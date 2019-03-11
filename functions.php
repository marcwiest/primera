<?php

require_once get_parent_theme_file_path( 'vendor/autoload.php' );

$app_dir = get_template_directory() . '/app/';

require_once $app_dir . 'Theme.php';
require_once $app_dir . 'Model.php';
require_once $app_dir . 'Twig.php';

use primeraPhpNamespace\Theme;
use primeraPhpNamespace\Model;
use primeraPhpNamespace\Twig;

Theme::init();
Model::init();
Twig::init();
