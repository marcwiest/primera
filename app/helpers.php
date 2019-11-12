<?php

defined('ABSPATH') || exit;

if ( ! function_exists( 'asset' ) ) :
// Get URL of an asset from within the public folder.
function asset( string $filePath ): string
{
    return get_theme_file_uri( "public/{$filePath}" );
}
endif;

if ( ! function_exists('strtobool') ) :
/**
* Function for turning string booleans values into real booleans.
*
* @since  1.0
* @param  mixed  $value  String to convert to a boolean.
* @return  bool|string
*/
function strtobool($value): bool
{
    $value = strtolower(strval($value));

    if ( $value === 'true' || $value === '1' ) {
        return true;
    }
    elseif ( $value === 'false' || $value === '0' ) {
        return false;
    }

    return $value;
}
endif;

if (! function_exists('is_ssl')) :
// Check if SSL is enabled.
function is_ssl()
{
    if (is_ssl()) {
        return true;
    }
    elseif (0 === stripos(get_option('siteurl'), 'https://')) {
        return true;
    }
    elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' == $_SERVER['HTTP_X_FORWARDED_PROTO']) {
        return true;
    }

    return false;
}
endif;

if ( ! function_exists( 'env_name' ) ) :
/**
* Get current environment.
* @since 1.0
* @return string
*/
function env_name(bool $allowServerName=false)
{
    static $env = '';

    if ( '' != $env ) {
        return $env;
    }

    $server = [
        $_SERVER['HTTP_HOST']
    ];

    // NOTE: SERVER_NAME is less reliable but can function as a 2nd test if HTTP_HOST fails.
    if ( $allowServerName ) {
        $server[] = $_SERVER['SERVER_NAME'];
    }

    if ( in_array( '%production-url%', $server ) ) {
        return $env = 'production';
    }
    else if ( in_array( '%staging-url%', $server ) ) {
        return $env = 'staging';
    }
    else if ( in_array( '%development-url%', $server ) ) {
        return $env = 'development';
    }
    else if ( in_array( $_SERVER['REMOTE_ADDR'], ['::1', '127.0.0.1'] ) ) {
        return $env = 'local';
    }

    return 'production';
}
endif;
