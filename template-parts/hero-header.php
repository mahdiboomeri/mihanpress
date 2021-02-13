<?php
/**
 * Template for displaying hero header
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
?>
<section class="hero-header position-relative p-0">
	<?php if ( 'skew' === $mihanpress_options['hero_header_type'] ) : ?>

		<div class="skew-bg">
			<div class="skew-bg--gradient-primary">
				<span class="skew-bg--shadow-main"></span>
			</div>
			<div class="skew-bg--gradient-secondary"></div>
			<span class="skew-bg--shadow-right"></span>
			<span class="skew-bg--shadow-left"></span>
		</div>

	<?php elseif ( 'wave' === $mihanpress_options['hero_header_type'] ) : ?>

		<div class="waves-container">

			<div class="wave-wrapper">
				<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
					<defs>
						<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
					</defs>
					<g class="parallax">
						<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
						<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
						<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
						<use xlink:href="#gentle-wave" x="48" y="7" fill="<?php echo ! empty( $mihanpress_options['body_background'] ) ? esc_attr( $mihanpress_options['body_background'] ) : '#fff'; ?>" />
					</g>
				</svg>
			</div><!--.wave-wrapper-->

		</div>

	<?php endif; ?>

	<?php
	if ( have_posts() && is_single() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<div class="container pr-1 pl-1 pr-sm-2 pl-sm-2 pr-md-3 pl-md-3">
				<div class="hero-header--content position-relative flex-wrap">
					<div class="hero-header--content-title d-flex flex-column justify-content-center pb-4 pt-4 col-lg-8 col-md-6 col-12 flex-grow-1 pr-1 pl-1 pr-sm-2 pl-sm-2 pr-md-3 pl-md-3">
						<h1 class="h2"><?php the_title(); ?></h1>
						<?php get_template_part( 'template-parts/single/post-meta/meta' ); ?>
					</div><!--.hero-header--content-title-->

					<?php if ( '1' === $mihanpress_options['blog_single_thumbnail'] ) : ?>
						<div class="hero-header--content-thumbnail col-lg-4 col-md-6 col-12 pr-1 pl-1 pr-sm-2 pl-sm-2 pr-md-3 pl-md-3">
							<figure class="box-shadow-sm">
								<?php the_post_thumbnail(); ?>
							</figure>
						</div><!--.hero-header--content-thumbnail-->
					<?php endif; ?>
				</div><!--.hero-header--content-->
			</div>
			<?php
		endwhile;
	endif;
	?>
</section><!--.hero-header-->
