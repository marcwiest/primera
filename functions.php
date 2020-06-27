<?php

/**
* Helper function for prettying up errors.
* @param string $message
* @param string $subtitle
* @param string $title
*/
$primeraError = function( $message, $subtitle='', $title='' ) {
    $title = $title ?: __('Error', 'primeraTextDomain');
    $footer = '<a href="http://gooddaywp.com/primera/docs/">https://gooddaywp.com/primera/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die( $message, $title );
};

/**
* Ensure composer dependencies are loaded.
*/
if ( ! file_exists( $composer = get_parent_theme_file_path( 'vendor/autoload.php' ) ) ) {
    $primeraError(
        __( 'You must run <code>composer install</code> from the theme directory.', 'primeraTextDomain' ),
        __( 'Autoloader not found', 'primeraTextDomain' )
    );
}
require_once $composer;

/**
* Ensure app files are loaded.
*
* Add or remove files to the array as needed, locate_template supports child theme overrides.
* Including these files before the `venodr/autoload.php` allows us to overwrite Laravel's
* pluggable helper functions.
*/
foreach ([
    'helpers',
] as $file) {
    locate_template("app/{$file}.php", true, true);
}

/**
* Ensure config files are loaded.
*
* Add or remove files to the array as needed, locate_template supports child theme overrides.
*/
foreach ([
    'admin',
    'editor',
    'frontend',
    'primera',
    'scripts',
    'theme',
    'woocommerce',
] as $file) {
    locate_template("app/config/{$file}.php", true, true);
}


