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
     * The key of the authenticated model that can be passed to the Google Tag Manager
     * Data Layer using a middleware. Note that this cannot contain personal information
     * like email or phone number.
     */
    'user_model_key' => env('GOOGLE_TAG_MANAGER_USER_MODEL_KEY', 'id'), 

    /*
     * The key used in the data layer for storing the authenticated model id.
     */
    'data_layer_user_key' => env('GOOGLE_TAG_MANAGER_DATA_LAYER_USER_KEY', 'uid'), 
];
