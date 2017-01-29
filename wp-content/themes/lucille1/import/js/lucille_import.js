jQuery(document).ready(function($) {
	$('.import_lucille_btn').click(function(){

		if ($(this).attr('disabled') == 'disabled') {
			return;
		}
		
		$('#import_message').empty();
		showMessage($, "Preparing to import <strong>"+$(this).data('importname')+"</strong> demo...");
		prepareImportUI($);
		showMessage($, "Importing demo content. This may take up to several minutes to complete, please be patient...");
		
		/*import content/set menu location and set static front page */
		var importName = $(this).data('importname');

		setTimeout(function(){
			beforeImportContent($, importName);
		}, 500);		

	});
});

function beforeImportContent($, importName) {
	showMessage($, "Checking existing data...");

	var data = {
		action: 'LUCILLE_SWP_check_import_data'
	};

	$.post(ajaxurl, data, function(response) {
		var obj;
			
		try {
			obj = $.parseJSON(response);
		}
		catch(e) {
			showMessage($, e);
			removeImportUI($);
			return;
		}
		
		if(obj.success === true) {
			showMessage($, "Finished. Importing content...");
			setTimeout(function(){
				importJSContent($, importName, 1);
			}, 2000);			
		} else {
			showMessage($, 'There was an error when trying to import: <strong>'+obj.import_error+'</strong>');
		}
	}).fail(function(xhr, textStatus, ajaxError){
		showAjaxFailMessage($, xhr);
	});	
}

function importJSContent($, importName, importPart) {
	var IMPORT_PARTS = 2;
	
	showMessage($, "Importing content step "+importPart+" of "+IMPORT_PARTS+"...");
	
	var data = {
		action: 'LUCILLE_SWP_import_content',
		demo_import: importName,
		import_part: importPart
	};
	
	$.post(ajaxurl, data, function(response) {
		var obj;
			
		try {
			obj = $.parseJSON(response);
		}
		catch(e) {
			showMessage($, e);
			removeImportUI($);
			return;
		}
		
		if(obj.success === true) {
			showMessage($, "Content step "+importPart+" of "+IMPORT_PARTS+" imported successfully.");
			showMessage($, "<br>"+obj.import_error, true);
			
			if (importPart < IMPORT_PARTS) {
				prepareImportUI($);
				importJSContent($, importName, importPart+1);
			} else {
				prepareImportUI($);
				setStaticFrontPage($, importName);
				
				prepareImportUI($);
				setImportThemeSettings($, importName);				
			}
		} else {
			showMessage($, 'There was an error when trying to import: <strong>'+obj.import_error+'</strong>');
		}

	}).fail(function(xhr, textStatus, ajaxError){
		showAjaxFailMessage($, xhr);
	});
}

function setStaticFrontPage($, importName) {
	var data = {
		action: 'LUCILLE_SWP_set_static_front_page',
		demo_import: importName
	};
	
	$.post(ajaxurl, data, function(response) {
		var obj;
			
		try {
			obj = $.parseJSON(response);
		}
		catch(e) {
			showMessage($, e);
			removeImportUI($);
			return;
		}
		
		if(obj.success === true) {
			showMessage($, "Static front page set successfully.");
			showMessage($, "<br>"+obj.import_error, true);
		} else {
			showMessage($, 'There was an error when trying to set static front page: <strong>'+obj.import_error+'</strong>');
		}

		removeImportUI($);
	});	
}

function setImportThemeSettings($, importName) {
	var data = {
		action: 'LUCILLE_SWP_set_import_theme_settings',
		demo_import: importName
	};
	
	$.post(ajaxurl, data, function(response) {
		var obj;
			
		try {
			obj = $.parseJSON(response);
		}
		catch(e) {
			showMessage($, e);
			removeImportUI($);
			return;
		}
		
		if(obj.success === true) {
			showMessage($, "Theme settings set successfully.");
			showMessage($, "<br>"+obj.import_error, true);


			var getTheSliderMsg = '<div class="updated">All done, <strong>'+importName+'</strong> demo is now imported on your installation.<br>';
			getTheSliderMsg += 'Please go to <strong>Slider Revolution -> Import Slider</strong> and import the slider used in this demo.';
			getTheSliderMsg += '<br>All sliders used in the Lucille demos are included in the full download package as <strong>zip</strong> files.</div>';
			setTimeout(function(){
				showMessage($, getTheSliderMsg);
				$("html, body").animate({ scrollTop: $(document).height() }, 1000);
			}, 600);
			
		} else {
			showMessage($, 'There was an error when trying to set theme settings: <strong>'+obj.import_error+'</strong>');
		}

		removeImportUI($);
	});	
}

function showMessage($, msg, hideElem = false) {
	if (!hideElem) {
		$('#import_message').append('<p>'+msg+'</p>');
	} else {
		$('#js_swp_import_details').append(msg);
	}
}

function showAjaxFailMessage($, xhr) {
	showMessage($, "Lucille Demo Importer returned with the following error: <strong>"+xhr.status+" ("+xhr.statusText+").</strong>", false);
	if (500 == xhr.status)  {
		var messageDetails = '<div class="updated js_server_error">This error indicates that the Lucille Demo Importer cannot successfully import the demo under the current <strong>PHP memory limit.</strong> ';
		messageDetails += "<br>Don't worry, this is a common problem on web servers that have low PHP memory limit, and your hosting provider can easily fix this. ";
		messageDetails += "<br>Please contact your hosting support service, and ask them to increase the amount of memory dedicated to php.";
		messageDetails += "<br>If something is not clear or you need more details, feel free to mail us to support@smartwpress.com.</div>";
		showMessage($, messageDetails, false);
	}
	removeImportUI($);
}

function prepareImportUI($) {
	$('.import_lucille_btn').attr('disabled', true);
	$('.import_items').css('opacity','0.1');
	$('.import_spinner').show();	
}

function removeImportUI($) {
	$('.import_items').css('opacity','1');
	$('.import_spinner').hide();
	$('.import_lucille_btn ').attr('disabled', false);
}