<?php

// primeraPhpNamespace_Module::defaults( $data, array() );

while ( have_posts() ) : the_post();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class("primeraCssPrefix-entry"); ?> role="article">

    <header class="primeraCssPrefix-entry-header">

        <?php the_post_thumbnail( 'post-thumbnail', array(
            'class' => 'primeraCssPrefix-entry-thumbnail',
        ) ); ?>

        <h2 class="primeraCssPrefix-entry-title">
            <?php the_title(); ?>
        </h2>

        <time class="primeraCssPrefix-entry-date">
            <?php the_date(); ?>
        </time>

    </header>

    <?php primeraPhpNamespace_Module::display( 'editor-content', array(
        'css_class' => 'primeraCssPrefix-entry-content',
    ) ); ?>

</article>
<?php

endwhile;

primeraPhpNamespace_Module::display( 'related-entries' );

comments_template();
