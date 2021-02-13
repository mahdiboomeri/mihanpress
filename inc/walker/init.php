<?php
/**
 * Custom Fields for WordPress Menu
 *
 * @package MihanPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Mihanpress_Menu_Custom_Fields {

	public function is_wp_version( $version = '5.4' ) {

		global $wp_version;

		/** WordPress version */
		return version_compare( strtolower( $wp_version ), strtolower( $version ), '>=' );
	}

	public function __construct() {
		/** Add custom fields to menu */
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'add_custom_fields_meta' ) );
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'add_custom_fields' ), 10, 4 );

		/** Save menu custom fields */
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_nav_fields' ), 10, 3 );

		/** Output the resault */
		add_action( 'nav_menu_css_class', array( $this, 'nav_menu_output' ), 10, 3 );

		/** Edit menu walker */
		if ( ! $this::is_wp_version( '5.4' ) ) {
			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ), 10, 2 );
		}
	}

	public function add_custom_fields_meta( $menu_item ) {
		$menu_item->nolink       = get_post_meta( $menu_item->ID, '_menu_item_nolink', true );
		$menu_item->megamenu     = get_post_meta( $menu_item->ID, '_menu_item_megamenu', true );
		$menu_item->megamenu_col = get_post_meta( $menu_item->ID, '_menu_item_megamenu_col', true );

		return $menu_item;
	}

	public function add_custom_fields( $id, $item, $depth, $args ) { ?>
		<p class="field-nolink description description-wide">
			<label for="edit-menu-item-nolink-<?php echo esc_attr( $item->ID ); ?>">
				<input type="checkbox" id="edit-menu-item-nolink-<?php echo esc_attr( $item->ID ); ?>" class="code edit-menu-item-nolink" value="nolink" name="menu-item-nolink[<?php echo esc_attr( $item->ID ); ?>]" <?php checked( $item->nolink, 'nolink' ); ?> />
				<?php esc_html_e( 'غیرفعال کردن لینک', 'mihanpress' ); ?>
			</label>
		</p>

		<p class="field-megamenu description description-wide">
			<label for="edit-menu-item-megamenu-<?php echo esc_attr( $item->ID ); ?>">
				<input type="checkbox" id="edit-menu-item-megamenu-<?php echo esc_attr( $item->ID ); ?>" class="code edit-menu-item-megamenu" value="megamenu" name="menu-item-megamenu[<?php echo esc_attr( $item->ID ); ?>]" <?php checked( $item->megamenu, 'megamenu' ); ?> />
				<?php esc_html_e( 'فعال کردن مگامنو', 'mihanpress' ); ?>
			</label>
		</p>
		<p class="field-megamenu-columns description description-wide">
			<label for="edit-menu-item-megamenu_col-<?php echo esc_attr( $item->ID ); ?>">
				<?php esc_html_e( 'تعداد ستون های مگامنو (۱ تا ۶)', 'mihanpress' ); ?><br />
				<input type="number" id="edit-menu-item-megamenu_col-<?php echo esc_attr( $item->ID ); ?>" class="widefat code edit-menu-item-custom" name="menu-item-megamenu_col[<?php echo esc_attr( $item->ID ); ?>]" min="1" max="6" value="<?php echo esc_attr( $item->megamenu_col ); ?>" />
			</label>
		</p>

		<?php
	}

	public function update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

		$check = array( 'nolink', 'megamenu', 'megamenu_col' );

		foreach ( $check as $key ) {
			if ( ! isset( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] ) ) {
				$_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] = '';
			}

			$value = sanitize_text_field( wp_unslash( $_POST[ 'menu-item-' . $key ][ $menu_item_db_id ] ) );
			update_post_meta( $menu_item_db_id, '_menu_item_' . $key, $value );
		}
	}


	public function nav_menu_output( $class_names, $item ) {
		$mega_menu_col = get_post_meta( $item->ID, '_menu_item_megamenu_col', true );
		$class_names[] = ! empty( get_post_meta( $item->ID, '_menu_item_megamenu', true ) ) ? "mihanpress-megamenu mihanpress-megamenu-col-$mega_menu_col" : '';
		$class_names[] = ! empty( get_post_meta( $item->ID, '_menu_item_nolink', true ) ) ? 'no-link' : '';
		return $class_names;
	}

	public function edit_walker() {
		require_once MIHANPRESS_THEME_DIR . '/inc/walker/class-walker-edit-custom.php';
		return 'Walker_Nav_Menu_Edit_Custom';
	}
}

new Mihanpress_Menu_Custom_Fields();
