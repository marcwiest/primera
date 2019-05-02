<?php

// NOTE: Allows use of unprefixed functions.
namespace primeraPhpNamespace;

// require_once get_parent_theme_file_path( 'config/app.php' );

require_once get_parent_theme_file_path( 'vendor/autoload.php' );

$app_dir = get_template_directory() . '/app/';

require_once $app_dir . 'Theme.php';
require_once $app_dir . 'Admin.php';
require_once $app_dir . 'Model.php';
require_once $app_dir . 'Twig.php';

use primeraPhpNamespace\Theme;
use primeraPhpNamespace\Admin;
use primeraPhpNamespace\Model;
use primeraPhpNamespace\Twig;

Theme::init();
Admin::init();
Model::init();
Twig::init();
