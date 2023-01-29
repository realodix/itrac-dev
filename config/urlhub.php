<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Unregistered Users Access
    |--------------------------------------------------------------------------
    */

    /*
     * If you set false, users must be registered to create Short URL.
     */
    'public_site' => env('UH_PUBLIC_SITE', true),

    /*
     * Enable users registration. If disabled it, no one can register.
     */
    'registration' => env('UH_REGISTRATION', true),

    /*
    |--------------------------------------------------------------------------
    | Shorten URL
    |--------------------------------------------------------------------------
    */

    /*
     * The expected (and maximum) number of characters in generating unique
     * keyword.
     */
    'hash_length' => env('UH_HASH_LENGTH', 6), // >= 1

    /*
     * Characters to be used in generating unique keyword. For convenience,
     * currently the allowed characters are only alphanumeric consisting of
     * a limited set of characters belonging to the US-ASCII characters,
     * including digits (0-9), letters (A-Z, a-z).
     */
    'hash_char' => env(
        'UH_HASH_CHAR',
        'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    ),

    /*
     * List of non allowed domain.
     *
     * This list is used to prevent shortening of urls that contain one of the
     * domains below.
     */
    'domain_blacklist' => [
        config('app.url'),
        // 'bit.ly',
    ],

    /*
     * List of reserved or not allowed URL ending.
     *
     * Some of them represent things that look like folder names in public
     * folders. Feel free to add keywords that you want to prevent, for
     * example rude words.
     */
    'reserved_keyword' => [
        'css',
        'images',
        'img',
        'fonts',
        'js',
        'svg',
    ],

    'web_title' => env('UH_WEB_TITLE', true),

    /*
    |--------------------------------------------------------------------------
    | Visiting
    |--------------------------------------------------------------------------
    */

    /*
     * Configure the kind of redirect you want to use for your short URLs. You
     * can either set:
     * - 301
     * - 302
     *
     * When selecting 301 redirects, you can also configure the time redirects
     * are cached, to mitigate deviations in stats.
     */
    'redirect_status_code' => env('UH_REDIRECT_STATUS_CODE', 302),

    /*
     * Set the amount of seconds that redirects should be cached when redirect
     * status is 301. Default values is 30.
     */
    'redirect_cache_max_age' => env('UH_REDIRECT_CACHE_MAX_AGE', 30),

    /**
     * Determine whether bot visits are logged or not
     *
     * - TRUE: Logs bot visits in the visitor log
     * - FALSE: Doesn't log bot visits in visitor logs
     */
    'track_bot_visits' => env('UH_TRACK_BOT_VISITS', false),
];
