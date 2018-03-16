<?php

get_header();

primeraObjectPrefix_Module::display( 'header' );

if ( is_home() || is_post_type_archive() || is_archive() || is_search() ) {

    echo '<main class="primeraCssPrefix-content primeraCssPrefix-content--archive" role="main">';

        while ( have_posts() ) {
            the_post();
            primeraObjectPrefix_Module::display( 'post-teaser' );
        }

        primeraObjectPrefix_Module::display( 'pagination' );

    echo '</main>';

}
else {

    echo '<main class="primeraCssPrefix-content primeraCssPrefix-content--singular" role="main">';

        while ( have_posts() ) {
            the_post();
            primeraObjectPrefix_Module::display( 'post-full' );
        }

        primeraObjectPrefix_Module::display( 'related-entries' );

        comments_template();

    echo '</main>';

}

echo '<aside class="primeraCssPrefix-sidebar">';
dynamic_sidebar( 'primeraFunctionPrefix_primary' );
echo '</aside>';

primeraObjectPrefix_Module::display( 'footer' );

get_footer();
