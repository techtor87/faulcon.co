jQuery(document).ready(function($) { 

	$(document).on('change', '.bbp-div-toggle', function() {
		var target = $(this).data('target');
		var show = $("option:selected", this).data('show');
		$(target).children().addClass('hidden');
		$(show).removeClass('hidden');
	});
	$(document).ready(function(){
		$('.bbp-div-toggle').trigger('change');
	});

});

jQuery(function ($) {
	$("#better-block-patterns").tabs({
		classes: {"ui-tabs-active": "current"},
		active: localStorage.getItem("bbpCurrentSettingsTab"),
		activate: function (event, ui) {
			localStorage.setItem("bbpCurrentSettingsTab", $(this).tabs('option', 'active'));
		}
	});
});