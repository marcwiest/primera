<?php

// primeraObjectPrefix_Module::defaults( $data, array() );

echo '<div class="primeraCssPrefix-site">';
echo '<div class="primeraCssPrefix-site-inner">';

primeraObjectPrefix_Module::display( 'header' );

primeraObjectPrefix_Module::display( 'main', $data );

primeraObjectPrefix_Module::display( 'sidebar' );

primeraObjectPrefix_Module::display( 'footer' );

echo '</div>'; // end of .primeraCssPrefix-site-inner
echo '</div>'; // end of .primeraCssPrefix-site

primeraObjectPrefix_Module::display( 'sidebar', array(
    'sidebar_id' => 'offcanvas',
) );
