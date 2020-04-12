<?php

namespace App\config\primera;

defined('ABSPATH') || exit;

// Actions
add_action( 'after_setup_theme' , __NAMESPACE__ . '\\initPrimera' );
// add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addBladeComponentAliases' );
// add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addExampleBladeDirective' );
// add_action( 'after_setup_theme' , __NAMESPACE__ . '\\addExampleIfBladeDirective' );

/**
* Initialize Primera.
*/
function initPrimera()
{
    $envFile = defined('PRIMERA_ENV_FILE') && ! empty(PRIMERA_ENV_FILE)
        ? (string) PRIMERA_ENV_FILE
        : null;

    primera([
        'viewsDir' => get_theme_file_path('source/views/'),
        'cacheDir' => trailingslashit(wp_get_upload_dir()['basedir']).'blade-cache',
        'envFile'  => $envFile,
    ]);
}

/**
* Add Example Blade Component.
*/
function addBladeComponentAliases()
{
    // Usage example:
    // @xmpl
    // @endxmpl
    primera('blade')->component('components.example', 'xmpl');
}

/**
* Add Example Blade Component.
*/
function addExampleBladeDirective()
{
    // Usage example:
    // @hello(Test)
    // @endhello
    primera('blade')->directive('hello', function($expression) {
        return "<?php e('Hello {$expression}'); ?>";
    });
    primera('blade')->directive('endhello', function() {
        return "<?php e('Goodbye'); ?>";
    });
}

/**
* Add Example Blade Component.
*/
function addExampleIfBladeDirective()
{
    // Usage example:
    // @isUserLoggedIn
    // @else
    // @endisUserLoggedIn
    primera('blade')->if('isUserLoggedIn', function() {
        return is_user_logged_in();
    });
}


