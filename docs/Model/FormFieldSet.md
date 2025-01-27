# FormFieldSet

## Example FormFieldSet Object

```
{
  "id": 1,
  "title": "Sample Form Title",
  "form_layout": [
    1,
    2,
    3,
    4
  ],
  "form_fields": {
    "id": 1,
    "label": "Sample Label",
    "required": true,
    "help_text": "Help Text",
    "field_type": "text",
    "options_for_select": [
      "red",
      "green",
      "blue"
    ],
    "default_option": "red",
    "form_field_set_id": 1
  },
  "skip_name": true,
  "skip_email": true,
  "skip_company": true
}
```

* `id` (int64): Form field set id
* `title` (string): Title to be displayed
* `form_layout` (int64): Layout of the form
* `form_fields` (FormField): Associated form fields
* `skip_name` (boolean): Any associated InboxRegistrations or BundleRegistrations can be saved without providing name
* `skip_email` (boolean): Any associated InboxRegistrations or BundleRegistrations can be saved without providing email
* `skip_company` (boolean): Any associated InboxRegistrations or BundleRegistrations can be saved without providing company
* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.

---

## List Form Field Sets

```
$form_field_set = new \Files\Model\FormFieldSet();
$form_field_set->list(, [
  'user_id' => 1,
  'per_page' => 1,
]);
```


### Parameters

* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).

---

## Show Form Field Set

```
$form_field_set = new \Files\Model\FormFieldSet();
$form_field_set->find($id);
```


### Parameters

* `id` (int64): Required - Form Field Set ID.

---

## Create Form Field Set

```
$form_field_set = new \Files\Model\FormFieldSet();
$form_field_set->create(, [
  'user_id' => 1,
  'title' => "Sample Form Title",
  'skip_email' => true,
  'skip_name' => true,
  'skip_company' => true,
  'form_fields' => {"label":"Sample Label","required":true,"help_text":"Help Text","field_type":"text","options_for_select":["red","green","blue"],"default_option":"red","form_field_set_id":1},
]);
```


### Parameters

* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.
* `title` (string): Title to be displayed
* `skip_email` (boolean): Skip validating form email
* `skip_name` (boolean): Skip validating form name
* `skip_company` (boolean): Skip validating company
* `form_fields` (array(object)): 

---

## Update Form Field Set

```
$form_field_set = current(\Files\Model\FormFieldSet::list());

$form_field_set->update([
  'title' => "Sample Form Title",
  'skip_email' => true,
  'skip_name' => true,
  'skip_company' => true,
  'form_fields' => {"id":1,"label":"Sample Label","required":true,"help_text":"Help Text","field_type":"text","options_for_select":["red","green","blue"],"default_option":"red","form_field_set_id":1},
]);
```

### Parameters

* `id` (int64): Required - Form Field Set ID.
* `title` (string): Title to be displayed
* `skip_email` (boolean): Skip validating form email
* `skip_name` (boolean): Skip validating form name
* `skip_company` (boolean): Skip validating company
* `form_fields` (array(object)): 

### Example Response

```json
{
  "id": 1,
  "title": "Sample Form Title",
  "form_layout": [
    1,
    2,
    3,
    4
  ],
  "form_fields": {
    "id": 1,
    "label": "Sample Label",
    "required": true,
    "help_text": "Help Text",
    "field_type": "text",
    "options_for_select": [
      "red",
      "green",
      "blue"
    ],
    "default_option": "red",
    "form_field_set_id": 1
  },
  "skip_name": true,
  "skip_email": true,
  "skip_company": true
}
```

---

## Delete Form Field Set

```
$form_field_set = current(\Files\Model\FormFieldSet::list());

$form_field_set->delete();
```

### Parameters

* `id` (int64): Required - Form Field Set ID.

