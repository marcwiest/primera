<?php

/**
* Helper function for prettying up errors.
* @param string $message
* @param string $subtitle
* @param string $title
*/
$primeraError = function( $message, $subtitle='', $title='' ) {
    $title = $title ?: __('Error', 'primeraTextdomain');
    $footer = '<a href="http://gooddaywp.com/primera/docs/">https://gooddaywp.com/primera/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die( $message, $title );
};

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
* Ensure app files are loaded.
* Add or remove files to the array as needed, locate_template supports child theme overrides.
*/
foreach ([
    'helpers',
    'backcompat',
    'theme',
    'primera',
    'rest',
    'ajax'
] as $file) {
    locate_template("app/{$file}.php", true, true);
}


