<?php

// namespace App;
// namespace Sober\Controller;

// use Illuminate\Container\Container;
use Brain\Hierarchy\Hierarchy;
use Sober\Controller\Loader;

/**
* Loader
*/
function primeraSoberControllerLoader()
{
    // // Get Sage function
    // $sage = sage();

    // // Return if function does not exist
    // if (!$sage) {
    //     return;
    // }

    // Run WordPress hierarchy class
    $hierarchy = new Hierarchy;

    // Run Loader class and pass on WordPress hierarchy class
    $loader = new Loader( $hierarchy );

    // Use the Sage DI container
    // $container = $sage();

    // Loop over each class
    foreach ( $loader->getClassesToRun() as $class ) {

        $controller = new $class;

        // Create the class on the DI container
        // $controller = $container->make($class);

        // Set the params required for template param
        $controller->__setParams();

        // Determine template location to expose data
        $location = "primera/template/{$controller->__getTemplateParam()}-data/data";

        // Pass data to filter
        add_filter( $location, function( $data ) use ( $class ) {
            // Recreate the class so that $post is included
            // $controller = $container->make($class);
            $controller = new $class;

            // Params
            $controller->__setParams();

            // Lifecycle
            $controller->__before();

            // Data
            $controller->__setData( $data );

            // Lifecycle
            $controller->__after();

            // Return
            return $controller->__getData();

        }, 10 );
    }
}

/**
* Hooks
*/
if ( function_exists('add_action') ) {
    // add_action('init', __NAMESPACE__ . '\loader');
    add_action('init', 'primeraSoberControllerLoader');
}
