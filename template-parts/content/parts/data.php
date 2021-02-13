<?php
/**
 * Template for displaying meta data in cards
 *
 * @package MihanPress
 * @since 1.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'metadata'  => array(),
		'alignment' => 'center',
	)
);

$justify_class = 'justify-content-' . $args['alignment'];

if ( ! empty( array_diff( $args['metadata'], array( 'category' ) ) ) ) { ?>
	<div class="card__data d-inline-flex align-items-center flex-wrap <?php echo sanitize_html_class( $justify_class ); ?>">

		<?php if ( in_array( 'author', $args['metadata'], true ) ) : ?>
			<div class="card__author-meta">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), '35' ); ?>
					<span class="mr-2"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></span>
				</a>
			</div>
		<?php endif; ?>	

		<div class="d-flex align-items-center card__meta mr-3">
			<?php if ( in_array( 'time', $args['metadata'], true ) ) : ?>
				<span class="flaticon-clock ml-2 mt-0"></span>
				<span>
					<?php
					global $mihanpress_options;
					'human_time' === $mihanpress_options['blog_single_date_type'] ? printf( _x( '%s پیش', '%s = مدت زمان گذشته از ارسال نوشته', 'mihanpress' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ) : printf( get_the_date() );
					?>
				</span>
			<?php endif; ?>	
		</div>

		<div class="d-flex align-items-center card__meta mr-3">
			<?php if ( in_array( 'comments', $args['metadata'], true ) ) : ?>
				<span class="flaticon-speech-bubble ml-2"></span>
				<span>
					<?php
					/* Translators: %s comments number */
					echo sprintf( esc_html__( '%s نظر', 'mihanpress' ), get_comments_number() );
					?>
				</span>
			<?php endif; ?>	
		</div>

	</div><!--.card__data-->
<?php } ?>
