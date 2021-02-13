<?php
/**
 * Template for displaying thumbnail in cards
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
		'link_classes'   => '',
		'figure_classes' => '',
	)
);

?>

<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( $args['link_classes'] ); ?>">
	<figure class="card__thumbnail position-relative <?php echo esc_attr( $args['figure_classes'] ); ?>">
		<?php the_post_thumbnail(); ?>
	</figure>
</a>
