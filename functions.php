<?php

/**
* Helper function for prettying up errors.
* @param string $message
* @param string $subtitle
* @param string $title
*/
$primeraError = function( $message, $subtitle='', $title='' ) {
    $title = $title ?: __('Primera &rsaquo; Error', 'primeraTextdomain');
    $footer = '<a href="http://offloadwp.com/primera/docs/">offloadwp.com/primera/docs/</a>';
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
* Ensure dependencies are loaded.
*/
if ( ! file_exists( $composer = get_parent_theme_file_path( 'vendor/autoload.php' ) ) ) {
    $primeraError(
        __( 'You must run <code>composer install</code> from the theme directory.', 'primeraTextdomain' ),
        __( 'Autoloader not found', 'primeraTextdomain' )
    );
}
require_once $composer;

/**
* Primera required files.
*
* The mapped array determines the code library included in your theme.
* Add or remove files to the array as needed. Supports child theme overrides.
*/
foreach ( ['helpers','setup'] as $file ) {
    $file = "app/{$file}.php";
    // NOTE: locate_template uses load_template to include the $file.
    if ( ! locate_template( $file, true, true ) ) {
        $primeraError(sprintf(__('Error locating <code>%s</code> for inclusion.', 'primeraTextdomain'), $file), 'File not found');
    }
}

