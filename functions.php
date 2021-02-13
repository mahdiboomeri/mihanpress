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
		wp_localize_script( 'mihanpress-javascript', 'mihanpressObj', $localize_array );
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
			'addedToCart'     => esc_html__( 'یک محصول به سبد خرید شما اضافه شد .', 'mihanpress' ),
			'copiedShortLink' => esc_html__( 'لینک کوتاه مطلب کپی شد.', 'mihanpress' ),
			'ajaxurl'         => admin_url( 'admin-ajax.php' ),
			'like'            => esc_html__( 'پسندیدن', 'mihanpress' ),
			'unlike'          => esc_html__( 'لغو پسندیدن', 'mihanpress' ),
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
