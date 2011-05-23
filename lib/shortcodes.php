<?php

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
		extract( shortcode_atts( array(
				'style' => 1
				), $atts ) );

		$GLOBALS['tab_count'] = 0;

		do_shortcode( $content );

		if ( is_array( $GLOBALS['tabs'] ) ) {
			foreach ( $GLOBALS['tabs'] as $tab ) {
				$tabs[] = '<span>' . $tab['title'] . '</span>';
				$panes[] = '<div class="su-tabs-pane">' . $tab['content'] . '</div>';
			}
			$return = '<div class="su-tabs su-tabs-style-' . $style . '"><div class="su-tabs-nav">' . implode( '', $tabs ) . '</div><div class="su-tabs-panes">' . implode( "\n", $panes ) . '</div></div>';
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
				'title' => __( 'Spoiler title', 'shortcodes-ultimate' ),
				'style' => 0
				), $atts ) );

		return '<div class="su-spoiler su-spoiler-open su-spoiler-style-' . $style . '"><div class="su-spoiler-title">' . $title . '</div><div class="su-spoiler-content">' . do_shortcode( $content ) . '</div></div>';
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
				'last' => false,
				'style' => 0
				), $atts ) );

		return ( $last ) ? '<div class="su-column su-column-' . $size . ' su-column-last su-column-style-' . $style . '">' . do_shortcode( $content ) . '</div><div class="su-spacer"></div>' : '<div class="su-column su-column-' . $size . ' su-column-style-' . $style . '">' . do_shortcode( $content ) . '</div>';
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

		return '<div class="su-list su-list-style-' . $style . '">' . do_shortcode( $content ) . '</div>';
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
				'size' => 3,
				'icon' => false,
				'class' => 'su-button-class',
				'target' => false
				), $atts ) );

		$styles = array(
			'border_radius' => ( $square ) ? 0 : round( $size + 2 ),
			'dark_color' => su_hex_shift( $color, 'darker', 20 ),
			'light_color' => su_hex_shift( $color, 'lighter', 70 ),
			'size' => round( ( $size + 9 ) * 1.3 ),
			'text_color' => ( $dark ) ? su_hex_shift( $color, 'darker', 70 ) : su_hex_shift( $color, 'lighter', 90 ),
			'text_shadow' => ( $dark ) ? su_hex_shift( $color, 'lighter', 50 ) : su_hex_shift( $color, 'darker', 20 ),
			'text_shadow_position' => ( $dark ) ? '1px 1px' : '-1px -1px',
			'padding_v' => round( ( $size * 2 ) + 2 ),
			'padding_h' => round( ( ( $size * 3 ) + 10 ) )
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

		$img_styles = array(
			'margin' => '0 ' . round( $size * 0.7 ) . 'px -' . round( ( $size * 0.3 ) + 4 ) . 'px -' . round( $size * 0.8 ) . 'px',
			'height' => ( $styles['size'] + 4 ) . 'px'
		);

		foreach ( $link_styles as $link_rule => $link_value ) {
			$link_style .= $link_rule . ':' . $link_value . ';';
		}

		foreach ( $span_styles as $span_rule => $span_value ) {
			$span_style .= $span_rule . ':' . $span_value . ';';
		}

		foreach ( $img_styles as $img_rule => $img_value ) {
			$img_style .= $img_rule . ':' . $img_value . ';';
		}

		$icon_image = ( $icon ) ? '<img src="' . $icon . '" alt="' . htmlspecialchars( $content ) . '" style="' . $img_style . '" /> ' : '';

		$target = ( $target ) ? ' target="_' . $target . '"' : '';

		return '<a href="' . $link . '" class="su-button su-button-style-' . $style . ' ' . $class . '" style="' . $link_style . '"' . $target . '><span style="' . $span_style . '">' . $icon_image . $content . '</span></a>';
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
	 * Shortcode: media
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_media_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'url' => '',
				'width' => 600,
				'height' => 400
				), $atts ) );

		$return = '<div class="su-media">';
		$return .= ( $url ) ? su_get_media( $url, $width, $height ) : __( 'Please specify media url', 'shortcodes-ultimate' );
		$return .= '</div>';

		return $return;
	}

	/**
	 * Shortcode: table
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_table_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 1,
				'file' => false
				), $atts ) );

		$return = '<div class="su-table su-table-style-' . $style . '">';
		$return .= ( $file ) ? su_parse_csv( $file ) : do_shortcode( $content );
		$return .= '</div>';

		return $return;
	}

	/**
	 * Shortcode: photoshop
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_photoshop_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'image' => false,
				'width' => 200,
				'height' => 100,
				'crop' => 1,
				'quality' => 100,
				'filter' => 1,
				'sharpen' => 0
				), $atts ) );

		return '<img src="' . su_plugin_url() . '/lib/timthumb.php?src=' . $image . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;zc=' . $crop . '&amp;q=' . $quality . '&amp;f=' . $filter . '&amp;s=' . $sharpen . '" width="' . $width . '" height="' . $height . '" alt="" />';
	}

	/**
	 * Shortcode: nivo_slider
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_nivo_slider_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 600,
				'height' => 300,
				'link' => false,
				'effect' => 'random',
				'speed' => 600,
				'delay' => 3000,
				'p' => false
				), $atts ) );

		global $post;
		$post_id = ( $p ) ? $p : $post->ID;

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'order' => 'ASC',
			'post_status' => null,
			'post_parent' => $post_id
		);

		// Get attachments
		$attachments = get_posts( $args );

		// If has attachments
		if ( count( $attachments ) > 1 ) {

			$slider_id = uniqid( 'su-nivo-slider_' );

			$return = '
				<script type="text/javascript">
					jQuery(window).load(function() {
						jQuery("#' . $slider_id . '").nivoSlider({
							effect: "' . $effect . '",
							animSpeed: ' . $speed . ',
							pauseTime: ' . $delay . '
						});
					});
				</script>
			';

			$return .= '<div id="' . $slider_id . '" class="su-nivo-slider" style="width:' . $width . 'px;height:' . $height . 'px">';
			foreach ( $attachments as $attachment ) {
				$title = apply_filters( 'the_title', $attachment->post_title );
				$image = wp_get_attachment_image_src( $attachment->ID, 'full', false );

				// Link to file
				if ( $link == 'file' ) {
					$return .= '<a href="' . $image[0] . '" title="' . $title . '"><img src="' . su_plugin_url() . '/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></a>' . "\n";
				}

				// Link to attachment page
				elseif ( $link == 'attachment' ) {
					$return .= '<a href="' . get_permalink( $attachment->ID ) . '" title="' . $title . '"><img src="' . su_plugin_url() . '/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></a>' . "\n";
				}

				// Custom link
				elseif ( $link == 'caption' ) {
					if ( $attachment->post_excerpt ) {
						$return .= '<a href="' . $attachment->post_excerpt . '" title="' . $title . '"><img src="' . su_plugin_url() . '/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></a>' . "\n";
					} else {
						$return .= '<img src="' . su_plugin_url() . '/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" />' . "\n";
					}
				}

				// No link
				else {
					$return .= '<img src="' . su_plugin_url() . '/lib/timthumb.php?src=' . $image[0] . '&amp;w=' . $width . '&amp;h=' . $height . '&amp;q=100&amp;zc=1" width="' . $width . '" height="' . $height . '" alt="' . $title . '" />' . "\n";
				}
			}
			$return .= '</div>';
		}

		// No attachments
		else {
			$return = '<p class="su-error"><strong>Nivo slider:</strong> ' . __( 'no attached images, or only one attached image', 'shortcodes-ultimate' ) . '&hellip;</p>';
		}

		return $return;
	}

	/**
	 * Shortcode: permalink
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_permalink_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'p' => 1,
				'target' => ''
				), $atts ) );

		$text = ( $content ) ? $content : get_the_title( $p );
		$tgt = ( $target ) ? ' target="_' . $target . '"' : '';

		return '<a href="' . get_permalink( $p ) . '" title="' . $text . '"' . $tgt . '>' . $text . '</a>';
	}

	/**
	 * Shortcode: bloginfo
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_bloginfo_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'option' => 'name'
				), $atts ) );

		return get_bloginfo( $option );
	}

	/**
	 * Shortcode: subpages
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_subpages_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'depth' => 1
				), $atts ) );

		global $post;

		$return = wp_list_pages( array(
			'title_li' => '',
			'echo' => 0,
			'child_of' => get_the_ID(),
			'depth' => $depth
			) );

		return ( $return ) ? '<ul class="su-subpages">' . $return . '</ul>' : false;
	}

	/**
	 * Shortcode: siblings pages
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_siblings_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'depth' => 1
				), $atts ) );

		global $post;

		$return = wp_list_pages( array(
			'title_li' => '',
			'echo' => 0,
			'child_of' => $post->post_parent,
			'depth' => $depth,
			'exclude' => $post->ID
			) );

		return ( $return ) ? '<ul class="su-siblings">' . $return . '</ul>' : false;
	}

	/**
	 * Shortcode: menu
	 *
	 * @param string $content
	 * @return string Output html
	 */
	function su_menu_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'name' => 1
				), $atts ) );

		$return = wp_nav_menu( array(
			'echo' => false,
			'menu' => $name,
			'container' => false,
			'fallback_cb' => 'su_menu_shortcode_fb_cb'
			) );

		return ( $name ) ? $return : false;
	}

	/**
	 * Fallback callback function for menu shortcode
	 *
	 * @return string Text message
	 */
	function su_menu_shortcode_fb_cb() {
		return __( 'This menu doesn\'t exists, or has no elements', 'shortcodes-ultimate' );
	}

	/**
	 * Shortcode: document
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_document_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'width' => 600,
				'height' => 400,
				'file' => ''
				), $atts ) );

		return '<iframe src="http://docs.google.com/viewer?embedded=true&url=' . $file . '" width="' . $width . '" height="' . $height . '" class="su-document"></iframe>';
	}

	/**
	 * Shortcode: members
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_members_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'style' => 1
				), $atts ) );

		if ( is_user_logged_in() && !is_null( $content ) && !is_feed() ) {
			return do_shortcode( $content );
		} else {
			return '<div class="su-members su-members-style-' . $style . '"><span class="su-members-shell">' . __( 'This content is for members only.', 'shortcodes-ultimate' ) . ' <a href="' . wp_login_url() . '">' . __( 'Please login', 'shortcodes-ultimate' ) . '</a>.' . '</span></div>';
		}
	}

	/**
	 * Shortcode: feed
	 *
	 * @param array $atts Shortcode attributes
	 * @param string $content
	 * @return string Output html
	 */
	function su_feed_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'url' => get_bloginfo_rss( 'rss2_url' ),
				'limit' => 3
				), $atts ) );

		include_once( ABSPATH . WPINC . '/rss.php' );

		return '<div class="su-feed">' . wp_rss( $url, $limit ) . '</div>';
	}

?>