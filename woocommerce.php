<?php

if ( is_product() ) {

    echo 'is_product';

}
elseif ( is_shop() || is_product_taxonomy() ) {

    echo 'is_shop || is_product_taxonomy';

}
elseif ( is_cart() ) {

    echo 'is_cart';

}
elseif ( is_checkout() ) {

    echo 'is_checkout';

}
elseif ( is_account_page() ) {

    echo 'is_account_page';

}
