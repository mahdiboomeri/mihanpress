<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package MihanPress
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * This is simple class for adding Zhaket guard system in any WordPress theme and plugin.
 * Author: Mojtaba Darvishi
 * http://mojtaba.in
 * Created by PhpStorm.
 * User: mojtaba
 * Date: 11/10/17
 * Time: 12:17 PM
 */

class MihanPress_Guard_SDK {

	/**
	 * Your plugin or theme name. It will be used in admin notices
	 *
	 * @var mixed
	 */
	private $name;
	/**
	 * Registration page slug
	 *
	 * @var mixed
	 */
	private $slug;
	/**
	 * Parent menu slug
	 * More info: https://developer.wordpress.org/reference/functions/add_submenu_page/
	 *
	 * @var mixed
	 */
	private $parent_slug;
	/**
	 * Your plugin or theme text domain
	 * This wil be used to translate Zhaket Guard SDK strings with you theme or plugin translation file
	 *
	 * @var mixed
	 */
	private $text_domain;
	/**
	 * Name of option that save info
	 *
	 * @var mixed
	 */
	private static $option_name;
	/**
	 * Your product token in zhaket.com
	 *
	 * @var mixed
	 */
	private $product_token;
	/**
	 * Zhaket guard API url
	 *
	 * @var string
	 */
	public static $api_url = 'http://guard.zhaket.com/api/';

	/**
	 * Single instance of class
	 *
	 * @var null
	 */
	private static $instance = null;

	/**
	 * MihanPress_Guard_SDK constructor.
	 */
	public function __construct( array $settings ) {

		// Initial settings
		$defaults = array(
			'name'          => '',
			'slug'          => 'zhk_guard_register',
			'parent_slug'   => 'options-general.php',
			'text_domain'   => '',
			'product_token' => '',
			'option_name'   => 'zhk_guard_register_settings',
		);
		foreach ( $settings as $key => $setting ) {
			if ( array_key_exists( $key, $defaults ) && ! empty( $setting ) ) {
				$defaults[ $key ] = $setting;
			}
		}
		$this->name          = $defaults['name'];
		$this->slug          = $defaults['slug'];
		$this->parent_slug   = $defaults['parent_slug'];
		$this->text_domain   = $defaults['text_domain'];
		self::$option_name   = $defaults['option_name'];
		$this->product_token = $defaults['product_token'];

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_' . $this->slug, array( $this, 'wp_starter' ) );

		add_action( 'wp_ajax_' . $this->slug . '_revalidate', array( $this, 'revalidate_starter' ) );

		add_action( 'init', array( $this, 'schedule_programs' ) );

		add_action( $this->slug . '_daily_validator', array( $this, 'daily_event' ) );

		add_action( 'admin_notices', array( $this, 'admin_notice' ) );

	}


	/**
	 * Add submenu page for display registration form
	 */
	public function admin_menu() {
		add_submenu_page(
			$this->parent_slug,
			__( 'فعالسازی لایسنس میهن پرس', $this->text_domain ),
			__( 'فعالسازی لایسنس میهن پرس', $this->text_domain ),
			'manage_options',
			$this->slug,
			array( $this, 'menu_content' )
		);
	}

