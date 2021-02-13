<?php
/**
 * MihanPress dynamic CSS
 *
 * @package MihanPress
 * @since 1.0.0
 */

require_once MIHANPRESS_THEME_DIR . '/inc/class-php-css.php';

/**
 * Function for generate dynamic CSS
 *
 * @since 1.0.0
 */
function mihanpress_dynamic_css() {
	global $mihanpress_options;
	if ( ! isset( $mihanpress_options ) ) {
		return;
	}

	/** Instantiate the library */
	$css = new MihanPress\PHP_CSS();

	/**
	 * 404 page dynamic style
	 */
	if ( is_404() ) {
		$css->set_selector( '.body-404' );
		$css->add_property( 'background', 'linear-gradient(to top, ' . $mihanpress_options['404_background']['from'] . ', ' . $mihanpress_options['404_background']['to'] . ')' );

		$css->set_selector( '.eror_container .eror-message button' );
		$css->add_properties(
			array(
				'background' => $mihanpress_options['404_button_color'],
				'color'      => $mihanpress_options['404_button_color_text'],
				'box-shadow' => '0 5px 20px ' . $mihanpress_options['404_button_color_shadow'],
			)
		);
	}

	/**
	 * Footer dynamic style
	 */
	$css->set_selector( '#footer' );
	$css->add_properties(
		array(
			'background-color' => $mihanpress_options['footer_color_main_bg'],
			'color'            => $mihanpress_options['footer_color_main_text'],
			'border-top'       => '4px solid ' . $mihanpress_options['footer_border_color'],
		)
	);

	$css->set_selector( '#footer h2' );
	$css->add_properties(
		array(
			'font-size' => $mihanpress_options['footer_widget_title_size'] . 'px',
			'color'     => $mihanpress_options['footer_color_main_heading_text'],
		)
	);

	$css->set_selector( '#footer .copyright' );
	$css->add_property( 'background', $mihanpress_options['footer_color_copyright_bg'] . '!important' );

	$css->set_selector( '.footer-notice' );
	$css->add_properties(
		array(
			'background' => $mihanpress_options['footer_color_topbar_bg'],
			'color'      => $mihanpress_options['footer_color_topbar_text'] . '!important',
		)
	);
	$css->set_selector( '.footer-badge span' );
	$css->add_property( 'color', $mihanpress_options['footer_color_topbar_text'] . '!important' );

	/**
	 * Custom btn colors
	 */
	if ( '1' === $mihanpress_options['btn_primary_color_switcher'] ) {
		$css->set_selector( '.btn-primary , .button , button , input[type=submit] , input[type=button] , .elementor-button-mp-primary .elementor-button-wrapper a' );
		$css->add_properties(
			array(
				'background' => 'linear-gradient(to right, ' . $mihanpress_options['btn_primary_color']['from'] . ', ' . $mihanpress_options['btn_primary_color']['to'] . ') !important',
				'color'      => $mihanpress_options['btn_primary_color_text'] . '!important',
				'box-shadow' => '0 5px 20px ' . $mihanpress_options['btn_primary_color_shadow'] . '!important',
			)
		);
	}
	if ( '1' === $mihanpress_options['btn_light_color_switcher'] ) {
		$css->set_selector( '.btn-light , .elementor-button-mp-light .elementor-button-wrapper a' );
		$css->add_properties(
			array(
				'background' => $mihanpress_options['btn_light_color'] . '!important',
				'color'      => $mihanpress_options['btn_light_color_text'] . '!important',
			)
		);
	}

	/**
	 * Custom Sub Menu colors
	 */
	if ( '1' === $mihanpress_options['sub_menu_color_switcher'] ) {
		$css->set_selector( '.navbar .sub-menu' );
		$css->add_properties(
			array(
				'background' => 'linear-gradient(45deg, ' . $mihanpress_options['sub_menu_color']['from'] . ', ' . $mihanpress_options['sub_menu_color']['to'] . ')',
				'box-shadow' => '0 10px 40px ' . $mihanpress_options['sub_menu_color_shadow'],
			)
		);
		$css->set_selector( '.navbar > ul > li .sub-menu li a' );
		$css->add_property( 'color', $mihanpress_options['sub_menu_color_text'] );

		$css->add_selector_state( ':hover' );
		$css->add_property( 'color', $mihanpress_options['sub_menu_color_text_hover'] );
		$css->reset_selector_states();

		$css->set_selector( '.navbar > ul > li > .sub-menu::before' );
		$css->add_property( 'background', 'linear-gradient(135deg, ' . $mihanpress_options['sub_menu_color']['to'] . ' 50%, transparent)' );
	}
	if ( '1' === $mihanpress_options['collapsible_color_switcher'] ) {
		$css->set_selector( '.right-sidenav .collapsible-body' );
		$css->add_property( 'background', $mihanpress_options['collapsible_color'] );

		$css->set_selector( '.right-sidenav .collapsible-body a' );
		$css->add_property( 'color', $mihanpress_options['collapsible_color_text'] . '!important' );
	}
	if ( '1' === $mihanpress_options['mega_menu_color_switcher'] ) {
		$css->set_selector( '.navbar > ul > li.mihanpress-megamenu > .sub-menu' );
		$css->add_properties(
			array(
				'background' => 'linear-gradient(45deg, ' . $mihanpress_options['mega_menu_color']['from'] . ', ' . $mihanpress_options['mega_menu_color']['to'] . ') !important',
				'box-shadow' => '0 5px 40px ' . $mihanpress_options['mega_menu_color_shadow'],
			)
		);
		$css->set_selector( '.navbar > ul > li.mihanpress-megamenu > .sub-menu a' );
		$css->add_property( 'color', $mihanpress_options['mega_menu_color_text'] . '!important' );

		$css->add_selector_state( ':hover' );
		$css->add_property( 'color', $mihanpress_options['mega_menu_color_text_hover'] . '!important' );
		$css->reset_selector_states();
	}

	/**
	 * General Colors
	 */
	$color_primary    = $mihanpress_options['general_color']['from'];
	$color_secondary  = $mihanpress_options['general_color']['to'];
	$text_dark_color  = $mihanpress_options['general_color_text_dark'];
	$text_light_color = $mihanpress_options['general_color_text_light'];
	$general_gradient = 'linear-gradient(to right, ' . $color_primary . ', ' . $color_secondary . ')';
	$general_shadow   = '0 5px 15px ' . $mihanpress_options['general_color_shadow'];

	if ( ! empty( $mihanpress_options['body_background'] ) ) {
		$css->set_selector( 'body' );
		$css->add_property( 'background-color', $mihanpress_options['body_background'] . '!important' );
	}

	/** Boxes border-radius */
	$boxes_radius  = array(
		'.box',
		'.card',
		'.card .card__thumbnail',
		'.widget_container li',
		'.comment .comment-container',
		'.review .comment-container',
		'.single-product .related',
		'.comment-form',
	);
	$border_radius = ! empty( $mihanpress_options['box_radius'] ) ? $mihanpress_options['box_radius'] : '20';
	$css->set_selector( implode( ',', $boxes_radius ) );
	$css->add_property( 'border-radius', $border_radius . 'px !important' );

	if ( '1' === $mihanpress_options['general_color_switcher'] ) {
		$text_dark = array(
			'body',
			'html',
			'.mp-scrollspy-links a',
			'.mihanpress-dashboard-sidebar ul li a',
			'.widget a',
			'.mini_cart_product_name a',
			'.mp-breadcrumbs ul li a',
			'.paginate-links .page-numbers',
			'.paginate-links .post-page-numbers',
			'.dokan-pagination li a',
			'.about-author__title',
			'.comment .comment__author a',
			'.card__content a',
			'td.product-name a',
			'.post-meta-child',
			'.post-meta-child a',
			'.comment .comment-content a',
			'.review .comment-content a',
			'.woocommerce-pagination .page-numbers li .page-numbers',
			'.contact-section a',
			'.shopping-cart__trigger .searchicon .modal-trigger span',
			'.navbar > ul > li.mihanpress-megamenu > .sub-menu li a',
			'.navbar > ul > li > a',
			'.right-sidenav nav>ul>li>a',
			'.footer-nav a',
			'.footer-nav a:hover',
			'.dokan-table a',
		);
		$css->set_selector( implode( ',', $text_dark ) );
		$css->add_property( 'color', $text_dark_color );

		$css->set_selector( '.bg-colorful , .widget_product_search form button , .widget_search form input[type=submit]' );
		$css->add_properties(
			array(
				'background' => $general_gradient . '!important',
				'box-shadow' => $general_shadow . '!important',
				'color'      => $text_light_color . '!important',
			)
		);

		$css->set_selector( '.text-colorful , .widget .comment-author-link' );
		$css->add_property( 'color', $color_secondary );

		/** Links color */
		$css->set_selector( 'a' );
		$css->add_property( 'color', $color_secondary );

		$css->add_selector_state( ':hover' );
		$css->add_property( 'color', $color_secondary );
		$css->reset_selector_states();

		/** Other components */
		$css->set_selector( '.author-meta .author-meta--link-badge a' );
		$css->add_properties(
			array(
				'background' => $color_secondary . '!important',
				'color'      => $text_light_color . '!important',
				'box-shadow' => $general_shadow . '!important',
			)
		);

		$css->set_selector( '.mp-scrollspy-links a.active' );
		$css->add_property( 'border-color', $color_secondary );

		$css->set_selector( '.text-primary' );
		$css->add_property( 'color', $color_secondary );
	}

	return $css->css_output() . MihanPress_Theme::load_site_font() . $mihanpress_options['site_custom_css'];
}

