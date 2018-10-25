<?php

return [

    /*
     * The Google Tag Manager id, should be a code that looks something like "gtm-xxxx".
     */
    'id' => '',
    
    /*
     * Enable or disable script rendering. Useful for local development.
     */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Google Tags Environments
    |--------------------------------------------------------------------------
    |
    | If you want to use environments in Google Tag Manager you have to enable the
    | use of environments by defining environmentsEnabled as true and define the
    | the gtmAuth and gtmPreview keys.
    |
    */
    'environmentsEnabled' => false,

    // The gtm_auth parameter of the Google Tag Manager environment to use
    'gtmAuth' => '',

    // The gtm_preview parameter of the Google Tag Manager environment to use
    'gtmPreview' => '',

    /*
     * If you want to use some macro's you 'll probably store them
     * in a dedicated file. You can optionally define the path
     * to that file here and we will load it for you.
     */
    'macroPath' => '',

    /*
     * The key under which data is saved to the session with flash.
     */
    'sessionKey' => '_googleTagManager',

];
