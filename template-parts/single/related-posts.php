<?php
/**
 * Template for displaying related posts
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

$post_per_page = ! empty( $mihanpress_options['blog_single_related_posts_pre_page'] ) ? intval( $mihanpress_options['blog_single_related_posts_pre_page'] ) : 3;

$args = array(
	'post__not_in'        => array( get_the_ID() ), // excludes current post.
	'posts_per_page'      => $post_per_page,
	'ignore_sticky_posts' => true,
);

/**
 * Add current post tags or categories to query args
 */
$logic_args = array(
	'terms' => array(),
	'key'   => '',
);

if ( 'tags' === $mihanpress_options['blog_single_related_posts_logic'] ) {
	$logic_args['terms'] = wp_get_post_tags( $post->ID );
	$logic_args['key']   = 'tag__in';

} elseif ( 'category' === $mihanpress_options['blog_single_related_posts_logic'] ) {
	$logic_args['terms'] = get_terms( 'category' );
	$logic_args['key']   = 'category__in';
}

$chosen_terms = array();

foreach ( (array) $logic_args['terms'] as $the_term ) {
	$chosen_terms[] = $the_term->term_id;
}

$args[ $logic_args['key'] ] = $chosen_terms;

/**
 * Set the query
 */
if ( ! empty( $args[ $logic_args['key'] ] ) ) {

	$related_query = new WP_Query( $args );
	if ( $related_query->have_posts() ) {
		?>

		<section class="box box-shadow-sm mt-4 pt-4">
			<div class="archive-title mb-3">
				<h3><?php esc_html_e( 'شاید از این نوشته‌ها هم خوشتان بیاید', 'mihanpress' ); ?></h3>
			</div>

			<div class="row related-posts col-lg-12 p-0 m-0">
				<?php
				while ( $related_query->have_posts() ) {
					$related_query->the_post();

					get_template_part(
						'template-parts/content/archive-block',
						null,
						array(
							'excerpt'   => $mihanpress_options['card_related_excerpt'],
							'read_more' => $mihanpress_options['card_related_btn'],
							'metadata'  => $mihanpress_options['card_related_metadata'] ?? array(),
						)
					);
				}
				?>
			</div><!--.related-posts-->
		</section>

		<?php
	}
	wp_reset_postdata();
}
