<?php
/**
 * Template for displaying sidenav content
 *
 * @package MihanPress
 * @since 1.0.0
 */

?>
<div class="sidenav right-sidenav sidenav-fixed" id="responsive-nav">
	<?php do_action( 'mihanpress_before_mobile_sidenav' ); ?>

	<nav>
		<?php
		if ( has_nav_menu( 'responsive_menu' ) ) :
			wp_nav_menu(
				array(
					'theme_location' => 'responsive_menu',
					'container'      => false,
					'menu_class'     => 'collapsible right-sidenav-collapsible',
					'walker'         => new Mihanpress_Collapsible_Nav_Walker(),
				)
			);
		else :
			?>
			<ul class="no-menu">
				<li>
					<a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>" target="_blank"><?php esc_html_e( 'هنوز هیچ منویی برای این قسمت تنظیم نشده است. برای ایجاد منو کلیک کنید.', 'mihanpress' ); ?></a>
				</li>
			</ul>
			<?php
		endif;
		?>
	</nav>

	<?php do_action( 'mihanpress_after_mobile_sidenav' ); ?>

	<div class="mb-5 pt-5"> </div>
</div><!--#responsive-nav-->


<div id="slide-out" class="sidenav desktop-sidenav pt-5 pr-4 pl-4 pb-5">
	<?php
	if ( is_active_sidebar( 'desktop_sidenav' ) ) {
		dynamic_sidebar( 'desktop_sidenav' );
	}
	?>
	<div class="mb-5 pt-5"> </div>

</div><!--#slide-out-->
