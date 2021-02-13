<?php
/**
 * Config for WoocCommerce Plugin
 *
 * @package MihanPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MihanPress_WooCommerce_Config {

	/**
	 * Main Class Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		global $mihanpress_options;

		/** Change number of posts in products archive */
		add_filter( 'loop_shop_per_page', array( __CLASS__, 'shop_per_page' ), 20 );

		/** Return Discount Percentage insted of Sale Badge */
		add_filter( 'woocommerce_sale_flash', array( __CLASS__, 'percentage_to_sale_badge' ), 20, 3 );

		/** Change number of related posts in single-product page */
		add_filter( 'woocommerce_output_related_products_args', array( __CLASS__, 'related_products_limit' ) );

		/** Ajax refresh mini-cart items */
		add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'mini_cart_ajax_refresh' ) );

		/** Ajax refresh mini-cart count */
		add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'iconic_cart_count_fragments' ), 10, 1 );

		/** Remove <a> tag from loop start - Content-product.php */
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

		/** Remove default thumbnail - Content-product.php */
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		/** Remove default woocommerce sale flush - Content-product.php */
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

		/** Show custom woocommerce sale flush - Content-product.php */
		add_action( 'mihanpress_custom_woocommerce_sale_flush', 'woocommerce_show_product_loop_sale_flash' );

		/** Remove default Title - Content-product.php */
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

		/** Remove default rating - Content-product.php */
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		/** Remove <a> tag from loop end - Content-product.php */
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

		/** Filter default add to cart button - Content-product.php */
		add_filter( 'woocommerce_loop_add_to_cart_args', array( __CLASS__, 'template_loop_add_to_cart' ) );

		/** Add Custom rating template - Content-product.php */
		add_action( 'woocommerce_after_shop_loop_item_title', array( __CLASS__, 'template_loop_rating' ), 15 );

		/** Add Custom Ttitle template - Content-product.php */
		add_action( 'woocommerce_shop_loop_item_title', array( __CLASS__, 'template_loop_product_title' ), 10 );

		/** Add Custom thumbnail template - Content-product.php */
		add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'template_loop_product_thumbnail' ), 10 );

		/** Remove output content wrapper start tags - [Single-product.php , Archive-product.php] */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );

		/** Remove output content wrapper end tags - Global */
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		/** Remove Woocommerce default breadcrumb - Global */
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

		/** Remove Product title above add to cart button - Single-product.php */
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

		/** Remove Rating of current post (Sidebar) - Single-product.php */
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

		/** Remove tabs in single product page - Single-product.php */
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

		/** Remove woocommerce default sidebar - Global */
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

		/** Remove product sale flash - Single-product.php */
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

		/** Change priority of single product Summary - Single-product.php */
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

		/** Add Product Description that removed with Tabs - Single-product.php */
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'template_product_description' ), 20 );

		/** Add Product Reviews that removed with Tabs - Single-product.php */
		add_action( 'woocommerce_before_single_product_summary', 'comments_template', 30 );

		/** Add Product Testimonial (from Custom metabox) - Single-product.php */
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'woocommerce_testimonial' ), 22 );

		/** Add Vendor Information (Dokan plugin) - Single-product.php */
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'single_product_vendor_info' ), 23 );

		/** Add Product Updates (from Custom metabox) - Single-product.php */
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'single_product_updates' ), 24 );

		/** Prodcut Additional Information table (Woocommerce default) - Single-product.php */
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'additional_information' ), 25 );

		/** Add Product Meta data (Custom metabox) - Single-product.php */
		add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'woocommerce_last_modified_date' ), 10 );

		/** Add extra button under add to cart button (Custom metabox) - Single-product.php */
		add_action( 'woocommerce_after_add_to_cart_button', array( __CLASS__, 'single_product_extra_button' ) );

		/** Add Reply link for normal users - Single-product.php */
		add_action( 'woocommerce_review_comment_text', array( __CLASS__, 'woocommerce_review_reply_button' ) );

		/** Add waiting approval box in reviews - Single-product.php */
		add_action( 'woocommerce_review_before_comment_text', array( __CLASS__, 'woocommerce_awaiting_approval_massage' ) );

		/** Add Scrollspy section to sidebar of single product - Single-product.php */
		add_action( 'woocommerce_sidebar', array( __CLASS__, 'single_product_sidebar_scrollspy' ), 5 );

		/** Remove Product gallery and thumbnail conditionally by theme options - Single-product.php */
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		add_action( 'woocommerce_before_single_product_summary', array( __CLASS__, 'woocommerce_show_product_images' ), 19 );

		/** Add Woocommerce Archive Sidebar - Archive-product.php */
		add_action( 'woocommerce_sidebar', array( __CLASS__, 'woocommerce_archive_sidebar' ), 10 );

		/** Mihanpress Breadcrumb for Woocommerce archive - Archive-product.php */
		add_action( 'woocommerce_before_main_content', array( __CLASS__, 'woocommerce_archive_breadcrumb' ), 20 );
	}



	/**
	 * Change number of posts in products archive
	 *
	 * @since 1.0.0
	 */
	public static function shop_per_page() {
		global $mihanpress_options;
		$shop_per_page = ! empty( $mihanpress_options['shop_products_per_page'] ) ? $mihanpress_options['shop_products_per_page'] : 10;
		return $shop_per_page;
	}


	/**
	 * Return Discount Percentage insted of Sale Badge
	 *
	 * @since 1.0.0
	 */
	public static function percentage_to_sale_badge( $html, $post, $product ) {
		if ( $product->is_type( 'variable' ) ) {
			$percentages = array();

			/** Get all variation prices */
			$prices = $product->get_variation_prices();

			/** Loop through variation prices */
			foreach ( $prices['price'] as $key => $price ) {
				/** Only on sale variations */
				if ( $prices['regular_price'][ $key ] !== $price ) {
					/** Calculate and set in the array the percentage for each variation on sale */
					$percentages[] = round( 100 - ( $prices['sale_price'][ $key ] / $prices['regular_price'][ $key ] * 100 ) );
				}
			}
			/** We keep the highest value */
			$percentage = max( $percentages ) . '%';
		} else {
			$regular_price = (float) $product->get_regular_price();
			$sale_price    = (float) $product->get_sale_price();

			$percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';
		}
		return '<span class="onsale">' . $percentage . '</span>';
	}

	/**
	 * Change number of related posts in single-product page
	 *
	 * @since 1.0.0
	 */
	public static function related_products_limit( $args ) {
		$args['posts_per_page'] = 3;
		return $args;
	}


	/**
	 * Ajax refresh mini-cart items
	 *
	 * @since 1.0.0
	 */
	public static function mini_cart_ajax_refresh( $fragments ) {
		/** Refreshing mini cart subtotal amount */
		$fragments['#mcart-stotal'] = '<span id="mcart-stotal">' . WC()->cart->get_cart_subtotal() . '</span>';

		/** Refreshing cart subtotal */
		ob_start();
		echo '<span id="mcart-widget">';
		woocommerce_mini_cart();
		echo '</span>';
		$fragments['#mcart-widget'] = ob_get_clean();

		return $fragments;
	}


	/**
	 * Ajax refresh mini-cart count
	 *
	 * @since 1.0.0
	 */
	public static function iconic_cart_count_fragments( $fragments ) {
		$fragments['span.header-cart-count'] = '<span class="header-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
		return $fragments;
	}

	/**
	 * Return Current user total orders
	 *
	 * @since 1.0.0
	 */
	public static function get_customer_total_order() {
		$customer_orders = get_posts(
			array(
				'numberposts' => -1,
				'meta_key'    => '_customer_user',
				'meta_value'  => get_current_user_id(),
				'post_type'   => array( 'shop_order' ),
				'post_status' => array( 'wc-completed' ),
			)
		);

		$total = 0;
		foreach ( $customer_orders as $customer_order ) {
			$order  = wc_get_order( $customer_order );
			$total += $order->get_total();
		}

		return $total;
	}

	/**
	 * Return true if current user has bought at least one product
	 *
	 * @since 1.0.0
	 */
	public static function has_bought() {
		$customer_orders = get_posts(
			array(
				'numberposts' => -1,
				'meta_key'    => '_customer_user',
				'meta_value'  => get_current_user_id(),
				'post_type'   => 'shop_order',
				'post_status' => 'wc-completed',
			)
		);

		if ( count( $customer_orders ) > 0 ) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Add Custom thumbnail template
	 *
	 *  Content-product.php
	 *
	 * @since 1.0.0
	 */
	public static function template_loop_product_thumbnail() {
		?>
		<figure class="card__thumbnail position-relative">
			<?php
			woocommerce_template_loop_product_thumbnail();
			do_action( 'mihanpress_custom_woocommerce_sale_flush' );
			?>
		</figure>
		<?php
	}


	/**
	 * Add Custom Ttitle template
	 *
	 * Content-product.php
	 *
	 * @since 1.0.0
	 */
	public static function template_loop_product_title() {
		?>
		<a href="<?php the_permalink(); ?>">
			<h1 class="card__title"><?php the_title(); ?></h1>
		</a>
		<?php
	}


	/**
	 * Add Custom rating template
	 *
	 * Content-product.php
	 *
	 * @since 1.0.0
	 */
	public static function template_loop_rating() {
		if ( wc_review_ratings_enabled() ) :
			global $woocommerce, $product;
			$average = $product->get_average_rating();
			?>
			<div class="rating">
				<?php echo '<div class="star-rating"><span style="width:' . ( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . esc_html__( 'out of 5', 'woocommerce' ) . '</span></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<?php
		endif;
	}

	/**
	 * Filter default add to cart button
	 *
	 * Content-product.php
	 *
	 * @since 1.0.0
	 */
	public static function template_loop_add_to_cart( $args ) {
		$args['class'] = 'btn btn-success add_to_cart_button ajax_add_to_cart';
		return $args;
	}


	/**
	 * Add Product Description that removed with Tabs
	 *
	 * Single-prduct.php
	 *
	 * @since 1.0.0
	 */
	public static function template_product_description() {
		wc_get_template( 'single-product/tabs/description.php' );
	}


	/**
	 * Add Product Testimonial (from Custom metabox)
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_testimonial() {
		get_template_part( 'template-parts/woocommerce/single-testimonial' );
	}

	/**
	 * Add Vendor Information (Dokan plugin)
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function single_product_vendor_info() {
		global $mihanpress_options;
		if ( '1' === $mihanpress_options['shop_dokan_vendor_info'] ) {
			get_template_part( 'template-parts/woocommerce/single-vendor-info' );
		}
	}

	/**
	 * Add Product Updates (from Custom metabox)
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function single_product_updates() {
		get_template_part( 'template-parts/woocommerce/single-updates' );
	}

	/**
	 * Prodcut Additional Information table (Woocommerce default)
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function additional_information() {
		global $product;
		if ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) {
			wc_get_template( 'single-product/tabs/additional-information.php' );
		}
	}

	/**
	 * Add Product Meta data (Custom metabox)
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_last_modified_date() {
		get_template_part( 'template-parts/woocommerce/single-meta' );
	}

	/**
	 * Add extra button under add to cart button (Custom metabox)
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function single_product_extra_button() {
		get_template_part( 'template-parts/woocommerce/single-buttons' );
	}


	/**
	 * Add Reply link for normal users
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_review_reply_button() {
		global $mihanpress_options;
		if ( '1' === $mihanpress_options['shop_user_reply'] ) {
			$args = array(
				'reply_text' => esc_html__( 'پاسخ دادن', 'mihanpress' ),
				'depth'      => '1',
				'max_depth'  => '2',
			);
			comment_reply_link( $args );
		}
	}

	/**
	 * Add waiting approval box in reviews
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_awaiting_approval_massage() {
		global $comment;
		if ( '0' === $comment->comment_approved ) {
			?>

			<p class="meta">
				<em class="woocommerce-review__awaiting-approval">
					<?php esc_html_e( 'Your review is awaiting approval', 'woocommerce' ); ?>
				</em>
			</p>

			<?php
		}
	}


	/**
	 * Add Scrollspy section to sidebar of single product
	 *
	 * Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function single_product_sidebar_scrollspy() {
		if ( is_product() ) :
			global $product;
			?>
			<div class="mp-scrollspy-links box box-shadow-lg">
				<ul>
					<li><a href="#mp-description" class="scrollspy-active"><?php esc_html_e( 'معرفی محصول', 'mihanpress' ); ?></a></li>
					<?php
					$product_testimonial = get_post_meta( get_the_ID(), 'mihanpress_product_testimonial_items', true );
					if ( ! empty( $product_testimonial[0]['mihanpress_customer_name'] ) ) :
						?>
						<li><a href="#mp-testimonial" class=""><?php esc_html_e( 'نظرات مشتریان', 'mihanpress' ); ?></a></li>
						<?php
					endif;
					if ( class_exists( 'Dokan_Store_Location' ) ) :
						?>
						<li><a href="#mp-vendor-info" class=""><?php esc_html_e( 'اطلاعات فروشنده', 'mihanpress' ); ?></a></li>
						<?php
					endif;
					if ( ! empty( get_post_meta( get_the_ID(), 'mihanpress_product_updates_content', true ) ) ) :
						?>
						<li><a href="#mp-updates" class=""><?php esc_html_e( 'بروزرسانی ها', 'mihanpress' ); ?></a></li>
						<?php
					endif;
					if ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) :
						?>
						<li><a href="#mp-additional-info" class=""><?php esc_html_e( 'ویژگی های محصول', 'mihanpress' ); ?></a></li>
						<?php
					endif;
					?>
					<li><a href="#mp-reviews" class=""><?php esc_html_e( 'سوالات مشتریان', 'mihanpress' ); ?></a></li>
				</ul>
			</div>
			<?php
		endif;
	}


	/**
	 * Add Scrollspy section to sidebar of single product
	 *
	 *  Single-product.php
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_show_product_images() {
		global $mihanpress_options;

		if ( '1' === $mihanpress_options['shop_single_product_gallery'] ) {
			wc_get_template( 'single-product/product-image.php' );
		}
	}

	/**
	 * Woocommerce Sidebar
	 *
	 * Archive-product.php
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_archive_sidebar() {
		if ( is_active_sidebar( 'sidebar_shop_woocommerce' ) && ! is_product() ) {
			get_sidebar( 'shop' );
		}
	}

	/**
	 * Mihanpress Breadcrumb for Woocommerce archive
	 *
	 * Archive-product.php
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_archive_breadcrumb() {
		if ( is_shop() && function_exists( 'mihanpress_breadcrumbs' ) ) {
			echo '<div class="col-lg-12 archive-product--breadcrumb pr-2 pl-2">';
			mihanpress_breadcrumbs();
			echo '</div>';
		}
	}
}
new MihanPress_WooCommerce_Config();
