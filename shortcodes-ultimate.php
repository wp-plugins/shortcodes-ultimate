<?php
	/*
	  Plugin Name: Shortcodes Ultimate
	  Plugin URI: http://ilovecode.ru/?p=122
	  Version: 1.4.1
	  Author: Vladimir Anokhin
	  Author URI: http://ilovecode.ru/
	  Description: Provides support for many easy to use shortcodes
	  Text Domain: shortcodes-ultimate
	  Domain Path: /languages
	 */

	/**
	 * Shortcode: heading
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_heading_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'size' => 3
				), $atts ) );

		return '<div class="su-heading"><div class="su-heading-shell">' . $content . '</div></div>';
	}

	/**
	 * Shortcode: frame
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_frame_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'align' => 'none'
				), $atts ) );

		return '<div class="su-frame su-frame-align-' . $align . '"><div class="su-frame-shell">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: tabs
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_tabs( $atts, $content ) {
		$GLOBALS['tab_count'] = 0;

		do_shortcode( $content );

		if ( is_array( $GLOBALS['tabs'] ) ) {
			foreach ( $GLOBALS['tabs'] as $tab ) {
				$tabs[] = '<span>' . $tab['title'] . '</span>';
				$panes[] = '<div class="su-tabs-pane">' . $tab['content'] . '</div>';
			}
			$return = '<div class="su-tabs"><div class="su-tabs-nav">' . implode( '', $tabs ) . '</div><div class="su-tabs-panes">' . implode( "\n", $panes ) . '</div></div>';
		}
		return $return;
	}

	/**
	 * Shortcode: tab
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_tab( $atts, $content ) {
		extract( shortcode_atts( array( 'title' => 'Tab %d' ), $atts ) );
		$x = $GLOBALS['tab_count'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' => do_shortcode( $content ) );
		$GLOBALS['tab_count']++;
	}

	/**
	 * Shortcode: spoiler
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_spoiler_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'title' => __( 'Spoiler title', 'shortcodes-ultimate' )
				), $atts ) );

		return '<div class="su-spoiler su-spoiler-open"><div class="su-spoiler-title">' . $title . '</div><div class="su-spoiler-content">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: divider
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_divider_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'top' => false
				), $atts ) );

		return ( $top ) ? '<div class="su-divider"><a href="#">' . __( 'Top', 'shortcodes-ultimate' ) . '</a></div>' : '<div class="su-divider"></div>';
	}

	/**
	 * Shortcode: spacer
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_spacer_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'size' => 0
				), $atts ) );

		return '<div class="su-spacer" style="height:' . $size . 'px"></div>';
	}

	/**
	 * Shortcode: highlight
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_highlight_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'bg' => '#df9',
				'color' => '#000'
				), $atts ) );

		return '<span class="su-highlight" style="background:' . $bg . ';color:' . $color . '">&nbsp;' . $content . '&nbsp;</span>';
	}

	/**
	 * Shortcode: column
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_column_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'size' => '1-2',
				'last' => false
				), $atts ) );

		return ( $last ) ? '<div class="su-column su-column-' . $size . ' su-column-last">' . do_shortcode( $content ) . '</div><div class="su-spacer su-spacer-20"></div>' : '<div class="su-column su-column-' . $size . '">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Shortcode: list
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_list_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 'star'
				), $atts ) );

		return '<div class="su-list su-list-style-' . $style . '">' . $content . '</div>';
	}

	/**
	 * Shortcode: quote
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_quote_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 1
				), $atts ) );

		return '<div class="su-quote su-quote-style-' . $style . '"><div class="su-quote-shell">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: pullquote
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_pullquote_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 1,
				'align' => 'left'
				), $atts ) );

		return '<div class="su-pullquote su-pullquote-style-' . $style . ' su-pullquote-align-' . $align . '">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Shortcode: button
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_button_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'link' => '#',
				'color' => '#aaa',
				'dark' => false,
				'square' => false,
				'style' => 1,
				'size' => 2
				), $atts ) );

		$styles = array(
			'border_radius' => ( $square ) ? 0 : $size + 2,
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'light_color' => su_hex_shift( $color, 'lighter', 70 ),
			'size' => round( ( $size + 9 ) * 1.3 ),
			'text_color' => ( $dark ) ? su_hex_shift( $color, 'darker', 70 ) : su_hex_shift( $color, 'lighter', 90 ),
			'text_shadow' => ( $dark ) ? su_hex_shift( $color, 'lighter', 50 ) : su_hex_shift( $color, 'darker', 20 ),
			'text_shadow_position' => ( $dark ) ? '1px 1px' : '-1px -1px',
			'padding_v' => ( $size * 2 ) + 2,
			'padding_h' => ( $size * 5 ) + 5
		);

		$link_styles = array(
			'background-color' => $color,
			'border' => '1px solid ' . $styles['dark_color'],
			'border-radius' => $styles['border_radius'] . 'px',
			'-moz-border-radius' => $styles['border_radius'] . 'px',
			'-webkit-border-radius' => $styles['border_radius'] . 'px'
		);

		$span_styles = array(
			'color' => $styles['text_color'],
			'padding' => $styles['padding_v'] . 'px ' . $styles['padding_h'] . 'px',
			'font-size' => $styles['size'] . 'px',
			'height' => $styles['size'] . 'px',
			'line-height' => $styles['size'] . 'px',
			'border-top' => '1px solid ' . $styles['light_color'],
			'text-transform' => 'uppercase',
			'border-radius' => $styles['border_radius'] . 'px',
			'text-shadow' => $styles['text_shadow_position'] . ' 0 ' . $styles['text_shadow'],
			'-moz-border-radius' => $styles['border_radius'] . 'px',
			'-moz-text-shadow' => $styles['text_shadow_position'] . ' 0 ' . $styles['text_shadow'],
			'-webkit-border-radius' => $styles['border_radius'] . 'px',
			'-webkit-text-shadow' => $styles['text_shadow_position'] . ' 0 ' . $styles['text_shadow']
		);

		foreach ( $link_styles as $link_rule => $link_value ) {
			$link_style .= $link_rule . ':' . $link_value . ';';
		}

		foreach ( $span_styles as $span_rule => $span_value ) {
			$span_style .= $span_rule . ':' . $span_value . ';';
		}

		return '<a href="' . $link . '" class="su-button su-button-style-' . $style . '" style="' . $link_style . '"><span style="' . $span_style . '">' . $content . '</span></a>';
	}

	/**
	 * Shortcode: fancy-link
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_fancy_link_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'link' => '#',
				'color' => 'black'
				), $atts ) );

		return '<a class="su-fancy-link su-fancy-link-' . $color . '" href="' . $link . '">' . $content . '</a>';
	}

	/**
	 * Shortcode: service
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_service_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'title' => __( 'Service name', 'shortcodes-ultimate' ),
				'icon' => su_plugin_url() . '/images/service.png',
				'size' => 32
				), $atts ) );

		return '<div class="su-service"><div class="su-service-title" style="padding:' . round( ( $size - 16 ) / 2 ) . 'px 0 ' . round( ( $size - 16 ) / 2 ) . 'px ' . ( $size + 15 ) . 'px"><img src="' . $icon . '" width="' . $size . '" height="' . $size . '" alt="' . $title . '" /> ' . $title . '</div><div class="su-service-content" style="padding:0 0 0 ' . ( $size + 15 ) . 'px">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: box
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_box_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'color' => '#333',
				'title' => __( 'This is box title', 'shortcodes-ultimate' )
				), $atts ) );

		$styles = array(
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'light_color' => su_hex_shift( $color, 'lighter', 60 ),
			'text_shadow' => su_hex_shift( $color, 'darker', 70 ),
		);

		return '<div class="su-box" style="border:1px solid ' . $styles['dark_color'] . '"><div class="su-box-title" style="background-color:' . $color . ';border-top:1px solid ' . $styles['light_color'] . ';text-shadow:1px 1px 0 ' . $styles['text_shadow'] . '">' . $title . '</div><div class="su-box-content">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Shortcode: note
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_note_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'color' => '#fc0'
				), $atts ) );

		$styles = array(
			'dark_color' => su_hex_shift( $color, 'darker', 10 ),
			'light_color' => su_hex_shift( $color, 'lighter', 20 ),
			'extra_light_color' => su_hex_shift( $color, 'lighter', 80 ),
			'text_color' => su_hex_shift( $color, 'darker', 70 )
		);

		return '<div class="su-note" style="background-color:' . $styles['light_color'] . ';border:1px solid ' . $styles['dark_color'] . '"><div class="su-note-shell" style="border:1px solid ' . $styles['extra_light_color'] . ';color:' . $styles['text_color'] . '">' . do_shortcode( $content ) . '</div></div>';
	}

	/**
	 * Plugin initialization
	 */
	function su_plugin_init() {

		// Make plugin available for tramslation
		load_plugin_textdomain( 'shortcodes-ultimate', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		/**
		 * Returns current plugin version.
		 *
		 * @return string Plugin version
		 */
		function su_get_version() {
			if ( !function_exists( 'get_plugins' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
			$plugin_file = basename( ( __FILE__ ) );
			return $plugin_folder[$plugin_file]['Version'];
		}

		/**
		 * Returns current plugin url.
		 *
		 * @return string Plugin url
		 */
		function su_plugin_url() {
			return plugins_url( basename( __FILE__, '.php' ), dirname( __FILE__ ) );
		}

		/**
		 * Color shift a hex value by a specific percentage factor
		 *
		 * @param string $supplied_hex Any valid hex value. Short forms e.g. #333 accepted.
		 * @param string $shift_method How to shift the value e.g( +,up,lighter,>)
		 * @param integer $percentage Percentage in range of [0-100] to shift provided hex value by
		 * @return string shifted hex value
		 * @version 1.0 2008-03-28
		 */
		function su_hex_shift( $supplied_hex, $shift_method, $percentage = 50 ) {
			$shifted_hex_value = null;
			$valid_shift_option = FALSE;
			$current_set = 1;
			$RGB_values = array( );
			$valid_shift_up_args = array( 'up', '+', 'lighter', '>' );
			$valid_shift_down_args = array( 'down', '-', 'darker', '<' );
			$shift_method = strtolower( trim( $shift_method ) );

			// Check Factor
			if ( !is_numeric( $percentage ) || ($percentage = ( int ) $percentage) < 0 || $percentage > 100 ) {
				trigger_error( "Invalid factor", E_USER_ERROR );
			}

			// Check shift method
			foreach ( array( $valid_shift_down_args, $valid_shift_up_args ) as $options ) {
				foreach ( $options as $method ) {
					if ( $method == $shift_method ) {
						$valid_shift_option = !$valid_shift_option;
						$shift_method = ( $current_set === 1 ) ? '+' : '-';
						break 2;
					}
				}
				++$current_set;
			}

			if ( !$valid_shift_option ) {
				trigger_error( "Invalid shift method", E_USER_ERROR );
			}

			// Check Hex string
			switch ( strlen( $supplied_hex = ( str_replace( '#', '', trim( $supplied_hex ) ) ) ) ) {
				case 3:
					if ( preg_match( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', $supplied_hex ) ) {
						$supplied_hex = preg_replace( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', '\\1\\1\\2\\2\\3\\3', $supplied_hex );
					} else {
						trigger_error( "Invalid hex value", E_USER_ERROR );
					}
					break;
				case 6:
					if ( !preg_match( '/^[0-9a-f]{2}[0-9a-f]{2}[0-9a-f]{2}$/i', $supplied_hex ) ) {
						trigger_error( "Invalid hex value", E_USER_ERROR );
					}
					break;
				default:
					trigger_error( "Invalid hex length", E_USER_ERROR );
			}

			// Start shifting
			$RGB_values['R'] = hexdec( $supplied_hex{0} . $supplied_hex{1} );
			$RGB_values['G'] = hexdec( $supplied_hex{2} . $supplied_hex{3} );
			$RGB_values['B'] = hexdec( $supplied_hex{4} . $supplied_hex{5} );

			foreach ( $RGB_values as $c => $v ) {
				switch ( $shift_method ) {
					case '-':
						$amount = round( ((255 - $v) / 100) * $percentage ) + $v;
						break;
					case '+':
						$amount = $v - round( ($v / 100) * $percentage );
						break;
					default:
						trigger_error( "Oops. Unexpected shift method", E_USER_ERROR );
				}

				$shifted_hex_value .= $current_value = (
					strlen( $decimal_to_hex = dechex( $amount ) ) < 2
					) ? '0' . $decimal_to_hex : $decimal_to_hex;
			}

			return '#' . $shifted_hex_value;
		}

		/**
		 * Disable auto-formatting for shortcodes
		 *
		 * @param string $content
		 * @return string Formatted content with clean shortcodes content
		 */
		function su_custom_formatter( $content ) {
			$new_content = '';

			// Matches the contents and the open and closing tags
			$pattern_full = '{(\[raw\].*?\[/raw\])}is';

			// Matches just the contents
			$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

			// Divide content into pieces
			$pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );

			// Loop over pieces
			foreach ( $pieces as $piece ) {

				// Look for presence of the shortcode
				if ( preg_match( $pattern_contents, $piece, $matches ) ) {

					// Append to content (no formatting)
					$new_content .= $matches[1];
				} else {

					// Format and append to content
					$new_content .= wptexturize( wpautop( $piece ) );
				}
			}

			return $new_content;
		}

		// Enable shortcodes in widgets
		add_filter( 'widget_text', 'do_shortcode' );

		if ( get_option( 'su_disable_custom_formatting' ) != 'on' ) {

			// Disable WordPress native formatters
			remove_filter( 'the_content', 'wpautop' );
			remove_filter( 'the_content', 'wptexturize' );

			// Apply custom formatter function
			add_filter( 'the_content', 'su_custom_formatter', 99 );
			add_filter( 'widget_text', 'su_custom_formatter', 99 );
		}


		// Fix for large posts, http://core.trac.wordpress.org/ticket/8553
		@ini_set( 'pcre.backtrack_limit', 500000 );

		if ( !is_admin() ) {
			// Register
			wp_register_style( 'shortcodes-ultimate', su_plugin_url() . '/css/style.css', false, su_get_version(), 'all' );
			wp_register_script( 'shortcodes-ultimate', su_plugin_url() . '/js/init.js', false, su_get_version(), false );

			// Enqueue
			wp_enqueue_style( 'shortcodes-ultimate' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'shortcodes-ultimate' );
		}

		// Add shortcodes
		add_shortcode( 'heading', 'su_heading_shortcode' );
		add_shortcode( 'frame', 'su_frame_shortcode' );
		add_shortcode( 'tabs', 'su_tabs' );
		add_shortcode( 'tab', 'su_tab' );
		add_shortcode( 'spoiler', 'su_spoiler_shortcode' );
		add_shortcode( 'divider', 'su_divider_shortcode' );
		add_shortcode( 'spacer', 'su_spacer_shortcode' );
		add_shortcode( 'quote', 'su_quote_shortcode' );
		add_shortcode( 'pullquote', 'su_pullquote_shortcode' );
		add_shortcode( 'highlight', 'su_highlight_shortcode' );
		add_shortcode( 'button', 'su_button_shortcode' );
		add_shortcode( 'fancy_link', 'su_fancy_link_shortcode' );
		add_shortcode( 'service', 'su_service_shortcode' );
		add_shortcode( 'box', 'su_box_shortcode' );
		add_shortcode( 'note', 'su_note_shortcode' );
		add_shortcode( 'list', 'su_list_shortcode' );
		add_shortcode( 'column', 'su_column_shortcode' );

		/**
		 * Register administration page
		 */
		function shortcodes_ultimate_add_admin() {
			add_options_page( __( 'Shortcodes', 'shortcodes-ultimate' ), __( 'Shortcodes', 'shortcodes-ultimate' ), 'manage_options', 'shortcodes-ultimate', 'shortcodes_ultimate_admin_page' );
		}

		/**
		 * Administration page
		 */
		function shortcodes_ultimate_admin_page() {
			?>

			<style type="text/css">
				#su-top-message {
					margin: 20px 20px 10px 0;
					padding: 5px 15px;
					border: 1px solid #E6DB55;
					background: #FFFFE0;
					border-radius: 3px;
				}
				.su-new-shortcode td {
					background: #ffd;
				}
			</style>

			<div id="su-top-message">
				<p><strong><?php _e( 'Want to support author? Just share this link!', 'shortcodes-ultimate' ); ?></strong></p>
				<p>
					<input type="text" value="http://ilovecode.ru/?p=122" size="27" onclick="this.select();" />
					<a href="http://facebook.com/sharer.php?u=http://ilovecode.ru/?p=122" title="<?php _e( 'Share on Facebook', 'shortcodes-ultimate' ); ?>" target="_blank">
						<img src="<?php echo su_plugin_url(); ?>/images/social/facebook_16.png" title="<?php _e( 'Share on Facebook', 'shortcodes-ultimate' ); ?>" style="margin-bottom:-3px" />
					</a>
					<a href="http://twitter.com/home?status=Shortcodes%20Ultimate%20http://ilovecode.ru/?p=122" title="<?php _e( 'Share on Twitter', 'shortcodes-ultimate' ); ?>" target="_blank">
						<img src="<?php echo su_plugin_url(); ?>/images/social/twitter_16.png" title="<?php _e( 'Share on Twitter', 'shortcodes-ultimate' ); ?>" style="margin-bottom:-3px" />
					</a>
				</p>
				<p>
					<a href="http://wordpress.org/tags/shortcodes-ultimate?forum_id=10" target="_blank"><?php _e( 'Support forum', 'shortcodes-ultimate' ); ?></a> |
					<a href="http://twitter.com/gn_themes" target="_blank"><?php _e( 'Twitter', 'shortcodes-ultimate' ); ?></a> |
					<a href="http://ilovecode.ru/?p=122#commentform" target="_blank" style="color:red"><?php _e( 'Bug report', 'shortcodes-ultimate' ); ?></a>
				</p>
			</div>

			<?php
			if ( $_POST['save'] ) {
				update_option( 'su_disable_custom_formatting', $_POST['su_disable_custom_formatting'] );
				echo '<div class="updated"><p><strong>' . __( 'Settings saved', 'shortcodes-ultimate' ) . '</strong></p></div>';
			}

			$checked = ( get_option( 'su_disable_custom_formatting' ) == 'on' ) ? ' checked="checked"' : '';
			?>
			<!-- .wrap -->
			<div class="wrap">
				<h2><?php _e( 'Shortcodes ultimate settings', 'shortcodes-ultimate' ); ?></h2>
				<form action="" method="post">
					<p><label><input type="checkbox" name="su_disable_custom_formatting" <?php echo $checked; ?> /> <?php _e( 'Disable custom formatting', 'shortcodes-ultimate' ); ?></label></p>
					<p><input type="submit" value="<?php _e( 'Save settings', 'shortcodes-ultimate' ); ?>" class="button-primary" /></p>
					<input type="hidden" name="save" value="true" />
				</form>
				<h2><?php _e( 'Available shortcodes', 'shortcodes-ultimate' ); ?></h2>
				<table class="widefat fixed" style="width:700px;margin-bottom:20px">
					<tr>
						<th width="100"><?php _e( 'Shortcode', 'shortcodes-ultimate' ); ?></th>
						<th width="200"><?php _e( 'Parameters', 'shortcodes-ultimate' ); ?></th>
						<th><?php _e( 'Usage', 'shortcodes-ultimate' ); ?></th>
					</tr>
					<tr>
						<td>heading</td>
						<td>&mdash;</td>
						<td>[heading] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/heading]</td>
					</tr>
					<tr>
						<td>frame</td>
						<td>align="left|center|none|right"</td>
						<td>[frame align="center"] &lt;img src="image.jpg" alt="" /&gt; [/frame]</td>
					</tr>
					<tr>
						<td>tabs, tab</td>
						<td>title</td>
						<td>[tabs] [tab title="<?php _e( 'Tab name', 'shortcodes-ultimate' ); ?>"] <?php _e( 'Tab content', 'shortcodes-ultimate' ); ?> [/tab] [/tabs]</td>
					</tr>
					<tr>
						<td>spoiler</td>
						<td>title</td>
						<td>[spoiler title="<?php _e( 'Spoiler title', 'shortcodes-ultimate' ); ?>"] <?php _e( 'Hidden text', 'shortcodes-ultimate' ); ?> [/spoiler]</td>
					</tr>
					<tr>
						<td>divider</td>
						<td>top (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)</td>
						<td>[divider top="1"]</td>
					</tr>
					<tr>
						<td>spacer</td>
						<td>size</td>
						<td>[spacer size="20"]</td>
					</tr>
					<tr>
						<td>quote</td>
						<td>&mdash;</td>
						<td>[quote] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/quote]</td>
					</tr>
					<tr>
						<td>pullquote</td>
						<td>align="left|right"</td>
						<td>[pullquote align="left"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/pullquote]</td>
					</tr>
					<tr>
						<td>highlight</td>
						<td>bg="#HEX"<br/>color="#HEX"</td>
						<td>[highlight bg="#fc0" color="#000"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/highlight]</td>
					</tr>
					<tr>
						<td>button</td>
						<td>link<br/>color="#HEX"<br/>size="1-10"<br/>style="1|2"<br/>dark (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)<br/>square (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)</td>
						<td>[button link="#" color="#b00" size="3" style="2" dark="1" square="1"] <?php _e( 'Button text', 'shortcodes-ultimate' ); ?> [/button]</td>
					</tr>
					<tr class="su-new-shortcode">
						<td>fancy_link</td>
						<td>color="black|white"<br/>link</td>
						<td>[fancy_link color="black" link="http://example.com/"] <?php _e( 'Read more', 'shortcodes-ultimate' ); ?> [/fancy_link]</td>
					</tr>
					<tr>
						<td>service</td>
						<td>title<br/>icon (<?php _e( 'image url', 'shortcodes-ultimate' ); ?>)<br/>size (<?php _e( 'icon size', 'shortcodes-ultimate' ); ?>)</td>
						<td>[service title="<?php _e( 'Service name', 'shortcodes-ultimate' ); ?>" icon="images/service-1.png" size="32"] <?php _e( 'Service description', 'shortcodes-ultimate' ); ?> [/service]</td>
					</tr>
					<tr>
						<td>box</td>
						<td>title<br/>color="#HEX"</td>
						<td>[box title="<?php _e( 'Box title', 'shortcodes-ultimate' ); ?>" color="#f00"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/box]</td>
					</tr>
					<tr>
						<td>note</td>
						<td>color="#HEX"</td>
						<td>[note color="#D1F26D"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/note]</td>
					</tr>
					<tr>
						<td>list</td>
						<td>style="star|arrow|check|cross"</td>
						<td>[list style="check"] &lt;ul&gt; &lt;li&gt; <?php _e( 'List item', 'shortcodes-ultimate' ); ?> &lt;/li&gt; &lt;/ul&gt; [/list]</td>
					</tr>
					<tr>
						<td>column</td>
						<td>size="1-2|1-3|1-4|1-5|1-6|2-3|3-4|2-5|3-5|4-5|5-6"<br/>last (<?php _e( 'add this to last columns', 'shortcodes-ultimate' ); ?>)</td>
						<td>[column size="1-2"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/column]<br/>[column size="1-2" last="1"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/column]</td>
					</tr>
				</table>
			</div>
			<!-- /.wrap -->
			<?php
		}

		/**
		 * Hook to translate plugin information
		 */
		function su_add_locale_strings() {
			$strings = __( 'Shortcodes Ultimate', 'shortcodes-ultimate' ) . __( 'Vladimir Anokhin', 'shortcodes-ultimate' ) . __( 'Provides support for many easy to use shortcodes', 'shortcodes-ultimate' );
		}

	}

	add_action( 'admin_menu', 'shortcodes_ultimate_add_admin' );
	add_action( 'init', 'su_plugin_init' );
?>