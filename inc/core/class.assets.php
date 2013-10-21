<?php

/**
 * Class for managing plugin assets
 */
class Shortcodes_Ultimate_Assets {

	/**
	 * Set of queried assets
	 *
	 * @var array
	 */
	static $assets = array( 'css' => array(), 'js' => array() );

	/**
	 * Constructor
	 */
	function __construct() {
		// Register
		add_action( 'wp_head',                     array( __CLASS__, 'register' ) );
		add_action( 'admin_head',                  array( __CLASS__, 'register' ) );
		add_action( 'su/generator/preview/before', array( __CLASS__, 'register' ) );
		// Enqueue
		add_action( 'wp_footer',                   array( __CLASS__, 'enqueue' ) );
		add_action( 'admin_footer',                array( __CLASS__, 'enqueue' ) );
		// Print
		add_action( 'su/generator/preview/after',  array( __CLASS__, 'prnt' ) );
		// Custom CSS
		add_action( 'wp_footer',                   array( __CLASS__, 'custom_css' ), 99 );
		add_action( 'su/generator/preview/after',  array( __CLASS__, 'custom_css' ), 99 );
		// Options page assets
		add_action( 'sunrise_page_before',         array( __CLASS__, 'options_page' ) );
	}

	/**
	 * Register assets
	 */
	public static function register() {
		// Get plugin object
		$shult = shortcodes_ultimate();
		// Font Awesome
		wp_register_style( 'font-awesome', $shult->assets( 'css', 'font-awesome.css' ), false, '3.2.1', 'all' );
		// qTip
		wp_register_style( 'qtip', $shult->assets( 'css', 'qtip.css' ), false, '2.1.1', 'all' );
		wp_register_script( 'qtip', $shult->assets( 'js', 'qtip.js' ), array( 'jquery' ), '2.1.1', true );
		// jsRender
		wp_register_script( 'jsrender', $shult->assets( 'js', 'jsrender.js' ), array( 'jquery' ), '1.0.0-beta', true );
		// Magnific Popup
		wp_register_style( 'magnific-popup', $shult->assets( 'css', 'magnific-popup.css' ), false, '0.9.7', 'all' );
		wp_register_script( 'magnific-popup', $shult->assets( 'js', 'magnific-popup.js' ), array( 'jquery' ), '0.9.7', true );
		// Ace
		wp_register_script( 'ace', $shult->assets( 'js', 'ace/ace.js' ), false, '1.1.01', true );
		// Swiper
		wp_register_script( 'swiper', $shult->assets( 'js', 'swiper.js' ), array( 'jquery' ), $shult->version, true );
		// jPlayer
		wp_register_script( 'jplayer', $shult->assets( 'js', 'jplayer.js' ), array( 'jquery' ), $shult->version, true );
		// Options page
		wp_register_style( 'su-options-page', $shult->assets( 'css', 'options-page.css' ), false, $shult->version, 'all' );
		wp_register_script( 'su-options-page', $shult->assets( 'js', 'options-page.js' ), array( 'magnific-popup', 'jquery-ui-sortable', 'ace', 'jsrender' ), $shult->version, true );
		wp_localize_script( 'su-options-page', 'su_options_page', array(
				'upload_title' => __( 'Choose files', 'su' ),
				'upload_insert' => __( 'Add selected files', 'su' )
			) );
		// Generator
		wp_register_style( 'su-generator', $shult->assets( 'css', 'generator.css' ), array( 'farbtastic', 'magnific-popup' ), $shult->version, 'all' );
		wp_register_script( 'su-generator', $shult->assets( 'js', 'generator.js' ), array( 'farbtastic', 'magnific-popup', 'qtip' ), $shult->version, true );
		wp_localize_script( 'su-generator', 'su_generator', array(
				'upload_title' => __( 'Choose file', 'su' ),
				'upload_insert' => __( 'Insert', 'su' ),
				'loading_icons' => __( 'Please wait', 'su' )
			) );
		// Shortcodes stylesheets
		wp_register_style( 'su-content-shortcodes', self::skin_url( 'content-shortcodes.css' ), false, $shult->version, 'all' );
		wp_register_style( 'su-box-shortcodes', self::skin_url( 'box-shortcodes.css' ), false, $shult->version, 'all' );
		wp_register_style( 'su-media-shortcodes', self::skin_url( 'media-shortcodes.css' ), false, $shult->version, 'all' );
		wp_register_style( 'su-other-shortcodes', self::skin_url( 'other-shortcodes.css' ), false, $shult->version, 'all' );
		wp_register_style( 'su-galleries-shortcodes', self::skin_url( 'galleries-shortcodes.css' ), false, $shult->version, 'all' );
		wp_register_style( 'su-players-shortcodes', self::skin_url( 'players-shortcodes.css' ), false, $shult->version, 'all' );
		// Shortcodes scripts
		wp_register_script( 'su-galleries-shortcodes', $shult->assets( 'js', 'galleries-shortcodes.js' ), array( 'jquery', 'swiper' ), $shult->version, true );
		wp_register_script( 'su-players-shortcodes', $shult->assets( 'js', 'players-shortcodes.js' ), array( 'jquery', 'jplayer' ), $shult->version, true );
		wp_register_script( 'su-other-shortcodes', $shult->assets( 'js', 'other-shortcodes.js' ), array( 'jquery' ), $shult->version, true );
		wp_localize_script( 'su-other-shortcodes', 'su_other_shortcodes', array( 'no_preview' => __( 'This shortcode doesn\'t work in live preview. Please insert it into editor and preview on the site.', 'su' ) ) );
		// Hook to deregister assets or add custom
		do_action( 'su/assets/register' );
	}

