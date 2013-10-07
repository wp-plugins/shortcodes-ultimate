<?php

class Shortcodes_Ultimate_Shortcodes {
	static $tabs = array();
	static $tab_count = 0;

	function __construct() {}

	public static function heading( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'size'  => 3,
				'align' => 'center',
				'class' => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		$size = round( ( $atts['size'] + 7 ) * 1.3 );
		return '<div class="su-heading su-heading-align-' . $atts['align'] . su_ecssc( $atts ) . '" style="font-size:' . $size . 'px"><div class="su-heading-inner">' . $content . '</div></div>';
	}

	public static function tabs( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'active'   => 1,
				'vertical' => 'no',
				'style'    => null, // 3.x
				'class'    => ''
			), $atts );
		if ( $atts['style'] == '3' ) $atts['vertical'] = 'yes';
		self::$tabs = array();
		self::$tab_count = 0;
		do_shortcode( $content );
		$return = '';
		$tabs = $panes = array();
		if ( is_array( self::$tabs ) ) {
			if ( self::$tab_count < $atts['active'] ) $atts['active'] = self::$tab_count;
			foreach ( self::$tabs as $tab ) {
				$tabs[] = '<span class="' . su_ecssc( $tab ) . $tab['disabled'] . '">' . su_scattr( $tab['title'] ) . '</span>';
				$panes[] = '<div class="su-tabs-pane' . su_ecssc( $tab ) . '">' . $tab['content'] . '</div>';
			}
			$vertical = ( $atts['vertical'] === 'yes' ) ? ' su-tabs-vertical' : '';
			$return = '<div class="su-tabs' . $vertical . su_ecssc( $atts ) . '" data-active="' . (string) $atts['active'] . '"><div class="su-tabs-nav">' . implode( '', $tabs ) . '</div><div class="su-tabs-panes">' . implode( "\n", $panes ) . '</div><div style="clear:both;height:0"></div></div>';
		}
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-other-shortcodes' );
		return $return;
	}

	public static function tab( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'    => __( 'Tab title', 'su' ),
				'disabled' => 'no',
				'class'    => ''
			), $atts );
		$x = self::$tab_count;
		self::$tabs[$x] = array(
			'title' => $atts['title'],
			'content' => do_shortcode( $content ),
			'disabled' => ( $atts['disabled'] === 'yes' ) ? ' su-tabs-disabled' : '',
			'class' => $atts['class']
		);
		self::$tab_count++;
	}

	public static function spoiler( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title' => __( 'Spoiler title', 'su' ),
				'open'  => 'no',
				'style' => 'default',
				'class' => ''
			), $atts );
		$atts['style'] = str_replace( array( '1', '2' ), array( 'default', 'fancy' ), $atts['style'] );
		$closed = ( $atts['open'] !== 'yes' ) ? ' su-spoiler-closed' : '';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-other-shortcodes' );
		return '<div class="su-spoiler su-spoiler-style-' . $atts['style'] . $closed . su_ecssc( $atts ) . '"><div class="su-spoiler-title"><span class="su-spoiler-icon"></span>' . su_scattr( $atts['title'] ) . '</div><div class="su-spoiler-content">' . su_do_shortcode( $content, 's' ) . '</div></div>';
	}

	public static function accordion( $atts = null, $content = null ) {
		$atts = shortcode_atts( array( 'class' => '' ), $atts );
		return '<div class="su-accordion' . su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</div>';
	}

	public static function divider( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'top'   => 'yes',
				'text'  => __( 'Go to top', 'su' ),
				'class' => ''
			), $atts );
		$top = ( $atts['top'] === 'yes' ) ? '<a href="#">' . su_scattr( $atts['text'] ) . '</a>' : '';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		return '<div class="su-divider' . su_ecssc( $atts ) . '">' . $top . '</div>';
	}

	public static function spacer( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'size'  => 0,
				'class' => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		return '<div class="su-spacer' . su_ecssc( $atts ) . '" style="height:' . $atts['size'] . 'px"></div>';
	}

	public static function highlight( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'background' => '#ddff99',
				'bg'         => null, // 3.x
				'color'      => '#000000',
				'class'      => ''
			), $atts );
		if ( $atts['bg'] !== null ) $atts['background'] = $atts['bg'];
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		return '<span class="su-highlight' . su_ecssc( $atts ) . '" style="background:' . $atts['background'] . ';color:' . $atts['color'] . '">&nbsp;' . do_shortcode( $content ) . '&nbsp;</span>';
	}

	public static function label( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'type'  => 'default',
				'style' => null, // 3.x
				'class' => ''
			), $atts );
		if ( $atts['style'] !== null ) $atts['type'] = $atts['style'];
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		return '<span class="su-label su-label-type-' . $atts['type'] . su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</span>';
	}

	public static function quote( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'cite'  => false,
				'url'   => false,
				'class' => ''
			), $atts );
		$cite_link = ( $atts['url'] && $atts['cite'] ) ? '<a href="' . $atts['url'] . '">' . $atts['cite'] . '</a>'
		: $atts['cite'];
		$cite = ( $atts['cite'] ) ? '<span class="su-quote-cite">&mdash; ' . $cite_link . '</span>' : '';
		$cite_class = ( $atts['cite'] ) ? ' su-quote-has-cite' : '';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		return '<div class="su-quote' . $cite_class . su_ecssc( $atts ) . '"><div class="su-quote-inner">' . do_shortcode( $content ) . su_scattr( $cite ) . '</div></div>';
	}

	public static function pullquote( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'align' => 'left',
				'class' => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		return '<div class="su-pullquote su-pullquote-align-' . $atts['align'] . su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</div>';
	}

	public static function dropcap( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style' => 'default',
				'size'  => 3,
				'class' => ''
			), $atts );
		$atts['style'] = str_replace( array( '1', '2', '3' ), array( 'default', 'light', 'default' ), $atts['style'] ); // 3.x
		// Calculate font-size
		$em = $atts['size'] * 0.5 . 'em';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		return '<span class="su-dropcap su-dropcap-style-' . $atts['style'] . su_ecssc( $atts ) . '" style="font-size:' . $em . '">' . do_shortcode( $content ) . '</span>';
	}

	public static function frame( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style' => 'default',
				'align' => 'left',
				'class' => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-other-shortcodes' );
		return '<span class="su-frame su-frame-align-' . $atts['align'] . ' su-frame-style-' . $atts['style'] . su_ecssc( $atts ) . '"><span class="su-frame-inner">' . do_shortcode( $content ) . '</span></span>';
	}

	public static function row( $atts = null, $content = null ) {
		$atts = shortcode_atts( array( 'class' => '' ), $atts );
		return '<div class="su-row' . su_ecssc( $atts ) . '">' . su_do_shortcode( $content, 'r' ) . '</div>';
	}

	public static function column( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'size'   => '1/2',
				'center' => 'no',
				'last'   => null,
				'class'  => ''
			), $atts );
		if ( $atts['last'] !== null && $atts['last'] == '1' ) $atts['class'] .= ' su-column-last';
		if ( $atts['center'] === 'yes' ) $atts['class'] .= ' su-column-centered';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		return '<div class="su-column su-column-size-' . str_replace( '/', '-', $atts['size'] ) . su_ecssc( $atts ) . '"><div class="su-column-inner">' . su_do_shortcode( $content, 'c' ) . '</div></div>';
	}

	public static function su_list( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style' => 'star',
				'class' => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		return '<div class="su-list su-list-style-' . $atts['style'] . su_ecssc( $atts ) . '">' . su_do_shortcode( $content, 'l' ) . '</div>';
	}

	public static function button( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'        => get_option( 'home' ),
				'link'       => null, // 3.x
				'target'     => 'self',
				'style'      => 'default',
				'background' => '#2D89EF',
				'color'      => '#FFFFFF',
				'dark'       => null, // 3.x
				'size'       => 3,
				'wide'       => 'no',
				'center'     => 'no',
				'radius'     => 'auto',
				'icon'       => false,
				'ts_color'   => 'dark',
				'ts_pos'     => 'none',
				'desc'       => '',
				'class'      => ''
			), $atts );

		if ( $atts['link'] !== null ) $atts['url'] = $atts['link'];
		if ( $atts['dark'] !== null ) {
			$atts['background'] = $atts['color'];
			$atts['color'] = ( $atts['dark'] ) ? '#000' : '#fff';
		}
		if ( is_numeric( $atts['style'] ) ) $atts['style'] = str_replace( array( '1', '2', '3', '4', '5' ), array( 'default', 'glass', 'bubbles', 'noise', 'stroked' ), $atts['style'] ); // 3.x
		// Prepare vars
		$a_css = array();
		$span_css = array();
		$img_css = array();
		$small_css = array();
		$radius = '0px';
		$before = $after = '';
		// Text shadow values
		$shadows = array(
			'none'         => '0 0',
			'top'          => '0 -1px',
			'right'        => '1px 0',
			'bottom'       => '0 1px',
			'left'         => '-1px 0',
			'top-right'    => '1px -1px',
			'top-left'     => '-1px -1px',
			'bottom-right' => '1px 1px',
			'bottom-left'  => '-1px 1px'
		);
		// Common styles for button
		$styles = array(
			'size'     => round( ( $atts['size'] + 7 ) * 1.3 ),
			'ts_color' => ( $atts['ts_color'] === 'light' ) ? su_hex_shift( $atts['background'], 'lighter', 50 ) : su_hex_shift( $atts['background'], 'darker', 40 ),
			'ts_pos'   => $shadows[$atts['ts_pos']]
		);
		// Calculate border-radius
		if ( $atts['radius'] == 'auto' ) $radius = round( $atts['size'] + 2 ) . 'px';
		elseif ( $atts['radius'] == 'round' ) $radius = round( ( ( $atts['size'] * 2 ) + 2 ) * 2 + $styles['size'] ) . 'px';
		elseif ( is_numeric( $atts['radius'] ) ) $radius = intval( $atts['radius'] ) . 'px';
		// CSS rules for <a> tag
		$a_rules = array(
			'color'                 => $atts['color'],
			'background-color'      => $atts['background'],
			'border-color'          => su_hex_shift( $atts['background'], 'darker', 20 ),
			'border-radius'         => $radius,
			'-moz-border-radius'    => $radius,
			'-webkit-border-radius' => $radius
		);
		// CSS rules for <span> tag
		$span_rules = array(
			'color'                 => $atts['color'],
			'padding'               => ( $atts['icon'] ) ? round( ( $atts['size'] ) / 2 + 4 ) . 'px ' . round( $atts['size'] * 2 + 10 ) . 'px' : '0px ' . round( $atts['size'] * 2 + 10 ) . 'px',
			'font-size'             => $styles['size'] . 'px',
			'line-height'           => ( $atts['icon'] ) ? round( $styles['size'] * 1.5 ) . 'px' : round( $styles['size'] * 2 ) . 'px',
			'border-color'          => su_hex_shift( $atts['background'], 'lighter', 30 ),
			'border-radius'         => $radius,
			'-moz-border-radius'    => $radius,
			'-webkit-border-radius' => $radius,
			'text-shadow'           => $styles['ts_pos'] . ' 1px ' . $styles['ts_color'],
			'-moz-text-shadow'      => $styles['ts_pos'] . ' 1px ' . $styles['ts_color'],
			'-webkit-text-shadow'   => $styles['ts_pos'] . ' 1px ' . $styles['ts_color']
		);
		// CSS rules for <img> tag
		$img_rules = array(
			'width'  => round( $styles['size'] * 1.5 ) . 'px',
			'height' => round( $styles['size'] * 1.5 ) . 'px'
		);
		// CSS rules for <small> tag
		$small_rules = array(
			'padding-bottom' => round( ( $atts['size'] ) / 2 + 4 ) . 'px',
			'color' => $atts['color']
		);
		// Create style attr value for <a> tag
		foreach ( $a_rules as $a_rule => $a_value ) $a_css[] = $a_rule . ':' . $a_value;
		// Create style attr value for <span> tag
		foreach ( $span_rules as $span_rule => $span_value ) $span_css[] = $span_rule . ':' . $span_value;
		// Create style attr value for <img> tag
		foreach ( $img_rules as $img_rule => $img_value ) $img_css[] = $img_rule . ':' . $img_value;
		// Create style attr value for <img> tag
		foreach ( $small_rules as $small_rule => $small_value ) $small_css[] = $small_rule . ':' . $small_value;
		// Prepare button classes
		$classes = array( 'su-button', 'su-button-style-' . $atts['style'] );
		// Additional classes
		if ( $atts['class'] ) $classes[] = $atts['class'];
		// Wide class
		if ( $atts['wide'] === 'yes' ) $classes[] = 'su-button-wide';
		// Prepare icon
		$icon = ( $atts['icon'] ) ? '<img src="' . $atts['icon'] . '" alt="' . esc_attr( $content ) . '" style="' . implode( $img_css, ';' ) . '" />' : '';
		// Prepare <small> with description
		$desc = ( $atts['desc'] ) ? '<small style="' . implode( $small_css, ';' ) . '">' . su_scattr( $atts['desc'] ) . '</small>' : '';
		// Wrap with div if button centered
		if ( $atts['center'] === 'yes' ) {
			$before .= '<div class="su-button-center">';
			$after .= '</div>';
		}
		// Replace icon marker in content,
		// add float-icon class to rearrange margins
		if ( strpos( $content, '%icon%' ) !== false ) {
			$content = str_replace( '%icon%', $icon, $content );
			$classes[] = 'su-button-float-icon';
		}
		// Button text has no icon marker, append icon to begin of the text
		else $content = $icon . ' ' . $content;
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		return $before . '<a href="' . $atts['url'] . '" class="' . implode( $classes, ' ' ) . '" style="' . implode( $a_css, ';' ) . '" target="_' . $atts['target'] . '"><span style="' . implode( $span_css, ';' ) . '">' . $content . $desc . '</span></a>' . $after;
	}

	public static function service( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title' => __( 'Service title', 'su' ),
				'icon'  => plugins_url( 'assets/images/service.png', SU_PLUGIN_FILE ),
				'size'  => 32,
				'class' => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		return '<div class="su-service' . su_ecssc( $atts ) . '"><div class="su-service-title" style="padding:' . round( ( $atts['size'] - 16 ) / 2 ) . 'px 0 ' . round( ( $atts['size'] - 16 ) / 2 ) . 'px ' . ( $atts['size'] + 15 ) . 'px"><img src="' . su_scattr( $atts['icon'] ) . '" width="' . $atts['size'] . '" height="' . $atts['size'] . '" alt="' . $atts['title'] . '" /> ' . su_scattr( $atts['title'] ) . '</div><div class="su-service-content" style="padding:0 0 0 ' . ( $atts['size'] + 15 ) . 'px">' . do_shortcode( $content ) . '</div></div>';
	}

	public static function box( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'title'       => __( 'This is box title', 'su' ),
				'style'       => 'default',
				'box_color'   => '#333333',
				'title_color' => '#FFFFFF',
				'color'       => null, // 3.x
				'radius'      => '3',
				'class'       => ''
			), $atts );
		if ( $atts['color'] !== null ) $atts['box_color'] = $atts['color'];
		// Prepare border-radius
		$radius = ( $atts['radius'] != '0' ) ?
			'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] .
			'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		$title_radius = ( $atts['radius'] != '0' ) ? $atts['radius'] - 1 : '';
		$title_radius = ( $title_radius ) ?
			'-webkit-border-top-left-radius:' . $title_radius . 'px;-webkit-border-top-right-radius:' . $title_radius .
			'px;-moz-border-radius-topleft:' . $title_radius . 'px;-moz-border-radius-topright:' . $title_radius .
			'px;border-top-left-radius:' . $title_radius . 'px;border-top-right-radius:' . $title_radius . 'px;' : '';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		// Return result
		return
		'<div class="su-box su-box-style-' . $atts['style'] . su_ecssc( $atts ) . '" style="border-color:' .
			su_hex_shift( $atts['box_color'], 'darker', 20 ) . ';' . $radius .
			'"><div class="su-box-title" style="background-color:' . $atts['box_color'] . ';color:' .
			$atts['title_color'] . ';' . $title_radius . '">' . su_scattr( $atts['title'] ) . '</div><div class="su-box-content">' .
			su_do_shortcode( $content, 'b' ) . '</div></div>';
	}

	public static function note( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'note_color' => '#FFFF66',
				'text_color' => '#333333',
				'background' => null, // 3.x
				'color'      => null, // 3.x
				'radius'     => '3',
				'class'      => ''
			), $atts );
		if ( $atts['color'] !== null ) $atts['note_color'] = $atts['color'];
		if ( $atts['background'] !== null ) $atts['note_color'] = $atts['background'];
		// Prepare border-radius
		$radius = ( $atts['radius'] != '0' ) ? 'border-radius:' . $atts['radius'] . 'px;-moz-border-radius:' . $atts['radius'] . 'px;-webkit-border-radius:' . $atts['radius'] . 'px;' : '';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-box-shortcodes' );
		return '<div class="su-note' . su_ecssc( $atts ) . '" style="border-color:' . su_hex_shift( $atts['note_color'], 'darker', 10 ) . ';' . $radius . '"><div class="su-note-inner" style="background-color:' . $atts['note_color'] . ';border-color:' . su_hex_shift( $atts['note_color'], 'lighter', 80 ) . ';color:' . $atts['text_color'] . ';' . $radius . '">' . su_do_shortcode( $content, 'n' ) . '</div></div>';
	}

	public static function lightbox( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'src'   => 'http://www.youtube.com/watch?v=NbE8INOjTKM',
				'type'  => 'iframe',
				'class' => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'magnific-popup' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'magnific-popup' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-other-shortcodes' );
		return '<span class="su-lightbox' . su_ecssc( $atts ) . '" data-mfp-src="' . su_scattr( $atts['src'] ) . '" data-mfp-type="' . $atts['type'] . '">' . do_shortcode( $content ) . '</span>';
	}

	public static function tooltip( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'style'        => 'yellow',
				'position'     => 'north',
				'shadow'       => 'no',
				'rounded'      => 'no',
				'size'         => 'default',
				'title'        => '',
				'content'      => __( 'Tooltip text', 'su' ),
				'behavior'     => 'hover',
				'close'        => 'no',
				'class'        => ''
			), $atts );
		// Prepare style
		$atts['style'] = ( in_array( $atts['style'], array( 'light', 'dark', 'green', 'red', 'blue', 'youtube', 'tipsy', 'bootstrap', 'jtools', 'tipped', 'cluetip' ) ) ) ? $atts['style'] : 'plain';
		// Position
		$atts['position'] = str_replace( array( 'top', 'right', 'bottom', 'left' ), array( 'north', 'east', 'south', 'west' ), $atts['position'] );
		$position = array(
			'my' => str_replace( array( 'north', 'east', 'south', 'west' ), array( 'bottom center', 'center left', 'top center', 'center right' ), $atts['position'] ),
			'at' => str_replace( array( 'north', 'east', 'south', 'west' ), array( 'top center', 'center right', 'bottom center', 'center left' ), $atts['position'] )
		);
		// Prepare classes
		$classes = array( 'su-qtip qtip-' . $atts['style'] );
		$classes[] = 'su-qtip-size-' . $atts['size'];
		if ( $atts['shadow'] === 'yes' ) $classes[] = 'qtip-shadow';
		if ( $atts['rounded'] === 'yes' ) $classes[] = 'qtip-rounded';
		// Query assets
		Shortcodes_Ultimate_Assets::add( 'css', 'qtip' );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-other-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'qtip' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-other-shortcodes' );
		return '<span class="su-tooltip' . su_ecssc( $atts ) . '" data-close="' . $atts['close'] . '" data-behavior="' . $atts['behavior'] . '" data-my="' . $position['my'] . '" data-at="' . $position['at'] . '" data-classes="' . implode( ' ', $classes ) . '" data-title="' . $atts['title'] . '" title="' . esc_attr( $atts['content'] ) . '">' . do_shortcode( $content ) . '</span>';
	}

	public static function su_private( $atts = null, $content = null ) {
		$atts = shortcode_atts( array( 'class' => '' ), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-other-shortcodes' );
		return ( current_user_can( 'publish_posts' ) ) ? '<div class="su-private' . su_ecssc( $atts ) . '"><div class="su-private-shell">' . do_shortcode( $content ) . '</div></div>' : '';
	}

	public static function media( $atts = null, $content = null ) {
		// Check YouTube video
		if ( strpos( $atts['url'], 'youtu' ) !== false ) return su_youtube( $atts );
		// Check Vimeo video
		elseif ( strpos( $atts['url'], 'vimeo' ) !== false ) return su_vimeo( $atts );
		// Image
		else return '<img src="' . $atts['url'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" style="max-width:100%" />';
	}

	public static function youtube( $atts = null, $content = null ) {
		// Prepare data
		$return = array();
		$atts = shortcode_atts( array(
				'url'        => 'http://www.youtube.com/watch?v=NbE8INOjTKM',
				'width'      => 600,
				'height'     => 400,
				'autoplay'   => 'no',
				'responsive' => 'yes',
				'class'      => ''
			), $atts );
		$atts['url'] = su_scattr( $atts['url'] );
		$id = ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $atts['url'], $match ) ) ? $match[1] : false;
		// Check that url is specified
		if ( !$id ) return '<p class="su-error">YouTube: ' . __( 'please specify correct url', 'su' ) . '</p>';
		// Prepare autoplay
		$autoplay = ( $atts['autoplay'] === 'yes' ) ? '?autoplay=1' : '';
		// Create player
		$return[] = '<div class="su-youtube su-responsive-media-' . $atts['responsive'] . su_ecssc( $atts ) . '">';
		$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://www.youtube.com/embed/' . $id . $autoplay . '" frameborder="0" allowfullscreen="true"></iframe>';
		$return[] = '</div>';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-media-shortcodes' );
		// Return result
		return implode( '', $return );
	}

	public static function vimeo( $atts = null, $content = null ) {
		// Prepare data
		$return = array();
		$atts = shortcode_atts( array(
				'url'        => 'http://vimeo.com/21294655',
				'width'      => 600,
				'height'     => 400,
				'autoplay'   => 'no',
				'responsive' => 'yes',
				'class'      => ''
			), $atts );
		$atts['url'] = su_scattr( $atts['url'] );
		$id = ( preg_match( '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $atts['url'], $match ) ) ? $match[1] : false;
		// Check that url is specified
		if ( !$id ) return '<p class="su-error">Vimeo: ' . __( 'please specify correct url', 'su' ) . '</p>';
		// Prepare autoplay
		$autoplay = ( $atts['autoplay'] === 'yes' ) ? '&amp;autoplay=1' : '';
		// Create player
		$return[] = '<div class="su-vimeo su-responsive-media-' . $atts['responsive'] . su_ecssc( $atts ) . '">';
		$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] .
			'" src="http://player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff' .
			$autoplay . '" frameborder="0" allowfullscreen="true"></iframe>';
		$return[] = '</div>';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-media-shortcodes' );
		// Return result
		return implode( '', $return );
	}

	public static function screenr( $atts = null, $content = null ) {
		// Prepare data
		$return = array();
		$atts = shortcode_atts( array(
				'url'        => 'http://www.screenr.com/OuWH',
				'width'      => 600,
				'height'     => 400,
				'responsive' => 'yes',
				'class'      => ''
			), $atts );
		$atts['url'] = su_scattr( $atts['url'] );
		$id = ( preg_match( '~(?:<iframe [^>]*src=")?(?:https?:\/\/(?:[\w]+\.)*screenr\.com(?:[\/\w]*\/videos?)?\/([a-zA-Z0-9]+)[^\s]*)"?(?:[^>]*></iframe>)?(?:<p>.*</p>)?~ix', $atts['url'], $match ) ) ? $match[1] : false;
		// Check that url is specified
		if ( !$id ) return '<p class="su-error">Screenr: ' . __( 'please specify correct url', 'su' ) . '</p>';
		// Create player
		$return[] = '<div class="su-screenr su-responsive-media-' . $atts['responsive'] . su_ecssc( $atts ) . '">';
		$return[] = '<iframe width="' . $atts['width'] . '" height="' . $atts['height'] .
			'" src="http://screenr.com/embed/' . $id . '" frameborder="0" allowfullscreen="true"></iframe>';
		$return[] = '</div>';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-media-shortcodes' );
		// Return result
		return implode( '', $return );
	}

	public static function audio( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'      => 'http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3',
				'width'    => 'auto',
				'title'    => '',
				'autoplay' => 'no',
				'loop'     => 'no',
				'class'    => ''
			), $atts );
		$atts['url'] = su_scattr( $atts['url'] );
		// Generate unique ID
		$id = uniqid( 'su_audio_player_' );
		// Prepare width
		$width = ( $atts['width'] !== 'auto' ) ? 'max-width:' . $atts['width'] : '';
		// Check that url is specified
		if ( !$atts['url'] ) return '<p class="su-error">Audio: ' . __( 'please specify correct url', 'su' ) . '</p>';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-players-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jplayer' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-players-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-players-shortcodes' );
		// Create player
		return '<div class="su-audio' . su_ecssc( $atts ) . '" data-id="' . $id . '" data-audio="' . $atts['url'] . '" data-swf="' . plugins_url( 'assets/other/Jplayer.swf', SU_PLUGIN_FILE ) . '" data-autoplay="' . $atts['autoplay'] . '" data-loop="' . $atts['loop'] . '" style="' . $width . '"><div id="' . $id . '" class="jp-jplayer"></div><div id="' . $id . '_container" class="jp-audio"><div class="jp-type-single"><div class="jp-gui jp-interface"><div class="jp-controls"><span class="jp-play"></span><span class="jp-pause"></span><span class="jp-stop"></span><span class="jp-mute"></span><span class="jp-unmute"></span><span class="jp-volume-max"></span></div><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div><div class="jp-current-time"></div><div class="jp-duration"></div></div><div class="jp-title">' . $atts['title'] . '</div></div></div></div>';
	}

	public static function video( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'      => 'http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v',
				'poster'   => 'http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png',
				'title'    => '',
				'width'    => 600,
				'height'   => 300,
				'controls' => 'yes',
				'autoplay' => 'no',
				'loop'     => 'no',
				'class'    => ''
			), $atts );
		$atts['url'] = su_scattr( $atts['url'] );
		// Generate unique ID
		$id = uniqid( 'su_video_player_' );
		// Check that url is specified
		if ( !$atts['url'] ) return '<p class="su-error">Video: ' . __( 'please specify correct url', 'su' ) . '</p>';
		// Prepare title
		$title = ( $atts['title'] ) ? '<div class="jp-title">' . $atts['title'] . '</div>' : '';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-players-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jplayer' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-players-shortcodes' );
		// Create player
		return '<div style="width:' . $atts['width'] . 'px"><div id="' . $id . '" class="su-video jp-video su-video-controls-' . $atts['controls'] . su_ecssc( $atts ) . '" data-id="' . $id . '" data-video="' . $atts['url'] . '" data-swf="' . plugins_url( 'assets/other/Jplayer.swf', SU_PLUGIN_FILE ) . '" data-autoplay="' . $atts['autoplay'] . '" data-loop="' . $atts['loop'] . '" data-poster="' . $atts['poster'] . '"><div id="' . $id . '_player" class="jp-jplayer" style="width:' . $atts['width'] . 'px;height:' . $atts['height'] . 'px"></div>' . $title . '<div class="jp-start jp-play"></div><div class="jp-gui"><div class="jp-interface"><div class="jp-progress"><div class="jp-seek-bar"><div class="jp-play-bar"></div></div></div><div class="jp-current-time"></div><div class="jp-duration"></div><div class="jp-controls-holder"><span class="jp-play"></span><span class="jp-pause"></span><span class="jp-mute"></span><span class="jp-unmute"></span><span class="jp-full-screen"></span><span class="jp-restore-screen"></span><div class="jp-volume-bar"><div class="jp-volume-bar-value"></div></div></div></div></div></div></div>';
	}

	public static function table( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'   => false,
				'class' => ''
			), $atts );
		$return = '<div class="su-table' . su_ecssc( $atts ) . '">';
		$return .= ( $atts['url'] ) ? su_parse_csv( $atts['url'] ) : do_shortcode( $content );
		$return .= '</div>';
		Shortcodes_Ultimate_Assets::add( 'css', 'su-content-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-other-shortcodes' );
		return $return;
	}

	public static function permalink( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'id' => 1,
				'p' => null, // 3.x
				'target' => 'self',
				'class' => ''
			), $atts );
		if ( $atts['p'] !== null ) $atts['id'] = $atts['p'];
		$atts['id'] = su_scattr( $atts['id'] );
		// Prepare link text
		$text = ( $content ) ? $content : get_the_title( $atts['id'] );
		return '<a href="' . get_permalink( $atts['id'] ) . '" class="' . su_ecssc( $atts ) . '" title="' . $text . '" target="_' . $atts['target'] . '">' . $text . '</a>';
	}

	public static function members( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'message'    => __( 'This content is for registered users only. Please %login%.', 'su' ),
				'color'      => '#ffcc00',
				'style'      => null, // 3.x
				'login_text' => __( 'login', 'su' ),
				'login_url'  => wp_login_url(),
				'login'      => null, // 3.x
				'class'      => ''
			), $atts );
		if ( $atts['style'] !== null ) $atts['color'] = str_replace( array( '0', '1', '2' ), array( '#fff', '#FFFF29', '#1F9AFF' ), $atts['style'] );
		// Check feed
		if ( is_feed() ) return;
		// Check authorization
		if ( !is_user_logged_in() ) {
			if ( $atts['login'] !== null && $atts['login'] == '0' ) return; // 3.x
			// Prepare login link
			$login = '<a href="' . esc_attr( $atts['login_url'] ) . '">' . $atts['login_text'] . '</a>';
			Shortcodes_Ultimate_Assets::add( 'css', 'su-other-shortcodes' );
			return '<div class="su-members' . su_ecssc( $atts ) . '" style="background-color:' . su_hex_shift( $atts['color'], 'lighter', 50 ) . ';border-color:' .su_hex_shift( $atts['color'], 'darker', 20 ) . ';color:' .su_hex_shift( $atts['color'], 'darker', 60 ) . '">' . str_replace( '%login%', $login, su_scattr( $atts['message'] ) ) . '</div>';
		}
		// Return original content
		else return do_shortcode( $content );
	}

	public static function guests( $atts = null, $content = null ) {
		$atts = shortcode_atts( array( 'class' => '' ), $atts );
		$return = '';
		if ( !is_user_logged_in() && !is_null( $content ) ) {
			Shortcodes_Ultimate_Assets::add( 'css', 'su-other-shortcodes' );
			$return = '<div class="su-guests' . su_ecssc( $atts ) . '">' . do_shortcode( $content ) . '</div>';
		}
		return $return;
	}

	public static function feed( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'   => get_bloginfo_rss( 'rss2_url' ),
				'limit' => 3,
				'class' => ''
			), $atts );
		if ( !function_exists( 'wp_rss' ) ) include_once ABSPATH . WPINC . '/rss.php';
		ob_start();
		echo '<div class="su-feed' . su_ecssc( $atts ) . '">';
		wp_rss( $atts['url'], $atts['limit'] );
		echo '</div>';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}

	public static function subpages( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'depth' => 1,
				'p'     => false,
				'class' => ''
			), $atts );
		global $post;
		$child_of = ( $atts['p'] ) ? $atts['p'] : get_the_ID();
		$return = wp_list_pages( array(
				'title_li' => '',
				'echo' => 0,
				'child_of' => $child_of,
				'depth' => $atts['depth']
			) );
		return ( $return ) ? '<ul class="su-subpages' . su_ecssc( $atts ) . '">' . $return . '</ul>' : false;
	}

	public static function siblings( $atts = null, $content = null ) {
		$atts = shortcode_atts( array( 'depth' => 1, 'class' => '' ), $atts );
		global $post;
		$return = wp_list_pages( array( 'title_li' => '',
				'echo' => 0,
				'child_of' => $post->post_parent,
				'depth' => $atts['depth'],
				'exclude' => $post->ID ) );
		return ( $return ) ? '<ul class="su-siblings' . su_ecssc( $atts ) . '">' . $return . '</ul>' : false;
	}

	public static function menu( $atts = null, $content = null ) {
		$atts = shortcode_atts( array( 'name' => false, 'class' => '' ), $atts );
		$return = wp_nav_menu( array(
				'echo'        => false,
				'menu'        => $atts['name'],
				'container'   => false,
				'fallback_cb' => array( __CLASS__, 'menu_fb' ),
				'class'       => $atts['class']
				) );
		return ( $atts['name'] ) ? $return : false;
	}

	public static function menu_fb() {
		return __( 'This menu doesn\'t exists, or has no elements', 'su' );
	}

	public static function document( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'url'        => '',
				'file'       => null, // 3.x
				'width'      => 600,
				'height'     => 400,
				'responsive' => 'yes',
				'class'      => ''
			), $atts );
		if ( $atts['file'] !== null ) $atts['url'] = $atts['file'];
		Shortcodes_Ultimate_Assets::add( 'css', 'su-media-shortcodes' );
		return '<div class="su-document su-responsive-media-' . $atts['responsive'] . '"><iframe src="http://docs.google.com/viewer?embedded=true&url=' . $atts['url'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" class="su-document' . su_ecssc( $atts ) . '"></iframe></div>';
	}

	public static function gmap( $atts = null, $content = null ) {
		$atts = shortcode_atts( array(
				'width'      => 600,
				'height'     => 400,
				'responsive' => 'yes',
				'address'    => 'New York',
				'class'      => ''
			), $atts );
		Shortcodes_Ultimate_Assets::add( 'css', 'su-media-shortcodes' );
		return '<div class="su-gmap su-responsive-media-' . $atts['responsive'] . su_ecssc( $atts ) . '"><iframe width="' . $atts['width'] . '" height="' . $atts['height'] . '" src="http://maps.google.com/maps?q=' . urlencode( su_scattr( $atts['address'] ) ) . '&amp;output=embed"></iframe></div>';
	}

	public static function slider( $atts = null, $content = null ) {
		// Prepare vars
		$shult = shortcodes_ultimate();
		$return = '';
		$atts = shortcode_atts( array(
				'gallery'    => 1,
				'width'      => 600,
				'height'     => 300,
				'responsive' => 'yes',
				'title'      => 'yes',
				'centered'   => 'yes',
				'arrows'     => 'yes',
				'pages'      => 'yes',
				'mousewheel' => 'yes',
				'autoplay'   => 3000,
				'speed'      => 600,
				'target'     => 'yes',
				'class'      => ''
			), $atts );
		// Prepare unique ID
		$id = uniqid( 'su_slider_' );
		// Links target
		$target = ( $atts['target'] === 'yes' ) ? ' target="_blank"' : '';
		// Centered class
		$centered = ( $atts['centered'] === 'yes' ) ? ' su-slider-centered' : '';
		// Wheel control
		$mousewheel = ( $atts['mousewheel'] === 'yes' ) ? 'true' : 'false';
		// Prepare gallery
		$galleries = $shult->get_option( 'galleries' );
		$gallery = ( is_numeric( $atts['gallery'] ) && $atts['gallery'] > 0 ) ? $galleries[$atts['gallery'] - 1] : 1;
		// Prepare slides
		$slides = ( count( ( array ) $gallery['items'] ) ) ? $gallery['items'] : array();
		// Prepare width and height
		$size = ( $atts['responsive'] === 'yes' ) ? 'width:100%' : 'width:' . intval( $atts['width'] ) . 'px;height:' . intval( $atts['height'] ) . 'px';
		// Slides not found
		if ( !count( $slides ) || !is_array( $slides ) ) $return = '<p class="su-error">Slider: ' . __( 'images not found', 'su' ) . '</p>';
		// Slides are found
		else {
			// Open slider
			$return .= '<div id="' . $id . '" class="su-slider' . $centered . ' su-slider-pages-' . $atts['pages'] . ' su-slider-responsive-' . $atts['responsive'] . su_ecssc( $atts ) . '" style="' . $size . '" data-autoplay="' . $atts['autoplay'] . '" data-speed="' . $atts['speed'] . '" data-mousewheel="' . $mousewheel . '"><div class="su-slider-slides">';
			// Create slides
			foreach ( (array) $slides as $slide ) {
				// Crop the image
				$image = su_image_resize( $slide['image'], $atts['width'], $atts['height'] );
				// Prepare slide title
				$title = ( $atts['title'] === 'yes' && $slide['title'] ) ? '<span class="su-slider-slide-title">' . stripslashes( $slide['title'] ) . '</span>' : '';
				// Open slide
				$return .= '<div class="su-slider-slide">';
				// Slide content with link
				if ( $slide['link'] ) $return .= '<a href="' . $slide['link'] . '"' . $target . '><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
				// Slide content without link
				else $return .= '<a><img src="' . $slide['image'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
				// Close slide
				$return .= '</div>';
			}
			// Close slides
			$return .= '</div>';
			// Open nav section
			$return .= '<div class="su-slider-nav">';
			// Append direction nav
			if ( $atts['arrows'] === 'yes'
			) $return .= '<div class="su-slider-direction"><span class="su-slider-prev"></span><span class="su-slider-next"></span></div>';
			// Append pagination nav
			$return .= '<div class="su-slider-pagination"></div>';
			// Close nav section
			$return .= '</div>';
			// Close slider
			$return .= '</div>';
		}
		Shortcodes_Ultimate_Assets::add( 'css', 'su-galleries-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'swiper' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-galleries-shortcodes' );
		return $return;
	}

	public static function carousel( $atts = null, $content = null ) {
		// Prepare vars
		$shult = shortcodes_ultimate();
		$return = '';
		$atts = shortcode_atts( array(
				'gallery'    => 1,
				'width'      => 600,
				'height'     => 100,
				'responsive' => 'yes',
				'items'      => 3,
				'scroll'     => 1,
				'title'      => 'yes',
				'centered'   => 'yes',
				'arrows'     => 'yes',
				'pages'      => 'no',
				'mousewheel' => 'yes',
				'autoplay'   => 3000,
				'speed'      => 600,
				'target'     => 'yes',
				'class'      => ''
			), $atts );
		// Prepare unique ID
		$id = uniqid( 'su_carousel_' );
		// Links target
		$target = ( $atts['target'] === 'yes' ) ? ' target="_blank"' : '';
		// Centered class
		$centered = ( $atts['centered'] === 'yes' ) ? ' su-carousel-centered' : '';
		// Wheel control
		$mousewheel = ( $atts['mousewheel'] === 'yes' ) ? 'true' : 'false';
		// Prepare gallery
		$galleries = $shult->get_option( 'galleries' );
		$gallery = ( is_numeric( $atts['gallery'] ) && $atts['gallery'] > 0 ) ? $galleries[$atts['gallery'] - 1] : 1;
		// Prepare slides
		$slides = ( count( ( array ) $gallery['items'] ) ) ? $gallery['items'] : array();
		// Prepare width and height
		$size = ( $atts['responsive'] === 'yes' ) ? 'width:100%' : 'width:' . intval( $atts['width'] ) . 'px;height:' . intval( $atts['height'] ) . 'px';
		// Slides not found
		if ( !count( $slides ) || !is_array( $slides ) ) $return = '<p class="su-error">Carousel: ' . __( 'images not found', 'su' ) . '</p>';
		// Slides are found
		else {
			// Open slider
			$return .= '<div id="' . $id . '" class="su-carousel' . $centered . ' su-carousel-pages-' . $atts['pages'] . ' su-carousel-responsive-' . $atts['responsive'] . su_ecssc( $atts ) . '" style="' . $size . '" data-autoplay="' . $atts['autoplay'] . '" data-speed="' . $atts['speed'] . '" data-mousewheel="' . $mousewheel . '" data-items="' . $atts['items'] . '" data-scroll="' . $atts['scroll'] . '"><div class="su-carousel-slides">';
			// Create slides
			foreach ( (array) $slides as $slide ) {
				// Crop the image
				$image = su_image_resize( $slide['image'], round( $atts['width'] / $atts['items'] ), $atts['height'] );
				// Prepare slide title
				$title = ( $atts['title'] === 'yes' && $slide['title'] ) ? '<span class="su-carousel-slide-title">' . stripslashes( $slide['title'] ) . '</span>' : '';
				// Open slide
				$return .= '<div class="su-carousel-slide">';
				// Slide content with link
				if ( $slide['link'] ) $return .= '<a href="' . $slide['link'] . '"' . $target . '><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
				// Slide content without link
				else $return .= '<a><img src="' . $slide['image'] . '" alt="' . esc_attr( $slide['title'] ) . '" />' . $title . '</a>';
				// Close slide
				$return .= '</div>';
			}
			// Close slides
			$return .= '</div>';
			// Open nav section
			$return .= '<div class="su-carousel-nav">';
			// Append direction nav
			if ( $atts['arrows'] === 'yes'
			) $return .= '<div class="su-carousel-direction"><span class="su-carousel-prev"></span><span class="su-carousel-next"></span></div>';
			// Append pagination nav
			$return .= '<div class="su-carousel-pagination"></div>';
			// Close nav section
			$return .= '</div>';
			// Close slider
			$return .= '</div>';
		}
		Shortcodes_Ultimate_Assets::add( 'css', 'su-galleries-shortcodes' );
		Shortcodes_Ultimate_Assets::add( 'js', 'jquery' );
		Shortcodes_Ultimate_Assets::add( 'js', 'swiper' );
		Shortcodes_Ultimate_Assets::add( 'js', 'su-galleries-shortcodes' );
		return $return;
	}

	public static function custom_gallery( $atts = null, $content = null ) {
		// Prepare vars
		$shult = shortcodes_ultimate();
		$return = '';
		$atts = shortcode_atts( array(
				'gallery' => 1,
				'width'   => 90,
				'height'  => 90,
				'title'   => 'hover',
				'target'  => 'yes',
				'class'   => ''
			), $atts );
		// Links target
		$target = ( $atts['target'] === 'yes' ) ? ' target="_blank"' : '';
		// Prepare gallery
		$galleries = $shult->get_option( 'galleries' );
		$gallery = ( is_numeric( $atts['gallery'] ) && $atts['gallery'] > 0 ) ? $galleries[$atts['gallery'] - 1] : 1;
		// Prepare slides
		$slides = ( count( ( array ) $gallery['items'] ) ) ? $gallery['items'] : array();
		// Slides not found
		if ( !count( $slides ) || !is_array( $slides ) ) $return = '<p class="su-error">Custom gallery: ' . __( 'images not found', 'su' ) . '</p>';
		// Slides are found
		else {
			// Open gallery
			$return .= '<div class="su-custom-gallery su-custom-gallery-title-' . $atts['title'] . su_ecssc( $atts ) . '">';
			// Create slides
			foreach ( (array) $slides as $slide ) {
				// Crop image
				$image = su_image_resize( $slide['image'], $atts['width'], $atts['height'] );
				// Prepare slide title
				$title = ( $slide['title'] ) ? '<span class="su-custom-gallery-title">' . stripslashes( $slide['title'] ) . '</span>' : '';
				// Open slide
				$return .= '<div class="su-custom-gallery-slide">';
				// Slide content with link
				if ( $slide['link'] ) $return .= '<a href="' . $slide['link'] . '"' . $target . '><img src="' . $image['url'] . '" alt="' . esc_attr( $slide['title'] ) . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" />' . $title . '</a>';
				// Slide content without link
				else $return .= '<a><img src="' . $slide['image'] . '" alt="' . esc_attr( $slide['title'] ) . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" />' . $title . '</a>';
				// Close slide
				$return .= '</div>';
			}
			// Clear floats
			$return .= '<div class="su-clear"></div>';
			// Close gallery
			$return .= '</div>';
		}
		Shortcodes_Ultimate_Assets::add( 'css', 'su-galleries-shortcodes' );
		return $return;
	}

	public static function posts( $atts = null, $content = null ) {
		// Prepare error var
		$error = null;
		// Parse attributes
		$atts = shortcode_atts( array(
				'template'            => 'templates/default-loop.php',
				'id'                  => false,
				'posts_per_page'      => get_option( 'posts_per_page' ),
				'post_type'           => 'post',
				'taxonomy'            => 'category',
				'tax_term'            => false,
				'tax_operator'        => 'IN',
				'author'              => '',
				'meta_key'            => '',
				'offset'              => 0,
				'order'               => 'DESC',
				'orderby'             => 'date',
				'post_parent'         => false,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 'no'
			), $atts );

		$original_atts = $atts;

		$author = sanitize_text_field( $atts['author'] );
		$id = $atts['id']; // Sanitized later as an array of integers
		$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$meta_key = sanitize_text_field( $atts['meta_key'] );
		$offset = intval( $atts['offset'] );
		$order = sanitize_key( $atts['order'] );
		$orderby = sanitize_key( $atts['orderby'] );
		$post_parent = $atts['post_parent'];
		$post_status = $atts['post_status'];
		$post_type = sanitize_text_field( $atts['post_type'] );
		$posts_per_page = intval( $atts['posts_per_page'] );
		$tag = sanitize_text_field( $atts['tag'] );
		$tax_operator = $atts['tax_operator'];
		$tax_term = sanitize_text_field( $atts['tax_term'] );
		$taxonomy = sanitize_key( $atts['taxonomy'] );
		// Set up initial query for post
		$args = array(
			'category_name'  => '',
			'order'          => $order,
			'orderby'        => $orderby,
			'post_type'      => explode( ',', $post_type ),
			'posts_per_page' => $posts_per_page,
			'tag'            => $tag
			);
		// Ignore Sticky Posts
		if ( $ignore_sticky_posts ) $args['ignore_sticky_posts'] = true;
		// Meta key (for ordering)
		if ( !empty( $meta_key ) ) $args['meta_key'] = $meta_key;
		// If Post IDs
		if ( $id ) {
			$posts_in = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}
		// Post Author
		if ( !empty( $author ) ) $args['author_name'] = $author;
		// Offset
		if ( !empty( $offset ) ) $args['offset'] = $offset;
		// Post Status
		$post_status = explode( ', ', $post_status );
		$validated = array();
		$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) $validated[] = $unvalidated;
		}
		if ( !empty( $validated ) ) $args['post_status'] = $validated;
		// If taxonomy attributes, create a taxonomy query
		if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
			// Term string to array
			$tax_term = explode( ',', $tax_term );
			// Validate operator
			if ( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) $tax_operator = 'IN';
			$tax_args = array( 'tax_query' => array( array( 'taxonomy' => $taxonomy,
						'field' => 'slug',
						'terms' => $tax_term,
						'operator' => $tax_operator ) ) );
			// Check for multiple taxonomy queries
			$count = 2;
			$more_tax_queries = false;
			while ( isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
				isset( $original_atts['tax_' . $count . '_term'] ) &&
				!empty( $original_atts['tax_' . $count . '_term'] ) ) {
				// Sanitize values
				$more_tax_queries = true;
				$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
				$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . $count . '_term'] ) );
				$tax_operator = isset( $original_atts['tax_' . $count . '_operator'] ) ? $original_atts[
				'tax_' . $count . '_operator'] : 'IN';
				$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array( 'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $terms,
					'operator' => $tax_operator );
				$count++;
			}
			if ( $more_tax_queries ):
					$tax_relation = 'AND';
			if ( isset( $original_atts['tax_relation'] ) &&
				in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
			) $tax_relation = $original_atts['tax_relation'];
			$args['tax_query']['relation'] = $tax_relation;
			endif;
			$args = array_merge( $args, $tax_args );
		}

		// If post parent attribute, set up parent
		if ( $post_parent ) {
			if ( 'current' == $post_parent ) {
				global $post;
				$post_parent = $post->ID;
			}
			$args['post_parent'] = intval( $post_parent );
		}
		// Save original posts
		global $posts;
		$original_posts = $posts;
		// Query posts
		$posts = new WP_Query( $args );
		// Buffer output
		ob_start();
		// Search for template in stylesheet directory
		if ( file_exists( STYLESHEETPATH . '/' . $atts['template'] ) ) load_template( STYLESHEETPATH . '/' . $atts['template'], false );
		// Search for template in theme directory
		elseif ( file_exists( TEMPLATEPATH . '/' . $atts['template'] ) ) load_template( TEMPLATEPATH . '/' . $atts['template'], false );
		// Search for template in plugin directory
		elseif ( path_join( dirname( SU_PLUGIN_FILE ), $atts['template'] ) ) load_template( path_join( dirname( SU_PLUGIN_FILE ), $atts['template'] ), false );
		// Template not found
		else echo '<p class="su-error">Posts: ' . __( 'template not found', 'su' ) . '</p>';
		$output = ob_get_contents();
		ob_end_clean();
		// Return original posts
		$posts = $original_posts;
		// Reset the query
		wp_reset_postdata();
		Shortcodes_Ultimate_Assets::add( 'css', 'su-other-shortcodes' );
		return $output;
	}
}

new Shortcodes_Ultimate_Shortcodes;
