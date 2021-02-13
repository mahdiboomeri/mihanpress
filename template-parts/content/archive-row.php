<?php
/**
 * Template for displaying row card
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

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-lg-6 p-1 card-row' ); ?>>
	<div class="card out-thumbnail row m-0 p-0">

		<?php
		get_template_part(
			'template-parts/content/parts/thumbnail',
			null,
			array(
				'link_classes'   => 'col-lg-4 pr-1 pl-1',
				'figure_classes' => 'ml-0 mr-2',
			)
		)
		?>

		<div class="card__content col-lg-8 d-lg-flex flex-lg-column justify-content-lg-center">
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

			<footer>
				<?php
				get_template_part(
					'template-parts/content/parts/data',
					null,
					array(
						'metadata'  => $args['metadata'],
						'alignment' => 'start',
					)
				);
				?>

				<?php if ( '1' === $args['read_more'] ) : ?>
					<div>
						<?php get_template_part( 'template-parts/content/parts/read-more' ); ?>
					</div>
				<?php endif; ?>	

			</footer>
		</div>

	</div>
</article>
