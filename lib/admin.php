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

		$checked_formatting = ( get_option( 'su_disable_custom_formatting' ) == 'on' ) ? ' checked="checked"' : '';
		$checked_compatibility = ( get_option( 'su_compatibility_mode' ) == 'on' ) ? ' checked="checked"' : '';
		?>

		<!-- .wrap -->
		<div class="wrap">

			<div id="icon-options-general" class="icon32"><br /></div>
			<h2><?php _e( 'Shortcodes Ultimate', 'shortcodes-ultimate' ); ?></h2>

			<!-- #su-wrapper -->
			<div id="su-wrapper">

				<?php su_save_notification(); ?>

				<div id="su-tabs">
					<a class="su-current"><span><?php _e( 'About', 'shortcodes-ultimate' ); ?></span></a>
					<a><span><?php _e( 'General settings', 'shortcodes-ultimate' ); ?></span></a>
					<a><span><?php _e( 'Custom CSS', 'shortcodes-ultimate' ); ?></span></a>
					<a><span><?php _e( 'Available shortcodes', 'shortcodes-ultimate' ); ?></span></a>
				</div>
				<div class="su-pane">

					<div class="su-onethird-column">
						<h3><?php _e( 'FREE Support', 'shortcodes-ultimate' ); ?></h3>
						<p><a href="http://wordpress.org/tags/shortcodes-ultimate?forum_id=10" target="_blank"><?php _e( 'Support forum', 'shortcodes-ultimate' ); ?></a></p>
						<p><a href="http://twitter.com/gn_themes" target="_blank"><?php _e( 'Twitter', 'shortcodes-ultimate' ); ?></a></p>
						<p><a href="http://ilovecode.ru/?p=163#commentform" target="_blank" style="color:red"><?php _e( 'Bug report', 'shortcodes-ultimate' ); ?></a></p>
					</div>

					<div class="su-twothird-column">
						<h3><?php _e( 'Do you love this plugin?', 'shortcodes-ultimate' ); ?></h3>
						<p><?php _e( 'Buy author a beer', 'shortcodes-ultimate' ); ?> - <a href="http://ilovecode.ru/donate/" target="_blank"><?php _e( 'Donate', 'shortcodes-ultimate' ); ?></a></p>
						<p><a href="http://wordpress.org/extend/plugins/shortcodes-ultimate/" target="_blank"><?php _e( 'Rate this plugin at wordpress.org', 'shortcodes-ultimate' ); ?></a> (<?php _e( '5 stars', 'shortcodes-ultimate' ); ?>)</p>
						<p><?php _e( 'Review this plugin in your blog', 'shortcodes-ultimate' ); ?></p>
					</div>

					<div class="su-clear"></div>
				</div>
				<div class="su-pane">
					<form action="" method="post" id="su-form-save-settings">
						<p class="su-message su-message-loading"><?php _e( 'Saving...', 'shortcodes-ultimate' ); ?></p>
						<p class="su-message su-message-success"><?php _e( 'Settings saved', 'shortcodes-ultimate' ); ?></p>
						<table class="fixed">
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
									<input type="submit" value="<?php _e( 'Save settings', 'shortcodes-ultimate' ); ?>" class="button-primary" />
									<input type="hidden" name="save" value="true" />
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div class="su-pane">
					<form action="" method="post" id="su-form-save-custom-css">
						<p class="su-message su-message-loading"><?php _e( 'Saving...', 'shortcodes-ultimate' ); ?></p>
						<p class="su-message su-message-success"><?php _e( 'Custom CSS saved', 'shortcodes-ultimate' ); ?></p>
						<p><?php _e( 'You can add custom styles, that will override defaults', 'shortcodes-ultimate' ); ?></p>
						<p><a href="<?php echo su_plugin_url(); ?>/css/style.css" target="_blank"><?php _e( 'See original styles', 'shortcodes-ultimate' ); ?></a></p>
						<p><textarea id="su-custom-css" name="su_custom_css"><?php echo get_option( 'su_custom_css' ); ?></textarea></p>
						<p>
							<input type="submit" value="<?php _e( 'Save styles', 'shortcodes-ultimate' ); ?>" class="button-primary" />
							<input type="hidden" name="save-css" value="true" />
						</p>
					</form>
				</div>
				<div class="su-pane">
					<table class="widefat fixed">
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
						<tr>
							<td>list</td>
							<td>style="star|arrow|check|cross|thumbs|link|gear|time|note|plus|guard|event|idea|settings|twitter"</td>
							<td>[list style="check"] &lt;ul&gt; &lt;li&gt; <?php _e( 'List item', 'shortcodes-ultimate' ); ?> &lt;/li&gt; &lt;/ul&gt; [/list]</td>
						</tr>
						<tr>
							<td>column</td>
							<td>size="1-2|1-3|1-4|1-5|1-6|2-3|3-4|2-5|3-5|4-5|5-6"<br/>last (<?php _e( 'add this to last columns', 'shortcodes-ultimate' ); ?>)</td>
							<td>[column size="1-2"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/column]<br/>[column size="1-2" last="1"] <?php _e( 'Content', 'shortcodes-ultimate' ); ?> [/column]</td>
						</tr>
						<tr>
							<td>table</td>
							<td>style="1|2|3"<br/>file (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)</td>
							<td><p><strong><?php _e( 'Plain table', 'shortcodes-ultimate' ); ?></strong><br/>[table style="1"] &lt;table&gt; &hellip; &lt;table&gt; [/table]</p><p><strong><?php _e( 'From CSV', 'shortcodes-ultimate' ); ?></strong><br/>[table style="1" file="http://example.com/file.csv"]  [/table]</p></td>
						</tr>
						<tr>
							<td>media</td>
							<td>url<br/>width<br/>height</td>
							<td>[media url="http://www.youtube.com/watch?v=2c2EEacfC1M"]<br/>[media url="http://vimeo.com/15069551"]<br/>[media url="video.mp4"]<br/>[media url="video.flv"]<br/>[media url="audio.mp3"]<br/>[media url="image.jpg"]</td>
						</tr>
						<tr class="su-new-shortcode">
							<td>nivo_slider</td>
							<td>width<br/>height<br/>link="file|attachment" (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)<br/>speed (1000 = <?php _e( '1 second', 'shortcodes-ultimate' ); ?>)<br/>delay (1000 = <?php _e( '1 second', 'shortcodes-ultimate' ); ?>)<br/>p - post ID (<?php _e( 'optional', 'shortcodes-ultimate' ); ?>)<br/>effect="random|boxRandom|fold|fade"</td>
							<td>[nivo_slider]<br/>[nivo_slider width="640" height="400" link="file" effect="boxRandom"]</td>
						</tr>
						<tr class="su-new-shortcode">
							<td>photoshop</td>
							<td>image (url)<br/>width<br/>height<br/>crop="0|1"<br/>quality="0-100"<br/>sharpen="0|1"<br/>filter="%filter_id%"<br/><a href="http://www.binarymoon.co.uk/demo/timthumb-filters/" target="_blank"><?php _e( 'See filter IDs', 'shortcodes-ultimate' ); ?></a></td>
							<td>[photoshop image="image.jpg" width="400" height="300" filter="2"]</td>
						</tr>
					</table>
				</div>
			</div>
			<!-- /#su-wrapper -->

		</div>
		<!-- /.wrap -->
		<?php
	}

	add_action( 'admin_menu', 'shortcodes_ultimate_add_admin' );
?>