<?php
	add_action( 'admin_notices', 'my_admin_notice' );

	/**
	 * Function to show admin notice if Shortcodes Ultimate is not installed
	 */
	function my_admin_notice() {
		// Check that plugin is not installed
		if ( function_exists( 'shortcodes_ultimate' ) ) return;
		?>
		<div class="error">
			<p>For full functionality of this theme you need to install and activate plugin <strong>Shortcodes Ultimate</strong>. <a href="<?php echo admin_url( 'plugin-install.php?tab=search&s=shortcodes+ultimate' ); ?>">Install now &rsaquo;</a></p>
		</div>
		<?php
	}

	add_filter( 'shortcodes_ultimate_data', 'register_my_custom_shortcode' );

	/**
	 * Filter to modify original shortcodes data and add custom shortcodes
	 *
	 * @param array $shortcodes Basic plugin shortcodes
	 * @return array Modified array
	 */
	function register_my_custom_shortcode( $shortcodes ) {
		// Add new shortcode
		$shortcodes['heading2'] = array(
			// Shortcode name
			'name' => __( 'Heading 2', 'textdomain' ),
			// Shortcode type. Can be 'wrap' or 'single'
			// Example: [b]this is wrapped[/b], [this_is_single]
			'type' => 'wrap',
			// Shortcode group. Can be 'content', 'box', 'media' or 'other'. Groups can be mixed, for example 'content box'
			'group' => 'content',
			// List of shortcode params (attributes)
			'atts' => array(
				// Style attribute
				'style' => array(
					// Attribute type. Can be 'select', 'color', 'switch', 'gallery' or 'text'
					'type' => 'select',
					// Available values
					'values' => array(
						'default' => __( 'Default', 'textdomain' ),
						'small' => __( 'Small', 'textdomain' )
					),
					// Default value
					'default' => 'default',
					// Attribute name
					'name' => __( 'Style', 'textdomain' ),
					// Attribute description
					'desc' => __( 'Heading 2 style', 'textdomain' )
				)
			),
			// Example of usage for cheatsheet
			'usage' => '[heading2] Content [/heading2]<br/>[heading2 style="2"] Content [/heading2]',
			// Default content for generator (for wrap-type shortcodes)
			'content' => __( 'Heading 2 text', 'textdomain' ),
			// Shortcode description for cheatsheet and generator
			'desc' => __( 'Styled heading 2', 'textdomain' ),
			// Custom icon url for Generator (example)
			'icon' => '/wp-content/plugins/shortcodes-ultimate-addon/img/icon.png',
			// Custom demo image url for cheatsheet (example)
			'demo' => '/wp-content/plugins/shortcodes-ultimate-addon/img/demo.png',
			// Name of custom shortcode function
			'function' => 'su_heading2_shortcode'
		);
		// Return modified data
		return $shortcodes;
	}

	/**
	 * Shortcode function
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content Shortcode content
	 * @return string Shortcode markup
	 */
	function su_heading2_shortcode( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'style' => 'default',
			'align' => 'center'
			), $atts );
		return '<div class="su-heading su-heading-style-' . $atts['style'] . '" style="text-align:' . $atts['align'] . '"><div class="su-heading-inner">' . $content . '</div></div>';
	}
?>