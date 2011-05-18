jQuery(document).ready(function($) {

	// Code editor
	var editor = CodeMirror.fromTextArea(document.getElementById("su-custom-css"), {});

	// Tabs
	$('.wrap .su-pane:first').show();
	$('#su-tabs').delegate('a:not(.su-current)', 'click', function() {
		$(this).addClass('su-current').siblings().removeClass('su-current')
		.parents('.wrap').find('.su-pane').hide().eq($(this).index()).show();
		editor.refresh();
		$('.su-message').hide();
	});

	// Forms
	$('#su-form-save-settings').ajaxForm({
		beforeSubmit: function() {
			$('#su-form-save-settings .su-message-success').hide();
			$('#su-form-save-settings .su-message-loading').slideDown(200);
		},
		success: function() {
			$('#su-form-save-settings .su-message-success, #su-form-save-settings .su-message-loading').fadeOut(200);
			$('#su-form-save-settings .su-message-success').fadeIn(200);
			setTimeout('jQuery("#su-form-save-settings .su-message-success").slideUp(100)', 2000);
		}
	});

	$('#su-form-save-custom-css').ajaxForm({
		beforeSubmit: function() {
			$('#su-form-save-custom-css .su-message-success').hide();
			$('#su-form-save-custom-css .su-message-loading').slideDown(200);
		},
		success: function() {
			$('#su-form-save-custom-css .su-message-success, #su-form-save-custom-css .su-message-loading').fadeOut(200);
			$('#su-form-save-custom-css .su-message-success').fadeIn(200);
			setTimeout('jQuery("#su-form-save-custom-css .su-message-success").slideUp(100)', 2000);
		}
	});
});