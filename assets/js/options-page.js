// Wait DOM
jQuery(document).ready(function ($) {

	// ########## Custom CSS screen ##########

	$('.su-custom-css-originals a').magnificPopup({
		type: 'iframe'
	});

	var editor = ace.edit('sunrise-plugin-field-custom_css-editor'),
		$textarea = $('#sunrise-plugin-field-custom_css').hide();
	editor.getSession().setValue($textarea.val());
	editor.getSession().on('change', function () {
		$textarea.val(editor.getSession().getValue());
	});
	editor.getSession().setMode('ace/mode/css');
	editor.setTheme('ace/theme/monokai');
	editor.getSession().setUseWrapMode(true);
	editor.getSession().setWrapLimitRange(null, null);
	editor.renderer.setShowPrintMargin(null);
	editor.session.setUseSoftTabs(null);

	// ########## Demos screen ##########

	// Even class for tables
	$('.su-table-demos tbody tr:even').addClass('even');
	// Shortcodes preview
	$('.su-preview').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});

	// ########## Galleries screen ##########

	// Create new gallery
	$('.su-gallery-create').click(function (e) {
		// Prepare data
		var $last = $('#su-galleries .su-gallery:last'),
			id = ($last.length > 0) ? $last.data('id') + 1 : 0,
			$gallery = $($.templates('#su_new_gallery_template').render([{
				id: id
			}]));
		// Hide not found message
		$('#su-galleries-not-found').hide();
		// Place new gallery
		$gallery.appendTo('#su-galleries');
		// Focus gallery name input
		$gallery.find('.su-gallery-name').focus();
		// Apply upload buttons actions
		apply_uploads();
		// Apply sortable
		apply_sortable()
		e.preventDefault();
	});
	// Open/close gallery
	$('.su-gallery-open, .su-gallery-close').live('click', function (e) {
		$(this).parents('.su-gallery').toggleClass('su-gallery-edit');
		$(this).parents('.su-gallery').find('.su-gallery-image').removeClass('su-gallery-image-edit');
		e.preventDefault();
	});
	// Close and save gallery
	$('.su-gallery-save-close').live('click', function (e) {
		$(this).parents('.su-gallery').removeClass('su-gallery-edit');
		$(this).parents('.su-gallery').find('.su-gallery-image').removeClass('su-gallery-image-edit');
		$('#sunrise-plugin-options-form').submit();
		e.preventDefault();
	});
	// Image preview
	$('.su-gallery-image-preview').live('click', function (e) {
		$(this).magnificPopup({
			type: 'image'
		}).magnificPopup('open');
		e.preventDefault();
	});
	// Delete gallery
	$('.su-gallery-delete').live('click', function (e) {
		var message = $('#su-galleries').data('delete-gallery-message');
		if (confirm(message)) {
			$(this).parents('.su-gallery').remove();
			$('#sunrise-plugin-options-form').submit();
		}
		e.preventDefault();
	});
	// Add new image, apply upload buttons actions
	apply_uploads();
	// Update images indexes
	update_images();
	// Apply sortables
	apply_sortable();
	// Open/close image
	$('.su-gallery-image-open, .su-gallery-image-title, .su-gallery-image-ok').live('click', function (e) {
		var $image = $(this).parents('.su-gallery-image');
		// Change image container class
		$image.toggleClass('su-gallery-image-edit');
		// Update image title
		$image.find('.su-gallery-image-title').text($image.find('.su-gallery-image-title-value').val());
		e.preventDefault();
	});
	// Delete image
	$('.su-gallery-image-delete').live('click', function (e) {
		// Get message
		var message = $('#su-galleries').data('delete-image-message');
		// Confirm deletion
		if (confirm(message)) $(this).parents('.su-gallery-image').remove();
		// Update images indexes
		update_images();
		e.preventDefault();
	});

	// Apply sortable

	function apply_sortable() {
		$('.su-gallery-content').sortable({
			items: '> .su-gallery-image',
			handle: '.su-gallery-image-sort-handle',
			axis: 'y',
			stop: function (event, ui) {
				update_images();
			}
		});
	}

	function apply_uploads() {
		$('.su-gallery-add-image:not(.su-gallery-add-image-ready) a').each(function () {
			var $button = $(this),
				$cnt = $button.parent(),
				$gallery = $(this).parents('.su-gallery'),
				files;
			$button.on('click', function (e) {
				e.preventDefault();
				e.stopPropagation();
				// If the frame already exists, reopen it
				if (typeof (files) !== 'undefined') files.close();
				// Create WP media frame.
				files = wp.media.frames.customHeader = wp.media({
					// Title of media manager frame
					title: su_options_page.upload_title,
					library: {
						type: 'image'
					},
					button: {
						//Button text
						text: su_options_page.upload_insert
					},
					// Do not allow multiple files, if you want multiple, set true
					multiple: true
				});
				//callback for selected image
				files.on('select', function () {
					var attachments = files.state().get('selection').toJSON();
					$.each(attachments, function () {
						// Create new image section
						var att = this,
							$image = $($.templates('#su_new_image_template').render([{
								id: 999,
								title: att.title,
								gallery_id: $gallery.data('id'),
								image: att.url
							}]));
						// Append new image to gallery content
						$cnt.after($image);
						// Update images indexes
						update_images();
					});
				});
				// Open modal
				files.open();
			});
			// Add ready class
			$(this).addClass('su-gallery-add-image-ready');
		});
	}

	function update_images() {
		// Loop through galleries
		$('#su-galleries .su-gallery').each(function () {
			// Prepare gallery data
			var $gallery = $(this),
				id = $gallery.data('id');
			// Loop through images
			$gallery.find('.su-gallery-image').each(function (i) {
				// Loop through fields
				$(this).find('[data-field]').each(function () {
					$(this).attr('name', 'galleries[' + id + '][items][' + i + '][' + $(this).data('field') +
						']')
				});
			});

		});
	}

	/* Get filename from url */

	function get_file_title(url) {
		if (url) return url.substring(url.lastIndexOf("/") + 1, url.lastIndexOf("."));
		return "";
	}
});