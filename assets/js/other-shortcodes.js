jQuery(document).ready(function($) {
	// Spoiler
	$('.su-spoiler-title').click(function(e) {
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
	$('.su-accordion .su-spoiler-title').click(function(e) {
		if ($(this).hasClass('su-spoiler-closed')) $(this).parent().siblings().addClass('su-spoiler-closed');
		e.preventDefault();
	});
	// Tabs
	$('.su-tabs-nav span').click(function(e) {
		var index = $(this).index(),
			$tabs = $(this).parent('.su-tabs-nav').children('span'),
			$panes = $(this).parents('.su-tabs').find('.su-tabs-pane'),
			$gmaps = $panes.eq(index).find('.su-gmap:not(.su-gmap-reloaded)');
		// Hide all panes, show selected pane
		$panes.hide().eq(index).show();
		// Disable all tabs, enable selected tab
		$tabs.removeClass('su-tabs-current').eq(index).addClass('su-tabs-current');
		// Reload gmaps
		if ($gmaps.length > 0) $gmaps.each(function() {
			var $iframe = $(this).find('iframe:first');
			$(this).addClass('su-gmap-reloaded');
			$iframe.attr('src', $iframe.attr('src'));
		});
		// Set height for vertical tabs
		su_set_tabs_height();
		e.preventDefault();
	});
	$('.su-tabs').each(function() {
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
	$('.su-lightbox').each(function() {
		$(this).click(function(e) {
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
	$('.su-frame-align-center, .su-frame-align-none').each(function() {
		var frame_width = $(this).find('img').width();
		$(this).css('width', frame_width + 12);
	});
});