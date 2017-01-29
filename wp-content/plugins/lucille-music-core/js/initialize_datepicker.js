jQuery(document).ready( function($) {
	'use strict';
	jQuery( "#datepicker" ).datepicker({
		dateFormat : "yy/mm/dd"
	});
	jQuery("#timepicker").timepicker();
});	