# ExternalEvent

## Example ExternalEvent Object

```
{
  "id": 1,
  "event_type": "",
  "status": "",
  "body": "",
  "created_at": "2000-01-01T01:00:00Z",
  "body_url": "",
  "folder_behavior_id": 1,
  "successful_files": 1,
  "errored_files": 1,
  "bytes_synced": 1,
  "remote_server_type": ""
}
```

* `id` (int64): Event ID
* `event_type` (string): Type of event being recorded.
* `status` (string): Status of event.
* `body` (string): Event body
* `created_at` (date-time): External event create date/time
* `body_url` (string): Link to log file.
* `folder_behavior_id` (int64): Folder Behavior ID
* `successful_files` (int64): For sync events, the number of files handled successfully.
* `errored_files` (int64): For sync events, the number of files that encountered errors.
* `bytes_synced` (int64): For sync events, the total number of bytes synced.
* `remote_server_type` (string): Associated Remote Server type, if any

---

## List External Events

```
$external_event = new \Files\Model\ExternalEvent();
$external_event->list(, [
  'per_page' => 1,
]);
```


### Parameters

* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `remote_server_type`, `site_id`, `folder_behavior_id`, `event_type`, `created_at` or `status`.
* `filter` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `created_at`, `event_type`, `remote_server_type`, `status` or `folder_behavior_id`. Valid field combinations are `[ event_type, status, created_at ]`, `[ event_type, created_at ]` or `[ status, created_at ]`.
* `filter_gt` (object): If set, return records where the specified field is greater than the supplied value. Valid fields are `created_at`, `event_type`, `remote_server_type`, `status` or `folder_behavior_id`. Valid field combinations are `[ event_type, status, created_at ]`, `[ event_type, created_at ]` or `[ status, created_at ]`.
* `filter_gteq` (object): If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `created_at`, `event_type`, `remote_server_type`, `status` or `folder_behavior_id`. Valid field combinations are `[ event_type, status, created_at ]`, `[ event_type, created_at ]` or `[ status, created_at ]`.
* `filter_like` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `created_at`, `event_type`, `remote_server_type`, `status` or `folder_behavior_id`. Valid field combinations are `[ event_type, status, created_at ]`, `[ event_type, created_at ]` or `[ status, created_at ]`.
* `filter_lt` (object): If set, return records where the specified field is less than the supplied value. Valid fields are `created_at`, `event_type`, `remote_server_type`, `status` or `folder_behavior_id`. Valid field combinations are `[ event_type, status, created_at ]`, `[ event_type, created_at ]` or `[ status, created_at ]`.
* `filter_lteq` (object): If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `created_at`, `event_type`, `remote_server_type`, `status` or `folder_behavior_id`. Valid field combinations are `[ event_type, status, created_at ]`, `[ event_type, created_at ]` or `[ status, created_at ]`.

---

## Show External Event

```
$external_event = new \Files\Model\ExternalEvent();
$external_event->find($id);
```


### Parameters

* `id` (int64): Required - External Event ID.

---

## Create External Event

```
$external_event = new \Files\Model\ExternalEvent();
$external_event->create(, [
  'status' => "status",
  'body' => "body",
]);
```


### Parameters

* `status` (string): Required - Status of event.
* `body` (string): Required - Event body
