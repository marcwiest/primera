<?php

define( 'DEV_NAME', 'Marc Wiest' );
define( 'DEV_EMAIL', 'marc@marcwiest.com' );

$inc_dir = get_template_directory() . '/includes/';

require_once $inc_dir . 'class.loader.php';
require_once $inc_dir . 'class.theme.php';
require_once $inc_dir . 'class.ajax.php';
require_once $inc_dir . 'class.rest.php';
require_once $inc_dir . 'class.mail.php';

if ( ! primeraObjectPrefix_Loader::missing_dependencies() ) {

    primeraObjectPrefix_Theme::init();
    primeraObjectPrefix_AJAX::init();
    primeraObjectPrefix_REST::init();
    primeraObjectPrefix_Mail::init();
}
