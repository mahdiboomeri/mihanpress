<?php
/**
 * Template for displaying navbar in header
 *
 * @package MihanPress
 * @since 1.0.0
 */

?>
<nav class="navbar align-self-center">
	<?php
	if ( has_nav_menu( 'top_menu' ) ) :
		wp_nav_menu(
			array(
				'theme_location' => 'top_menu',
				'container'      => false,
				'menu_class'     => 'd-flex flex-wrap',
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
