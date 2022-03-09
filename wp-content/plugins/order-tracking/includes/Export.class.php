<?php

/**
 * Class to export orders created by the plugin
 */

if ( !defined( 'ABSPATH' ) )
	exit;

if (!class_exists('ComposerAutoloaderInit4618f5c41cf5e27cc7908556f031e4d4')) { require_once EWD_OTP_PLUGIN_DIR . '/lib/PHPSpreadsheet/vendor/autoload.php'; }
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
class ewdotpExport {

	// Set whether a valid nonce is needed before exporting orders
	public $nonce_check = true;

	public function __construct() {
		add_action( 'admin_menu', array($this, 'register_install_screen' ));

		if ( isset( $_POST['ewd_otp_export'] ) ) { add_action( 'admin_menu', array($this, 'export_orders' )); }

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_export_scripts' ) );
	}

	public function register_install_screen() {
		global $ewd_otp_controller;
		
		add_submenu_page( 
			'ewd-otp-orders', 
			'Export Menu', 
			'Export', 
			$ewd_otp_controller->settings->get_setting( 'access-role' ), 
			'ewd-otp-export', 
			array($this, 'display_export_screen') 
		);
	}

	public function display_export_screen() {
		global $ewd_otp_controller;

		$export_permission = $ewd_otp_controller->permissions->check_permission( 'export' );

		?>
		<div class='wrap'>
			<h2>Export</h2>
			<?php if ( $export_permission ) { ?> 
				<form method='post'>
					<?php wp_nonce_field( 'EWD_OTP_Export', 'EWD_OTP_Export_Nonce' );  ?>
					<input type='submit' name='ewd_otp_export' value='Export to Spreadsheet' class='button button-primary' />
				</form>
			<?php } else { ?>
				<div class='ewd-otp-premium-locked'>
					<a href="https://www.etoilewebdesign.com/license-payment/?Selected=OTP&Quantity=1" target="_blank">Upgrade</a> to the premium version to use this feature
				</div>
			<?php } ?>
		</div>
	<?php }

	public function export_orders() {
		global $ewd_otp_controller;

		if ( $this->nonce_check and ! isset( $_POST['EWD_OTP_Export_Nonce'] ) ) { return; }

    	if ( $this->nonce_check and ! wp_verify_nonce( $_POST['EWD_OTP_Export_Nonce'], 'EWD_OTP_Export' ) ) { return; }

		$custom_fields = $ewd_otp_controller->settings->get_order_custom_fields();

		// Instantiate a new PHPExcel object
		$spreadsheet = new Spreadsheet();
		// Set the active Excel worksheet to sheet 0
		$spreadsheet->setActiveSheetIndex(0);

		// Print out the regular order field labels
		$spreadsheet->getActiveSheet()->setCellValue( 'A1', 'Name' );
		$spreadsheet->getActiveSheet()->setCellValue( 'B1', 'Number' );
		$spreadsheet->getActiveSheet()->setCellValue( 'C1', 'Order Status' );
		$spreadsheet->getActiveSheet()->setCellValue( 'D1', 'Order Status Updated (Read-Only)' );
		$spreadsheet->getActiveSheet()->setCellValue( 'E1', 'Location' );
		$spreadsheet->getActiveSheet()->setCellValue( 'F1', 'Display' );
		$spreadsheet->getActiveSheet()->setCellValue( 'G1', 'Notes Public' );
		$spreadsheet->getActiveSheet()->setCellValue( 'H1', 'Notes Private' );
		$spreadsheet->getActiveSheet()->setCellValue( 'I1', 'Email' );
		$spreadsheet->getActiveSheet()->setCellValue( 'J1', 'Customer' );
		$spreadsheet->getActiveSheet()->setCellValue( 'K1', 'Sales Rep' );

		$column = 'L';
		foreach ( $custom_fields as $custom_field ) {

			$spreadsheet->getActiveSheet()->setCellValue( $column . '1', $custom_field->name );
    		$column++;
		}

		//start while loop to get data
		$row_count = 2;

		$args = array(
			'orders_per_page'	=> -1,
			'display'			=> true,
		);

		if ( ! empty( $this->customer_id ) ) { $args['customer'] = $this->customer_id; }
		if ( ! empty( $this->sales_rep_id ) ) { $args['sales_rep'] = $this->sales_rep_id; }
		if ( ! empty( $this->after ) ) { $args['after'] = $this->after; }

		$orders = $ewd_otp_controller->order_manager->get_matching_orders( $args );

		foreach ( $orders as $order ) {

    	 	$spreadsheet->getActiveSheet()->setCellValue( 'A' . $row_count, $order->name );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'B' . $row_count, $order->number );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'C' . $row_count, $order->status );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'D' . $row_count, $order->status_updated );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'E' . $row_count, $order->location );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'F' . $row_count, ( $order->display ? 'Yes' : 'No' ) );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'G' . $row_count, $order->notes_public );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'H' . $row_count, $order->notes_private );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'I' . $row_count, $order->email );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'J' . $row_count, max( $order->customer, 0 ) );
    	 	$spreadsheet->getActiveSheet()->setCellValue( 'K' . $row_count, max( $order->sales_rep, 0 ) );

			$column = 'L';
			foreach ( $custom_fields as $custom_field ) {

				$spreadsheet->getActiveSheet()->setCellValue( $column . $row_count, $ewd_otp_controller->order_manager->get_field_value( $custom_field->id, $order->id ) );
   				$column++;
			}
			
    		$row_count++;
		}

		// Redirect output to a client’s web browser (Excel5)
		if ( ! isset( $format_type ) == 'csv' ) {

			ob_clean();

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="orders_export.csv"');
			header('Cache-Control: max-age=0');
			$objWriter = new Csv($spreadsheet);
			$objWriter->save('php://output');
			die();
		}
		else {

			ob_clean();

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="orders_export.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = new Xls($spreadsheet);
			$objWriter->save('php://output');
			die();
		}
	}

	public function enqueue_export_scripts() {

		$screen = get_current_screen();

		if ( $screen->id == 'ewd-otp-tracking_page_ewd-otp-export' ) {

			wp_enqueue_style( 'ewd-otp-admin-css', EWD_OTP_PLUGIN_URL . '/assets/css/ewd-otp-admin.css', array(), EWD_OTP_VERSION );
			wp_enqueue_script( 'ewd-otp-admin-js', EWD_OTP_PLUGIN_URL . '/assets/js/ewd-otp-admin.js', array( 'jquery' ), EWD_OTP_VERSION, true );
		}
	}

}


