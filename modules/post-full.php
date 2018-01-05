<?php

Primera_Module::defaults( $data, array() );

?>

<article id="post-<?php the_ID(); ?>" class="<?php post_class('primera-entry'); ?>" role="article">

    <header class="primera-entry-header">

        <?php the_post_thumbnail( 'post-thumbnail', array(
            'class' => 'primera-entry-thumbnail',
        ) ); ?>

        <h1 class="primera-entry-title">
            <?php the_title(); ?>
        </h1>

        <time class="primera-entry-date">
            <?php the_date(); ?>
        </time>

    </header>

    <section class="primera-entry-content">
        <?php

            the_content();

            wp_link_pages( array(
                'before'           => '<div class="primera-link-pages">'.esc_html_x( 'Pages:', 'Link pages', 'primera' ),
                'after'            => '</div>',
                'link_before'      => '',
                'link_after'       => '',
                'next_or_number'   => 'number',
                'separator'        => ' ',
                'nextpagelink'     => esc_html_x( 'Next Page', 'Link pages', 'primera' ),
                'previouspagelink' => esc_html_x( 'Previous Page', 'Link pages', 'primera' ),
                'pagelink'         => '%',
                'echo'             => 1,
            ) );

        ?>
    </section>

    <footer class="primera-entry-footer">
        <?php Primera_Module::display( 'author-info' ); ?>
    </footer>

</article>
