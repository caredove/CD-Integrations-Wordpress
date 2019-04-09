(function( $ ) {
	'use strict';
	
    		$(document).ready(function(){
            $('#insert-caredove-search-page').on('click', function() {
            	 var ed = tinyMCE.activeEditor;
            	 //format:: ed.execCommand('tinyMceCommand', 'image values', 'shortcode_code');
            	 ed.execCommand('editImage', '', 'caredove_search');
          	});
          	$('#insert-caredove-button').on('click', function() {
            	 var ed = tinyMCE.activeEditor;
							 //format:: ed.execCommand('tinyMceCommand', 'image values', 'shortcode_code');
            	 ed.execCommand('editImage', '', 'caredove_button');
          	});
          	$('#insert-caredove-listings').on('click', function() {
            	 var ed = tinyMCE.activeEditor;
            	 //format:: ed.execCommand('tinyMceCommand', 'image values', 'shortcode_code');
            	 ed.execCommand('editImage', '', 'caredove_listings');
          	}); 
        });

        function caredove_hide_fields(item){
          var variables = $(item).attr('class').split(' ');

          variables.map(function(value) {
              if( value.indexOf("-hide") > -1 ) {
                  // console.log(value);
                  $('.'+value.replace('-hide','')).val("").parentsUntil('.mce-formitem').hide();
              }            
              if( value.indexOf("-show") > -1 ) {
                  // console.log(value);
                  $('.'+value.replace('-show', '')).parentsUntil('.mce-formitem').show();
              }     
          });       
        }

        // $(".caredove-admin-button").on('click', function() {
        //   caredove_hide_fields('.mce-caredove_button_style');
        // });
        //controls which fields to show or hide depending on a given dropdown option
        $(document).on('click', '.mce-optional', function() {
          caredove_hide_fields(this);
        });                
        $(document).on('click', '.mce-caredove-sample-button-wrapper-show', function() {
          $('.mce-caredove-sample-button-wrapper').show();
        });
        $(document).on('click', '.mce-caredove-style-default', function() {
          $('.mce-caredove-sample-button-wrapper').hide();
        });
})( jQuery );
