
<main class="primera-content primera-content-singular">

    <?php while( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" class="<?php post_class('primera-entry'); ?>" role="article">

            <header class="primera-entry-header">

                <?php the_post_thumbnail( 'post-thumbnail', array(
                    'class' => '',
                ) ); ?>

                <h1 class="primera-entry-title">
                    <?php the_title(); ?>
                </h1>

                <time class="primera-entry-date">
                    <?php the_date(); ?>
                </time>

            </header>

            <section class="primera-entry-content">
                <?php the_content(); ?>
                <?php
                    wp_link_pages( array(
                        'before'           => '<div class="primera-link-pages">'.esc_html_x( 'Pages:', 'Link pages.', 'primera' ),
                        'after'            => '</div>',
                        'link_before'      => '',
                        'link_after'       => '',
                        'next_or_number'   => 'number',
                        'separator'        => ' ',
                        'nextpagelink'     => esc_html_x( 'Next Page', 'Link pages.', 'primera' ),
                        'previouspagelink' => esc_html_x( 'Previous Page', 'Link pages.', 'primera' ),
                        'pagelink'         => '%',
                        'echo'             => 1,
                    ) );
                ?>
            </section>

            <footer class="primera-entry-footer">
                <?php primera_author_info(); ?>
            </footer>

        </article>

        <?php
            if ( shortcode_exists('jetpack-related-posts') ) {
                echo do_shortcode( '[jetpack-related-posts]' );
            }
            else {
                primera_related_entries( 3 );
            }
        ?>

    <?php endwhile; ?>

    <?php comments_template(); ?>

</main>
