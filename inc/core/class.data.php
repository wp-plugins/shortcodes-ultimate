<?php
/**
 * Class for managing plugin data
 */
class Shortcodes_Ultimate_Data {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'init', array( __CLASS__, 'register' ) );
	}

	/**
	 * Register shortcodes
	 */
	public static function register() {
		// Loop through shortcodes
		foreach ( ( array ) self::shortcodes() as $id => $data ) {
			unset( $func );
			if ( isset( $data['function'] ) ) $func = $data['function'];
			elseif ( method_exists( 'Shortcodes_Ultimate_Shortcodes', $id ) ) $func = array( 'Shortcodes_Ultimate_Shortcodes', $id );
			elseif ( method_exists( 'Shortcodes_Ultimate_Shortcodes', 'su_' . $id ) ) $func = array( 'Shortcodes_Ultimate_Shortcodes', 'su_' . $id );
			// Register shortcode
			if ( isset( $func ) ) add_shortcode( su_cmpt() . $id, $func );
		}
		// Register [media] manually // 3.x
		add_shortcode( su_cmpt() . 'media', array( 'Shortcodes_Ultimate_Shortcodes', 'media' ) );
	}

	/**
	 * Shortcode groups
	 */
	public static function groups() {
		return ( array ) apply_filters( 'su/data/groups', array(
				'all'     => __( 'All', 'su' ),
				'content' => __( 'Content', 'su' ),
				'box'     => __( 'Box', 'su' ),
				'media'   => __( 'Media', 'su' ),
				'gallery' => __( 'Gallery', 'su' ),
				'other'   => __( 'Other', 'su' )
			) );
	}

	public static function icons() {
		return apply_filters( 'su/data/icons', array( 'adjust', 'anchor', 'archive', 'asterisk', 'ban-circle', 'bar-chart', 'barcode', 'beaker', 'beer', 'bell', 'bell-alt', 'bolt', 'book', 'bookmark', 'bookmark-empty', 'briefcase', 'bug', 'building', 'bullhorn', 'bullseye', 'calendar', 'calendar-empty', 'camera', 'camera-retro', 'certificate', 'check', 'check-empty', 'check-minus', 'check-sign', 'circle', 'circle-blank', 'cloud', 'cloud-download', 'cloud-upload', 'code', 'code-fork', 'coffee', 'cog', 'cogs', 'collapse', 'collapse-alt', 'collapse-top', 'comment', 'comment-alt', 'comments', 'comments-alt', 'compass', 'credit-card', 'crop', 'dashboard', 'desktop', 'download', 'download-alt', 'edit', 'edit-sign', 'ellipsis-horizontal', 'ellipsis-vertical', 'envelope', 'envelope-alt', 'eraser', 'exchange', 'exclamation', 'exclamation-sign', 'expand', 'expand-alt', 'external-link', 'external-link-sign', 'eye-close', 'eye-open', 'facetime-video', 'female', 'fighter-jet', 'film', 'filter', 'fire', 'fire-extinguisher', 'flag', 'flag-alt', 'flag-checkered', 'folder-close', 'folder-close-alt', 'folder-open', 'folder-open-alt', 'food', 'frown', 'gamepad', 'cog', 'cogs', 'gift', 'glass', 'globe', 'group', 'hdd', 'headphones', 'heart', 'heart-empty', 'home', 'inbox', 'info', 'info-sign', 'key', 'keyboard', 'laptop', 'leaf', 'legal', 'lemon', 'level-down', 'level-up', 'lightbulb', 'location-arrow', 'lock', 'magic', 'magnet', 'share-alt', 'reply', 'mail-reply-all', 'male', 'map-marker', 'meh', 'microphone', 'microphone-off', 'minus', 'minus-sign', 'minus-sign-alt', 'mobile-phone', 'money', 'moon', 'move', 'music', 'off', 'ok', 'ok-circle', 'ok-sign', 'pencil', 'phone', 'phone-sign', 'picture', 'plane', 'plus', 'plus-sign', 'plus-sign-alt', 'off', 'print', 'pushpin', 'puzzle-piece', 'qrcode', 'question', 'question-sign', 'quote-left', 'quote-right', 'random', 'refresh', 'remove', 'remove-circle', 'remove-sign', 'reorder', 'reply', 'reply-all', 'resize-horizontal', 'resize-vertical', 'retweet', 'road', 'rocket', 'rss', 'rss-sign', 'screenshot', 'search', 'share', 'share-alt', 'share-sign', 'shield', 'shopping-cart', 'sign-blank', 'signal', 'signin', 'signout', 'sitemap', 'smile', 'sort', 'sort-by-alphabet', 'sort-by-alphabet-alt', 'sort-by-attributes', 'sort-by-attributes-alt', 'sort-by-order', 'sort-by-order-alt', 'sort-down', 'sort-up', 'spinner', 'star', 'star-empty', 'star-half', 'star-half-empty', 'star-half-empty', 'subscript', 'suitcase', 'sun', 'superscript', 'tablet', 'tag', 'tags', 'tasks', 'terminal', 'thumbs-down', 'thumbs-down-alt', 'thumbs-up', 'thumbs-up-alt', 'ticket', 'time', 'tint', 'trash', 'trophy', 'truck', 'umbrella', 'check-empty', 'unlock', 'unlock-alt', 'upload', 'upload-alt', 'user', 'volume-down', 'volume-off', 'volume-up', 'warning-sign', 'wrench', 'zoom-in', 'zoom-out', 'angle-down', 'angle-left', 'angle-right', 'angle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'caret-down', 'caret-left', 'caret-right', 'caret-up', 'chevron-down', 'chevron-left', 'chevron-right', 'chevron-sign-down', 'chevron-sign-left', 'chevron-sign-right', 'chevron-sign-up', 'chevron-up', 'circle-arrow-down', 'circle-arrow-left', 'circle-arrow-right', 'circle-arrow-up', 'double-angle-down', 'double-angle-left', 'double-angle-right', 'double-angle-up', 'hand-down', 'hand-left', 'hand-right', 'hand-up', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'backward', 'eject', 'fast-backward', 'fast-forward', 'forward', 'fullscreen', 'pause', 'play', 'play-circle', 'play-sign', 'resize-full', 'resize-small', 'step-backward', 'step-forward', 'stop', 'youtube-play', 'adn', 'android', 'apple', 'bitbucket', 'bitbucket-sign', 'btc', 'btc', 'css3', 'dribbble', 'dropbox', 'facebook', 'facebook-sign', 'flickr', 'foursquare', 'github', 'github-alt', 'github-sign', 'gittip', 'google-plus', 'google-plus-sign', 'html5', 'instagram', 'linkedin', 'linkedin-sign', 'linux', 'maxcdn', 'pinterest', 'pinterest-sign', 'renren', 'skype', 'stackexchange', 'trello', 'tumblr', 'tumblr-sign', 'twitter', 'twitter-sign', 'vk', 'weibo', 'windows', 'xing', 'xing-sign', 'youtube', 'youtube-play', 'youtube-sign', 'ambulance', 'h-sign', 'hospital', 'medkit', 'plus-sign-alt', 'stethoscope', 'user-md' ) );
	}

	/**
	 * Shortcodes
	 */
	public static function shortcodes( $shortcode = false ) {
		$shortcodes = apply_filters( 'su/data/shortcodes', array(
				// heading
				'heading' => array(
					'name' => __( 'Heading', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'size' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 18,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'su' ), 'desc' => __( 'Select heading size', 'su' )
						),
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'center',
							'name' => __( 'Align', 'su' ),
							'desc' => __( 'Heading text alignment', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[heading] Content [/heading]<br/>[heading size="5"] Content [/heading]', 'content' => __( 'Heading text', 'su' ),
					'desc' => __( 'Styled heading', 'su' ),
					'icon' => 'icon-h-sign'
				),
				// tabs
				'tabs' => array(
					'name' => __( 'Tabs', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'active' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 100,
							'step' => 1,
							'default' => 1,
							'name' => __( 'Active tab', 'su' ),
							'desc' => __( 'Select which tab is open by default', 'su' )
						),
						'vertical' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Vertical', 'su' ),
							'desc' => __( 'Show tabs vertically', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[tabs style="default"] [tab title="Tab name"] Tab content [/tab] [/tabs]',
					'content' => __( "[%prefix_tab title=\"Title 1\"]Content 1[/%prefix_tab]\n[%prefix_tab title=\"Title 2\"]Content 2[/%prefix_tab]\n[%prefix_tab title=\"Title 3\"]Content 3[/%prefix_tab]", 'su' ),
					'desc' => __( 'Tabs container', 'su' ),
					'icon' => 'icon-list-alt'
				),
				// tab
				'tab' => array(
					'name' => __( 'Tab', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Tab name', 'su' ),
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Enter tab name', 'su' )
						),
						'disabled' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Disabled', 'su' ),
							'desc' => __( 'Is this tab disabled', 'su' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'su' ),
							'desc' => __( 'You can use unique anchor for this tab to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This tab will be activated and scrolled in', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[tabs] [tab title="Tab name"] Tab content [/tab] [/tabs]',
					'content' => __( 'Tab content', 'su' ),
					'desc' => __( 'Single tab', 'su' ),
					'icon' => 'icon-list-alt'
				),
				// spoiler
				'spoiler' => array(
					'name' => __( 'Spoiler', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'default' => __( 'Spoiler title', 'su' ),
							'name' => __( 'Title', 'su' ), 'desc' => __( 'Text in spoiler title', 'su' )
						),
						'open' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Open', 'su' ),
							'desc' => __( 'Is spoiler content visible by default', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'fancy' => __( 'Fancy', 'su' ),
								'simple' => __( 'Simple', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Spoiler skin', 'su' )
						),
						'anchor' => array(
							'default' => '',
							'name' => __( 'Anchor', 'su' ),
							'desc' => __( 'You can use unique anchor for this spoiler to access it with hash in page url. For example: type here <b%value>Hello</b> and then use url like http://example.com/page-url#Hello. This spoiler will be open and scrolled in', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[spoiler title="Spoiler title"] Hidden text [/spoiler]',
					'content' => __( 'Hidden content', 'su' ),
					'desc' => __( 'Spoiler with hidden content', 'su' ),
					'icon' => 'icon-list-ul'
				),
				// accordion
				'accordion' => array(
					'name' => __( 'Accordion', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[accordion]<br/>[spoiler open="yes"] content [/spoiler]<br/>[spoiler] content [/spoiler]<br/>[spoiler] content [/spoiler]<br/>[/accordion]',
					'content' => __( "[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]\n[%prefix_spoiler]Content[/%prefix_spoiler]", 'su' ),
					'desc' => __( 'Accordion with spoilers', 'su' ),
					'icon' => 'icon-list'
				),
				// divider
				'divider' => array(
					'name' => __( 'Divider', 'su' ),
					'type' => 'single',
					'group' => 'content',
					'atts' => array(
						'top' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Show TOP link', 'su' ),
							'desc' => __( 'Show link to top of the page or not', 'su' )
						),
						'text' => array(
							'values' => array( ),
							'default' => __( 'Go to top', 'su' ),
							'name' => __( 'Link text', 'su' ), 'desc' => __( 'Text for the GO TOP link', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[divider top="yes" text="Go to top"]',
					'desc' => __( 'Content divider with optional TOP link', 'su' ),
					'icon' => 'icon-ellipsis-horizontal'
				),
				// spacer
				'spacer' => array(
					'name' => __( 'Spacer', 'su' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'size' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 5,
							'default' => 20,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Height of the spacer in pixels', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[spacer size="20"]',
					'desc' => __( 'Empty space with adjustable height', 'su' ),
					'icon' => 'icon-resize-vertical'
				),
				// highlight
				'highlight' => array(
					'name' => __( 'Highlight', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#DDFF99',
							'name' => __( 'Background', 'su' ),
							'desc' => __( 'Highlighted text background color', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#000000',
							'name' => __( 'Text color', 'su' ), 'desc' => __( 'Highlighted text color', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[highlight background="#DDFF99" color="#000000"] Content [/highlight]', 'content' => __( 'Highlighted text', 'su' ),
					'desc' => __( 'Highlighted text', 'su' ),
					'icon' => 'icon-pencil'
				),
				// label
				'label' => array(
					'name' => __( 'Label', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'success' => __( 'Success', 'su' ),
								'warning' => __( 'Warning', 'su' ),
								'important' => __( 'Important', 'su' ),
								'black' => __( 'Black', 'su' ),
								'info' => __( 'Info', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Type', 'su' ),
							'desc' => __( 'Style of the label', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[label type="info"] Information [/label]', 'content' => __( 'Label', 'su' ),
					'desc' => __( 'Styled label', 'su' ),
					'icon' => 'icon-tag'
				),
				// quote
				'quote' => array(
					'name' => __( 'Quote', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'cite' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Cite', 'su' ),
							'desc' => __( 'Quote author name', 'su' )
						),
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Cite url', 'su' ),
							'desc' => __( 'Url of the quote author. Leave empty to disable link', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[quote style="default"] Content [/quote]', 'content' => __( 'Quote', 'su' ),
					'desc' => __( 'Blockquote alternative', 'su' ),
					'icon' => 'icon-quote-right'
				),
				// pullquote
				'pullquote' => array(
					'name' => __( 'Pullquote', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'su' ), 'desc' => __( 'Pullquote alignment (float)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[pullquote align="left"] Content [/pullquote]', 'content' => __( 'Pullquote', 'su' ),
					'desc' => __( 'Pullquote', 'su' ),
					'icon' => 'icon-quote-left'
				),
				// dropcap
				'dropcap' => array(
					'name' => __( 'Dropcap', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'flat' => __( 'Flat', 'su' ),
								'light' => __( 'Light', 'su' ),
								'simple' => __( 'Simple', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ), 'desc' => __( 'Dropcap style preset', 'su' )
						),
						'size' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5 ), 'default' => 3,
							'name' => __( 'Size', 'su' ), 'desc' => __( 'Choose dropcap size', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[dropcap style="default"]D[/dropcap]ropcap', 'content' => __( 'D', 'su' ),
					'desc' => __( 'Dropcap', 'su' ),
					'icon' => 'icon-bold'
				),
				// frame
				'frame' => array(
					'name' => __( 'Frame', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'align' => array(
							'type' => 'select',
							'values' => array(
								'left' => __( 'Left', 'su' ),
								'center' => __( 'Center', 'su' ),
								'right' => __( 'Right', 'su' )
							),
							'default' => 'left',
							'name' => __( 'Align', 'su' ),
							'desc' => __( 'Frame alignment', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[frame align="center"]<img src="image.jpg">[/frame]',
					'content' => '<img src="http://lorempixel.com/g/400/200/" />',
					'desc' => __( 'Styled image frame', 'su' ),
					'icon' => 'icon-picture'
				),
				// row
				'row' => array(
					'name' => __( 'Row', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[row]<br/>[column size="1/2"] 50% [/column]<br/>[column size="1/4"] 25% [/column]<br/>[column size="1/4"] 25% [/column]<br/>[/row]',
					'content' => __( "[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]\n[%prefix_column size=\"1/3\"]Content[/%prefix_column]", 'su' ),
					'desc' => __( 'Row for flexible columns', 'su' ),
					'icon' => 'icon-columns'
				),
				// column
				'column' => array(
					'name' => __( 'Column', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'size' => array(
							'type' => 'select',
							'values' => array(
								'1/1' => __( 'Full width', 'su' ),
								'1/2' => __( 'One half', 'su' ),
								'1/3' => __( 'One third', 'su' ),
								'2/3' => __( 'Two third', 'su' ),
								'1/4' => __( 'One fourth', 'su' ),
								'3/4' => __( 'Three fourth', 'su' ),
								'1/5' => __( 'One fifth', 'su' ),
								'2/5' => __( 'Two fifth', 'su' ),
								'3/5' => __( 'Three fifth', 'su' ),
								'4/5' => __( 'Four fifth', 'su' ),
								'1/6' => __( 'One sixth', 'su' ),
								'5/6' => __( 'Five sixth', 'su' )
							),
							'default' => '1/2',
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Select column width. This width will be calculated depend page width', 'su' )
						),
						'center' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Centered', 'su' ),
							'desc' => __( 'Is this column centered on the page', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[row]<br/>[column size="6"] 50% [/column]<br/>[column size="3"] 25% [/column]<br/>[column size="3"] 25% [/column]<br/>[/row]',
					'content' => __( 'Column content', 'su' ),
					'desc' => __( 'Flexible and responsive columns', 'su' ),
					'icon' => 'icon-columns'
				),
				// list
				'list' => array(
					'name' => __( 'List', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this list or pick a built-in icon', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[list style="check"] <ul> <li> List item </li> </ul> [/list]',
					'content' => __( "<ul>\n<li>List item</li>\n<li>List item</li>\n<li>List item</li>\n</ul>", 'su' ),
					'desc' => __( 'Styled unordered list', 'su' ),
					'icon' => 'icon-list-ol'
				),
				// button
				'button' => array(
					'name' => __( 'Button', 'su' ),
					'type' => 'wrap',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => get_option( 'home' ),
							'name' => __( 'Link', 'su' ),
							'desc' => __( 'Button link', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'su' ),
								'blank' => __( 'New tab', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'su' ),
							'desc' => __( 'Button link target', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'flat' => __( 'Flat', 'su' ),
								'soft' => __( 'Soft', 'su' ),
								'glass' => __( 'Glass', 'su' ),
								'bubbles' => __( 'Bubbles', 'su' ),
								'noise' => __( 'Noise', 'su' ),
								'stroked' => __( 'Stroked', 'su' ),
								'3d' => __( '3D', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ), 'desc' => __( 'Button background style preset', 'su' )
						),
						'background' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#2D89EF',
							'name' => __( 'Background', 'su' ), 'desc' => __( 'Button background color', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Text color', 'su' ),
							'desc' => __( 'Button text color', 'su' )
						),
						'size' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1,
							'default' => 3,
							'name' => __( 'Size', 'su' ),
							'desc' => __( 'Button size', 'su' )
						),
						'wide' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Fluid', 'su' ), 'desc' => __( 'Fluid buttons has 100% width', 'su' )
						),
						'center' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Centered', 'su' ), 'desc' => __( 'Is button centered on the page', 'su' )
						),
						'radius' => array(
							'type' => 'select',
							'values' => array(
								'auto' => __( 'Auto', 'su' ),
								'round' => __( 'Round', 'su' ),
								'0' => __( 'Square', 'su' ),
								'5' => '5px',
								'10' => '10px',
								'20' => '20px'
							),
							'default' => 'auto',
							'name' => __( 'Radius', 'su' ),
							'desc' => __( 'Radius of button corners. Auto-radius calculation based on button size', 'su' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this button or pick a built-in icon', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#FFFFFF',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'text_shadow' => array(
							'type' => 'shadow',
							'default' => 'none',
							'name' => __( 'Text shadow', 'su' ),
							'desc' => __( 'Button text shadow', 'su' )
						),
						'desc' => array(
							'default' => '',
							'name' => __( 'Description', 'su' ),
							'desc' => __( 'Small description under button text. This option is incompatible with icon.', 'su' )
						),
						'onclick' => array(
							'default' => '',
							'name' => __( 'onClick', 'su' ),
							'desc' => __( 'Advanced JavaScript code for onClick action', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[button url="#" background="#b00" size="3" style="default"] Button text [/button]',
					'content' => __( 'Button text', 'su' ),
					'desc' => __( 'Styled button', 'su' ),
					'icon' => 'icon-heart'
				),
				// service
				'service' => array(
					'name' => __( 'Service', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Service title', 'su' ),
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Service name', 'su' )
						),
						'icon' => array(
							'type' => 'icon',
							'default' => '',
							'name' => __( 'Icon', 'su' ),
							'desc' => __( 'You can upload custom icon for this box', 'su' )
						),
						'icon_color' => array(
							'type' => 'color',
							'default' => '#333333',
							'name' => __( 'Icon color', 'su' ),
							'desc' => __( 'This color will be applied to the selected icon. Does not works with uploaded icons', 'su' )
						),
						'size' => array(
							'type' => 'number',
							'min' => 10,
							'max' => 128,
							'step' => 2,
							'default' => 32,
							'name' => __( 'Icon size', 'su' ),
							'desc' => __( 'Size of the uploaded icon in pixels', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[service title="Service title" icon="service.png" size="32"] Service description [/service]',
					'content' => __( 'Service description', 'su' ),
					'desc' => __( 'Service box with title', 'su' ),
					'icon' => 'icon-check'
				),
				// box
				'box' => array(
					'name' => __( 'Box', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'title' => array(
							'values' => array( ),
							'default' => __( 'Box title', 'su' ),
							'name' => __( 'Title', 'su' ), 'desc' => __( 'Text for the box title', 'su' )
						),
						'style' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'soft' => __( 'Soft', 'su' ),
								'glass' => __( 'Glass', 'su' ),
								'bubbles' => __( 'Bubbles', 'su' ),
								'noise' => __( 'Noise', 'su' )
							),
							'default' => 'default',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Box style preset', 'su' )
						),
						'box_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Color', 'su' ),
							'desc' => __( 'Color for the box title and borders', 'su' )
						),
						'title_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFFFF',
							'name' => __( 'Title text color', 'su' ), 'desc' => __( 'Color for the box title text', 'su' )
						),
						'radius' => array(
							'type' => 'select',
							'values' => array( '0', '3', '5', '10', '20' ),
							'default' => '3',
							'name' => __( 'Radius', 'su' ),
							'desc' => __( 'Box corners radius', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[box title="Box title"] Content [/box]',
					'content' => __( 'Box content', 'su' ),
					'desc' => __( 'Colored box with caption', 'su' ),
					'icon' => 'icon-list-alt'
				),
				// note
				'note' => array(
					'name' => __( 'Note', 'su' ),
					'type' => 'wrap',
					'group' => 'box',
					'atts' => array(
						'note_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#FFFF66',
							'name' => __( 'Background', 'su' ), 'desc' => __( 'Note background color', 'su' )
						),
						'text_color' => array(
							'type' => 'color',
							'values' => array( ),
							'default' => '#333333',
							'name' => __( 'Text color', 'su' ),
							'desc' => __( 'Note text color', 'su' )
						),
						'radius' => array(
							'type' => 'select',
							'values' => array( '0', '3', '5', '10', '20' ),
							'default' => '3',
							'name' => __( 'Radius', 'su' ), 'desc' => __( 'Note corners radius', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[note background="#FFCC00"] Content [/note]', 'content' => __( 'Note text', 'su' ),
					'desc' => __( 'Colored box', 'su' ),
					'icon' => 'icon-list-alt'
				),
				// lightbox
				'lightbox' => array(
					'name' => __( 'Lightbox', 'su' ),
					'type' => 'wrap',
					'group' => 'gallery',
					'atts' => array(
						'type' => array(
							'type' => 'select',
							'values' => array(
								'iframe' => __( 'Iframe', 'su' ),
								'image' => __( 'Image', 'su' ),
								'inline' => __( 'Inline (html content)', 'su' )
							),
							'default' => 'iframe',
							'name' => __( 'Content type', 'su' ),
							'desc' => __( 'Select type of the lightbox window content', 'su' )
						),
						'src' => array(
							'default' => 'http://www.youtube.com/watch?v=NbE8INOjTKM',
							'name' => __( 'Content source', 'su' ),
							'desc' => __( 'Insert here URL or CSS selector. Use URL for Iframe and Image content types. Use CSS selector for Inline content type.<br />Example values:<br /><b%value>http://www.youtube.com/watch?v=NbE8INOjTKM</b> - YouTube video (iframe)<br /><b%value>http://example.com/wp-content/uploads/image.jpg</b> - uploaded image (image)<br /><b%value>http://example.com/</b> - any web page (iframe)<br /><b%value>#contact-form</b> - any HTML content (inline)', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[lightbox src="http://example.com/" type="iframe"] Open example.com [/lightbox]',
					'content' => __( '[%prefix_button] Click Here to Watch the Video [/%prefix_button]', 'su' ),
					'desc' => __( 'Lightbox window with custom content', 'su' ),
					'icon' => 'icon-external-link'
				),
				// tooltip
				'tooltip' => array(
					'name' => __( 'Tooltip', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'style' => array(
							'type' => 'select',
							'values' => array(
								'light' => __( 'Basic: Light', 'su' ),
								'dark' => __( 'Basic: Dark', 'su' ),
								'yellow' => __( 'Basic: Yellow', 'su' ),
								'green' => __( 'Basic: Green', 'su' ),
								'red' => __( 'Basic: Red', 'su' ),
								'blue' => __( 'Basic: Blue', 'su' ),
								'youtube' => __( 'Youtube', 'su' ),
								'tipsy' => __( 'Tipsy', 'su' ),
								'bootstrap' => __( 'Bootstrap', 'su' ),
								'jtools' => __( 'jTools', 'su' ),
								'tipped' => __( 'Tipped', 'su' ),
								'cluetip' => __( 'Cluetip', 'su' ),
							),
							'default' => 'yellow',
							'name' => __( 'Style', 'su' ),
							'desc' => __( 'Tooltip window style', 'su' )
						),
						'position' => array(
							'type' => 'select',
							'values' => array(
								'north' => __( 'Top', 'su' ),
								'south' => __( 'Bottom', 'su' ),
								'west' => __( 'Left', 'su' ),
								'east' => __( 'Right', 'su' )
							),
							'default' => 'top',
							'name' => __( 'Position', 'su' ),
							'desc' => __( 'Tooltip position', 'su' )
						),
						'shadow' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Shadow', 'su' ),
							'desc' => __( 'Add shadow to tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'su' )
						),
						'rounded' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Rounded corners', 'su' ),
							'desc' => __( 'Use rounded for tooltip. This option is only works with basic styes, e.g. blue, green etc.', 'su' )
						),
						'size' => array(
							'type' => 'select',
							'values' => array(
								'default' => __( 'Default', 'su' ),
								'1' => 1,
								'2' => 2,
								'3' => 3,
								'4' => 4,
								'5' => 5,
								'6' => 6,
							),
							'default' => 'default',
							'name' => __( 'Font size', 'su' ),
							'desc' => __( 'Tooltip font size', 'su' )
						),
						'title' => array(
							'default' => '',
							'name' => __( 'Tooltip title', 'su' ),
							'desc' => __( 'Enter title for tooltip window. Leave this field empty to hide the title', 'su' )
						),
						'content' => array(
							'default' => __( 'Tooltip text', 'su' ),
							'name' => __( 'Tooltip content', 'su' ),
							'desc' => __( 'Enter tooltip content here', 'su' )
						),
						'behavior' => array(
							'type' => 'select',
							'values' => array(
								'hover' => __( 'Show and hide on mouse hover', 'su' ),
								'click' => __( 'Show and hide by mouse click', 'su' ),
								'always' => __( 'Always visible', 'su' )
							),
							'default' => 'hover',
							'name' => __( 'Behavior', 'su' ),
							'desc' => __( 'Select tooltip behavior', 'su' )
						),
						'close' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Close button', 'su' ),
							'desc' => __( 'Show close button', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[tooltip] Hover me [/lightbox]',
					'content' => __( '[%prefix_button] Hover me to open tooltip [/%prefix_button]', 'su' ),
					'desc' => __( 'Tooltip window with custom content', 'su' ),
					'icon' => 'icon-comment-alt'
				),
				// private
				'private' => array(
					'name' => __( 'Private', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[private] Private content [/private]',
					'content' => __( 'Private note text', 'su' ),
					'desc' => __( 'Private note for post authors', 'su' ),
					'icon' => 'icon-lock'
				),
				// youtube
				'youtube' => array(
					'name' => __( 'YouTube', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url of YouTube page with video. Ex: http://youtube.com/watch?v=XXXXXX', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'autoplay' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[youtube url="http://www.youtube.com/watch?v=NbE8INOjTKM"]',
					'desc' => __( 'YouTube video', 'su' ),
					'icon' => 'icon-youtube-play'
				),
				// vimeo
				'vimeo' => array(
					'name' => __( 'Vimeo', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ), 'desc' => __( 'Url of Vimeo page with video', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'autoplay' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play video automatically when page is loaded', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[vimeo url="http://vimeo.com/21294655"]',
					'desc' => __( 'Vimeo video', 'su' ),
					'icon' => 'icon-youtube-play'
				),
				// screenr
				'screenr' => array(
					'name' => __( 'Screenr', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'default' => '',
							'name' => __( 'Url', 'su' ), 'desc' => __( 'Url of Screenr page with video', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'responsive' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make player responsive', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[screenr url="http://www.screenr.com/OuWH"]',
					'desc' => __( 'Screenr video', 'su' ),
					'icon' => 'icon-youtube-play'
				),
				// audio
				'audio' => array(
					'name' => __( 'Audio', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'su' ),
							'desc' => __( 'Audio file url. Supported formats: mp3, ogg', 'su' )
						),
						'width' => array(
							'values' => array(),
							'default' => '100%',
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width. You can specify width in percents and player will be responsive. Example values: <b%value>200px</b>, <b%value>100&#37;</b>', 'su' )
						),
						'autoplay' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play file automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Repeat when playback is ended', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[audio url="http://example.com/audio.mp3"]',
					'desc' => __( 'Custom audio player', 'su' ),
					'icon' => 'icon-play-circle'
				),
				// video
				'video' => array(
					'name' => __( 'Video', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'File', 'su' ),
							'desc' => __( 'Url to mp4/flv video-file', 'su' )
						),
						'poster' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Poster', 'su' ),
							'desc' => __( 'Url to poster image, that will be shown before playback', 'su' )
						),
						'title' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Title', 'su' ),
							'desc' => __( 'Player title', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Player width', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Player height', 'su' )
						),
						'controls' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Controls', 'su' ),
							'desc' => __( 'Show player controls (play/pause etc.) or not', 'su' )
						),
						'autoplay' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Play file automatically when page is loaded', 'su' )
						),
						'loop' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Loop', 'su' ),
							'desc' => __( 'Repeat when playback is ended', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[video url="http://example.com/video.mp4"]',
					'desc' => __( 'Custom video player', 'su' ),
					'icon' => 'icon-play-circle'
				),
				// table
				'table' => array(
					'name' => __( 'Table', 'su' ),
					'type' => 'mixed',
					'group' => 'content',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'CSV file', 'su' ),
							'desc' => __( 'Upload CSV file if you want to create HTML-table from file', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[table style="default"] <table> ... </table> [/table]<br/>[table style="default" url="http://example.com/file.csv"] [/table]',
					'content' => __( "<table>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n<tr>\n\t<td>Table</td>\n\t<td>Table</td>\n</tr>\n</table>", 'su' ),
					'desc' => __( 'Styled table from HTML or CSV file', 'su' ),
					'icon' => 'icon-table'
				),
				// permalink
				'permalink' => array(
					'name' => __( 'Permalink', 'su' ),
					'type' => 'mixed',
					'group' => 'content other',
					'atts' => array(
						'id' => array(
							'values' => array( ), 'default' => 1,
							'name' => __( 'ID', 'su' ),
							'desc' => __( 'Post or page ID', 'su' )
						),
						'target' => array(
							'type' => 'select',
							'values' => array(
								'self' => __( 'Same tab', 'su' ),
								'blank' => __( 'New tab', 'su' )
							),
							'default' => 'self',
							'name' => __( 'Target', 'su' ),
							'desc' => __( 'Link target. blank - link will be opened in new window/tab', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[permalink id=52]<br/>[permalink id="52" target="blank"] Content [/permalink]',
					'content' => '',
					'desc' => __( 'Permalink to specified post/page', 'su' ),
					'icon' => 'icon-link'
				),
				// members
				'members' => array(
					'name' => __( 'Members', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'message' => array(
							'default' => __( 'This content is for registered users only. Please %login%.', 'su' ),
							'name' => __( 'Message', 'su' ), 'desc' => __( 'Message for not logged users', 'su' )
						),
						'color' => array(
							'type' => 'color',
							'default' => '#ffcc00',
							'name' => __( 'Box color', 'su' ), 'desc' => __( 'This color will applied only to box for not logged users', 'su' )
						),
						'login_text' => array(
							'default' => __( 'login', 'su' ),
							'name' => __( 'Login link text', 'su' ), 'desc' => __( 'Text for the login link', 'su' )
						),
						'login_url' => array(
							'default' => wp_login_url(),
							'name' => __( 'Login link url', 'su' ), 'desc' => __( 'Login link url', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[members style="default"] Content for logged members [/members]',
					'content' => __( 'Content for logged members', 'su' ),
					'desc' => __( 'Content for logged in members only', 'su' ),
					'icon' => 'icon-lock'
				),
				// guests
				'guests' => array(
					'name' => __( 'Guests', 'su' ),
					'type' => 'wrap',
					'group' => 'other',
					'atts' => array(
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[guests] Content for guests [/guests]',
					'content' => __( 'Content for guests', 'su' ),
					'desc' => __( 'Content for guests only', 'su' ),
					'icon' => 'icon-user'
				),
				// feed
				'feed' => array(
					'name' => __( 'RSS Feed', 'su' ),
					'type' => 'single',
					'group' => 'content other',
					'atts' => array(
						'url' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url to RSS-feed', 'su' )
						),
						'limit' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ), 'default' => 3,
							'name' => __( 'Limit', 'su' ), 'desc' => __( 'Number of items to show', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[feed url="http://rss1.smashingmagazine.com/feed/" limit="5"]',
					'desc' => __( 'Feed grabber', 'su' ),
					'icon' => 'icon-rss'
				),
				// menu
				'menu' => array(
					'name' => __( 'Menu', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'name' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Menu name', 'su' ), 'desc' => __( 'Custom menu name. Ex: Main menu', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[menu name="Main menu"]',
					'desc' => __( 'Custom menu by name', 'su' ),
					'icon' => 'icon-reorder'
				),
				// subpages
				'subpages' => array(
					'name' => __( 'Sub pages', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3, 4, 5 ), 'default' => 1,
							'name' => __( 'Depth', 'su' ),
							'desc' => __( 'Max depth level of children pages', 'su' )
						),
						'p' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Parent ID', 'su' ),
							'desc' => __( 'ID of the parent page. Leave blank to use current page', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[subpages]<br/>[subpages depth="2" p="122"]',
					'desc' => __( 'List of sub pages', 'su' ),
					'icon' => 'icon-reorder'
				),
				// siblings
				'siblings' => array(
					'name' => __( 'Siblings', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'depth' => array(
							'type' => 'select',
							'values' => array( 1, 2, 3 ), 'default' => 1,
							'name' => __( 'Depth', 'su' ),
							'desc' => __( 'Max depth level', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[siblings]<br/>[siblings depth="2"]',
					'desc' => __( 'List of cureent page siblings', 'su' ),
					'icon' => 'icon-reorder'
				),
				// document
				'document' => array(
					'name' => __( 'Document', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'url' => array(
							'type' => 'upload',
							'default' => '',
							'name' => __( 'Url', 'su' ),
							'desc' => __( 'Url to uploaded document. Supported formats: doc, xls, pdf etc.', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Viewer width', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Viewer height', 'su' )
						),
						'responsive' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make viewer responsive', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[document url="file.doc" width="600" height="400"]',
					'desc' => __( 'Document viewer by Google', 'su' ),
					'icon' => 'icon-file-text'
				),
				// gmap
				'gmap' => array(
					'name' => __( 'Gmap', 'su' ),
					'type' => 'single',
					'group' => 'media',
					'atts' => array(
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ),
							'desc' => __( 'Map width', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 400,
							'name' => __( 'Height', 'su' ),
							'desc' => __( 'Map height', 'su' )
						),
						'responsive' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make map responsive', 'su' )
						),
						'address' => array(
							'values' => array( ),
							'default' => '',
							'name' => __( 'Marker', 'su' ),
							'desc' => __( 'Address for the marker. You can type it in any language', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[gmap width="600" height="400" address="New York"]',
					'desc' => __( 'Maps by Google', 'su' ),
					'icon' => 'icon-globe'
				),
				// slider
				'slider' => array(
					'name' => __( 'Slider', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'gallery' => array(
							'type' => 'gallery',
							'name' => __( 'Gallery', 'su' ),
							'desc' => __( 'Choose source gallery, that will be used for this slider', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ), 'desc' => __( 'Slider width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 300,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Slider height (in pixels)', 'su' )
						),
						'responsive' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make slider responsive', 'su' )
						),
						'title' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Show titles', 'su' ), 'desc' => __( 'Display slide titles', 'su' )
						),
						'centered' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Center', 'su' ), 'desc' => __( 'Is slider centered on the page', 'su' )
						),
						'arrows' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Arrows', 'su' ), 'desc' => __( 'Show left and right arrows', 'su' )
						),
						'pages' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Pagination', 'su' ),
							'desc' => __( 'Show pagination', 'su' )
						),
						'mousewheel' => array(
							'type' => 'switch',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'su' ),
							'desc' => __( 'Allow to change slides with mouse wheel', 'su' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Choose interval between slide animations. Set to 0 to disable autoplay', 'su' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'su' ), 'desc' => __( 'Specify animation speed', 'su' )
						),
						'target' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open slides links in new window/tab', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[slider gallery="1"]',
					'desc' => __( 'Customizable image slider', 'su' ),
					'icon' => 'icon-picture'
				),
				// carousel
				'carousel' => array(
					'name' => __( 'Carousel', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'gallery' => array(
							'type' => 'gallery',
							'name' => __( 'Gallery', 'su' ),
							'desc' => __( 'Choose source gallery, that will be used for this carousel', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 600,
							'name' => __( 'Width', 'su' ), 'desc' => __( 'Carousel width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 20,
							'default' => 100,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Carousel height (in pixels)', 'su' )
						),
						'responsive' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Responsive', 'su' ),
							'desc' => __( 'Ignore width and height parameters and make carousel responsive', 'su' )
						),
						'items' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1, 'default' => 3,
							'name' => __( 'Items to show', 'su' ),
							'desc' => __( 'How much carousel items is visible', 'su' )
						),
						'scroll' => array(
							'type' => 'number',
							'min' => 1,
							'max' => 20,
							'step' => 1, 'default' => 1,
							'name' => __( 'Scroll number', 'su' ),
							'desc' => __( 'How much items are scrolled in one transition', 'su' )
						),
						'title' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Show titles', 'su' ), 'desc' => __( 'Display titles for each item', 'su' )
						),
						'centered' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Center', 'su' ), 'desc' => __( 'Is carousel centered on the page', 'su' )
						),
						'arrows' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Arrows', 'su' ), 'desc' => __( 'Show left and right arrows', 'su' )
						),
						'pages' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Pagination', 'su' ),
							'desc' => __( 'Show pagination', 'su' )
						),
						'mousewheel' => array(
							'type' => 'switch',
							'default' => 'yes', 'name' => __( 'Mouse wheel control', 'su' ),
							'desc' => __( 'Allow to rotate carousel with mouse wheel', 'su' )
						),
						'autoplay' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 100000,
							'step' => 100,
							'default' => 5000,
							'name' => __( 'Autoplay', 'su' ),
							'desc' => __( 'Choose interval between auto animations. Set to 0 to disable autoplay', 'su' )
						),
						'speed' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 20000,
							'step' => 100,
							'default' => 600,
							'name' => __( 'Speed', 'su' ), 'desc' => __( 'Specify animation speed', 'su' )
						),
						'target' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Links target', 'su' ),
							'desc' => __( 'Open carousel links in new window/tab', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[carousel gallery="1"]',
					'desc' => __( 'Customizable image carousel', 'su' ),
					'icon' => 'icon-picture'
				),
				// custom_gallery
				'custom_gallery' => array(
					'name' => __( 'Gallery', 'su' ),
					'type' => 'single',
					'group' => 'gallery',
					'atts' => array(
						'gallery' => array(
							'type' => 'gallery',
							'name' => __( 'Gallery', 'su' ),
							'desc' => __( 'Choose source gallery, that will be used for this shortcode', 'su' )
						),
						'width' => array(
							'type' => 'number',
							'min' => 20,
							'max' => 2000,
							'step' => 20,
							'default' => 90,
							'name' => __( 'Width', 'su' ), 'desc' => __( 'Single item width (in pixels)', 'su' )
						),
						'height' => array(
							'type' => 'number',
							'min' => 20,
							'max' => 2000,
							'step' => 20,
							'default' => 90,
							'name' => __( 'Height', 'su' ), 'desc' => __( 'Single item height (in pixels)', 'su' )
						),
						'title' => array(
							'type' => 'select',
							'values' => array(
								'never' => __( 'Never', 'su' ),
								'hover' => __( 'On mouse over', 'su' ),
								'always' => __( 'Always', 'su' )
							),
							'default' => 'hover',
							'name' => __( 'Show titles', 'su' ),
							'desc' => __( 'Title display mode', 'su' )
						),
						'target' => array(
							'type' => 'switch',
							'default' => 'yes',
							'name' => __( 'Links target', 'su' ), 'desc' => __( 'Open links in new window/tab', 'su' )
						),
						'class' => array(
							'default' => '',
							'name' => __( 'Class', 'su' ),
							'desc' => __( 'Extra CSS class', 'su' )
						)
					),
					'usage' => '[custom_gallery gallery="1"]',
					'desc' => __( 'Customizable image gallery', 'su' ),
					'icon' => 'icon-picture'
				),
				// posts
				'posts' => array(
					'name' => __( 'Posts', 'su' ),
					'type' => 'single',
					'group' => 'other',
					'atts' => array(
						'template' => array(
							'default' => 'templates/default-loop.php', 'name' => __( 'Template', 'su' ),
							'desc' => __( '<b>Do not change this field value if you do not understand description below.</b><br/>Relative path to the template file. Default templates is placed under the plugin directory (templates folder). You can copy it under your theme directory and modify as you want. You can use following default templates that already available in the plugin directory:<br/><b%value>templates/default-loop.php</b> - posts loop<br/><b%value>templates/teaser-loop.php</b> - posts loop with thumbnail and title<br/><b%value>templates/single-post.php</b> - single post template<br/><b%value>templates/list-loop.php</b> - unordered list with posts titles', 'su' )
						),
						'id' => array(
							'default' => '',
							'name' => __( 'Post ID\'s', 'su' ),
							'desc' => __( 'Enter comma separated ID\'s of the posts that you want to show', 'su' )
						),
						'posts_per_page' => array(
							'type' => 'number',
							'min' => -1,
							'max' => 10000,
							'step' => 1,
							'default' => get_option( 'posts_per_page' ),
							'name' => __( 'Posts per page', 'su' ),
							'desc' => __( 'Specify number of posts that you want to show. Enter -1 to get all posts', 'su' )
						),
						'post_type' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => su_get_post_types(),
							'default' => 'post',
							'name' => __( 'Post types', 'su' ),
							'desc' => __( 'Select post types. Hold Ctrl key to select multiple post types', 'su' )
						),
						'taxonomy' => array(
							'type' => 'select',
							'values' => su_get_taxonomies(),
							'default' => 'category',
							'name' => __( 'Taxonomy', 'su' ),
							'desc' => __( 'Select taxonomy to show posts from', 'su' )
						),
						'tax_term' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => su_get_terms( su_get_taxonomies( true ) ),
							'default' => '',
							'name' => __( 'Terms', 'su' ), 'desc' => __( 'Select terms to show posts from', 'su' )
						),
						'tax_operator' => array(
							'type' => 'select',
							'values' => array( 'IN', 'NOT IN', 'AND' ),
							'default' => 'IN', 'name' => __( 'Taxonomy term operator', 'su' ),
							'desc' => __( 'IN - posts that have any of selected categories terms<br/>NOT IN - posts that is does not have any of selected terms<br/>AND - posts that have all selected terms', 'su' )
						),
						'author' => array(
							'type' => 'select',
							'multiple' => true,
							'values' => su_get_users(),
							'default' => 'default',
							'name' => __( 'Authors', 'su' ),
							'desc' => __( 'Choose the authors whose posts you want to show', 'su' )
						),
						'meta_key' => array(
							'default' => '',
							'name' => __( 'Meta key', 'su' ),
							'desc' => __( 'Enter meta key name to show posts that have this key', 'su' )
						),
						'offset' => array(
							'type' => 'number',
							'min' => 0,
							'max' => 10000,
							'step' => 1, 'default' => 0,
							'name' => __( 'Offset', 'su' ),
							'desc' => __( 'Specify offset to start posts loop not from first post', 'su' )
						),
						'order' => array(
							'type' => 'select',
							'values' => array(
								'desc' => __( 'Descending', 'su' ),
								'asc' => __( 'Ascending', 'su' )
							),
							'default' => 'DESC',
							'name' => __( 'Order', 'su' ),
							'desc' => __( 'Posts order', 'su' )
						),
						'orderby' => array(
							'type' => 'select',
							'values' => array(
								'none' => __( 'None', 'su' ),
								'id' => __( 'Post ID', 'su' ),
								'author' => __( 'Post author', 'su' ),
								'title' => __( 'Post title', 'su' ),
								'name' => __( 'Post slug', 'su' ),
								'date' => __( 'Date', 'su' ), 'modified' => __( 'Last modified date', 'su' ),
								'parent' => __( 'Post parent', 'su' ),
								'rand' => __( 'Random', 'su' ), 'comment_count' => __( 'Comments number', 'su' ),
								'menu_order' => __( 'Menu order', 'su' ), 'meta_value' => __( 'Meta key values', 'su' ),
							),
							'default' => 'date',
							'name' => __( 'Order by', 'su' ),
							'desc' => __( 'Order posts by', 'su' )
						),
						'post_parent' => array(
							'default' => '',
							'name' => __( 'Post parent', 'su' ),
							'desc' => __( 'Show childrens of entered post (enter post ID)', 'su' )
						),
						'post_status' => array(
							'type' => 'select',
							'values' => array(
								'publish' => __( 'Published', 'su' ),
								'pending' => __( 'Pending', 'su' ),
								'draft' => __( 'Draft', 'su' ),
								'auto-draft' => __( 'Auto-draft', 'su' ),
								'future' => __( 'Future post', 'su' ),
								'private' => __( 'Private post', 'su' ),
								'inherit' => __( 'Inherit', 'su' ),
								'trash' => __( 'Trashed', 'su' ),
								'any' => __( 'Any', 'su' ),
							),
							'default' => 'publish',
							'name' => __( 'Post status', 'su' ),
							'desc' => __( 'Show only posts with selected status', 'su' )
						),
						'ignore_sticky_posts' => array(
							'type' => 'switch',
							'default' => 'no',
							'name' => __( 'Ignore sticky', 'su' ),
							'desc' => __( 'Select Yes to ignore posts that is sticked', 'su' )
						)
					),
					'usage' => '[posts template="templates/posts.php"]',
					'desc' => __( 'Custom posts query with customizable template', 'su' ),
					'icon' => 'icon-th-list'
				)
			) );
		// Return result
		return ( is_string( $shortcode ) ) ? $shortcodes[sanitize_text_field( $shortcode )] : $shortcodes;
	}
}

new Shortcodes_Ultimate_Data;
