<?php
/**
 * Template for displaying head
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

$body_class = '';

if ( is_404() ) {
	$body_class = 'body-404';
} elseif ( '1' === $mihanpress_options['sticky_sidebar'] ) {
	$body_class = 'sticky-sidebar-on';
}
?>

<!DOCTYPE html>
<html 
<?php
echo is_404() ? 'class="body-404" ' : '';
language_attributes();
?>
>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="shortcut icon" href="<?php echo esc_url( $mihanpress_options['site_favicon']['url'] ); ?>">
	<meta name="keywords" content="<?php echo esc_attr( $mihanpress_options['site_keywords'] ); ?>">

	<?php if ( 'iransansweb' === $mihanpress_options['theme_fonts'] ) : ?>
		<meta name="fontiran.com:license" content="QQESA4">
	<?php else : ?>
		<meta name="fontiran.com:license" content="2NGH4C">
	<?php endif; ?>

	<?php wp_head(); ?>

	<?php if ( ! empty( $mihanpress_options['site_custom_js'] ) ) : ?>
		<script>
			<?php echo $mihanpress_options['site_custom_js']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</script>
	<?php endif; ?>
</head>

<body <?php body_class( $body_class ); ?>>

	<?php wp_body_open(); ?>

	<?php if ( '1' === $mihanpress_options['preloader-on-off'] ) {
		get_template_part( 'template-parts/preloaders/preloader', $mihanpress_options['preloaders'] );
	}
	?>
