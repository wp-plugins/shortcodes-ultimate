jQuery(document).ready(function($) {

	// Code editor
	var editor = CodeMirror.fromTextArea(document.getElementById("su-custom-css"), {});

	// Tabs
	$('.wrap .su-pane:first').show();
	$('#su-tabs').delegate('li:not(.su-current)', 'click', function() {
		$(this).addClass('su-current').siblings().removeClass('su-current')
		.parents('.wrap').find('.su-pane').hide().eq($(this).index()).fadeIn(150);
		editor.refresh();
	});
});