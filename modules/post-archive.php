<?php

// primeraObjectPrefix_Module::defaults( $data, array() );

while ( have_posts() ) : the_post();

?>
<article id="post-<?php the_ID(); ?>" class="<?php post_class("primeraCssPrefix-entry"); ?>" role="article">

    <header class="primeraCssPrefix-entry-header">

        <?php the_post_thumbnail( 'post-thumbnail', array(
            'class' => 'primeraCssPrefix-entry-thumbnail',
        ) ); ?>

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

    <?php primeraObjectPrefix_Module::display( 'editor-content', array(
        'css_class' => 'primeraCssPrefix-entry-content',
        'excerpt' => true,
    ) ); ?>

    <footer class="primeraCssPrefix-entry-footer">
        <?php primeraObjectPrefix_Module::display( 'author-info' ); ?>
    </footer>

</article>
<?php

endwhile;

primeraObjectPrefix_Module::display( 'pagination' );
