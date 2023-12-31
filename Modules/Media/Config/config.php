<?php

return [
    'name' => 'Media',
    /*
    |--------------------------------------------------------------------------
    | Choose which filesystem you wish to use to store the media
    |--------------------------------------------------------------------------
    | Choose one or more of the filesystems you configured
    | in app/config/filesystems.php
    | Supported: "local", "s3"
     */
    'filesystem' => 'local',
    /*
    |--------------------------------------------------------------------------
    | The path where the media files will be uploaded
    |--------------------------------------------------------------------------
    | Note: Trailing slash is required
     */
    //'files-path' => '/assets/media/',
    'files-path' => '../storage/app/public/uploads/',
    /*
    |--------------------------------------------------------------------------
    | Specify all the allowed file extensions a user can upload on the server
    |--------------------------------------------------------------------------
     */
    'allowed-types' => '.jpg,.png',
    /*
    |--------------------------------------------------------------------------
    | Determine the max file size upload rate
    | Defined in MB
    |--------------------------------------------------------------------------
     */
    'max-file-size' => '5',

    /*
    |--------------------------------------------------------------------------
    | Determine the max total media folder size
    |--------------------------------------------------------------------------
    | Expressed in bytes
     */
    'max-total-size' => 1000000000,
];
