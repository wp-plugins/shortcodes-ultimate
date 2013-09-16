<table class="widefat fixed su-table-demos">
	<thead>
		<tr>
			<th width="110"></th>
			<th width="180"><?php _e( 'Shortcode', $this->textdomain ); ?></th>
			<th><?php _e( 'Parameters', $this->textdomain ); ?></th>
			<th><?php _e( 'Example', $this->textdomain ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
foreach ( (array) Shortcodes_Ultimate_Data::shortcodes() as $id => $shortcode ) {
	$demo = ( isset( $shortcode['demo'] ) ) ? $shortcode['demo'] : $this->assets( 'images', 'demo' ) . '/' . $id . '.png';
?>
				<tr>
					<td>
						<a href="<?php echo $demo; ?>" class="su-preview" title="<?php echo $shortcode['name']; ?> <?php _e( 'Demo', $this->textdomain ); ?>"><img src="<?php echo $demo; ?>" alt="<?php echo $shortcode['name']; ?>" /></a>
					</td>
					<td>
						<h4><?php echo $shortcode['name']; ?></h4>
						<small><?php echo $shortcode['desc']; ?></small>
					</td>
					<td>
						<?php
	if ( count( $shortcode['atts'] ) )
		foreach ( $shortcode['atts'] as $aid => $attr ) {
			if ( !isset( $attr['type'] ) ) $attr['type'] = 'text';
			if ( !isset( $attr['default'] ) ) $attr['default'] = '';
?>
								<span class="su-cheatsheet-parameter">
									<strong><?php echo $attr['name']; ?></strong>
									<?php
			// Selects
			if ( $attr['type'] === 'select' && is_array( $attr['values'] ) && count( $attr['values'] ) ) {
				$is_numbers = is_numeric( implode( '', array_keys( $attr['values'] ) ) )
					? true : false;
				$values = ( $is_numbers ) ? implode( '|', array_values( $attr['values'] ) )
					: implode( '|', array_keys( $attr['values'] ) );
				echo $aid . '="' . $values . '"';
			}
			// Switch
			elseif ( $attr['type'] === 'switch' ) echo $aid . '="yes|no"';
			// Other fields - upload, color, text
			else echo $aid . '="' . $attr['default'] . '"';
?>
									<br />
									<?php
			if ( isset( $attr['default'] ) )
				echo __( 'Default value', $this->textdomain ) . ': ' . $attr['default'] . '<br />';
?>
								</span>
								<?php
		}
	else
		_e( '-- no parameters --', $this->textdomain );
?>
					</td>
					<td>
						<textarea disabled><?php echo str_replace( '<br/>', "\n", $shortcode['usage'] ); ?></textarea>
					</td>
				</tr>
				<?php
}
?>
	</tbody>
</table>
