<?php
/**
 * Template for displaying category badges in cards
 *
 * @package MihanPress
 * @since 1.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'metadata' => array(),
	)
);

if ( in_array( 'category', $args['metadata'], true ) ) {
	?>

	<div class="category-badge mb-3">
		<?php the_terms( $post->ID, 'category', '', ' ' ); ?>
	</div>

	<?php
}
