<?php

Primera_Module::defaults( $data, array(
    'title'     => get_bloginfo( 'name' ),
    'title_tag' => is_home() ? 'h1' : 'strong',
    'home_url'  => esc_url( home_url('/') ),
) );

?>

<header class="primera-header primera-header--primary" role="banner">

    <div class="primera-brand">
        <?php echo "<$data->title_tag class='primera-brand-title'><a href='$data->home_url' rel='home'>$data->title</a></$data->title_tag>"; ?>
	</div>

    <nav class="primera-menu primera-menu--primary" role="navigation">
	<?php
		wp_nav_menu( array(
			'theme_location' => 'primera_primary',
			'depth'          => 0,
			'container'      => false,
			'fallback_cb'    => false,
			'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		) );
	?>
    </nav>

</header>