<?php

primeraPhpNamespace_Module::defaults( $data, array(
    'theme_location' => 'primary',
    'depth'          => 0,
    'container'      => false,
    'fallback_cb'    => false,
    'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
) );

?>

<nav class="primeraCssPrefix-menu primeraCssPrefix-menu--<?php echo $data->theme_location; ?>" role="navigation">

    <?php wp_nav_menu( $data ); ?>

</nav>
