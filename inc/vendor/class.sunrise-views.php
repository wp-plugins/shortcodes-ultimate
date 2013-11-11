<?php
if ( !class_exists( 'Sunrise3_Views' ) ) {
	class Sunrise3_Views {

		static $config = array();

		function __construct() {}

		public static function notice( $msg = '', $class = '' ) {
			return '<div class="sunrise-notice ' . $class . '"><p>' . $msg . '</p></div>';
		}

		public static function opentab( $field ) {
			return '<div class="sunrise-pane"><h3 class="hide-if-js sunrise-no-js-tab">' . $field['name'] . '</h3><table class="form-table">';
		}

		public static function closetab( $field, $config ) {
			$field = wp_parse_args( $field, array( 'actions' => true ) );
			$return = array();
			$return[] = '</table>';
			if ( $field['actions'] ) $return[] = '<div class="sunrise-actions-bar"><input type="submit" value="' . __( 'Save changes', $config['textdomain'] ) . '" class="sunrise-submit button-primary" /><span class="sunrise-spin"><img src="' . admin_url( 'images/wpspin_light.gif' ) . '" alt="" /> ' . __( 'Saving', $config['textdomain'] ) . '&hellip;</span><span class="sunrise-success-tip"><img src="' . admin_url( 'images/yes.png' ) . '" alt="" /> ' . __( 'Saved', $config['textdomain'] ) . '</span><a href="' . Sunrise3::get_page_url() . '&sunrise_action=reset" class="sunrise-reset button alignright" title="' . esc_attr( __( 'This action will delete all your settings. Are you sure? This action cannot be undone!', $config['textdomain'] ) ) . '">' . __( 'Restore default settings', $config['textdomain'] ) . '</a></div>';
			$return[] = '</div>';
			return implode( '', $return );
		}

		public static function text( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Text field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text" /><p class="description">' . $field['desc'] . '</p></td></tr>';
		}

		public static function textarea( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Textarea field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => '',
					'rows'  => 10,
					'cols'  => 30
				) );
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><textarea name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text widefat" cols="' . $field['cols'] . '" rows="' . $field['rows'] . '">' . stripslashes( get_option( $config['prefix'] . $field['id'] ) ) . '</textarea><p class="description">' . $field['desc'] . '</p></td></tr>';
		}

		public static function checkbox( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Checkbox', $config['textdomain'] ),
					'label' => __( 'Label', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			$checked = ( get_option( $config['prefix'] . $field['id'] ) === 'on' ) ? ' checked="checked"' : '';
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><label><input type="checkbox" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '"' . $checked . ' /> ' . $field['label'] . '</label><span class="description">' . $field['desc'] . '</span></td></tr>';
		}

		public static function checkbox_group( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'    => __( 'Checkbox', $config['textdomain'] ),
					'options' => array(),
					'id'      => '',
					'desc'    => ''
				) );
			$group = array();
			$value = (array) get_option( $config['prefix'] . $field['id'] );
			if ( is_array( $field['options'] ) ) foreach ( $field['options'] as $single ) {
				$checked = ( isset( $value[$single['id']] ) && $value[$single['id']] === 'on' ) ? ' checked="checked"' : '';
				$group[] = '<label for="sunrise-field-' . $field['id'] . '-' . $single['id'] . '"><input type="checkbox" name="sunrise[' . $field['id'] . '][' . $single['id'] . ']" id="sunrise-field-' . $field['id'] . '-' . $single['id'] . '"' . $checked . ' /> ' . $single['label'] . '</label><br/>';
			}
			return '<tr><th scope="row">' . $field['name'] . '</th><td class="sunrise-checkbox-group">' . implode( '', $group ) . '<span class="description">' . $field['desc'] . '</span></td></tr>';
		}

		public static function color( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Color picker', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			// DON'T PANIC about base64 code, this is just an image tag =)
			return '<tr><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><div class="sunrise-color-picker"><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text sunrise-color-picker-value" /><span class="sunrise-color-picker-wheel"></span> <a href="javascript:;" class="button sunrise-color-picker-button hide-if-no-js"><img alt="" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAArFJREFUeNqkU01PE1EUPUOn004/hpmmhH6AFA2KRojxIzFoooK4calLXbhyTeLeEFe69Qe4wJiwcKMLo8Yag9EEIgsS0VpKsdOZ0hbaaUtp6cx0vAOkgbjkJefNnXn3nHvefW8Yy7JwlMHa06uXDM566SUB1JbQwxcx7tpwjEJ1hKDRQju6bhg9SzrCcRfOFE2cxib8uGZN7gkckLshnQw8kG7eGREGJ45x7pCARhdaSr1ajacz5TfKbbPEvqDMz4cc7EeTbKz/Uezcs8tcwxSwvAwk54GyDy7vUKDnysVA9/mrx9ee/uw1FYfN+2jTuuzJ4hFmwsLUwPiTMY7PCdheBPyUE40AkSjg6gb+6OCqfmHg4fUxyxeaaoELdxy0grjLhm+NsJLuAyeTIq15g4DbDwgCUO8FPCKwLoH1+3zsBXOk9CV7l6jPdx0U3ZhgpUvBdSYFzSfCDBO5j6rHBggxctGHdjCCmiggX6aenJCCWWCi42BVx3DT7XcVoUCABNHhhSiK8HgiYLwBNBke2hag8UClDTQ5t2sV+nBHIGXAqaKKEizQblHZR4BzwcHzKDFExh7s79skloLh7AhQf9I/6iv9Tr/HWUCTPOyg104Es9vlMqGwA5QaQLUFqGrdSEBPd05BLiL+Vllo5Cj+CwN50lXhoBhYo+qqA8hTKZnsJ6l6PKU0MqjHOw6sFGYWpV/3gpFRPiREnQyRm1TdQ7BHkx4VEimS6VS9qifVtNLG5kzHAW1ebmmt6U9zHworWs3IkW6GyGu2A0KGkKXMlS3NWJifKxh6fZrOVj58E03MNjIb+Fp4/Th8ajvaN+TlRSnKQjdQKZaN7PdkQ32XUIy8TmRx9v+rbA/dnDWWc9/kxPv7spQdp0swiFrAtpHG7604sq0ZtGPyQQpz1N/5nwADAEUXDAYgnuAXAAAAAElFTkSuQmCC" /> ' . __( 'Pick a color', $config['textdomain'] ) . '</a></div><span class="description">' . $field['desc'] . '</span></td></tr>';
		}

		public static function media( $field, $config ) {
			$field = wp_parse_args( $field, array(
					'name'  => __( 'Text field', $config['textdomain'] ),
					'id'    => '',
					'desc'  => ''
				) );
			if ( function_exists( 'wp_enqueue_media' ) ) wp_enqueue_media();
			return '<tr class="sunrise-media"><th scope="row"><label for="sunrise-field-' . $field['id'] . '">' . $field['name'] . '</label></th><td><input type="text" value="' . get_option( $config['prefix'] . $field['id'] ) . '" name="sunrise[' . $field['id'] . ']" id="sunrise-field-' . $field['id'] . '" class="regular-text sunrise-media-value" /> <a href="javascript:;" class="button sunrise-media-button hide-if-no-js"><img src="' . admin_url( 'images/media-button.png' ) . '" alt="" /> ' . __( 'Media manager', $config['textdomain'] ) . '</a><p class="description">' . $field['desc'] . '</p></td></tr>';
		}
	}
}
