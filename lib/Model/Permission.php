<?php

declare(strict_types=1);

namespace Files\Model;

use Files\Api;
use Files\Logger;

require_once __DIR__ . '/../Files.php';

/**
 * Class Permission
 *
 * @package Files
 */
class Permission {
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
    return !!@$this->attributes['id'];
  }

  // int64 # Permission ID
  public function getId() {
    return @$this->attributes['id'];
  }

  public function setId($value) {
    return $this->attributes['id'] = $value;
  }

  // string # Folder path This must be slash-delimited, but it must neither start nor end with a slash. Maximum of 5000 characters.
  public function getPath() {
    return @$this->attributes['path'];
  }

  public function setPath($value) {
    return $this->attributes['path'] = $value;
  }

  // int64 # User ID
  public function getUserId() {
    return @$this->attributes['user_id'];
  }

  public function setUserId($value) {
    return $this->attributes['user_id'] = $value;
  }

  // string # User's username
  public function getUsername() {
    return @$this->attributes['username'];
  }

  public function setUsername($value) {
    return $this->attributes['username'] = $value;
  }

  // int64 # Group ID
  public function getGroupId() {
    return @$this->attributes['group_id'];
  }

  public function setGroupId($value) {
    return $this->attributes['group_id'] = $value;
  }

  // string # Group name if applicable
  public function getGroupName() {
    return @$this->attributes['group_name'];
  }

  public function setGroupName($value) {
    return $this->attributes['group_name'] = $value;
  }

  // string # Permission type
  public function getPermission() {
    return @$this->attributes['permission'];
  }

  public function setPermission($value) {
    return $this->attributes['permission'] = $value;
  }

  // boolean # Does this permission apply to subfolders?
  public function getRecursive() {
    return @$this->attributes['recursive'];
  }

  public function setRecursive($value) {
    return $this->attributes['recursive'] = $value;
  }

  public function delete($params = []) {
    if (!is_array($params)) {
      throw new \Files\InvalidParameterException('$params must be of type array; received ' . gettype($params));
    }

    if (!@$params['id']) {
      if (@$this->id) {
        $params['id'] = $this->id;
      } else {
        throw new \Files\MissingParameterException('Parameter missing: id');
      }
    }

    if (@$params['id'] && !is_int(@$params['id'])) {
      throw new \Files\InvalidParameterException('$id must be of type int; received ' . gettype($id));
    }

    $response = Api::sendRequest('/permissions/' . @$params['id'] . '', 'DELETE', $params, $this->options);
    return $response->data;
  }

  public function destroy($params = []) {
    return $this->delete($params);
  }

  public function save() {
      if (@$this->attributes['id']) {
        throw new \Files\NotImplementedException('The Permission object doesn\'t support updates.');
      } else {
        $new_obj = self::create($this->attributes, $this->options);
        $this->attributes = $new_obj->attributes;
        return true;
      }
  }

  // Parameters:
  //   cursor - string - Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
  //   per_page - int64 - Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
  //   sort_by - object - If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `group_id`, `path`, `user_id` or `permission`.
  //   filter - object - If set, return records where the specified field is equal to the supplied value. Valid fields are `group_id`, `user_id` or `path`. Valid field combinations are `[ group_id, path ]` and `[ user_id, path ]`.
  //   filter_gt - object - If set, return records where the specified field is greater than the supplied value. Valid fields are `group_id`, `user_id` or `path`. Valid field combinations are `[ group_id, path ]` and `[ user_id, path ]`.
  //   filter_gteq - object - If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `group_id`, `user_id` or `path`. Valid field combinations are `[ group_id, path ]` and `[ user_id, path ]`.
  //   filter_like - object - If set, return records where the specified field is equal to the supplied value. Valid fields are `group_id`, `user_id` or `path`. Valid field combinations are `[ group_id, path ]` and `[ user_id, path ]`.
  //   filter_lt - object - If set, return records where the specified field is less than the supplied value. Valid fields are `group_id`, `user_id` or `path`. Valid field combinations are `[ group_id, path ]` and `[ user_id, path ]`.
  //   filter_lteq - object - If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `group_id`, `user_id` or `path`. Valid field combinations are `[ group_id, path ]` and `[ user_id, path ]`.
  //   path - string - DEPRECATED: Permission path.  If provided, will scope permissions to this path. Use `filter[path]` instead.
  //   group_id - string - DEPRECATED: Group ID.  If provided, will scope permissions to this group. Use `filter[group_id]` instead.`
  //   user_id - string - DEPRECATED: User ID.  If provided, will scope permissions to this user. Use `filter[user_id]` instead.`
  //   include_groups - boolean - If searching by user or group, also include user's permissions that are inherited from its groups?
  public static function list($params = [], $options = []) {
    if (@$params['cursor'] && !is_string(@$params['cursor'])) {
      throw new \Files\InvalidParameterException('$cursor must be of type string; received ' . gettype($cursor));
    }

    if (@$params['per_page'] && !is_int(@$params['per_page'])) {
      throw new \Files\InvalidParameterException('$per_page must be of type int; received ' . gettype($per_page));
    }

    if (@$params['path'] && !is_string(@$params['path'])) {
      throw new \Files\InvalidParameterException('$path must be of type string; received ' . gettype($path));
    }

    if (@$params['group_id'] && !is_string(@$params['group_id'])) {
      throw new \Files\InvalidParameterException('$group_id must be of type string; received ' . gettype($group_id));
    }

    if (@$params['user_id'] && !is_string(@$params['user_id'])) {
      throw new \Files\InvalidParameterException('$user_id must be of type string; received ' . gettype($user_id));
    }

    $response = Api::sendRequest('/permissions', 'GET', $params, $options);

    $return_array = [];

    foreach ($response->data as $obj) {
      $return_array[] = new Permission((array)$obj, $options);
    }

    return $return_array;
  }

  public static function all($params = [], $options = []) {
    return self::list($params, $options);
  }

  // Parameters:
  //   group_id - int64 - Group ID
  //   path - string - Folder path
  //   permission - string -  Permission type.  Can be `admin`, `full`, `readonly`, `writeonly`, `list`, or `history`
  //   recursive - boolean - Apply to subfolders recursively?
  //   user_id - int64 - User ID.  Provide `username` or `user_id`
  //   username - string - User username.  Provide `username` or `user_id`
  public static function create($params = [], $options = []) {
    if (@$params['group_id'] && !is_int(@$params['group_id'])) {
      throw new \Files\InvalidParameterException('$group_id must be of type int; received ' . gettype($group_id));
    }

    if (@$params['path'] && !is_string(@$params['path'])) {
      throw new \Files\InvalidParameterException('$path must be of type string; received ' . gettype($path));
    }

    if (@$params['permission'] && !is_string(@$params['permission'])) {
      throw new \Files\InvalidParameterException('$permission must be of type string; received ' . gettype($permission));
    }

    if (@$params['user_id'] && !is_int(@$params['user_id'])) {
      throw new \Files\InvalidParameterException('$user_id must be of type int; received ' . gettype($user_id));
    }

    if (@$params['username'] && !is_string(@$params['username'])) {
      throw new \Files\InvalidParameterException('$username must be of type string; received ' . gettype($username));
    }

    $response = Api::sendRequest('/permissions', 'POST', $params, $options);

    return new Permission((array)(@$response->data ?: []), $options);
  }
}
