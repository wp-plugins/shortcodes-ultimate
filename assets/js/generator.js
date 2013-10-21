jQuery(document).ready(function ($) {

	// Prepare data
	var $generator = $('#su-generator'),
		$search = $('#su-generator-search'),
		$filter = $('#su-generator-filter'),
		$filters = $filter.children('a'),
		$choices = $('#su-generator-choices'),
		$choice = $choices.find('span'),
		$settings = $('#su-generator-settings'),
		$prefix = $('#su-compatibility-mode-prefix'),
		$result = $('#su-generator-result'),
		$selected = $('#su-generator-selected'),
		mce_selection = '';

	// Apply qTip to choices
	$choice.each(function () {
		var $c = $(this);
		if ($c.attr('title') != '') $c.qtip({
			style: {
				classes: 'qtip-bootstrap'
			},
			position: {
				my: 'bottom center',
				at: 'top center'
			}
		});
	});

	// Generator button
	$('body').on('click', '.su-generator-button', function (e) {
		e.preventDefault();
		// Save the target
		window.su_generator_target = $(this).data('target');
		// Get open shortcode
		var shortcode = $(this).data('shortcode');
		// Open magnificPopup
		$(this).magnificPopup({
			type: 'inline',
			alignTop: true,
			callbacks: {
				open: function () {
					// Open queried shortcode
					if (shortcode) $choice.filter('[data-shortcode="' + shortcode + '"]').trigger('click');
					// Focus search field when popup is opened
					else window.setTimeout(function () {
						$search.focus();
					}, 200);
					// Change z-index
					$('body').addClass('su-generator-shown');
					// Save selection
					mce_selection = (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor.selection !== null) ? tinyMCE.activeEditor.selection.getContent({
						format: "text"
					}) : '';
				},
				close: function () {
					// Clear search field
					$search.val('');
					// Hide settings
					$settings.html('').hide();
					// Remove narrow class
					$generator.removeClass('su-generator-narrow');
					// Show filters
					$filter.show();
					// Show choices panel
					$choices.show();
					$choice.show();
					// Clear selection
					mce_selection = '';
					// Change z-index
					$('body').removeClass('su-generator-shown');
				}
			}
		}).magnificPopup('open');
	});

	// Filters
	$filters.click(function (e) {
		// Prepare data
		var filter = $(this).data('filter');
		// If filter All, show all choices
		if (filter === 'all') $choice.show();
		// Else run search
		else {
			var regex = new RegExp(filter, 'gi');
			// Hide all choices
			$choice.hide();
			// Find searched choices and show
			$choice.each(function () {
				// Get shortcode name
				var group = $(this).data('group');
				// Show choice if matched
				if (group.match(regex) !== null) $(this).show();
			});
		}
		e.preventDefault();
	});

	// Go to home link
	$('#su-generator').on('click', '.su-generator-home', function (e) {
		// Clear search field
		$search.val('');
		// Hide settings
		$settings.html('').hide();
		// Remove narrow class
		$generator.removeClass('su-generator-narrow');
		// Show filters
		$filter.show();
		// Show choices panel
		$choices.show();
		$choice.show();
		// Clear selection
		mce_selection = '';
		// Focus search field
		$search.focus();
		e.preventDefault();
	});

	// Generator close button
	$('#su-generator').on('click', '.su-generator-close', function (e) {
		// Close popup
		$.magnificPopup.close();
		// Prevent default action
		e.preventDefault();
	});

	// Search field
	$search.on({
		focus: function () {
			// Clear field
			$(this).val('');
			// Hide settings
			$settings.html('').hide();
			// Remove narrow class
			$generator.removeClass('su-generator-narrow');
			// Show choices panel
			$choices.show();
			$choice.show();
			// Show filters
			$filter.show();
		},
		blur: function () {},
		keyup: function (e) {
			var val = $(this).val(),
				regex = new RegExp(val, 'gi');
			// Hide all choices
			$choice.hide();
			// Find searched choices and show
			$choice.each(function () {
				// Get shortcode name
				var name = $(this).children('strong').text(),
					desc = $(this).data('desc'),
					group = $(this).data('group');
				// Show choice if matched
				if (name.match(regex) !== null) $(this).show();
				else
				if (desc.match(regex) !== null) $(this).show();
				else
				if (group.match(regex) !== null) $(this).show();
			});
		}
	});

	// Click on shortcode choice
	$choice.on('click', function (e) {
		// Prepare data
		var shortcode = $(this).data('shortcode');
		// Load shortcode options
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'su_generator_settings',
				shortcode: shortcode
			},
			beforeSend: function () {
				// Hide preview box
				$('#su-generator-preview').hide();
				// Hide choices panel
				$choices.hide();
				// Show loading animation
				$settings.addClass('su-loading-animation').show();
				// Add narrow class
				$generator.addClass('su-generator-narrow');
				// Hide filters
				$filter.hide();
			},
			success: function (data) {
				// Hide loading animation
				$settings.removeClass('su-loading-animation');
				// Insert new HTML
				$settings.html(data);
				// Apply selected text to the content field
				if (typeof mce_selection !== 'undefined' && mce_selection !== '') $('#su-generator-content').val(mce_selection);
				// Init color pickers
				$('.su-generator-select-color').each(function (index) {
					$(this).find('.su-generator-select-color-wheel').filter(':first').farbtastic('.su-generator-select-color-value:eq(' +
						index + ')');
					$(this).find('.su-generator-select-color-value').focus(function () {
						$('.su-generator-select-color-wheel:eq(' + index + ')').show();
					});
					$(this).find('.su-generator-select-color-value').blur(function () {
						$('.su-generator-select-color-wheel:eq(' + index + ')').hide();
					});
				});
				// Init reload galleries links
				$('.su-generator-reload-galleries').each(function () {
					var $attr = $(this).parents('.su-generator-attr-container'),
						$list = $attr.find('select:first');
					$(this).click(function (e) {
						e.preventDefault();
						// Perform request
						$.ajax({
							type: 'POST',
							url: ajaxurl,
							data: {
								action: 'su_generator_galleries'
							},
							beforeSend: function () {
								$attr.addClass('su-generator-uploading');
								$list.html('<option value="0">' + $list.data('loading') + '&hellip;</option>');
							},
							success: function (data) {
								$list.html(data).trigger('change');
								$attr.removeClass('su-generator-uploading');
							}
						});
					});
				});
				// Init upload buttons
				$('.su-generator-upload-button').each(function () {
					var $button = $(this),
						$val = $(this).parents('.su-generator-attr-container').find('input:text'),
						file;
					$button.on('click', function (e) {
						e.preventDefault();
						e.stopPropagation();
						// If the frame already exists, reopen it
						if (typeof (file) !== 'undefined') file.close();
						// Create WP media frame.
						file = wp.media.frames.customHeader = wp.media({
							// Title of media manager frame
							title: su_generator.upload_title,
							library: {
								type: 'image'
							},
							button: {
								//Button text
								text: su_generator.upload_insert
							},
							// Do not allow multiple files, if you want multiple, set true
							multiple: false
						});
						//callback for selected image
						file.on('select', function () {
							var attachment = file.state().get('selection').first().toJSON();
							$val.val(attachment.url).trigger('change');
						});
						// Open modal
						file.open();
					});
				});
				// Init icon pickers
				$('.su-generator-icon-picker-button').each(function () {
					var $button = $(this),
						$field = $(this).parents('.su-generator-attr-container'),
						$val = $field.find('input:text'),
						$picker = $field.find('.su-generator-icon-picker');

					$button.click(function (e) {
						$picker.toggleClass('su-generator-icon-picker-visible');
						if ($picker.html() !== '') return;
						// Load icons
						$.ajax({
							type: 'POST',
							url: ajaxurl,
							data: {
								action: 'su_generator_icons'
							},
							dataType: 'json',
							beforeSend: function () {
								// Show loading animation
								$picker.html(su_generator.loading_icons + '&hellip;');
							},
							success: function (data) {
								$picker.html('');
								$.each(data, function (icon) {
									$picker.append('<i class="icon-' + data[icon] + '" title="' + data[icon] + '"></i>');
								});
								$picker.find('i').click(function (e) {
									$val.val('icon: ' + $(this).attr('title'));
									$picker.removeClass('su-generator-icon-picker-visible');
									$val.trigger('change');
									e.preventDefault();
								});
							}
						});
						e.preventDefault();
					});
				});
				// Init switches
				$('.su-generator-switch').click(function (e) {
					// Prepare data
					var $switch = $(this),
						$value = $switch.parent().children('input'),
						is_on = !! ($value.val() === 'yes');
					// Disable
					if (is_on) {
						// Change class
						$switch.removeClass('su-generator-switch-yes').addClass('su-generator-switch-no');
						// Change value
						$value.val('no').trigger('change');
					}
					// Enable
					else {
						// Change class
						$switch.removeClass('su-generator-switch-no').addClass('su-generator-switch-yes');
						// Change value
						$value.val('yes').trigger('change');
					}
					e.preventDefault();
				});
				// Init tax_term selects
				$('select#su-generator-attr-taxonomy').on('change', function () {
					var $taxonomy = $(this),
						taxonomy = $taxonomy.val(),
						$terms = $('select#su-generator-attr-tax_term');
					// Load new options
					window.su_generator_get_terms = $.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'su_generator_get_terms',
							taxonomy: taxonomy
						},
						dataType: 'json',
						beforeSend: function () {
							// Check previous requests
							if (typeof window.su_generator_get_terms ===
								'object') window.su_generator_get_terms.abort();
							// Show loading animation
							$terms.parent().addClass('su-generator-uploading');
						},
						success: function (data) {
							// Remove previous options
							$terms.find('option').remove();
							// Append new options
							for (var slug in data) {
								$terms.append('<option value="' + slug + '">' + data[slug] + '</option>');
							}
							// Hide loading animation
							$terms.parent().removeClass('su-generator-uploading');
						}
					});
				});
				// Init shadow pickers
				$('.su-generator-shadow-picker').each(function (index) {
					var $picker = $(this),
						$fields = $picker.find('.su-generator-shadow-picker-field input'),
						$hoff = $picker.find('.su-generator-sp-hoff'),
						$voff = $picker.find('.su-generator-sp-voff'),
						$blur = $picker.find('.su-generator-sp-blur'),
						$color = {
							cnt: $picker.find('.su-generator-shadow-picker-color'),
							value: $picker.find('.su-generator-shadow-picker-color-value'),
							wheel: $picker.find('.su-generator-shadow-picker-color-wheel')
						},
						$val = $picker.find('.su-generator-attr');
					// Init color picker
					$color.wheel.farbtastic($color.value);
					$color.value.focus(function () {
						$color.wheel.show();
					});
					$color.value.blur(function () {
						$color.wheel.hide();
					});
					// Handle text fields
					$fields.on('change blur keyup', function () {
						$val.val($hoff.val() + 'px ' + $voff.val() + 'px ' + $blur.val() + 'px ' + $color.value.val()).trigger('change');
					});
				});
				// Remove skip class when setting is changed
				$settings.find('.su-generator-attr').on('change keyup blur', function () {
					var $cnt = $(this).parents('.su-generator-attr-container'),
						_default = $cnt.data('default'),
						val = $(this).val();
					// Value is changed
					if (val != _default) $cnt.removeClass('su-generator-skip');
					else $cnt.addClass('su-generator-skip');
				});
				// Init value setters
				$('.su-generator-set-value').click(function (e) {
					$(this).parents('.su-generator-attr-container').find('input').val($(this).text()).trigger('change');
				});
				// Save selected value
				$selected.val(shortcode);
			},
			dataType: 'html'
		});
	});

	// Insert shortcode
	$('#su-generator').on('click', '.su-generator-insert', function (e) {
		// Prepare data
		var shortcode = su_generator_parse();
		if (typeof window.su_generator_target !== 'undefined' && window.su_generator_target !== 'content') {
			// Prepare target
			var $target = $('#' + window.su_generator_target);
			// Insert into target
			$target.val($target.val() + shortcode);
		}
		// Insert into editor
		else window.wp.media.editor.insert(shortcode);
		// Close popup
		$.magnificPopup.close();
		// Save shortcode to div
		$result.text(shortcode);
		// Prevent default action
		e.preventDefault();
	});

	// Preview shortcode
	$('#su-generator').on('click', '.su-generator-toggle-preview', function (e) {
		// Prepare data
		var $button = $(this);
		// Update link text
		$button.hide(); //.text($button.data('update-text'));
		// Bind updating on settings changes
		if (!$button.hasClass('su-preview-enabled')) $settings.find('input, textarea, select').on('change keyup blur', function () {
			su_generator_update_preview();
		});
		// Add ready-class
		$button.addClass('su-preview-enabled');
		// Update preview box
		su_generator_update_preview();
		// Prevent default action
		e.preventDefault();
	});

	function su_generator_parse() {
		// Prepare data
		var query = $selected.val(),
			prefix = $prefix.val(),
			$settings = $('#su-generator-settings .su-generator-attr-container:not(.su-generator-skip) .su-generator-attr'),
			content = $('#su-generator-content').val(),
			result = new String('');
		// Open shortcode
		result += '[' + prefix + query;
		// Add shortcode attributes
		$settings.each(function () {
			// Prepare field and value
			var $this = $(this),
				value = '';
			// Selects
			if ($this.is('select')) value = $this.find('option:selected').val();
			// Other fields
			else value = $this.val();
			// Check that value is not empty
			if (value == null) value = '';
			else if (value !== '') result += ' ' + $(this).attr('name') + '="' + $(this).val() + '"';
		});
		// End of opening tag
		result += ']';
		// Wrap shortcode if content presented
		if (content != 'false') result += content + '[/' + prefix + query + ']';
		// Return result
		return result;
	}

	function su_generator_update_preview() {
		// Prepare data
		var $preview = $('#su-generator-preview'),
			shortcode = su_generator_parse(),
			previous = $result.text();
		// Request new preview
		if (shortcode !== previous || !$preview.is(':visible')) window.su_generator_preview_request = $.ajax({
			type: 'POST',
			url: ajaxurl,
			cache: false,
			data: {
				action: 'su_generator_preview',
				shortcode: shortcode
			},
			beforeSend: function () {
				// Abort previous requests
				if (typeof window.su_generator_preview_request ===
					'object') window.su_generator_preview_request.abort();
				// Show loading animation
				$preview.addClass('su-preview-loading').html('').show();
			},
			success: function (data) {
				// Hide loading animation and set new HTML
				$preview.html(data).removeClass('su-preview-loading');
			},
			dataType: 'html'
		});
		// Save shortcode to div
		$result.text(shortcode);
	}

});