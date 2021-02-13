<?php
/**
 * Template for displaying read more button in cards
 *
 * @package MihanPress
 * @since 1.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<a href="<?php the_permalink(); ?>" class="btn btn-success position-relative d-inline-block mt-4 pr-5 pl-5"><?php esc_html_e( 'بیشتر بخوانید', 'mihanpress' ); ?></a>

