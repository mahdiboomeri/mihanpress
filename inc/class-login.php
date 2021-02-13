<?php
/**
 * Customize WordPress Default Login/Register Page
 *
 * @package MihanPress
 * @since 1.6.0
 */

namespace MihanPress;

/**
 * Class Declaration
 *
 * @since 1.0.0
 */
class Login {
	/**
	 * Class Constructor
	 *
	 * @since 1.6.0
	 */
	public function __construct() {
		/** Load login CSS */
		add_action( 'login_enqueue_scripts', array( __CLASS__, 'login_css' ) );

		/** Fix lost password link */
		add_filter( 'lostpassword_url', array( __CLASS__, 'reset_pass_url' ), 11, 0 );

		/** Change login's logo url to home page insted of Wordpress.org */
		add_filter( 'login_headerurl', array( __CLASS__, 'login_logo_url' ) );

		/** Correct the <title> tag */
		add_filter( 'login_title', array( __CLASS__, 'login_title' ), 99 );

		/** Customize errors messages */
		add_filter( 'wp_login_errors', array( __CLASS__, 'handle_errors_text' ), 10, 2 );
	}

	/**
	 * Load Login Page CSS (this function moved from functions.php in version 1.6.0)
	 *
	 * @since 1.0.0
	 */
	public static function login_css() {
		/** Minify CSS */
		$css = \MihanPress_Theme::minify_css( mihanpress_login_css() );

		/** Print CSS output */
		echo '<style type="text/css">' . wp_strip_all_tags( $css ) . '</style>';
	}

	/**
	 * Fix Woocommerce lost password link changing (this function moved from functions.php in version 1.6.0)
	 *
	 * @since 1.0.0
	 */
	public static function reset_pass_url() {
		$site_url = wp_login_url();
		return $site_url . '?action=lostpassword';
	}

	/**
	 * Change login's logo url to home page insted of Wordpress.org
	 *
	 * @since 1.6.0
	 */
	public static function login_logo_url() {
		return home_url();
	}

	/**
	 * Correct page <title> tag
	 *
	 * @param string $login_title The page title, with extra context added.
	 * @since 1.6.0
	 */
	public static function login_title( $login_title ) {
		return get_bloginfo( 'title' );
	}

	/**
	 * Customize errors messages
	 *
	 * @param WP_Error $errors WP Error object.
	 * @param string   $redirect_to Redirect destination URL.
	 * @since 1.6.0
	 */
	public static function handle_errors_text( $errors, $redirect_to ) {
		global $mihanpress_options;

		if ( is_object( $errors ) ) {
			$error_keys  = array_keys( $errors->errors );
			$error_codes = array(
				'test_cookie',
				'invalid_username',
				'incorrect_password',
				'empty_username',
				'empty_password',
			);

			foreach ( (array) $error_codes as $code ) {
				if ( in_array( $code, $error_keys, true ) && '1' === $mihanpress_options[ 'login_' . $code ] ) {
					$errors->errors[ $code ][0] = wp_kses_post( $mihanpress_options[ 'login_' . $code . '_text' ] );
				}
			}
		}
		return $errors;
	}

}
new Login();
