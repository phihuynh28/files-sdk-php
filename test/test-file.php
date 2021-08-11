<?php

declare(strict_types=1);

namespace Files;

use Files\Model\ApiKey;
use Files\Model\File;
use Files\Model\Folder;
use Files\Model\Session;
use Files\Model\User;

require dirname(__FILE__) . '/../lib/Files.php';

// name of an existing folder in your root to create/delete test files and folders
define('SDK_TEST_ROOT_FOLDER', 'sdk-test');

$api_key = getenv('FILES_API_KEY');
$api_domain = getenv('FILES_API_DOMAIN');

if (!$api_key) {
  trigger_error('ENV variable "FILES_API_KEY" was not found', E_USER_ERROR);
  exit;
}

if (!$api_domain) {
  trigger_error('ENV variable "FILES_API_DOMAIN" was not found', E_USER_ERROR);
  exit;
}

//
// initialize
//

Files::setApiKey($api_key);
Files::setBaseUrl('https://' . $api_domain);

//
// utilities
//

function assertUserCreatedAndDelete($user, $name) {
  assert($user->isLoaded() === true);

  $saved_user = User::find($user->id);

  assert($saved_user->isLoaded() === true);
  assert($saved_user->name === $name);

  $saved_user->delete();

  $userNoLongerExists = false;

  try {
    User::find($user->id);
  } catch (NotFoundException $error) {
    $userNoLongerExists = true;
  }

  assert($userNoLongerExists === true);
}

function findFile($targetFile, $fileList) {
  $matches = array_filter($fileList, function($element) use ($targetFile) { return $element->path === $targetFile->path; });
  return $matches ? current($matches) : new File();
}

function createTestFolder() {
  $rootDir = constant('SDK_TEST_ROOT_FOLDER');
  $dirName = '/created-folder_' . date('Ymd-His');
  $path = $rootDir . $dirName;

  $folder = Folder::create($path);

  $folder->setPath($path);

  return [
    $rootDir,
    $dirName,
    $folder,
  ];
}

function createTestFile() {
  $rootDir = constant('SDK_TEST_ROOT_FOLDER');
  $dirName = '/created-file_' . date('Ymd-His');

  $folder = Folder::create($rootDir . $dirName);

  return [
    $rootDir,
    $dirName,
    $folder,
  ];
}

//
// define tests
//

function testErrors() {
  global $api_key;
  global $api_domain;

  //
  // invalid configuration
  //

  Files::setApiKey(null);
  Files::setBaseUrl(null);

  $caughtExpectedException = false;

  try {
    User::all();
  } catch (ConfigurationException $error) {
    $caughtExpectedException = true;
  }

  assert($caughtExpectedException === true);

  Files::setApiKey($api_key);
  Files::setBaseUrl('https://' . $api_domain);

  //
  // deleting a folder with no path specified
  //

  $nonExistentFile = new File();

  $caughtExpectedException = false;

  try {
    $nonExistentFile->delete();
  } catch (EmptyPropertyException $error) {
    $caughtExpectedException = true;
  }

  assert($caughtExpectedException === true);

  //
  // deleting a non-existent path
  //

  $nonExistentFile->path = '_fake_path_so_this_should_404_';

  $caughtExpectedException = false;

  try {
    $nonExistentFile->delete();
  } catch (NotFoundException $error) {
    $caughtExpectedException = true;
  }

  assert($caughtExpectedException === true);

  //
  // create the root folder path
  //

  $caughtExpectedException = false;

  try {
    $folder = Folder::create('.');
  } catch (ProcessingFailure\DestinationExistsException $error) {
    $caughtExpectedException = true;
  }

  assert($caughtExpectedException === true);

  Logger::info('***** testErrors() succeeded! *****');
}

