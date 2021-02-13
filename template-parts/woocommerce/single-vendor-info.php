<?php
/**
 * Template for displaying Dokan vendor information (custom metabox)
 *
 * @package MihanPress
 * @since 1.0.0
 */

if ( class_exists( 'Dokan_Store_Location' ) ) {
	$vendor_id  = get_post_field( 'post_author', get_the_id() );
	$store_info = dokan_get_store_info( $vendor_id );
	$store_name = $store_info['store_name'];
	$store_url  = dokan_get_store_url( $vendor_id );
	$address    = implode( ' - ', array_filter( array( $store_info['address']['city'], $store_info['address']['street_1'], $store_info['address']['street_2'] ) ) );
	?>

	<span class="product_section_title"><?php esc_html_e( 'اطلاعات فروشنده', 'mihanpress' ); ?></span>
	<div id="mp-vendor-info" class="author-meta mp-scrollspy-section box-shadow-lg box vendor-info d-flex row mt-4 mr-0 ml-0">

		<div class="d-flex align-items-center col-lg-2 col-md-2">
			<img src="<?php echo esc_attr( wp_get_attachment_image_url( $store_info['gravatar'], array( '50', '50' ) ) ); ?>" alt="<?php echo esc_attr( $store_name ); ?>">
		</div>

		<div class="col-lg-10 col-md-10">
			<div class="d-flex align-items-center">
				<b><?php echo esc_html( $store_name ); ?></b>

				<span class="author-meta--link-badge">
					<a href="<?php echo esc_url( $store_url ); ?>">
						<?php esc_html_e( 'مشاهده فروشگاه', 'mihanpress' ); ?>
					</a>
				</span>

			</div>
			<div><?php echo esc_html( $address ); ?></div>
		</div>

	</div><!--#mp-vendor-info-->

	<?php
}
