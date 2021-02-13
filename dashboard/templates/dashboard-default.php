<?php
/**
 * Default dashboard page
 *
 * @package MihanPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $mihanpress_options;
?>
<p>
	<?php
	printf(
		wp_kses_post( __( 'سلام %1$s ( %1$s نیستید؟ <a href="%2$s">خارج شوید</a>)', 'mihanpress' ) ),
		'<strong>' . esc_html( wp_get_current_user()->display_name ) . '</strong>',
		esc_url( wp_logout_url( wp_login_url() ) )
	);
	?>
</p>

<section class="dashboard_info row">
	<?php do_action( 'mihanpress_before_dashboard_info' ); ?>

	<?php if ( '1' === $mihanpress_options['registred_days'] ) : ?>
		<div class="col-lg-4 p-1 orange">
			<div>
				<?php
				$today_obj      = new DateTime( date( 'Y-m-d', strtotime( 'today' ) ) );
				$register_date  = get_the_author_meta( 'user_registered', get_current_user_id() );
				$registered_obj = new DateTime( date( 'Y-m-d', strtotime( $register_date ) ) );
				$interval_obj   = $today_obj->diff( $registered_obj );
				echo '<strong>' . $interval_obj->days . '</strong>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
				<div><?php echo esc_html( $mihanpress_options['registred_days_text'] ); ?></div>
				<span class="flaticon-clock-1"></span>
			</div>
		</div>
		<?php
	endif;
	if ( class_exists( 'WooWallet' ) && '1' === $mihanpress_options['woo_wallet'] ) :
		?>
		<div class="col-lg-4 p-1 light-purple">
			<div>
				<?php echo '<strong>' . woo_wallet()->wallet->get_wallet_balance( get_current_user_id() ) . '</strong>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<div><?php echo esc_html( $mihanpress_options['woo_wallet_text'] ); ?></div>
				<span class="flaticon-money-1"></span>
			</div>
		</div>
		<?php
	endif;

	if ( '1' === $mihanpress_options['approved_comments'] ) :
		?>
		<div class="col-lg-4 p-1 blue">
			<div>
				<?php

				global $wpdb, $post, $current_user;
				wp_get_current_user();
				$user_id = $current_user->ID;

				$where         = 'WHERE comment_approved = 1 AND user_id = ' . $user_id;
				$comment_count = $wpdb->get_var(
					"SELECT COUNT( * ) AS total 
                             FROM {$wpdb->comments}
                             {$where}"
				);
				echo '<strong>' . $comment_count . '</strong>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
				<div><?php echo esc_html( $mihanpress_options['approved_comments_text'] ); ?></div>
				<span class="flaticon-message"></span>
			</div>
		</div>
		<?php
	endif;

	if ( '1' === $mihanpress_options['completed_orders'] ) :
		?>
		<div class="col-lg-4 p-1 red">
			<div>
				<strong>
					<?php
					$customer_orders = get_posts(
						array(
							'numberposts' => -1,
							'meta_key'    => '_customer_user',
							'meta_value'  => get_current_user_id(),
							'post_type'   => 'shop_order',
							'post_status' => 'wc-completed',
						)
					);
					echo count( $customer_orders );
					?>
					</strong>
				<div><?php echo esc_html( $mihanpress_options['completed_orders_text'] ); ?></div>
				<span class="flaticon-shopping-cart-1"></span>
			</div>
		</div>
		<?php
	endif;

	if ( '1' === $mihanpress_options['total_purchased'] ) :
		?>
		<div class="col-lg-4 p-1 green">
			<div>
				<strong>
					<?php
					echo MihanPress_WooCommerce_config::get_customer_total_order() / 1000; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</strong>
				<div><?php echo esc_html( $mihanpress_options['total_purchased_text'] ); ?></div>
				<span class="flaticon-money-bag"></span>
			</div>
		</div>
		<?php
	endif;
	if ( class_exists( 'Easy_Digital_Downloads' ) && '1' === $mihanpress_options['purchased_files_count'] ) :
		?>
		<div class="col-lg-4 p-1 purple">
			<?php
			$user_id            = get_current_user_id();
			$edd_user_purchased = edd_get_users_purchases( $user_id );
			$counter            = 0;
			if ( $edd_user_purchased ) {
				foreach ( $edd_user_purchased as $val ) {
					foreach ( $val as $k => $v ) {
						if ( 'ID' === $k ) {
							$get_products = edd_get_payment_meta_cart_details( $v );
							foreach ( $get_products as $get_product ) {
								$counter++;
							}
						}
					}
				}
			}

			?>
			<div>
				<strong>
					<?php
					echo $counter; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</strong>
				<div><?php echo esc_html( $mihanpress_options['purchased_files_count_text'] ); ?></div>
				<span class="flaticon-files-and-folders"></span>
			</div>
		</div>
	<?php endif; ?>

	<?php
	if ( '1' === $mihanpress_options['coupon'] ) :
		?>
		<div class="col-lg-6 p-1 night-blue">
			<div class="coupon_gift">
				<strong class="en-text"><?php echo esc_html( $mihanpress_options['coupon_itself'] ); ?></strong>
				<div><?php echo esc_html( $mihanpress_options['coupon_description'] ); ?></div>
				<span class="flaticon-gift"></span>
			</div>
		</div>
		<?php
	endif;
	?>

	<?php do_action( 'mihanpress_after_dashboard_info' ); ?>
</section>
<section class="dashboard-alerts">
	<?php
	global $mihanpress_options;

	if ( ! empty( $mihanpress_options['user_dashboard_alert_1'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_1'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_2'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_2'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_3'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_3'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_4'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_4'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_5'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_5'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_6'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_6'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_7'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_7'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_8'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_8'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_9'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_9'] ) . '</div>';
	}
	if ( ! empty( $mihanpress_options['user_dashboard_alert_10'] ) ) {
		echo '<div>' . wp_kses_post( $mihanpress_options['user_dashboard_alert_10'] ) . '</div>';
	}
	?>
</section>
