<?php

primeraObjectPrefix_Module::defaults( $data, array(
    'title'     => get_bloginfo( 'name' ),
    'title_tag' => is_home() ? 'h1' : 'strong',
    'home_url'  => esc_url( home_url('/') ),
) );

?>

<header class="primeraCssPrefix-header" role="banner">

    <div class="primeraCssPrefix-brand">
        <?php echo "<$data->title_tag class='primeraCssPrefix-brand-title'><a href='$data->home_url' rel='home'>$data->title</a></$data->title_tag>"; ?>
	</div>

    <?php primeraObjectPrefix_Module::display( 'nav-menu' ); ?>

</header>
