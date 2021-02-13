<?php
/**
 * Template for displaying woocommerce meta (like modified date) in info box (custom metabox)
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $product, $mihanpress_options;
?>
<div class="mb-4">

	<?php if ( '1' === $mihanpress_options['shop_update_date'] ) : ?>
		<div class="mp_product_extra_meta alert-success">
			<span class="date_modified">
				<?php
				printf(
					esc_html__( 'آپدیت شده در %s پیش', 'mihanpress' ),
					human_time_diff( $product->get_date_modified()->date( 'U' ), current_time( 'timestamp' ) )
				);
				?>
			</span>
		</div>
	<?php endif; ?>

	<?php
	$items = get_post_meta( get_the_ID(), 'mihanpress_product_information_items', true );
	if ( ! empty( $items[0]['mihanpress_information_text'] ) ) {
		foreach ( (array) $items as $item ) :
			if ( ! empty( $item['mihanpress_information_text'] ) ) :
				?>

				<div class="mp_product_extra_meta mt-2 <?php echo esc_attr( $item['mihanpress_information_color'] ); ?>">
					<?php echo esc_html( $item['mihanpress_information_text'] ); ?>
				</div>

				<?php
			endif;
		endforeach;
	}
	?>
</div>
