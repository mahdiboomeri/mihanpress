<?php
/**
 * Sidebar template for archive pages of WooCommerce
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
$sidebar_col = ! empty( $mihanpress_options['shop_sidebar_col'] ) ? $mihanpress_options['shop_sidebar_col'] : 3;
?>
<aside id="sticky-sidebar" class="sticky-sidebar col-lg-<?php echo esc_attr( $sidebar_col ); ?> col-ml-12 widget-sidebar p-0">
	<div class="sidebar__inner pr-lg-3 pl-lg-3 pr-md-3 pl-md-3 pr-sm-1 pl-sm-1 pr-1 pl-1">
		<ul class="widget_container">
			<?php dynamic_sidebar( 'sidebar_shop_woocommerce' ); ?>
		</ul>
	</div>
</aside><!--sidebar-->
