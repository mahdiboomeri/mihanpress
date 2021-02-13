<?php
/**
 * Template for displaying logo in header
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

$logo_desktop = $mihanpress_options['site_logo']['url'];
$logo_tablet  = ! empty( $mihanpress_options['site_logo_tablet']['url'] ) ? $mihanpress_options['site_logo_tablet']['url'] : $logo_desktop;
$logo_mobile  = ! empty( $mihanpress_options['site_logo_mobile']['url'] ) ? $mihanpress_options['site_logo_mobile']['url'] : $logo_desktop;
?>
<div class="logo flex-navbar-grow-1 justify-content-navbar-start">
	<div class="open-navbar-responsiv">
		<a href="#" data-target="responsive-nav" class="flex-column align-items-center justify-content-center sidenav-trigger hambruger">
			<span class="menu-bar"> </span>
			<span class="menu-bar"> </span>
			<span class="menu-bar"> </span>
		</a>
	</div>

	<?php if ( '1' === $mihanpress_options['sidenav_desktop'] && 'right' === $mihanpress_options['sidenav_desktop_position'] ) : ?>
		<div class="sidenav-desktop-logo mr-1 ml-1 d-inline-flex">
			<?php get_template_part( 'template-parts/headers/templates/sidenav-trigger' ); ?>
		</div>
	<?php endif; ?>

	<a href="<?php echo esc_url( home_url() ); ?>">
		<picture>
			<source media="(min-width:992px)" srcset="<?php echo esc_url( $logo_desktop ); ?>"><!--desktop-->
			<source media="(min-width:700px)" srcset="<?php echo esc_url( $logo_tablet ); ?>"><!--tablet-->
			<source media="(max-width:700px)" srcset="<?php echo esc_url( $logo_mobile ); ?>"><!--mobile-->
			<img src="<?php echo esc_url( $logo_desktop ); ?>" alt="<?php bloginfo( 'name' ); ?>"><!--fallback-->
		</picture>
	</a>
</div>