	/**
	 * Submenu content
	 */
	public function menu_content() {
		$option  = get_option( self::$option_name );
		$now     = json_decode( get_option( $option ) );
		$starter = ( isset( $now->starter ) && ! empty( $now->starter ) ) ? base64_decode( $now->starter ) : '';
		if ( isset( $_GET['debugger'] ) && ! empty( $_GET['debugger'] ) && $_GET['debugger'] === 'show' ) {
			$data_show = $option;
		} else {
			$data_show = '';
		}
		?>
		<style>
			form.register_version_form,
			.current_license {
				width: 30%;
				background: #fff;
				margin: 0 auto;
				padding: 20px 30px;
			}
			form.register_version_form  .license_key {
				padding: 5px 10px;
				width: calc( 100% - 100px );
			}

			form.register_version_form button {
				width: 80px;
				text-align: center;
			}

			form.register_version_form .result,
			.current_license .check_result {
				width: 100%;
				padding: 30px 0 15px;
				text-align: center;
				display: none;
			}
			.current_license .check_result {
				padding: 20px 0;
				float: right;
				width: 100%;
			}
			form.register_version_form .result .spinner,
			.current_license .check_result .spinner {
				width: auto;
				background-position: right center;
				padding-right: 30px;
				margin: 0;
				float: none;
				visibility: visible;
				display: none;
			}
			.current_license.waiting .check_result .spinner,
			form.register_version_form .result.show .spinner {
				display: inline-block;
			}
			.current_license {
				width: 40%;
				text-align: center;
			}
			.current_license > .current_label {
				line-height: 25px;
				height: 25px;
				display: inline-block;
				font-weight: bold;
				margin-left: 10px;
			}
			.current_license > code {
				line-height: 25px;
				height: 25px;
				padding: 0 5px;
				color: #c7254e;
				margin-left: 10px;
				display: inline-block;
				-webkit-transform: translateY(2px);
				-moz-transform: translateY(2px);
				-ms-transform: translateY(2px);
				-o-transform: translateY(2px);
				transform: translateY(2px);
			}
			.current_license .action {
				color: #fff;
				line-height: 25px;
				height: 25px;
				padding: 0 5px;
				display: inline-block;
			}
			.current_license .last_check {
				line-height: 25px;
				height: 25px;
				padding: 0 5px;
				display: inline-block;
			}
			.current_license .action.active {
				background: #4CAF50;
			}
			.current_license .action.inactive {
				background: #c7254e;
			}

			.current_license .keys {
				float: right;
				width: 100%;
				text-align: center;
				padding-top: 20px;
				border-top: 1px solid #ddd;
				margin-top: 20px;
			}
			.current_license .keys .wpmlr_revalidate {
				margin-left: 30px;
			}
			.current_license .register_version_form {
				display: none;
				padding: 0;
				float: right;
				width: 80%;
				margin: 20px 10%;
			}
			.zhk_guard_notice {
				background: #fff;
				border: 1px solid rgba(0,0,0,.1);
				border-right: 4px solid #00a0d2;
				padding: 5px 15px;
				margin: 5px;
			}
			.zhk_guard_danger {
				background: #fff;
				border: 1px solid rgba(0,0,0,.1);
				border-right: 4px solid #DC3232;
				padding: 5px 15px;
				margin: 5px;
			}
			.zhk_guard_success {
				background: #fff;
				border: 1px solid rgba(0,0,0,.1);
				border-right: 4px solid #46b450;
				padding: 5px 15px;
				margin: 5px;
			}
			@media (max-width: 1024px) {
				form.register_version_form,
				.current_license {
					width: 90%;
				}
			}
		</style>
		<div class="wrap wpmlr_wrap" data-show="<?php echo $data_show; ?>">
			<h1><?php _e( 'فعالسازی لایسنس میهن پرس', $this->text_domain ); ?></h1>
			<?php if ( isset( $now ) && ! empty( $now ) ) : ?>
				<div class="mihanpress-license-single-page-message">
					<p><?php _e( 'شما از قبل لایسنس خود را وارد کرده اید. برای چک دوباره آن از بخش زیر استفاده کنید.', $this->text_domain ); ?></p>
				</div>
				<div class="current_license">
					<span class="current_label"><?php _e( 'لایسنس فعلی شما : ', $this->text_domain ); ?></span>
					<code><?php echo $starter; ?></code>
					<div class="action <?php echo ( $now->action == 1 ) ? 'active' : 'inactive'; ?>">
						<?php if ( $now->action == 1 ) : ?>
							<span class="dashicons dashicons-yes"></span>
							<?php echo $now->message; ?>
						<?php else : ?>
							<span class="dashicons dashicons-no-alt"></span>
							<?php echo $now->message; ?>
						<?php endif; ?>
					</div>
					<div class="keys">
						<a href="#" class="button button-primary wpmlr_revalidate" data-key="<?php echo $starter; ?>"><?php _e( 'بازرسی لایسنس', $this->text_domain ); ?></a>
						<a href="#" class="button zhk_guard_new_key"><?php _e( 'حذف لایسنس فعلی و ثبت لایسنس جدید', $this->text_domain ); ?></a>
					</div>

					<form action="#" method="post" class="register_version_form">
						<input type="text" class="license_key" placeholder="<?php _e( 'لایسنس جدید', $this->text_domain ); ?>">
						<button class="button button-primary"><?php _e( 'فعالسازی لایسنس میهن پرس', $this->text_domain ); ?></button>
						<div class="result">
							<div class="spinner"><?php _e( 'لطفا چند لحظه صبر کنید ...', $this->text_domain ); ?></div>
							<div class="result_text"></div>
						</div>
					</form>

					<div class="check_result">
						<div class="spinner"><?php _e( 'لطفا چند لحظه صبر کنید ...', $this->text_domain ); ?></div>
						<div class="result_text"></div>
					</div>
					<div class="clear"></div>
				</div>
			<?php else : ?>
				<div class="mihanpress-license-single-page-message">
					<p><?php _e( 'ضمن تشکر بابت خرید شما کاربر گرامی', $this->text_domain ); ?></p>
					<p><?php _e( 'جهت استفاده از تمامی امکانات قالب میهن پرس لازم است لایسنسی را که در قسمت دانلود های ژاکت دریافت نموده اید را در باکس زیر وارد کنید.', $this->text_domain ); ?></p>
				</div>
				<form action="#" method="post" class="register_version_form">
					<input type="text" class="license_key" placeholder="<?php _e( 'کد لایسنس دریافتی', $this->text_domain ); ?>">
					<button class="button button-primary"><?php _e( 'فعالسازی ', $this->text_domain ); ?></button>
					<div class="result">
						<div class="spinner"><?php _e( 'لطفا چند لحظه صبر کنید ...', $this->text_domain ); ?></div>
						<div class="result_text"></div>
					</div>
				</form>
			<?php endif; ?>
			<script>
				jQuery(document).ready(function($) {
					var ajax_url = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
					jQuery(document).on('submit', '.register_version_form', function(event) {
						event.preventDefault();
						var starter = jQuery(this).find('.license_key').val(),
							thisEl = jQuery(this);
						thisEl.addClass('waiting');
						thisEl.find('.result').slideDown(300).addClass('show');
						thisEl.find('.button').addClass('disabled');
						thisEl.find('.result_text').slideUp(300).html('');
						jQuery.ajax({
							url: ajax_url,
							type: 'POST',
							dataType: 'json',
							data: {
								action: '<?php echo $this->slug; ?>',
								starter: starter
							},
						})
							.done(function(result) {
								thisEl.find('.result_text').append(result.data).slideDown(150)
							})
							.fail(function(result) {
								thisEl.find('.result_text').append('<div class="zhk_guard_danger"><?php _e( 'Something goes wrong please try again.', $this->text_domain ); ?></div>').slideDown(150)
							})
							.always(function(result) {
								console.log(result);
								thisEl.removeClass('waiting');
								thisEl.find('.result').removeClass('show');
								thisEl.find('.button').removeClass('disabled');
							});
					});

					$(document).on('click', '.wpmlr_revalidate', function(event) {
						event.preventDefault();
						var starter = $(this).data('key'),
							thisEl = $(this).parents('.current_license');
						thisEl.addClass('waiting');
						thisEl.find('.check_result').slideDown(300);
						thisEl.find('.button').addClass('disabled');
						thisEl.find('.result_text').slideUp(300).html('');
						thisEl.find('.register_version_form').slideUp(300)
						$.ajax({
							url: ajax_url,
							type: 'POST',
							dataType: 'json',
							data: {
								action: '<?php echo $this->slug; ?>_revalidate',
								starter: starter
							},
						})
							.done(function(result) {
								thisEl.find('.check_result .result_text').append(result.data).slideDown(150)
							})
							.fail(function(result) {
								thisEl.find('.check_result .result_text').append('<div class="wpmlr_danger"><?php _e( 'Something goes wrong please try again.', $this->text_domain ); ?></div>').slideDown(150)
							})
							.always(function(result) {
								thisEl.removeClass('waiting');
								thisEl.find('.button').removeClass('disabled');
							});
					});


					$(document).on('click', '.zhk_guard_new_key', function(event) {
						event.preventDefault();
						var thisEl = $(this).parents('.current_license');
						thisEl.find('.result_text').slideUp(300).html('');
						thisEl.find('.register_version_form').slideDown(300)
					});
				});
			</script>

		</div>
		<?php

	}

