<?php
/**
 * Callback function for rewriting comments template.
 *
 * @package MihanPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mihanpress_comment_template( $comment, $args, $depth ) {

	?>
	<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-container flex-sm-nowrap flex-wrap pr-1 pl-1 pr-sm-2 pl-sm-2 pr-md-3 pl-md-3">

			<div class="comment-data mr-auto ml-auto">
				<?php echo get_avatar( $comment->comment_author_email ); ?>
				<div class="comment-meta mb-3">
					<strong class="comment__author"><?php echo get_comment_author_link(); ?></strong>
					<span><?php edit_comment_link( 'ویرایش' ); ?></span>
					<time class="comment__published-date"><?php echo esc_html( get_comment_date( 'Y/d/m' ) ); ?></time>
				</div>
			</div>
			<div class="comment-content flex-grow-1">
				<?php
				if ( 0 === $comment->comment_approved ) :
					?>
					<p class="comment__awaiting-approval alert-info alert-shadow-info"><?php esc_html_e( 'دیدگاه شما پس از تایید نمایش داده می شود.', 'mihanpress' ); ?></p>
					<?php
				endif;
				?>
				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
				<?php
				comment_reply_link(
					array(
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
					)
				);
				?>
			</div>


		</div>
	</div>
	<?php

}
