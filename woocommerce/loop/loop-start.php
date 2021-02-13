<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( is_shop() || ( class_exists( 'WeDevs_Dokan' ) && dokan_is_store_page() ) ) && wp_script_is( 'mihanpress-masonry', 'enqueued' ) ) :
	?>
	<section class="masonry-grid col-lg-12 m-0 p-0 products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>" data-column="3" data-column-tablet="2" data-column-mobile="1">
	<?php
else :
	?>
	<section class="row col-lg-12 m-0 p-0 products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
	<?php
endif;
