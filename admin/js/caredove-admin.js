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
        
        //updates the button preview in the popup when editing
        // $(document).on('change, keyup, input', '.mce-caredove_button_text, .mce-caredove_button_color, .mce-caredove_text_color', function() {
        //     console.log('input happening');
        //     var buttonDetails = {};
        //     var button_style = '';
            
        //     buttonDetails.button_text = $('.mce-caredove_button_text').val();
        //     button_style = $('.mce-optional.mce-active').attr('class').split(' ');

        //     console.log('button style = ' + button_style);

        //     if($('.mce-caredove_button_color').val().length > 0){
        //         buttonDetails.button_color = $('.mce-caredove_button_color').val();
        //     }
        //     if($('.mce-caredove_text_color').val().length > 0){
        //         buttonDetails.text_color = $('.mce-caredove_text_color').val();
        //     }
        //     const thestyles = button_style.map(function(value) {
        //         if( value.indexOf("mce-caredove-style-") > -1 ) {
        //             buttonDetails.button_style = value.replace('mce-caredove-style-','');                                
        //             buttonDetails.button_style = buttonDetails.button_style.split('-');
        //         }
        //     })
        //     Promise.all(thestyles).then(() => {
        //         sampleButton = doStyledButton(buttonDetails);
        //         $('.mce-caredove-sample-button-wrapper').html(sampleButton);
        //     });
        // });  
        
        // function doStyledButton( bc ){
        //   var style_name = '';

        //   bc.button_style.forEach(function (value, i){
        //      style_name += 'caredove-button-'+value+' ';
        //      switch(value){
        //          case 'outline':
        //              style_inline = 'border-color:'+bc.button_color+';'+'color:'+bc.text_color+';';
        //              break;
        //          case 'solid':
        //              style_inline = 'background-color:'+bc.button_color+';'+'color:'+bc.text_color+';';
        //              break;
        //      }
        //  });

        //  var button = '<button type="button" class="caredove-inline-link caredove-styled-button '+style_name+'" style="'+style_inline+'">'+bc.button_text+'</button>';
        //  return button;
        // }

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
