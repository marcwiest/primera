<?php

primeraObjectPrefix_Module::defaults( $data, array(
    'css_class' => '',
) );

$class = $data->css_class ? ' '.$data->css_class : '';

?>

<main class='primeraCssPrefix-main<?php echo $class; ?>' role='main'>

    <?php primeraObjectPrefix_Module::display_children( $data ); ?>

</main>
