<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'tppdil_disable_description_in_loop' );
delete_option( 'tppdil_disable_description_in_mobile' );
delete_option( 'tppdil_description_priority' );
delete_option( 'tppdil_description_position' );
delete_option( 'tppdil_exclude_description_from_related' );
delete_option( 'tppdil_exclude_description_from_up_sells' );
delete_option( 'tppdil_exclude_description_from_shop' );
delete_option( 'tppdil_description_color' );
delete_option( 'tppdil_description_font_size' );
delete_option( 'tppdil_description_text_align' );
delete_option( 'tppdil_description_font_weight' );
delete_option( 'tppdil_show_product_short_description' );
delete_option( 'tppdil_show_product_description' );
delete_option( 'tppdil_tooltip_background' );
delete_option( 'tppdil_tooltip_color' );
delete_option( 'tppdil_tooltip_position' );
delete_option( 'tppdil_exclude_description_from_categories' );
delete_option( 'tppdil_exclude_description_from_tags' );