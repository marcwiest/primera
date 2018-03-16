<?php

Primera_Module::defaults( $data, array(
    'amount' => 3,
) );

?>

<div class="primera-related-entries">
    <?php
    if ( $tags = wp_get_post_tags( get_the_ID() ) ) {

        $tag_ids = array();
        foreach( $tags as $tag ) {
            $tag_ids[] = $tag->term_id;
        }

        $args = array(
            'tag__in'             => $tag_ids,
            'post__not_in'        => array( get_the_ID() ),
            'posts_per_page'      => $data->amount,
            'ignore_sticky_posts' => 1,
        );

        $query = new wp_query( $args );

        while( $query->have_posts() ) { $query->the_post();
            ?>
            <div class="primera-related-entry">

                <a href="<?php echo esc_url(the_permalink()); ?>" rel="bookmark">
                    <?php if ( has_post_thumbnail() ) the_post_thumbnail('post-thumbnail'); ?>
                    <h4><?php the_title(); ?></h4>
                </a>

            </div>
            <?php
        }
    }
    ?>
</div>
