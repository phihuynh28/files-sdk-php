<?php

declare(strict_types=1);

namespace Files\Model;

use Files\Api;
use Files\Logger;

require_once __DIR__ . '/../Files.php';

/**
 * Class Folder
 *
 * @package Files
 */
class Folder {
  private $attributes = [];
  private $options = [];

  function __construct($attributes = [], $options = []) {
    foreach ($attributes as $key => $value) {
      $this->attributes[str_replace('?', '', $key)] = $value;
    }

    $this->options = $options;
  }

  public function __set($name, $value) {
    $this->attributes[$name] = $value;
  }

  public function __get($name) {
    return @$this->attributes[$name];
  }

  public function isLoaded() {
    return !!@$this->attributes['path'];
  }

  // string # File/Folder path This must be slash-delimited, but it must neither start nor end with a slash. Maximum of 5000 characters.
  public function getPath() {
    return @$this->attributes['path'];
  }

  public function setPath($value) {
    return $this->attributes['path'] = $value;
  }

  // string # File/Folder display name
  public function getDisplayName() {
    return @$this->attributes['display_name'];
  }

  public function setDisplayName($value) {
    return $this->attributes['display_name'] = $value;
  }

  // string # Type: `directory` or `file`.
  public function getType() {
    return @$this->attributes['type'];
  }

  public function setType($value) {
    return $this->attributes['type'] = $value;
  }

  // int64 # File/Folder size
  public function getSize() {
    return @$this->attributes['size'];
  }

  public function setSize($value) {
    return $this->attributes['size'] = $value;
  }

  // date-time # File last modified date/time, according to the server.  This is the timestamp of the last Files.com operation of the file, regardless of what modified timestamp was sent.
  public function getMtime() {
    return @$this->attributes['mtime'];
  }

  public function setMtime($value) {
    return $this->attributes['mtime'] = $value;
  }

  // date-time # File last modified date/time, according to the client who set it.  Files.com allows desktop, FTP, SFTP, and WebDAV clients to set modified at times.  This allows Desktop<->Cloud syncing to preserve modified at times.
  public function getProvidedMtime() {
    return @$this->attributes['provided_mtime'];
  }

  public function setProvidedMtime($value) {
    return $this->attributes['provided_mtime'] = $value;
  }

  // string # File CRC32 checksum. This is sometimes delayed, so if you get a blank response, wait and try again.
  public function getCrc32() {
    return @$this->attributes['crc32'];
  }

  public function setCrc32($value) {
    return $this->attributes['crc32'] = $value;
  }

  // string # File MD5 checksum. This is sometimes delayed, so if you get a blank response, wait and try again.
  public function getMd5() {
    return @$this->attributes['md5'];
  }

  public function setMd5($value) {
    return $this->attributes['md5'] = $value;
  }

  // string # MIME Type.  This is determined by the filename extension and is not stored separately internally.
  public function getMimeType() {
    return @$this->attributes['mime_type'];
  }

  public function setMimeType($value) {
    return $this->attributes['mime_type'] = $value;
  }

  // string # Region location
  public function getRegion() {
    return @$this->attributes['region'];
  }

  public function setRegion($value) {
    return $this->attributes['region'] = $value;
  }

  // string # A short string representing the current user's permissions.  Can be `r`,`w`,`d`, `l` or any combination
  public function getPermissions() {
    return @$this->attributes['permissions'];
  }

  public function setPermissions($value) {
    return $this->attributes['permissions'] = $value;
  }

  // boolean # Are subfolders locked and unable to be modified?
  public function getSubfoldersLocked() {
    return @$this->attributes['subfolders_locked'];
  }

  public function setSubfoldersLocked($value) {
    return $this->attributes['subfolders_locked'] = $value;
  }

  // string # Link to download file. Provided only in response to a download request.
  public function getDownloadUri() {
    return @$this->attributes['download_uri'];
  }

  public function setDownloadUri($value) {
    return $this->attributes['download_uri'] = $value;
  }

  // string # Bookmark/priority color of file/folder
  public function getPriorityColor() {
    return @$this->attributes['priority_color'];
  }

  public function setPriorityColor($value) {
    return $this->attributes['priority_color'] = $value;
  }

