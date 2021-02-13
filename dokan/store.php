<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 */

$store_user   = dokan()->vendor->get( get_query_var( 'author' ) );
$store_info   = $store_user->get_shop_info();
$map_location = $store_user->get_location();

get_header();
?>
<main id="main" class="container">
	<section class="row mt-2 pb-0">
		<?php do_action( 'woocommerce_before_main_content' ); ?>

		<?php
		dokan_get_template_part(
			'store',
			'sidebar',
			array(
				'store_user'   => $store_user,
				'store_info'   => $store_info,
				'map_location' => $map_location,
			)
		);
		?>

		<div id="dokan-primary" class="dokan-single-store dokan-w8 col-lg-9 col-md-12 col-sm-12 col-12 pr-1 pl-1 m-0">
			<div id="dokan-content" class="store-page-wrap woocommerce" role="main">

				<?php dokan_get_template_part( 'store-header' ); ?>

				<?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

				<?php if ( have_posts() ) { ?>

					<div class="seller-items">

						<?php woocommerce_product_loop_start(); ?>

							<?php
							while ( have_posts() ) :
								the_post();
								?>

								<?php wc_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>

						<?php woocommerce_product_loop_end(); ?>

					</div>

					<?php dokan_content_nav( 'nav-below' ); ?>

				<?php } else { ?>

					<p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'dokan-lite' ); ?></p>

				<?php } ?>
			</div>

		</div><!-- .dokan-single-store -->

		<div class="dokan-clearfix"></div>

		<?php do_action( 'woocommerce_after_main_content' ); ?>
	</section>
</main>
<?php get_footer(); ?>
