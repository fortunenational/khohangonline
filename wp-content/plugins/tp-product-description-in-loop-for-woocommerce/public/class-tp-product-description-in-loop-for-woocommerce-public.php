<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 * @subpackage Tp_Product_Description_In_Loop_For_Woocommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 * @subpackage Tp_Product_Description_In_Loop_For_Woocommerce/public
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Product_Description_In_Loop_For_Woocommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tp-product-description-in-loop-for-woocommerce-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tp-product-description-in-loop-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );

	}

	public function init_description_in_loop() {
		global $product;
		global $woocommerce_loop; //$woocommerce_loop['name'] -> up-sells , related
		//wp_dbug($woocommerce_loop);
		//wp_dbug($product);
		$disable = 0;

		//$description = get_post_meta( $product->get_id(), 'tppdil_description', true );
		//$disable     = get_post_meta( $product->get_id(), 'tppdil_single_disable', true );

		$disable_description = get_option('tppdil_disable_description_in_loop');
		$disable_description_in_mobile = get_option('tppdil_disable_description_in_mobile');

		$show_product_description = get_option('tppdil_show_product_description');
    	$show_product_short_description = get_option('tppdil_show_product_short_description');

		if($show_product_description || $show_product_short_description){
			if($show_product_description){
				$description = $product->get_description();
			}
			elseif($show_product_short_description){
				$description = $product->get_short_description();
			}
		}

		if($disable_description_in_mobile && wp_is_mobile()){
			$disable = 1;
		}

		if($description && !$disable && !$disable_description){
			echo '<div class="tppdil_description">'.$description.'</div>';
		}
	}

	public function init_custom_css() {
		
		$description_color       = get_option('tppdil_description_color');
		$description_background  = get_option('tppdil_description_background');
		$description_margin      = get_option('tppdil_description_margin');
		$description_font_size   = get_option('tppdil_description_font_size');
		$description_font_weight = get_option('tppdil_description_font_weight');
		$description_text_align  = get_option('tppdil_description_text_align');

		$tooltip_background      = get_option('tppdil_tooltip_background');
    	$tooltip_color           = get_option('tppdil_tooltip_color');
		$tooltip_position        = get_option('tppdil_tooltip_position');

		$description_background = ($description_background) ? $description_background : 'none';

		echo '<style>';

			echo '.tppdil_description{
				color: '.$description_color.';
				background: '.$description_background.';
				font-size: '.$description_font_size.'px;
				text-align: '.$description_text_align.';
				font-weight: '.$description_font_weight.';
			}';

			echo '.tppdil-tooltip .top, .tppdil-tooltip .right, .tppdil-tooltip .bottom, .tppdil-tooltip .left{
				color: '.$tooltip_color.';
				background: '.$tooltip_background.';
			}';

			echo '.tppdil-tooltip .top i::after, .tppdil-tooltip .right i::after, .tppdil-tooltip .bottom i::after, .tppdil-tooltip .left i::after{
				background: '.$tooltip_background.';
			}';

		echo '</style>';

	}

}