  // int64 # File preview ID
  public function getPreviewId() {
    return @$this->attributes['preview_id'];
  }

  public function setPreviewId($value) {
    return $this->attributes['preview_id'] = $value;
  }

  // Preview # File preview
  public function getPreview() {
    return @$this->attributes['preview'];
  }

  public function setPreview($value) {
    return $this->attributes['preview'] = $value;
  }

  // boolean # Create parent directories if they do not exist?
  public function getMkdirParents() {
    return @$this->attributes['mkdir_parents'];
  }

  public function setMkdirParents($value) {
    return $this->attributes['mkdir_parents'] = $value;
  }

  public function save() {
      $new_obj = self::create($this->path, $this->attributes, $this->options);
      $this->attributes = $new_obj->attributes;
      return true;
  }

  // Parameters:
  //   cursor - string - Send cursor to resume an existing list from the point at which you left off.  Get a cursor from an existing list via the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
  //   per_page - int64 - Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
  //   path (required) - string - Path to operate on.
  //   filter - string - If specified, will filter folders/files list by this string.  Wildcards of `*` and `?` are acceptable here.
  //   preview_size - string - Request a preview size.  Can be `small` (default), `large`, `xlarge`, or `pdf`.
  //   search - string - If `search_all` is `true`, provide the search string here.  Otherwise, this parameter acts like an alias of `filter`.
  //   search_all - boolean - Search entire site?  If set, we will ignore the folder path provided and search the entire site.  This is the same API used by the search bar in the UI.  Search results are a best effort, not real time, and not guaranteed to match every file.  This field should only be used for ad-hoc (human) searching, and not as part of an automated process.
  //   with_previews - boolean - Include file previews?
  //   with_priority_color - boolean - Include file priority color information?
  public static function listFor($path, $params = [], $options = []) {
    if (!is_array($params)) {
      throw new \Files\InvalidParameterException('$params must be of type array; received ' . gettype($params));
    }

    $params['path'] = $path;

    if (!@$params['path']) {
      throw new \Files\MissingParameterException('Parameter missing: path');
    }

    if (@$params['cursor'] && !is_string(@$params['cursor'])) {
      throw new \Files\InvalidParameterException('$cursor must be of type string; received ' . gettype($cursor));
    }

    if (@$params['per_page'] && !is_int(@$params['per_page'])) {
      throw new \Files\InvalidParameterException('$per_page must be of type int; received ' . gettype($per_page));
    }

    if (@$params['path'] && !is_string(@$params['path'])) {
      throw new \Files\InvalidParameterException('$path must be of type string; received ' . gettype($path));
    }

    if (@$params['filter'] && !is_string(@$params['filter'])) {
      throw new \Files\InvalidParameterException('$filter must be of type string; received ' . gettype($filter));
    }

    if (@$params['preview_size'] && !is_string(@$params['preview_size'])) {
      throw new \Files\InvalidParameterException('$preview_size must be of type string; received ' . gettype($preview_size));
    }

    if (@$params['search'] && !is_string(@$params['search'])) {
      throw new \Files\InvalidParameterException('$search must be of type string; received ' . gettype($search));
    }

    $response = Api::sendRequest('/folders/' . @$params['path'] . '', 'GET', $params, $options);

    $return_array = [];

    foreach ($response->data as $obj) {
      $return_array[] = new File((array)$obj, $options);
    }

    return $return_array;
  }

  // Parameters:
  //   path (required) - string - Path to operate on.
  //   mkdir_parents - boolean - Create parent directories if they do not exist?
  public static function create($path, $params = [], $options = []) {
    if (!is_array($params)) {
      throw new \Files\InvalidParameterException('$params must be of type array; received ' . gettype($params));
    }

    $params['path'] = $path;

    if (!@$params['path']) {
      throw new \Files\MissingParameterException('Parameter missing: path');
    }

    if (@$params['path'] && !is_string(@$params['path'])) {
      throw new \Files\InvalidParameterException('$path must be of type string; received ' . gettype($path));
    }

    $response = Api::sendRequest('/folders/' . @$params['path'] . '', 'POST', $params, $options);

    return new File((array)(@$response->data ?: []), $options);
  }
}
