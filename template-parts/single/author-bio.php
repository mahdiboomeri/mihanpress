<?php
/**
 * Template for displaying author bio box in single.php
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

if ( '1' === $mihanpress_options['blog_single_author'] ) {
	?>

	<div class="author-meta box-shadow-sm d-flex row mt-4 mr-0 ml-0">
		<div class="d-flex align-items-center col-lg-2 col-md-2 mr-auto ml-auto">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
		</div>

		<div class="col-lg-10 col-md-10">
			<div class="d-flex align-items-center justify-content-center justify-content-md-start mt-3 mt-md-0">
				<b><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></b>

				<span class="author-meta--link-badge">
					<a class="author-url" href="<?php echo esc_url( get_the_author_meta( 'user_url' ) ); ?>">
						<?php esc_html_e( 'وبسایت', 'mihanpress' ); ?>
					</a>
				</span>
			</div>

			<div>
				<?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?>
			</div>
		</div>
	</div><!--.author-meta-->

	<?php
}
