<?php

class Shortcodes_Ultimate {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'plugins_loaded', array( __CLASS__, 'init' ) );
		register_activation_hook( SU_PLUGIN_FILE, array( __CLASS__, 'activation' ) );
		register_activation_hook( SU_PLUGIN_FILE, array( __CLASS__, 'deactivation' ) );
	}

	/**
	 * Plugin init
	 */
	public static function init() {
		// Prepare variable for global plugin helper instance
		global $shult;
		// Create plugin helper instance
		$shult = new Sunrise_Plugin_Framework_2_1( SU_PLUGIN_FILE );
		// Register settings page
		$shult->add_options_page( array( 'link' => false ), self::options() );
		// Translate plugin meta
		__( 'Shortcodes Ultimate', 'su' );
		__( 'Vladimir Anokhin', 'su' );
		__( 'Supercharge your WordPress theme with mega pack of shortcodes', 'su' );
		// Add plugin actions links
		add_filter( 'plugin_action_links_' . $shult->basename, array( __CLASS__, 'actions_links' ), -10 );
		// Add plugin meta links
		add_filter( 'plugin_row_meta', array( __CLASS__, 'meta_links' ), 10, 2 );
		// Import custom CSS from previous version
		add_action( 'admin_init', array( __CLASS__, 'import_custom_css' ) );
		// Shortcodes Ultimate is ready
		do_action( 'su/init' );
	}

	/**
	 * Plugin activation
	 */
	public static function activation() {
		self::timestamp();
		self::create_skins_dir();
		Shortcodes_Ultimate_Generator::reset();
		do_action( 'su/activation' );
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivation() {
		do_action( 'su/deactivation' );
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
	public static function create_skins_dir() {
		$upload_dir = wp_upload_dir();
		$path = trailingslashit( path_join( $upload_dir['basedir'], 'shortcodes-ultimate-skins' ) );
		if ( !file_exists( $path ) ) mkdir( $path, 0755 );
	}

	/**
	 * Import custom CSS from previous version
	 */
	public static function import_custom_css() {
		$shult = shortcodes_ultimate();
		$old = get_option( 'su_custom_css' );
		if ( !$old ) return;
		$current = $shult->get_option( 'custom_css' );
		$shult->update_option( 'custom_css', "/* Custom CSS from v3 - begin */\n" . $old . "\n/* Custom CSS from v3 - end*/\n\n" . $current );
		delete_option( 'su_custom_css' );
	}

	/**
	 * Add plugin actions links
	 */
	public static function actions_links( $links ) {
		$shult = shortcodes_ultimate();
		$links[] = '<a href="' . $shult->admin_url . '#tab-0">' . __( 'Where to start?', 'su' ) . '</a>';
		return $links;
	}

	/**
	 * Add plugin meta links
	 */
	public static function meta_links( $links, $file ) {
		global $shult;
		// Check plugin
		if ( $file === $shult->basename ) {
			unset( $links[2] );
			$links[] = '<a href="http://gndev.info/shortcodes-ultimate/" target="_blank">' . __( 'Project homepage', 'su' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/support/plugin/shortcodes-ultimate/" target="_blank">' . __( 'Support forum', 'su' ) . '</a>';
			$links[] = '<a href="http://wordpress.org/extend/plugins/shortcodes-ultimate/changelog/" target="_blank">' . __( 'Changelog', 'su' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Plugin options
	 */
	public static function options() {
		return apply_filters( 'su/options', array(
				array( 'name' => __( 'About', 'su' ), 'type' => 'opentab' ),
				array( 'type' => 'about' ),
				array( 'type' => 'closetab', 'actions' => false ),
				array( 'name' => __( 'Settings', 'su' ), 'type' => 'opentab' ),
				array(
					'name' => __( 'Custom formatting', 'su' ),
					'desc' => __( 'Disable this option if you have some problems with other plugins or content formatting', 'su' ) . '<br /><a href="http://gndev.info/kb/custom-formatting/" target="_blank">' . __( 'Documentation article', 'su' ) . '</a>',
					'std' => 'on',
					'id' => 'custom_formatting',
					'type' => 'checkbox',
					'label' => __( 'Enabled', 'su' )
				),
				array(
					'name' => __( 'Compatibility mode', 'su' ),
					'desc' => __( 'Enable this option if you have some problems with other plugins that uses similar shortcode names', 'su' ) . '<br /><code>[button] => [su_button]</code> ' . __( 'etc.', 'su' ) . '<br /><a href="http://gndev.info/kb/compatibility-mode/" target="_blank">' . __( 'Documentation article', 'su' ) . '</a>',
					'std' => '',
					'id' => 'compatibility_mode',
					'type' => 'checkbox',
					'label' => __( 'Enabled', 'su' )
				),
				array(
					'name' => __( 'Skip default values', 'su' ),
					'desc' => __( 'Enable this option and the generator will insert a shortcode without default attribute values that you have not changed. As a result, the generated code will be shorter.', 'su' ),
					'std' => 'on',
					'id' => 'skip',
					'type' => 'checkbox',
					'label' => __( 'Enabled', 'su' )
				),
				array(
					'name' => __( 'Skin', 'su' ),
					'desc' => sprintf( __( 'Choose skin for shortcodes.<br /><a href="%s" target="_blank">Learn how to create custom skin</a><br /><a href="%s" target="_blank"><b>Download more skins</b></a>', 'su' ), 'http://gndev.info/kb/how-to-create-custom-skin-for-shortcodes-ultimate/', 'http://gndev.info/shortcodes-ultimate/' ),
					'std' => 'default',
					'id' => 'skin',
					'type' => 'text'
				),
				array( 'type' => 'closetab' ),
				array( 'name' => __( 'Custom CSS', 'su' ), 'type' => 'opentab' ),
				array( 'id' => 'custom_css', 'type' => 'css' ),
				array( 'type' => 'closetab' ),
				array( 'name' => __( 'Galleries', 'su' ), 'type' => 'opentab' ),
				array( 'id' => 'galleries', 'type' => 'galleries' ),
				array( 'type' => 'closetab' ),
				array( 'name' => __( 'Cheatsheet', 'su' ), 'type' => 'opentab' ),
				array( 'type' => 'cheatsheet' ),
				array( 'type' => 'closetab', 'actions' => false ) ) );
	}
}

// Define global plugin helper instance
$shult = null;

/**
 * Register main plugin function to perform checks that plugin is installed
 *
 * Useful for integration with themes and other plugins
 *
 * @global Sunrise_Plugin_Framework_2 $shult
 * @return \Sunrise_Plugin_Framework_2
 */
function shortcodes_ultimate() {
	global $shult;
	return $shult;
}

new Shortcodes_Ultimate;
