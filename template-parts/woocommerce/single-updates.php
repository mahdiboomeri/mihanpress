<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product_id;
$updates_content = get_post_meta( get_the_ID(), 'mihanpress_product_updates_content', true );
if ( ! empty( $updates_content ) ) :
	?>
	<span class="product_section_title"><?php esc_html_e( 'لیست بروزرسانی ها', 'mihanpress' ); ?></span>
	<section id="mp-updates" class="product-update-list tick-list mp-scrollspy-section box box-shadow-lg">
		<?php
		echo wp_kses_post( $updates_content );
		?>
	</section>
	<?php
endif;