	/**
	 *
	 */
	public function wp_starter() {
		$starter = sanitize_text_field( $_POST['starter'] );
		if ( empty( $starter ) ) {
			wp_send_json_error( '<div class="zhk_guard_danger">' . __( 'لطفا لایسنس خود را وارد کنید.', $this->text_domain ) . '</div>' );
		}

		$private_session = get_option( self::$option_name );
		delete_option( $private_session );

		$product_token = $this->product_token;
		$result        = self::install( $starter, $product_token );
		$output        = '';

		if ( $result->status == 'successful' ) {
			$rand_key = md5( wp_generate_password( 12, true, true ) );
			update_option( self::$option_name, $rand_key );
			$result = array(
				'starter' => base64_encode( $starter ),
				'action'  => 1,
				'message' => __( 'کد لایسنس معتبر میباشد..', $this->text_domain ),
				'timer'   => time(),
			);
			update_option( $rand_key, json_encode( $result ) );
			$output = '<div class="zhk_guard_success">' . __( 'هورا ! لایسنس شما با موفقیت تایید شد.', $this->text_domain ) . '</div>';
			wp_send_json_success( $output );
		} else {
			if ( ! is_object( $result->message ) ) {
				$output = '<div class="zhk_guard_danger">' . $result->message . '</div>';
				wp_send_json_error( $output );
			} else {
				foreach ( $result->message as $message ) {
					foreach ( $message as $msg ) {
						$output .= '<div class="zhk_guard_danger">' . $msg . '</div>';
					}
				}
				wp_send_json_error( $output );
			}
		}
	}

	/**
	 * Show admin notice for registration problems
	 */
	public function admin_notice() {
		$private_session = get_option( self::$option_name );
		$now             = json_decode( get_option( $private_session ) );
		?>
		<?php if ( empty( $now ) ) : ?>
			<div class="notice notice-error mihanpress-license-admin-notice">
				<p>
					<?php printf( __( 'برای فعالسازی %s لطفا لایسنس قالب را وارد کنید.', $this->text_domain ), $this->name ); ?>
				</p>
				<a href="<?php echo admin_url( 'admin.php?page=' . $this->slug ); ?>" class="button button-primary"><?php _e( 'رفتن به صفحه لایسنس', $this->text_domain ); ?></a>
			</div>
		<?php elseif ( $now->action != 1 ) : ?>
			<div class="notice notice-error">
				<p>
					<?php printf( __( 'برای لایسنس %s مشکلی پیش آمده است. لطفا کد لایسنس را چک کنید.', $this->text_domain ), $this->name ); ?>
					<a href="<?php echo admin_url( 'admin.php?page=' . $this->slug ); ?>" class="button button-primary"><?php _e( 'Check Now', $this->text_domain ); ?></a>
				</p>
			</div>
		<?php endif; ?>
		<?php
	}

