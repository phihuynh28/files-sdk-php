# FileMigration

## Example FileMigration Object

```
{
  "id": 1,
  "path": "MyFolder",
  "dest_path": "MyFolder",
  "files_moved": 1,
  "files_total": 1,
  "operation": "move",
  "region": "USA",
  "status": "complete",
  "log_url": "https://www.example.com/log_file"
}
```

* `id` (int64): File migration ID
* `path` (string): Source path This must be slash-delimited, but it must neither start nor end with a slash. Maximum of 5000 characters.
* `dest_path` (string): Destination path
* `files_moved` (int64): Number of files processed
* `files_total` (int64): Total number of files to process
* `operation` (string): The type of operation
* `region` (string): Region
* `status` (string): Status
* `log_url` (string): Link to download the log file for this migration.

---

## Show File Migration

```
$file_migration = new \Files\Model\FileMigration();
$file_migration->find($id);
```


### Parameters

* `id` (int64): Required - File Migration ID.
