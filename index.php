<?php

get_header();
get_header( 'primary' );

?>

<div class="primera-main">
<div class="container">
    <div class="row">

        <div class="col col-9">

            <?php
                if ( is_home() || is_post_type_archive() || is_archive() || is_search() ) {

                    get_template_part( 'content', 'archive' );
                }
                else {

                    get_template_part( 'content', 'singular' );
                }
            ?>

        </div>

        <div class="col col-3">

            <?php dynamic_sidebar( 'primera_content_sidebar' ); ?>

        </div>

    </div>
</div>
</div>

<?php

get_footer( 'primary' );
get_footer();
