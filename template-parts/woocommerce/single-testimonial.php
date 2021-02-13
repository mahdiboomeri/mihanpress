<?php
/**
 * Template for displaying woocommerce testiminials
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $product_id;
$items = get_post_meta( get_the_ID(), 'mihanpress_product_testimonial_items', true );

if ( ! empty( $items[0]['mihanpress_customer_name'] ) ) {
	?>
	<span class="product_section_title"><?php esc_html_e( 'نظرات مشتریان', 'mihanpress' ); ?></span>
	<section id="mp-testimonial" class="product_testimonial mp-scrollspy-section d-flex justify-content-between flex-wrap mb-5">

		<?php foreach ( (array) $items as $item ) : ?>
			<section class="col-lg-6 col-md-6 col-sm-12 mb-1 p-0">
				<div class="testimonial_product position-relative box box-shadow-sm m-0 m-sm-1 m-md-2 m-lg-2">

					<figure>
						<img src="<?php echo esc_url( $item['mihanpress_image'] ); ?>" alt="<?php echo esc_attr( $item['mihanpress_customer_name'] ); ?>">
					</figure>

					<div class="mt-4">
						<header>
							<?php if ( ! empty( $item['mihanpress_customer_link'] ) ) : ?>

								<a href="<?php echo esc_url( $item['mihanpress_customer_link'] ); ?>">
									<h3>
										<?php echo esc_html( $item['mihanpress_customer_name'] ); ?>
									</h3>

									<?php if ( ! empty( $item['mihanpress_customer_job'] ) ) : ?>
										<span>
											<?php echo esc_html( $item['mihanpress_customer_job'] ); ?>
										</span>
									<?php endif; ?>
								</a>

							<?php else : ?>

								<h3>
									<?php echo esc_html( $item['mihanpress_customer_name'] ); ?>
								</h3>
								<?php if ( ! empty( $item['mihanpress_customer_job'] ) ) : ?>
									<span>
										<?php echo esc_html( $item['mihanpress_customer_job'] ); ?>
									</span>
								<?php endif; ?>

							<?php endif; ?>
						</header>

						<p>
							<?php echo wp_kses_post( $item['mihanpress_customer_review'] ); ?>
						</p>

					</div>
				</div><!--.testimonial_product-->
			</section>
		<?php endforeach; ?>

	</section><!--#mp-testimonial-->
	<?php
}
