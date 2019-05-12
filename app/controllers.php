<?php

namespace App;

use Brain\Hierarchy\Hierarchy;
use Sober\Controller\Loader;

/**
* Add controller data to views via filter hook.
*/
function _injectControllers()
{
    // Run WordPress hierarchy class
    $hierarchy = new Hierarchy;

    // Run Loader class and pass on WordPress hierarchy class
    $loader = new Loader( $hierarchy );

    // Loop over each class
    foreach ( $loader->getClassesToRun() as $class ) {

        $controller = new $class;

        // Set the params required for template param
        $controller->__setParams();

        // Determine template location to expose data
        $filterTag = "primera/template/{$controller->__getTemplateParam()}-data/data";

        // Pass data to filter
        add_filter( $filterTag, function( $data ) use ( $class ) {

            // Recreate the class so that $post is included.
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
add_action( 'init', __NAMESPACE__ . '\\_injectControllers');
