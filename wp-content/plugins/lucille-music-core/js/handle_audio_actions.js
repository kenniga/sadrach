jQuery(document).ready( function($) {

	/* call the album removal function on loading*/
	removeAudio();
	detectAudioMediaChanges();
	enableListSorting();
});	


function update_audio_list()
{
	var parent	= jQuery('form#post input#post_ID').prop('value');
	var data = {
	action: 'LUCILLE_SWP_update_my_audio_list',
	parent: parent
	};

	jQuery.post(ajaxurl, data, function(response) {
		var obj;
			
		try {
			obj = jQuery.parseJSON(response);
		} catch(e) { 
			/*catch some error*/
		}

		if(obj.success === true) { 
			jQuery('div#audio_list').replaceWith(obj.audio_list);
		} else {
			/*problems..*/
		}
	});
}

/*
	detect media changes on gallery post - trigger for update_gallery()
*/
function detectAudioMediaChanges()
{
	jQuery('#media-items').bind("DOMSubtreeModified", function() {
		update_audio_list();
	});
}	

function enableListSorting()
{
	try {
		jQuery( "#ul_sortable_list" ).sortable({
			update: function( event, ui ) {
				var trackOrder = jQuery(this).sortable('toArray').toString();
					
						
				var data = {
					action: 'LUCILLE_SWP_update_track_order',
					trackList: trackOrder,
				};

				
				jQuery.post(ajaxurl, data, function(response) 
				{
					var obj;
					
					try 
					{
						obj = jQuery.parseJSON(response);
						
					}
					catch(e) 
					{ 
					
						/*catch some error*/
					}
				
				});
			}
		});
		jQuery( "#ul_sortable_list" ).disableSelection();
	} catch (e) {
		
	}
}

/*
	album removal function - fired at load and after AJAX
*/
	
function removeAudio() 
{
	jQuery('span.remove_audio').on('click', function(event) {
		var audio	= jQuery(this).attr('rel');
		var parent	= jQuery('form#post input#post_ID').prop('value');
		
		var data = {
			action: 'LUCILLE_SWP_remove_from_album',
			audio: audio,
			parent: parent
		};
		
		jQuery.post(ajaxurl, data, function(response) {
			var obj;
			
			try {
				obj = jQuery.parseJSON(response);
				
			} catch(e) { 
				/*catch some error*/
			}

			if(obj.success === true) { 
				jQuery('div#audio_list').replaceWith(obj.tracklist);
				removeAudio();
			} else {
				/*problems..*/
			}
		});
	});
}
	

