# RemoteBandwidthSnapshot

## Example RemoteBandwidthSnapshot Object

```
{
  "id": 1,
  "sync_bytes_received": 1.0,
  "sync_bytes_sent": 1.0,
  "logged_at": "2000-01-01T01:00:00Z",
  "remote_server_id": 1
}
```

* `id` (int64): Site bandwidth ID
* `sync_bytes_received` (double): Site sync bandwidth report bytes received
* `sync_bytes_sent` (double): Site sync bandwidth report bytes sent
* `logged_at` (date-time): Time the site bandwidth report was logged
* `remote_server_id` (int64): ID of related Remote Server

---

## List Remote Bandwidth Snapshots

```
$remote_bandwidth_snapshot = new \Files\Model\RemoteBandwidthSnapshot();
$remote_bandwidth_snapshot->list(, [
  'per_page' => 1,
]);
```


### Parameters

* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `logged_at`.
* `filter` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `logged_at`.
* `filter_gt` (object): If set, return records where the specified field is greater than the supplied value. Valid fields are `logged_at`.
* `filter_gteq` (object): If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `logged_at`.
* `filter_like` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `logged_at`.
* `filter_lt` (object): If set, return records where the specified field is less than the supplied value. Valid fields are `logged_at`.
* `filter_lteq` (object): If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `logged_at`.
