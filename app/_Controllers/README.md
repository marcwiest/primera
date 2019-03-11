
# Notes reg. a possibility

The idea here is that, this folder may hold all WP template files instead of having them inside the root directory.

The filter that will be utilized to make this change happen is found inside `wp-include/template.php` and called via `wp-include/template-loader.php`:

```
/**
 * Filters the list of template filenames that are searched for when retrieving a template to use.
 *
 * The last element in the array should always be the fallback template for this query type.
 *
 * Possible values for "$type" include: 'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date',
 * 'embed', 'home', 'frontpage', 'page', 'paged', 'search', 'single', 'singular', and 'attachment'.
 *
 * @since 4.7.0
 *
 * @param array $templates A list of template candidates, in descending order of priority.
 */
$templates = apply_filters( "{$type}_template_hierarchy", $templates );
```

The role of one of these Controllers is similar to the current `index.php`, just provide data to and render the Twig template.
