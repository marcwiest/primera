<?php

use App\Models\Model;

echo('<pre style=overflow-x:auto;font-size:12px><code>'.print_r(Model::get_utility_data(),true).'</code></pre>');

// use primeraPhpNamespace\Controller;
// use primeraPhpNamespace\Twig;

// // wp_enqueue_style( 'page' );
// // wp_enqueue_script( 'page' );

// $context = array_merge(
//     Controller::get_utility_data(),
//     Controller::get_page_data()
// );

// get_header();

// Twig::display( 'index', $context );

// get_footer();

// if ( is_front_page() ) {
//     View::render( 'page' );
// }
// elseif ( is_singular( 'book' ) ) {
//     View::render( 'book' );
// }
// elseif ( is_page_template( 'tmpl-books-index.php' ) ) {
//     View::render( 'books' );
// }
// elseif ( is_single() ) {
//     View::render( 'post' );
// }
// elseif ( is_home() || is_archive() || is_tax() || is_search() ) {
//     View::render( 'posts' );
// }
// else {
//     View::render( 'page' );
// }
