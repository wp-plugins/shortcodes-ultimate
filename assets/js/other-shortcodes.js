jQuery(document).ready(function ($) {
	// Spoiler
	$('.su-spoiler-title').click(function (e) {
		var // Spoiler elements
		$title = $(this),
			$spoiler = $title.parent();
		// Open/close spoiler
		$spoiler.toggleClass('su-spoiler-closed');
		// Close other spoilers in accordion
		$spoiler.parent('.su-accordion').children('.su-spoiler').not($spoiler).addClass('su-spoiler-closed');
		e.preventDefault();
	});
	// Accordion
	$('.su-accordion .su-spoiler-title').click(function (e) {
		var $title = $(this),
			bar = ($('#wpadminbar').length > 0) ? 28 : 0;
		if ($title.hasClass('su-spoiler-closed')) $title.parent().siblings().addClass('su-spoiler-closed');
		if ($(window).scrollTop() > $title.offset().top) $(window).scrollTop($title.offset().top - $title.height() - bar);
		e.preventDefault();
	});
	// Tabs
	$('.su-tabs-nav span').click(function (e) {
		var $tab = $(this),
			index = $tab.index(),
			is_disabled = $tab.hasClass('su-tabs-disabled'),
			$tabs = $tab.parent('.su-tabs-nav').children('span'),
			$panes = $tab.parents('.su-tabs').find('.su-tabs-pane'),
			$gmaps = $panes.eq(index).find('.su-gmap:not(.su-gmap-reloaded)');
		// Check tab is not disabled
		if (is_disabled) return false;
		// Hide all panes, show selected pane
		$panes.hide().eq(index).show();
		// Disable all tabs, enable selected tab
		$tabs.removeClass('su-tabs-current').eq(index).addClass('su-tabs-current');
		// Reload gmaps
		if ($gmaps.length > 0) $gmaps.each(function () {
			var $iframe = $(this).find('iframe:first');
			$(this).addClass('su-gmap-reloaded');
			$iframe.attr('src', $iframe.attr('src'));
		});
		// Set height for vertical tabs
		su_set_tabs_height();
		e.preventDefault();
	});
	$('.su-tabs').each(function () {
		var active = parseInt($(this).data('active')) - 1;
		$(this).children('.su-tabs-nav').children('span').eq(active).trigger('click');
		su_set_tabs_height();
	});

	function su_set_tabs_height() {
		$('.su-tabs-vertical').each(function () {
			var $tabs = $(this),
				$panes = $(this).children('.su-tabs-panes'),
				height = 0;
			$panes.css('height', 'auto').css('height', $tabs.height());
		});
	}
	// Tables
	$('.su-table tr:even').addClass('su-even');
	// Magnific popup
	$('.su-lightbox').each(function () {
		$(this).click(function (e) {
			e.preventDefault();
			e.stopPropagation();
			if ($(this).parent().attr('id') === 'su-generator-preview') $(this).html(su_other_shortcodes.no_preview);
			else {
				var type = $(this).data('mfp-type');
				$(this).magnificPopup({
					type: type
				}).magnificPopup('open');
			}
		});
	});
	// Frame
	$('.su-frame-align-center, .su-frame-align-none').each(function () {
		var frame_width = $(this).find('img').width();
		$(this).css('width', frame_width + 12);
	});
	// Tooltip
	$('.su-tooltip').each(function () {
		var $tt = $(this),
			$content = $tt.find('.su-tooltip-content'),
			is_advanced = $content.length > 0,
			data = $tt.data(),
			config = {
				style: {
					classes: data.classes
				},
				position: {
					my: data.my,
					at: data.at,
					viewport: $(window)
				},
				content: {
					title: '',
					text: ''
				}
			};
		if (data.title !== '') config.content.title = data.title;
		if (is_advanced) config.content.text = $content;
		else config.content.text = $tt.attr('title');
		if (data.close === 'yes') config.content.button = true;
		if (data.behavior === 'click') {
			config.show = 'click';
			config.hide = 'click';
			$tt.click(function (e) {
				e.preventDefault();
				e.stopPropagation();
			});
			$(window).on('scroll resize', function () {
				$tt.qtip('reposition');
			});
		} else if (data.behavior === 'always') {
			config.show = true;
			config.hide = false;
			$(window).on('scroll resize', function () {
				$tt.qtip('reposition');
			});
		} else if (data.behavior === 'hover' && is_advanced) {
			config.hide = {
				fixed: true,
				delay: 600
			}
		}
		$tt.qtip(config);
	});
});