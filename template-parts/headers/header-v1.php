<?php
/**
 * Template for displaying header (template 1)
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

$header_sticky          = ( 'fix' === $mihanpress_options['fix_header_type'] && '1' === $mihanpress_options['fix_header_type_sticky'] ) ? ' hide-on-scroll' : '';
$header_fix             = 'fix' === $mihanpress_options['fix_header_type'] ? ' id="fix-on-scroll" ' : '';
$header_data_scroll_top = ! empty( $mihanpress_options['fixed_header_top'] ) ? $mihanpress_options['fixed_header_top'] : 500;
?>
<div id="replacehead"></div>
<section class="nav-container d-flex justify-content-between align-items-center <?php echo esc_attr( $header_sticky ); ?>" <?php echo $header_fix; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> data-scroll-top="<?php echo esc_attr( $header_data_scroll_top ); ?>">
	<div class="container d-flex align-items-center justify-content-between flex-wrap p-0">
		<?php
		get_template_part( 'template-parts/headers/templates/logo' );
		get_template_part( 'template-parts/headers/templates/navbar' );
		?>

		<div class="d-flex align-items-start mt-1 mr-auto flex-navbar-grow-1 justify-content-navbar-end">
			<div class="d-flex justify-content-center flex-wrap align-items-center align-self-center nav-icons">
				<?php
				get_template_part( 'template-parts/headers/templates/shopping-cart' );
				get_template_part( 'template-parts/headers/templates/search-icon' );
				?>
			</div>

			<div class="nav-btn mr-2 ml-2 d-flex flex-wrap">
				<?php get_template_part( 'template-parts/headers/templates/nav-button' ); ?>
			</div>

			<?php
			if ( '1' === $mihanpress_options['sidenav_desktop'] && 'left' === $mihanpress_options['sidenav_desktop_position'] ) {
				get_template_part( 'template-parts/headers/templates/sidenav-trigger' );
			}
			?>
		</div>
	</div>
</section>
<?php
get_template_part( 'template-parts/headers/templates/search-modal' );
get_template_part( 'template-parts/headers/templates/sidenav' );
