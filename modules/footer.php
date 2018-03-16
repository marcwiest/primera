<?php
// primeraObjectPrefix_Module::defaults( $data, array() );
?>

<footer class="primeraCssPrefix-footer primeraCssPrefix-footer--primary">

    <small class="primeraCssPrefix-colophon" role="contentinfo">
        <?php
            /* translators: &copy;: copyright symbol, %1$s: current year, %2$s: site name */
            $colophon = esc_html_x( '&copy; %1$s %2$s, all rights reserved.', 'Copyright message', 'primeraTextDomain' );
            printf(
                apply_filters( 'primeraFunctionPrefix_colophon_text', $colophon ),
                date_i18n( 'Y' ),
                get_bloginfo( 'name' )
            );
        ?>
    </small>

    <nav class="primeraCssPrefix-menu primeraCssPrefix-menu--colophon" role="navigation">
        <?php
            wp_nav_menu( array(
            	'theme_location' => 'primeraFunctionPrefix_colophon',
            	'depth'          => 1,
            	'container'      => false,
            	'fallback_cb'    => false,
            	'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ) );
        ?>
    </nav>

</footer>
