jQuery(document).ready(function($) {

	// Frame
	$('.su-frame-align-center, .su-frame-align-none').each(function() {
		var frame_width = $(this).find('img').width();
		$(this).css('width', frame_width + 12);
	});

	// Spoiler
	$('.su-spoiler').removeClass('su-spoiler-open');
	$('.su-spoiler .su-spoiler-title').click(function() {
		$(this).parent('.su-spoiler').toggleClass('su-spoiler-open');
	});

	// Tabs
	$('.su-tabs-nav').delegate('span:not(.su-tabs-current)', 'click', function() {
		$(this).addClass('su-tabs-current').siblings().removeClass('su-tabs-current')
		.parents('.su-tabs').find('.su-tabs-pane').hide().eq($(this).index()).show();
	});
	$('.su-tabs-pane').hide();
	$('.su-tabs-nav span:first-child').addClass('su-tabs-current');
	$('.su-tabs-panes .su-tabs-pane:first-child').show();

	// Tables
	$('.su-table tr:even').addClass('su-even');

});

function mycarousel_initCallback(carousel) {

	// Disable autoscrolling if the user clicks the prev or next button.
	carousel.buttonNext.bind('click', function() {
		carousel.startAuto(0);
	});

	carousel.buttonPrev.bind('click', function() {
		carousel.startAuto(0);
	});

	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
}