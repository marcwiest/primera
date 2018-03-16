<?php
// Primera_Module::defaults( $data, array() );
?>

<article id="post-<?php the_ID(); ?>" class="<?php post_class('primera-entry'); ?>" role="article">

    <header class="primera-entry-header">

        <?php the_post_thumbnail(); ?>

        <h2 class="primera-entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h2>

        <time class="primera-entry-date">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                <?php the_date(); ?>
            </a>
        </time>

    </header>

    <section class="primera-entry-content">
        <?php the_excerpt(); ?>
    </section>

    <footer class="primera-entry-footer">
    </footer>

</article>
