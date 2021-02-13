<?php
/**
 * Template for displating search icon in header
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

if ( '1' === $mihanpress_options['searchform'] ) {
	?>

	<div class="searchicon">
		<a class="modal-trigger" href="#modal1">
			<span class="<?php echo empty( $mihanpress_options['search_icon'] ) ? 'flaticon-search-3' : sanitize_html_class( $mihanpress_options['search_icon'] ); ?> text-dark"></span>
		</a>
	</div>

	<?php
}
