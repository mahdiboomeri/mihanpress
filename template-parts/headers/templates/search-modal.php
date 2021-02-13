<?php
/**
 * Template for displaying search form modal
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

if ( '1' === $mihanpress_options['searchform'] ) {
	?>

	<div id="modal1" class="modal">
		<a class="modal-close">
			<span class="flaticon-delete"></span>
		</a>
		<div class="modal-content">
			<?php get_template_part( 'template-parts/headers/templates/searchform' ); ?>
		</div>
	</div>

	<?php
}
