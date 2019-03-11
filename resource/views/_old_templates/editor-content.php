<?php

primeraPhpNamespace_Module::defaults( $data, array(
    'css_class' => '',
    'excerpt' => false,
    'link_pages_args' => array(
        'before'           => '<div class="primeraCssPrefix-link-pages">'.esc_html_x( 'Pages:', 'Link pages', 'primeraTextDomain' ),
        'after'            => '</div>',
        'link_before'      => '',
        'link_after'       => '',
        'next_or_number'   => 'number',
        'separator'        => ' ',
        'nextpagelink'     => esc_html_x( 'Next Page', 'Link pages', 'primeraTextDomain' ),
        'previouspagelink' => esc_html_x( 'Previous Page', 'Link pages', 'primeraTextDomain' ),
        'pagelink'         => '%',
        'echo'             => 1,
    ),
) );

$class = $data->excerpt ? " primeraCssPrefix-editor-content--is-excerpt" : '';
$class .= $data->css_class ? ' '.$data->css_class : '';

?>

<div class="primeraCssPrefix-editor-content<?php echo $class; ?>">
    <?php
        if ( $data->excerpt ) {

            the_excerpt();
        }
        else {

            the_content();
            wp_link_pages( $data->link_pages_args );
        }
    ?>
</div>
