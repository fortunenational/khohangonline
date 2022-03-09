<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ewdotpSettings' ) ) {
/**
 * Class to handle configurable settings for Order Tracking
 * @since 3.0.0
 */
class ewdotpSettings {

	public $order_information_options = array();

	public $sales_rep_options = array();

	public $status_options = array();

	public $currency_options = array();

	public $email_options = array();

	/**
	 * Default values for settings
	 * @since 3.0.0
	 */
	public $defaults = array();

	/**
	 * Stored values for settings
	 * @since 3.0.0
	 */
	public $settings = array();

	public function __construct() {

		add_action( 'init', array( $this, 'set_defaults' ) );

		add_action( 'init', array( $this, 'set_field_options' ), 11 );

		add_action( 'init', array( $this, 'load_settings_panel' ), 12 );
	}

	/**
	 * Load the plugin's default settings
	 * @since 3.0.0
	 */
	public function set_defaults() {

		$order_information_defaults = array(
			'order_number',
			'order_name',
			'order_status',
			'order_updated',
			'order_notes',
		);

		$this->defaults = array(

			'order-information'					=> $order_information_defaults,

			'date-format'						=> _x( 'd-m-Y H:i:s', 'Default date format for display. Available options here https://www.php.net/manual/en/datetime.format.php', 'order-tracking' ),
			'form-instructions'					=> __( 'Enter the order number you would like to track in the form below.', 'order-tracking' ),

			'access-role'						=> 'manage_options',
			'tracking-graphic'					=> 'default',

			'google-maps-api-key'				=> 'AIzaSyBFLmQU4VaX-T67EnKFtos7S7m_laWn6L4',

			'email-messages'					=> array(),

			'label-retrieving-results'			=> __( 'Retrieving Results...', 'order-tracking' ),
			'label-customer-order-thank-you'	=> __( 'Thank you. Your order number is:', 'order-tracking' ),
		);

		$this->defaults = apply_filters( 'ewd_otp_defaults', $this->defaults );
	}

	/**
	 * Put all of the available possible select options into key => value arrays
	 * @since 3.0.0
	 */
	public function set_field_options() {
		global $ewd_otp_controller;

		$this->currency_options = array(
			'AUD' => __( 'Australian Dollar', 'order-tracking'),
			'BRL' => __( 'Brazilian Real', 'order-tracking'),
			'CAD' => __( 'Canadian Dollar', 'order-tracking'),
			'CZK' => __( 'Czech Koruna', 'order-tracking'),
			'DKK' => __( 'Danish Krone', 'order-tracking'),
			'EUR' => __( 'Euro', 'order-tracking'),
			'HKD' => __( 'Hong Kong Dollar', 'order-tracking'),
			'HUF' => __( 'Hungarian Forint', 'order-tracking'),
			'ILS' => __( 'Israeli New Sheqel', 'order-tracking'),
			'JPY' => __( 'Japanese Yen', 'order-tracking'),
			'MYR' => __( 'Malaysian Ringgit', 'order-tracking'),
			'MXN' => __( 'Mexican Peso', 'order-tracking'),
			'NOK' => __( 'Norwegian Krone', 'order-tracking'),
			'NZD' => __( 'New Zealand Dollar', 'order-tracking'),
			'PHP' => __( 'Philippine Peso', 'order-tracking'),
			'PLN' => __( 'Polish Zloty', 'order-tracking'),
			'GBP' => __( 'Pound Sterling', 'order-tracking'),
			'RUB' => __( 'Russian Ruble', 'order-tracking'),
			'SGD' => __( 'Singapore Dollar', 'order-tracking'),
			'SEK' => __( 'Swedish Krona', 'order-tracking'),
			'CHF' => __( 'Swiss Franc', 'order-tracking'),
			'TWD' => __( 'Taiwan New Dollar', 'order-tracking'),
			'THB' => __( 'Thai Baht', 'order-tracking'),
			'TRY' => __( 'Turkish Lira', 'order-tracking'),
			'USD' => __( 'U.S. Dollar', 'order-tracking'),
		);

		$this->order_information_options = array(
			'order_number'			=> __( 'Order Number', 'order-tracking' ),
			'order_name'			=> __( 'Name', 'order-tracking' ),
			'order_status'			=> __( 'Status', 'order-tracking' ),
			'order_location'		=> __( 'Location', 'order-tracking' ),
			'order_updated'			=> __( 'Updated Date', 'order-tracking' ),
			'order_notes'			=> __( 'Notes', 'order-tracking' ),
			'customer_notes'		=> __( 'Customer Notes', 'order-tracking' ),
			'order_graphic'			=> __( 'Status Graphic', 'order-tracking' ),
			'order_map'				=> __( 'Tracking Map', 'order-tracking' ),
			'customer_name'			=> __( 'Customer Name', 'order-tracking' ),
			'customer_email'		=> __( 'Customer Email', 'order-tracking' ),
			'sales_rep_first_name'	=> __( 'Sales Rep First Name', 'order-tracking' ),
			'sales_rep_last_name'	=> __( 'Sales Rep Last Name', 'order-tracking' ),
			'sales_rep_email'		=> __( 'Sales Rep Email', 'order-tracking' ),
		);

		$statuses = ewd_otp_decode_infinite_table_setting( $this->get_setting( 'statuses' ) );

		foreach ( $statuses as $status ) {

			$this->status_options[ $status->status ] = $status->status;
		}

		$emails = ewd_otp_decode_infinite_table_setting( $this->get_setting( 'email-messages' ) );

		foreach ( $emails as $email ) { 

			$this->email_options[ $email->id ] = $email->name;
		}

		if ( post_type_exists( 'uwpm_mail_template' ) ) {

			$this->email_options[-1] = '';
			
			$args = array(
				'post_type'		=> 'uwpm_mail_template',
				'numberposts'	=> -1
			);

			$uwpm_emails = get_posts( $args );

			foreach ( $uwpm_emails as $uwpm_email ) { 

				$email_id = $uwpm_email->ID * -1;

				$this->email_options[ $email_id ] = $uwpm_email->post_title;
			}
		}

		$args = array(
			'sales_reps_per_page'	=> -1
		);

		$sales_reps = $ewd_otp_controller->sales_rep_manager->get_matching_sales_reps( $args );

		foreach ( $sales_reps as $sales_rep ) {
			
			$this->sales_rep_options[ $sales_rep->id ] = $sales_rep->first_name . ' ' . $sales_rep->last_name; 
		}
	}

