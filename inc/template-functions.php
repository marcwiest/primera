<?php /*
This file holds functions that are ment to be hooked.
*/


if ( ! function_exists('primera_site_tag_open') ) :
/**
* Site tag open.
*/
function primera_site_tag_open()
{
    echo '<div id="primera-site">';
}
endif;



if ( ! function_exists('primera_site_tag_close') ) :
/**
* Site tag close.
*/
function primera_site_tag_close()
{
    echo '</div>';
}
endif;



if ( ! function_exists('primera_site_canvas_tag_open') ) :
/**
* Site canvas tag open.
*/
function primera_site_canvas_tag_open()
{
    echo '<div id="primera-site-canvas">';
}
endif;



if ( ! function_exists('primera_site_canvas_tag_close') ) :
/**
* Site canvas tag close.
*/
function primera_site_canvas_tag_close()
{
    echo '</div>';
}
endif;



if ( ! function_exists('primera_main_content_tag_open') ) :
/**
* Main content tag open.
*/
function primera_main_content_tag_open()
{
    echo '<div class="primera-main-content">';
}
endif;



if ( ! function_exists('primera_main_content_tag_close') ) :
/**
* Main content tag close.
*/
function primera_main_content_tag_close()
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



if ( ! function_exists('primera_entries') ) :
/**
* Display entries.
*/
function primera_entries()
{
    ?>
    <main class="primera-entries">
    <?php while( have_posts() ) : the_post(); ?>
        <article class="<?php post_class('entry'); ?>">
            <h1><?php the_title(); ?></h1>
            <div><?php
                the_content();
                wp_link_pages( array(
                    'before'           => '<div class="primera-link-pages">',
                    'after'            => '</div>',
                    'link_before'      => '',
                    'link_after'       => '',
                    'next_or_number'   => 'number',
                    'separator'        => ' ',
                    'nextpagelink'     => esc_html__( 'Next', 'portal' ),
                    'previouspagelink' => esc_html__( 'Previous', 'portal' ),
                    'pagelink'         => '%',
                    'echo'             => 1,
                ) );
            ?></div>
        </article>
    <?php endwhile; ?>
    </main>
    <?php
}
endif;



if ( ! function_exists('primera_sidebar') ) :
/**
* Display sidebar.
*/
function primera_sidebar()
{
    if ( is_active_sidebar( 'primary' ) ) :
        ?>
        <div class="primera-sidebar">
            <?php dynamic_sidebar( 'primary' ); ?>
        </div>
        <?php
    endif;
}
endif;



if ( ! function_exists('primera_colophon') ) :
/**
* Display colophon.
*/
function primera_colophon()
{
    $year = date('Y');
    $site = get_bloginfo('name');

    echo "<small>&copy; $year $site, all rights reserved.</small>";
}
endif;
