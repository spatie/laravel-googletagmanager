<?php

return [

    /*
     * The Google Tag Manager id, should be a code that looks something like "gtm-xxxx".
     */
    'id' => env('GOOGLE_TAG_MANAGER_ID', ''),

    /*
     * Enable or disable script rendering. Useful for local development.
     */
    'enabled' => env('GOOGLE_TAG_MANAGER_ENABLED', true),

    /*
     * If you want to use some macro's you 'll probably store them
     * in a dedicated file. You can optionally define the path
     * to that file here and we will load it for you.
     */
    'macroPath' => env('GOOGLE_TAG_MANAGER_MACRO_PATH', ''),

    /*
     * The key under which data is saved to the session with flash.
     */
    'sessionKey' => env('GOOGLE_TAG_MANAGER_SESSION_KEY', '_googleTagManager'),

    /*
     * Configures the Google Tag Manager script domain.
     * Modify this value only if you're using "Google Tag Manage: Web Container" client
     * to serve gtm.js for your web container. Else, keep the default value.
     */
    'domain' => env('GOOGLE_TAG_MANAGER_DOMAIN', 'www.googletagmanager.com'),
];
