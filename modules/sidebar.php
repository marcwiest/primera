<?php

primeraObjectPrefix_Module::defaults( $data, array(
    'sidebar_id' => 'primary',
) );

?>

<aside class="primeraCssPrefix-sidebar primeraCssPrefix-sidebar--<?php echo $data->sidebar_id; ?>">
    <div class="primeraCssPrefix-sidebar-inner">

        <?php dynamic_sidebar( $data->sidebar_id ); ?>

    </div>
</aside>
