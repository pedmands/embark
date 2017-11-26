jQuery(document).ready(function($) {
	var mediaUploader;

	// Upload profile picture button
	$( '#upload-button' ).on('click', function(e){
		e.preventDefault();
		if( mediaUploader ){
			mediaUploader.open();
			return;
		}

		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Upload a Profile Picture',
			button: {
				text: 'Choose Picture'
			},
			multiple: false
		});

		mediaUploader.on('select', function(){
			attachment = mediaUploader.state().get('selection').first().toJSON();
			$('#profile-picture').val(attachment.url);
			$('#profile-picture-preview').css('background-image', 'url(' + attachment.url + ')');
		});

		mediaUploader.open();

	}); // #upload-button

	// Remove profile picture button
	$('#remove-picture').on('click', function(e){
		e.preventDefault();
		var answer = confirm("Are you sure you want to remove your profile picture?");
		if (answer == true){
			$('#profile-picture').val('');
			$('.embark-general-form').submit();
		}
		return;
	});

});
