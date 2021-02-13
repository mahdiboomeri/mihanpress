<?php
/**
 * Dashboard Navigation
 *
 * @package MihanPress
 * @since 1.0.0
 */

$task = ! empty( $_GET['task'] ) ? $_GET['task'] : ''; // phpcs:ignore WordPress.Security.NonceVerification
?>
<div class="col-lg-4 pr-0 pl-0 pl-md-3 mb-3 ltr-pl-md-0 ltr-pr-md-3">
	<div class="mihanpress-dashboard-sidebar">
		<div class="user-panel_details">
			<?php
			$current_user      = wp_get_current_user();
			$current_user_name = $current_user->display_name;
			echo get_avatar( $current_user->user_email );
			echo '<div class="user-panel-username">' . $current_user->user_login . '</div>';
			echo '<div>';
			printf( esc_html__( '%s عزیز خوش آمدید!', 'mihanpress' ), $current_user_name );
			echo '</div>';
			?>
		</div>
		<nav class="mp-dashboard-menu">
			<ul class="menu">
				<?php
				foreach ( $menu_items as $value ) :
					if ( $task === $value['task'] ) {
						$class = 'active';
					} else {
						$class = '';
					}
					if ( ! empty( $value['url'] ) ) {
						$link = $value['url'];
					} else {
						$link = add_query_arg( 'task', $value['task'], get_permalink() );
					}
					?>

					<li class="<?php echo esc_attr( $value['task'] . ' ' . $class ); ?>">
						<a href="<?php echo esc_url( $link ); ?>">
							<?php echo esc_html( $value['name'] ); ?>
						</a>
					</li>
					<?php
				endforeach;
				?>
				<li>
					<a href="<?php echo esc_url( wp_logout_url( wp_login_url() ) ); ?>">
						<?php esc_html_e( 'خروج از سیستم', 'mihanpress' ); ?>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</div>
