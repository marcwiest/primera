<?php
// primeraObjectPrefix_Module::defaults( $data, array() );
?>

<article id="post-<?php the_ID(); ?>" class="<?php post_class('primeraCssPrefix-entry'); ?>" role="article">

    <header class="primeraCssPrefix-entry-header">

        <?php the_post_thumbnail( 'post-thumbnail', array(
            'class' => 'primeraCssPrefix-entry-thumbnail',
        ) ); ?>

        <h1 class="primeraCssPrefix-entry-title">
            <?php the_title(); ?>
        </h1>

        <time class="primeraCssPrefix-entry-date">
            <?php the_date(); ?>
        </time>

    </header>

    <section class="primeraCssPrefix-entry-content">
        <?php

            the_content();

            wp_link_pages( array(
                'before'           => '<div class="primeraCssPrefix-link-pages">'.esc_html_x( 'Pages:', 'Link pages', 'primeraTextDomain' ),
                'after'            => '</div>',
                'link_before'      => '',
                'link_after'       => '',
                'next_or_number'   => 'number',
                'separator'        => ' ',
                'nextpagelink'     => esc_html_x( 'Next Page', 'Link pages', 'primeraTextDomain' ),
                'previouspagelink' => esc_html_x( 'Previous Page', 'Link pages', 'primeraTextDomain' ),
                'pagelink'         => '%',
                'echo'             => 1,
            ) );

        ?>
    </section>

    <footer class="primeraCssPrefix-entry-footer">
        <?php primeraObjectPrefix_Module::display( 'author-info' ); ?>
    </footer>

</article>
