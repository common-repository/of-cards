	jQuery(document).ready(function($){
	  var mediaUploader;

	  $('.upload-img').click(function(e) {
	  var input = $(this).prev('input').attr('id');
		//e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		 /* if (mediaUploader) {
		  mediaUploader.open();
		  return;
		}*/

		//console.log('input: '+input); 
		// Extend the wp.media object
		mediaUploader = wp.media.frames.file_frame = wp.media({
		  title: 'Choose Image',
		  button: {
		  text: 'Choose Image'
		}, multiple: false });
	 
		// When a file is selected, grab the URL and set it as the text field's value
		mediaUploader.on('select', function() {
			console.log(mediaUploader.state().get('selection').toJSON());
		  attachment = mediaUploader.state().get('selection').first().toJSON();
		  $('#'+input).val(attachment.url); 
		  $('#'+input).next('span').html('<img src="'+attachment.url+'"/>');

		});
		// Open the uploader dialog
		mediaUploader.open();
		//return false;
	  }); // End upload function 



	  $('.img-uploade-btn').click(function(e) {
	  var input = $(this).attr('id');
	  //alert(input);
		//e.preventDefault();
		// If the uploader object has already been created, reopen the dialog
		 /* if (mediaUploader) {
		  mediaUploader.open();
		  return;
		}*/

		//console.log('input: '+input); 
		// Extend the wp.media object
		mediaUploader = wp.media.frames.file_frame = wp.media({
		  title: 'Choose Image',
		  button: {
		  text: 'Choose Image'
		}, multiple: false });
	 
		// When a file is selected, grab the URL and set it as the text field's value
		mediaUploader.on('select', function() {
			console.log(mediaUploader.state().get('selection').toJSON());
		  attachment = mediaUploader.state().get('selection').first().toJSON();
		  $( "<input style='display:none;' type='checkbox' checked name='card-backend[]' value='"+attachment.url+"'/><span class='upload-img-backend-card'><img src='"+attachment.url+"'/><span class='delete-back-img'><div alt='f182' class='dashicons dashicons-trash'></div></span></span>").insertBefore( "#"+input );
		  //$('#'+input).val(attachment.url); 
		  //$('#'+input).next('span').html('<img src="'+attachment.url+'"/>');
		});
		// Open the uploader dialog
		mediaUploader.open();
		//return false;
	  }); // End upload function 


		$(document.body).on('click', 'span.delete-back-img', function(){
			$(this).closest('span.upload-img-backend-card').prev('input').remove();
			$(this).closest('span.upload-img-backend-card').remove();
		}); // End Delete Function 


	  }); // End Document Ready 