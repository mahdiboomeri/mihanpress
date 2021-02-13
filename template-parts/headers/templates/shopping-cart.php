<?php
/**
 * Template for displaying shopping cart dropdown (WooCommerce) in header
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

if ( class_exists( 'WooCommerce' ) && '1' === $mihanpress_options['shopping_cart'] ) {
	?>

	<div class="d-flex shopping-cart mr-3">
		<span class="<?php echo ! empty( $mihanpress_options['shopping_cart_icon'] ) ? sanitize_html_class( $mihanpress_options['shopping_cart_icon'] ) : 'flaticon-cart'; ?> shopping-cart__trigger d-flex">
			<span class="shopping-cart__count">
				<span class="header-cart-count">
					<?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>
				</span>
			</span>
		</span>

		<?php if ( ! is_cart() ) : ?>
			<div class="shopping-cart__content">
				<ul class="mega_menu cart">
					<li class="mega_sub">
						<div id="mcart-widget">
							<?php woocommerce_mini_cart(); ?>
						</div>
					</li>
				</ul>
			</div><!--.shopping-cart__content-->
		<?php endif; ?>

	</div><!--.shopping-cart-->

	<?php
}
