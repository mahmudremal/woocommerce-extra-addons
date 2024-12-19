<?php
/**
 * @package WooXtraAddons
 */
namespace WOOXTRAADDONS\inc;
use WOOXTRAADDONS\inc\Traits\Singleton;
class Cart {
	use Singleton;
	protected function __construct() {
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		add_filter('woocommerce_add_cart_item_data', [ $this, 'add_product_options_to_cart' ], 10, 2);
		add_filter('woocommerce_get_item_data', [ $this, 'display_product_options_in_cart' ], 10, 2);
		add_action('woocommerce_before_calculate_totals', [ $this, 'update_cart_total_with_options' ]);
	}
	public function add_product_options_to_cart($cart_item_data, $product_id) {
		if (isset($_POST['product_options'])) {
			$_options = $_POST['product_options'];
			if (is_array($_options)) {
				foreach ($_options as $index => $option) {
					$_options[$index] = json_decode(stripslashes($option), true);
				}
			}
			$cart_item_data['product_options'] = json_encode($_options);
		}
		return $cart_item_data;
	}

	// Display selected options in the cart
	public function display_product_options_in_cart($item_data, $cart_item) {
		if (isset($cart_item['product_options'])) {
			$_options = json_decode($cart_item['product_options'], true);
			$_options = array_map(function($option) {
				[$label, $price] = $option;
				$price = floatval($price);
				return $label . ' (' . wc_price($price) . ')';
			}, $_options);
			$item_data[] = array(
				'name' => __('Product Options', 'woo-extra-addons-options'),
				'value' => implode(", \n", $_options)
			);
		}
		return $item_data;
	}
	// Adjust the cart total based on selected options
	public function update_cart_total_with_options($cart) {
		if (is_admin() && !defined('DOING_AJAX')) return;

		foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
			// Reset the price to the original product price
			$product = $cart_item['data'];
			$base_price = $product->get_regular_price();
			$additional_price = 0;

			if (isset($cart_item['product_options'])) {
				$_options = json_decode($cart_item['product_options'], true);
				foreach ($_options as $option) {
					$additional_price += floatval($option[1]);
				}
			}

			// Set the new price
			$product->set_price($base_price + $additional_price);
		}
	}
}
