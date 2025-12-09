<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Drive Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para la integración con Google Drive
    |
    */

    'enabled' => env('GOOGLE_DRIVE_ENABLED', false),

    'credentials_path' => env('GOOGLE_CREDENTIALS_PATH', storage_path('app/google-credentials.json')),

    'project_id' => env('GOOGLE_PROJECT_ID'),

    'private_key_id' => env('GOOGLE_PRIVATE_KEY_ID'),

    'private_key' => env('GOOGLE_PRIVATE_KEY'),

    'client_email' => env('GOOGLE_CLIENT_EMAIL'),

    'client_id' => env('GOOGLE_CLIENT_ID'),

    'providers_folder_id' => env('GOOGLE_DRIVE_PROVIDERS_FOLDER_ID'),
];
