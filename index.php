<?php

$children = 'post-single';

if ( is_home() || is_archive() || is_search() ) {

    $children = 'post-archive';
}

get_header();

primeraObjectPrefix_Module::display( 'site', array(
    'children' => $children,
) );

get_footer();
