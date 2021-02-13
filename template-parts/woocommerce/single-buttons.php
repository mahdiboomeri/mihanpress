<?php
/**
 * Template for displaying woocommerce buttons in info box (custom metabox)
 *
 * @package MihanPress
 * @since 1.0.0
 */

$items = get_post_meta( get_the_ID(), 'mihanpress_product_button_items', true );
if ( ! empty( $items[0]['mihanpress_button_text'] ) ) {
	foreach ( (array) $items as $item ) :

		if ( ! empty( $item['mihanpress_button_text'] ) ) :
			$target = ! empty( $item['target'] ) ? $item['target'] : 'blank';
			?>

			<a
				href="<?php echo ! empty( $item['mihanpress_button_link'] ) ? esc_url( $item['mihanpress_button_link'] ) : ''; ?>"
				class="mp_product_extra_button text-center <?php echo esc_attr( $item['mihanpress_button_color'] ); ?>"
				target="_<?php echo esc_attr( $target ); ?>"
			>
				<?php echo esc_html( $item['mihanpress_button_text'] ); ?>
			</a>

			<?php
		endif;

	endforeach;
}
