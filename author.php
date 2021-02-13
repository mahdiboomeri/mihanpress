<?php
/**
 * The template for displaying author pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) ); // phpcs:ignore WordPress.Security.NonceVerification

get_header();

?>
<main id="main" class="container">
	<section class="row mt-5 p-sm-0 mr-sm-0 mb-5 justify-content-center m-lg-auto m-md-auto">
		<div class="col-lg-10 pr-0 pl-0">
			<section class="about-author text-center position-relative box box-shadow-sm pb-5 mt-5 mr-2 ml-2 mb-3 row flex-column align-items-center">
				<figure class="about-author__avatar"><?php echo get_avatar( get_the_author_meta( $curauth->email ) ); ?></figure>
				<div class="col-lg-12 col-md-12">
					<a class="about-author__title" href="<?php echo esc_url( $curauth->user_url ); ?>">
						<h2><?php echo esc_html( $curauth->display_name ); ?></h2>
					</a>
					<p class="about-author__content"><?php echo esc_html( $curauth->user_description ); ?></p>
				</div>
			</section>
			<div class="col-lg-12 col-ml-12 p-0 m-0">
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

					<section class="row p-sm-0">
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
					<section class="p-sm-0">

						<?php
						if ( have_posts() ) {
							while ( have_posts() ) {
								the_post();
								get_template_part( 'template-parts/content/archive-row' );
							}
						}
						?>

					</section>

				<?php endif ?>

				<?php if ( paginate_links() ) : ?>
					<div class="d-flex paginate-links flex-wrap justify-content-center mr-1 ml-1 mt-3">
						<?php echo paginate_links(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif ?>
			</div>
		</div>
	</section>
</main><!--#main-->

<?php
get_footer();
