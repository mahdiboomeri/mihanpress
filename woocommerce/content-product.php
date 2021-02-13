<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<?php
if ( ( is_shop() || ( class_exists( 'WeDevs_Dokan' ) && dokan_is_store_page() ) ) && wp_script_is( 'mihanpress-masonry', 'enqueued' ) ) {
	?>
	<article <?php wc_product_class( 'p-2 pt-2', $product ); ?>>
	<?php
} else {
	?>
		<article <?php wc_product_class( 'col-lg-4 col-md-6 col-sm-12 p-2 pt-2', $product ); ?>>
		<?php
}
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
?>

		<div class="card card-product d-flex flex-column out-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php
				/**
				 * Hook: woocommerce_before_shop_loop_item_title.
				 *
				 * @hooked mihanpress_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</a>

			<div class="card__content">
				<header>
					<div class="category-badge pb-2">
						<?php the_terms( $post->ID, 'product_cat', '', ' ' ); ?>
					</div>
					<?php
					/**
					 * Hook: woocommerce_shop_loop_item_title.
					 *
					 * @hooked mihanpress_template_loop_product_title - 10
					 */
					do_action( 'woocommerce_shop_loop_item_title' );
					?>
				</header>
			</div>
			<footer class="d-flex justify-content-between align-items-center flex-column">
				<?php
				if ( $product->is_in_stock() ) {
					/**
					 * Hook: woocommerce_after_shop_loop_item_title.
					 *
					 * @hooked woocommerce_template_loop_price - 10
					 * @hooked mihanpress_template_loop_rating - 15
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
					<div class="product-actions pb-4">
						<?php
						/**
						 * Hook: woocommerce_after_shop_loop_item.
						 *
						 * @hooked woocommerce_template_loop_add_to_cart - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item' );
						?>
					</div>
					<?php
				} else {
					echo '<div class="alert-danger product-not-available text-center">' . esc_html__( 'موجود نیست', 'mihanpress' ) . '</div>';
				}
				?>
			</footer>
		</div>
		</article>
