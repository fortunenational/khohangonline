<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://tplugins.com/shop
 * @since             1.0.0
 * @package           Tp_Product_Description_In_Loop_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       TP Product Description in Loop for Woocommerce
 * Plugin URI:        http://tplugins.com/
 * Description:       Add product description to your Shop / Category / Archives pages.
 * Version:           1.0.1
 * Author:            TP Plugins
 * Author URI:        http://tplugins.com/shop
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tp-product-description-in-loop-for-woocommerce
 * Domain Path:       /languages
 * WC requires at least: 3.5
 * WC tested up to: 5.5.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TP_PRODUCT_DESCRIPTION_IN_LOOP_FOR_WOOCOMMERCE_VERSION', '1.0.1' );
define('TPPDIL_PLUGIN_NAME', 'TP Product Description in Loop for Woocommerce');
define('TPPDIL_PLUGIN_MENU_NAME', 'TP Product Description in Loop');
define('TPPDIL_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('TPPDIL_PLUGIN_HOME', 'https://www.tplugins.com/');
define('TPPDIL_PLUGIN_API', 'https://www.tplugins.com/tp-services');
define('TPPDIL_PLUGIN_SLUG', 'tp-product-description-in-loop-for-woocommerce');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tp-product-description-in-loop-for-woocommerce-activator.php
 */
function activate_tp_product_description_in_loop_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tp-product-description-in-loop-for-woocommerce-activator.php';
	Tp_Product_Description_In_Loop_For_Woocommerce_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tp-product-description-in-loop-for-woocommerce-deactivator.php
 */
function deactivate_tp_product_description_in_loop_for_woocommerce() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tp-product-description-in-loop-for-woocommerce-deactivator.php';
	Tp_Product_Description_In_Loop_For_Woocommerce_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tp_product_description_in_loop_for_woocommerce' );
register_deactivation_hook( __FILE__, 'deactivate_tp_product_description_in_loop_for_woocommerce' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tp-product-description-in-loop-for-woocommerce.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tp_product_description_in_loop_for_woocommerce() {

	$plugin = new Tp_Product_Description_In_Loop_For_Woocommerce();
	$plugin->run();

}
run_tp_product_description_in_loop_for_woocommerce();