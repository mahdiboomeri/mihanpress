<?php
/**
 * Pie Chart element for Elementor and soon for Gutenberg
 *
 * @package MihanPress
 * @since 1.4.0
 */

$args = wp_parse_args(
	$args,
	array(
		'attributes' => '',
		'text'       => '',
	)
);
?>

<div class="mp-pie-chart chart-hidden d-block text-center" <?php echo $args['attributes']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<span class="mp-pie-chart__text">
		<?php echo esc_html( $args['text'] ); ?>
	</span>
</div>