/**
 * Function for generate dynamic CSS on login page
 *
 * @since 1.0.0
 */
function mihanpress_login_css() {
	global $mihanpress_options;
	if ( ! isset( $mihanpress_options ) ) {
		return;
	}

	/** Instantiate the library */
	$css = new MihanPress\PHP_CSS();

	/** Body font & Background */
	$css->set_selector( 'body.login' );
	$css->add_properties(
		array(
			'font-family'           => '"mihanpress-font" !important',
			'background-image'      => $mihanpress_options['login_bg']['url'],
			'background-size'       => 'cover',
			'background-attachment' => 'fixed',
			'background-repeat'     => 'no-repeat',
		)
	);
	$css->add_selector_state( ':before' );
	$css->add_properties(
		array(
			'content'    => '""',
			'top'        => '0',
			'position'   => 'fixed',
			'width'      => '100%',
			'height'     => '100%',
			'background' => 'linear-gradient(to right, rgba(0, 168, 255, 0.5), rgba(185, 0, 255, 0.5))',
			'bottom'     => '0',
			'right'      => '0',
			'left'       => '0',
			'z-index'    => '-1',
			'opacity'    => '0.9',
		)
	);
	$css->reset_selector_states();

	/** Logo */
	if ( ! empty( $mihanpress_options['login_logo']['url'] ) ) {
		$css->set_selector( 'body.login #login h1 a' );
		$css->add_properties(
			array(
				'background-image'  => $mihanpress_options['login_logo']['url'],
				'background-repeat' => 'no-repeat',
				'background-size'   => '100% 100%',
				'width'             => $mihanpress_options['login_logo_width'] . 'px',
				'height'            => $mihanpress_options['login_logo_height'] . 'px',
				'background-size'   => 'contain',
			)
		);
	}

	/** Container Box */
	$css->set_selector( 'body.login #login' );
	$css->add_properties(
		array(
			'width'         => '30% !important',
			'background'    => '#ffffff',
			'padding'       => '30px',
			'border-radius' => '10px',
			'margin'        => '30px auto',
		)
	);

	$css->start_media_query( '(max-width: 900px)' );
	$css->set_selector( 'body.login #login' )->add_property( 'width', '80% !important' );
	$css->stop_media_query();

	/** Remember Me Toggle */
	$css->set_selector( '#rememberme' );
	$css->add_properties(
		array(
			'-moz-appearance' => 'none',
			'cursor'          => 'pointer',
			'width'           => '60px',
			'height'          => '30px',
			'background'      => '#E0E0E0',
			'display'         => 'inline-block',
			'border-radius'   => '100px',
			'border'          => 'none',
			'position'        => 'relative',
		)
	);

	$css->add_selector_state( ':focus' );
	$css->add_property( 'box-shadow', 'none' );

	$css->add_selector_state( ':before' );
	$css->add_property( 'display', 'none' );

	$css->add_selector_state( ':after' );
	$css->add_properties(
		array(
			'content'       => '""',
			'position'      => 'absolute',
			'top'           => '5px',
			'left'          => '5px',
			'width'         => '20px',
			'height'        => '20px',
			'background'    => '#fff',
			'border-radius' => '90px',
			'transition'    => '0.3s',
		)
	);

	$css->add_selector_state( ':checked' );
	$css->add_property( 'background', '#2ABA5F' );

	$css->add_selector_state( ':checked:after' );
	$css->add_properties(
		array(
			'left'      => 'calc(100% - 5px)',
			'transform' => 'translateX(-100%)',
		)
	);

	$css->add_selector_state( ':active:after' );
	$css->add_property( 'width', '40px' );
	$css->reset_selector_states();

	/** Messages */
	$css->set_selector(
		'body.login .message,
		body.login #login_error'
	);
	$css->add_properties(
		array(
			'background'    => '#396afc',
			'color'         => '#fff',
			'border-radius' => '5px',
			'border'        => 'none',
			'box-shadow'    => 'none',
		)
	);

	$css->set_selector(
		'body.login .message a,
		body.login .message,
		body.login #login_error a'
	);
	$css->add_properties(
		array(
			'color'           => '#fff',
			'box-shadow'      => 'none',
			'text-decoration' => 'none',
			'border-bottom'   => '1px solid #fff',
		)
	);

	$css->set_selector( 'body.login .message' );
	$css->add_property( 'background', '#396afc' );

	$css->set_selector( 'body.login #login_error' );
	$css->add_property( 'background', '#f00000' );

	/** Buttons */
	$css->set_selector( 'body.login #login form p.submit' );
	$css->add_properties(
		array(
			'display' => 'block',
			'margin'  => 'auto',
			'width'   => '180px',
		)
	);

	$css->set_selector( 'body.login #login form p.submit input#wp-submit' );
	$css->add_properties(
		array(
			'width'         => '100%',
			'margin-top'    => '25px',
			'border-radius' => '50px',
			'padding'       => '7px',
			'font-size'     => '15px',
			'background'    => 'linear-gradient(to right, #396afc, #2948ff)',
			'color'         => '#fff',
			'box-shadow'    => '0 5px 20px #5382ee',
			'border'        => 'none !important',
		)
	);

	$css->set_selector( 'body.login #login form .user-pass-wrap .wp-pwd button' );
	$css->add_property( 'margin-top', '18px' );

	/** Form Fields */
	$css->set_selector( 'body.login #login form' );
	$css->add_properties(
		array(
			'background' => 'none',
			'border'     => 'none',
			'box-shadow' => 'none',
		)
	);

	$css->set_selector(
		'body.login #login form input#user_login,
        body.login #login form input#user_pass,
		body.login #login form input#user_email,
		body.login #login form input#pass1'
	);
	$css->add_properties(
		array(
			'box-shadow'    => 'none',
			'border'        => 'none',
			'padding'       => '15px 25px',
			'margin-top'    => '10px',
			'box-shadow'    => '0 5px 20px 4px rgba(0, 0, 0, .1)',
			'border-radius' => '50px',
			'font-size'     => '17px',
			'direction'     => 'ltr',
		)
	);

	$css->set_selector( 'body.login .wp-pwd .wp-hide-pw' );
	$css->add_property( 'right', '15px !important' );

	$css->set_selector( '#forgetmenot' );
	$css->add_properties(
		array(
			'display' => 'block',
			'width'   => '100%',
		)
	);

	return MihanPress_Theme::load_site_font() . $css->css_output();
}
