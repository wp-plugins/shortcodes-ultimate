jQuery(document).ready(function($) {

	// Code editor
	var gn_custom_editor = CodeMirror.fromTextArea(document.getElementById("su-custom-css"), {});

	// Tabs
	$('#su-wrapper .su-pane:first').show();
	$('#su-tabs a').click(function() {
		$('.su-message').hide();
		$('#su-tabs a').removeClass('su-current');
		$(this).addClass('su-current');
		$('#su-wrapper .su-pane').hide();
		$('#su-wrapper .su-pane').eq($(this).index()).show();
		gn_custom_editor.refresh();
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