<?php
/**
 * Register Meta Boxes
 *
 * @package WooXtraAddons
 */
namespace WOOXTRAADDONS\inc;
use WOOXTRAADDONS\inc\Traits\Singleton;
/**
 * Class Meta_Boxes
 */
class Meta_Boxes {
	use Singleton;
	protected function __construct() {
		// load class.
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		/**
		 * Actions.
		 */
		add_action( 'add_meta_boxes', [ $this, 'add_custom_meta_box' ] );
		add_action( 'save_post', [ $this, 'save_product_options' ] );
	}
	/**
	 * Add custom meta box.
	 *
	 * @return void
	 */
	public function add_custom_meta_box() {
		add_meta_box('product_options', 'Product Options', [ $this, 'custom_meta_box_html' ], 'product', 'normal', 'high');
	}
	/**
	 * Custom meta box HTML( for form )
	 *
	 * @param object $post Post.
	 *
	 * @return void
	 */
	public function custom_meta_box_html( $post ) {
		$options = get_post_meta($post->ID, '_extra_product_addons', true) ?: [];
		?>
		<div id="product-options-container" data-tabs="<?php echo esc_attr($options); ?>">
			<h2 class="title"><?php echo esc_html('Extra product options', 'woo-extra-addons-options'); ?></h2>
		</div>
		<?php
	}
	/**
	 * Save post meta into database
	 * when the post is saved.
	 *
	 * @param integer $post_id Post id.
	 *
	 * @return void
	 */
	public function save_product_options( $post_id ) {
		if (isset($_POST['product_options'])) {
			update_post_meta($post_id, '_extra_product_addons', $_POST['product_options']);
		}
	}
}
