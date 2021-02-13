<?php
/**
 * User Dashboard Panel
 *
 * @package MihanPress
 * @since 1.0.0
 */

namespace MihanPress;

if ( class_exists( 'WooCommerce' ) ) {
	include_once MIHANPRESS_THEME_DIR . '/dashboard/templates/woocommerce-downloads.php';
	include_once MIHANPRESS_THEME_DIR . '/dashboard/templates/woocommerce-address.php';
	include_once MIHANPRESS_THEME_DIR . '/dashboard/templates/woocommerce-orders.php';
}

class Dashboard {

	/**
	 * Class Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_shortcode( 'mihanpress_user_dashboard', array( $this, 'dashboard_shortcode' ) );

		/** Redirect to login */
		add_action( 'template_redirect', array( $this, 'redirect_login_users' ) );

		/** Redirect to panel */
		add_filter( 'login_redirect', array( $this, 'admin_login_redirect' ), 10, 3 );

		/** Disable pagination for orders list */
		add_filter( 'woocommerce_my_account_my_orders_query', array( $this, 'orders_per_page' ), 20, 1 );
	}

	/**
	 * Build the dashboard shortcode
	 *
	 * @since 1.0.0
	 */
	public function dashboard_shortcode( $atts, $content = '' ) {
		ob_start();

		if ( is_user_logged_in() ) :

			$menu_items        = $this->build_menu();
			$dashboard_content = $this->build_page_content();
			?>
			<div class="row">
				<?php
				/** Customer dashboard menu */
				do_action( 'mihanpress_dashboard_before_menu' );
				require_once MIHANPRESS_THEME_DIR . '/dashboard/templates/dashboard-navigation.php';
				do_action( 'mihanpress_dashboard_after_menu' );

				?>
				<div class="col-lg-8 p-0">
					<div class="mihanpress-dashboard-content">
						<?php
						do_action( 'mihanpress_dashboard_before_content' );
						echo $dashboard_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						do_action( 'mihanpress_dashboard_after_content' );
						?>
					</div>
				</div>
			</div>

			<?php
		else :
			esc_html_e( 'برای دسترسی به پنل میبایست وارد شوید', 'mihanpress' );

		endif;

		$dashboard = ob_get_clean();

		return $dashboard;
	}

	/**
	 * Customer dashboard menu items
	 *
	 * @since 1.0.0
	 */
	public function build_menu() {
		global $mihanpress_options;
		$menu  = array();
		$items = $mihanpress_options['mihanpress_dashboard_menus'];

		$menu['dashboard'] = array(
			'task' => 'dashboard',
			'name' => esc_html__( 'داشبورد کاربری', 'mihanpress' ),
			'url'  => '',
		);
		foreach ( $items as $item ) {
			$item_sort = intval( $item['sort'] ) + 1;
			if ( ! empty( $item['title'] ) ) {
				$menu[ $item_sort ] = array(
					'task' => $item_sort,
					'name' => esc_html( $item['title'] ),
					'url'  => esc_url( $item['url'] ),
				);
			}
		}

		ksort( $menu );
		return $menu;
	}

	/**
	 * Customer dashboard page content
	 *
	 * @since 1.0.0
	 */
	public function build_page_content() {
		$task       = ! empty( $_GET['task'] ) ? $_GET['task'] : '';
		$view_order = ! empty( $_GET['view_order'] ) ? $_GET['view_order'] : '';

		ob_start();
		if ( ! empty( $view_order ) && function_exists( 'woocommerce_account_view_order' ) ) {
			woocommerce_account_view_order( $view_order );
		} else {
			if ( 'dashboard' === $task || empty( $task ) ) {
				get_template_part( 'dashboard/templates/dashboard-default' );
			} else {
				global $mihanpress_options;
				$task  = intval( $task );
				$items = $mihanpress_options['mihanpress_dashboard_menus'];
				foreach ( $items as $item ) {
					$item_sort = intval( $item['sort'] ) + 1;
					if ( $item_sort === $task ) {
						echo '<div class="dashboard-title bg-colorful shadow-colorful"><h3>' . esc_html( $item['title'] ) . '</h3></div>';
						echo '<div class="dashboard-content-wrapper">';
						echo do_shortcode( $item['description'], false );
						echo '</div>';
					}
				}
			}
		}

		$dashboard_content = ob_get_clean();

		return $dashboard_content;
	}

	/**
	 * Redirect none logedin users
	 *
	 * @since 1.0.0
	 */
	public function redirect_login_users() {
		global $mihanpress_options;
		if ( ! is_user_logged_in() ) {
			$panel_url = ! empty( $mihanpress_options['panel_slug'] ) ? $mihanpress_options['panel_slug'] : 'panel';
			if ( is_page( $panel_url ) ) {
				wp_redirect( wp_login_url() );
			}
		}
	}

	/**
	 * Redirect normal users
	 *
	 * @since 1.0.0
	 */
	public function admin_login_redirect( $redirect_to, $request, $user ) {
		global $mihanpress_options;

		$panel_url = ! empty( $mihanpress_options['panel_slug'] ) ? $mihanpress_options['panel_slug'] : 'panel';
		$url       = home_url( '/' );
		if ( $user && is_object( $user ) && is_a( $user, 'WP_User' ) ) {
			if ( $user->has_cap( 'administrator' ) ) {
				$url = admin_url();
			} else {
				$url = home_url( '/' . $panel_url . '' );
			}
		}
		return $url;
	}

	/**
	 * Disable pagination for orders list
	 *
	 * @since 1.4.0
	 */
	public function orders_per_page( $args ) {
		$args['limit'] = -1;

		return $args;
	}
}
new Dashboard();
