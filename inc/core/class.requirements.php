<?php
class Shortcodes_Ultimate_Requirements {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'shutdown',      array( __CLASS__, 'wp_footer_check' ), -99 );
		add_action( 'admin_notices', array( __CLASS__, 'wp_footer_notice' ) );
		add_action( 'su/activation', array( __CLASS__, 'php_wp' ) );
	}

	public static function wp_footer_check() {
		if ( is_admin() || strpos( $_SERVER['REQUEST_URI'], 'wp-admin' ) !== false ) return;
		delete_option( 'su_no_wp_footer' );
		if ( !did_action( 'wp_footer' ) && !did_action( 'admin_init' ) && !defined( 'DOING_AJAX' ) ) update_option( 'su_no_wp_footer', true );
	}

	public static function wp_footer_notice() {
		//if ( get_option( 'su_no_wp_footer' ) ) echo '<div class="error"><p>' . __( '<b>Shortcodes Ultimate:</b> Your current theme does not use wp_footer tag. Shortcodes will not work properly. Please add the wp_footer in the footer of your theme.', 'su' ) . ' <a href="http://codex.wordpress.org/Function_Reference/wp_footer" target="_blank">' . __( 'Learn more', 'su' ) . '</a>.' . '</p></div>';
	}

	/**
	 * Check PHP and WordPress versions
	 */
	public static function php_wp() {
		// Prepare versions
		$min_wp = '3.5';
		$min_php = '5.1';
		$wp = get_bloginfo( 'version' );
		$php = phpversion();
		// Load textdomain
		load_plugin_textdomain( 'shortcodes-ultimate', false, dirname( plugin_basename( SU_PLUGIN_FILE ) ), '/languages/' );
		// Prepare messages
		$message_wp = sprintf( __( '<h1>Oops! Plugin not activated&hellip;</h1> <p>Shortcodes Ultimate is not fully compatible with your version of WordPress (%s).<br />Reccomended WordPress version &ndash; %s (or higher).</p><a href="%s">&larr; Return to the plugins screen</a> <a href="%s"%s>Continue and activate anyway &rarr;</a>', 'su' ), $wp, $min_wp, network_admin_url( 'plugins.php?deactivate=true' ), $_SERVER['REQUEST_URI'] . '&continue=true', ' style="float:right;font-weight:bold"' );
		$message_php = sprintf( __( '<h1>Oops! Plugin not activated&hellip;</h1> <p>Shortcodes Ultimate is not fully compatible with your PHP version (%s).<br />Reccomended PHP version &ndash; %s (or higher).</p><a href="%s">&larr; Return to the plugins screen</a> <a href="%s"%s>Continue and activate anyway &rarr;</a>', 'su' ), $php, $min_php, network_admin_url( 'plugins.php?deactivate=true' ), $_SERVER['REQUEST_URI'] . '&continue=true', ' style="float:right;font-weight:bold"' );
		// Check Forced activation
		if ( isset( $_GET['continue'] ) ) return;
		// WP version is too low
		if ( version_compare( $min_wp, $wp, '>' ) ) {
			deactivate_plugins( plugin_basename( SU_PLUGIN_FILE ) );
			wp_die( $message_wp );
		}
		// PHP version is too low
		elseif ( version_compare( $min_php, $php, '>' ) ) {
			deactivate_plugins( plugin_basename( SU_PLUGIN_FILE ) );
			wp_die( $message_php );
		}
	}

}

new Shortcodes_Ultimate_Requirements;