	/**
	 * Get a setting's value or fallback to a default if one exists
	 * @since 3.0.0
	 */
	public function get_setting( $setting ) { 

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'ewd-otp-settings' );
		}
		
		if ( ! empty( $this->settings[ $setting ] ) ) {
			return apply_filters( 'ewd-otp-settings-' . $setting, $this->settings[ $setting ] );
		}

		if ( ! empty( $this->defaults[ $setting ] ) ) { 
			return apply_filters( 'ewd-otp-settings-' . $setting, $this->defaults[ $setting ] );
		}

		return apply_filters( 'ewd-otp-settings-' . $setting, null );
	}

	/**
	 * Set a setting to a particular value
	 * @since 3.0.0
	 */
	public function set_setting( $setting, $value ) {

		$this->settings[ $setting ] = $value;
	}

	/**
	 * Save all settings, to be used with set_setting
	 * @since 3.0.0
	 */
	public function save_settings() {
		
		update_option( 'ewd-otp-settings', $this->settings );
	}

	/**
	 * Load the admin settings page
	 * @since 3.0.0
	 * @sa https://github.com/NateWr/simple-admin-pages
	 */
	public function load_settings_panel() {

		global $ewd_otp_controller;

		require_once( EWD_OTP_PLUGIN_DIR . '/lib/simple-admin-pages/simple-admin-pages.php' );
		$sap = sap_initialize_library(
			$args = array(
				'version'       => '2.6.1',
				'lib_url'       => EWD_OTP_PLUGIN_URL . '/lib/simple-admin-pages/',
				'theme'			=> 'purple',
			)
		);
		
		$sap->add_page(
			'submenu',
			array(
				'id'            => 'ewd-otp-settings',
				'title'         => __( 'Settings', 'order-tracking' ),
				'menu_title'    => __( 'Settings', 'order-tracking' ),
				'parent_menu'	=> 'ewd-otp-orders',
				'description'   => '',
				'capability'    => $this->get_setting( 'access-role' ),
				'default_tab'   => 'ewd-otp-basic-tab',
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-basic-tab',
				'title'         => __( 'Basic', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-general',
				'title'         => __( 'General', 'order-tracking' ),
				'tab'	        => 'ewd-otp-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'textarea',
			array(
				'id'			=> 'custom-css',
				'title'			=> __( 'Custom CSS', 'order-tracking' ),
				'description'	=> __( 'You can add custom CSS styles to your appointment booking page in the box above.', 'order-tracking' ),			
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'checkbox',
			array(
				'id'            => 'order-information',
				'title'         => __( 'Order Information Displayed', 'order-tracking' ),
				'description'   => __( 'What information should be displayed for your orders?', 'order-tracking' ), 
				'options'       => $this->order_information_options
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'toggle',
			array(
				'id'			=> 'hide-blank-fields',
				'title'			=> __( 'Hide Blank Fields', 'order-tracking' ),
				'description'	=> __( 'Should fields which don\'t have a value (ex. customer name, custom fields) be hidden if they\'re empty?', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'textarea',
			array(
				'id'			=> 'form-instructions',
				'title'			=> __( 'Form Instructions', 'order-tracking' ),
				'description'	=> __( 'The instructions that will display above the order form.', 'order-tracking' ),			
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'text',
			array(
				'id'            => 'date-format',
				'title'         => __( 'Date/Time Format', 'order-tracking' ),
				'description'	=> __( 'The format to use when displaying dates. Possible options can be: <a href="https://www.php.net/manual/en/datetime.format.php">found here</a>', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'radio',
			array(
				'id'			=> 'email-frequency',
				'title'			=> __( 'Order Email Frequency', 'order-tracking' ),
				'description'	=> __( 'How often should emails be sent to customers about the status of their orders?', 'order-tracking' ),
				'options'		=> array(
					'change'		=> __( 'On Change', 'order-tracking' ),
					'creation'		=> __( 'On Creation', 'order-tracking' ),
					'never'			=> __( 'Never', 'order-tracking' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'toggle',
			array(
				'id'			=> 'disable-ajax-loading',
				'title'			=> __( 'Disable AJAX Reloads', 'order-tracking' ),
				'description'	=> __( 'Should the use of AJAX to display search results without reloading the page be disabled?', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'toggle',
			array(
				'id'			=> 'new-window',
				'title'			=> __( 'New Window', 'order-tracking' ),
				'description'	=> __( 'Should search results open in a new window? (Doesn\'t work with AJAX reloads)', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'toggle',
			array(
				'id'			=> 'display-print-button',
				'title'			=> __( 'Display "Print" Button', 'order-tracking' ),
				'description'	=> __( 'Should a "Print" button be added to tracking form results, so that visitors can print their order information more easily?', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'toggle',
			array(
				'id'			=> 'email-verification',
				'title'			=> __( 'Email Verification', 'order-tracking' ),
				'description'	=> __( 'Do visitors need to also enter the email address associated with an order to be able to view order information?', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'text',
			array(
				'id'          => 'google-maps-api-key',
				'title'       => __( 'Google Maps API Key', 'order-tracking' ),
				'description' => sprintf(
					__( 'If you\'re displaying a map with a map of your order locations ( using the "Tracking Map" checkbox of the "Order Information" setting above), Google requires an API key to use their maps. %sGet an API key%s.', 'order-tracking' ),
					'<a href="https://developers.google.com/maps/documentation/javascript/get-api-key">',
					'</a>'
				),
				'conditional_on'		=> 'order-information',
				'conditional_on_value'	=> 'order_map'
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'text',
			array(
				'id'            => 'tracking-page-url',
				'title'         => __( 'Status Tracking URL', 'order-tracking' ),
				'description'	=> __( 'The URL of your tracking page, required if you want to include a tracking link in your message body, on the WooCommerce order page, etc..', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-general',
			'toggle',
			array(
				'id'          => 'use-wp-timezone',
				'title'       => __( 'Use WP Timezone', 'order-tracking' ),
				'description' => __( 'By default, the timestamp on status updates uses your server\'s timezone. Enabling this will make it display (in the admin and on the front-end tracking page) using the timezone you have set in your WordPress General Settings instead. ', 'order-tracking' )
			)
		);

		if ( ! $ewd_otp_controller->permissions->check_permission( 'premium' ) ) {
			$ewd_otp_premium_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/order-tracking/'
			);
		}
		else { $ewd_otp_premium_permissions = array(); }

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-premium-tab',
				'title'         => __( 'Premium', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-premium-general',
					'title'         => __( 'General', 'order-tracking' ),
					'tab'	        => 'ewd-otp-premium-tab',
				),
				$ewd_otp_premium_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-premium-general',
			'select',
			array(
				'id'            => 'access-role',
				'title'         => __( 'Set Access Role', 'order-tracking' ),
				'description'   => __( 'Who should have access to the "Order Tracking" admin menu?', 'order-tracking' ), 
				'blank_option'	=> false,
				'options'       => array(
					'administrator'				=> __( 'Administrator', 'order-tracking' ),
					'delete_others_pages'		=> __( 'Editor', 'order-tracking' ),
					'delete_published_posts'	=> __( 'Author', 'order-tracking' ),
					'delete_posts'				=> __( 'Contributor', 'order-tracking' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-premium-general',
			'radio',
			array(
				'id'			=> 'tracking-graphic',
				'title'			=> __( 'Status Tracking Graphic', 'order-tracking' ),
				'description'	=> __( 'Which tracking graphic should be displayed, if the graphic is being used for your orders.', 'order-tracking' ),
				'options'		=> array(
					'default'		=> __( 'Default', 'order-tracking' ),
					'streamlined'	=> __( 'Streamlined', 'order-tracking' ),
					'sleek'			=> __( 'Sleek', 'order-tracking' ),
					'minimalist'	=> __( 'Minimalist', 'order-tracking' ),
					'round'			=> __( 'Round', 'order-tracking' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-premium-general',
			'select',
			array(
				'id'            => 'customer-notes-email',
				'title'         => __( 'Customer Notes Email', 'order-tracking' ),
				'description'   => __( 'What email, if any, should be sent to the administrator when the customer note on an order is updated?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->email_options
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-premium-general',
			'select',
			array(
				'id'            => 'customer-order-email',
				'title'         => __( 'Customer Order Email', 'order-tracking' ),
				'description'   => __( 'What email, if any, should be sent to the administrator when a new customer order is created?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->email_options
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-premium-general',
			'toggle',
			array(
				'id'			=> 'allow-customer-downloads',
				'title'			=> __( 'Allow Customer Downloads', 'order-tracking' ),
				'description'	=> __( 'Should customers be able to download all of the information on their orders as a CSV file?', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-premium-general',
			'toggle',
			array(
				'id'			=> 'allow-sales-rep-downloads',
				'title'			=> __( 'Allow Sales Rep Downloads', 'order-tracking' ),
				'description'	=> __( 'Should sales reps be able to download all of the information on their orders as a CSV file?', 'order-tracking' )
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-customer-order-form',
					'title'         => __( 'Customer Order Form', 'order-tracking' ),
					'tab'	        => 'ewd-otp-premium-tab',
				),
				$ewd_otp_premium_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-customer-order-form',
			'select',
			array(
				'id'            => 'default-customer-order-form-status',
				'title'         => __( 'Default Order Status', 'order-tracking' ),
				'description'   => __( 'What status, if any, should an order be set to after when a customer submits one?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-customer-order-form',
			'toggle',
			array(
				'id'			=> 'allow-sales-rep-selection',
				'title'			=> __( 'Allow Sales Rep Selection', 'order-tracking' ),
				'description'	=> __( 'Should an option to choose a sales rep be included in the customer order form?', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-customer-order-form',
			'toggle',
			array(
				'id'			=> 'allow-assign-orders-to-customers',
				'title'			=> __( 'Assign Orders to Customers', 'order-tracking' ),
				'description'	=> __( 'With this enabled, orders submitted using the customer order form will be automatically assigned to a customer based on their email address.', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-customer-order-form',
			'text',
			array(
				'id'            => 'customer-order-number-prefix',
				'title'         => __( 'Order Number Prefix', 'order-tracking' ),
				'description'	=> __( 'Specify a prefix for the auto-generated order number for orders created using the customer order form', 'order-tracking' ),
				'small'			=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-customer-order-form',
			'text',
			array(
				'id'            => 'customer-order-number-suffix',
				'title'         => __( 'Order Number Suffix', 'order-tracking' ),
				'description'	=> __( 'Specify a suffix for the auto-generated order number for orders created using the customer order form', 'order-tracking' ),
				'small'			=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-customer-order-form',
			'select',
			array(
				'id'            => 'default-sales-rep',
				'title'         => __( 'Default Sales Rep', 'order-tracking' ),
				'description'   => __( 'Choose a default sales rep for all orders created using the customer order form (if not using the above option to enable sales rep selection).', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->sales_rep_options
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-statuses-tab',
				'title'         => __( 'Statuses', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-statuses',
				'title'         => __( 'Statuses', 'order-tracking' ),
				'tab'	        => 'ewd-otp-statuses-tab',
			)
		);

		$statuses_description = __( 'Statuses let your customers know the current status of their order.', 'order-tracking' ) . '<br />';
		
		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-statuses',
			'infinite_table',
			array(
				'id'			=> 'statuses',
				'title'			=> __( 'Statuses', 'order-tracking' ),
				'add_label'		=> __( '&plus; ADD', 'order-tracking' ),
				'del_label'		=> __( 'Delete', 'order-tracking' ),
				'description'	=> $statuses_description,
				'fields'		=> array(
					'status' => array(
						'type' 		=> 'text',
						'label' 	=> 'Status',
						'required' 	=> true
					),
					'percentage' => array(
						'type' 		=> 'text',
						'label' 	=> '&#37; Complete',
						'required' 	=> false
					),
					'email' => array(
						'type' 			=> 'select',
						'label' 		=> __( 'Email', 'order-tracking' ),
						'options' 		=> $this->email_options
					),
					'internal' => array(
						'type' 		=> 'select',
						'label' 	=> __( 'Internal Status', 'order-tracking' ),
						'options' 	=> array(
							'no'		=> __( 'No', 'order-tracking' ),
							'yes'		=> __( 'Yes', 'order-tracking' ),
						)
					)
				)
			)
		);

		if ( ! $ewd_otp_controller->permissions->check_permission( 'locations' ) ) {
			$ewd_otp_locations_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/order-tracking/'
			);
		}
		else { $ewd_otp_locations_permissions = array(); }

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-locations-tab',
				'title'         => __( 'Locations', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-locations',
					'title'         => __( 'Locations', 'order-tracking' ),
					'tab'	        => 'ewd-otp-locations-tab',
				),
				$ewd_otp_locations_permissions
			)
		);

		$locations_description = __( 'Locations help your customers to know where their order is.', 'order-tracking' ) . '<br />';
		
		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-locations',
			'infinite_table',
			array(
				'id'			=> 'locations',
				'title'			=> __( 'Locations', 'order-tracking' ),
				'add_label'		=> __( '&plus; ADD', 'order-tracking' ),
				'del_label'		=> __( 'Delete', 'order-tracking' ),
				'description'	=> $locations_description,
				'fields'		=> array(
					'name' => array(
						'type' 		=> 'text',
						'label' 	=> 'Name',
						'required' 	=> true
					),
					'latitude' => array(
						'type' 		=> 'text',
						'label' 	=> 'Latitude',
						'required' 	=> false
					),
					'longitude' => array(
						'type' 		=> 'text',
						'label' 	=> 'Longitude',
						'required' 	=> false
					)
				)
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-emails-tab',
				'title'         => __( 'Emails', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-emails',
				'title'         => __( 'Emails', 'order-tracking' ),
				'tab'	        => 'ewd-otp-emails-tab',
			)
		);

		$emails_description = __( 'What should be in the messages sent to users? You can put [order-name], [order-number], [order-status], [order-notes], [customer-notes] and [order-time] into the message, to include current order name, order number, order status, public order notes or the time the order was updated.', 'order-tracking' ) . '<br />';
		$emails_description .= __( 'You can also use [tracking-link], [customer-name], [customer-id], [sales-rep] or the slug of a custom field enclosed in square brackets to include those fields in the email.', 'order-tracking' );
		
		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-emails',
			'infinite_table',
			array(
				'id'			=> 'email-messages',
				'title'			=> __( 'Email Messages', 'order-tracking' ),
				'add_label'		=> __( '&plus; ADD', 'order-tracking' ),
				'del_label'		=> __( 'Delete', 'order-tracking' ),
				'description'	=> $emails_description,
				'fields'		=> array(
					'id' => array(
						'type' 		=> 'hidden',
						'label' 	=> 'ID',
						'required' 	=> true
					),
					'name' => array(
						'type' 		=> 'text',
						'label' 	=> 'Name',
						'required' 	=> true
					),
					'subject' => array(
						'type' 		=> 'text',
						'label' 	=> 'Subject',
						'required' 	=> true
					),
					'message' => array(
						'type' 		=> 'text',
						'label' 	=> 'Message',
						'required' 	=> true
					)
				)
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-emails',
			'text',
			array(
				'id'            => 'admin-email',
				'title'         => __( 'Admin Email', 'order-tracking' ),
				'description'	=> __( 'What email should customer note and customer order notifications be sent to, if they\'ve been set in the "Premium" area of the "Options" tab? Leave blank to use the WordPress admin email address.', 'order-tracking' ),
				'small'			=> true
			)
		);

		if ( ! $ewd_otp_controller->permissions->check_permission( 'payment' ) ) {
			$ewd_otp_payment_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/order-tracking/'
			);
		}
		else { $ewd_otp_payment_permissions = array(); }

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-payment-tab',
				'title'         => __( 'Payment', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-payment-options',
					'title'         => __( 'Payment Options', 'order-tracking' ),
					'tab'	        => 'ewd-otp-payment-tab',
				),
				$ewd_otp_payment_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-payment-options',
			'toggle',
			array(
				'id'			=> 'allow-order-payments',
				'title'			=> __( 'Allow Order Payment By PayPal', 'order-tracking' ),
				'description'	=> __( 'Should order payment be possible via PayPal?', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-payment-options',
			'select',
			array(
				'id'            => 'default-payment-status',
				'title'         => __( 'Default Post-Payment Status', 'order-tracking' ),
				'description'   => __( 'What status, if any, should an order be set to after payment is received?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'allow-order-payments',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-payment-options',
			'text',
			array(
				'id'            => 'paypal-email-address',
				'title'         => __( 'PayPal Email Address', 'order-tracking' ),
				'description'	=> __( 'If PayPal payments are possible, what email address is associated with the PayPal account?', 'order-tracking' ),
				'small'			=> true,
				'conditional_on'		=> 'allow-order-payments',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-payment-options',
			'select',
			array(
				'id'            => 'pricing-currency-code',
				'title'         => __( 'Pricing Currency', 'order-tracking' ),
				'description'   => __( 'What currency are your orders priced in?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->currency_options,
				'conditional_on'		=> 'allow-order-payments',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-payment-options',
			'text',
			array(
				'id'            => 'thank-you-url',
				'title'         => __( '"Thank You" Page URL', 'order-tracking' ),
				'description'	=> __( 'What page should customers be taken to after successfully completing a PayPal payment?', 'order-tracking' ),
				'small'			=> true,
				'conditional_on'		=> 'allow-order-payments',
				'conditional_on_value'	=> true
			)
		);

		if ( ! $ewd_otp_controller->permissions->check_permission( 'woocommerce' ) ) {
			$ewd_otp_woocommerce_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/order-tracking/'
			);
		}
		else { $ewd_otp_woocommerce_permissions = array(); }

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-woocommerce-tab',
				'title'         => __( 'WooCommerce', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-woocommerce-options',
					'title'         => __( 'WooCommerce Options', 'order-tracking' ),
					'tab'	        => 'ewd-otp-woocommerce-tab',
				),
				$ewd_otp_woocommerce_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'toggle',
			array(
				'id'			=> 'woocommerce-integration',
				'title'			=> __( 'WooCommerce Integration', 'order-tracking' ),
				'description'	=> __( 'Should WooCommerce orders be automatically created inside of the Status Tracking plugin? (Only works for new orders)', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'text',
			array(
				'id'            => 'woocommerce-prefix',
				'title'         => __( 'WooCommerce Prefix', 'order-tracking' ),
				'description'	=> __( 'What prefix, if any, should be added to WooCommerce order numbers?', 'order-tracking' ),
				'small'			=> true,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'toggle',
			array(
				'id'			=> 'woocommerce-disable-random-suffix',
				'title'			=> __( 'Disable WooCommerce Random Suffix', 'order-tracking' ),
				'description'	=> __( 'Should the random characters added to WooCommerce orders be not be added?', 'order-tracking' ),
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'toggle',
			array(
				'id'			=> 'woocommerce-show-on-order-page',
				'title'			=> __( 'Show Tracking On Order Page', 'order-tracking' ),
				'description'	=> __( 'Should order status information be displayed on the order page?', 'order-tracking' ),
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'toggle',
			array(
				'id'			=> 'woocommerce-locations-enabled',
				'title'			=> __( 'Location Dropdown for WooCommerce Orders', 'order-tracking' ),
				'description'	=> __( 'Should a location dropdown be added to the WooCommerce "Edit Order" screen?', 'order-tracking' ),
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'toggle',
			array(
				'id'			=> 'woocommerce-replace-statuses',
				'title'			=> __( 'Replace WooCommerce Statuses with Status Tracking Statuses', 'order-tracking' ),
				'description'	=> __( 'Should order tracking statuses replace the default WooCommerce statuses?', 'order-tracking' ),
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'toggle',
			array(
				'id'			=> 'disable-woocommerce-revert-statuses',
				'title'			=> __( 'Disable Revert WooCommerce Statuses on Deactivation', 'order-tracking' ),
				'description'	=> __( 'Should WooCommerce orders having their statuses returned to one of the defaults when the plugin is deactivated be disabled? This is disabled by default if WooCommerce integration is not enabled, but could result in orders with custom statuses being hidden from the WooCommerce admin orders table after deactivation.', 'order-tracking' ),
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'select',
			array(
				'id'            => 'woocommerce-paid-status',
				'title'         => __( 'WooCommerce Completed Order Status', 'order-tracking' ),
				'description'   => __( 'What status should an order be set to when it\'s paid for successfully?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'select',
			array(
				'id'            => 'woocommerce-unpaid-status',
				'title'         => __( 'WooCommerce Unpaid Order Status', 'order-tracking' ),
				'description'   => __( 'What status should an order be set to when it\'s unpaid?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'select',
			array(
				'id'            => 'woocommerce-processing-status',
				'title'         => __( 'WooCommerce Processing Order Status', 'order-tracking' ),
				'description'   => __( 'What status should an order be set to when it\'s processing?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'select',
			array(
				'id'            => 'woocommerce-cancelled-status',
				'title'         => __( 'WooCommerce Cancelled Order Status', 'order-tracking' ),
				'description'   => __( 'What status should an order be set to when it\'s cancelled?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'select',
			array(
				'id'            => 'woocommerce-onhold-status',
				'title'         => __( 'WooCommerce On-Hold Order Status', 'order-tracking' ),
				'description'   => __( 'What status should an order be set to when it\'s on-hold?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'select',
			array(
				'id'            => 'woocommerce-failed-status',
				'title'         => __( 'WooCommerce Failed Order Status', 'order-tracking' ),
				'description'   => __( 'What status should an order be set to when it fails?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-woocommerce-options',
			'select',
			array(
				'id'            => 'woocommerce-refunded-status',
				'title'         => __( 'WooCommerce Refunded Order Status', 'order-tracking' ),
				'description'   => __( 'What status should an order be set to when it\'s refunded?', 'order-tracking' ), 
				'blank_option'	=> true,
				'options'       => $this->status_options,
				'conditional_on'		=> 'woocommerce-integration',
				'conditional_on_value'	=> true
			)
		);

		if ( ! $ewd_otp_controller->permissions->check_permission( 'zendesk' ) ) {
			$ewd_otp_zendesk_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/order-tracking/'
			);
		}
		else { $ewd_otp_zendesk_permissions = array(); }

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-zendesk-tab',
				'title'         => __( 'Zendesk', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-zendesk-options',
					'title'         => __( 'Zendesk Options', 'order-tracking' ),
					'tab'	        => 'ewd-otp-zendesk-tab',
				),
				$ewd_otp_zendesk_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-zendesk-options',
			'toggle',
			array(
				'id'			=> 'zendesk-integration',
				'title'			=> __( 'Zendesk Integration', 'order-tracking' ),
				'description'	=> __( 'Should the plugin listen for new tickets from Zendesk?<br>Check out our <a style=\'display:inline; padding-left:0px;\' href=\'http://www.etoilewebdesign.com/status-tracking-zendesk-integration/\'>tutorial on setting up Status Tracking-Zendesk integration</a>', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-zendesk-options',
			'text',
			array(
				'id'            => 'zendesk-api-key',
				'title'         => __( 'Zendesk API Key (optional)', 'order-tracking' ),
				'description'	=> __( 'The (optional) key you\'re using to make sure that fake tickets can\'t be created by a 3rd party.', 'order-tracking' ),
				'small'			=> true,
				'conditional_on'		=> 'zendesk-integration',
				'conditional_on_value'	=> true
			)
		);

		if ( ! $ewd_otp_controller->permissions->check_permission( 'labelling' ) ) {
			$ewd_otp_labelling_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/order-tracking/'
			);
		}
		else { $ewd_otp_labelling_permissions = array(); }

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-labelling-tab',
				'title'         => __( 'Labelling', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-labelling-tracking-form',
					'title'         => __( 'Tracking Form', 'order-tracking' ),
					'tab'	        => 'ewd-otp-labelling-tab',
				),
				$ewd_otp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-tracking-form',
			'text',
			array(
				'id'            => 'label-order-form-title',
				'title'         => __( 'Tracking Form Title', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-tracking-form',
			'text',
			array(
				'id'            => 'label-order-form-number',
				'title'         => __( 'Order Number Label', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-tracking-form',
			'text',
			array(
				'id'            => 'label-order-form-number-placeholder',
				'title'         => __( 'Order Number Placeholder', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-tracking-form',
			'text',
			array(
				'id'            => 'label-order-form-email',
				'title'         => __( 'Email Address', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-tracking-form',
			'text',
			array(
				'id'            => 'label-order-form-email-placeholder',
				'title'         => __( 'Email Address Placeholder', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-tracking-form',
			'text',
			array(
				'id'            => 'label-order-form-button',
				'title'         => __( 'Track button', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-tracking-form',
			'text',
			array(
				'id'            => 'label-retrieving-results',
				'title'         => __( 'Retrieving Results', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-labelling-customer-form',
					'title'         => __( 'Customer Form', 'order-tracking' ),
					'tab'	        => 'ewd-otp-labelling-tab',
				),
				$ewd_otp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form',
			'text',
			array(
				'id'            => 'label-customer-form-title',
				'title'         => __( 'Form Title', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form',
			'text',
			array(
				'id'            => 'label-customer-form-instructions',
				'title'         => __( 'Instructions', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form',
			'text',
			array(
				'id'            => 'label-customer-form-number',
				'title'         => __( 'Customer Number Label', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form',
			'text',
			array(
				'id'            => 'label-customer-form-number-placeholder',
				'title'         => __( 'Customer Number Placeholder', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form',
			'text',
			array(
				'id'            => 'label-customer-form-email',
				'title'         => __( 'Email Address', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form',
			'text',
			array(
				'id'            => 'label-customer-form-email-placeholder',
				'title'         => __( 'Email Address Placeholder', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form',
			'text',
			array(
				'id'            => 'label-customer-form-button',
				'title'         => __( 'Track button', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-labelling-sales-rep-form',
					'title'         => __( 'Sales Rep Form', 'order-tracking' ),
					'tab'	        => 'ewd-otp-labelling-tab',
				),
				$ewd_otp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form',
			'text',
			array(
				'id'            => 'label-sales-rep-form-title',
				'title'         => __( 'Form Title', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form',
			'text',
			array(
				'id'            => 'label-sales-rep-form-instructions',
				'title'         => __( 'Instructions', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form',
			'text',
			array(
				'id'            => 'label-sales-rep-form-number',
				'title'         => __( 'Sales Rep Number Label', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form',
			'text',
			array(
				'id'            => 'label-sales-rep-form-number-placeholder',
				'title'         => __( 'Sales Rep Number Placeholder', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form',
			'text',
			array(
				'id'            => 'label-sales-rep-form-email',
				'title'         => __( 'Email Address', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form',
			'text',
			array(
				'id'            => 'label-sales-rep-form-email-placeholder',
				'title'         => __( 'Email Address Placeholder', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form',
			'text',
			array(
				'id'            => 'label-sales-rep-form-button',
				'title'         => __( 'Track button', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-labelling-order-display',
					'title'         => __( 'Order Display Page', 'order-tracking' ),
					'tab'	        => 'ewd-otp-labelling-tab',
				),
				$ewd_otp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-information',
				'title'         => __( 'Order Information', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-number',
				'title'         => __( 'Order Number', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-name',
				'title'         => __( 'Order Name', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-notes',
				'title'         => __( 'Order Notes', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-customer-notes',
				'title'         => __( 'Customer Notes', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-status',
				'title'         => __( 'Order Status', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-location',
				'title'         => __( 'Order Location', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-updated',
				'title'         => __( 'Order Updated', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-current-location',
				'title'         => __( 'Current Location', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-print-button',
				'title'         => __( 'Print Button', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-add-note-button',
				'title'         => __( 'Add Note Button', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-order-display',
			'text',
			array(
				'id'            => 'label-order-update-status',
				'title'         => __( 'Update Status Button', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-labelling-customer-form-display',
					'title'         => __( 'Customer Form Display Page', 'order-tracking' ),
					'tab'	        => 'ewd-otp-labelling-tab',
				),
				$ewd_otp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form-display',
			'text',
			array(
				'id'            => 'label-customer-display-name',
				'title'         => __( 'Customer Name', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form-display',
			'text',
			array(
				'id'            => 'label-customer-display-email',
				'title'         => __( 'Customer Email', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-form-display',
			'text',
			array(
				'id'            => 'label-customer-display-download',
				'title'         => __( 'Download All Orders', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-labelling-sales-rep-form-display',
					'title'         => __( 'Sales Rep Form Display Page', 'order-tracking' ),
					'tab'	        => 'ewd-otp-labelling-tab',
				),
				$ewd_otp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form-display',
			'text',
			array(
				'id'            => 'label-sales-rep-display-first-name',
				'title'         => __( 'Sales Rep First Name', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form-display',
			'text',
			array(
				'id'            => 'label-sales-rep-display-last-name',
				'title'         => __( 'Sales Rep Last Name', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form-display',
			'text',
			array(
				'id'            => 'label-sales-rep-display-email',
				'title'         => __( 'Sales Rep Email', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-sales-rep-form-display',
			'text',
			array(
				'id'            => 'label-sales-rep-display-download',
				'title'         => __( 'Download All Orders', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-labelling-customer-order-form-display',
					'title'         => __( 'Customer Order Form', 'order-tracking' ),
					'tab'	        => 'ewd-otp-labelling-tab',
				),
				$ewd_otp_labelling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-order-form-display',
			'text',
			array(
				'id'            => 'label-customer-order-name',
				'title'         => __( 'Order Name', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-order-form-display',
			'text',
			array(
				'id'            => 'label-customer-order-email',
				'title'         => __( 'Order Email Address', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-order-form-display',
			'text',
			array(
				'id'            => 'label-customer-order-email-instructions',
				'title'         => __( 'Email Instructions', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-order-form-display',
			'text',
			array(
				'id'            => 'label-customer-order-notes',
				'title'         => __( 'Customer Notes', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-order-form-display',
			'text',
			array(
				'id'            => 'label-customer-order-button',
				'title'         => __( 'Send Order button', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-labelling-customer-order-form-display',
			'text',
			array(
				'id'            => 'label-customer-order-thank-you',
				'title'         => __( 'Thank You Message', 'order-tracking' ),
				'description'	=> ''
			)
		);

		if ( ! $ewd_otp_controller->permissions->check_permission( 'styling' ) ) {
			$ewd_otp_styling_permissions = array(
				'disabled'		=> true,
				'disabled_image'=> '#',
				'purchase_link'	=> 'https://www.etoilewebdesign.com/plugins/order-tracking/'
			);
		}
		else { $ewd_otp_styling_permissions = array(); }

		$sap->add_section(
			'ewd-otp-settings',
			array(
				'id'            => 'ewd-otp-styling-tab',
				'title'         => __( 'Styling', 'order-tracking' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-otp-settings',
			array_merge(
				array(
					'id'            => 'ewd-otp-styling',
					'title'         => __( 'Styling Options', 'order-tracking' ),
					'tab'	        => 'ewd-otp-styling-tab',
				),
				$ewd_otp_styling_permissions
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-title-font',
				'title'         => __( 'Title Font Family', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-title-font-size',
				'title'         => __( 'Title Font Size', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'colorpicker',
			array(
				'id'			=> 'styling-title-font-color',
				'title'			=> __( 'Title Font Color', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-title-margin',
				'title'         => __( 'Title Margin', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-title-padding',
				'title'         => __( 'Title Padding', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-label-font',
				'title'         => __( 'Label Font Family', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-label-font-size',
				'title'         => __( 'Label Font Size', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'colorpicker',
			array(
				'id'			=> 'styling-label-font-color',
				'title'			=> __( 'Label Font Color', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-label-margin',
				'title'         => __( 'Label Margin', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-label-padding',
				'title'         => __( 'Label Padding', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-content-font',
				'title'         => __( 'Content Font Family', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-content-font-size',
				'title'         => __( 'Content Font Size', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'colorpicker',
			array(
				'id'			=> 'styling-content-font-color',
				'title'			=> __( 'Content Font Color', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-content-margin',
				'title'         => __( 'Content Margin', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-content-padding',
				'title'         => __( 'Content Padding', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'colorpicker',
			array(
				'id'			=> 'styling-button-font-color',
				'title'			=> __( 'Button Font Color', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'colorpicker',
			array(
				'id'			=> 'styling-button-background-color',
				'title'			=> __( 'Button Background Color', 'order-tracking' )
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-button-border',
				'title'         => __( 'Button Border', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-button-margin',
				'title'         => __( 'Button Margin', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-otp-settings',
			'ewd-otp-styling',
			'text',
			array(
				'id'            => 'styling-button-padding',
				'title'         => __( 'Button Padding', 'order-tracking' ),
				'description'	=> ''
			)
		);

		$sap = apply_filters( 'ewd_otp_settings_page', $sap );

		$sap->add_admin_menus();

	}

	/**
	 * Create a set of default statuses and emails if none exist
	 * @since 3.0.0
	 */
	public function create_default_statuses_and_emails() {

		$statuses = ewd_otp_decode_infinite_table_setting( $this->get_setting( 'statuses' ) );

		if ( ! empty( $statuses ) ) { return; }

		$emails = array(
			array(
				'id'			=> 1,
				'name'			=> __( 'Default', 'order-tracking' ),
				'subject'		=> __( 'Order Status Update', 'order-tracking' ),
				'message'		=> __( 'Hello [order-name], You have an update for your order [order-number]!', 'order-tracking' )
			)
		);

		$this->set_setting( 'email-messages', json_encode( $emails ) );

		$statuses = array(
			array(
				'status'		=> __( 'Pending Payment', 'order-tracking' ),
				'percentage'	=> '25',
				'email'			=> 1,
				'internal'		=> 'no',
			),
			array(
				'status'		=> __( 'Processing', 'order-tracking' ),
				'percentage'	=> '50',
				'email'			=> 1,
				'internal'		=> 'no',
			),
			array(
				'status'		=> __( 'On Hold', 'order-tracking' ),
				'percentage'	=> '50',
				'email'			=> 1,
				'internal'		=> 'no',
			),
			array(
				'status'		=> __( 'Completed', 'order-tracking' ),
				'percentage'	=> '100',
				'email'			=> 1,
				'internal'		=> 'no',
			),
			array(
				'status'		=> __( 'Cancelled', 'order-tracking' ),
				'percentage'	=> '0',
				'email'			=> 1,
				'internal'		=> 'no',
			),
			array(
				'status'		=> __( 'Refunded', 'order-tracking' ),
				'percentage'	=> '0',
				'email'			=> 1,
				'internal'		=> 'no',
			),
			array(
				'status'		=> __( 'Failed', 'order-tracking' ),
				'percentage'	=> '0',
				'email'			=> 1,
				'internal'		=> 'no',
			),
		);


		$this->set_setting( 'statuses', json_encode( $statuses ) );

		$this->save_settings();
	}

	/**
	 * Load all custom fields 
	 * @since 3.0.0
	 */
	public function get_custom_fields() {
		
		$custom_fields = is_array( get_option( 'ewd-otp-custom-fields' ) ) ? get_option( 'ewd-otp-custom-fields' ) : array();

		return $custom_fields;
	}

	/**
	 * Load the custom fields related to orders
	 * @since 3.0.0
	 */
	public function get_order_custom_fields() {
		
		$custom_fields = is_array( get_option( 'ewd-otp-custom-fields' ) ) ? get_option( 'ewd-otp-custom-fields' ) : array();

		$return_fields = array();

		foreach ( $custom_fields as $custom_field ){

			if ( $custom_field->function == 'orders' ) { $return_fields[] = $custom_field; }
		}

		return $return_fields;
	}

	/**
	 * Load the custom fields related to customers
	 * @since 3.0.0
	 */
	public function get_customer_custom_fields() {
		
		$custom_fields = is_array( get_option( 'ewd-otp-custom-fields' ) ) ? get_option( 'ewd-otp-custom-fields' ) : array();

		$return_fields = array();

		foreach ( $custom_fields as $custom_field ){

			if ( $custom_field->function == 'customers' ) { $return_fields[] = $custom_field; }
		}

		return $return_fields;
	}

	/**
	 * Load the custom fields related to sales reps
	 * @since 3.0.0
	 */
	public function get_sales_rep_custom_fields() {
		
		$custom_fields = is_array( get_option( 'ewd-otp-custom-fields' ) ) ? get_option( 'ewd-otp-custom-fields' ) : array();

		$return_fields = array();

		foreach ( $custom_fields as $custom_field ){

			if ( $custom_field->function == 'sales_reps' ) { $return_fields[] = $custom_field; }
		}

		return $return_fields;
	}
}
} // endif;
