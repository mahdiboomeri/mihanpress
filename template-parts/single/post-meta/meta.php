<?php
/**
 * Template for displaying post metadata
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
?>
<div class="d-flex flex-wrap col-lg-auto col-md-12 mt-3">
	<?php if ( '1' === $mihanpress_options['blog_single_update'] ) : ?>
		<span class="post-modified-date btn-success mb-2">
			<?php
			printf(
				/* Translators: %s the past duration of publishing */
				esc_html__( 'آپدیت شده در %s پیش', 'mihanpress' ),
				human_time_diff( get_the_modified_date( 'U' ), current_time( 'timestamp' ) )
			);
			?>
		</span>
	<?php endif; ?>

	<?php if ( '1' === $mihanpress_options['blog_single_date'] ) : ?>
		<span class="post-meta-child mb-2">
			<span class="flaticon-clock ml-2"></span>
			<span class="ml-3">
				<?php 'human_time' === $mihanpress_options['blog_single_date_type'] ? printf( _x( '%s پیش', '%s = مدت زمان گذشته از ارسال نوشته', 'mihanpress' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) : print( get_the_date() ); ?>
			</span>
		</span>
	<?php endif; ?>

	<?php if ( '1' === $mihanpress_options['blog_single_like'] ) : ?>
		<span class="post-meta-child mb-2">
			<?php
			if ( '1' === $mihanpress_options['blog_single_like'] && class_exists( 'MihanPress_Like' ) ) {
				global $mihanpress_like;
				echo $mihanpress_like->get_likes_button( get_the_ID(), 0 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</span>
	<?php endif; ?>

	<?php if ( '1' === $mihanpress_options['blog_single_comment_count'] ) : ?>
		<span class="post-meta-child mb-2">
			<span class="flaticon-speech-bubble ml-2"></span>
			<span>
				<?php
				/* Translators: %s comments number */
				echo sprintf( esc_html__( '%s نظر', 'mihanpress' ), get_comments_number() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</span>
		</span>
	<?php endif; ?>
</div>
