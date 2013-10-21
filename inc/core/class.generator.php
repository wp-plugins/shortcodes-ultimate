<?php
/**
 * Shortcode Generator
 */
class Shortcodes_Ultimate_Generator {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'media_buttons',                  array( __CLASS__, 'button' ), 100 );
		add_action( 'su/activation',                  array( __CLASS__, 'reset' ) );
		add_action( 'sunrise_page_before',            array( __CLASS__, 'reset' ) );
		add_action( 'create_term',                    array( __CLASS__, 'reset' ), 10, 3 );
		add_action( 'edit_term',                      array( __CLASS__, 'reset' ), 10, 3 );
		add_action( 'delete_term',                    array( __CLASS__, 'reset' ), 10, 3 );
		add_action( 'wp_ajax_su_generator_settings',  array( __CLASS__, 'settings' ) );
		add_action( 'wp_ajax_su_generator_preview',   array( __CLASS__, 'preview' ) );
		add_action( 'wp_ajax_su_generator_get_terms', array( __CLASS__, 'get_terms' ) );
		add_action( 'wp_ajax_su_generator_upload',    array( __CLASS__, 'upload' ) );
		add_action( 'wp_ajax_su_generator_icons',     array( __CLASS__, 'icons' ) );
		add_action( 'wp_ajax_su_generator_galleries', array( __CLASS__, 'galleries' ) );
	}

	/**
	 * Generator button
	 */
	public static function button( $args = array() ) {
		// Check access
		if ( !self::access_check() ) return;
		// Plugin object
		$shult = shortcodes_ultimate();
		// Prepare args
		$args = wp_parse_args( $args, array(
				'target'    => 'content',
				'text'      => __( 'Insert shortcode', 'su' ),
				'class'     => 'button',
				'icon'      => plugins_url( 'assets/images/generator/icon.png', SU_PLUGIN_FILE ),
				'echo'      => true,
				'shortcode' => false
			) );
		// Prepare icon
		$args['icon'] = ( $args['icon'] ) ? '<img src="' . $args['icon'] . '" /> ' : '';
		// Print button
		$button = '<a href="javascript:void(0);" class="su-generator-button ' . $args['class'] . '" title="' . $args['text'] . '" data-target="' . $args['target'] . '" data-mfp-src="#su-generator" data-shortcode="' . (string) $args['shortcode'] . '">' . $args['icon'] . $args['text'] . '</a>';
		// Show generator popup
		add_action( 'wp_footer',    array( __CLASS__, 'popup' ) );
		add_action( 'admin_footer', array( __CLASS__, 'popup' ) );
		// Request assets
		wp_enqueue_media();
		su_query_asset( 'css', array( 'farbtastic', 'qtip', 'magnific-popup', 'font-awesome', 'su-generator' ) );
		su_query_asset( 'js', array( 'jquery', 'farbtastic', 'qtip', 'magnific-popup', 'su-generator' ) );
		// Print/return result
		if ( $args['echo'] ) echo $button;
		else return $button;
	}

	/**
	 * Cache reset
	 */
	public static function reset() {
		// Clear popup cache
		delete_transient( 'su/generator/popup' );
		// Clear shortcodes settings cache
		foreach ( (array) Shortcodes_Ultimate_Data::shortcodes() as $name => $data )
			delete_transient( 'su/generator/settings/' . $name );
	}

	/**
	 * Generator popup form
	 */
	public static function popup() {
		// Get cache
		$output = get_transient( 'su/generator/popup' );
		if ( $output && SU_ENABLE_CACHE ) echo $output;
		// Cache not found
		else {
			ob_start();
			$shult = shortcodes_ultimate();
			$tools = apply_filters( 'su/generator/tools', array(
					'<a href="' . $shult->admin_url . '#tab-1" target="_blank" title="' . __( 'Settings', 'su' ) . '">' . __( 'Plugin settings', 'su' ) . '</a>',
					'<a href="http://gndev.info/shortcodes-ultimate/" target="_blank" title="' . __( 'Plugin homepage', 'su' ) . '">' . __( 'Plugin homepage', 'su' ) . '</a>',
					'<a href="http://wordpress.org/support/plugin/shortcodes-ultimate/" target="_blank" title="' . __( 'Support forums', 'su' ) . '">' . __( 'Support forums', 'su' ) . '</a>'
				) );
?>
		<div id="su-generator-wrap" style="display:none">
			<div id="su-generator">
				<div id="su-generator-header">
					<div id="su-generator-tools"><?php echo implode( ' <span></span> ', $tools ); ?></div>
					<input type="text" name="su_generator_search" id="su-generator-search" value="" placeholder="<?php _e( 'Search for shortcodes', 'su' ); ?>" />
					<div id="su-generator-filter">
						<strong><?php _e( 'Filter by type', 'su' ); ?></strong>
						<?php foreach ( (array) Shortcodes_Ultimate_Data::groups() as $group => $label ) echo '<a href="#" data-filter="' . $group . '">' . $label . '</a>'; ?>
					</div>
					<div id="su-generator-choices">
						<?php
			// Choices loop
			foreach ( (array) Shortcodes_Ultimate_Data::shortcodes() as $name => $shortcode ) {
				$icon = ( isset( $shortcode['icon'] ) ) ? $shortcode['icon'] : '';
				echo '<span data-shortcode="' . $name . '" title="' . esc_attr( $shortcode['desc'] ) . '" data-desc="' . esc_attr( $shortcode['desc'] ) . '" data-group="' . $shortcode['group'] . '">' . Shortcodes_Ultimate_Tools::icon( $icon ) . $shortcode['name'] . '</span>' . "\n";
			}
?>
					</div>
				</div>
				<div id="su-generator-settings"></div>
				<input type="hidden" name="su-generator-selected" id="su-generator-selected" value="<?php echo $shult->url; ?>" />
				<input type="hidden" name="su-generator-url" id="su-generator-url" value="<?php echo $shult->url; ?>" />
				<input type="hidden" name="su-compatibility-mode-prefix" id="su-compatibility-mode-prefix" value="<?php echo su_compatibility_mode_prefix(); ?>" />
				<div id="su-generator-result" style="display:none"></div>
			</div>
		</div>
	<?php
			$output = ob_get_contents();
			set_transient( 'su/generator/popup', $output, 60*60*24*30 );
			ob_end_clean();
			echo $output;
		}
	}

	/**
	 * Process AJAX request
	 */
	public static function settings() {
		$shult = shortcodes_ultimate();
		// Capability check
		self::access();
		// Param check
		if ( empty( $_REQUEST['shortcode'] ) ) wp_die( __( 'Shortcode not specified', 'su' ) );
		// Get cache
		$output = get_transient( 'su/generator/settings/' . sanitize_text_field( $_REQUEST['shortcode'] ) );
		if ( $output && SU_ENABLE_CACHE ) echo $output;
		// Cache not found
		else {
			// Request queried shortcode
			$shortcode = Shortcodes_Ultimate_Data::shortcodes( $_REQUEST['shortcode'] );
			// Prepare skip-if-default option
			$skip = ( $shult->get_option( 'skip' ) === 'on' ) ? ' su-generator-skip' : '';
			// Prepare actions
			$actions = apply_filters( 'su/generator/actions', array(
					'insert' => '<a href="javascript:void(0);" class="button button-primary button-large su-generator-insert">' . __( 'Insert shortcode', 'su' ) . '</a>',
					'preview' => '<a href="javascript:void(0);" class="button button-large su-generator-toggle-preview">' . __( 'Live preview', 'su' ) . '</a>',
					'close' => '<a href="javascript:void(0);" class="button alignright button-large su-generator-close">' . __( 'Close window', 'su' ) . '</a>'
				) );
			// Shortcode header
			$return = '<div id="su-generator-breadcrumbs">';
			$return .= apply_filters( 'su/generator/breadcrumbs', '<a href="javascript:void(0);" class="su-generator-home" title="' . __( 'Click to return to the shortcodes list', 'su' ) . '">' . __( 'All shortcodes', 'su' ) . '</a> &rarr; <span>' . $shortcode['name'] . '</span> <small class="alignright">' . $shortcode['desc'] . '</small><div class="su-generator-clear"></div>' );
			$return .= '</div>';
			// Shortcode has atts
			if ( count( $shortcode['atts'] ) && $shortcode['atts'] ) {
				// Loop through shortcode parameters
				foreach ( $shortcode['atts'] as $attr_name => $attr_info ) {
					// Prepare default value
					$default = (string) ( isset( $attr_info['default'] ) ) ? $attr_info['default'] : '';
					$return .= '<div class="su-generator-attr-container' . $skip . '" data-default="' . esc_attr( $default ) . '">';
					$return .= '<h5>' . $attr_info['name'] . '</h5>';
					// Create field types
					if ( !isset( $attr_info['type'] ) ) $attr_info['type'] = 'text';
					switch ( $attr_info['type'] ) {
						// Select
					case 'select':
						$return .= Shortcodes_Ultimate_Generator_Fields::select( $attr_name, $attr_info );
						break;
						// Switch
					case 'switch':
						$return .= Shortcodes_Ultimate_Generator_Fields::swtch( $attr_name, $attr_info );
						break;
						// Upload
					case 'upload':
						$return .= Shortcodes_Ultimate_Generator_Fields::upload( $attr_name, $attr_info );
						break;
						// Icon
					case 'icon':
						$return .= Shortcodes_Ultimate_Generator_Fields::icon( $attr_name, $attr_info );
						break;
						// Color
					case 'color':
						$return .= Shortcodes_Ultimate_Generator_Fields::color( $attr_name, $attr_info );
						break;
						// Gallery
					case 'gallery':
						$return .= Shortcodes_Ultimate_Generator_Fields::gallery( $attr_name, $attr_info );
						break;
						// Number
					case 'number':
						$return .= Shortcodes_Ultimate_Generator_Fields::number( $attr_name, $attr_info );
						break;
						// Shadow
					case 'shadow':
						$return .= Shortcodes_Ultimate_Generator_Fields::shadow( $attr_name, $attr_info );
						break;
						// Text and other types
					default:
						$return .= Shortcodes_Ultimate_Generator_Fields::text( $attr_name, $attr_info );
						break;
					}
					if ( isset( $attr_info['desc'] ) ) $return .= '<div class="su-generator-attr-desc">' . str_replace( '<b%value>', '<b class="su-generator-set-value" title="' . __( 'Click to set this value', 'su' ) . '">', $attr_info['desc'] ) . '</div>';
					$return .= '</div>';
				}
			}
			// Single shortcode (not closed)
			if ( $shortcode['type'] == 'single' ) $return .= '<input type="hidden" name="su-generator-content" id="su-generator-content" value="false" />';
			// Wrapping shortcode
			else $return .= '<div class="su-generator-attr-container"><h5>' . __( 'Content', 'su' ) . '</h5><textarea name="su-generator-content" id="su-generator-content" rows="3">' . esc_attr( str_replace( '%prefix_', su_compatibility_mode_prefix(), $shortcode['content'] ) ) . '</textarea></div>';
			$return .= '<div id="su-generator-preview"></div>';
			$return .= '<div class="su-generator-actions">' . implode( ' ', array_values( $actions ) ) . '</div>';
			set_transient( 'su/generator/settings/' . sanitize_text_field( $_REQUEST['shortcode'] ), $return, 60*60*24*30 );
			echo $return;
		}
		exit;
	}

	/**
	 * Process AJAX request and generate preview HTML
	 */
	public static function preview() {
		// Check authentication
		self::access();
		// Output results
		do_action( 'su/generator/preview/before' );
		echo '<h5>' . __( 'Preview', 'su' ) . '</h5>';
		echo do_shortcode( str_replace( '\"', '"', $_POST['shortcode'] ) );
		echo '<div class="su-spacer"></div>';
		do_action( 'su/generator/preview/after' );
		die();
	}

	/**
	 * Process AJAX request and generate json-encoded array with terms
	 */
	public static function get_terms() {
		// Check authentication
		self::access();
		die( json_encode( su_get_terms( sanitize_text_field( $_POST['taxonomy'] ) ) ) );
	}

	/**
	 * Function to handle uploads
	 */
	public static function upload() {
		// Check capability
		self::access();
		// Create mew upload instance
		$upload = new MediaUpload;
		// Save file
		$file = $upload->saveUpload( $field_name = 'file' );
		// Print result
		die( wp_get_attachment_url( $file['attachment_id'] ) );
	}

	public static function icons() {
		// Check capability
		self::access();
		// Return JSON-encoded list of available icons
		die( json_encode( Shortcodes_Ultimate_Data::icons() ) );
	}

	/**
	 * Print json-encoded list of galleries
	 */
	public static function galleries() {
		$shult = shortcodes_ultimate();
		// Check user
		if ( !is_user_logged_in() ) return;
		// Prepare galleries list
		$galleries = $shult->get_option( 'galleries' );
		$options = array();
		// Check that galleries is set
		if ( is_array( $galleries ) && count( $galleries ) )
			foreach ( $galleries as $id => $gallery ) {
				// Is this option selected
				$selected = ( $id == 0 ) ? ' selected' : '';
				// Prepare title
				$gallery['name'] = ( $gallery['name'] == '' ) ? __( 'Untitled gallery', 'su' ) : stripslashes( $gallery['name'] );
				// Create option
				$options[] = '<option value="' . ( $id + 1 ) . '"' . $selected . '>' . $gallery['name'] . '</option>';
			}
		// Galleries not created
		else
			$options[] = '<option value="0" selected>' . __( 'Galleries not found', 'su' ) . '</option>';
		// Print result
		die( implode( '', $options ) );
	}

	/**
	 * Access check
	 */
	public static function access() {
		if ( !self::access_check() ) wp_die( __( 'Access denied', 'su' ) );
	}

	public static function access_check() {
		$by_role = ( get_option( 'su_generator_access' ) ) ? current_user_can( get_option( 'su_generator_access' ) ) : true;
		return current_user_can( 'edit_posts' ) && $by_role;
	}
}

new Shortcodes_Ultimate_Generator;
