<?php

get_header();

Primera_Module::display( 'header' );

if ( is_home() || is_post_type_archive() || is_archive() || is_search() ) {

    echo '<main class="primera-content primera-content--archive" role="main">';

        while ( have_posts() ) {
            the_post();
            Primera_Module::display( 'post-teaser' );
        }

        Primera_Module::display( 'pagination' );

    echo '</main>';

}
else {

    echo '<main class="primera-content primera-content--singular" role="main">';

        while ( have_posts() ) {
            the_post();
            Primera_Module::display( 'post-full' );
        }

        Primera_Module::display( 'related-entries' );

        comments_template();

    echo '</main>';

}

echo '<aside class="primera-sidebar">';
dynamic_sidebar( 'primera_primary' );
echo '</aside>';

Primera_Module::display( 'footer' );

get_footer();
