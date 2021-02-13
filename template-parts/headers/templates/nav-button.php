<?php
/**
 * Template for displaying Login/Register and Dashboard links in header
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;
$nav_button_target = ! empty( $mihanpress_options['nav_button_target'] ) ? $mihanpress_options['nav_button_target'] : 'self';

if ( '1' === $mihanpress_options['nav_button'] ) {
	if ( 'account' === $mihanpress_options['nav_button_type'] ) :

		if ( ! is_user_logged_in() ) :
			?>

			<a href="<?php echo esc_url( $mihanpress_options['nav_button_account_login_url'] ); ?>" target="_<?php echo esc_attr( $nav_button_target ); ?>" class="btn btn-primary mr-2">
				<?php echo esc_html( $mihanpress_options['nav_button_account_login_text'] ); ?>
			</a>
			<a href="<?php echo esc_url( $mihanpress_options['nav_button_account_register_url'] ); ?>" target="_<?php echo esc_attr( $nav_button_target ); ?>" class="btn btn-light mr-2">
				<?php echo esc_html( $mihanpress_options['nav_button_account_register_text'] ); ?>
			</a>

			<?php
		else :
			?>

			<a href="<?php echo esc_url( $mihanpress_options['nav_button_account_logedin_url'] ); ?>" target="_<?php echo esc_attr( $nav_button_target ); ?>" class="btn btn-primary">
				<?php echo esc_html( $mihanpress_options['nav_button_account_logedin_text'] ); ?>
			</a>

			<?php
		endif;

	else :
		?>

		<a href="<?php echo esc_url( $mihanpress_options['nav_button_custom_link'] ); ?>" target="_<?php echo esc_attr( $nav_button_target ); ?>" class="btn btn-primary">
			<?php echo esc_html( $mihanpress_options['nav_button_custom_text'] ); ?>
		</a>

		<?php
	endif;
}
