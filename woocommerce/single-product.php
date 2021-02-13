<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
<section class="container mb-5 mt-4 pr-lg-3 pl-lg-3 pr-md-2 pl-md-2 pr-sm-1 pl-sm-1 pr-0 pl-0">

	<?php
	/**
	 * Woocommerce_before_main_content hook.
	 */
	do_action( 'woocommerce_before_main_content' );
	?>
	<section id="sticky-content" class="row col-lg-12 flex-ml-column-reverse justify-content-center mr-0 mt-0 ml-0 pr-0 pl-0 pt-0">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php
		endwhile; // end of the loop.
		?>

		<?php
		/**
		 * Woocommerce_after_main_content hook.
		 */
		do_action( 'woocommerce_after_main_content' );
		?>
		<aside id="sticky-sidebar" class="sticky-sidebar col-lg-3 col-ml-12 widget-sidebar pr-0 pl-0 mt-md-3 mt-sm-3 mb-3 mt-lg-0">
			<div class="sidebar__inner pr-2 pl-2">
				<div class="summary box box-shadow-lg entry-summary">
					<?php

					/**
					 * Hook: woocommerce_single_product_summary.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40 => conditionally mananged by theme options
					 * @hooked woocommerce_template_single_sharing - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
					do_action( 'woocommerce_single_product_summary' );
					?>
				</div>


				<?php
				/**
				 * Woocommerce_sidebar hook.
				 */
				do_action( 'woocommerce_sidebar' );
				?>
			</div>

		</aside>
	</section>
</section>


<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
