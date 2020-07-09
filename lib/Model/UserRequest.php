<?php

declare(strict_types=1);

namespace Files\Model;

use Files\Api;
use Files\Logger;

require_once __DIR__ . '/../Files.php';

/**
 * Class UserRequest
 *
 * @package Files
 */
class UserRequest {
  private $attributes = [];
  private $options = [];

  function __construct($attributes = [], $options = []) {
    foreach ($attributes as $key => $value) {
      $this->attributes[str_replace('?', '', $key)] = $value;
    }

    $this->options = $options;
  }

  public function __get($name) {
    return $this->attributes[$name];
  }

  public function isLoaded() {
    return !!$this->attributes['id'];
  }

  // string # User's full name
  public function getName() {
    return $this->attributes['name'];
  }

  public function setName($value) {
    return $this->attributes['name'] = $value;
  }

  // email # User email address
  public function getEmail() {
    return $this->attributes['email'];
  }

  public function setEmail($value) {
    return $this->attributes['email'] = $value;
  }

  // string # Details of the user's request
  public function getDetails() {
    return $this->attributes['details'];
  }

  public function setDetails($value) {
    return $this->attributes['details'] = $value;
  }

  public function delete($params = []) {
    if (!$this->id) {
      throw new \Error('Current object has no ID');
    }

    if (!is_array($params)) {
      throw new \InvalidArgumentException('Bad parameter: $params must be of type array; received ' . gettype($params));
    }

    $params['id'] = $this->id;

    if ($params['id'] && !is_int($params['id'])) {
      throw new \InvalidArgumentException('Bad parameter: $id must be of type int; received ' . gettype($id));
    }

    if (!$params['id']) {
      if ($this->id) {
        $params['id'] = $this->id;
      } else {
        throw new \Error('Parameter missing: id');
      }
    }

    return Api::sendRequest('/user_requests/' . $params['id'] . '', 'DELETE', $params, $this->options);
  }

  public function destroy($params = []) {
    return $this->delete($params);
  }

  public function save() {
    if ($this->attributes['id']) {
      throw new \BadMethodCallException('The UserRequest object doesn\'t support updates.');
    } else {
      $new_obj = self::create($this->attributes, $this->options);
      $this->attributes = $new_obj->attributes;
      return true;
    }
  }

  // Parameters:
  //   page - int64 - Current page number.
  //   per_page - int64 - Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
  //   action - string - Deprecated: If set to `count` returns a count of matching records rather than the records themselves.
  public static function list($params = [], $options = []) {
    if ($params['page'] && !is_int($params['page'])) {
      throw new \InvalidArgumentException('Bad parameter: $page must be of type int; received ' . gettype($page));
    }

    if ($params['per_page'] && !is_int($params['per_page'])) {
      throw new \InvalidArgumentException('Bad parameter: $per_page must be of type int; received ' . gettype($per_page));
    }

    if ($params['action'] && !is_string($params['action'])) {
      throw new \InvalidArgumentException('Bad parameter: $action must be of type string; received ' . gettype($action));
    }

    $response = Api::sendRequest('/user_requests', 'GET', $params, $options);

    $return_array = [];

    foreach ($response->data as $obj) {
      $return_array[] = new UserRequest((array)$obj, $options);
    }

    return $return_array;
  }

  public static function all($params = [], $options = []) {
    return self::list($params, $options);
  }

  // Parameters:
  //   id (required) - int64 - User Request ID.
  public static function find($id, $params = [], $options = []) {
    if (!is_array($params)) {
      throw new \InvalidArgumentException('Bad parameter: $params must be of type array; received ' . gettype($params));
    }

    $params['id'] = $id;

    if (!$params['id']) {
      throw new \Error('Parameter missing: id');
    }

    if ($params['id'] && !is_int($params['id'])) {
      throw new \InvalidArgumentException('Bad parameter: $id must be of type int; received ' . gettype($id));
    }

    $response = Api::sendRequest('/user_requests/' . $params['id'] . '', 'GET', $params, $options);

    return new UserRequest((array)$response->data, $options);
  }

  public static function get($id, $params = [], $options = []) {
    return self::find($id, $params, $options);
  }

  // Parameters:
  //   name (required) - string - Name of user requested
  //   email (required) - string - Email of user requested
  //   details (required) - string - Details of the user request
  public static function create($params = [], $options = []) {
    if (!$params['name']) {
      throw new \Error('Parameter missing: name');
    }

    if (!$params['email']) {
      throw new \Error('Parameter missing: email');
    }

    if (!$params['details']) {
      throw new \Error('Parameter missing: details');
    }

    if ($params['name'] && !is_string($params['name'])) {
      throw new \InvalidArgumentException('Bad parameter: $name must be of type string; received ' . gettype($name));
    }

    if ($params['email'] && !is_string($params['email'])) {
      throw new \InvalidArgumentException('Bad parameter: $email must be of type string; received ' . gettype($email));
    }

    if ($params['details'] && !is_string($params['details'])) {
      throw new \InvalidArgumentException('Bad parameter: $details must be of type string; received ' . gettype($details));
    }

    $response = Api::sendRequest('/user_requests', 'POST', $params, $options);

    return new UserRequest((array)$response->data, $options);
  }
}