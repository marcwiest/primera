<?php

use primeraPhpNamespace\Controller;
use primeraPhpNamespace\Twig;

// wp_enqueue_style( 'page' );
// wp_enqueue_script( 'page' );

$context = array_merge(
    Controller::get_utility_data(),
    Controller::get_page_data()
);

Twig::display( 'index', $context );
