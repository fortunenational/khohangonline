<?php namespace oshwoo; ?>

<!-- donate -->
<?php
# generate an unique ID based on the including parent
add_meta_box('oshwoo_donate', __('Support', 'order-status-history-for-woocommerce'), function() {
    $donation_link = function(){ return '<a href="https://paypal.me/alx359" target="_blank">paypal.me/alx359</a>'; };
    printf( /* translators: 1: plugin name 2: paypal donation link */
        __('If you like the %1s plugin, a donation for support and further development is much appreciated. ' .
           'Help us over this link: %2s', 'order-status-history-for-woocommerce'), 
           '<b>'.namespace\NAME.'</b>', 
           $donation_link() );
});
?>
<!-- /donate -->
