
<main class="primera-content primera-content-archive">

    <div class="primera-page-header">
        <?php
            the_archive_title( '<h1 class="primera-archive-title">', '</h1>' );
            the_archive_description( '<div class="primera-archive-description">', '</div>' );
        ?>
    </div>

    <?php while( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" class="<?php post_class('primera-entry'); ?>" role="article">

            <header class="primera-entry-header">

                <?php the_post_thumbnail(); ?>

                <h2 class="primera-entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
                </h2>

                <time class="primera-entry-date">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_date(); ?></a>
                </time>

            </header>

            <section class="primera-entry-content">
                <?php the_excerpt(); ?>
            </section>

            <footer class="primera-entry-footer">
            </footer>

        </article>

    <?php endwhile; ?>

    <div class="primera-pagination primera-pagination-archive">
        <?php the_posts_pagination(); ?>
    </div>

</main>
