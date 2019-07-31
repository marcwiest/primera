<?php

add_filter('primera/bladeone', function($bladeone) {

    $bladeone->directive('svg', function($svgName) {
        $svgName = trim($svgName, "'\"");
        return "<?php include get_theme_file_path('public/img/{$svgName}.svg'); ?>";
    });
});

