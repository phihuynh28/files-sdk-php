# MessageCommentReaction

## Example MessageCommentReaction Object

```
{
  "id": 1,
  "emoji": "👍"
}
```

* `id` (int64): Reaction ID
* `emoji` (string): Emoji used in the reaction.
* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.

---

## List Message Comment Reactions

```
$message_comment_reaction = new \Files\Model\MessageCommentReaction();
$message_comment_reaction->list(, [
  'user_id' => 1,
  'per_page' => 1,
  'message_comment_id' => 1,
]);
```


### Parameters

* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
* `message_comment_id` (int64): Required - Message comment to return reactions for.

---

## Show Message Comment Reaction

```
$message_comment_reaction = new \Files\Model\MessageCommentReaction();
$message_comment_reaction->find($id);
```


### Parameters

* `id` (int64): Required - Message Comment Reaction ID.

---

## Create Message Comment Reaction

```
$message_comment_reaction = new \Files\Model\MessageCommentReaction();
$message_comment_reaction->create(, [
  'user_id' => 1,
  'emoji' => "emoji",
]);
```


### Parameters

* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.
* `emoji` (string): Required - Emoji to react with.

---

## Delete Message Comment Reaction

```
$message_comment_reaction = current(\Files\Model\MessageCommentReaction::list());

$message_comment_reaction->delete();
```

### Parameters

* `id` (int64): Required - Message Comment Reaction ID.

