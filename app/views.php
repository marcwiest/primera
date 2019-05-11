<?php
// Helps looking for blade templates.
// Illuminate helper functions are available.

namespace App;

use Windwalker\Renderer\BladeRenderer;

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates( $templates )
{
    $paths = apply_filters('primera/filter_templates/paths', [
        'views',
        'source/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
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

collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
// function locate_template($templates)
// {
//     return \locate_template(filter_templates($templates));
// }

/**
 * Render page using Blade
 */
add_filter( 'template_include', function( $template ) {

    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });

    $data = collect(get_body_class())->reduce( function( $data, $class ) use ( $template ) {
        return apply_filters( "primera/template/{$class}/data", $data, $template );
    }, []);

    if ( $template ) {

        $config   = [ 'cache_path' => __DIR__ . '/cache' ];
        $renderer = new BladeRenderer( get_theme_file_path( 'source/views' ), $config );

        // echo template($template, $data);
        echo $renderer->render( 'index', $data );

        // Returns the path to the index, which is intentionally empty.
        return get_stylesheet_directory().'/index.php';
    }

    return $template;

}, PHP_INT_MAX);
