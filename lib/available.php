<?php

	/**
	 * List of available shortcodes
	 */
	function su_shortcodes( $shortcode = false ) {
		$shortcodes = array(
			# heading
			'heading' => array(
				'name' => 'Heading',
				'type' => 'wrap',
				'atts' => array( ),
				'usage' => '[heading] Content [/heading]',
				'desc' => __( 'Styled heading', 'shortcodes-ultimate' )
			),
			# frame
			'frame' => array(
				'name' => 'Image frame',
				'type' => 'wrap',
				'atts' => array(
					'align' => array(
						'values' => array(
							'left',
							'center',
							'none',
							'right'
						),
						'desc' => __( 'Frame align', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[frame align="center"] <img src="image.jpg" alt="" /> [/frame]',
				'desc' => __( 'Styled image frame', 'shortcodes-ultimate' )
			),
			# tabs
			'tabs' => array(
				'name' => 'Tabs',
				'type' => 'wrap',
				'atts' => array(
					'style' => array(
						'values' => array(
							'1',
							'2',
							'3'
						),
						'default' => '1',
						'desc' => __( 'Tabs style', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[tabs style="1"] [tab title="Tab name"] Tab content [/tab] [/tabs]',
				'desc' => __( 'Tabs container', 'shortcodes-ultimate' )
			),
			# tab
			'tab' => array(
				'name' => 'Tab',
				'type' => 'wrap',
				'atts' => array(
					'title' => array(
						'values' => array( ),
						'default' => __( 'Title', 'shortcodes-ultimate' ),
						'desc' => __( 'Tab title', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[tabs style="1"] [tab title="Tab name"] Tab content [/tab] [/tabs]',
				'desc' => __( 'Single tab', 'shortcodes-ultimate' )
			),
			# spoiler
			'spoiler' => array(
				'name' => 'Spoiler',
				'type' => 'wrap',
				'atts' => array(
					'title' => array(
						'values' => array( ),
						'default' => __( 'Spoiler title', 'shortcodes-ultimate' ),
						'desc' => __( 'Spoiler title', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[spoiler title="Spoiler title"] Hidden text [/spoiler]',
				'desc' => __( 'Hidden text', 'shortcodes-ultimate' )
			),
			# divider
			'divider' => array(
				'name' => 'Divider',
				'type' => 'single',
				'atts' => array(
					'top' => array(
						'values' => array(
							'0',
							'1'
						),
						'default' => '0',
						'desc' => __( 'Show TOP link', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[divider top="1"]',
				'desc' => __( 'Content divider with optional TOP link', 'shortcodes-ultimate' )
			),
			# spacer
			'spacer' => array(
				'name' => 'Spacer',
				'type' => 'single',
				'atts' => array(
					'size' => array(
						'values' => array(
							'0',
							'5',
							'10',
							'20',
							'40'
						),
						'default' => '0',
						'desc' => __( 'Spacer height in pixels', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[spacer size="20"]',
				'desc' => __( 'Empty space with adjustable height', 'shortcodes-ultimate' )
			),
			# quote
			'quote' => array(
				'name' => 'Quote',
				'type' => 'wrap',
				'atts' => array(
					'style' => array(
						'values' => array(
							'1',
							'2',
							'3'
						),
						'default' => '1',
						'desc' => __( 'Quote style', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[quote style="1"] Content [/quote]',
				'desc' => __( 'Blockquote alternative', 'shortcodes-ultimate' )
			),
			# pullquote
			'pullquote' => array(
				'name' => 'Pullquote',
				'type' => 'wrap',
				'atts' => array(
					'align' => array(
						'values' => array(
							'left',
							'right'
						),
						'default' => 'left',
						'desc' => __( 'Pullquote alignment', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[pullquote align="left"] Content [/pullquote]',
				'desc' => __( 'Pullquote', 'shortcodes-ultimate' )
			),
			# highlight
			'highlight' => array(
				'name' => 'Highlight',
				'type' => 'wrap',
				'atts' => array(
					'bg' => array(
						'values' => array( ),
						'default' => '#DDFF99',
						'desc' => __( 'Background color', 'shortcodes-ultimate' )
					),
					'color' => array(
						'values' => array( ),
						'default' => '#000000',
						'desc' => __( 'Text color', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[highlight bg="#fc0" color="#000"] Content [/highlight]',
				'desc' => __( 'Highlighted text', 'shortcodes-ultimate' )
			),
			# bloginfo
			'bloginfo' => array(
				'name' => 'Bloginfo',
				'type' => 'single',
				'atts' => array(
					'option' => array(
						'values' => array(
							'name',
							'description',
							'siteurl',
							'admin_email',
							'charset',
							'version',
							'html_type',
							'text_direction',
							'language',
							'template_url',
							'pingback_url',
							'rss2_url'
						),
						'default' => 'left',
						'desc' => __( 'Option name', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[bloginfo option="name"]',
				'desc' => __( 'Blog info', 'shortcodes-ultimate' )
			),
			# permalink
			'permalink' => array(
				'name' => 'Permalink',
				'type' => 'mixed',
				'atts' => array(
					'p' => array(
						'values' => array( ),
						'default' => '1',
						'desc' => __( 'Post/page ID', 'shortcodes-ultimate' )
					),
					'target' => array(
						'values' => array(
							'self',
							'blank'
						),
						'default' => 'self',
						'desc' => __( 'Link target', 'shortcodes-ultimate' )
					),
				),
				'usage' => '[permalink p=52]<br/>[permalink p="52" target="blank"] Content [/permalink]',
				'desc' => __( 'Permalink to specified post/page', 'shortcodes-ultimate' )
			),
			# button
			'button' => array(
				'name' => 'Button',
				'type' => 'wrap',
				'atts' => array(
					'link' => array(
						'values' => array( ),
						'default' => '#',
						'desc' => __( 'Button link', 'shortcodes-ultimate' )
					),
					'color' => array(
						'values' => array( ),
						'default' => '#AAAAAA',
						'desc' => __( 'Button background color', 'shortcodes-ultimate' )
					),
					'size' => array(
						'values' => array(
							'1',
							'2',
							'3',
							'4',
							'5',
							'6',
							'7',
							'8',
							'9',
							'10',
							'11',
							'12'
						),
						'default' => '3',
						'desc' => __( 'Button size', 'shortcodes-ultimate' )
					),
					'style' => array(
						'values' => array(
							'1',
							'2',
							'3',
							'4'
						),
						'default' => '1',
						'desc' => __( 'Button background style', 'shortcodes-ultimate' )
					),
					'dark' => array(
						'values' => array(
							'0',
							'1'
						),
						'default' => '0',
						'desc' => __( 'Dark text color', 'shortcodes-ultimate' )
					),
					'square' => array(
						'values' => array(
							'0',
							'1'
						),
						'default' => '0',
						'desc' => __( 'Disable rounded corners', 'shortcodes-ultimate' )
					),
					'icon' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Button icon', 'shortcodes-ultimate' )
					),
					'class' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Button class', 'shortcodes-ultimate' )
					),
					'target' => array(
						'values' => array(
							'self',
							'blank'
						),
						'default' => 'self',
						'desc' => __( 'Button link target', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[button link="#" color="#b00" size="3" style="3" dark="1" square="1" icon="image.png"] Button text [/button]',
				'desc' => __( 'Styled button', 'shortcodes-ultimate' )
			),
			# fancy_link
			'fancy_link' => array(
				'name' => 'Fancy link',
				'type' => 'wrap',
				'atts' => array(
					'color' => array(
						'values' => array(
							'black',
							'white'
						),
						'default' => 'black',
						'desc' => __( 'Link color', 'shortcodes-ultimate' )
					),
					'link' => array(
						'values' => array( ),
						'default' => '#',
						'desc' => __( 'URL', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[fancy_link color="black" link="http://example.com/"] Read more [/fancy_link]',
				'desc' => __( 'Fancy link', 'shortcodes-ultimate' )
			),
			# service
			'service' => array(
				'name' => 'Service',
				'type' => 'wrap',
				'atts' => array(
					'title' => array(
						'values' => array( ),
						'default' => __( 'Service title', 'shortcodes-ultimate' ),
						'desc' => __( 'Service title', 'shortcodes-ultimate' )
					),
					'icon' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Service icon', 'shortcodes-ultimate' )
					),
					'size' => array(
						'values' => array(
							'24',
							'32',
							'48'
						),
						'default' => '32',
						'desc' => __( 'Icon size', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[service title="Service title" icon="service.png" size="32"] Service description [/service]',
				'desc' => __( 'Service box with title', 'shortcodes-ultimate' )
			),
			# members
			'members' => array(
				'name' => 'Members',
				'type' => 'wrap',
				'atts' => array(
					'style' => array(
						'values' => array(
							'0',
							'1',
							'2'
						),
						'default' => '1',
						'desc' => __( 'Box style', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[members style="2"] Content for logged users [/members]',
				'desc' => __( 'Content for logged in members only', 'shortcodes-ultimate' )
			),
			# box
			'box' => array(
				'name' => 'Box',
				'type' => 'wrap',
				'atts' => array(
					'title' => array(
						'values' => array( ),
						'default' => __( 'Box title', 'shortcodes-ultimate' ),
						'desc' => __( 'Box title', 'shortcodes-ultimate' )
					),
					'color' => array(
						'values' => array( ),
						'default' => '#333333',
						'desc' => __( 'Box color', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[box title="Box title" color="#f00"] Content [/box]',
				'desc' => __( 'Colored box with caption', 'shortcodes-ultimate' )
			),
			# note
			'note' => array(
				'name' => 'Note',
				'type' => 'wrap',
				'atts' => array(
					'color' => array(
						'values' => array( ),
						'default' => '#FFCC00',
						'desc' => __( 'Note color', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[note color="#FFCC00"] Content [/note]',
				'desc' => __( 'Colored box', 'shortcodes-ultimate' )
			),
			# list
			'list' => array(
				'name' => 'List',
				'type' => 'wrap',
				'atts' => array(
					'style' => array(
						'values' => array(
							'star',
							'arrow',
							'check',
							'cross',
							'thumbs',
							'link',
							'gear',
							'time',
							'note',
							'plus',
							'guard',
							'event',
							'idea',
							'settings',
							'twitter'
						),
						'default' => 'star',
						'desc' => __( 'List style', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[list style="check"] <ul> <li> List item </li> </ul> [/list]',
				'desc' => __( 'Styled unordered list', 'shortcodes-ultimate' )
			),
			# feed
			'feed' => array(
				'name' => 'Feed',
				'type' => 'wrap',
				'atts' => array(
					'url' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Feed URL', 'shortcodes-ultimate' )
					),
					'limit' => array(
						'values' => array(
							'1',
							'3',
							'5',
							'7',
							'10'
						),
						'default' => '3',
						'desc' => __( 'Number of item to show', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[feed url="http://rss1.smashingmagazine.com/feed/" limit="5"]',
				'desc' => __( 'Feed grabber', 'shortcodes-ultimate' )
			),
			# menu
			'menu' => array(
				'name' => 'Menu',
				'type' => 'wrap',
				'atts' => array(
					'name' => array(
						'values' => array( ),
						'default' => '',
						'desc' => __( 'Custom menu name', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[menu name="Main menu"]',
				'desc' => __( 'Custom menu by name', 'shortcodes-ultimate' )
			),
			# subpages
			'subpages' => array(
				'name' => 'Sub pages',
				'type' => 'single',
				'atts' => array(
					'depth' => array(
						'values' => array(
							'1',
							'2',
							'3'
						),
						'default' => '1',
						'desc' => __( 'Depth level', 'shortcodes-ultimate' )
					),
					'p' => array(
						'values' => false,
						'default' => '',
						'desc' => __( 'Parent page ID', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[subpages]<br/>[subpages depth="2" p="122"]',
				'desc' => __( 'Page childrens', 'shortcodes-ultimate' )
			),
			# siblings
			'siblings' => array(
				'name' => 'Siblings',
				'type' => 'single',
				'atts' => array(
					'depth' => array(
						'values' => array(
							'1',
							'2',
							'3'
						),
						'default' => '1',
						'desc' => __( 'Depth level', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[siblings]<br/>[siblings depth="2"]',
				'desc' => __( 'Page childrens', 'shortcodes-ultimate' )
			),
			# column
			'column' => array(
				'name' => 'Column',
				'type' => 'wrap',
				'atts' => array(
					'size' => array(
						'values' => array(
							'1-2',
							'1-3',
							'1-4',
							'1-5',
							'1-6',
							'2-3',
							'2-5',
							'3-4',
							'3-5',
							'4-5',
							'5-6'
						),
						'default' => '1-2',
						'desc' => __( 'Column width', 'shortcodes-ultimate' )
					),
					'last' => array(
						'values' => array(
							'0',
							'1'
						),
						'default' => '0',
						'desc' => __( 'For last columns', 'shortcodes-ultimate' )
					),
					'style' => array(
						'values' => array(
							'0',
							'1',
							'2'
						),
						'default' => '0',
						'desc' => __( 'You can define custom styles for each columns set', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[column size="1-2"] Content [/column]<br/>[column size="1-2" last="1"] Content [/column]',
				'desc' => __( 'Flexible columns', 'shortcodes-ultimate' )
			),
			# table
			'table' => array(
				'name' => 'Table',
				'type' => 'mixed',
				'atts' => array(
					'style' => array(
						'values' => array(
							'1',
							'2',
							'3'
						),
						'default' => '1',
						'desc' => __( 'Table style', 'shortcodes-ultimate' )
					),
					'file' => array(
						'values' => false,
						'default' => '',
						'desc' => __( 'Create table from CSV', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[table style="1"] <table> … <table> [/table]<br/>[table style="1" file="http://example.com/file.csv"] [/table]',
				'desc' => __( 'Styled table from HTML or CSV file', 'shortcodes-ultimate' )
			),
			# media
			'media' => array(
				'name' => 'Media',
				'type' => 'single',
				'atts' => array(
					'url' => array(
						'values' => false,
						'default' => '',
						'desc' => __( 'Media URL', 'shortcodes-ultimate' )
					),
					'width' => array(
						'values' => false,
						'default' => '600',
						'desc' => __( 'Width', 'shortcodes-ultimate' )
					),
					'height' => array(
						'values' => false,
						'default' => '400',
						'desc' => __( 'Height', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[media url="http://www.youtube.com/watch?v=2c2EEacfC1M"]<br/>[media url="http://vimeo.com/15069551"]<br/>[media url="video.mp4"]<br/>[media url="video.flv"]<br/>[media url="audio.mp3"]<br/>[media url="image.jpg"]',
				'desc' => __( 'YouTube video, Vimeo video, .mp4/.flv video, .mp3 file or images', 'shortcodes-ultimate' )
			),
			# document
			'document' => array(
				'name' => 'Document',
				'type' => 'single',
				'atts' => array(
					'file' => array(
						'values' => false,
						'default' => '',
						'desc' => __( 'Document URL', 'shortcodes-ultimate' )
					),
					'width' => array(
						'values' => false,
						'default' => '600',
						'desc' => __( 'Width', 'shortcodes-ultimate' )
					),
					'height' => array(
						'values' => false,
						'default' => '400',
						'desc' => __( 'Height', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[document file="file.doc" width="600" height="400"]',
				'desc' => __( '.doc, .xls, .pdf viewer by Google', 'shortcodes-ultimate' )
			),
			# nivo_slider
			'nivo_slider' => array(
				'name' => 'Nivo slider',
				'type' => 'single',
				'atts' => array(
					'width' => array(
						'values' => false,
						'default' => '600',
						'desc' => __( 'Slider width', 'shortcodes-ultimate' )
					),
					'height' => array(
						'values' => false,
						'default' => '300',
						'desc' => __( 'Slider height', 'shortcodes-ultimate' )
					),
					'link' => array(
						'values' => array(
							'none',
							'file',
							'attachment',
							'caption'
						),
						'default' => 'none',
						'desc' => __( 'Slides links', 'shortcodes-ultimate' )
					),
					'speed' => array(
						'values' => false,
						'default' => '600',
						'desc' => __( 'Animation speed (1000 = 1 second)', 'shortcodes-ultimate' )
					),
					'delay' => array(
						'values' => false,
						'default' => '3000',
						'desc' => __( 'Animation delay (1000 = 1 second)', 'shortcodes-ultimate' )
					),
					'p' => array(
						'values' => false,
						'default' => '',
						'desc' => __( 'Post/page ID', 'shortcodes-ultimate' )
					),
					'effect' => array(
						'values' => array(
							'random',
							'boxRandom',
							'fold',
							'fade'
						),
						'default' => 'random',
						'desc' => __( 'Animation effect', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[nivo_slider]<br/>[nivo_slider width="600" height="300" link="file" effect="boxRandom"]',
				'desc' => __( 'Nivo slider by attached to post images', 'shortcodes-ultimate' )
			),
			# jcarousel
			'jcarousel' => array(
				'name' => 'jCarousel',
				'type' => 'single',
				'atts' => array(
					'width' => array(
						'values' => false,
						'default' => '600',
						'desc' => __( 'Carousel width', 'shortcodes-ultimate' )
					),
					'height' => array(
						'values' => false,
						'default' => '130',
						'desc' => __( 'Carousel height', 'shortcodes-ultimate' )
					),
					'bg' => array(
						'values' => false,
						'default' => '#EEEEEE',
						'desc' => __( 'Carousel background', 'shortcodes-ultimate' )
					),
					'items' => array(
						'values' => array(
							'3',
							'4',
							'5'
						),
						'default' => '3',
						'desc' => __( 'Number of items to show', 'shortcodes-ultimate' )
					),
					'link' => array(
						'values' => array(
							'none',
							'file',
							'attachment',
							'caption'
						),
						'default' => 'none',
						'desc' => __( 'Items links', 'shortcodes-ultimate' )
					),
					'speed' => array(
						'values' => false,
						'default' => '400',
						'desc' => __( 'Animation speed (1000 = 1 second)', 'shortcodes-ultimate' )
					),
					'p' => array(
						'values' => false,
						'default' => '',
						'desc' => __( 'Post/page ID', 'shortcodes-ultimate' )
					)
				),
				'usage' => '[jcarousel]<br/>[jcarousel width="600" height="130" link="file" items="5" bg="#EEEEEE" speed="400"]',
				'desc' => __( 'jCarousel by attached to post images', 'shortcodes-ultimate' )
			)
		);

		if ( $shortcode )
			return $shortcodes[$shortcode];
		else
			return $shortcodes;
	}

?>