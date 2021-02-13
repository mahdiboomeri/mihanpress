<?php
/**
 * Template for displaying post actions (copy short link, share in social media and etc.)
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

$icons = $mihanpress_options['blog_single_social_media_icons'];
?>
<div class="d-flex align-items-center flex-row-reverse flex-wrap col-lg-12 mt-3 justify-content-between">

	<?php if ( '1' === $mihanpress_options['blog_single_short_link'] ) : ?>
		<div class="short-link mb-3">
			<span class="flaticon-copy-content"></span>
			<span id="post_short_link"><?php echo esc_url( home_url() . '/?p=' . get_the_ID() ); ?></span>
		</div>
	<?php endif; ?>

	<?php if ( '1' === $mihanpress_options['blog_single_social_media'] ) { ?>

		<div class="share-links ml-3 mb-3">
			<?php if ( '1' === $icons['telegram'] ) : ?>
				<a 
					href="https://t.me/share/url?url=<?php echo esc_attr( wp_strip_all_tags( get_the_permalink() ) ); ?>&amp;title=<?php echo esc_attr( wp_strip_all_tags( get_the_permalink() ) ); ?>"
					title="<?php esc_html_e( 'اشتراک گذاری در تلگرام', 'mihanpress' ); ?>"
					target="_blank"
					class="d-inline-block"
				>
					<span class="flaticon-paper-plane"></span>
				</a>
			<?php endif; ?>

			<?php if ( '1' === $icons['twitter'] ) : ?>
				<a 
					href="https://twitter.com/home?status=Reading:<?php the_permalink(); ?>"
					title="<?php esc_html_e( 'اشتراک گذاری در تویتر', 'mihanpress' ); ?>"
					target="_blank"
					class="d-inline-block ml-2"
				>
					<span class="flaticon-twitter-logo-silhouette"></span>
				</a>
			<?php endif; ?>

			<?php if ( '1' === $icons['whatsapp'] ) : ?>
				<a
					href="whatsapp://send?text=<?php the_permalink(); ?>"
					title="<?php esc_html_e( 'اشتراک گذاری در واتساپ', 'mihanpress' ); ?>"
					target="_blank"
					class="d-inline-block ml-2"
				>
					<span class="flaticon-chat"></span>
				</a>
			<?php endif; ?>

			<?php if ( '1' === $icons['linkedin'] ) : ?>
				<a
					href="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo esc_attr( wp_strip_all_tags( get_the_title() ) ); ?>&amp;url=<?php the_permalink(); ?>"
					title="<?php esc_html_e( 'اشتراک گذاری در لینکداین', 'mihanpress' ); ?>"
					target="_blank"
					class="d-inline-block ml-2"
				>
					<span class="flaticon-linkedin-logo"></span>
				</a>
			<?php endif; ?>
		</div><!--.share-links-->

	<?php } ?>
</div>
