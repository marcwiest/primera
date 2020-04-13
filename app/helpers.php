<?php

defined('ABSPATH') || exit;


if (! function_exists('asset')) :
// Get URL of an asset from within the public folder.
function asset(string $filePath): string
{
    return get_theme_file_uri( "public/{$filePath}" );
}
endif;


if (! function_exists('env')) :
// Overwrites Laravel's `env` helper function to allow for array like values in `.env` file.
function env(string $key, $default=null)
{
    return primera('env')->get($key, $default);
}
endif;


if (! function_exists('add_ajax_action')) :
/**
* Ajax action wrapper to simplify action creation for both, logged-in and logged-out users.
* Note: You can check whether a user is logged-in via `is_user_logged_in()`.
*/
function add_ajax_action(string $action, callable $callback): void
{
    add_action("wp_ajax_{$action}", $callback);
    add_action("wp_ajax_nopriv_{$action}", $callback);
}
endif;


if (! function_exists('log_report')) :
/**
* Log message inside `debug.log`.
*/
function log_report(string $msg): void
{
    $logPath = WP_CONTENT_DIR . '/debug.log';
    if (defined('WP_DEBUG_LOG') && is_string(WP_DEBUG_LOG) && ! empty(WP_DEBUG_LOG)) {
        $logPath = trim(WP_DEBUG_LOG);
    }
    @error_log($msg, 3, $logPath);
}
endif;


if (! function_exists('mix')) :
/**
* Gets the versioned JS or CSS file from the `mix-manifest.json`.
*/
function mix(string $path): string
{
    static $manifests = [];

    $path = '/' . ltrim($path, '/');

    $manifestPath = get_parent_theme_file_path('public/mix-manifest.json');

    if (! isset($manifests[$manifestPath])) {
        if (! file_exists($manifestPath)) {
            throw new Exception('The Mix manifest does not exist.');
        }

        $manifests[$manifestPath] = json_decode(file_get_contents($manifestPath), true);
    }

    $manifest = $manifests[$manifestPath];

    if (! isset($manifest[$path])) {
        $exception = new Exception("Unable to locate Mix file: {$path}.");

        if (defined('WP_DEBUG') && true == WP_DEBUG) {
            throw $exception;
        } else {
            log_report($exception);
            return $path;
        }
    }

    return esc_url(get_parent_theme_file_uri("public{$manifest[$path]}"));
}
endif;


if ( ! function_exists('validate_boolean') ) :
/**
* Function for turning values into booleans.
*
* Only returns true for: true, 'true', 1, '1', 'on', 'yes'.
* Note, all other values (e.g. 'asdf') will return false.
*
* @since  1.0
* @param  mixed  $value  Value to convert to a boolean.
* @return  bool
*/
function validate_boolean($value): bool
{
    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
}
endif;
