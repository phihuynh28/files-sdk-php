# PublicKey

## Example PublicKey Object

```
{
  "id": 1,
  "title": "My public key",
  "created_at": "2000-01-01T01:00:00Z",
  "fingerprint": "43:51:43:a1:b5:fc:8b:b7:0a:3a:a9:b1:0f:66:73:a8"
}
```

* `id` (int64): Public key ID
* `title` (string): Public key title
* `created_at` (date-time): Public key created at date/time
* `fingerprint` (string): Public key fingerprint
* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.
* `public_key` (string): Actual contents of SSH key.

---

## List Public Keys

```
$public_key = new \Files\Model\PublicKey();
$public_key->list(, [
  'user_id' => 1,
  'per_page' => 1,
]);
```


### Parameters

* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.
* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).

---

## Show Public Key

```
$public_key = new \Files\Model\PublicKey();
$public_key->find($id);
```


### Parameters

* `id` (int64): Required - Public Key ID.

---

## Create Public Key

```
$public_key = new \Files\Model\PublicKey();
$public_key->create(, [
  'user_id' => 1,
  'title' => "My Main Key",
  'public_key' => "public_key",
]);
```


### Parameters

* `user_id` (int64): User ID.  Provide a value of `0` to operate the current session's user.
* `title` (string): Required - Internal reference for key.
* `public_key` (string): Required - Actual contents of SSH key.

---

## Update Public Key

```
$public_key = current(\Files\Model\PublicKey::list());

$public_key->update([
  'title' => "My Main Key",
]);
```

### Parameters

* `id` (int64): Required - Public Key ID.
* `title` (string): Required - Internal reference for key.

### Example Response

```json
{
  "id": 1,
  "title": "My public key",
  "created_at": "2000-01-01T01:00:00Z",
  "fingerprint": "43:51:43:a1:b5:fc:8b:b7:0a:3a:a9:b1:0f:66:73:a8"
}
```

---

## Delete Public Key

```
$public_key = current(\Files\Model\PublicKey::list());

$public_key->delete();
```

### Parameters

* `id` (int64): Required - Public Key ID.

