<?php
/**
 * Call to action element for Elementor and soon for Gutenberg
 *
 * @package MihanPress
 * @since 1.4.0
 */

$args = wp_parse_args(
	$args,
	array(
		'description'       => '',
		'button_text'       => '',
		'button_attributes' => '',
	)
);

?>

<div class="mp-call-to-action d-flex justify-content-between align-items-center flex-wrap">
	<div>
		<?php echo wp_kses_post( $args['description'] ); ?>
	</div>

	<div class="d-flex justify-content-end">
		<a <?php echo $args['button_attributes']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php echo esc_html( $args['button_text'] ); ?>
		</a>
	</div>
</div>
