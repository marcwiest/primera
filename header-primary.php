
<header class="primera-header primera-header-primary" role="banner">
<div class="container">
    <div class="row">

		<div class="col">

            <div class="primera-brand">
                <?php
                    $title     = get_bloginfo( 'name' );
                    $title_tag = is_home() ? 'h1' : 'strong';
                    $home_url  = esc_url( home_url('/') );
                    echo "<$title_tag class='primera-brand-title'><a href='$home_url' rel='home'>$title</a></$title_tag>";
                ?>
			</div>

        </div>

		<div class="col">

            <nav class="primera-menu primera-menu-primary" role="navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'primera_primary_menu',
					'depth'          => 0,
					'container'      => false,
					'fallback_cb'    => false,
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				) );
			?>
            </nav>

		</div>

	</div>
</div>
</header>
