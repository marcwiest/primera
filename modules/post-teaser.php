<?php
// primeraObjectPrefix_Module::defaults( $data, array() );
?>

<article id="post-<?php the_ID(); ?>" class="<?php post_class('primeraCssPrefix-entry'); ?>" role="article">

    <header class="primeraCssPrefix-entry-header">

        <?php the_post_thumbnail(); ?>

        <h2 class="primeraCssPrefix-entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h2>

        <time class="primeraCssPrefix-entry-date">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                <?php the_date(); ?>
            </a>
        </time>

    </header>

    <section class="primeraCssPrefix-entry-content">
        <?php the_excerpt(); ?>
    </section>

    <footer class="primeraCssPrefix-entry-footer">
    </footer>

</article>
