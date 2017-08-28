<?php

get_header();

while( have_posts() ) {
    the_post();
    echo '<article class="'.join( ' ', get_post_class() ).'">';
    echo '<h2>'.get_the_title().'</h2>';
    echo '<div>'.get_the_content().'</div>';
    echo '</article>';
}

if ( is_active_sidebar( 'primary' ) ) {
	echo '<div>';
	dynamic_sidebar( 'primary' );
	echo '</div>';
}

get_footer();
