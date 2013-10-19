<?php
$upload_dir = wp_upload_dir();
$dir = new DirectoryIterator( $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'shortcodes-ultimate-skins' );
$option['options'] = array( 'default' );
foreach ( $dir as $fileinfo ) if ( $fileinfo->isDir() && !$fileinfo->isDot() ) $option['options'][] = $fileinfo->getFilename();
?>
<tr>
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
