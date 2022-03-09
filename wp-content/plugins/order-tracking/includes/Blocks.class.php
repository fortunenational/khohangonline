<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ewdotpBlocks' ) ) {
/**
 * Class to handle plugin Gutenberg blocks
 *
 * @since 3.0.0
 */
class ewdotpBlocks {

	public function __construct() {

		add_action( 'init', array( $this, 'add_blocks' ) );
		
		add_filter( 'block_categories_all', array( $this, 'add_block_category' ) );
	}

	/**
	 * Add the Gutenberg block to the list of available blocks
	 * @since 3.0.0
	 */
	public function add_blocks() {

		if ( ! function_exists( 'render_block_core_block' ) ) { return; }

		$this->enqueue_assets();   

		$args = array(
			'attributes' => array(
				'show_orders' => array(
					'type' => 'string',
				),
			),
			'editor_script'   	=> 'ewd-otp-blocks-js',
			'editor_style'  	=> 'ewd-otp-blocks-css',
			'render_callback' 	=> 'ewd_otp_tracking_form_shortcode',
		);

		register_block_type( 'order-tracking/ewd-otp-display-tracking-form-block', $args );

		$args = array(
			'editor_script'   	=> 'ewd-otp-blocks-js',
			'editor_style'  	=> 'ewd-otp-blocks-css',
			'render_callback' 	=> 'ewd_otp_customer_form_shortcode',
		);

		register_block_type( 'order-tracking/ewd-otp-display-customer-form-block', $args );

		$args = array(
			'editor_script'   	=> 'ewd-otp-blocks-js',
			'editor_style'  	=> 'ewd-otp-blocks-css',
			'render_callback' 	=> 'ewd_otp_sales_rep_form_shortcode',
		);

		register_block_type( 'order-tracking/ewd-otp-display-sales-rep-form-block', $args );

		$args = array(
			'editor_script'   	=> 'ewd-otp-blocks-js',
			'editor_style'  	=> 'ewd-otp-blocks-css',
			'render_callback' 	=> 'ewd_otp_customer_order_form_shortcode',
		);

		register_block_type( 'order-tracking/ewd-otp-display-customer-order-form-block', $args );
	}

	/**
	 * Create a new category of blocks to hold our block
	 * @since 3.0.0
	 */
	public function add_block_category( $categories ) {
		
		$categories[] = array(
			'slug'  => 'ewd-otp-blocks',
			'title' => __( 'Order Tracking', 'order-tracking' ),
		);

		return $categories;
	}

	/**
	 * Register the necessary JS and CSS to display the block in the editor
	 * @since 3.0.0
	 */
	public function enqueue_assets() {

		wp_register_script( 'ewd-otp-blocks-js', EWD_OTP_PLUGIN_URL . '/assets/js/ewd-otp-blocks.js', array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ), EWD_OTP_VERSION );
		wp_register_style( 'ewd-otp-blocks-css', EWD_OTP_PLUGIN_URL . '/assets/css/ewd-otp-blocks.css', array( 'wp-edit-blocks' ), EWD_OTP_VERSION );
	}
}

}