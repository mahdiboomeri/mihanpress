<?php
/**
 * Template for displaying search form in modal
 *
 * @package MihanPress
 * @since 1.0.0
 */

?>
<form action="<?php echo esc_url( home_url() ); ?>/" method="get" class="search-form pt-4 pb-4 d-flex">
	<input type="text" name="s" placeholder="<?php esc_html_e( 'کلمه مورد نظر + اینتر', 'mihanpress' ); ?>" value="<?php the_search_query(); ?>" class="search-form__input">
</form>