	/**
	 * Enqueue assets
	 */
	public static function enqueue() {
		// Get assets query and plugin object
		$assets = self::assets();
		// Enqueue stylesheets
		foreach ( $assets['css'] as $style ) wp_enqueue_style( $style );
		// Enqueue scripts
		foreach ( $assets['js'] as $script ) wp_enqueue_script( $script );
		// Hook to dequeue assets or add custom
		do_action( 'su/assets/enqueue', $assets );
	}

	/**
	 * Print assets without enqueuing
	 */
	public static function prnt() {
		// Prepare assets set
		$assets = self::assets();
		// Enqueue stylesheets
		wp_print_styles( $assets['css'] );
		// Enqueue scripts
		wp_print_scripts( $assets['js'] );
		// Hook
		do_action( 'su/assets/print', $assets );
	}

	/**
	 * Print custom CSS
	 */
	public static function custom_css() {
		$shult = shortcodes_ultimate();
		// Get custom CSS and apply filters to it
		$custom_css = apply_filters( 'su/assets/custom_css', str_replace( '&#039;', '\'', html_entity_decode( (string) $shult->get_option( 'custom_css' ) ) ) );
		// Print CSS if exists
		if ( $custom_css ) echo "\n\n<!-- Shortcodes Ultimate custom CSS - begin -->\n<style type='text/css'>\n" . stripslashes( str_replace( array( '%theme_url%', '%home_url%', '%plugin_url%' ), array( get_stylesheet_directory_uri(), get_option( 'home' ), $shult->url ), $custom_css ) ) . "\n</style>\n<!-- Shortcodes Ultimate custom CSS - end -->\n\n";
	}

	/**
	 * Add asset to the query
	 */
	public static function add( $type, $handle ) {
		// Array with handles
		if ( is_array( $handle ) ) { foreach ( $handle as $h ) self::$assets[$type][$h] = $h; }
		// Single handle
		else self::$assets[$type][$handle] = $handle;
	}
	/**
	 * Get queried assets
	 */
	public static function assets() {
		// Get assets query
		$assets = self::$assets;
		// Apply filters to assets set
		$assets['css'] = array_unique( ( array ) apply_filters( 'su/assets/css', ( array ) array_unique( $assets['css'] ) ) );
		$assets['js'] = array_unique( ( array ) apply_filters( 'su/assets/js', ( array ) array_unique( $assets['js'] ) ) );
		// Return set
		return $assets;
	}

	/**
	 * Add options page assets
	 */
	public static function options_page() {
		$shult = shortcodes_ultimate();
		// Check this is Shortcodes Ultimate settings page
		if ( $_GET['page'] !== $shult->slug ) return;
		// Request assets
		self::add( 'css', array( 'magnific-popup', 'ace', 'su-options-page' ) );
		self::add( 'js', array( 'jquery', 'magnific-popup', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-sortable', 'jsrender', 'su-options-page' ) );
	}

	/**
	 * Helper to get full URL of a skin file
	 */
	public static function skin_url( $file = '' ) {
		$shult = shortcodes_ultimate();
		$skin = $shult->get_option( 'skin' );
		$uploads = wp_upload_dir(); $uploads = $uploads['baseurl'];
		// Prepare url to skin directory
		$url = ( $skin === 'default' ) ? $shult->assets( 'css', '' ) : $uploads . '/shortcodes-ultimate-skins/' . $skin;
		return trailingslashit( apply_filters( 'su/assets/skin', $url ) ) . $file;
	}
}

$shult_assets = new Shortcodes_Ultimate_Assets;

/**
 * Helper function to add asset to the query
 *
 * @param string  $type   Asset type (css|js)
 * @param mixed   $handle Asset handle or array with handles
 */
function su_query_asset( $type, $handle ) {
	Shortcodes_Ultimate_Assets::add( $type, $handle );
}

/**
 * Helper function to get current skin url
 *
 * @param string  $file Asset file name. Example value: box-shortcodes.css
 */
function su_skin_url( $file ) {
	return Shortcodes_Ultimate_Assets::skin_url( $file );
}
