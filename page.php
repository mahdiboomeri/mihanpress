<?php
/**
 * The template for displaying pages
 *
 * @package MihanPress
 * @since 1.0.0
 */

if ( 'show' === get_post_meta( get_the_ID(), 'mihanpress_show_header', true ) || empty( get_post_meta( get_the_ID(), 'mihanpress_show_header', true ) ) ) {
	get_header();
} else {
	get_template_part( 'template-parts/head' );
}
?>
<main id="main" class="container">
	<section class="row mt-4 pb-0">
		<div class="col-lg-12 pr-0 pl-0 pr-sm-1 pl-sm-1 pr-md-2 pl-md-2 pr-lg-3 pl-lg-3">
			<article class="post col-lg-9 col-ml-12 mr-auto ml-auto p-0">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();

						if ( function_exists( 'mihanpress_breadcrumbs' ) && ( 'show' === get_post_meta( get_the_ID(), 'mihanpress_show_breadcrumb', true ) || empty( get_post_meta( get_the_ID(), 'mihanpress_show_breadcrumb', true ) ) ) ) {
							?>
							<div class="col-lg-12 p-0 mb-3">
								<?php mihanpress_breadcrumbs(); ?>
							</div>
						<?php } ?>

						<section class="box box-shadow-sm overflow-x-hidden pt-0 pt-0 pr-0 pl-0 pr-sm-2 pl-sm-2 pr-md-4 pl-md-4">
							<div class="post">
								<header>
									<h1 class="article-title  h3 mb-0"><?php the_title(); ?></h1>
								</header>
								<div class="article-body pt-4 pb-3 pr-2 pl-2 pr-sm-3 pl-sm-3">
									<?php the_content(); ?>
								</div>
							</div>

						</section>
						<?php
					endwhile;
				endif;
				?>
			</article>
		</div>
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
?>
