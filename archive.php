<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

get_header();

?>
<main id="main" class="container pr-lg-3 pl-lg-3 pr-md-2 pl-md-2 pr-sm-1 pl-sm-1 pr-0 pl-0">
	<section class="row mt-5 p-0 p-sm-0 mb-5 justify-content-center">
		<?php if ( function_exists( 'mihanpress_breadcrumbs' ) ) : ?>
			<div class="col-lg-12 p-1">
				<?php mihanpress_breadcrumbs(); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_category() && ! empty( category_description( get_queried_object()->term_id ) ) ) : ?>
			<div class="col-lg-12 box box-shadow-sm p-4 flex-shrink-1 mr-0 ml-0 mb-3">
				<?php echo category_description( get_queried_object()->term_id ); ?>
			</div>
		<?php endif; ?>

		<div class="col-lg-12 m-0 p-0">
			<?php if ( 'masonry' === $mihanpress_options['blog_archive_template'] ) : ?>
				<section id="sticky-content" class="masonry-grid p-sm-0" data-column="3" data-column-tablet="2" data-column-mobile="1">
					<?php
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/content/archive-block' );
						}
					}
					?>

				</section>
			<?php elseif ( 'block-card' === $mihanpress_options['blog_archive_template'] ) : ?>
				<section class="row p-sm-0 mr-0 ml-0">
					<?php
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/content/archive-block' );
						}
					}
					?>

				</section>
			<?php else : ?>
				<section class="row p-sm-0 mr-0 ml-0">
					<?php
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/content/archive-row' );
						}
					}
					?>
				</section>
			<?php endif; ?>

			<?php if ( paginate_links() ) : ?>
				<div class="d-flex paginate-links flex-wrap justify-content-center mt-3">
					<?php echo paginate_links(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php endif; ?>
		</div>

	</section>
</main><!--#main-->

<?php
get_footer();
