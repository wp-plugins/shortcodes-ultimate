<?php

/**
 * Csv files parser
 * Converts csv-files to html-tables
 *
 * @param type $file File url to parse
 */
function su_parse_csv( $file ) {
	$csv_lines = file( $file );
	if ( is_array( $csv_lines ) ) {
		$cnt = count( $csv_lines );
		for ( $i = 0; $i < $cnt; $i++ ) {
			$line = $csv_lines[$i];
			$line = trim( $line );
			$first_char = true;
			$col_num = 0;
			$length = strlen( $line );
			for ( $b = 0; $b < $length; $b++ ) {
				if ( $skip_char != true ) {
					$process = true;
					if ( $first_char == true ) {
						if ( $line[$b] == '"' ) {
							$terminator = '";';
							$process = false;
						}
						else
							$terminator = ';';
						$first_char = false;
					}
					if ( $line[$b] == '"' ) {
						$next_char = $line[$b + 1];
						if ( $next_char == '"' ) $skip_char = true;
						elseif ( $next_char == ';' ) {
							if ( $terminator == '";' ) {
								$first_char = true;
								$process = false;
								$skip_char = true;
							}
						}
					}
					if ( $process == true ) {
						if ( $line[$b] == ';' ) {
							if ( $terminator == ';' ) {
								$first_char = true;
								$process = false;
							}
						}
					}
					if ( $process == true ) $column .= $line[$b];
					if ( $b == ( $length - 1 ) ) $first_char = true;
					if ( $first_char == true ) {
						$values[$i][$col_num] = $column;
						$column = '';
						$col_num++;
					}
				}
				else
					$skip_char = false;
			}
		}
	}
	$return = '<table><tr>';
	foreach ( $values[0] as $value ) $return .= '<th>' . $value . '</th>';
	$return .= '</tr>';
	array_shift( $values );
	foreach ( $values as $rows ) {
		$return .= '<tr>';
		foreach ( $rows as $col ) {
			$return .= '<td>' . $col . '</td>';
		}
		$return .= '</tr>';
	}
	$return .= '</table>';
	return $return;
}

/**
 * Color shift a hex value by a specific percentage factor
 *
 * @param string $supplied_hex  Any valid hex value. Short forms e.g. #333 accepted.
 * @param string $shift_method  How to shift the value e.g( +,up,lighter,>)
 * @param integer $percentage   Percentage in range of [0-100] to shift provided hex value by
 *
 * @return string shifted hex value
 * @version 1.0 2008-03-28
 */
