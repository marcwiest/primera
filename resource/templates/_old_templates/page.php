<?php

use primeraPhpNamespace\Twig;
use primeraPhpNamespace\Model;

$data = [];

$data['site'] = Model::get_site_data();

$data['posts'] = $posts;

//----

get_header();

Twig::display( 'page', $data );

get_footer();
