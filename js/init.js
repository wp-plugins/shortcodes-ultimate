jQuery(document).ready(function($) {

	// Frame
	$('.su-frame-align-center').each(function() {
		var frame_width = $(this).find('img').width();
		$(this).css('width', frame_width + 12);
	});

	// Spoiler
	$('.su-spoiler').removeClass('su-spoiler-open');
	$('.su-spoiler .su-spoiler-title').click(function() {
		$(this).parent('.su-spoiler').toggleClass('su-spoiler-open');
	});

	// Tabs
	$('.su-tabs .su-tabs-pane').hide().filter(':first').show();
	$('.su-tabs-nav span').filter(':first').addClass('su-tabs-current');
	$('.su-tabs-nav').delegate('span:not(.su-tabs-current)', 'click', function() {
		$(this).addClass('su-tabs-current').siblings().removeClass('su-tabs-current').parents('.su-tabs').find('.su-tabs-pane').hide().eq($(this).index()).show();
	});

	// Tables
	$('.su-table tr:even').addClass('su-even');

});