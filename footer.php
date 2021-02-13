<?php
/**
 * The template for displaying footer
 *
 * @package MihanPress
 * @since 1.0.0
 */

global $mihanpress_options;

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
	?>
	<footer id="footer">
		<?php if ( '1' === $mihanpress_options['footer_topbar_switch'] ) : ?>
			<div class="footer-notice p-4">
				<section class="container d-flex justify-content-between flex-wrap pt-3 pb-3">
					<?php
					if ( 'text' === $mihanpress_options['footer_topbar_type'] ) {
						echo wp_kses_post( $mihanpress_options['footer_topbar_text_content'] );
					} elseif ( 'badge' === $mihanpress_options['footer_topbar_type'] ) {
						$items = $mihanpress_options['footer_topbar_badge_content'];
						$box   = array();
						foreach ( $items as $item ) {
							$box[ $item['sort'] ] = array(
								'title' => $item['title'],
								'img'   => $item['image'],
								'url'   => $item['url'],
							);
						}

						foreach ( $box as $item ) {
							?>
							<div class="footer-badge pb-4">
								<a href="<?php echo esc_url( $item['url'] ); ?>" class="d-flex flex-column align-items-center">
									<img src="<?php echo esc_url( $item['img'] ); ?>" class="footer-badge-img" alt="<?php echo esc_attr( $item['title'] ); ?>">
									<span class="pt-2"><?php echo esc_html( $item['title'] ); ?></span>
								</a>
							</div>
							<?php
						}
					} else {
						echo '<nav class="mr-auto ml-auto">';
						wp_nav_menu(
							array(
								'menu'       => intval( $mihanpress_options['footer_topbar_menu_content'] ),
								'container'  => false,
								'menu_class' => 'footer-nav',
							)
						);
						echo '</nav>';
					}
					?>
				</section>

			</div>
		<?php endif; ?>
		<section class="container row mr-auto ml-auto pt-4 pr-0 pl-0 pb-0">
			<?php
			$footer_widget_counts  = ! empty( $mihanpress_options['footer_widget_counts'] ) ? $mihanpress_options['footer_widget_counts'] : 4;
			$footer_columns        = ! empty( $mihanpress_options['footer_columns'] ) ? intval( $mihanpress_options['footer_columns'] ) : 4;
			$footer_columns_tablet = ! empty( $mihanpress_options['footer_columns_tablet'] ) ? intval( $mihanpress_options['footer_columns_tablet'] ) : 2;

			for ( $i = 0; $i < $footer_widget_counts; $i++ ) {
				if ( is_active_sidebar( 'footer_' . $i ) ) {
					echo '<div class="col-lg-' . 12 / $footer_columns . ' col-md-' . 12 / $footer_columns_tablet . ' mb-3 mt-3">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					dynamic_sidebar( 'footer_' . $i );
					echo '</div>';
				}
			}
			?>
		</section>

		<?php if ( ! empty( $mihanpress_options['footer_menu'] ) ) : ?>
			<section class="footer-after-menu container d-flex">
				<nav class="mr-auto ml-auto">
					<?php
					wp_nav_menu(
						array(
							'menu'       => intval( $mihanpress_options['footer_menu'] ),
							'container'  => false,
							'menu_class' => 'footer-nav',
						)
					);
					?>
				</nav>
			</section>
		<?php endif; ?>

		<section class="copyright ">
			<div class="container">
				<?php echo wp_kses_post( $mihanpress_options['footer_copyright'] ); ?>
			</div>
		</section>

	</footer><!--#footer-->
<?php } // Elementor ?>

<?php if ( '1' === $mihanpress_options['backtotop'] ) : ?>
	<a href="#" id="backtotop" class="btn btn-primary <?php echo 'left' === $mihanpress_options['backtotop_position'] ? 'backtotop-left' : ''; ?>">
		<span class="flaticon-arrow-up-solid"></span>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>

</html>
