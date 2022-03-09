<?php

/**
 * Fired during plugin activation
 *
 * @link       http://tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 * @subpackage Tp_Product_Description_In_Loop_For_Woocommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 * @subpackage Tp_Product_Description_In_Loop_For_Woocommerce/includes
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Product_Description_In_Loop_For_Woocommerce_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		add_option( 'tppdil_disable_description_in_loop', 0 );
		add_option( 'tppdil_disable_description_in_mobile', 0 );
		add_option( 'tppdil_description_priority', 10 );
		add_option( 'tppdil_description_position', 'woocommerce_after_shop_loop_item_title' );
		add_option( 'tppdil_show_product_short_description', 1 );
		add_option( 'tppdil_show_product_description', 0 );
		add_option( 'tppdil_exclude_description_from_related', 0 );
		add_option( 'tppdil_exclude_description_from_up_sells', 0 );
		add_option( 'tppdil_exclude_description_from_shop', 0 );
		add_option( 'tppdil_limit_description', 0 );
		add_option( 'tppdil_limit_description_len', 20 );
		add_option( 'tppdil_description_color', '#000' );
		add_option( 'tppdil_description_font_size', 12 );
		add_option( 'tppdil_description_text_align', 'left' );
		add_option( 'tppdil_description_font_weight', 'normal' );
		add_option( 'tppdil_tooltip_background', '#EEEEEE' );
		add_option( 'tppdil_tooltip_color', '#444444' );
		add_option( 'tppdil_tooltip_position', 'top' );
	}

}
