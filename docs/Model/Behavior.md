# Behavior

## Example Behavior Object

```
{
  "id": 1,
  "path": "",
  "attachment_url": "",
  "behavior": "webhook",
  "name": "",
  "description": "",
  "value": {
    "method": "GET"
  }
}
```

* `id` (int64): Folder behavior ID
* `path` (string): Folder path This must be slash-delimited, but it must neither start nor end with a slash. Maximum of 5000 characters.
* `attachment_url` (string): URL for attached file
* `behavior` (string): Behavior type.
* `name` (string): Name for this behavior.
* `description` (string): Description for this behavior.
* `value` (object): Settings for this behavior.  See the section above for an example value to provide here.  Formatting is different for each Behavior type.  May be sent as nested JSON or a single JSON-encoded string.  If using XML encoding for the API call, this data must be sent as a JSON-encoded string.
* `attachment_file` (file): Certain behaviors may require a file, for instance, the "watermark" behavior requires a watermark image
* `attachment_delete` (boolean): If true, will delete the file stored in attachment

---

## List Behaviors

```
$behavior = new \Files\Model\Behavior();
$behavior->list(, [
  'per_page' => 1,
  'behavior' => "webhook",
]);
```


### Parameters

* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `behavior`.
* `filter` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `behavior`.
* `filter_gt` (object): If set, return records where the specified field is greater than the supplied value. Valid fields are `behavior`.
* `filter_gteq` (object): If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `behavior`.
* `filter_like` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `behavior`.
* `filter_lt` (object): If set, return records where the specified field is less than the supplied value. Valid fields are `behavior`.
* `filter_lteq` (object): If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `behavior`.
* `behavior` (string): If set, only shows folder behaviors matching this behavior type.

---

## Show Behavior

```
$behavior = new \Files\Model\Behavior();
$behavior->find($id);
```


### Parameters

* `id` (int64): Required - Behavior ID.

---

## List Behaviors by path

```
$behavior = new \Files\Model\Behavior();
$behavior->listFor($path, [
  'per_page' => 1,
  'behavior' => "webhook",
]);
```


### Parameters

* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `sort_by` (object): If set, sort records by the specified field in either 'asc' or 'desc' direction (e.g. sort_by[last_login_at]=desc). Valid fields are `behavior`.
* `filter` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `behavior`.
* `filter_gt` (object): If set, return records where the specified field is greater than the supplied value. Valid fields are `behavior`.
* `filter_gteq` (object): If set, return records where the specified field is greater than or equal to the supplied value. Valid fields are `behavior`.
* `filter_like` (object): If set, return records where the specified field is equal to the supplied value. Valid fields are `behavior`.
* `filter_lt` (object): If set, return records where the specified field is less than the supplied value. Valid fields are `behavior`.
* `filter_lteq` (object): If set, return records where the specified field is less than or equal to the supplied value. Valid fields are `behavior`.
* `path` (string): Required - Path to operate on.
* `recursive` (string): Show behaviors above this path?
* `behavior` (string): DEPRECATED: If set only shows folder behaviors matching this behavior type. Use `filter[behavior]` instead.

---

## Create Behavior

```
$behavior = new \Files\Model\Behavior();
$behavior->create(, [
  'value' => "{\"method\": \"GET\"}",
  'path' => "path",
  'behavior' => "webhook",
]);
```


### Parameters

* `value` (string): The value of the folder behavior.  Can be a integer, array, or hash depending on the type of folder behavior. See The Behavior Types section for example values for each type of behavior.
* `attachment_file` (file): Certain behaviors may require a file, for instance, the "watermark" behavior requires a watermark image
* `name` (string): Name for this behavior.
* `description` (string): Description for this behavior.
* `path` (string): Required - Folder behaviors path.
* `behavior` (string): Required - Behavior type.

---

## Test webhook

```
$behavior = new \Files\Model\Behavior();
$behavior->webhookTest(, [
  'url' => "https://www.site.com/...",
  'method' => "GET",
  'encoding' => "RAW",
  'headers' => "x-test-header => testvalue",
  'body' => "test-param => testvalue",
  'action' => "test",
]);
```


### Parameters

* `url` (string): Required - URL for testing the webhook.
* `method` (string): HTTP method(GET or POST).
* `encoding` (string): HTTP encoding method.  Can be JSON, XML, or RAW (form data).
* `headers` (object): Additional request headers.
* `body` (object): Additional body parameters.
* `action` (string): action for test body

---

## Update Behavior

```
$behavior = current(\Files\Model\Behavior::list());

$behavior->update([
  'value' => "{\"method\": \"GET\"}",
  'behavior' => "webhook",
  'attachment_delete' => true,
]);
```

### Parameters

* `id` (int64): Required - Behavior ID.
* `value` (string): The value of the folder behavior.  Can be a integer, array, or hash depending on the type of folder behavior. See The Behavior Types section for example values for each type of behavior.
* `attachment_file` (file): Certain behaviors may require a file, for instance, the "watermark" behavior requires a watermark image
* `name` (string): Name for this behavior.
* `description` (string): Description for this behavior.
* `behavior` (string): Behavior type.
* `path` (string): Folder behaviors path.
* `attachment_delete` (boolean): If true, will delete the file stored in attachment

### Example Response

```json
{
  "id": 1,
  "path": "",
  "attachment_url": "",
  "behavior": "webhook",
  "name": "",
  "description": "",
  "value": {
    "method": "GET"
  }
}
```

---

## Delete Behavior

```
$behavior = current(\Files\Model\Behavior::list());

$behavior->delete();
```

### Parameters

* `id` (int64): Required - Behavior ID.

