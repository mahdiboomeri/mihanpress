<?php
/**
 * The template for displaying the 404 template.
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

get_template_part( 'template-parts/head' );

?>
<div class="eror_container">
	<div class="fourty-four-container">
		<div class="fourty-four-number">4</div>
		<div class="moon">
			<div class="moon__crater moon__crater1"></div>
			<div class="moon__crater moon__crater2"></div>
			<div class="moon__crater moon__crater3"></div>
		</div>
		<div class="fourty-four-number">4</div>
	</div>
	<div class="eror-message">
		<p><?php echo wp_kses_post( $mihanpress_options['404_content'] ); ?></p>
		<a href="<?php echo esc_url( $mihanpress_options['404_button_link'] ); ?>">
			<button><?php echo esc_html( $mihanpress_options['404_button_text'] ); ?></button>
		</a>
	</div>
</div>

<div class="stars">
	<?php for ( $i = 0;$i < 30;$i++ ) : ?>
		<div class="star"></div>
	<?php endfor; ?>
</div>
<?php wp_footer(); ?>
</body>

</html>
