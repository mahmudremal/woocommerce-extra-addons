<?php
/**
 * Enqueue theme assets
 *
 * @package WooXtraAddons
 */
namespace WOOXTRAADDONS\inc;
use WOOXTRAADDONS\inc\Traits\Singleton;
class Assets {
	use Singleton;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ], 10, 1 );
		add_filter( 'wooxtraaddons//siteconfig', [ $this, 'siteConfig' ], 1, 1 );
	}
	public function register_styles() {
		// Enqueue styles.
		$version = $this->filemtime( WOO_XTRA_ADDONS_BUILD_CSS_DIR_PATH . '/public.css' );
		wp_enqueue_style( 'xtra-product-options-public', WOO_XTRA_ADDONS_BUILD_CSS_URI . '/public.css', [], $version, 'all' );
	}
	public function register_scripts() {
		// Enqueue scripts.
		$version = $this->filemtime(WOO_XTRA_ADDONS_BUILD_JS_DIR_PATH.'/public.js');
		wp_enqueue_script( 'xtra-product-options-public', WOO_XTRA_ADDONS_BUILD_JS_URI . '/public.js', ['jquery'], $version, true );
		wp_localize_script( 'xtra-product-options-public', 'fwpSiteConfig', apply_filters( 'wooxtraaddons//siteconfig', [] ) );
	}
	public function admin_enqueue_scripts( $curr_page ) {
		global $post;
		if ( $curr_page !== 'post.php' || get_post_type($post) !== 'product' ) {
			return;
		}
		wp_enqueue_style( 'xtra-product-options-tailwind', WOO_XTRA_ADDONS_DIR_URI . '/assets/tailwind.css', [], $this->filemtime( WOO_XTRA_ADDONS_DIR_PATH . '/assets/tailwind.css' ), 'all' );
		wp_enqueue_style( 'xtra-product-options-admin', WOO_XTRA_ADDONS_BUILD_CSS_URI . '/admin.css', [], $this->filemtime( WOO_XTRA_ADDONS_BUILD_CSS_DIR_PATH . '/admin.css' ), 'all' );
		wp_enqueue_script( 'xtra-product-options-admin', WOO_XTRA_ADDONS_BUILD_JS_URI . '/admin.js', [ 'jquery' ], $this->filemtime( WOO_XTRA_ADDONS_BUILD_JS_DIR_PATH . '/admin.js' ), true );
		
		wp_localize_script('xtra-product-options-admin','fwpSiteConfig',apply_filters('wooxtraaddons//siteconfig',[
			'config' => [
				'category_id' => isset($_GET['tag_ID'])?(int) $_GET['tag_ID']:get_query_var('tag_ID',false)
			]
		]));
	}
	private function filemtime($path) {
		return (file_exists($path)&&!is_dir($path))?filemtime($path):false;
	}
	public function siteConfig( $args ) {
		return wp_parse_args( [
			'ajaxUrl'    		=> admin_url( 'admin-ajax.php' ),
			'ajax_nonce' 		=> wp_create_nonce( 'ajax/verify/nonce' ),
			'buildPath'  		=> WOO_XTRA_ADDONS_BUILD_URI,
			'i18n'				=> [
				'pls_wait'		=> __( 'Please wait...', 'woo-extra-addons-options' ),
			],
			
		], (array) $args );
	}
	public function wp_denqueue_scripts() {}
}
