<?php
/**
 * Template for displaying title in cards
 *
 * @package MihanPress
 * @since 1.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<a href="<?php the_permalink(); ?>">
	<h2 class="card__title"><?php the_title(); ?></h2>
</a>

