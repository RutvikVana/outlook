<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Azure OAuth Configuration
    |--------------------------------------------------------------------------
    |
    | This file stores credentials and endpoints required for authenticating
    | with Microsoft using OAuth2. Make sure the values in .env match.
    |
    */

    'appId' => env('AZURE_APP_ID', 'f2cff779-1415-48dc-9528-3aa74a9d5038'),
    'appSecret' => env('AZURE_APP_SECRET', 'dVJ8Q~SJ7SK2M1t3i1kHtADcfuQzAmTLB4lACdeo'),
    'redirectUri' => env('AZURE_REDIRECT_URI', 'http://localhost:8000/callback'),

    'authority' => 'https://login.microsoftonline.com/common',
    'authorizeEndpoint' => '/oauth2/v2.0/authorize',
    'tokenEndpoint' => '/oauth2/v2.0/token',

    'scopes' => 'openid profile offline_access user.read calendars.read',
];
