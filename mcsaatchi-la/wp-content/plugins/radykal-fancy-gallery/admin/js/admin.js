
//-----------Document ready----------

jQuery(document).ready(function($) {

	$ = jQuery.noConflict();
	
	$(document).find('.fg-button').removeClass('button');
	
	//set colorpickers
	if($(document).find('.colorpicker').length) {
		$('.colorpicker').spectrum({
			color: $(this).val(),
			preferredFormat: "hex",
			showInput: true,
			chooseText: "Change Color",
			change: function(color) {
				$(this).val(color.toHexString());
			}
		});
	}
	
	//disable all links
	if($(document).find('.fg-disable-links').length) {
		disableLinks = true;
		var galleriesAccordion = $('#galleries-accordion'),
			accordion_body = $('#galleries-accordion li > .sub-menu');
		$('.fg-disable-links').find('.button-secondary, .button-primary, .upload-button, .fg-button').unbind().fadeTo(0, 0.5);
		galleriesAccordion.undelegate('.fg-add-album', 'click');
		galleriesAccordion.undelegate('.fg-delete', 'click');
		galleriesAccordion.undelegate('.fg-edit', 'click');
		galleriesAccordion.undelegate('.fg-edit-album-description', 'click');
		$('.fg-disable-links').find('input:submit').attr('disabled', 'disabled');
		if(accordion_body.size() > 0) {
			accordion_body.sortable('disable');
		}
		$('.fg-paste-options').die('click');
	};
	
});