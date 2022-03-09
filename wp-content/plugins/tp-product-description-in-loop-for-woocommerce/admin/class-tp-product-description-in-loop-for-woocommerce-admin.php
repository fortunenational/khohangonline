<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://tplugins.com/shop
 * @since      1.0.0
 *
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 * @subpackage Tp_Product_Description_In_Loop_For_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tp_Product_Description_In_Loop_For_Woocommerce
 * @subpackage Tp_Product_Description_In_Loop_For_Woocommerce/admin
 * @author     TP Plugins <pluginstp@gmail.com>
 */
class Tp_Product_Description_In_Loop_For_Woocommerce_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'minicolors', plugin_dir_url( __FILE__ ) . 'css/jquery.minicolors.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'easySelect', plugin_dir_url( __FILE__ ) . 'css/easySelect.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tp-product-description-in-loop-for-woocommerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'minicolors', plugin_dir_url( __FILE__ ) . 'js/jquery.minicolors.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'easySelect', plugin_dir_url( __FILE__ ) . 'js/easySelect.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tp-product-description-in-loop-for-woocommerce-admin.js', array( 'jquery','jquery-ui-core','jquery-ui-tabs' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'tppdilParam', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   		//wp_enqueue_script( $this->plugin_name );

	}

	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=tppdil_plugin_settings_page">Settings</a>';
		$pro_link = '<a href="'.esc_url(TPPDIL_PLUGIN_HOME.'product/'.TPPDIL_PLUGIN_SLUG).'" class="tpc_get_pro" target="_blank">Go Premium!</a>';
		array_push( $links, $settings_link, $pro_link );
		return $links;
	} //function settings_link( $links )

	public function get_pro_link( $links, $file ) {

		if ( TPPDIL_PLUGIN_BASENAME == $file ) {
	
			$row_meta = array(
				'docs' => '<a href="' . esc_url( 'https://www.tplugins.com/demos/ex2/product-category/tp-product-description-in-loop/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Live Demo', 'wtppcs' ) . '" class="tpc_live_demo">&#128073; ' . esc_html__( 'Live Demo', 'wtppcs' ) . '</a>'
			);
	
			return array_merge( $links, $row_meta );
		}
		
		return (array) $links;
	} //function get_pro_link( $links, $file )

	/*
	* Tab
	*/
	//add_filter('woocommerce_product_data_tabs', 'tppdil_product_settings_tabs' );
	public function tppdil_product_settings_tabs( $tabs ){
	
		//unset( $tabs['inventory'] );
	
		$tabs['tppdil'] = array(
			'label'    => 'TP Description',
			'target'   => 'tppdil_product_data',
			//'class'    => array('show_if_simple','show_if_variable','show_if_grouped','show_if_external'),
			'priority' => 50,
		);
		
		return $tabs;
	
	}
 
	/*
	* Tab content
	*/
	//add_action( 'woocommerce_product_data_panels', 'tppdil_product_panels' );
	public function tppdil_product_panels(){
	
		echo '<div id="tppdil_product_data" class="panel woocommerce_options_panel hidden">';

			woocommerce_wp_checkbox(array( 
				'id'            => 'tppdil_single_disable', 
				'label'         => __('Disabel from loop (PRO)', 'tppdil'), 
				'description'   => __('Remove this description from loop', 'tppdil'),
				'value'         => get_post_meta( get_the_ID(), 'tppdil_single_disable', true ),
			) );
		
			woocommerce_wp_textarea_input( array(
				'id'          => 'tppdil_description',
				'value'       => get_post_meta( get_the_ID(), 'tppdil_description', true ),
				'label'       => __('Description (PRO)', 'tppdil'),
				'desc_tip'    => true,
				'description' => __('The Description will display on loop page and will override the default product description', 'tppdil'),
			) );

			echo '<div class="tppdil_product_panels_pro">This option is only available in the pro version of the plugin. <a href=" '.esc_url(TPPDIL_PLUGIN_HOME.'product/'.TPPDIL_PLUGIN_SLUG).'" target="_blank">GET PRO NOW!</a></div>';
	
		echo '</div>';
	
	}

	public function tppdil_css_icon(){
		echo '<style>
		#woocommerce-product-data ul.wc-tabs li.tppdil_options.tppdil_tab a:before{
			content: "\f130";
		}
		</style>';
	}

}