function su_hex_shift( $supplied_hex, $shift_method, $percentage = 50 ) {
	$shifted_hex_value = null;
	$valid_shift_option = false;
	$current_set = 1;
	$RGB_values = array();
	$valid_shift_up_args = array( 'up', '+', 'lighter', '>' );
	$valid_shift_down_args = array( 'down', '-', 'darker', '<' );
	$shift_method = strtolower( trim( $shift_method ) );
	// Check Factor
	if ( !is_numeric( $percentage ) || ( $percentage = ( int ) $percentage ) < 0 || $percentage > 100
	) trigger_error( "Invalid factor", E_USER_NOTICE );
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
	if ( !$valid_shift_option ) trigger_error( "Invalid shift method", E_USER_NOTICE );
	// Check Hex string
	switch ( strlen( $supplied_hex = ( str_replace( '#', '', trim( $supplied_hex ) ) ) ) ) {
		case 3:
			if ( preg_match( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', $supplied_hex ) ) {
				$supplied_hex = preg_replace( '/^([0-9a-f])([0-9a-f])([0-9a-f])/i', '\\1\\1\\2\\2\\3\\3',
				                              $supplied_hex );
			}
			else {
				trigger_error( "Invalid hex color value", E_USER_NOTICE );
			}
			break;
		case 6:
			if ( !preg_match( '/^[0-9a-f]{2}[0-9a-f]{2}[0-9a-f]{2}$/i', $supplied_hex ) ) {
				trigger_error( "Invalid hex color value", E_USER_NOTICE );
			}
			break;
		default:
			trigger_error( "Invalid hex color length", E_USER_NOTICE );
	}
	// Start shifting
	$RGB_values['R'] = hexdec( $supplied_hex{0} . $supplied_hex{1} );
	$RGB_values['G'] = hexdec( $supplied_hex{2} . $supplied_hex{3} );
	$RGB_values['B'] = hexdec( $supplied_hex{4} . $supplied_hex{5} );
	foreach ( $RGB_values as $c => $v ) {
		switch ( $shift_method ) {
			case '-':
				$amount = round( ( ( 255 - $v ) / 100 ) * $percentage ) + $v;
				break;
			case '+':
				$amount = $v - round( ( $v / 100 ) * $percentage );
				break;
			default:
				trigger_error( "Oops. Unexpected shift method", E_USER_NOTICE );
		}
		$shifted_hex_value .= $current_value = ( strlen( $decimal_to_hex = dechex( $amount ) ) < 2 ) ?
			'0' . $decimal_to_hex : $decimal_to_hex;
	}
	return '#' . $shifted_hex_value;
}

/**
 * Apply all custom formatting options of plugin
 */
function su_apply_formatting() {
	// Get plugin object
	global $shult;
	// Enable shortcodes in text widgets
	add_filter( 'widget_text', 'do_shortcode' );
	// Enable shortcodes in category descriptions
	add_filter( 'category_description', 'do_shortcode' );
	// Enable auto-formatting
	if ( $shult->get_option( 'custom_formatting' ) == 'on' ) {
		// Disable WordPress native content formatters
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_content', 'wptexturize' );
		// Apply custom formatter function
		add_filter( 'the_content', 'su_custom_formatter', 99 );
		add_filter( 'widget_text', 'su_custom_formatter', 99 );
		add_filter( 'category_description', 'su_custom_formatter', 99 );
	}
	// Fix for large posts, http://core.trac.wordpress.org/ticket/8553
	@ini_set( 'pcre.backtrack_limit', 500000 );
}

add_action( 'init', 'su_apply_formatting' );

/**
 * Custom formatter function
 *
 * @param string $content
 *
 * @return string Formatted content with clean shortcodes content
 */
function su_custom_formatter( $content ) {
	// Prepare variables
	$new_content = '';
	// Matches the contents and the open and closing tags
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	// Matches just the contents
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	// Divide content into pieces
	$pieces = preg_split( $pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE );
	// Loop over pieces
	foreach ( $pieces as $piece ) {
		// Look for presence of the shortcode, Append to content (no formatting)
		if ( preg_match( $pattern_contents, $piece, $matches ) ) $new_content .= $matches[1];
		// Format and append to content
		else $new_content .= wptexturize( wpautop( $piece ) );
	}
	// Return formatted content
	return $new_content;
}

/**
 * Custom do_shortcode function for nested shortcodes
 *
 * @param string $content Shortcode content
 * @param string $pre     First shortcode letter
 *
 * @return string Formatted content
 */
function su_do_shortcode( $content, $pre ) {
	if ( strpos( $content, '[_' ) !== false ) $content = preg_replace( '@(\[_*)_(' . $pre . '|/)@', "$1$2", $content );
	return do_shortcode( $content );
}

/**
 * Shortcode names prefix in compatibility mode
 *
 * @return string Special prefix
 */
function su_compatibility_mode_prefix() {
	$shult = shortcodes_ultimate();
	$option = get_option( 'su_compatibility_mode_prefix' );
	if ( $shult->get_option( 'compatibility_mode' ) === 'on' ) return ( $option ) ? $option : 'su_';
	else return '';
}

/**
 * Shortcut for su_compatibility_mode_prefix()
 */
function su_cmpt() {
	return su_compatibility_mode_prefix();
}

/**
 * Tweet relative time (like: 5 seconds ago)
 */
function su_rel_time( $original, $do_more = 0 ) {
	// array of time period chunks
	$chunks = array( array( 60 * 60 * 24 * 365, __( 'year', 'su' ) ),
	                 array( 60 * 60 * 24 * 30, __( 'month', 'su' ) ),
	                 array( 60 * 60 * 24 * 7, __( 'week', 'su' ) ),
	                 array( 60 * 60 * 24, __( 'day', 'su' ) ),
	                 array( 60 * 60, __( 'hour', 'su' ) ),
	                 array( 60, __( 'minute', 'su' ) ), );
	$today = time();
	$since = $today - $original;
	for ( $i = 0, $j = count( $chunks ); $i < $j; $i++ ) {
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		if ( ( $count = floor( $since / $seconds ) ) != 0 ) break;
	}
	$return = ( $count == 1 ) ? '1 ' . $name : "$count {$name}" . __( 's', 'su' );
	if ( $i + 1 < $j ) {
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];

		// add second item if it's greater than 0
		if ( ( ( $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2 ) ) != 0 ) && $do_more
		) $return .= ( $count2 == 1 ) ? ', 1 ' . $name2 : ", $count2 {$name2}" . __( 's', 'su' );
	}
	return $return;
}

