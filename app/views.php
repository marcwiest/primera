<?php
// Looks for, and renders blade templates.

namespace App;

use eftec\bladeone\BladeOne;
use Illuminate\Support\Collection;

/**
* Filter templates to locate custom templates.
* @param string|string[] $templates Possible template files
* @return array
*/
function _filterTemplates( $templates )
{
    $paths = \apply_filters('primera/filterTemplates/paths', [
        'views',
        'source/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return \collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}
\collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map( function( $type ) {
    \add_filter( "{$type}_template_hierarchy", __NAMESPACE__ . '\\_filterTemplates' );
});

/**
* Filter template include to render custom templates.
*/
function _renderTemplates( $template ) {

    // collect(['get_header','wp_head'])->each(function ($tag) {
    //     ob_start();
    //     do_action($tag);
    //     $output = ob_get_clean();
    //     remove_all_actions($tag);
    //     add_action($tag, function () use ($output) {
    //         echo $output;
    //     });
    // });

    $data = \collect(get_body_class())->reduce( function( $data, $class ) use ( $template ) {
        return \apply_filters( "primera/template/{$class}/data", $data, $template );
    }, []);

    if ( $template ) {

        /** Remove .blade.php/.blade/.php from template and gets it's basename. */
        $template = basename(preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template)));

        // NOTE: More modes can be found within BladeOne.
        if ( ! empty(WP_DEBUG) ) {
            $bladeoneMode = BladeOne::MODE_DEBUG;
        } else {
            $bladeoneMode = BladeOne::MODE_AUTO;
        }

        $viewsDir = \get_theme_file_path('source/views/');
        $cacheDir = \trailingslashit( \wp_get_upload_dir()['basedir'] ).'blade-cache';
        $bladeone = new BladeOne( $viewsDir, $cacheDir, $bladeoneMode );

        echo $bladeone->run( $template, $data );

        // Always returns the path to the theme's empty index file.
        return \get_theme_file_path('source/index.php');
    }

    return $template;
}
\add_filter( 'template_include', __NAMESPACE__ . '\\_renderTemplates', PHP_INT_MAX );

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
// add_action('the_post', function ($post) {
//     sage('blade')->share('post', $post);
// });
