<?php
/**
 * Template for displaying hamburger menu (Desktop)
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
?>
<div class="align-self-center">
	<a 
		href="#" 
		data-target="slide-out"
		data-position="<?php echo ! empty( $mihanpress_options['sidenav_desktop_position'] ) ? esc_attr( $mihanpress_options['sidenav_desktop_position'] ) : 'left'; ?>"
		class="flex-column align-items-center justify-content-center sidenav-trigger sidenav-desktop-trigger hambruger"
	>
		<span class="menu-bar"> </span>
		<span class="menu-bar"> </span>
		<span class="menu-bar"> </span>
	</a>
</div>
