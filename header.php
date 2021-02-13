<?php
/**
 * Header file for the MihanPress WordPress theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MihanPress
 * @since 1.0.0
 */

get_template_part( 'template-parts/head' );

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
	?>

<header id="header">
	<?php get_template_part( 'template-parts/headers/header', 'v1' ); ?>
</header><!--#header-->

	<?php
}
