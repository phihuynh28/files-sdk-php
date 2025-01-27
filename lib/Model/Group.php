<?php

declare(strict_types=1);

namespace Files\Model;

use Files\Api;
use Files\Logger;

require_once __DIR__ . '/../Files.php';

/**
 * Class Group
 *
 * @package Files
 */
class Group {
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

  // int64 # Group ID
  public function getId() {
    return @$this->attributes['id'];
  }

  public function setId($value) {
    return $this->attributes['id'] = $value;
  }

  // string # Group name
  public function getName() {
    return @$this->attributes['name'];
  }

  public function setName($value) {
    return $this->attributes['name'] = $value;
  }

  // string # List of user IDs who are group administrators (separated by commas)
  public function getAdminIds() {
    return @$this->attributes['admin_ids'];
  }

  public function setAdminIds($value) {
    return $this->attributes['admin_ids'] = $value;
  }

  // string # Notes about this group
  public function getNotes() {
    return @$this->attributes['notes'];
  }

  public function setNotes($value) {
    return $this->attributes['notes'] = $value;
  }

  // array # List of user IDs who belong to this group (separated by commas)
  public function getUserIds() {
    return @$this->attributes['user_ids'];
  }

  public function setUserIds($value) {
    return $this->attributes['user_ids'] = $value;
  }

  // array # List of usernames who belong to this group (separated by commas)
  public function getUsernames() {
    return @$this->attributes['usernames'];
  }

  public function setUsernames($value) {
    return $this->attributes['usernames'] = $value;
  }

  // Parameters:
  //   name - string - Group name.
  //   notes - string - Group notes.
  //   user_ids - string - A list of user ids. If sent as a string, should be comma-delimited.
  //   admin_ids - string - A list of group admin user ids. If sent as a string, should be comma-delimited.
  public function update($params = []) {
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

    if (@$params['name'] && !is_string(@$params['name'])) {
      throw new \Files\InvalidParameterException('$name must be of type string; received ' . gettype($name));
    }

    if (@$params['notes'] && !is_string(@$params['notes'])) {
      throw new \Files\InvalidParameterException('$notes must be of type string; received ' . gettype($notes));
    }

    if (@$params['user_ids'] && !is_string(@$params['user_ids'])) {
      throw new \Files\InvalidParameterException('$user_ids must be of type string; received ' . gettype($user_ids));
    }

    if (@$params['admin_ids'] && !is_string(@$params['admin_ids'])) {
      throw new \Files\InvalidParameterException('$admin_ids must be of type string; received ' . gettype($admin_ids));
    }

    $response = Api::sendRequest('/groups/' . @$params['id'] . '', 'PATCH', $params, $this->options);
    return $response->data;
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

    $response = Api::sendRequest('/groups/' . @$params['id'] . '', 'DELETE', $params, $this->options);
    return $response->data;
  }

  public function destroy($params = []) {
    return $this->delete($params);
  }

  public function save() {
      if (@$this->attributes['id']) {
        return $this->update($this->attributes);
      } else {
        $new_obj = self::create($this->attributes, $this->options);
        $this->attributes = $new_obj->attributes;
        return true;
      }
  }

  // Parameters:
  //   cursor - string - Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
  //   per_page - int64 - Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
  //   sort_by - object - If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `name`.
  //   filter - object - If set, return records where the specified field is equal to the supplied value. Valid fields are `name`.
  //   filter_gt - object - If set, return records where the specified field is greater than the supplied value. Valid fields are `name`.
  //   filter_gteq - object - If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `name`.
  //   filter_like - object - If set, return records where the specified field is equal to the supplied value. Valid fields are `name`.
  //   filter_lt - object - If set, return records where the specified field is less than the supplied value. Valid fields are `name`.
  //   filter_lteq - object - If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `name`.
  //   ids - string - Comma-separated list of group ids to include in results.
  public static function list($params = [], $options = []) {
    if (@$params['cursor'] && !is_string(@$params['cursor'])) {
      throw new \Files\InvalidParameterException('$cursor must be of type string; received ' . gettype($cursor));
    }

    if (@$params['per_page'] && !is_int(@$params['per_page'])) {
      throw new \Files\InvalidParameterException('$per_page must be of type int; received ' . gettype($per_page));
    }

    if (@$params['ids'] && !is_string(@$params['ids'])) {
      throw new \Files\InvalidParameterException('$ids must be of type string; received ' . gettype($ids));
    }

    $response = Api::sendRequest('/groups', 'GET', $params, $options);

    $return_array = [];

    foreach ($response->data as $obj) {
      $return_array[] = new Group((array)$obj, $options);
    }

    return $return_array;
  }

  public static function all($params = [], $options = []) {
    return self::list($params, $options);
  }

  // Parameters:
  //   id (required) - int64 - Group ID.
  public static function find($id, $params = [], $options = []) {
    if (!is_array($params)) {
      throw new \Files\InvalidParameterException('$params must be of type array; received ' . gettype($params));
    }

    $params['id'] = $id;

    if (!@$params['id']) {
      throw new \Files\MissingParameterException('Parameter missing: id');
    }

    if (@$params['id'] && !is_int(@$params['id'])) {
      throw new \Files\InvalidParameterException('$id must be of type int; received ' . gettype($id));
    }

    $response = Api::sendRequest('/groups/' . @$params['id'] . '', 'GET', $params, $options);

    return new Group((array)(@$response->data ?: []), $options);
  }

  public static function get($id, $params = [], $options = []) {
    return self::find($id, $params, $options);
  }

  // Parameters:
  //   name - string - Group name.
  //   notes - string - Group notes.
  //   user_ids - string - A list of user ids. If sent as a string, should be comma-delimited.
  //   admin_ids - string - A list of group admin user ids. If sent as a string, should be comma-delimited.
  public static function create($params = [], $options = []) {
    if (@$params['name'] && !is_string(@$params['name'])) {
      throw new \Files\InvalidParameterException('$name must be of type string; received ' . gettype($name));
    }

    if (@$params['notes'] && !is_string(@$params['notes'])) {
      throw new \Files\InvalidParameterException('$notes must be of type string; received ' . gettype($notes));
    }

    if (@$params['user_ids'] && !is_string(@$params['user_ids'])) {
      throw new \Files\InvalidParameterException('$user_ids must be of type string; received ' . gettype($user_ids));
    }

    if (@$params['admin_ids'] && !is_string(@$params['admin_ids'])) {
      throw new \Files\InvalidParameterException('$admin_ids must be of type string; received ' . gettype($admin_ids));
    }

    $response = Api::sendRequest('/groups', 'POST', $params, $options);

    return new Group((array)(@$response->data ?: []), $options);
  }
}
