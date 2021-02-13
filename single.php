<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

if ( 'show' === get_post_meta( get_the_ID(), 'mihanpress_show_header', true ) || empty( get_post_meta( get_the_ID(), 'mihanpress_show_header', true ) ) ) {
	get_header();

	if ( 'full-header' === $mihanpress_options['blog_single_template'] ) {
		get_template_part( 'template-parts/hero-header' );
	}
} else {
	get_template_part( 'template-parts/head' );
}
?>

<main id="main" class="container pr-lg-3 pl-lg-3 pr-md-2 pl-md-2 pr-sm-1 pl-sm-1 pr-0 pl-0">
	<section id="sticky-content" class="row mt-4 col-lg-12 justify-content-center mr-0 mt-0 ml-0 pr-0 pl-0 pt-0">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				$article_columns = ! empty( $mihanpress_options['blog_single_posts_col'] ) ? $mihanpress_options['blog_single_posts_col'] : 9;
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post col-lg-' . $article_columns . ' col-ml-12 mb-3 pr-lg-2 pl-lg-2 pr-md-2 pl-md-2 pr-sm-1 pl-sm-1 pr-0 pl-0' ); ?>>

					<?php if ( function_exists( 'mihanpress_breadcrumbs' ) && ( 'show' === get_post_meta( get_the_ID(), 'mihanpress_show_breadcrumb', true ) || empty( get_post_meta( get_the_ID(), 'mihanpress_show_breadcrumb', true ) ) ) ) : ?>
						<div class="col-lg-12 p-0 mb-3">
							<?php mihanpress_breadcrumbs(); ?>
						</div>
					<?php endif; ?>

					<section class="box box-shadow-sm overflow-x-hidden p-0">
						<?php
						if ( 'normal-header' === $mihanpress_options['blog_single_template'] ) :
							?>
							<header>
								<h1 class="article-title"><?php the_title(); ?></h1>
							</header>
							<?php
							if ( '1' === $mihanpress_options['blog_single_thumbnail'] ) {
								echo '<figure class="article-thumbnail mt-3">';
								the_post_thumbnail();
								echo '</fugure>';
							}
						endif;
						?>
						<div class="article-body pt-3 pb-3 pr-3 pl-3 pr-md-4 pl-md-4 pr-lg-5 pl-lg-5">
							<?php the_content(); ?>
							<div class="clear"></div>
						</div>
						<footer class="post-meta-wrapper pb-5 pr-3 pl-3 pr-md-4 pl-md-4 pr-lg-5 pl-lg-5">
							<?php
							if ( '1' === $mihanpress_options['blog_single_tags'] && get_the_tags() ) :
								?>
								<div class="category-badge mb-2">
									<span><?php esc_html_e( 'برچسب ها :', 'mihanpress' ); ?></span>
									<span><?php the_tags( '', ' ' ); ?></span>
								</div>
								<?php
							endif;

							get_template_part( 'template-parts/single/post-meta' );
							get_template_part( 'template-parts/single/author-bio' );
							?>
						</footer>
					</section>
				<?php
			endwhile;
		endif;

		wp_link_pages(
			array(
				'before'      => '<nav class="post-nav-links paginate-links flex-wrap bg-light-background box box-shadow-sm pt-4 pb-4 mt-4"" aria-label="' . esc_attr__( 'صفحه', 'mihanpress' ) . '"><span class="label">' . esc_html__( 'صفحات نوشته:', 'mihanpress' ) . '</span>',
				'after'       => '</nav>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);
		if ( '1' === $mihanpress_options['blog_single_related_posts'] ) {
			get_template_part( 'template-parts/single/related-posts' );
		}

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			?>
				<section class="comments-box-container p-0 mt-5">
					<?php comments_template(); ?>
				</section>
			<?php
		endif;

		?>
				</article>
				<?php
				if ( is_active_sidebar( 'sidebar_blog' ) ) {
					get_sidebar( 'blog' );
				}
				?>
	</section>
</main><!--#main-->

<?php
if ( 'show' === get_post_meta( get_the_ID(), 'mihanpress_show_footer', true ) || empty( get_post_meta( get_the_ID(), 'mihanpress_show_footer', true ) ) ) {
	get_footer();
} else {
	wp_footer();
	?>
	</body>
</html>
	<?php
}
