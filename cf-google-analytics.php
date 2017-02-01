<?php
/**

 * @copyright 2017 - CalderaWP LLC - License GPL V2+
 *
 * @wordpress-plugin
* Plugin Name: Caldera Forms Google Analytics
 * Plugin URI: https://calderaforms.com/downloads/caldera-forms-google-analytics-tracking/
 * Description: Google Analytics Tracking For Caldera Forms
 * Version: 1.0.1
 * Author:      Caldera Labs
 * Author URI:  https://calderaforms.com
 * Text Domain: cf-ga
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// define constants
define( 'CF_GA_PATH',  plugin_dir_path( __FILE__ ) );
define( 'CF_GA_URL',  plugin_dir_url( __FILE__ ) );
define( 'CF_GA_VER', '0.0.1' );
define( 'CF_GA_CORE',  __FILE__ );



/**
 * Load the plugin if PHP version is sufficient.
 */
add_action( 'plugins_loaded', 'cf_ga_load_or_not', 0 );
function cf_ga_load_or_not() {
	if ( is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		include_once CF_GA_PATH . 'vendor/calderawp/dismissible-notice/src/functions.php';
	}

	if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
		if ( is_admin() ) {
			$message = __( sprintf( 'Caldera Forms Google Analytics requires PHP version 5.3 or later. We strongly recommend PHP 5.6 or later for security and performance reasons. Current version is %2s.',  PHP_VERSION ), 'cf-ga' );

			echo caldera_warnings_dismissible_notice( $message, true, 'activate_plugins', 'cf_ga_php_nag' );

		}

	} else {
		include_once ( CF_GA_PATH . '/vendor/autoload.php' );
		include_once( CF_GA_PATH . '/bootstrap.php' );

	}

}



