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
                  // $('.'+value.replace('-hide','')).val("").parentsUntil('.mce-formitem').hide();
                  $('.'+value.replace('-hide','')).attr("disabled", true);
                  $('.'+value.replace('-hide','')).addClass("mce-disabled");
                  $('.'+value.replace('-hide','')).siblings(".mce-label").addClass("mce-disabled");
              }            
              if( value.indexOf("-show") > -1 ) {
                  // console.log(value);
                  // $('.'+value.replace('-show', '')).parentsUntil('.mce-formitem').show();
                  $('.'+value.replace('-show','')).removeAttr("disabled");
                  $('.'+value.replace('-show','')).removeClass("mce-disabled");
                  $('.'+value.replace('-show','')).siblings(".mce-label").removeClass("mce-disabled");
                  
              }     
          });       
        }

        $(document).on('click', '.mce-optional', function() {
          //when changing the button style options, hide necesarry fields
          caredove_hide_fields(this);

          // Copy the button style dropdown value to a hidden select field
          var variables = $(this).attr('class').split(' ');
          var button_style = '';

          variables.map(function(value) {
              if( value.indexOf("mce-caredove-style-") > -1 ) {
                  
                  var button_style = value.replace('mce-caredove-style-','');
                  // console.log('new style - ' + button_style);
                  $('select.caredove_button_style').val(button_style).change();
              }                          
          });                           
        });

        $(document).on('change', 'select.caredove_button_style', function() {
          do_button_style();
        });

        $(document).on('keyup, input', '.mce-caredove_button_text, .mce-caredove_button_color, .mce-caredove_text_color', function() {                         
          do_button_style();
        });        

        function do_button_style() {          
            var style_name = "";
            var button_color = "";
            var text_color = "#ffffff";
            var button_text = "";
            var style_inline = "";
            var thestyles = $('select.caredove_button_style').val();

            if($('.mce-caredove_button_text').val().length > 0){
              button_text = $('.mce-caredove_button_text').val();
            }else {
              button_text = $('.mce-caredove_button_text').attr('placeholder');
            }
            
            if($('.mce-caredove_button_color').val().length > 0){
                console.log('button color is filled');
                button_color = $('.mce-caredove_button_color').val();
            } else {
                button_color = "#00A4FF";
            }


            thestyles = thestyles.split('-');

            if($('.mce-caredove_text_color').val().length > 0){
                text_color = $('.mce-caredove_text_color').val();
            } else if(button_color == '#00A4FF' && thestyles[0] == 'outline') {
                text_color = "#00A4FF";
            }

            
            if(thestyles != null){
              if(thestyles == 'default') {
                $('.mce-caredove_button_color').val('');
                $('.mce-caredove_text_color').val('');
              }
              
              style_name += 'caredove-button-'+thestyles[0]+' ';
              style_name += 'caredove-button-'+thestyles[1]+' ';
              
              if(thestyles[0] == 'solid'){
                style_inline = 'background-color:'+button_color+';'+'color:'+text_color+';';
              } else {
                style_inline = 'border-color:'+button_color+';'+'color:'+text_color+';';
              };
              
              var button = '<button type="button" class="caredove-inline-link caredove-styled-button '+style_name+'" style="'+style_inline+'">'+button_text+'</button>';
              $('.mce-caredove-sample-button-wrapper').html(button);
            }
            
        };
      
        //controls which fields to show or hide depending on a given dropdown option
                        
        $(document).on('click', '.mce-caredove-sample-button-wrapper-show', function() {
          $('.mce-caredove-sample-button-wrapper').show();
        });
        $(document).on('click', '.mce-caredove-style-default', function() {
          $('.mce-caredove-sample-button-wrapper').hide();
        });
})( jQuery );