	/**
	 *  Ajax callback for check license action
	 */
	public function revalidate_starter() {
		$starter = sanitize_text_field( $_POST['starter'] );
		if ( empty( $starter ) ) {
			wp_send_json_error( '<div class="zhk_guard_danger">' . __( 'لطفا لایسنس خود را وارد کنید.active', $this->text_domain ) . '</div>' );
		}

		$result = self::is_valid( $starter );
		if ( $result->status == 'successful' ) {
			$rand_key = md5( wp_generate_password( 12, true, true ) );
			update_option( self::$option_name, $rand_key );
			$how = array(
				'starter' => base64_encode( $starter ),
				'action'  => 1,
				'message' => $result->message,
				'timer'   => time(),
			);
			update_option( $rand_key, json_encode( $how ) );
			$output = '<div class="zhk_guard_success">' . __( 'هورا ! لایسنس شما با موفقیت تایید شد.', $this->text_domain ) . '</div>';
			wp_send_json_success( $output );
		} else {
			$rand_key = md5( wp_generate_password( 12, true, true ) );
			update_option( self::$option_name, $rand_key );
			$how = array(
				'starter' => base64_encode( $starter ),
				'action'  => 0,
				'timer'   => time(),
			);
			if ( ! is_object( $result->message ) ) {
				$how['message'] = $result->message;
			} else {
				foreach ( $result->message as $message ) {
					foreach ( $message as $msg ) {
						$how['message'] = $msg;
					}
				}
			}
			update_option( $rand_key, json_encode( $how ) );
			$output = '<div class="zhk_guard_danger">' . $how['message'] . '</div>';
			wp_send_json_success( $output );
		}

	}

	/**
	 * Set a schedule event for daily checking
	 */
	public function schedule_programs() {
		if ( ! wp_next_scheduled( $this->slug . '_daily_validator' ) ) {
			wp_schedule_event( time(), 'daily', $this->slug . '_daily_validator' );
		}
	}

	/**
	 * Check license status every day
	 */
	public function daily_event() {
		$private_session = get_option( self::$option_name );
		$now             = json_decode( get_option( $private_session ) );
		if ( isset( $now ) && ! empty( $now ) ) {
			$starter = ( isset( $now->starter ) && ! empty( $now->starter ) ) ? base64_decode( $now->starter ) : '';
			$result  = self::is_valid( $starter );
			if ( $result != null ) {
				if ( $result->status == 'successful' ) {
					delete_option( $private_session );
					$rand_key = md5( wp_generate_password( 12, true, true ) );
					update_option( self::$option_name, $rand_key );
					$how = array(
						'starter' => base64_encode( $starter ),
						'action'  => 1,
						'message' => $result->message,
						'timer'   => time(),
					);
					update_option( $rand_key, json_encode( $how ) );
				} else {

					delete_option( $private_session );
					$rand_key = md5( wp_generate_password( 12, true, true ) );
					update_option( self::$option_name, $rand_key );
					$how = array(
						'starter' => base64_encode( $starter ),
						'action'  => 0,
						'timer'   => time(),
					);
					if ( ! is_object( $result->message ) ) {
						$how['message'] = $result->message;
					} else {
						foreach ( $result->message as $message ) {
							foreach ( $message as $msg ) {
								$how['message'] = $msg;
							}
						}
					}
					update_option( $rand_key, json_encode( $how ) );
				}
			}
		}
	}

