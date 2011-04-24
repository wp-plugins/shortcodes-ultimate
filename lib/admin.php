<?php

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
			update_option( 'su_compatibility_mode', $_POST['su_compatibility_mode'] );
			echo '<div class="updated"><p><strong>' . __( 'Settings saved', 'shortcodes-ultimate' ) . '</strong></p></div>';
		}

		$checked_formatting = ( get_option( 'su_disable_custom_formatting' ) == 'on' ) ? ' checked="checked"' : '';
		$checked_compatibility = ( get_option( 'su_compatibility_mode' ) == 'on' ) ? ' checked="checked"' : '';
		?>
		<!-- .wrap -->
		<div class="wrap">
			<h2><?php _e( 'Shortcodes ultimate settings', 'shortcodes-ultimate' ); ?></h2>
			<form action="" method="post">
				<table class="widefat fixed" style="width:700px;margin-bottom:20px">
					<tr>
						<td>
							<p><label><input type="checkbox" name="su_disable_custom_formatting" <?php echo $checked_formatting; ?> /> <?php _e( 'Disable custom formatting', 'shortcodes-ultimate' ); ?></label></p>
						</td>
						<td>
							<p><small><?php _e( 'Enable this option if you have some problems with other plugins or content formatting', 'shortcodes-ultimate' ); ?></small></p>
						</td>
					</tr>
					<tr>
						<td>
							<p><label><input type="checkbox" name="su_compatibility_mode" <?php echo $checked_compatibility; ?> /> <?php _e( 'Compatibility mode', 'shortcodes-ultimate' ); ?></label></p>
						</td>
						<td>
							<p><small><?php _e( 'Enable this option if you have some problems with other plugins that uses similar shortcode names', 'shortcodes-ultimate' ); ?><br/><code>[button] => [gn_button]</code></small></p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p><input type="submit" value="<?php _e( 'Save settings', 'shortcodes-ultimate' ); ?>" class="button-primary" /></p>
							<input type="hidden" name="save" value="true" />
						</td>
					</tr>
				</table>
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
				<tr class="su-new-shortcode">
					<td>button</td>
					<td>link<br/>color="#HEX"<br/>size="1-12"<br/>style="1|2|3|4"<br/>dark (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)<br/>square (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)<br/>icon (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)</td>
					<td>[button link="#" color="#b00" size="3" style="3" dark="1" square="1" icon="image.png"] <?php _e( 'Button text', 'shortcodes-ultimate' ); ?> [/button]</td>
				</tr>
				<tr>
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
				<tr class="su-new-shortcode">
					<td>list</td>
					<td>style="star|arrow|check|cross|thumbs|link|gear|time|note|plus|guard|event|idea|settings|twitter"</td>
					<td>[list style="check"] &lt;ul&gt; &lt;li&gt; <?php _e( 'List item', 'shortcodes-ultimate' ); ?> &lt;/li&gt; &lt;/ul&gt; [/list]</td>
				</tr>
				<tr>
					<td>column</td>
					<td>size="1-2|1-3|1-4|1-5|1-6|2-3|3-4|2-5|3-5|4-5|5-6"<br/>last (<?php _e( 'add this to last columns', 'shortcodes-ultimate' ); ?>)</td>
					<td>[column size="1-2"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/column]<br/>[column size="1-2" last="1"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/column]</td>
				</tr>
				<tr class="su-new-shortcode">
					<td>table</td>
					<td>style="1|2|3"<br/>file (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)</td>
					<td><p><strong><?php _e( 'Plain table', 'shortcodes-ultimate' ); ?></strong><br/>[table style="1"] &lt;table&gt; &hellip; &lt;table&gt; [/table]</p><p><strong><?php _e( 'From CSV', 'shortcodes-ultimate' ); ?></strong><br/>[table file=http://example.com/file.csv]  [/table]</p></td>
				</tr>
				<tr class="su-new-shortcode">
					<td>media</td>
					<td>url<br/>width<br/>height</td>
					<td>[media url="http://www.youtube.com/watch?v=2c2EEacfC1M"]<br/>[media url="http://vimeo.com/15069551"]<br/>[media url="video.mp4"]<br/>[media url="video.flv"]<br/>[media url="audio.mp3"]<br/>[media url="image.jpg"]</td>
				</tr>
			</table>
		</div>
		<!-- /.wrap -->
		<?php
	}

	add_action( 'admin_menu', 'shortcodes_ultimate_add_admin' );
?>