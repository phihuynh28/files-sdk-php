# Notification

## Example Notification Object

```
{
  "id": 1,
  "path": "",
  "group_id": 1,
  "group_name": "",
  "triggering_group_ids": [
    1
  ],
  "triggering_user_ids": [
    1
  ],
  "trigger_by_share_recipients": true,
  "notify_user_actions": true,
  "notify_on_copy": true,
  "notify_on_delete": true,
  "notify_on_download": true,
  "notify_on_move": true,
  "notify_on_upload": true,
  "recursive": true,
  "send_interval": "fifteen_minutes",
  "message": "custom notification email message",
  "triggering_filenames": [
    "*.jpg",
    "notify_file.txt"
  ],
  "unsubscribed": true,
  "unsubscribed_reason": "",
  "user_id": 1,
  "username": "User",
  "suppressed_email": true
}
```

* `id` (int64): Notification ID
* `path` (string): Folder path to notify on This must be slash-delimited, but it must neither start nor end with a slash. Maximum of 5000 characters.
* `group_id` (int64): Notification group id
* `group_name` (string): Group name if applicable
* `triggering_group_ids` (int64): Only notify on actions made by a member of one of the specified groups
* `triggering_user_ids` (int64): Only notify on actions made one of the specified users
* `trigger_by_share_recipients` (boolean): Notify when actions are performed by a share recipient?
* `notify_user_actions` (boolean): Trigger notification on notification user actions?
* `notify_on_copy` (boolean): Triggers notification when copying files to this path
* `notify_on_delete` (boolean): Triggers notification when deleting files from this path
* `notify_on_download` (boolean): Triggers notification when downloading files from this path
* `notify_on_move` (boolean): Triggers notification when moving files to this path
* `notify_on_upload` (boolean): Triggers notification when uploading new files to this path
* `recursive` (boolean): Enable notifications for each subfolder in this path
* `send_interval` (string): The time interval that notifications are aggregated to
* `message` (string): Custom message to include in notification emails.
* `triggering_filenames` (array): Array of filenames (possibly with wildcards) to match for action path
* `unsubscribed` (boolean): Is the user unsubscribed from this notification?
* `unsubscribed_reason` (string): The reason that the user unsubscribed
* `user_id` (int64): Notification user ID
* `username` (string): Notification username
* `suppressed_email` (boolean): If true, it means that the recipient at this user's email address has manually unsubscribed from all emails, or had their email "hard bounce", which means that we are unable to send mail to this user's current email address. Notifications will resume if the user changes their email address.

---

## List Notifications

```
$notification = new \Files\Model\Notification();
$notification->list(, [
  'user_id' => 1,
  'per_page' => 1,
  'group_id' => 1,
  'include_ancestors' => true,
]);
```


### Parameters

* `user_id` (int64): DEPRECATED: Show notifications for this User ID. Use `filter[user_id]` instead.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `path`, `user_id` or `group_id`.
* `filter` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `user_id`, `group_id` or `path`.
* `filter_gt` (object): If set, return records where the specified field is greater than the supplied value. Valid fields are `user_id`, `group_id` or `path`.
* `filter_gteq` (object): If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `user_id`, `group_id` or `path`.
* `filter_like` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `user_id`, `group_id` or `path`.
* `filter_lt` (object): If set, return records where the specified field is less than the supplied value. Valid fields are `user_id`, `group_id` or `path`.
* `filter_lteq` (object): If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `user_id`, `group_id` or `path`.
* `group_id` (int64): DEPRECATED: Show notifications for this Group ID. Use `filter[group_id]` instead.
* `path` (string): Show notifications for this Path.
* `include_ancestors` (boolean): If `include_ancestors` is `true` and `path` is specified, include notifications for any parent paths. Ignored if `path` is not specified.

---

## Show Notification

```
$notification = new \Files\Model\Notification();
$notification->find($id);
```


### Parameters

* `id` (int64): Required - Notification ID.

---

## Create Notification

```
$notification = new \Files\Model\Notification();
$notification->create(, [
  'user_id' => 1,
  'notify_on_copy' => true,
  'notify_on_delete' => true,
  'notify_on_download' => true,
  'notify_on_move' => true,
  'notify_on_upload' => true,
  'notify_user_actions' => true,
  'recursive' => true,
  'send_interval' => "daily",
  'message' => "custom notification email message",
  'triggering_filenames' => ["*.jpg","notify_file.txt"],
  'triggering_group_ids' => [1],
  'triggering_user_ids' => [1],
  'trigger_by_share_recipients' => true,
  'group_id' => 1,
  'username' => "User",
]);
```