	/**
	 * Check license status
	 * If you want add an interrupt in your plugin or theme simply can use this static method: MihanPress_Guard_SDK::is_activated
	 * This will return true or false for license status
	 *
	 * @return bool
	 */
	public static function is_activated() {
		$private_session = get_option( self::$option_name );
		$now             = json_decode( get_option( $private_session ) );
		if ( empty( $now ) ) {
			return false;
		} elseif ( $now->action != 1 ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @param $method
	 * @param array  $params
	 *
	 * @return array|mixed|object
	 */
	public static function send_request( $method, $params = array() ) {
		$param_string = http_build_query( $params );
		$ch           = curl_init();
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt(
			$ch,
			CURLOPT_URL,
			self::$api_url . $method . '?' . $param_string
		);
		$content = curl_exec( $ch );
		return json_decode( $content );
	}

	/**
	 * @param $license_token
	 *
	 * @return array|mixed|object
	 */
	public static function is_valid( $license_token ) {
		$result = self::send_request(
			'validation-license',
			array(
				'token'  => $license_token,
				'domain' => self::get_host(),
			)
		);
		return $result;
	}

	/**
	 * @param $license_token
	 * @param $product_token
	 *
	 * @return array|mixed|object
	 */
	public static function install( $license_token, $product_token ) {
		$result = self::send_request(
			'install-license',
			array(
				'product_token' => $product_token,
				'token'         => $license_token,
				'domain'        => self::get_host(),
			)
		);
		return $result;
	}

	/**
	 * @return string
	 */
	public static function get_host() {
		$possibleHostSources   = array( 'HTTP_X_FORWARDED_HOST', 'HTTP_HOST', 'SERVER_NAME', 'SERVER_ADDR' );
		$sourceTransformations = array(
			'HTTP_X_FORWARDED_HOST' => function( $value ) {
				$elements = explode( ',', $value );
				return trim( end( $elements ) );
			},
		);
		$host                  = '';
		foreach ( $possibleHostSources as $source ) {
			if ( ! empty( $host ) ) {
				break;
			}
			if ( empty( $_SERVER[ $source ] ) ) {
				continue;
			}
			$host = $_SERVER[ $source ];
			if ( array_key_exists( $source, $sourceTransformations ) ) {
				$host = $sourceTransformations[ $source ]($host);
			}
		}

		// Remove port number from host
		$host = preg_replace( '/:\d+$/', '', $host );
		// remove www from host
		$host = str_ireplace( 'www.', '', $host );

		return trim( $host );
	}

	/**
	 * @param $settings
	 *
	 * @return null|MihanPress_Guard_SDK
	 */
	public static function instance( $settings ) {
		// Check if instance is already exists
		if ( self::$instance == null ) {
			self::$instance = new self( $settings );
		}
		return self::$instance;
	}

}
add_action( 'init', 'mihanpress_guard_init' );
/**
 * Initialize function for class and hook it to WordPress init action
 */
function mihanpress_guard_init() {
	$settings = array(
		'name'          => 'قالب میهن پرس',
		'slug'          => 'mihanpress_guard_register',
		'parent_slug'   => 'options-general.php', // Read this: https://developer.wordpress.org/reference/functions/add_submenu_page/#parameters
		'text_domain'   => 'mihanpress',
		'product_token' => '89907163-661e-4e3b-88f1-2e29b55626b3', // Get it from here: https://zhaket.com/dashboard/licenses/
		'option_name'   => 'mihanpress_kibSp4AmA54N8',
	);
	MihanPress_Guard_SDK::instance( $settings );
}

/**
 * Define Core Theme Constants
 *
 * @since 1.0.0
 */
define( 'MIHANPRESS_THEME_URI', get_template_directory_uri() );
define( 'MIHANPRESS_THEME_DIR', get_template_directory() );
define( 'MIHANPRESS_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'MIHANPRESS_MATERIALIZE_VERSION', '1.0.0' );

/**
 * Main theme Class
 *
 * @since 1.0.0
 */
final class MihanPress_Theme {

	/**
	 * Main Theme Class Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		/** Load all core theme function files */
		add_action( 'after_setup_theme', array( __CLASS__, 'include_functions' ), 1 );

		/** Stop the program if license key is not validate */
		add_action( 'wp_head', array( __CLASS__, 'check_for_license' ), 999 );

		/** Load configuration classes */
		add_action( 'after_setup_theme', array( __CLASS__, 'configs' ), 3 );

		/** Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc */
		add_action( 'after_setup_theme', array( __CLASS__, 'theme_setup' ), 10 );

		/** Load Framework Classes */
		add_action( 'after_setup_theme', array( __CLASS__, 'classes' ), 10 );

		/** Register sidebar widget areas */
		add_action( 'widgets_init', array( __CLASS__, 'register_sidebars' ) );

		/** Add async/defer attributes to enqueued / registered scripts. */
		add_filter( 'script_loader_tag', array( __CLASS__, 'filter_script_loader_tag' ), 10, 2 );

		/** Load his file in last */
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'high_priority_css' ), 9999 );

		/** Load theme dynamic css */
		add_action( 'wp_head', array( __CLASS__, 'dynamic_css' ), 10000 );

		/** Load theme CSS */
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'theme_css' ) );

		/** Load theme JS */
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'theme_javascript' ) );

		/** Load scripts in the WP admin */
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );

		/** Load option panel scripts */
		add_action( 'redux/page/mihanpress_options/enqueue', array( __CLASS__, 'redux_scripts' ) );

		/** Loads html5 shiv script */
		add_action( 'wp_head', array( __CLASS__, 'html5_shiv' ) );

		/** Add support for Elementor Pro locations */
		add_action( 'elementor/theme/register_locations', array( __CLASS__, 'register_elementor_locations' ) );

	}

	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0
	 */
	public static function include_functions() {
		require_once MIHANPRESS_THEME_DIR . '/inc/breadcrumb.php';
		require_once MIHANPRESS_THEME_DIR . '/inc/comments.php';
		require_once MIHANPRESS_THEME_DIR . '/dashboard/class-dashboard.php';
		require_once MIHANPRESS_THEME_DIR . '/inc/walker/init.php';
		require_once MIHANPRESS_THEME_DIR . '/inc/walker/collapsible-walker.php';
		require_once MIHANPRESS_THEME_DIR . '/inc/dynamic-css.php';
	}

	/**
	 * Stop the program if license key is not validate
	 *
	 * @since 1.0.0
	 */
	public static function check_for_license() {
		if ( true !== MihanPress_Guard_SDK::is_activated() ) {
			wp_die( 'برای اجرای برنامه باید لایسنس قالب را در پنل ادمین وردپرس خود وارد کنید.' );
		}
	}

	/**
	 * Configs for 3rd party plugins.
	 *
	 * @since 1.0.0
	 */
	public static function configs() {
		/** WooCommerce config */
		if ( class_exists( 'WooCommerce' ) ) {
			require_once MIHANPRESS_THEME_DIR . '/inc/woocommerce.php';
		}
	}

	/**
	 * Load theme classes
	 *
	 * @since 1.0.0
	 */
	public static function classes() {
		if ( is_admin() ) {
			/** Recommended plugins */
			require_once MIHANPRESS_THEME_DIR . '/inc/tgmpa/class-tgm-plugin-activation.php';
			require_once MIHANPRESS_THEME_DIR . '/inc/tgmpa/tgm-plugin-activation.php';
		}

		/** Login page config */
		require_once MIHANPRESS_THEME_DIR . '/inc/class-login.php';
	}

	/**
	 * Theme Setup
	 *
	 * @since 1.0.0
	 */
	public static function theme_setup() {
		/** Load text domain */
		load_theme_textdomain( 'mihanpress', MIHANPRESS_THEME_DIR . '/languages' );

		/** Get globals */
		global $content_width;

		/** Set content width based on theme's default design */
		if ( ! isset( $content_width ) ) {
			$content_width = 1200;
		}

		/** Register navigation menus */
		register_nav_menus(
			array(
				'top_menu'        => esc_html__( 'منوی سربرگ', 'mihanpress' ),
				'responsive_menu' => esc_html__( 'منوی موبایل', 'mihanpress' ),
			)
		);

		/** Enable support for <title> tag */
		add_theme_support( 'title-tag' );

		/** Add default posts and comments RSS feed links to head */
		add_theme_support( 'automatic-feed-links' );

		/** Enable support for Post Thumbnails on posts and pages */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets',
			)
		);

		/** Declare WooCommerce support */
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/** Declare support for selective refreshing of widgets. */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/** Set theme options global vaiable */
		global $mihanpress_options;

		/** Remove WordPress emoji */
		if ( '1' === $mihanpress_options['wp-emoji'] ) {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
		}

		/** Remove query strings from static resources */
		if ( '1' === $mihanpress_options['string-query'] ) {
			add_filter( 'script_loader_src', array( __CLASS__, 'remove_script_version' ), 15, 1 );
			add_filter( 'style_loader_src', array( __CLASS__, 'remove_script_version' ), 15, 1 );
		}

		if ( ! current_user_can( 'manage_options' ) && '1' === $mihanpress_options['wordpress_topbar'] ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}
	}

	/**
	 * Registers sidebars
	 *
	 * @since 1.0.0
	 */
	public static function register_sidebars() {
		global $mihanpress_options;
		$heading = 'h2';
		$heading = apply_filters( 'mihanpress_sidebar_heading', $heading );

		/** Blog Sidebar */
		register_sidebar(
			array(
				'name'         => esc_html__( 'ساید بار وبلاگ', 'mihanpress' ),
				'id'           => 'sidebar_blog',
				'description'  => esc_html__( 'سایدبار وبلاگ', 'mihanpress' ),
				'before_title' => '<' . $heading . ' class="widget-title h3">',
				'after_title'  => '</' . $heading . '>',
			)
		);

		/** WooCommerce Sidebar */
		if ( class_exists( 'WooCommerce' ) ) {
			register_sidebar(
				array(
					'name'         => esc_html__( 'ساید بار ووکامرس', 'mihanpress' ),
					'id'           => 'sidebar_shop_woocommerce',
					'description'  => esc_html__( 'سایدبار ووکامرس', 'mihanpress' ),
					'before_title' => '<' . $heading . ' class="widget-title h3">',
					'after_title'  => '</' . $heading . '>',
				)
			);
		}

		/** Sidenav Sidebar */
		if ( '1' === $mihanpress_options['sidenav_desktop'] ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'ساید بار بخش کشویی دسکتاپ', 'mihanpress' ),
					'id'            => 'desktop_sidenav',
					'description'   => esc_html__( 'بخش کشویی دسکتاپ', 'mihanpress' ),
					'before_widget' => '<div id="%1$s" class="mb-3">',
					'after_widget'  => '</div>',
					'before_title'  => '<' . $heading . ' class="sidenav_widgettitle">',
					'after_title'   => '</' . $heading . '>',
				)
			);
		}

		/** Footer Sidebars */
		$footer_widget_counts = ! empty( $mihanpress_options['footer_widget_counts'] ) ? $mihanpress_options['footer_widget_counts'] : 4;
		for ( $i = 0; $i < $footer_widget_counts; $i++ ) {
			register_sidebar(
				array(
					'name'          => sprintf( esc_html__( 'فوتر #%s', 'mihanpress' ), ( $i + 1 ) ),
					'id'            => 'footer_' . $i,
					'description'   => esc_html__( 'بخش فوتر یا پاورقی وبسایت (برای مدیریت تعداد ستون ها به تنظیمات قالب بروید)', 'mihanpress' ),
					'before_widget' => '<div id="%1$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<div class="footer_widgettitle">',
					'after_title'   => '</div>',
					'before_title'  => '<' . $heading . ' class="footer-title">',
					'after_title'   => '</' . $heading . '>',
				)
			);
		};
	}

	/**
	 * Remove ?ver from scripts and styles url
	 *
	 * @since 1.0.0
	 */
	public static function remove_script_version( $src ) {
		$parts = explode( '?ver', $src );
		return $parts[0];
	}

	/**
	 * Adds async/defer attributes to enqueued / registered scripts.
	 *
	 * @since 1.0.0
	 */
	public static function filter_script_loader_tag( $tag, $handle ) {
		foreach ( array( 'async', 'defer' ) as $attr ) {
			if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
				continue;
			}
			// Prevent adding attribute when already added in #12009.
			if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
				$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
			}
			// Only allow async or defer, not both.
			break;
		}
		return $tag;
	}

	/**
	 * Load scripts in the WP admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_scripts() {
		wp_register_style( 'mihanpress-admin', MIHANPRESS_THEME_URI . '/assets/dist/css/admin.min.css', false, MIHANPRESS_THEME_VERSION, 'all' );
		wp_enqueue_style( 'mihanpress-admin' );
	}

	/**
	 * Load option panel scripts
	 *
	 * @since 1.6.0
	 */
	public static function redux_scripts() {
		wp_register_style( 'mihanpress-redux', MIHANPRESS_THEME_URI . '/assets/dist/css/redux.min.css', array( 'redux-admin-css' ), MIHANPRESS_THEME_VERSION, 'all' );
		wp_enqueue_style( 'mihanpress-redux' );
	}

	/**
	 * Register Frontend Stylesheets
	 *
	 * @since 1.0.0
	 */
	public static function theme_css() {
		/** Register Theme Main Stylesheet */
		wp_register_style( 'mihanpress-style', MIHANPRESS_THEME_URI . '/assets/dist/css/main.min.css', false, MIHANPRESS_THEME_VERSION, 'all' );
		wp_enqueue_style( 'mihanpress-style' );

		/** Register Flickity Carousel CSS */
		wp_register_style( 'mihanpress-flickity-carousel', MIHANPRESS_THEME_URI . '/assets/dist/css/flickity.min.css', false, '2.2.1', 'all' );
	}

	/**
	 * Register High Priority Stylesheets
	 *
	 * @since 1.0.0
	 */
	public static function high_priority_css() {
		if ( class_exists( 'WooCommerce' ) ) {
			wp_register_style( 'mihanpress-woocommerce', MIHANPRESS_THEME_URI . '/assets/dist/css/woocommerce.min.css', false, MIHANPRESS_THEME_VERSION, 'all' );
			wp_enqueue_style( 'mihanpress-woocommerce' );
		}
	}

	/**
	 * Minify CSS
	 *
	 * @since 1.0.0
	 */
	public static function minify_css( $css = '' ) {
		/** Return if no CSS */
		if ( ! $css ) {
			return;
		}

		/** Normalize whitespace */
		$css = preg_replace( '/\s+/', ' ', $css );

		/** Remove ; before } */
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		/** Remove space after some operators */
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		/** Remove space before , ; { } */
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		/** Strips leading 0 on decimal values (converts 0.5px into .5px) */
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		/** Strips units if value is 0 (converts 0px to 0) */
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		/** Trim */
		$css = trim( $css );

		/** Return minified CSS */
		return $css;
	}

	/**
	 * Theme Dynamic CSS
	 *
	 * @since 1.0.0
	 */
	public static function dynamic_css() {
		/** Minify CSS */
		$css = self::minify_css( mihanpress_dynamic_css() );

		/** Print CSS output */
		echo '<style type="text/css">' . wp_strip_all_tags( $css ) . '</style>';
	}

	/**
	 * Register All Frontend JS
	 *
	 * @since 1.0.0
	 */
	public static function theme_javascript() {
		global $mihanpress_options;
		$localize_array = self::localize_array();

		/** Flickity Carousel JS */
		wp_register_script( 'mihanpress-flickity-carousel-js', MIHANPRESS_THEME_URI . '/assets/js/libraries/flickity.pkgd.min.js', false, '2.2.1', true );

		/** Masonry (Macy) JS */
		wp_register_script( 'mihanpress-masonry', MIHANPRESS_THEME_URI . '/assets/js/libraries/macy.min.js', false, '2.5.1', true );

		/** Sticky Sidebar and Resize Sensor JS */
		if ( '1' === $mihanpress_options['sticky_sidebar'] ) {
			wp_register_script( 'mihanpress-sticky-sidebar', MIHANPRESS_THEME_URI . '/assets/dist/js/sticky-sidebar.min.js', false, '3.3.1', true );
			wp_enqueue_script( 'mihanpress-sticky-sidebar' );
		}

		/** Masonry Grid */
		if ( ( 'masonry' === $mihanpress_options['blog_archive_template'] && ( is_archive() || is_search() || is_author() || is_front_page() ) )
			|| ( class_exists( 'WooCommerce' ) &&
				( is_shop() || is_product_category() || is_product_tag() || ( class_exists( 'WeDevs_Dokan' ) && dokan_is_store_page() ) ) ) ) {
			wp_enqueue_script( 'mihanpress-masonry' );
		}

		/** Comments Reply */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		/** Main Theme Javascript */
		wp_register_script( 'mihanpress-javascript', MIHANPRESS_THEME_URI . '/assets/dist/js/main.min.js', false, MIHANPRESS_THEME_VERSION, true );
		wp_localize_script( 'mihanpress-javascript', 'mihanpress_js_translate', $localize_array );
		wp_enqueue_script( 'mihanpress-javascript' );

		/** Add defer data to theme registred scripts */
		self::add_defer_data_scripts();
	}

	/**
	 *
	 * Add defer data to theme registered scripts
	 *
	 * @since 1.0.0
	 */
	public static function add_defer_data_scripts() {
		$handles = array(
			'mihanpress-flickity-carousel-js',
			'mihanpress-masonry',
			'mihanpress-sticky-sidebar',
			'mihanpress-javascript',
		);
		$handles = apply_filters( 'mihanpress_defer_scripts', $handles );

		foreach ( $handles as $handle ) {
			wp_script_add_data( $handle, 'defer', true );
		}
	}

	/**
	 * Main javascript localize array
	 *
	 * @since 1.0.0
	 */
	public static function localize_array() {
		$translation_array = array(
			'added_to_cart'     => esc_html__( 'یک محصول به سبد خرید شما اضافه شد .', 'mihanpress' ),
			'copied_short_link' => esc_html__( 'لینک کوتاه مطلب کپی شد.', 'mihanpress' ),
			'ajaxurl'           => admin_url( 'admin-ajax.php' ),
			'like'              => esc_html__( 'پسندیدن', 'mihanpress' ),
			'unlike'            => esc_html__( 'لغو پسندیدن', 'mihanpress' ),
		);
		return apply_filters( 'mihanpress_localize_array', $translation_array );
	}

	/**
	 * Load HTML5 dependencies for IE8
	 *
	 * @since 1.0.0
	 */
	public static function html5_shiv() {
		wp_register_script( 'html5shiv', MIHANPRESS_THEME_URI . '/assets/html5shiv.min.js', false, '3.7.3', true );
		wp_enqueue_script( 'html5shiv' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	}

	/**
	 * Add support for Elementor Pro locations
	 *
	 * @since 1.0.0
	 */
	public static function register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_all_core_location();
	}

	/**
	 * Site Font from theme options
	 *
	 * @since 1.0.0
	 */
	public static function load_site_font() {
		global $mihanpress_options;
		$theme_font    = $mihanpress_options['theme_fonts'];
		$theme_dir_url = MIHANPRESS_THEME_URI;

		if ( ! empty( $theme_font ) ) {
			if ( 'custom' === $theme_font ) {
				$eot_font   = ! empty( $mihanpress_options['custom-font-eot'] ) ? 'url(' . esc_url( $mihanpress_options['custom-font-eot'] ) . '?#iefix) format("embedded-opentype")' : '';
				$woff2_font = ! empty( $mihanpress_options['custom-font-woff2'] ) ? 'url(' . esc_url( $mihanpress_options['custom-font-woff2'] ) . ') format("woff2")' : '';
				$woff_font  = ! empty( $mihanpress_options['custom-font-woff'] ) ? 'url(' . esc_url( $mihanpress_options['custom-font-woff'] ) . ') format("woff")' : '';
				$ttf_font   = ! empty( $mihanpress_options['custom-font-ttf'] ) ? 'url(' . esc_url( $mihanpress_options['custom-font-ttf'] ) . ') format("truetype")' : '';

				$font_array = array_filter( array( $eot_font, $woff2_font, $woff_font, $ttf_font ) );

				$dynamic_font = "@font-face {
                font-family: 'mihanpress-font';
                font-weight: normal;
                font-style: normal;
                " . ( ! empty( $eot_font ) ? 'src: url("' . esc_url( $mihanpress_options['custom-font-eot'] ) . '");' : '' ) . '
                src: ' . implode( ',', $font_array ) . ';
            }';
			} else {
				$dynamic_font = "@font-face {
                font-family: 'mihanpress-font';
                src: url({$theme_dir_url}/assets/webfonts/{$theme_font}/{$theme_font}.eot);
                src: url({$theme_dir_url}/assets/webfonts/{$theme_font}/{$theme_font}.eot?#iefix) format(\"embedded-opentype\"),
                     url({$theme_dir_url}/assets/webfonts/{$theme_font}/{$theme_font}.woff2) format(\"woff2\"),
                     url({$theme_dir_url}/assets/webfonts/{$theme_font}/{$theme_font}.woff) format(\"woff\"),
                     url({$theme_dir_url}/assets/webfonts/{$theme_font}/{$theme_font}.ttf) format(\"truetype\");
                font-weight: normal;
                font-style: normal
            }";
			}
			return $dynamic_font;
		}
	}
}
new MihanPress_Theme();



/**
 * User Custom PHP
 *
 * @since 1.0.0
 */
require_once MIHANPRESS_THEME_DIR . '/functions-custom.php';
