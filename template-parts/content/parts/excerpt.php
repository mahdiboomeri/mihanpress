<?php
/**
 * Template for displaying excerpt in cards
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
		'show_excerpt' => '1',
	)
);

if ( '1' === $args['show_excerpt'] && ! empty( get_the_excerpt() ) ) { ?>

	<div class="card-excerpt mt-3">
		<?php the_excerpt(); ?>
	</div>

	<?php
}
