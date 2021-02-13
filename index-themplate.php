<?php
/* Template Name: Homepage */

get_header();
?>

<main id="main" class="mt-3">
	<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			the_content();
		}
	}
	?>
</main>

<?php
get_footer();
