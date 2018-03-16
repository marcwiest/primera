<?php

primeraObjectPrefix_Module::defaults( $data, array(
    'title'     => get_bloginfo( 'name' ),
    'title_tag' => is_home() ? 'h1' : 'strong',
    'home_url'  => esc_url( home_url('/') ),
) );

?>

<header class="primeraCssPrefix-header primeraCssPrefix-header--primary" role="banner">

    <div class="primeraCssPrefix-brand">
        <?php echo "<$data->title_tag class='primeraCssPrefix-brand-title'><a href='$data->home_url' rel='home'>$data->title</a></$data->title_tag>"; ?>
	</div>

    <nav class="primeraCssPrefix-menu primeraCssPrefix-menu--primary" role="navigation">
	<?php
		wp_nav_menu( array(
			'theme_location' => 'primeraFunctionPrefix_primary',
			'depth'          => 0,
			'container'      => false,
			'fallback_cb'    => false,
			'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		) );
	?>
    </nav>

</header>