### Parameters

* `user_id` (int64): The id of the user to notify. Provide `user_id`, `username` or `group_id`.
* `notify_on_copy` (boolean): If `true`, copying or moving resources into this path will trigger a notification, in addition to just uploads.
* `notify_on_delete` (boolean): Triggers notification when deleting files from this path
* `notify_on_download` (boolean): Triggers notification when downloading files from this path
* `notify_on_move` (boolean): Triggers notification when moving files to this path
* `notify_on_upload` (boolean): Triggers notification when uploading new files to this path
* `notify_user_actions` (boolean): If `true` actions initiated by the user will still result in a notification
* `recursive` (boolean): If `true`, enable notifications for each subfolder in this path
* `send_interval` (string): The time interval that notifications are aggregated by.  Can be `five_minutes`, `fifteen_minutes`, `hourly`, or `daily`.
* `message` (string): Custom message to include in notification emails.
* `triggering_filenames` (array(string)): Array of filenames (possibly with wildcards) to match for action path
* `triggering_group_ids` (array(int64)): Only notify on actions made by a member of one of the specified groups
* `triggering_user_ids` (array(int64)): Only notify on actions made one of the specified users
* `trigger_by_share_recipients` (boolean): Notify when actions are performed by a share recipient?
* `group_id` (int64): The ID of the group to notify.  Provide `user_id`, `username` or `group_id`.
* `path` (string): Path
* `username` (string): The username of the user to notify.  Provide `user_id`, `username` or `group_id`.

---

## Update Notification

```
$notification = current(\Files\Model\Notification::list());

$notification->update([
  'notify_on_copy' => true,
  'notify_on_delete' => true,
  'notify_on_download' => true,
  'notify_on_move' => true,
  'notify_on_upload' => true,
  'notify_user_actions' => true,
  'recursive' => true,
  'send_interval' => "daily",
  'message' => "custom notification email message",
  'triggering_filenames' => ["*.jpg","notify_file.txt"],
  'triggering_group_ids' => [1],
  'triggering_user_ids' => [1],
  'trigger_by_share_recipients' => true,
]);
```

### Parameters

* `id` (int64): Required - Notification ID.
* `notify_on_copy` (boolean): If `true`, copying or moving resources into this path will trigger a notification, in addition to just uploads.
* `notify_on_delete` (boolean): Triggers notification when deleting files from this path
* `notify_on_download` (boolean): Triggers notification when downloading files from this path
* `notify_on_move` (boolean): Triggers notification when moving files to this path
* `notify_on_upload` (boolean): Triggers notification when uploading new files to this path
* `notify_user_actions` (boolean): If `true` actions initiated by the user will still result in a notification
* `recursive` (boolean): If `true`, enable notifications for each subfolder in this path
* `send_interval` (string): The time interval that notifications are aggregated by.  Can be `five_minutes`, `fifteen_minutes`, `hourly`, or `daily`.
* `message` (string): Custom message to include in notification emails.
* `triggering_filenames` (array(string)): Array of filenames (possibly with wildcards) to match for action path
* `triggering_group_ids` (array(int64)): Only notify on actions made by a member of one of the specified groups
* `triggering_user_ids` (array(int64)): Only notify on actions made one of the specified users
* `trigger_by_share_recipients` (boolean): Notify when actions are performed by a share recipient?

### Example Response

```json
{
  "id": 1,
  "path": "",
  "group_id": 1,
  "group_name": "",
  "triggering_group_ids": [
    1
  ],
  "triggering_user_ids": [
    1
  ],
  "trigger_by_share_recipients": true,
  "notify_user_actions": true,
  "notify_on_copy": true,
  "notify_on_delete": true,
  "notify_on_download": true,
  "notify_on_move": true,
  "notify_on_upload": true,
  "recursive": true,
  "send_interval": "fifteen_minutes",
  "message": "custom notification email message",
  "triggering_filenames": [
    "*.jpg",
    "notify_file.txt"
  ],
  "unsubscribed": true,
  "unsubscribed_reason": "",
  "user_id": 1,
  "username": "User",
  "suppressed_email": true
}
```

---

## Delete Notification

```
$notification = current(\Files\Model\Notification::list());

$notification->delete();
```

### Parameters

* `id` (int64): Required - Notification ID.

