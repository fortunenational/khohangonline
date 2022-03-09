<?php
/**
 *
 * Plugin Name:          Order Status History for WooCommerce
 * Plugin URI:           https://wordpress.org/plugins/order-status-history-for-woocommerce
 * Description:          WooCommerce plugin for Order Status History and Reports 
 * Version:              1.7.5.1
 * Requires PHP:         7.0
 * Requires at least:    5.0
 * WC requires at least: 3.2
 * WC tested up to:      5.8.0
 * Text Domain:          order-status-history-for-woocommerce
 * Domain Path:          /languages
 * Author:               alx359
 * License:              GPL v3 or later
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 *
 */
namespace oshwoo;

# no direct page access
defined( 'ABSPATH' ) || exit;

# load main class
define( __NAMESPACE__ .'\FILE', __FILE__ );
  include_once plugin_dir_path( __FILE__ ) . 'includes/class_osh.php';

# instantiate class only with WooC 
add_action( 'plugins_loaded', function() {
    if( !class_exists('WooCommerce') ) {
        add_action( 'admin_notices', function() {
            echo '<div class="error"><p>';
            echo sprintf( /* translators: %s: plugin name */
                      __('<b>%s</b> requires of <b>WooCommerce</b> installed and active in order to operate.', 'order-status-history-for-woocommerce'), 
                      get_plugin_data( namespace\FILE )['Name'] );
            echo '</p></div>' . PHP_EOL;
        });
    }
    # late plugin load
    else osh();
});
