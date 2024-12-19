<?php
/**
 * This plugin made for Themelooks.com
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Product Extra Addons
 * Plugin URI:        https://themelooks.com/
 * Description:       WooCommerce Product Extra Addons
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Themelooks
 * Author URI:        https://themelooks.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woo-extra-addons-options
 * Domain Path:       /languages
 * 
 * @package WooXtraAddons
 * @author  Themelooks (https://themelooks.com/)
 * @version 1.0.2
 * @link https://github.com/mahmudremal/woocommerce-extra-addons/
 * @category	WooComerce Plugin
 * @copyright	Copyright (c) 2023-25
 * 
 */

/**
 * Bootstrap the plugin.
 */



defined( 'WOO_XTRA_ADDONS__FILE__' ) || define( 'WOO_XTRA_ADDONS__FILE__', untrailingslashit( __FILE__ ) );
defined( 'WOO_XTRA_ADDONS_DIR_PATH' ) || define( 'WOO_XTRA_ADDONS_DIR_PATH', untrailingslashit( plugin_dir_path( WOO_XTRA_ADDONS__FILE__ ) ) );
defined( 'WOO_XTRA_ADDONS_DIR_URI' ) || define( 'WOO_XTRA_ADDONS_DIR_URI', untrailingslashit( plugin_dir_url( WOO_XTRA_ADDONS__FILE__ ) ) );
defined( 'WOO_XTRA_ADDONS_BUILD_URI' ) || define( 'WOO_XTRA_ADDONS_BUILD_URI', untrailingslashit( WOO_XTRA_ADDONS_DIR_URI ) . '/assets/build' );
defined( 'WOO_XTRA_ADDONS_BUILD_PATH' ) || define( 'WOO_XTRA_ADDONS_BUILD_PATH', untrailingslashit( WOO_XTRA_ADDONS_DIR_PATH ) . '/assets/build' );
defined( 'WOO_XTRA_ADDONS_BUILD_JS_URI' ) || define( 'WOO_XTRA_ADDONS_BUILD_JS_URI', untrailingslashit( WOO_XTRA_ADDONS_DIR_URI ) . '/assets/build/js' );
defined( 'WOO_XTRA_ADDONS_BUILD_JS_DIR_PATH' ) || define( 'WOO_XTRA_ADDONS_BUILD_JS_DIR_PATH', untrailingslashit( WOO_XTRA_ADDONS_DIR_PATH ) . '/assets/build/js' );
defined( 'WOO_XTRA_ADDONS_BUILD_IMG_URI' ) || define( 'WOO_XTRA_ADDONS_BUILD_IMG_URI', untrailingslashit( WOO_XTRA_ADDONS_DIR_URI ) . '/assets/build/src/img' );
defined( 'WOO_XTRA_ADDONS_BUILD_CSS_URI' ) || define( 'WOO_XTRA_ADDONS_BUILD_CSS_URI', untrailingslashit( WOO_XTRA_ADDONS_DIR_URI ) . '/assets/build/css' );
defined( 'WOO_XTRA_ADDONS_BUILD_CSS_DIR_PATH' ) || define( 'WOO_XTRA_ADDONS_BUILD_CSS_DIR_PATH', untrailingslashit( WOO_XTRA_ADDONS_DIR_PATH ) . '/assets/build/css' );
defined( 'WOO_XTRA_ADDONS_BUILD_LIB_URI' ) || define( 'WOO_XTRA_ADDONS_BUILD_LIB_URI', untrailingslashit( WOO_XTRA_ADDONS_DIR_URI ) . '/assets/build/library' );
defined( 'WOO_XTRA_ADDONS_ARCHIVE_POST_PER_PAGE' ) || define( 'WOO_XTRA_ADDONS_ARCHIVE_POST_PER_PAGE', 9 );
defined( 'WOO_XTRA_ADDONS_SEARCH_RESULTS_POST_PER_PAGE' ) || define( 'WOO_XTRA_ADDONS_SEARCH_RESULTS_POST_PER_PAGE', 9 );
defined( 'WOO_XTRAADDONS_OPTIONS' ) || define( 'WOO_XTRAADDONS_OPTIONS', get_option( 'woo-extra-addons-options' ) );

require_once WOO_XTRA_ADDONS_DIR_PATH . '/inc/helpers/autoloader.php';
// require_once WOO_XTRA_ADDONS_DIR_PATH . '/inc/helpers/template-tags.php';

if( ! function_exists( 'woo_extra_options_plugin_instance' ) ) {
	function woo_extra_options_plugin_instance() {\WOOXTRAADDONS\inc\Project::get_instance();}
}
woo_extra_options_plugin_instance();



