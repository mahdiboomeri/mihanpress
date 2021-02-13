<?php
/**
 * WooCommerce Orders Table
 *
 * @package MihanPress
 * @since 1.0.0
 */

if ( ! is_admin() ) {
	add_shortcode( 'mihanpress_woo_orders', 'mihanpress_woo_orders' );
}

function mihanpress_woo_orders() {
	woocommerce_account_orders( $current_page );
}
