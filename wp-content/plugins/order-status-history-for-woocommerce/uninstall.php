<?php
/**
 * Uninstaller
 *
 * @package osh
 */

# no direct page access
defined( 'ABSPATH' ) || exit;

# Delete from wp_usermeta the aggregated meta-key from each Customer metadata
$user_ids = get_users( array(
	'blog_id' => '',
	'fields'  => 'ID',
) );
foreach( $user_ids as $user_id ) {
	delete_user_meta( $user_id, 'oshwoo_aggregated' );
}
#
# Delete from wp_usermeta the aggregated meta-key from each Order metadata
$order_ids = get_posts(array(
    'numberposts' => -1,
    'post_type'   => array('shop_order'),
));
foreach( $order_ids as $order_id ) {
	delete_post_meta( $order_id, 'oshwoo_aggregated' );
}
#
# Wipe wp_options from all custom settings (like color codes, etc.) stored by this plugin
foreach ( wp_load_alloptions() as $option => $value ) {
    if ( strpos( $option, 'oshwoo_' ) === 0 ) {
        delete_option( $option );
    }
}

/* bye! */
