
<header class="primera-header primera-header-primary" role="banner">
<div class="container">
    <div class="row">

		<div class="col">

            <h1 class="primera-brand">
				<?php bloginfo('name'); ?>
			</h1>

        </div>

		<div class="col">

            <nav class="primera-primary-menu" role="navigation">
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
