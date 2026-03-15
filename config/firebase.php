<?php

return [
    'project_id' => env('FIREBASE_PROJECT_ID'),
    'web_api_key' => env('FIREBASE_WEB_API_KEY'),
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
    // Optional allowlist: only this email can enter admin panel.
    'admin_email' => env('ADMIN_EMAIL'),
];
