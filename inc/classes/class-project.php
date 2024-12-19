<?php
/**
 * Bootstraps the Theme.
 *
 * @package WooXtraAddons
 */
namespace WOOXTRAADDONS\inc;
use WOOXTRAADDONS\inc\Traits\Singleton;
class Project {
	use Singleton;
	protected function __construct() {
		// Load class.
		Assets::get_instance();
		Cart::get_instance();
		Meta_Boxes::get_instance();
		Product::get_instance();
		// 
		// $this->setup_hooks();
	}
	protected function setup_hooks() {
		add_action( 'init', [ $this, 'init' ], 1, 0 );
		register_activation_hook( WOO_XTRA_ADDONS__FILE__, [ $this, 'register_activation_hook' ] );
		register_deactivation_hook( WOO_XTRA_ADDONS__FILE__, [ $this, 'register_deactivation_hook' ] );
	}
	public function init() {
		/**
		 * loco translator Lecto AI: api: V13Y91F-DR14RP6-KP4EAF9-S44K7SX
		 */
		load_plugin_textdomain( 'woo-extra-addons-options', false, dirname( plugin_basename( WOO_XTRA_ADDONS__FILE__ ) ) . '/languages' );		
	}
	public function register_activation_hook() {
		global $wpdb;$prefix = $wpdb->prefix . 'fwp_';
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$charset_collate = $wpdb->get_charset_collate();
		$tables = [];
		foreach( $tables as $table ) {
			dbDelta( $table );
		}
		$options = [ 'fwp_google_auth_code', 'fwp_google_afterauth_redirect' ];
		foreach( $options as $option ) {
			if( ! get_option( $option, false ) ) {add_option( $option, [] );}
		}
	}
	public function register_deactivation_hook() {
		global $wpdb;$prefix = $wpdb->prefix . 'fwp_';
		$tables = []; // [ 'stripe_payments', 'stripe_subscriptions', 'googledrive' ];
		foreach( $tables as $table ) {
			// $wpdb->query( "DROP TABLE IF EXISTS {$prefix}{$table};" );
		}
	}
}
