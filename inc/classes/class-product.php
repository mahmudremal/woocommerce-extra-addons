<?php
/**
 * LoadmorePosts
 *
 * @package WooXtraAddons
 */
namespace WOOXTRAADDONS\inc;
use WOOXTRAADDONS\inc\Traits\Singleton;
class Product {
	use Singleton;
	protected function __construct() {
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		add_action('woocommerce_before_add_to_cart_button', [ $this, 'display_product_options' ]);
	}
	public function display_product_options() {
		global $post;
		$_tabs = get_post_meta($post->ID, '_extra_product_addons', true);
		if ($_tabs) {
			if (is_string($_tabs)) {
				$_tabs = json_decode($_tabs, true);
			}
			?>
			<h3><?php echo esc_html('Extra Item', 'woo-extra-addons-options'); ?></h3>
			<div class="product-options">
				<?php foreach ($_tabs as $index => $tab): ?>
					<div class="product-tab <?php echo $index === 0 ? 'active' : ''; ?>">
						<h3 class="tab-title" data-index="<?php echo $index; ?>"><?php echo esc_html($tab['tabTitle']); ?></h3>
						<div class="tab-content" style="<?php echo $index === 0 ? 'display:block;' : 'display:none;'; ?>" data-required-fields="<?php echo esc_attr(isset($tab['tabRequired']) && $tab['tabRequired']); ?>">
							<p><?php echo esc_html($tab['tabContent']); ?></p>
							<?php foreach ($tab['tabOptions'] as $option): ?>
								<div class="product-option">
									<label>
										<input type="checkbox" name="product_options[]" value="<?php echo esc_attr(json_encode([$option['title'], $option['price']])); ?>">
										<?php if ($option['thumbnail'] && $option['thumbnail'] !== ''): ?>
											<img src="<?php echo esc_url($option['thumbnail']); ?>" alt="<?php echo esc_attr($option['title']); ?>" style="width:50px;height:auto;">
										<?php endif; ?>
										<span><?php echo esc_html($option['title']); ?></span>
										<?php if ($option['price'] > 0): ?>
											<span><?php echo wc_price($option['price']); ?></span>
										<?php endif; ?>
									</label>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php
		}
	}
}
