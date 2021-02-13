<?php
/**
 * Sidebar template for archive and single pages of blog
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
$sidebar_col = ! empty( $mihanpress_options['blog_single_sidebar_col'] ) ? $mihanpress_options['blog_single_sidebar_col'] : 3;
?>
<aside id="sticky-sidebar" class="sticky-sidebar col-lg-<?php echo esc_attr( $sidebar_col ); ?> col-ml-12 widget-sidebar p-0">
	<div class="sidebar__inner pr-lg-2 pl-lg-2 pr-md-2 pl-md-2 pr-sm-1 pl-sm-1 pr-1 pl-1">
		<ul class="widget_container">
			<?php dynamic_sidebar( 'sidebar_blog' ); ?>
		</ul>
	</div>
</aside><!--sidebar-->
