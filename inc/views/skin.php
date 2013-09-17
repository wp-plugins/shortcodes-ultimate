<?php
	$upload_dir = wp_upload_dir();
	$kins_path = trailingslashit( path_join( $upload_dir['basedir'], 'shortcodes-ultimate-skins' ) );
	$option['options'] = array( 'default' );
	foreach ( glob( $kins_path . '*', GLOB_ONLYDIR ) as $dir ) {
		$option['options'][] = str_replace( $kins_path, '', $dir );
	}
	$trigger = ( $option['trigger'] ) ? ' data-trigger="true" data-trigger-type="select"' : '';
	$triggable = ( $option['triggable'] ) ?
		' data-triggable="' . $option['triggable'] . '" class="sunrise-plugin-triggable hide-if-js"' : '';
?>
<tr<?php echo $trigger, $triggable; ?>>
	<th scope="row">
		<label for="sunrise-plugin-field-<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label></th>
	<td>
		<select name="<?php echo $option['id']; ?>" id="sunrise-plugin-field-<?php echo $option['id']; ?>" class="sunrise-plugin-select">
			<?php
				foreach ( $option['options'] as $skin ) {
					$selected = ( $settings[$option['id']] == $skin ) ? ' selected="selected"' : '';
					?>
					<option value="<?php echo $skin; ?>"<?php echo $selected; ?>><?php echo $skin; ?></option>
				<?php
				}
			?>
		</select> <span class="description"><?php echo $option['desc']; ?></span>
	</td>
</tr>