<?php
/**
 * Template for displaying block card
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

$args = wp_parse_args(
	$args,
	array(
		'excerpt'   => $mihanpress_options['card_archive_excerpt'],
		'read_more' => $mihanpress_options['card_archive_btn'],
		'metadata'  => $mihanpress_options['card_archive_metadata'] ?? array(),
	)
);

if ( ( is_archive() || is_search() ) && 'masonry' === $mihanpress_options['blog_archive_template'] ) {
	$post_class = 'p-2';
} elseif ( ( is_archive() || is_search() ) && 'block-card' === $mihanpress_options['blog_archive_template'] ) {
	$post_class = 'col-lg-4 p-2';
} else {
	$post_class = 'col-lg-4 d-flex align-content-center p-2';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
	<div class="card d-flex flex-column out-thumbnail">

		<?php get_template_part( 'template-parts/content/parts/thumbnail' ); ?>

		<div class="card__content">
			<header>
				<?php
				get_template_part(
					'template-parts/content/parts/category',
					null,
					array(
						'metadata' => $args['metadata'],
					)
				);

				get_template_part( 'template-parts/content/parts/title' );

				get_template_part(
					'template-parts/content/parts/data',
					null,
					array( 'metadata' => $args['metadata'] )
				);
				?>
			</header>

			<?php
			get_template_part(
				'template-parts/content/parts/excerpt',
				null,
				array(
					'show_excerpt' => $args['excerpt'],
				)
			);
			?>

			<?php
			if ( '1' === $args['read_more'] ) {
				get_template_part( 'template-parts/content/parts/read-more' );
			}
			?>

		</div>

	</div>
</article>
