<?php
/*
Plugin Name: Order Tracking - WordPress Status Tracking Plugin
Plugin URI: https://www.etoilewebdesign.com/order-tracking/
Description: Order tracking, status and project management plugin that lets you create tickets and tracking numbers and send email updates. Works standalone and with WooCommerce.
Author: Etoile Web Design
Author URI: https://www.etoilewebdesign.com/
Terms and Conditions: https://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: order-tracking
Version: 3.0.16
WC requires at least: 3.0
WC tested up to: 5.7
*/


if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'ewdotpInit' ) ) {
class ewdotpInit {

	/**
	 * Initialize the plugin and register hooks
	 */
	public function __construct() {

		self::constants();
		self::includes();
		self::instantiate();
		self::wp_hooks();
	}

	/**
	 * Define plugin constants.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @return void
	 */
	protected function constants() {

		define( 'EWD_OTP_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'EWD_OTP_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'EWD_OTP_PLUGIN_FNAME', plugin_basename( __FILE__ ) );
		define( 'EWD_OTP_TEMPLATE_DIR', 'ewd-otp-templates' );
		define( 'EWD_OTP_VERSION', '3.0.16' );
	}

	/**
	 * Include necessary classes.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @return void
	 */
	protected function includes() {

		require_once( EWD_OTP_PLUGIN_DIR . '/includes/AdminOrders.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/AdminCustomFields.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/AdminCustomers.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/AdminSalesReps.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Ajax.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Blocks.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Customer.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/CustomerManager.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Dashboard.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/DeactivationSurvey.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Export.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Import.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/InstallationWalkthrough.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Notifications.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Order.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/OrderManager.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Permissions.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/ReviewAsk.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/SalesRep.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/SalesRepManager.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Settings.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/template-functions.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/UltimateWPMail.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/WooCommerce.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Zendesk.class.php' );
	}

	/**
	 * Spin up instances of our plugin classes.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @return void
	 */
	protected function instantiate() {

		new ewdotpDashboard();
		new ewdotpDeactivationSurvey();
		new ewdotpInstallationWalkthrough();
		new ewdotpReviewAsk();

		$this->admin_customers		= new ewdotpAdminCustomers();
		$this->admin_custom_fields	= new ewdotpAdminCustomFields();
		$this->admin_orders			= new ewdotpAdminOrders();
		$this->admin_sales_reps		= new ewdotpAdminSalesReps();
		$this->customer_manager		= new ewdotpCustomerManager();
		$this->exports 				= new ewdotpExport();
		$this->order_manager		= new ewdotpOrderManager();
		$this->permissions 			= new ewdotpPermissions();
		$this->sales_rep_manager	= new ewdotpSalesRepManager();
		$this->settings 			= new ewdotpSettings(); 

		if ( $this->settings->get_setting( 'woocommerce-integration' ) ) {
			
			$this->woocommerce = new ewdotpWooCommerce();
		}

		if ( $this->settings->get_setting( 'zendesk-integration' ) ) {
			
			$this->zendesk = new ewdotpZendesk();
		}

		new ewdotpAJAX();
		new ewdotpBlocks();
		new ewdotpImport();
		new ewdotpNotifications();
		new ewdotpUltimateWPMail();
	}

	/**
	 * Run walk-through, load assets, add links to plugin listing, etc.
	 *
	 * @since  3.0.0
	 * @access protected
	 * @return void
	 */
	protected function wp_hooks() {

		register_activation_hook( __FILE__, 	array( $this, 'run_walkthrough' ) );
		register_activation_hook( __FILE__, 	array( $this, 'convert_options' ) );
		register_activation_hook( __FILE__, 	array( $this, 'create_default_statuses_and_emails' ) );
		register_activation_hook( __FILE__, 	array( $this, 'create_tables' ) );

		register_deactivation_hook( __FILE__, 	array( $this, 'revert_wc_statuses' ) );

		add_action( 'init',			        	array( $this, 'load_view_files' ) );

		add_action( 'plugins_loaded',        	array( $this, 'load_textdomain' ) );

		add_action( 'admin_notices', 			array( $this, 'display_header_area' ) );

		add_action( 'admin_enqueue_scripts', 	array( $this, 'enqueue_admin_assets' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', 	array( $this, 'register_assets' ) );
		add_action( 'wp_enqueue_scripts', 		array( $this, 'register_assets' ) );
		add_action( 'wp_head',					'ewd_add_frontend_ajax_url' );

		add_filter( 'plugin_action_links',		array( $this, 'plugin_action_links' ), 10, 2);
	}

	/**
	 * Run the options conversion function on update if necessary
	 *
	 * @since  3.0.0
	 * @access protected
	 * @return void
	 */
	public function convert_options() {
		
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/BackwardsCompatibility.class.php' );
		new ewdotpBackwardsCompatibility();
	}

	/**
	 * Run the default status and emails creation function if necessary
	 *
	 * @since  3.0.0
	 * @access protected
	 * @return void
	 */
	public function create_default_statuses_and_emails() {

		$this->settings->create_default_statuses_and_emails();
	}

	/**
	 * Creates the tables where orders and their meta information are stored
	 *
	 * @since  3.0.0
	 * @access protected
	 * @return void
	 */
	public function create_tables() {

		$this->customer_manager->create_tables();
		$this->order_manager->create_tables();
		$this->sales_rep_manager->create_tables();
	}

	/**
	 * Load files needed for views
	 * @since 3.0.0
	 * @note Can be filtered to add new classes as needed
	 */
	public function load_view_files() {
	
		$files = array(
			EWD_OTP_PLUGIN_DIR . '/views/Base.class.php' // This will load all default classes
		);
	
		$files = apply_filters( 'ewd_otp_load_view_files', $files );
	
		foreach( $files as $file ) {
			require_once( $file );
		}
	
	}

	/**
	 * Load the plugin textdomain for localisation
	 * @since 3.0.0
	 */
	public function load_textdomain() {
		
		load_plugin_textdomain( 'order-tracking', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Set a transient so that the walk-through gets run
	 * @since 3.0.0
	 */
	public function run_walkthrough() {

		set_transient( 'ewd-otp-getting-started', true, 30 );
	} 

	/**
	 * Returns WooCommerce orders to their default statuses, if required
	 * @since 3.0.0
	 */
	public function revert_wc_statuses() {

		require_once( EWD_OTP_PLUGIN_DIR . '/includes/WooCommerce.class.php' );
		require_once( EWD_OTP_PLUGIN_DIR . '/includes/Settings.class.php' );
		
		$settings = new ewdotpSettings();

		if ( empty( $settings->get_setting( 'woocommerce-integration' ) ) ) { return; }

		if ( ! empty( $settings->get_setting( 'disable-woocommerce-revert-statuses' ) ) ) { return; }

		$woocommerce = new ewdotpWooCommerce();

		$woocommerce->revert_statuses();
	} 

	/**
	 * Enqueue the admin-only CSS and Javascript
	 * @since 3.0.0
	 */
	public function enqueue_admin_assets( $hook ) {
		global $post;

		$post_type = is_object( $post ) ?  $post->post_type : '';

		$screen = get_current_screen();

   		// Return if not one of the UASP post types, we're not on a post-type page, or we're not on the settings or widget pages
   		if ( $hook != 'tracking_page_ewd-otp-settings' and $hook != 'tracking_page_ewd-otp-import' and $hook != 'tracking_page_ewd-otp-export' and $screen->id != 'toplevel_page_ewd-otp-orders' and $screen->id != 'tracking_page_ewd-otp-dashboard' and $screen->id != 'toplevel_page_ewd-otp-sales-rep-orders' ) { return; }

		wp_enqueue_style( 'ewd-otp-admin-css', EWD_OTP_PLUGIN_URL . '/assets/css/ewd-otp-admin.css', array(), EWD_OTP_VERSION );
		wp_enqueue_script( 'ewd-otp-admin-js', EWD_OTP_PLUGIN_URL . '/assets/js/ewd-otp-admin.js', array( 'jquery' ), EWD_OTP_VERSION, true );

		if ( $screen->id == 'toplevel_page_ewd-otp-orders'  ) {

			wp_enqueue_style( 'sap-spectrium-css', EWD_OTP_PLUGIN_URL . '/lib/simple-admin-pages/css/spectrum.css', array(), EWD_OTP_VERSION );
			wp_enqueue_style( 'sap-admin-settings-css', EWD_OTP_PLUGIN_URL . '/lib/simple-admin-pages/css/admin-settings.css', array(), EWD_OTP_VERSION );
			wp_enqueue_script( 'sap-spectrum-js', EWD_OTP_PLUGIN_URL . '/lib/simple-admin-pages/js/spectrum.js', array( 'jquery' ), EWD_OTP_VERSION, true );
			wp_enqueue_script( 'sap-admin-settings-js', EWD_OTP_PLUGIN_URL . '/lib/simple-admin-pages/js/admin-settings.js', array( 'jquery' ), EWD_OTP_VERSION, true );
		}
	}

	/**
	 * Register the front-end CSS and Javascript for the FAQs
	 * @since 3.0.0
	 */
	function register_assets() {
		global $ewd_otp_controller;

		wp_register_style( 'ewd-otp-css', EWD_OTP_PLUGIN_URL . '/assets/css/ewd-otp.css', EWD_OTP_VERSION );
		
		wp_register_script( 'ewd-otp-js', EWD_OTP_PLUGIN_URL . '/assets/js/ewd-otp.js', array( 'jquery' ), EWD_OTP_VERSION, true );
	}

	/**
	 * Add links to the plugin listing on the installed plugins page
	 * @since 3.0.0
	 */
	public function plugin_action_links( $links, $plugin ) {

		if ( $plugin == EWD_OTP_PLUGIN_FNAME ) {

			$links['settings'] = '<a href="admin.php?page=ewd-otp-settings" title="' . __( 'Head to the settings page for Order Tracking', 'order-tracking' ) . '">' . __( 'Settings', 'order-tracking' ) . '</a>';
		}

		return $links;

	}



	/**
	 * Adds in a menu bar for the plugin
	 * @since 3.0.0
	 */
	public function display_header_area() {
		global $ewd_otp_controller;

		$screen = get_current_screen();
		
		if ( empty( $screen->parent_file ) or $screen->parent_file != 'ewd-otp-orders' ) { return; }

		if ( ! current_user_can( $ewd_otp_controller->settings->get_setting( 'access-role' ) ) ) { return; }
		
		if ( ! $ewd_otp_controller->permissions->check_permission( 'styling' ) or get_option( 'EWD_OTP_Trial_Happening' ) == 'Yes' ) {
			?>
			<div class="ewd-otp-dashboard-new-upgrade-banner">
				<div class="ewd-otp-dashboard-banner-icon"></div>
				<div class="ewd-otp-dashboard-banner-buttons">
					<a class="ewd-otp-dashboard-new-upgrade-button" href="https://www.etoilewebdesign.com/license-payment/?Selected=OTP&Quantity=1" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="ewd-otp-dashboard-banner-text">
					<div class="ewd-otp-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="ewd-otp-dashboard-banner-brief">
						Add premium appointment booking functionality to your site
					</div>
				</div>
			</div>
			<?php
		}
		
		?>
		<div class="ewd-otp-admin-header-menu">
			<h2 class="nav-tab-wrapper">
			<a id="ewd-otp-dash-mobile-menu-open" href="#" class="menu-tab nav-tab"><?php _e("MENU", 'order-tracking'); ?><span id="ewd-otp-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-otp-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span></a>
			<a id="dashboard-menu" href='admin.php?page=ewd-otp-dashboard' class="menu-tab nav-tab <?php if ( $screen->id == 'tracking_page_ewd-otp-dashboard' ) {echo 'nav-tab-active';}?>"><?php _e("Dashboard", 'order-tracking'); ?></a>
			<a id="orders-menu" href='admin.php?page=ewd-otp-orders' class="menu-tab nav-tab <?php if ( $screen->id == 'toplevel_page_ewd-otp-orders' ) {echo 'nav-tab-active';}?>"><?php _e("Orders", 'order-tracking'); ?></a>
			<a id="customers-menu" href='admin.php?page=ewd-otp-customers' class="menu-tab nav-tab <?php if ( $screen->id == 'toplevel_page_ewd-otp-customers' ) {echo 'nav-tab-active';}?>"><?php _e("Customers", 'order-tracking'); ?></a>
			<a id="sales-reps-menu" href='admin.php?page=ewd-otp-sales-reps' class="menu-tab nav-tab <?php if ( $screen->id == 'toplevel_page_ewd-otp-sales-reps' ) {echo 'nav-tab-active';}?>"><?php _e("Sales Reps", 'order-tracking'); ?></a>
			<a id="export-menu" href='admin.php?page=ewd-otp-export' class="menu-tab nav-tab <?php if ( $screen->id == 'ewd-otp-export' ) {echo 'nav-tab-active';}?>"><?php _e("Export", 'order-tracking'); ?></a>
			<a id="import-menu" href='admin.php?page=ewd-otp-import' class="menu-tab nav-tab <?php if ( $screen->id == 'ewd-otp-import' ) {echo 'nav-tab-active';}?>"><?php _e("Import", 'order-tracking'); ?></a>
			<a id="custom-fields-menu" href='admin.php?page=ewd-otp-custom-fields' class="menu-tab nav-tab <?php if ( $screen->id == 'ewd-otp-custom-fields' ) {echo 'nav-tab-active';}?>"><?php _e("Custom Fields", 'order-tracking'); ?></a>
			<a id="options-menu" href='admin.php?page=ewd-otp-settings' class="menu-tab nav-tab <?php if ( $screen->id == 'ewd_otp_page_ewd-otp-settings' ) {echo 'nav-tab-active';}?>"><?php _e("Settings", 'order-tracking'); ?></a>
			</h2>
		</div>
		<?php
	}

}
} // endif;

global $ewd_otp_controller;
$ewd_otp_controller = new ewdotpInit();