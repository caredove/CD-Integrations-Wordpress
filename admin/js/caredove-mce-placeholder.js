(function($){
    /*
     * Create the TinyMCE plugin object.
     * 
     * See http://www.tinymce.com/wiki.php/Creating_a_plugin for more information
     * on how to create TinyMCE plugins.
     */
    
    tinymce.create( 'tinymce.plugins.visualShortcodes', {
        
        /*
         * Create the function to initialize our plugin. We're going to set up all the
         * properties necessary to function and then set some event handlers to make everything
         * work properly.
         * 
         * This function takes two arguments:
         * 
         * ed: the Editor object (this code will run once for each editor on the page)
         * url: the URL of the directory that this file resides in
         */
        init : function( ed, url ){
            
            // A counter will help us assign unique ids to each shortcode in this editor.
            this.counter = 0;
            
            // Set up some variables
            var t = this,
                i,
                shortcode,
                names = [];
            
            // Save the url in the object so that it's accessible elsewhere
            t.url = url;

            // Pull in the shortcodes object that we stored in the class-caredove-admin.php initialization object earlier
            // t._shortcodes = tinymce.i18n['visualShortcode.shortcodes'];
            t._shortcodes = caredove_tinymce_options;
            // Alternately, you can hardcode the shortcodes here:
                // t._shortcodes = [];
                // t._shortcodes[0] = {shortcode:"caredove", image:"https://via.placeholder.com/350x150", command:"caredoveiframe"};

            if( !t._shortcodes || undefined === t._shortcodes.length || 0 == t._shortcodes.length ){
                // If we don't have any shortcodes, we don't need to do anything else. Bail immediately.
                return;
            }
            // Set up the shortcodes object and fill it with the shortcodes
            t.shortcodes = {};

            for( i = 0, shortcode = t._shortcodes[i]; i < t._shortcodes.length; shortcode = t._shortcodes[++i]){
                if(undefined === shortcode.shortcode || '' == shortcode.shortcode || undefined === shortcode.image || '' == shortcode.image){
                    /*
                     * All shortcodes must have a non-empty string for the shortcode and image properties.
                     * If those conditions are not met, skip to the next one.
                     */
                    continue;
                }                
                t.shortcodes[shortcode.shortcode] = shortcode;
                names.push(shortcode.shortcode);
            }

            if( names.length < 1 ){
                // Again, if we don't have any valid shortcodes to work with, bail.
                return;
            }

            t._buildRegex( names );  
            //This is the editor popup, values are defined in class-caredove-admin.php     
            for (var key in t.shortcodes){

              ed.addCommand('editImage', function( img, shortcode ) {
                    var attributes = {};
                    var hide_stuff = [];
                    $('body').addClass("modal-open");
                    // console.log('shortcode Value: ' + shortcode);                
                    // console.log('this is the img tag: ' + img.length);
                    if (img.length != 0) {
                        t.shortcodes[shortcode].buttons['1'].text = "Update";
                    } else {
                        t.shortcodes[shortcode].buttons['1'].text = "Insert";
                    }
                    // override the object values with content from our HTML element when double clicked
                    // This isn't the most efficient way of pulling in the HTMl element content
                    // I will find a faster way
                    // console.log('test');
                    if(img.match(/[\w-]+=(["']).*?\1/g) != null){
                      img.match(/[\w-]+=(["']).*?\1/g).forEach(function(attribute) {
                        attribute = attribute.match(/([\w-]+)=(["'])(.*?)\2/);
                        attributes[attribute[1]] = attribute[3];
                      });                       

                      for(i=0; i < t.shortcodes[shortcode].popupbody.length; i++) {
                        if(attributes.hasOwnProperty(t.shortcodes[shortcode].popupbody[i].name)){
                        //show the class of the field if set
                        // console.log('class = ' + t.shortcodes[shortcode].popupbody[i].classes);
                        // console.log(attributes.hasOwnProperty(t.shortcodes[shortcode].popupbody[i].name));
                          if(t.shortcodes[shortcode].popupbody[i].hasOwnProperty('checked')){
                            t.shortcodes[shortcode].popupbody[i].checked = attributes[t.shortcodes[shortcode].popupbody[i].name];
                          } 
                          t.shortcodes[shortcode].popupbody[i].value = attributes[t.shortcodes[shortcode].popupbody[i].name];                                                                   
                            // console.log(t.shortcodes[shortcode].popupbody[i].name);                                                                                     
                            // console.log(t.shortcodes[shortcode].popupbody[i].value);
                        // if(t.shortcodes[shortcode].popupbody[i].classes){
                        //     if(t.shortcodes[shortcode].popupbody[i].classes.includes('embedded')) {
                        //         hide_stuff.push('embedded');
                        //     }
                        // }
                          if(t.shortcodes[shortcode].popupbody[i].value == 'embedded'){
                            hide_stuff.push('embedded');
                          } else if (t.shortcodes[shortcode].popupbody[i].value == 'link') {
                            hide_stuff.push('link');
                          } else if (t.shortcodes[shortcode].popupbody[i].value == 'default') {
                            hide_stuff.push('default');
                          } else if (t.shortcodes[shortcode].popupbody[i].value == 'modal') {
                            hide_stuff.push('modal');
                          }                          
                        } else {
                            t.shortcodes[shortcode].popupbody[i].value = '';
                        }
                      }                     
                    };
                                                           
                    
                    // Open window
                    ed.windowManager.open({
                      title: t.shortcodes[shortcode].title,
                      width: jQuery(window).width() - 500 > 800 ? jQuery(window).width() - 500 : jQuery(window).width() - 40,
                      height: (jQuery(window).height() > 500 ? jQuery(window).height() - 150 : jQuery(window).height() - 100 ),
                      resizable : true,
                      maximizable: true,
                      inline: true,
                      autoScroll: false, 
                      scrollbars: true,
                      buttons: t.shortcodes[shortcode].buttons,
                      body: t.shortcodes[shortcode].popupbody,
                      onsubmit: function( e ) {
                        var popupValues = e.data;
                        var placeholder = "";
                        
                        for(var key in popupValues){
                            
                            if(key == 'page_url'){
                                popupValues[key] = popupValues[key].replace(/(\/#|\/|#)$/, ''); //removes trailing slash
                                popupValues[key] = popupValues[key].replace(/^https?\:\/\/([^\/?#]+)(?:[\/?#]|$)/, ''); //removes any http and base url
                            }
                            if(popupValues[key] == ''){
                                //don't add the shortcode param, if it's blank
                            } else {
                                placeholder = placeholder + ' ' + key + '="' + popupValues[key] + '"';
                            }
                          
                        }                          
                        // placeholder = placeholder + index +'="'+item'"';
                        ed.insertContent( '['+ t.shortcodes[shortcode].shortcode + ' ' + placeholder + ']' );
                        $('body').removeClass("modal-open");
                      },
                      onclose: function(e) {   
                        $('body').removeClass("modal-open");
                      },
                      onrepaint: function(e) {
                        var window_id = this._id;                                                                                        
                        button_styles = attributes['button_style']; 
                        // console.log(button_styles);
                        $('select.caredove_button_style').val(button_styles).change();
                                                     
                        //moved this function to the caredove-admin.js file
                        // do_button_style();

                        if(!$('#' + window_id).hasClass('form-initialized')) {                                 

                            $('#' + window_id).addClass('form-initialized');
                            textboxwidth = $('#' + window_id).width() - 380 + 'px';
                            $('.mce-caredove-tinymce-page_url').before($('<span style="left:162px;position:absolute;padding-top:6px;">https://www.caredove.com/</span>'));
                            $('.mce-caredove-tinymce-page_url').css({'left': '340px','width': textboxwidth});                            
                            
                            $('.caredove-sample-view-link').attr('href', attributes['page_url']);

                            var inputs = $('#' + window_id + '-body');

                            for(var i=0; i < hide_stuff.length; i++){

                                if (hide_stuff !== ''){                                                                
                                    console.log('hide_stuff =' + hide_stuff[i]);
                                    inputs.find('.mce-caredove_hide-'+hide_stuff[i]).attr("disabled", true);
                                    inputs.find('.mce-caredove_hide-'+hide_stuff[i]).addClass("mce-disabled");
                                    inputs.find('.mce-caredove_hide-'+hide_stuff[i]).siblings(".mce-label").addClass("mce-disabled");
                                    inputs.find('.mce-caredove_hide-sample').hide();
                                }                         
                            }
                            if(img.length == 0){
                                // console.log('hide_stuff =' + hide_stuff[i]);
                                //hide stuff when this is a new item we're adding                                    
                                inputs.find('.mce-caredove_hide-modal').attr("disabled", true);
                                inputs.find('.mce-caredove_hide-modal').addClass("mce-disabled");
                                inputs.find('.mce-caredove_hide-modal').siblings(".mce-label").addClass("mce-disabled");
                                inputs.find('.mce-caredove_hide-default').attr("disabled", true);
                                inputs.find('.mce-caredove_hide-default').addClass("mce-disabled");
                                inputs.find('.mce-caredove_hide-default').siblings(".mce-label").addClass("mce-disabled");
                                // inputs.find('.mce-caredove_hide-embedded').attr("disabled", true);
                                // inputs.find('.mce-caredove_hide-embedded').addClass("mce-disabled");
                                // inputs.find('.mce-caredove_hide-embedded').siblings(".mce-label").addClass("mce-disabled");
                                inputs.find('.mce-caredove_hide-sample').hide();
                            }   
                        }                                                           
                    },                  
                    
                    });
              });
            };
            ed.on( 'DblClick', function( e ) {
                var image,
                node = e.target,
                dom = ed.dom;
                //add in rule that only when double clicking on a particular shortcode image do you show the popup with
                //the particulars from that shortcode
                var cls  = e.target.className.indexOf('jpbVisualShortcode');
                if ( e.target.nodeName == 'IMG' && e.target.className.indexOf('jpbVisualShortcode') > -1 ) {
                  var image = e.target.attributes['title'].value;
                  var shortcode = e.target.attributes['data-shortcode'].value;
                  ed.execCommand('editImage', image, shortcode);                  
                  // ed.windowManager.setParams({params:e.target.attributes});
                  // console.log(ed.windowManager.getParams());
                  // console.log(ed.dom);                  
                }
            });
              

            // This fires as the content is turned into an HTML string
            ed.on( 'PostProcess', function( event ) {
            if ( event.get ) {
                event.content = event.content.replace( / data-wp-chartselect="1"/g, '' );
            }
            });

            /*
             * Add an event handler for our plugin on the editor's 'change' event. This function
             * replaces the shortcodes with their images and updates the content of the editor as
             * the contents of the editor are being changed.
             * 
             * The 'change' event fires each time there is an 'undo-able' block change made.
             */
            ed.on('change', function(o){
                if( !t.regex.test(o.content)){
                    /*
                     * We shouldn't bother with changing anything and repainting the editor if we
                     * don't even have a regex match on our shortcodes.
                     */
                    return;
                }
                
                // Get the updated content
                o.content = t._doScImage( o.content );
                // Set the new content
                ed.setContent(o.content);
                // Repaint the editor
                ed.execCommand('mceRepaint');
            });

            /*
             * Add an event handler for our plugin on the editor's 'beforesetcontent' event. This
             * will swap the shortcode out for its image when the editor is initialized, or
             * whenever switching from HTML to Visual mode.
             */
            ed.on('BeforeSetContent', function(o){
                if( !t.regex.test(o.content)){
                    /*
                     * We shouldn't bother with changing anything and repainting the editor if we
                     * don't even have a regex match on our shortcodes.
                     */
                    return;
                }
                
                /*
                 * Honestly, I'm not sure why/how this works. We don't return anything and are
                 * making the change directly on the object passed in as the second argument. How
                 * does this change the content of the editor? I don't know. But it seems to work.
                 * 
                 * For whatever reason, this does not require a full setting / repainting of the
                 * editor's content like the function above.
                 * 
                 * This code was borrowed from the WordPress gallery TinyMCE plugin.
                 */
                o.content = t._doScImage( o.content );
            });

            /*
             * Add an event handler for our plugin on the editor's 'postprocess' event. This
             * changes the images back to shortcodes before saving the content to the form field
             * and when switching from Visual mode to HTML mode.
             * 
             * This code was borrowed from the WordPress gallery TinyMCE plugin.
             */
            ed.on('PostProcess', function(o) {
                if( o.get ){
                    o.content = t._getScImage( o.content );
                }
            });

            /*
             * Add an event handler for the plugin on the editor's initialization event. This
             * sets up some global event handlers to hide the buttons if the user scrolls or
             * if they drag something with their mouse.
             * 
             * This code was borrowed from the WordPress gallery TinyMCE plugin.
             */
            ed.on('Init', function(ed) {

              //do nothing

            });

        },

        _doButton: function( bc, co ){
            var t = this;
            // console.log('co: ' + JSON.stringify(co));
            
            button_fill = '#00A4FF';
            button_border = '#00A4FF';
            font_color = '#FFFFFF';
            button_text = 'Book Now (default)';
                        
            if(bc.button_style == "solid-md" || bc.button_style == "solid-lg" || bc.button_style == "solid-sm"){
                if(typeof bc.button_color !== 'undefined'){
                    button_fill = bc.button_color;
                    button_border = bc.button_color;
                }
                if(typeof bc.text_color !== 'undefined'){
                    font_color= bc.text_color;                   
                } 

            } else if(bc.button_style == "outline-md" || bc.button_style == "outline-lg" || bc.button_style == "outline-sm") {
                button_fill = 'transparent';
                if(typeof bc.button_color !== 'undefined'){
                    button_border = bc.button_color;
                }
                if(typeof bc.text_color !== 'undefined'){
                    font_color= bc.text_color;                   
                } 
            } else {
                font_color = '#FFFFFF';
                button_fill = '#000000';
                button_border = '#000000';
            }
        
            if(button_fill == 'transparent' && font_color == '#FFFFFF'){
                font_color = '#00A4FF';
            }            

            var fontSize = 14;

            if(typeof bc.button_text !== 'undefined'){
                button_text = bc.button_text
            } else {
                if(co.includes('caredove_search')){
                    button_text = 'Search (default)';
                }
            }

            
            var buttonWidth = button_text.length * fontSize/2 + 30;                    
            

            image = "<svg id='Layer_1' data-name='Layer 1' xmlns='http://www.w3.org/2000/svg' width='"+buttonWidth+"' height='50'><title>Placeholder Button</title><g><rect x='0' y='0' width='"+buttonWidth+"' height='50' fill='"+button_fill+"' stroke='"+button_border+"' stroke-width='4'></rect><text x='50%' y='50%' font-family='Verdana' font-size='"+fontSize+"' fill='"+font_color+"' dominant-baseline='middle' text-anchor='middle'>"+ button_text +"</text></g></svg>";    
            image = "data:image/svg+xml;base64," + btoa(image);

            return image;           
        },
        /*
         * Replace shortcodes with their respective images.
         * 
         * For each match, the function will replace it with an image. The arguments correspond,
         * respectively, to:
         *  - the whole matched string (the whole shortcode, possibly wrapped in <p> tags)
         *  - the name of the shortcode
         *  - the arguments of the shortcode (could be an empty string)
         * 
         * The id of the shortcode image will start with 'vscImage', followed by the current counter
         * value (which is incremented as it's used, so next time it will be different), a hyphen, and 
         * the name of the shortcode.
         * 
         * The class 'mceItem' prevents WordPress's normal image management icons from showing up when
         * the image is clicked.
         * 
         * The arguments of the shortcode are encoded and stored in the 'title' attribute of the image.
         * 
         * This code is based largely on the WordPress gallery TinyMCE plugin.
         */
        _doScImage: function( co ){
            var t = this;
            return co.replace( t.regex, function(a,b,c){
                c = c.replace(/\\([\s\S])|(\/")/, "\\$1$2");
                var shortcode_fields = {};
                c.match(/[\w-]+=(["']).*?\1/g).forEach(function(field) {    
                    field = field.match(/([\w-]+)=(["'])(.*?)\2/);                    
                    // console.log('field ' + field[1] + '=' + field[3]);
                    shortcode_fields[field[1]] = field[3];    
                    
                });
                if(shortcode_fields.button_text != '' && t.shortcodes[b].button != 'false'){
                   image = t._doButton(shortcode_fields, co);
                    // console.log(image);
                } else {
                    image = t.shortcodes[b].image;
                }
                
                return '<img src="'+image+'" id="vscImage'+(t.counter++)+'-'+b+'" class="mceItem jpbVisualShortcode" title="' + b + tinymce.DOM.encode(c) + '" data-mce-resize="false" data-mce-placeholder="1" data-shortcode="' + t.shortcodes[b].shortcode + '" />';
                // return '<div style="background:#000;width:200px;height:40px;" id="vscImage'+(t.counter++)+'-'+b+'" class="mceItem jpbVisualShortcode" title="' + b + tinymce.DOM.encode(c) + '" data-mce-resize="false" data-mce-placeholder="1" data-shortcode="' + t.shortcodes[b].shortcode + '"></div>';
            });
        },

        /*
         * Replace images with their respective shortcodes.
         * 
         * This code is based mostly on the WordPress gallery TinyMCE plugin.
         */
        _getScImage: function( co ){
            // Used to grab the title/class attributes and decode them
            function getAttr(s, n) {
                n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
                return n ? tinymce.DOM.decode(n[1]) : '';
            };

            return co.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,im) {
                var cls = getAttr(im, 'class');

                if ( cls.indexOf('jpbVisualShortcode') != -1 )
                    return '<p>['+tinymce.trim(getAttr(im, 'title'))+']</p>';

                return a;
            });
        },

        /*
         * Builds the plugin's shortcode for finding registered shortcodes
         * 
         * The regex is global and case insensitive, and only searches for self-closing
         * shortcodes.
         */
        _buildRegex: function( names ){
            var t = this,
            reString = '';

            reString = '\\\[(' + names.join('|') + ')(( [^\\\]]+)*)\\\]';
            t.regex = new RegExp( reString, 'gi' );
        },

      
    });

    // Add the plugin object to the TinyMCE plugin manager
    tinymce.PluginManager.add( 'visualshortcodes', tinymce.plugins.visualShortcodes );
    
})(jQuery);