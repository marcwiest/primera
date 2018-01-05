<?php /*
Template Name: Blank Page
Template Post Type: page

If selected, this template loads in place of the index.php file.
https://developer.wordpress.org/themes/template-files-section/
*/

get_header();

while ( have_posts() ) {
    the_post();
    the_content();
}

get_footer();
