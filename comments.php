<?php
/**
 * The template file for displaying the comments and comment form for the MihanPress theme.
 *
 * @package MihanPress
 * @since   1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}

?>
<div class="mp-comments">

	<?php
	$user      = wp_get_current_user();
	$commenter = wp_get_current_commenter();

	if ( comments_open() || pings_open() ) {
		$fields = array(
			'author' => '<div class="d-flex comment-container"><p class="comment-form-author"><label for="author"> نام *  </label> ' .

				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				'" size="30" /></p>',
			'email'  =>
			'<p class="comment-form-email"><label for="email"> ایمیل * </label> ' .

				'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
				'" size="30"/></p>',
			'url'    =>
			'<p class="comment-form-url"><label for="url"> وبسایت (اختیاری) </label>' .
				'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				'" size="30" /></p></div>',
		);

		$args = array(
			'title_reply'          => '<span class="product_section_title mb-4">' . esc_html__( 'نظر یا سوال شما در این مورد چیست؟', 'mihanpress' ) . '</span>',
			'title_reply_to'       => esc_html__( 'پاسخ دادن به %s', 'mihanpress' ),
			'cancel_reply_link'    => esc_html__( 'انصراف', 'mihanpress' ),
			'label_submit'         => esc_html__( 'ارسال نظر', 'mihanpress' ),
			'format'               => 'html5',
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">متن نظر<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="متن نظر خود را اینجا بنویسید"></textarea></p>',
			'must_log_in'          => '<div class="mp-must-log-in-container p-2"><p class="must-log-in alert-info p-4 m-4">' .
				sprintf(
					__( 'برای نظر دادن ابتدا باید %s شوید.', 'mihanpress' ),
					'<a href="' . esc_url( wp_login_url( get_permalink() ) ) . '">' . esc_html__( 'وارد', 'mihanpress' ) . '</a>'
				) .
				'</p></div>',
			'logged_in_as'         => '<p class="logged-in-as">' .
				sprintf(
					__( 'شما با نام کاربری %1$s وارد شده اید . آیا میخواهید %2$s شوید ؟', 'mihanpress' ),
					'<a href="' . admin_url( 'profile.php' ) . '">' . $user->user_nicename . '</a>',
					'<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">' . esc_html__( 'خارج', 'mihanpress' ) . '</a>'
				) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'توجه داشته باشید که نشانی ایمیل شما منتشر نخواهد شد.', 'mihanpress' ) . '</p>',

			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		);

		comment_form( $args );
	}
	?>

	<div class="comments" id="comments">
		<?php
		if ( have_comments() ) :
			wp_list_comments(
				array(
					'style'     => 'div',
					'max_depth' => 5,
					'callback'  => 'mihanpress_comment_template',
				)
			);
		else :
			?>
			<div class="no-comments-yet-container p-2">
				<p class="no-comments-yet alert-success mr-3 ml-3"><?php esc_html_e( 'هیچ دیدگاهی برای این نوشته ثبت نشده است.', 'mihanpress' ); ?></p>
			</div>
			<?php
		endif;

		$comments_paginate = paginate_comments_links( array( 'echo' => false ) );
		if ( $comments_paginate ) :
			?>
			<div class="paginate-links flex-wrap d-flex justify-content-center">
				<?php echo $comments_paginate; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<?php
		endif;
		?>
	</div>
</div><!--.mp-comments-->
