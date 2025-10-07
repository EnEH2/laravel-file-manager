<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Storage Disk
    |--------------------------------------------------------------------------
    |
    | This defines which Laravel filesystem disk will be used to store files.
    | You can define disks in config/filesystems.php.
    | Example: 'local', 'public', 's3'
    |
    */

    'disk' => env('FILEMANAGER_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Base Upload Path
    |--------------------------------------------------------------------------
    |
    | All uploaded files will be stored under this folder inside the chosen disk.
    | Example: 'uploads' means files go to storage/app/public/uploads/
    |
    */

    'base_path' => env('FILEMANAGER_BASE_PATH', 'uploads'),

    /*
    |--------------------------------------------------------------------------
    | Allowed File Types
    |--------------------------------------------------------------------------
    |
    | File extensions that are permitted to be uploaded. You can add or remove
    | types based on your system needs.
    |
    */

    'allowed_extensions' => [
        'jpg', 'jpeg', 'png', 'gif', 'svg',
        'pdf', 'doc', 'docx', 'xls', 'xlsx',
        'zip', 'rar', 'txt', 'csv', 'mp4', 'mp3',
    ],

    /*
    |--------------------------------------------------------------------------
    | Maximum Upload Size (in MB)
    |--------------------------------------------------------------------------
    |
    | Define how large a file can be uploaded through this system.
    | You can also set a per-model or per-user restriction later.
    |
    */

    'max_size' => env('FILEMANAGER_MAX_SIZE', 50), // in MB

    /*
    |--------------------------------------------------------------------------
    | Automatic Database Record Creation
    |--------------------------------------------------------------------------
    |
    | If enabled, each uploaded file will automatically create a record in
    | the "files" table (using File model). Disable if you prefer manual control.
    |
    */

    'auto_create_db_record' => true,

    /*
    |--------------------------------------------------------------------------
    | File URL Prefix
    |--------------------------------------------------------------------------
    |
    | Set how public file URLs should be generated. If you’re using 'public' disk,
    | it typically points to storage/app/public.
    |
    | Example output: /storage/uploads/filename.jpg
    |
    */

    'url_prefix' => env('FILEMANAGER_URL_PREFIX', '/storage'),

];
