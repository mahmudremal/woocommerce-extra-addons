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

	/**
	 * Constructor for the Project class.
	 * Loads necessary classes and sets up hooks.
	 */
	protected function __construct() {
		// Load class instances.
		Assets::get_instance();
		Cart::get_instance();
		Meta_Boxes::get_instance();
		Product::get_instance();
		// Uncomment the following line if setup_hooks needs to be called.
		// $this->setup_hooks();
	}

	/**
	 * Sets up WordPress hooks for the project.
	 */
	protected function setup_hooks() {
		add_action( 'init', [ $this, 'init' ], 1, 0 );
		register_activation_hook( WOO_XTRA_ADDONS__FILE__, [ $this, 'register_activation_hook' ] );
		register_deactivation_hook( WOO_XTRA_ADDONS__FILE__, [ $this, 'register_deactivation_hook' ] );
	}

	/**
	 * Initializes the plugin.
	 * Loads the text domain for localization.
	 */
	public function init() {
		load_plugin_textdomain( 'woo-extra-addons-options', false, dirname( plugin_basename( WOO_XTRA_ADDONS__FILE__ ) ) . '/languages' );		
	}

	/**
	 * Handles tasks to be performed on plugin activation.
	 */
	public function register_activation_hook() {
		// Perform setup tasks here.
	}

	/**
	 * Handles tasks to be performed on plugin deactivation.
	 */
	public function register_deactivation_hook() {
		// Perform cleanup tasks here.
	}
}
