<?php

require_once get_parent_theme_file_path( 'vendor/autoload.php' );

$app_dir = get_template_directory() . '/app/';

// require_once $app_dir . 'class.script.php';
require_once $app_dir . 'class.theme.php';
require_once $app_dir . 'class.controller.php';
require_once $app_dir . 'class.twig.php';
require_once $app_dir . 'class.ajax.php';
require_once $app_dir . 'class.rest.php';
require_once $app_dir . 'class.mail.php';

// use primeraPhpNamespace\Script;
use primeraPhpNamespace\Theme;
use primeraPhpNamespace\Controller;
use primeraPhpNamespace\Twig;
use primeraPhpNamespace\AJAX;
use primeraPhpNamespace\REST;
use primeraPhpNamespace\Mail;

// Script::init();
Theme::init();
Controller::init();
Twig::init();
AJAX::init();
REST::init();
Mail::init();
