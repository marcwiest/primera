<?php

get_header();

while( have_posts() ) {
    the_post();
    ?>
    <article <?php post_class(); ?>>
        <h2><?php the_title(); ?></h2>
        <div><?php the_content(); ?></div>
    </article>
    <?php
}

if ( is_active_sidebar( 'primary' ) ) {
	echo '<div>';
	dynamic_sidebar( 'primary' );
	echo '</div>';
}

get_footer();
