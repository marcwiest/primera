<?php

// primeraObjectPrefix_Module::defaults( $data, array() );

$_post = get_post();

if ( empty($_post->post_author) ) {
    return;
}

$name = get_the_author_meta( 'display_name', $_post->post_author );
if ( empty( $name ) ) {
    $name = get_the_author_meta( 'nickname', $_post->post_author );
}

$bio = trim( nl2br( get_the_author_meta( 'user_description', $_post->post_author ) ) );

$_posts_url = esc_url( get_author_posts_url( get_the_author_meta( 'ID', $_post->post_author ) ) );

$avatar = get_avatar( get_the_author_meta( 'user_email', $_post->post_author ) , 90 );

$urls = array(
    esc_html__('Website','primeraTextDomain') => esc_url( trim( get_the_author_meta( 'url', $_post->post_author ) ) ),
);

$r = '';

$r .= '<div class="primeraCssPrefix-author-info">';

$r .= '<div class="primeraCssPrefix-author-id">';
$r .= $avatar;
$r .= "<a class='primeraCssPrefix-author-name' href='$_posts_url' rel='bookmark'>$name</a>";
$r .= '</div>';

if ( $bio ) {
    $r .= "<div class='primeraCssPrefix-author-bio'>$bio</div>";
}

$profiles = '';
foreach ( $urls as $title => $url ) {
    if ( $url ) {
        $class = sanitize_html_class( strtolower($title) );
        $profiles .= "<a class='$class' href='$url' target='_blank' rel='nofollow'>$title</a>";
    }
}

if ( $profiles ) {
    $r .= '<div class="primeraCssPrefix-author-links">';
    $r .= $profiles;
    $r .= '</div>';
}

$r .= '</div>';

echo $r;
