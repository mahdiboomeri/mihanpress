<?php
/* Template Name: ساده */

get_header();
?>
<main id="main" class="<?php echo 'container'; ?>">
	<section class="row mt-4 pb-3">
		<div class="col-lg-12">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
				<div class="post">
					<?php the_content(); ?>
				</div>
					<?php
				}
			}
			?>
		</div>
	</section>
</main><!--#main-->
<?php
get_footer();
