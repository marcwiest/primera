<?php

get_header();

if ( is_home() || is_post_type_archive() || is_archive() || is_search() ) {

    echo '<main class="primera-content primera-content--archive">';

        while ( have_posts() ) { the_post();
            Primera_Module::display( 'post-teaser' );
        }

        Primera_Module::display( 'pagination' );

    echo '</main>';

}
else {

    echo '<main class="primera-content primera-content--singular">';

        while ( have_posts() ) { the_post();
            Primera_Module::display( 'post-full' );
        }

        Primera_Module::display( 'related-entries' );

        comments_template();

    echo '</main>';

}

dynamic_sidebar( 'primera_primary' );

get_footer();
