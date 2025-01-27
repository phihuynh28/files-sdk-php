# As2Partner

## Example As2Partner Object

```
{
  "id": 1,
  "as2_station_id": 1,
  "name": "AS2 Partner Name",
  "uri": "",
  "server_certificate": "require_match",
  "hex_public_certificate_serial": "A5:EB:C1:95:DC:D8:2B:E7",
  "public_certificate_md5": "",
  "public_certificate_subject": "",
  "public_certificate_issuer": "",
  "public_certificate_serial": "",
  "public_certificate_not_before": "",
  "public_certificate_not_after": ""
}
```

* `id` (int64): Id of the AS2 Partner.
* `as2_station_id` (int64): Id of the AS2 Station associated with this partner.
* `name` (string): The partner's formal AS2 name.
* `uri` (string): Public URI for sending AS2 message to.
* `server_certificate` (string): Remote server certificate security setting
* `hex_public_certificate_serial` (string): Serial of public certificate used for message security in hex format.
* `public_certificate_md5` (string): MD5 hash of public certificate used for message security.
* `public_certificate_subject` (string): Subject of public certificate used for message security.
* `public_certificate_issuer` (string): Issuer of public certificate used for message security.
* `public_certificate_serial` (string): Serial of public certificate used for message security.
* `public_certificate_not_before` (string): Not before value of public certificate used for message security.
* `public_certificate_not_after` (string): Not after value of public certificate used for message security.
* `public_certificate` (string): 

---

## List As2 Partners

```
$as2_partner = new \Files\Model\As2Partner();
$as2_partner->list(, [
  'per_page' => 1,
]);
```


### Parameters

* `cursor` (string): Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
* `per_page` (int64): Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).

---

## Show As2 Partner

```
$as2_partner = new \Files\Model\As2Partner();
$as2_partner->find($id);
```


### Parameters

* `id` (int64): Required - As2 Partner ID.

---

## Create As2 Partner

```
$as2_partner = new \Files\Model\As2Partner();
$as2_partner->create(, [
  'name' => "name",
  'uri' => "uri",
  'public_certificate' => "public_certificate",
  'as2_station_id' => 1,
  'server_certificate' => "require_match",
]);
```


### Parameters

* `name` (string): Required - AS2 Name
* `uri` (string): Required - URL base for AS2 responses
* `public_certificate` (string): Required - 
* `as2_station_id` (int64): Required - Id of As2Station for this partner
* `server_certificate` (string): Remote server certificate security setting

---

## Update As2 Partner

```
$as2_partner = current(\Files\Model\As2Partner::list());

$as2_partner->update([
  'name' => "AS2 Partner Name",
  'server_certificate' => "require_match",
]);
```

### Parameters

* `id` (int64): Required - As2 Partner ID.
* `name` (string): AS2 Name
* `uri` (string): URL base for AS2 responses
* `server_certificate` (string): Remote server certificate security setting
* `public_certificate` (string): 

### Example Response

```json
{
  "id": 1,
  "as2_station_id": 1,
  "name": "AS2 Partner Name",
  "uri": "",
  "server_certificate": "require_match",
  "hex_public_certificate_serial": "A5:EB:C1:95:DC:D8:2B:E7",
  "public_certificate_md5": "",
  "public_certificate_subject": "",
  "public_certificate_issuer": "",
  "public_certificate_serial": "",
  "public_certificate_not_before": "",
  "public_certificate_not_after": ""
}
```

---

## Delete As2 Partner

```
$as2_partner = current(\Files\Model\As2Partner::list());

$as2_partner->delete();
```

### Parameters

* `id` (int64): Required - As2 Partner ID.

