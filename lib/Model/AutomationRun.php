<?php

declare(strict_types=1);

namespace Files\Model;

use Files\Api;
use Files\Logger;

require_once __DIR__ . '/../Files.php';

/**
 * Class AutomationRun
 *
 * @package Files
 */
class AutomationRun {
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

  // int64 # ID.
  public function getId() {
    return @$this->attributes['id'];
  }

  // int64 # ID of the associated Automation.
  public function getAutomationId() {
    return @$this->attributes['automation_id'];
  }

  // date-time # Automation run completion/failure date/time.
  public function getCompletedAt() {
    return @$this->attributes['completed_at'];
  }

  // date-time # Automation run start date/time.
  public function getCreatedAt() {
    return @$this->attributes['created_at'];
  }

  // string # The success status of the AutomationRun. One of `running`, `success`, `partial_failure`, or `failure`.
  public function getStatus() {
    return @$this->attributes['status'];
  }

  // string # Link to status messages log file.
  public function getStatusMessagesUrl() {
    return @$this->attributes['status_messages_url'];
  }

  // Parameters:
  //   user_id - int64 - User ID.  Provide a value of `0` to operate the current session's user.
  //   cursor - string - Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
  //   per_page - int64 - Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
  //   sort_by - object - If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `created_at` and `status`.
  //   filter - object - If set, return records where the specified field is equal to the supplied value. Valid fields are `status`.
  //   filter_gt - object - If set, return records where the specified field is greater than the supplied value. Valid fields are `status`.
  //   filter_gteq - object - If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `status`.
  //   filter_like - object - If set, return records where the specified field is equal to the supplied value. Valid fields are `status`.
  //   filter_lt - object - If set, return records where the specified field is less than the supplied value. Valid fields are `status`.
  //   filter_lteq - object - If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `status`.
  //   automation_id (required) - int64 - ID of the associated Automation.
  public static function list($params = [], $options = []) {
    if (!@$params['automation_id']) {
      throw new \Files\MissingParameterException('Parameter missing: automation_id');
    }

    if (@$params['user_id'] && !is_int(@$params['user_id'])) {
      throw new \Files\InvalidParameterException('$user_id must be of type int; received ' . gettype($user_id));
    }

    if (@$params['cursor'] && !is_string(@$params['cursor'])) {
      throw new \Files\InvalidParameterException('$cursor must be of type string; received ' . gettype($cursor));
    }

    if (@$params['per_page'] && !is_int(@$params['per_page'])) {
      throw new \Files\InvalidParameterException('$per_page must be of type int; received ' . gettype($per_page));
    }

    if (@$params['automation_id'] && !is_int(@$params['automation_id'])) {
      throw new \Files\InvalidParameterException('$automation_id must be of type int; received ' . gettype($automation_id));
    }

    $response = Api::sendRequest('/automation_runs', 'GET', $params, $options);

    $return_array = [];

    foreach ($response->data as $obj) {
      $return_array[] = new AutomationRun((array)$obj, $options);
    }

    return $return_array;
  }

  public static function all($params = [], $options = []) {
    return self::list($params, $options);
  }

  // Parameters:
  //   id (required) - int64 - Automation Run ID.
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

    $response = Api::sendRequest('/automation_runs/' . @$params['id'] . '', 'GET', $params, $options);

    return new AutomationRun((array)(@$response->data ?: []), $options);
  }

  public static function get($id, $params = [], $options = []) {
    return self::find($id, $params, $options);
  }
}
