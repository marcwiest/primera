<?php /*
This file holds functions that are ment to be hooked.
*/


if ( ! function_exists('primera_site_wrapper_tag_open') ) :
/**
* Site wrapper tag open.
*/
function primera_site_wrapper_tag_open()
{
    echo '<div id="primera-site-wrapper">';
}
endif;



if ( ! function_exists('primera_site_wrapper_tag_close') ) :
/**
* Site wrapper tag close.
*/
function primera_site_wrapper_tag_close()
{
    echo '</div>';
}
endif;



if ( ! function_exists('primera_site_tag_open') ) :
/**
* Site wrapper tag open.
*/
function primera_site_tag_open()
{
    echo '<div id="primera-site">';
}
endif;



if ( ! function_exists('primera_site_tag_close') ) :
/**
* Site wrapper tag close.
*/
function primera_site_tag_close()
{
    echo '</div>';
}
endif;



if ( ! function_exists('primera_header') ) :
/**
* Display header.
*/
function primera_header()
{
    echo '<h1>'.get_bloginfo('name').'</h1>';

    wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    ) );
}
endif;



if ( ! function_exists('primera_index') ) :
/**
* Display index.
*/
function primera_index()
{
    echo '<main id="primera-site-content">';

    ?><div class="content"><?php
    while( have_posts() ) : the_post();
        ?>
        <article class="<?php post_class('entry'); ?>">
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
        </article>
        <?php
    endwhile;
    ?></div><?php

    if ( is_active_sidebar( 'primary' ) ) :
        ?>
        <div class="sidebar">
            <?php dynamic_sidebar( 'primary' ); ?>
        </div>
        <?php
    endif;

    echo '</main>';
}
endif;



if ( ! function_exists('primera_footer') ) :
/**
* Display footer.
*/
function primera_footer()
{
    $year = date('Y');
    $site = get_bloginfo('name');

    echo "<small>&copy; $year $site, all rights reserved.</small>";
}
endif;
