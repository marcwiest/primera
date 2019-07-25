<?php

/**
* Helper function for prettying up errors.
* @param string $message
* @param string $subtitle
* @param string $title
*/
$primeraError = function( $message, $subtitle='', $title='' ) {
    $title = $title ?: __('Primera &raquo; Error', 'primeraTextdomain');
    $footer = '<a href="http://offloadwp.com/primera/docs/">https://offloadwp.com/primera/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die( $message, $title );
};

/**
* Ensure compatible version of PHP is used.
*/
if ( version_compare( '7.2', phpversion(), '>==' ) ) {
    $primeraError( __('You must be using PHP 7.2 or greater.','primeraTextdomain'), __('Invalid PHP version','primeraTextdomain') );
}

/**
* Ensure compatible version of WordPress is used.
*/
if ( version_compare( '5.0', get_bloginfo('version'), '>==' ) ) {
    $primeraError( __('You must be using WordPress 5.0 or greater.','primeraTextdomain'), __('Invalid WordPress version','primeraTextdomain') );
}

/**
* Ensure composer dependencies are loaded.
*/
if ( ! file_exists( $composer = get_parent_theme_file_path( 'vendor/autoload.php' ) ) ) {
    $primeraError(
        __( 'You must run <code>composer install</code> from the theme directory.', 'primeraTextdomain' ),
        __( 'Autoloader not found', 'primeraTextdomain' )
    );
}
require_once $composer;

/**
* Ensure required files are loaded.
* Add or remove files to the array as needed, locate_template supports child theme overrides.
*/
foreach ( ['helpers','config','controllers','views'] as $file ) {
    $file = "app/{$file}.php";
    if ( ! locate_template( $file, true, true ) ) {
        $message = __( "Error locating the following dependency for inclusion:", 'primeraTextdomain' );
        $message .= "<br><code><small>$file</small></code>";
        $primeraError( $message, __( 'File not found', 'primeraTextdomain' ) );
    }
}