function testUserListAndUpdate() {
  $all_users = User::all();
  $first_user = $all_users[0];

  $old_name = $first_user->name;
  $new_name = 'edited name - ' . date('Y-m-d H:i:s');

  $first_user->setName($new_name);
  $first_user->save();

  $updated_user = User::find($first_user->id);

  assert($updated_user->isLoaded());
  assert($old_name !== $new_name);
  assert($updated_user->name === $new_name);

  Logger::info('***** testUserListAndUpdate() succeeded! *****');
}

function testUserCreateAndDelete() {
  $name = 'created-user_' . date('Ymd-His');

  $user = new User([
    'name' => $name,
    'username' => $name,
  ]);

  $user->save();

  assertUserCreatedAndDelete($user, $name);

  Logger::info('***** testUserCreateAndDelete() succeeded! *****');
}

function testUserStaticCreateAndDelete() {
  $name = 'created-user_' . date('Ymd-His');

  $user = User::create([
    'name' => $name,
    'username' => $name,
  ]);

  assertUserCreatedAndDelete($user, $name);

  Logger::info('***** testUserStaticCreateAndDelete() succeeded! *****');
}

function testFolderCreateListAndDelete() {
  list($rootDir, $dirName, $testFolder) = createTestFolder();

  $dirFiles = Folder::listFor($rootDir);

  $foundFolder = findFile($testFolder, $dirFiles);
  assert($foundFolder->isLoaded() === true);

  $result = $foundFolder->delete();
  assert($result->status >= 200 && $result->status < 300);

  Logger::info('***** testFolderCreateListAndDelete() succeeded! *****');
}

function testFileUploadFindCopyAndDelete() {
  list($rootDir, $dirName, $testFolder) = createTestFolder();

  $tempName = 'upload-' . date('Ymd_His') . '.txt';
  $tempPath = tempnam(sys_get_temp_dir(), $tempName);

  file_put_contents($tempPath, date('Y-m-d H:i:s'));

  Logger::debug('Uploading file at ' . $tempPath . ' which has contents:' . "\n" . substr(file_get_contents($tempPath), 0, 200));

  File::uploadFile($rootDir . $dirName . '/' . $tempName, $tempPath);
  File::uploadData($rootDir . $dirName . '/upload-data.txt', rand() . "\n" . date('Y-m-d H:i:s'));

  $foundFile = File::find($rootDir . $dirName . '/' . $tempName);
  assert($foundFile->isLoaded());

  $copyResponse = $foundFile->copyTo($rootDir . $dirName . '/copied-file.txt');
  assert($copyResponse->status >= 200 && $copyResponse->status < 300);

  $foundFile->delete();

  $fileNoLongerExists = false;

  try {
    File::find($rootDir . $dirName . '/' . $tempName);
  } catch (NotFoundException $error) {
    $fileNoLongerExists = true;
  }

  assert($fileNoLongerExists === true);

  $foundFile = File::find($rootDir . $dirName . '/upload-data.txt');
  assert($foundFile->isLoaded());

  $testFolder->delete(['recursive' => true]);

  unlink($tempPath);

  Logger::info('***** testFileUploadFindCopyAndDelete() succeeded! *****');
}

function testSession() {
  $username = getenv('FILES_SESSION_USERNAME');
  $password = getenv('FILES_SESSION_PASSWORD');

  if (!$username || !$password) {
    Logger::info('Bypassing testSession() - ENV variables "FILES_SESSION_USERNAME" and "FILES_SESSION_PASSWORD" are both required');
    return;
  }

  $session = Session::create(['username' => $username, 'password' => $password]);
  Files::setSessionId($session->id);

  assert(!!$session->id);

  ApiKey::list(['user_id' => 0]);

  $session::destroy();
  Files::setSessionId(null);

  Logger::info('***** testSession() succeeded! *****');
}

//
// run tests
//

assert_options(ASSERT_BAIL, 1);

testErrors();
testUserListAndUpdate();
testUserCreateAndDelete();
testUserStaticCreateAndDelete();
testFolderCreateListAndDelete();
testFileUploadFindCopyAndDelete();
testSession();
