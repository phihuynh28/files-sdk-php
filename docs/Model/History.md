# History

## Example History Object

```
{
  "id": 1,
  "path": "",
  "when": "2000-01-01T01:00:00Z",
  "destination": "/to_path",
  "display": "Actual text of the action here.",
  "ip": "192.283.128.182",
  "source": "/from_path",
  "targets": [

  ],
  "user_id": 1,
  "username": "user",
  "action": "create",
  "failure_type": "none",
  "interface": "web"
}
```

* `id` (int64): Action ID
* `path` (string): Path This must be slash-delimited, but it must neither start nor end with a slash. Maximum of 5000 characters.
* `when` (date-time): Action occurrence date/time
* `destination` (string): The destination path for this action, if applicable
* `display` (string): Friendly displayed output
* `ip` (string): IP Address that performed this action
* `source` (string): The source path for this action, if applicable
* `targets` (array): Targets
* `user_id` (int64): User ID
* `username` (string): Username
* `action` (string): Type of action
* `failure_type` (string): Failure type.  If action was a user login or session failure, why did it fail?
* `interface` (string): Interface on which this action occurred.

---

## List history for specific file

```
$history = new \Files\Model\History();
$history->listForFile($path, [
  'display' => "Actual text of the action here.",
  'per_page' => 1,
]);
```


### Parameters

* `start_at` (string): Leave blank or set to a date/time to filter earlier entries.
* `end_at` (string): Leave blank or set to a date/time to filter later entries.
* `display` (string): Display format. Leave blank or set to `full` or `parent`.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `user_id` and `created_at`.
* `path` (string): Required - Path to operate on.

---

## List history for specific folder

```
$history = new \Files\Model\History();
$history->listForFolder($path, [
  'display' => "Actual text of the action here.",
  'per_page' => 1,
]);
```


### Parameters

* `start_at` (string): Leave blank or set to a date/time to filter earlier entries.
* `end_at` (string): Leave blank or set to a date/time to filter later entries.
* `display` (string): Display format. Leave blank or set to `full` or `parent`.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `user_id` and `created_at`.
* `path` (string): Required - Path to operate on.

---

## List history for specific user

```
$history = new \Files\Model\History();
$history->listForUser($user_id, [
  'display' => "Actual text of the action here.",
  'per_page' => 1,
]);
```


### Parameters

* `start_at` (string): Leave blank or set to a date/time to filter earlier entries.
* `end_at` (string): Leave blank or set to a date/time to filter later entries.
* `display` (string): Display format. Leave blank or set to `full` or `parent`.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `user_id` and `created_at`.
* `user_id` (int64): Required - User ID.

---

## List site login history

```
$history = new \Files\Model\History();
$history->listLogins(, [
  'display' => "Actual text of the action here.",
  'per_page' => 1,
]);
```


### Parameters

* `start_at` (string): Leave blank or set to a date/time to filter earlier entries.
* `end_at` (string): Leave blank or set to a date/time to filter later entries.
* `display` (string): Display format. Leave blank or set to `full` or `parent`.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `user_id` and `created_at`.

---

## List site full action history

```
$history = new \Files\Model\History();
$history->list(, [
  'display' => "Actual text of the action here.",
  'per_page' => 1,
]);
```


### Parameters

* `start_at` (string): Leave blank or set to a date/time to filter earlier entries.
* `end_at` (string): Leave blank or set to a date/time to filter later entries.
* `display` (string): Display format. Leave blank or set to `full` or `parent`.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `path`, `folder`, `user_id` or `created_at`.
* `filter` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `user_id`, `folder` or `path`.
* `filter_gt` (object): If set, return records where the specified field is greater than the supplied value. Valid fields are `user_id`, `folder` or `path`.
* `filter_gteq` (object): If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `user_id`, `folder` or `path`.
* `filter_like` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `user_id`, `folder` or `path`.
* `filter_lt` (object): If set, return records where the specified field is less than the supplied value. Valid fields are `user_id`, `folder` or `path`.
* `filter_lteq` (object): If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `user_id`, `folder` or `path`.
