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

        $(document).on('click', '.mce-caredove-booking-button-link', function() {

          // Copy the button style dropdown value to a hidden select field
          // var links = $(this).attr('class').split(' ');

          var variables = $(this).attr('class').split(' ');
          var preview_link = '';


          variables.map(function(value) {
              if( value.indexOf("mce-http") > -1 ) {
                  // console.log(variables);        
                  var preview_link = value.replace('mce-','');
                  // console.log(preview_link);
                  $('.caredove-sample-view-link').attr('href', preview_link);
              }                          
          });                           
        });

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
                // console.log('button color is filled');
                button_color = $('.mce-caredove_button_color').val();
            } else {
                button_color = "#00A4FF";
            }          
            
            if(thestyles != null){

              thestyles = thestyles.split('-');

              if($('.mce-caredove_text_color').val().length > 0){
                  text_color = $('.mce-caredove_text_color').val();
              } else if(button_color == '#00A4FF' && thestyles[0] == 'outline') {
                  text_color = "#00A4FF";
              }
              
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

              var svgIcon = '<svg class="svg-icon" viewBox="0 0 20 20"><path style="stroke:'+text_color+';" d="M18.125,15.804l-4.038-4.037c0.675-1.079,1.012-2.308,1.01-3.534C15.089,4.62,12.199,1.75,8.584,1.75C4.815,1.75,1.982,4.726,2,8.286c0.021,3.577,2.908,6.549,6.578,6.549c1.241,0,2.417-0.347,3.44-0.985l4.032,4.026c0.167,0.166,0.43,0.166,0.596,0l1.479-1.478C18.292,16.234,18.292,15.968,18.125,15.804 M8.578,13.99c-3.198,0-5.716-2.593-5.733-5.71c-0.017-3.084,2.438-5.686,5.74-5.686c3.197,0,5.625,2.493,5.64,5.624C14.242,11.548,11.621,13.99,8.578,13.99 M16.349,16.981l-3.637-3.635c0.131-0.11,0.721-0.695,0.876-0.884l3.642,3.639L16.349,16.981z"></path></svg>';
              var svgImage = '<img src="data:image/svg+xml;base64,'+btoa(svgIcon)+'">';

              var button = '<button type="button" class="caredove-inline-link caredove-styled-button '+style_name+'" style="'+style_inline+'">'+svgImage+button_text+'</button>';
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
