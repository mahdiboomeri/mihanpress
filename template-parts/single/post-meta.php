<?php
/**
 * Template for displaying post metadata in single.php
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
?>
<div class="post-meta mt-4 d-flex justify-content-between align-items-center row">
	<?php
	/**
	 * Hook: mihanpress_before_post_meta.
	 */
	do_action( 'mihanpress_before_post_meta' );

	if ( 'full-header' !== $mihanpress_options['blog_single_template'] ) {
		get_template_part( 'template-parts/single/post-meta/meta' );
	}

	get_template_part( 'template-parts/single/post-meta/actions' );

	/**
	 * Hook: mihanpress_after_post_meta.
	 */
	do_action( 'mihanpress_after_post_meta' );
	?>
</div>
