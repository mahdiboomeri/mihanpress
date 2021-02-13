<?php
/**
 * Recommends plugins for use with the theme via the TGMPA Script
 *
 * @package MihanPress
 * @since 1.0.0
 */

add_action( 'tgmpa_register', 'mihanpress_register_required_plugins' );

function mihanpress_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'Mihanpress Addons',
			'slug'     => 'mihanpress-addons',
			'required' => true,
			'source'   => get_template_directory() . '/inc/plugins/mihanpress-addons.zip', // The plugin source.
			'version'  => wp_get_theme()->get( 'Version' ),
		),
		array(
			'name'     => 'Mihanpress Elementor Addons',
			'slug'     => 'mihanpress-elementor-addons',
			'required' => false,
			'source'   => get_template_directory() . '/inc/plugins/mihanpress-elementor-addons.zip', // The plugin source.
			'version'  => wp_get_theme()->get( 'Version' ),
		),
		array(
			'name'     => 'ThunderWP Rename Login',
			'slug'     => 'thunderwp-rename-login',
			'required' => false,
			'source'   => get_template_directory() . '/inc/plugins/thunderwp-rename-login.zip', // The plugin source.
			'version'  => wp_get_theme()->get( 'Version' ),
		),
		array(
			'name'     => 'Elementor',
			'slug'     => 'elementor',
			'required' => false,
		),
		array(
			'name'     => 'Woocommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => 'Easy Table of Contents',
			'slug'     => 'easy-table-of-contents',
			'required' => false,
		),

	);

	$config = array(
		'id'           => 'mihanpress',            // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		'strings'      => array(
			'page_title'                      => esc_html__( 'نصب افزونه های ضروری', 'mihanpress' ),
			'menu_title'                      => esc_html__( 'نصب افزونه ها', 'mihanpress' ),
			'installing'                      => esc_html__( 'درحال نصب افزونه: %s', 'mihanpress' ),
			'updating'                        => esc_html__( 'درحال آپدیت افزونه: %s', 'mihanpress' ),
			'oops'                            => esc_html__( 'در فرایند نصب افزونه مشکلی پیش آمده است.', 'mihanpress' ),
			'notice_can_install_required'     => _n_noop(
				'قالب میهن پرس برای اجرای صحیح به این افزونه نیاز دارد: %1$s.',
				'قالب میهن پرس برای اجرای صحیح به این افزونه ها نیاز دارد: %1$s.',
				'mihanpress'
			),
			'notice_can_install_recommended'  => _n_noop(
				'قالب میهن پرس استفاده از این افزونه را پیشنهاد می کند: %1$s.',
				'قالب میهن پرس استفاده از این افزونه ها را پیشنهاد می کند: %1$s.',
				'mihanpress'
			),
			'notice_ask_to_update'            => _n_noop(
				'این افزونه برای کارکرد بهتر با قالب نیاز به بروزرسانی به آخرین نسخه دارد: %1$s.',
				'این افزونه ها برای کارکرد بهتر با قالب نیاز به بروزرسانی به آخرین نسخه دارند: %1$s.',
				'mihanpress'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'یک بروز رسانی برای این افزونه در دسترس است: %1$s.',
				'بروز رسانی هایی برای افزونه های روبه رو در دسترس است: %1$s.',
				'mihanpress'
			),
			'notice_can_activate_required'    => _n_noop(
				'افزونه مقابل نیاز به فعالسازی دارد: %1$s.',
				'افزونه های مقابل نیاز به فعالسازی دارند: %1$s.',
				'mihanpress'
			),
			'notice_can_activate_recommended' => _n_noop(
				'افزونه پیشنهادی مقابل نیاز به فعالسازی دارد: %1$s.',
				'افزونه های پیشنهادی مقابل نیاز به فعالسازی دارند: %1$s.',
				'mihanpress'
			),
			'install_link'                    => _n_noop(
				'شروع نصب افزونه',
				'شروع نصب افزونه ها',
				'mihanpress'
			),
			'update_link'                     => _n_noop(
				'شروع بروزرسانی افزونه',
				'شروع بروزرسانی افزونه ها',
				'mihanpress'
			),
			'activate_link'                   => _n_noop(
				'شروع فعالسازی افزونه',
				'شروع فعالسازی افزونه ها',
				'mihanpress'
			),
			'plugin_activated'                => esc_html__( 'افزونه با موفقیت فعال شد.', 'mihanpress' ),
			'activated_successfully'          => esc_html__( 'افزونه مقابل با موفقیت فعال شد:', 'mihanpress' ),
			'complete'                        => esc_html__( 'همه افزونه ها با موفقیت فعال شدند. %1$s', 'mihanpress' ),
			'dismiss'                         => esc_html__( 'پنهان کردن این اطلاعیه', 'mihanpress' ),
		),

	);

	tgmpa( $plugins, $config );
}
