<?php

primeraObjectPrefix_Module::defaults( $data, array(
    'mid_size' => 1,
    'prev_text' => esc_html_x( 'Previous', 'Pagination prev text', 'primeraTextDomain' ),
    'next_text' => esc_html_x( 'Next', 'Pagination next text', 'primeraTextDomain' ),
    'screen_reader_text' => esc_html_x( 'Posts navigation', 'Pagination screen-reader text', 'primeraTextDomain' ),
) );

?>

<div class="primeraCssPrefix-pagination primeraCssPrefix-pagination-archive">

    <?php the_posts_pagination( $data ); ?>

</div>
