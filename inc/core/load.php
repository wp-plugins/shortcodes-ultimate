<?php
class Shortcodes_Ultimate {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'plugins_loaded',             array( __CLASS__, 'init' ) );
		add_action( 'init',                       array( __CLASS__, 'register' ) );
		add_action( 'init',                       array( __CLASS__, 'update' ), 20 );
		register_activation_hook( SU_PLUGIN_FILE, array( __CLASS__, 'activation' ) );
		register_activation_hook( SU_PLUGIN_FILE, array( __CLASS__, 'deactivation' ) );
	}

	/**
	 * Plugin init
	 */
	public static function init() {
		// Make plugin available for translation
		load_plugin_textdomain( 'su', false, dirname( plugin_basename( SU_PLUGIN_FILE ) ) . '/languages/' );
		// Setup admin class
		$admin = new Sunrise4( array(
				'file'       => SU_PLUGIN_FILE,
				'slug'       => 'su',
				'prefix'     => 'su_option_',
				'textdomain' => 'su'
			) );
		// Top-level menu
		$admin->add_menu( array(
				'page_title'  => __( 'Settings', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => __( 'Shortcodes', 'su' ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-ultimate',
				'icon_url'    => plugins_url( 'assets/images/icon.png', SU_PLUGIN_FILE ),
				'position'    => '80.11',
				'options'     => array(
					array(
						'type' => 'opentab',
						'name' => __( 'About', 'su' )
					),
					array(
						'type'     => 'about',
						'callback' => array( 'Su_Admin_Views', 'about' )
					),
					array(
						'type'    => 'closetab',
						'actions' => false
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Settings', 'su' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'custom-formatting',
						'name'    => __( 'Custom formatting', 'su' ),
						'desc'    => __( 'Disable this option if you have some problems with other plugins or content formatting', 'su' ) . '<br /><a href="http://gndev.info/kb/custom-formatting/" target="_blank">' . __( 'Documentation article', 'su' ) . '</a>',
						'default' => 'on',
						'label'   => __( 'Enabled', 'su' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'compatibility-mode',
						'name'    => __( 'Compatibility mode', 'su' ),
						'desc'    => __( 'Enable this option if you have some problems with other plugins that uses similar shortcode names', 'su' ) . '<br /><code>[button] => [su_button]</code> ' . __( 'etc.', 'su' ) . '<br /><a href="http://gndev.info/kb/compatibility-mode/" target="_blank">' . __( 'Documentation article', 'su' ) . '</a>',
						'default' => '',
						'label'   => __( 'Enabled', 'su' )
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'skip',
						'name'    => __( 'Skip default values', 'su' ),
						'desc'    => __( 'Enable this option and the generator will insert a shortcode without default attribute values that you have not changed. As a result, the generated code will be shorter.', 'su' ),
						'default' => 'on',
						'label'   => __( 'Enabled', 'su' )
					),
					array(
						'type'    => 'text',
						'id'      => 'skin',
						'name'    => __( 'Skin', 'su' ),
						'desc'    => sprintf( __( 'Choose skin for shortcodes.<br /><a href="%s" target="_blank">Learn how to create custom skin</a><br /><a href="%s" target="_blank"><b>Download more skins</b></a>', 'su' ), 'http://gndev.info/kb/how-to-create-custom-skin-for-shortcodes-ultimate/', 'http://gndev.info/shortcodes-ultimate/' ),
						'default' => 'default'
					),
					array(
						'type' => 'closetab'
					),
					array(
						'type' => 'opentab',
						'name' => __( 'Custom CSS', 'su' )
					),
					array(
						'type'     => 'custom_css',
						'id'       => 'custom-css',
						'default'  => '',
						'callback' => array( 'Su_Admin_Views', 'custom_css' )
					),
					array(
						'type' => 'closetab'
					)
				)
			) );
		// Settings submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes-ultimate',
				'page_title'  => __( 'Settings', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => __( 'Settings', 'su' ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-ultimate',
				'options'     => array()
			) );
		// Examples submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes-ultimate',
				'page_title'  => __( 'Examples', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => __( 'Examples', 'su' ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-ultimate-examples',
				'options'     => array(
					array(
						'type' => 'examples',
						'callback' => array( 'Su_Admin_Views', 'examples' )
					)
				)
			) );
		// Add-ons submenu
		$admin->add_submenu( array(
				'parent_slug' => 'shortcodes-ultimate',
				'page_title'  => __( 'Add-ons', 'su' ) . ' &lsaquo; ' . __( 'Shortcodes Ultimate', 'su' ),
				'menu_title'  => __( 'Add-ons', 'su' ),
				'capability'  => 'edit_others_posts',
				'slug'        => 'shortcodes-ultimate-addons',
				'options'     => array(
					array(
						'type' => 'addons',
						'callback' => array( 'Su_Admin_Views', 'addons' )
					)
				)
			) );
		// Translate plugin meta
		__( 'Shortcodes Ultimate', 'su' );
		__( 'Vladimir Anokhin', 'su' );
		__( 'Supercharge your WordPress theme with mega pack of shortcodes', 'su' );
		// Prevent insertion of default options
		if ( get_option( 'su_option_skin' ) ) update_option( 'sunrise_defaults_su', true );
		// Add plugin actions links
		add_filter( 'plugin_action_links_' . plugin_basename( SU_PLUGIN_FILE ), array( __CLASS__, 'actions_links' ), -10 );
		// Add plugin meta links
		add_filter( 'plugin_row_meta', array( __CLASS__, 'meta_links' ), 10, 2 );
		// Import custom CSS from version 3.9.5 and below
		add_action( 'admin_init', array( __CLASS__, 'import_395' ) );
		// Import settings from versions 4.3.2 and below
		add_action( 'admin_init', array( __CLASS__, 'import_432' ) );
		// Shortcodes Ultimate is ready
		do_action( 'su/init' );
	}

	/**
	 * Plugin activation
	 */
	public static function activation() {
		self::timestamp();
		self::skins_dir();
		update_option( 'su_option_version', SU_PLUGIN_VERSION );
		do_action( 'su/activation' );
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivation() {
		do_action( 'su/deactivation' );
	}

	/**
	 * Plugin update hook
	 */
	public static function update() {
		$option = get_option( 'su_option_version' );
		if ( $option !== SU_PLUGIN_VERSION ) {
			update_option( 'su_option_version', SU_PLUGIN_VERSION );
			do_action( 'su/update' );
		}
	}

	/**
	 * Register shortcodes
	 */
	public static function register() {
		// Prepare compatibility mode prefix
		$prefix = su_cmpt();
		// Loop through shortcodes
		foreach ( ( array ) Su_Data::shortcodes() as $id => $data ) {
			if ( isset( $data['function'] ) && is_callable( $data['function'] ) ) $func = $data['function'];
			elseif ( is_callable( array( 'Su_Shortcodes', $id ) ) ) $func = array( 'Su_Shortcodes', $id );
			elseif ( is_callable( array( 'Su_Shortcodes', 'su_' . $id ) ) ) $func = array( 'Su_Shortcodes', 'su_' . $id );
			else continue;
			// Register shortcode
			add_shortcode( $prefix . $id, $func );
		}
		// Register [media] manually // 3.x
		add_shortcode( $prefix . 'media', array( 'Su_Shortcodes', 'media' ) );
	}

	/**
	 * Add timestamp
	 */
	public static function timestamp() {
		if ( !get_option( 'su_installed' ) ) update_option( 'su_installed', time() );
	}

	/**
	 * Create directory /wp-content/uploads/shortcodes-ultimate-skins/ on activation
	 */
	public static function skins_dir() {
		$upload_dir = wp_upload_dir();
		$path = trailingslashit( path_join( $upload_dir['basedir'], 'shortcodes-ultimate-skins' ) );
		if ( !file_exists( $path ) ) mkdir( $path, 0755 );
	}

	/**
	 * Add plugin actions links
	 */
	public static function actions_links( $links ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=shortcodes-ultimate' ) . '#tab-0">' . __( 'Where to start?', 'su' ) . '</a>';
		return $links;
	}

	/**
	 * Add plugin meta links
	 */
	public static function meta_links( $links, $file ) {
		// Check plugin
		if ( $file === plugin_basename( SU_PLUGIN_FILE ) ) {
			unset( $links[2] );
			$links[] = '<a href="http://gndev.info/shortcodes-ultimate/" target="_blank">' . __( 'Project homepage', 'su' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/support/plugin/shortcodes-ultimate/" target="_blank">' . __( 'Support forum', 'su' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/extend/plugins/shortcodes-ultimate/changelog/" target="_blank">' . __( 'Changelog', 'su' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Import custom CSS from versions 3.9.5 and below
	 */
	public static function import_395() {
		$from_395 = get_option( 'su_custom_css' );
		if ( !$from_395 ) return;
		$current = get_option( 'su_option_custom-css' );
		update_option( 'su_option_custom-css', $from_395 . "\n\n" . $current );
		delete_option( 'su_custom_css' );
	}

	/**
	 * Import settings from versions 4.3.2 and below
	 */
	public static function import_432() {
		$from_432 = get_option( 'shortcodesultimate_options' );
		if ( !$from_432 ) return;
		// Custom formatting
		if ( isset( $from_432['custom_formatting'] ) ) update_option( 'su_option_custom-formatting', 'on' );
		else update_option( 'su_option_custom-formatting', '' );
		// Compatibility mode
		if ( isset( $from_432['compatibility_mode'] ) ) update_option( 'su_option_compatibility-mode', 'on' );
		else update_option( 'su_option_compatibility-mode', '' );
		// Skin
		if ( isset( $from_432['skin'] ) ) update_option( 'su_option_skin', $from_432['skin'] );
		// Skip
		if ( isset( $from_432['skip'] ) ) update_option( 'su_option_skip', 'on' );
		else update_option( 'su_option_skip', '' );
		// Custom CSS
		if ( isset( $from_432['custom_css'] ) ) update_option( 'su_option_custom-css', $from_432['custom_css'] );
		// Galleries
		if ( isset( $from_432['galleries'] ) ) update_option( 'su_option_galleries-432', $from_432['galleries'] );
		delete_option( 'shortcodesultimate_options' );
	}
}

/**
 * Register plugin function to perform checks that plugin is installed
 */
function shortcodes_ultimate() {
	return true;
}

new Shortcodes_Ultimate;
