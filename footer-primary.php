
<footer class="primera-footer primera-footer-primary">
<div class="container">
    <div class="row">

        <div class="col">
            <small class="primera-colophon" role="contentinfo">
                <?php
                    /* translators: &copy;: copyright symbol, %1$s: current year, %2$s: site name */
                    $colophon = esc_html_x( '&copy; %1$s %2$s, all rights reserved.', 'Copyright message.', 'primera' );
                    printf(
                        apply_filters( 'primera_colophon_text', $colophon ),
                        date_i18n( 'Y' ),
                        get_bloginfo( 'name' )
                    );
                ?>
            </small>
            <nav class="primera-menu primera-menu-colophon" role="navigation">
                <?php
                    wp_nav_menu( array(
                    	'theme_location' => 'primera_colophon_menu',
                    	'depth'          => 1,
                    	'container'      => false,
                    	'fallback_cb'    => false,
                    	'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ) );
                ?>
            </nav>
        </div>

    </div>
</div>
</footer>