/**
 * Add hyperlinks to tweets
 */
function su_parse_links( $text ) {
	// Props to Allen Shaw & webmancers.com
	// match protocol://address/path/file.extension?some=variable&another=asf%
	$text = preg_replace( '/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',
	                      "<a href=\"$1\" class=\"twitter-link\">$1</a>", $text );
	// match www.something.domain/path/file.extension?some=variable&another=asf%
	$text = preg_replace( '/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',
	                      "<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text );

	// match name@address
	$text = preg_replace( "/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i",
	                      "<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text );
	//mach #trendingtopics. Props to Michael Voigt
	$text = preg_replace( '/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i',
	                      "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ",
	                      $text );
	return $text;
}

/**
 * Get tweets by username
 */
function su_get_tweets( $username, $limit, $show_time ) {
	// Get tweets
	$tweets = json_decode( file_get_contents( 'https://api.twitter.com/1/statuses/user_timeline.json?screen_name=' .
	                                          $username . '&count=' . $limit ) );
	// No username
	if ( !$username ) {
		$return = __( 'username not specified', 'su' );
		$error = true;
	}
	// No messages
	if ( !count( $tweets ) ) {
		$return = __( 'no public messages', 'su' );
		$error = true;
	}
	// Loop tweets
	if ( count( $tweets ) ) foreach ( $tweets as $num => $tweet ) {
		// Prepare relative time
		$time = ( $show_time ) ?
			'<span class="su-tweet-time">' . su_rel_time( strtotime( $tweet->created_at ) ) . '</span>' : '';
		// Prepare last tweet class
		$last_tweet_class = ( $num == ( $limit - 1 ) ) ? ' su-tweet-last' : '';
		// Prepare markup
		$return = '<div class="su-tweet' . $last_tweet_class . '">';
		$return .=
			'<a href="http://twitter.com/' . $username . '" class="su-tweet-username">@' . $username . '</a>: ';
		$return .= su_parse_links( $tweet->text );
		$return .= $time;
		$return .= '</div>';
	}
	// Return results
	return ( $error ) ? '<p class="su-error"><strong>Tweets:</strong> ' . $return . '</p>' : $return;
}

function su_get_categories() {
	$cats = array();
	foreach ( ( array ) get_terms( 'category' ) as $cat ) {
		$cats[$cat->slug] = $cat->name;
	}
	return $cats;
}

function su_get_post_types() {
	$types = array();
	foreach ( ( array ) get_post_types( '', 'objects' ) as $cpt => $cpt_data ) {
		$types[$cpt] = $cpt_data->label;
	}
	return $types;
}

function su_get_users() {
	$users = array();
	foreach ( ( array ) get_users() as $user ) {
		$users[$user->ID] = $user->data->display_name;
	}
	return $users;
}

function su_get_taxonomies( $first = false ) {
	$taxes = array();
	foreach ( ( array ) get_taxonomies( '', 'objects' ) as $tax ) {
		$taxes[$tax->name] = $tax->label;
	}
	// Return only first taxonomy name
	if ( $first ) {
		reset( $taxes );
		return key( $taxes );
	}
	return $taxes;
}

function su_get_terms( $taxonomy ) {
	$terms = array();
	// Get the terms
	foreach ( ( array ) get_terms( $taxonomy, array( 'hide_empty' => false ) ) as $term ) {
		$terms[$term->slug] = $term->name;
	}
	return $terms;
}

/**
 * Extra CSS class helper
 *
 * @param array $atts Shortcode attributes
 *
 * @return string
 */
function su_ecssc( $atts ) {
	return ( $atts['class'] ) ? ' ' . trim( $atts['class'] ) : '';
}

/**
 *  Resizes an image and returns an array containing the resized URL, width, height and file type. Uses native Wordpress functionality.
 * 
 *  @author Matthew Ruddy (http://easinglider.com)
 *  @return array   An array containing the resized image URL, width, height and file type.
 */
function su_image_resize( $url, $width = NULL, $height = NULL, $crop = true, $retina = false ) {
	global $wp_version;

	//######################################################################
	//  First implementation
	//######################################################################
	if ( isset( $wp_version ) && version_compare( $wp_version, '3.5' ) >= 0 ) {

		global $wpdb;

		if ( empty( $url ) )
			return new WP_Error( 'no_image_url', 'No image URL has been entered.', $url );

		// Get default size from database
		$width = ( $width ) ? $width : get_option( 'thumbnail_size_w' );
		$height = ( $height ) ? $height : get_option( 'thumbnail_size_h' );

		// Allow for different retina sizes
		$retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

		// Get the image file path
		$file_path = parse_url( $url );
		$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

		// Check for Multisite
		if ( is_multisite() ) {
			global $blog_id;
			$blog_details = get_blog_details( $blog_id );
			$file_path = str_replace( $blog_details->path . 'files/', '/wp-content/blogs.dir/' . $blog_id . '/files/', $file_path );
		}

		// Destination width and height variables
		$dest_width = $width * $retina;
		$dest_height = $height * $retina;

		// File name suffix (appended to original file name)
		$suffix = "{$dest_width}x{$dest_height}";

		// Some additional info about the image
		$info = pathinfo( $file_path );
		$dir = $info['dirname'];
		$ext = $info['extension'];
		$name = wp_basename( $file_path, ".$ext" );

		// Suffix applied to filename
		$suffix = "{$dest_width}x{$dest_height}";

		// Get the destination file name
		$dest_file_name = "{$dir}/{$name}-{$suffix}.{$ext}";

		if ( !file_exists( $dest_file_name ) ) {

			/*
				 *  Bail if this image isn't in the Media Library.
				 *  We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate.
				 */
			$query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid='%s'", $url );
			$get_attachment = $wpdb->get_results( $query );
			if ( !$get_attachment )
				return array( 'url' => $url, 'width' => $width, 'height' => $height );

			// Load Wordpress Image Editor
			$editor = wp_get_image_editor( $file_path );
			if ( is_wp_error( $editor ) )
				return array( 'url' => $url, 'width' => $width, 'height' => $height );

			// Get the original image size
			$size = $editor->get_size();
			$orig_width = $size['width'];
			$orig_height = $size['height'];

			$src_x = $src_y = 0;
			$src_w = $orig_width;
			$src_h = $orig_height;

			if ( $crop ) {

				$cmp_x = $orig_width / $dest_width;
				$cmp_y = $orig_height / $dest_height;

				// Calculate x or y coordinate, and width or height of source
				if ( $cmp_x > $cmp_y ) {
					$src_w = round( $orig_width / $cmp_x * $cmp_y );
					$src_x = round( ( $orig_width - ( $orig_width / $cmp_x * $cmp_y ) ) / 2 );
				}
				else if ( $cmp_y > $cmp_x ) {
						$src_h = round( $orig_height / $cmp_y * $cmp_x );
						$src_y = round( ( $orig_height - ( $orig_height / $cmp_y * $cmp_x ) ) / 2 );
					}
			}

			// Time to crop the image!
			$editor->crop( $src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height );

			// Now let's save the image
			$saved = $editor->save( $dest_file_name );

			// Get resized image information
			$resized_url = str_replace( basename( $url ), basename( $saved['path'] ), $url );
			$resized_width = $saved['width'];
			$resized_height = $saved['height'];
			$resized_type = $saved['mime-type'];

			// Add the resized dimensions to original image metadata (so we can delete our resized images when the original image is delete from the Media Library)
			$metadata = wp_get_attachment_metadata( $get_attachment[0]->ID );
			if ( isset( $metadata['image_meta'] ) ) {
				$metadata['image_meta']['resized_images'][] = $resized_width . 'x' . $resized_height;
				wp_update_attachment_metadata( $get_attachment[0]->ID, $metadata );
			}

			// Create the image array
			$image_array = array(
				'url' => $resized_url,
				'width' => $resized_width,
				'height' => $resized_height,
				'type' => $resized_type
			);
		}
		else {
			$image_array = array(
				'url' => str_replace( basename( $url ), basename( $dest_file_name ), $url ),
				'width' => $dest_width,
				'height' => $dest_height,
				'type' => $ext
			);
		}

		// Return image array
		return $image_array;
	}

	//######################################################################
	//  Second implementation
	//######################################################################
	else {
		global $wpdb;

		if ( empty( $url ) )
			return new WP_Error( 'no_image_url', 'No image URL has been entered.', $url );

		// Bail if GD Library doesn't exist
		if ( !extension_loaded( 'gd' ) || !function_exists( 'gd_info' ) )
			return array( 'url' => $url, 'width' => $width, 'height' => $height );

		// Get default size from database
		$width = ( $width ) ? $width : get_option( 'thumbnail_size_w' );
		$height = ( $height ) ? $height : get_option( 'thumbnail_size_h' );

		// Allow for different retina sizes
		$retina = $retina ? ( $retina === true ? 2 : $retina ) : 1;

		// Destination width and height variables
		$dest_width = $width * $retina;
		$dest_height = $height * $retina;

		// Get image file path
		$file_path = parse_url( $url );
		$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];

		// Check for Multisite
		if ( is_multisite() ) {
			global $blog_id;
			$blog_details = get_blog_details( $blog_id );
			$file_path = str_replace( $blog_details->path . 'files/', '/wp-content/blogs.dir/' . $blog_id . '/files/', $file_path );
		}

		// Some additional info about the image
		$info = pathinfo( $file_path );
		$dir = $info['dirname'];
		$ext = $info['extension'];
		$name = wp_basename( $file_path, ".$ext" );

		// Suffix applied to filename
		$suffix = "{$dest_width}x{$dest_height}";

		// Get the destination file name
		$dest_file_name = "{$dir}/{$name}-{$suffix}.{$ext}";

		// No need to resize & create a new image if it already exists!
		if ( !file_exists( $dest_file_name ) ) {

			/*
				 *  Bail if this image isn't in the Media Library either.
				 *  We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate.
				 */
			$query = $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid='%s'", $url );
			$get_attachment = $wpdb->get_results( $query );
			if ( !$get_attachment )
				return array( 'url' => $url, 'width' => $width, 'height' => $height );

			$image = wp_load_image( $file_path );
			if ( !is_resource( $image ) )
				return new WP_Error( 'error_loading_image_as_resource', $image, $file_path );

			// Get the current image dimensions and type
			$size = @getimagesize( $file_path );
			if ( !$size )
				return new WP_Error( 'file_path_getimagesize_failed', 'Failed to get $file_path information using getimagesize.' );
			list( $orig_width, $orig_height, $orig_type ) = $size;

			// Create new image
			$new_image = wp_imagecreatetruecolor( $dest_width, $dest_height );

			// Do some proportional cropping if enabled
			if ( $crop ) {

				$src_x = $src_y = 0;
				$src_w = $orig_width;
				$src_h = $orig_height;

				$cmp_x = $orig_width / $dest_width;
				$cmp_y = $orig_height / $dest_height;

				// Calculate x or y coordinate, and width or height of source
				if ( $cmp_x > $cmp_y ) {
					$src_w = round( $orig_width / $cmp_x * $cmp_y );
					$src_x = round( ( $orig_width - ( $orig_width / $cmp_x * $cmp_y ) ) / 2 );
				}
				else if ( $cmp_y > $cmp_x ) {
						$src_h = round( $orig_height / $cmp_y * $cmp_x );
						$src_y = round( ( $orig_height - ( $orig_height / $cmp_y * $cmp_x ) ) / 2 );
					}

				// Create the resampled image
				imagecopyresampled( $new_image, $image, 0, 0, $src_x, $src_y, $dest_width, $dest_height, $src_w, $src_h );
			}
			else
				imagecopyresampled( $new_image, $image, 0, 0, 0, 0, $dest_width, $dest_height, $orig_width, $orig_height );

			// Convert from full colors to index colors, like original PNG.
			if ( IMAGETYPE_PNG == $orig_type && function_exists( 'imageistruecolor' ) && !imageistruecolor( $image ) )
				imagetruecolortopalette( $new_image, false, imagecolorstotal( $image ) );

			// Remove the original image from memory (no longer needed)
			imagedestroy( $image );

			// Check the image is the correct file type
			if ( IMAGETYPE_GIF == $orig_type ) {
				if ( !imagegif( $new_image, $dest_file_name ) )
					return new WP_Error( 'resize_path_invalid', 'Resize path invalid (GIF)' );
			}
			elseif ( IMAGETYPE_PNG == $orig_type ) {
				if ( !imagepng( $new_image, $dest_file_name ) )
					return new WP_Error( 'resize_path_invalid', 'Resize path invalid (PNG).' );
			}
			else {

				// All other formats are converted to jpg
				if ( 'jpg' != $ext && 'jpeg' != $ext )
					$dest_file_name = "{$dir}/{$name}-{$suffix}.jpg";
				if ( !imagejpeg( $new_image, $dest_file_name, apply_filters( 'resize_jpeg_quality', 90 ) ) )
					return new WP_Error( 'resize_path_invalid', 'Resize path invalid (JPG).' );
			}

			// Remove new image from memory (no longer needed as well)
			imagedestroy( $new_image );

			// Set correct file permissions
			$stat = stat( dirname( $dest_file_name ) );
			$perms = $stat['mode'] & 0000666;
			@chmod( $dest_file_name, $perms );

			// Get some information about the resized image
			$new_size = @getimagesize( $dest_file_name );
			if ( !$new_size )
				return new WP_Error( 'resize_path_getimagesize_failed', 'Failed to get $dest_file_name (resized image) info via @getimagesize', $dest_file_name );
			list( $resized_width, $resized_height, $resized_type ) = $new_size;

			// Get the new image URL
			$resized_url = str_replace( basename( $url ), basename( $dest_file_name ), $url );

			// Add the resized dimensions to original image metadata (so we can delete our resized images when the original image is delete from the Media Library)
			$metadata = wp_get_attachment_metadata( $get_attachment[0]->ID );
			if ( isset( $metadata['image_meta'] ) ) {
				$metadata['image_meta']['resized_images'][] = $resized_width . 'x' . $resized_height;
				wp_update_attachment_metadata( $get_attachment[0]->ID, $metadata );
			}

			// Return array with resized image information
			$image_array = array(
				'url' => $resized_url,
				'width' => $resized_width,
				'height' => $resized_height,
				'type' => $resized_type
			);
		}
		else {
			$image_array = array(
				'url' => str_replace( basename( $url ), basename( $dest_file_name ), $url ),
				'width' => $dest_width,
				'height' => $dest_height,
				'type' => $ext
			);
		}

		return $image_array;
	}
}

/**
 *  Deletes the resized images when the original image is deleted from the Wordpress Media Library.
 *
 *  @author Matthew Ruddy
 */
function su_delete_resized_images( $post_id ) {

	// Get attachment image metadata
	$metadata = wp_get_attachment_metadata( $post_id );
	if ( !$metadata )
		return;

	// Do some bailing if we cannot continue
	if ( !isset( $metadata['file'] ) || !isset( $metadata['image_meta']['resized_images'] ) )
		return;
	$pathinfo = pathinfo( $metadata['file'] );
	$resized_images = $metadata['image_meta']['resized_images'];

	// Get Wordpress uploads directory (and bail if it doesn't exist)
	$wp_upload_dir = wp_upload_dir();
	$upload_dir = $wp_upload_dir['basedir'];
	if ( !is_dir( $upload_dir ) )
		return;

	// Delete the resized images
	foreach ( $resized_images as $dims ) {

		// Get the resized images filename
		$file = $upload_dir . '/' . $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-' . $dims . '.' . $pathinfo['extension'];

		// Delete the resized image
		@unlink( $file );
	}
}

add_action( 'delete_attachment', 'su_delete_resized_images' );

class Shortcodes_Ultimate_Tools {
	function __construct() {}
	public static function decode_shortcode( $value ) {
		return do_shortcode( str_replace( array( '{', '}' ), array( '[', ']' ), $value ) );
	}

	public static function icon( $src = 'icon-file' ) {
		return ( strpos( $src, '/' ) !== false ) ? '<img src="' . $src . '" alt="" />' : '<i class="' . $src . '"></i>';
	}
}

/**
 * Just a shortcut for Shortcodes_Ultimate_Tools::decode_shortcode()
 */
function su_scattr( $value ) {
	return Shortcodes_Ultimate_Tools::decode_shortcode( $value );
}
