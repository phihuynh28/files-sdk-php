# GroupUser

## Example GroupUser Object

```
{
  "group_name": "My Group",
  "group_id": 1,
  "user_id": 1,
  "admin": true,
  "usernames": [
    "user"
  ]
}
```

* `group_name` (string): Group name
* `group_id` (int64): Group ID
* `user_id` (int64): User ID
* `admin` (boolean): Is this user an administrator of this group?
* `usernames` (array): A list of usernames for users in this group
* `id` (int64): Group User ID.

---

## List Group Users

```
$group_user = new \Files\Model\GroupUser();
$group_user->list(, [
  'user_id' => 1,
  'per_page' => 1,
  'group_id' => 1,
]);
```


### Parameters

* `user_id` (int64): User ID.  If provided, will return group_users of this user.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `group_id` (int64): Group ID.  If provided, will return group_users of this group.

---

## Create Group User

```
$group_user = new \Files\Model\GroupUser();
$group_user->create(, [
  'group_id' => 1,
  'user_id' => 1,
  'admin' => true,
]);
```


### Parameters

* `group_id` (int64): Required - Group ID to add user to.
* `user_id` (int64): Required - User ID to add to group.
* `admin` (boolean): Is the user a group administrator?

---

## Update Group User

```
$group_user = current(\Files\Model\GroupUser::list());

$group_user->update([
  'group_id' => 1,
  'user_id' => 1,
  'admin' => true,
]);
```

### Parameters

* `id` (int64): Required - Group User ID.
* `group_id` (int64): Required - Group ID to add user to.
* `user_id` (int64): Required - User ID to add to group.
* `admin` (boolean): Is the user a group administrator?

### Example Response

```json
{
  "group_name": "My Group",
  "group_id": 1,
  "user_id": 1,
  "admin": true,
  "usernames": [
    "user"
  ]
}
```

---

## Delete Group User

```
$group_user = current(\Files\Model\GroupUser::list());

$group_user->delete([
  'group_id' => 1,
  'user_id' => 1,
]);
```

### Parameters

* `id` (int64): Required - Group User ID.
* `group_id` (int64): Required - Group ID from which to remove user.
* `user_id` (int64): Required - User ID to remove from group.

