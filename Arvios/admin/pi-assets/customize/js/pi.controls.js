;(function($, window, document, undefined)
{
    "use strict";

    $.piControl = function()
    {
        this.api = wp.customize;
       
        this.doc = $(document);
        // this.accessIframe = $('iframe').contents();
        this.uploadImage  = ".upload-img",
        this.pi_media_upload();
        this.pi_toggle(); 
        // this.pi_remove_img();
        this.pi_sort_section(); 
        this.pi_scroll_to();
        this.pi_wrap_block();
        this.pi_create_section();
        this.pi_edit_custom_section();
        this.pi_color_picker();
        this.pi_contact_info();
        this.pi_change_icon();
        this.pi_save_contact_detail();
        this.pi_cancel();
        this.pi_remove_custom_section();
    }  
  
    $.piControl.prototype =  
    {   
        pi_cancel: function()
        {
            $(".pi-cancel").click(function()
            {
                $(this).closest(".pi-hidden-here").addClass("hidden");
                // $(".back-drop").remove();
                $("#pi-create-section").attr("data-is_edit", false);
                return false;
            })
        },

        pi_save_contact_detail: function()
        {
            this.doc.on("click", "#pi-save-contact-detail", function(event)
            {
                event.preventDefault();

                var _nonce = $("[name='_pi_contact_detail_nonce']").val();
                var _data = ""; 
                $("#customize-control-pi_set_contact_info .pi-settings").wrap("<form id='pi-get-settings'></form>");
                _data = $("#pi-get-settings").serialize();
                $("#customize-control-pi_set_contact_info .pi-settings").unwrap();
                
                $.ajax(
                {
                    type: "POST",
                    url: ajaxurl,
                    data: {nonce: _nonce, data: _data, action: "pi_contact_info"},
                    success: function(res)
                    {
                        location.reload();
                    }
                })
               
            })
        },

        pi_change_icon: function()
        {
            this.doc.on("click", ".pi-wrap-editor .js_change_icon", function(event)
            {
                event.preventDefault();
                var _getIcon = "";
                $(".js_change_icon").removeClass("active");
                $(this).addClass("active");

                $("#fa-table-list li").click(function()
                {
                    _getIcon = $(this).children().attr("class");
                    $(".js_change_icon.active").children().attr("class", _getIcon);
                    $(".js_change_icon.active").next().val(_getIcon);
                })

               
            })

            this.doc.on("click", ".js_delete_item", function(event)
            {
                event.preventDefault();
                $(event.target).closest(".pi_contactinfo").remove();
            })
        },

        pi_media_upload: function()
        {   
            var obj = this; 
            var _self, file_frame, insertLink= "",  isMultile=true, liveInsertMe=false, $getData="", $realTime="", $jsUpload = ".js_upload", $caseSpecial="", typeBefore;
            obj.doc.on("click", obj.uploadImage,function()
            {   
                _self = $(this);
                $getData = _self.data();
                // var $sliderid = _self.closest($jsPanelSetting).data("sliderid");

                if ( !_self.hasClass("multiple") )
                { 
                    isMultile = false;
                }else{
                    isMultile = true;
                }

                typeBefore = localStorage.getItem("multiple");

                if(typeof(Storage) !== "undefined") 
                {
                   localStorage.setItem("multiple", isMultile);
                }
                
                $caseSpecial = typeof $getData.special != 'undefined' ? $getData.special : '';

                /* get id of input that will insert image src or images id to */
                insertLink=_self.data("insertlink")


                if ( file_frame && ( typeBefore == isMultile ) ) 
                {
                    file_frame.open();
                    return;
                }

                /* Create the media frame */
                file_frame = wp.media.frames.file_frame = wp.media(
                {
                    title: jQuery( this ).data( 'uploader_title' ),
                    button: {
                        text: jQuery(this).data('uploader_button_title'),
                    },
                    multiple: isMultile,

                })

                /* When an image or many images is selected, run a callback */
                file_frame.on("select", function()
                {
                    var selection = file_frame.state().get('selection');

                    switch (isMultile)
                    {
                        case true:

                            var ids = [], urls = [], idsurls = [];

                            selection.map(function(attachment)
                            {
                                attachment  = attachment.toJSON();
                                ids.push(attachment.id);
                                urls.push(attachment.url);
                            });

                            var oldids = $.map(_self.siblings(insertLink).val().split(","), function(value)
                            {
                                if (value != "")
                                {
                                    return parseInt(value, 10);
                                }
                            });

                            var $imgs = "", $slider="";
                            
                            for (var j = 0; j < ids.length; j++)
                            {
                                oldids.push(ids[j]); 

                                $imgs += '<li class="attachment img-item width-300" data-id="'+ids[j]+'">';
                                    $imgs += '<img data-src="'+urls[j]+'"  src="' + urls[j] + '" />';
                                    $imgs += '<a class="pi-remove customize-control" href="#" data-id="'+ids[j]+'">';
                                        $imgs += '<span class="dashicons dashicons-no"></span>';
                                    $imgs += '</a>';
                                $imgs += '</li>';

                                $slider += '<div class="slide">';
                                    $slider += urls[j];
                                $slider += '</div>';
                            }

                           
                            _self.siblings(insertLink).val(oldids);
                           
                            _self.siblings(".image-wrap").append($imgs);

                            if ( _self.hasClass("img_slider") )
                            {
                                obj.pi_hack_trigger("img_slider", obj);
                            }
                            

                            break;

                        case false:
                                var insert_link, origionUrl, getId;
                                selection.map(function(attachment)
                                {
                                    attachment  = attachment.toJSON();
                                    
                                    getId       =  attachment.id;
                                    insert_link  = attachment.url;
                                });

                                var $imgs="";
                                
                                if ( !_self.hasClass("custom_section") )
                                {
                                    $imgs += '<li class="attachment">';
                                        $imgs += '<img data-src="'+insert_link+'"  src="' + insert_link + '" />';
                                        $imgs += '<a class="pi-remove customize-control" href="#">';
                                            $imgs += '<span class="dashicons dashicons-no"></span>';
                                        $imgs += '</a>';
                                    $imgs += '</li>';
                                }else{
                                    $imgs += '<span>';
                                        $imgs += '<img data-src="'+insert_link+'"  src="' + insert_link + '" />';
                                    $imgs += '</span>';
                                }
                                

                                _self.siblings(".image-wrap").html($imgs);

                                if ( _self.hasClass("section_bg") )
                                { 
                                    _self.siblings(insertLink).val("");
                                    _self.siblings(insertLink).trigger("keypress");
                                    _self.siblings(insertLink).val(insert_link);
                                    _self.siblings(insertLink).trigger("change");
                                }else if(_self.hasClass("image_fixed")){
                                    _self.siblings(insertLink).val(insert_link);
                                    obj.pi_hack_trigger("image_fixed", obj);
                                }else if (  _self.hasClass("is_logo") )
                                {
                                    _self.siblings(insertLink).trigger("keypress");
                                    _self.next().val(insert_link);
                                    _self.siblings(insertLink).trigger("change");
                                }else
                                {
                                    _self.next().val(insert_link);
                                }
                                
                            break;
                    }
                   
                })
    
                /* Finally,  open the modal */
                file_frame.open();
                return false;
            });
        },
        pi_toggle: function()
        {
            var obj = this;
           
            // var $oSectionsBg = ["aboutus", "portfolio", "team", "services", "pricingtable", "contact", "twitter", "testimonial", "ourfacts"];
            PI_CONFIG = $.parseJSON(PI_CONFIG);

            var $oSections   = PI_CONFIG.name;
            var $oSectionsBg = PI_CONFIG.sections;

            $("#customize-control-pi_save_theme_options-theme_options-header-hack_youtube input, customize-control-pi_save_theme_options-theme_options-header-hack_img_slider, customize-control-pi_save_theme_options-theme_options-header-hack_tunna_slider, customize-control-pi_save_theme_options-theme_options-header-hack_imagefixed").val("");

            
            /*toggle display section*/
            var _oStatus = {};
            var $sectionStatus = $("#customize-control-pi_save_theme_options-theme_options-section-status input");
            var _total = $oSections.length;
            var $bgType = "", _oData={}, $img;
            $.each($oSectionsBg, function(i, val)
            {   
                _oStatus[val] = $("pi_save_theme_options[theme_options]["+val+"][enable]").is(":checked") ? 1 : 0;
                
                // if ( i == _total - 1 )
                // {
                //     _oStatus['contact_form'] = $("#customize-control-pi_save_theme_options-theme_options-contact-contact_form input").is(":checked") ?  1 : 0;
                //     _oStatus['enablegooglemap'] = $("#customize-control-pi_save_theme_options-theme_options-contact-enablegooglemap input").is(":checked") ?  1 : 0;
                //     $sectionStatus.trigger("change");
                //     $sectionStatus.val( encodeURIComponent(json.stringify(_total)) );
                //     $sectionStatus.trigger("change");
                // }
            // })


            /*Section Background*/
            
            // $.each($oSectionsBg, function(i, val)
            // {

                obj.pi_toggle_overlay(val);

                $("#customize-control-pi_save_theme_options-theme_options-"+val+"-background select").change(function()
                {
                    $bgType = $(this).find("option:selected").val();  

                    if ( $bgType == 'image' )
                    {
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-bg_img").fadeIn();
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-parallax").fadeIn();
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-parallax").find("input").trigger("change");
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay").fadeIn();
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay").find("input").trigger("change");
                    }else{
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-bg_img").fadeOut();
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-parallax").fadeOut();
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay").fadeOut();
                        $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay_color").fadeOut();
                    }

                    $("#customize-control-pi_save_theme_options-theme_options-"+val+"-hack_section_bg input").val("");
                    obj.pi_hack_section_bg(val, $bgType);
                }).trigger("change");

            
            })
    
            /*Custom Color*/
            $("#customize-control-pi_save_theme_options-theme_options-customcolor-enable input").change(function()
            {
                var $getColor = "";
                var $hackCustomColor = $("#customize-control-pi_save_theme_options-theme_options-hack_custom_color input");
                if ( $(this).is(":checked") )
                {   
                    $getColor = $("#customize-control-pi_save_theme_options-theme_options-pi_custom_color").find(".wp-color-result").css("background-color");
                    $hackCustomColor.trigger("change");
                    $hackCustomColor.val($getColor);
                    $hackCustomColor.trigger("change");
                }
            })

            /*Image For Mobile*/

            $("#customize-control-pi_save_theme_options-theme_options-video_options-videoplaceholder input").change(function()
            {
                if ( $(this).is(":checked") )
                {
                    $("#customize-control-pi_save_theme_options-theme_options-video_options-imageplaceholder").fadeIn();
                }else{
                    $("#customize-control-pi_save_theme_options-theme_options-video_options-imageplaceholder").fadeOut();
                }
            });

            // bg type
            $("#customize-control-pi_save_theme_options-theme_options-header-type select").change(function()
            {
                var getVal = $(this).find("option:selected").val();
               
                switch ( getVal )
                {
                    case 'youtube_bg':
                        $("[id*='img_slider'], [id*='tunna_slider'], [id*='text_slider'], [id*='image_fixed']").fadeOut();
                        $("[id*='youtube'], [id*='video_options'],[id*='header-title'], [id*='header-description']").fadeIn();
                        $("#customize-control-pi_save_theme_options-theme_options-header-sub_title, #customize-control-pi_save_theme_options-theme_options-header-button_name, #customize-control-pi_save_theme_options-theme_options-header-button_link, #customize-control-pi_save_theme_options-theme_options-header-overlay_color").fadeOut();
                        obj.pi_hack_trigger("youtube_bg", obj);
                    break;

                    case 'img_slider':
                       $("[id*='youtube'], [id*='tunna_slider'], [id*='text_slider'], [id*='image_fixed'], [id*='video_options']").fadeOut();
                       $("#customize-control-pi_save_theme_options-theme_options-header-sub_title, #customize-control-pi_save_theme_options-theme_options-header-button_name, #customize-control-pi_save_theme_options-theme_options-header-button_link, #customize-control-pi_save_theme_options-theme_options-header-overlay_color").fadeIn();
                       $("[id*='img_slider'],[id*='header-title'], [id*='header-description']").fadeIn();
                        obj.pi_hack_trigger("img_slider", obj);
                    break;
 
                    case 'bg_slideshow':
                        $("[id*='img_slider'], [id*='youtube'], [id*='text_slider'], [id*='image_fixed'], [id*='video_options'],[id*='header-title'], [id*='header-description']").fadeOut();
                        $("#customize-control-pi_save_theme_options-theme_options-header-sub_title, #customize-control-pi_save_theme_options-theme_options-header-button_name, #customize-control-pi_save_theme_options-theme_options-header-button_link, #customize-control-pi_save_theme_options-theme_options-header-overlay_color").fadeOut();
                        $("[id*='tunna_slider']").fadeIn();
                    break;

                    case 'text_slider':
                        $("[id*='img_slider'], [id*='tunna_slider'], [id*='youtube'], [id*='image_fixed'], [id*='video_options'],[id*='header-title'], [id*='header-description']").fadeOut();
                        $("#customize-control-pi_save_theme_options-theme_options-header-sub_title, #customize-control-pi_save_theme_options-theme_options-header-button_name, #customize-control-pi_save_theme_options-theme_options-header-button_link, #customize-control-pi_save_theme_options-theme_options-header-overlay_color").fadeOut();
                        $("[id*='text_slider']").fadeIn();
                        obj.pi_hack_trigger("text_slider", obj);
                    break;

                    case 'image_fixed':
                        $("[id*='img_slider'], [id*='youtube'], [id*='text_slider'], [id*='tunna_slider'], [id*='video_options']").fadeOut();
                        $("[id*='image_fixed'], [id*='header-title'], [id*='header-description']").fadeIn();
                        $("#customize-control-pi_save_theme_options-theme_options-header-sub_title, #customize-control-pi_save_theme_options-theme_options-header-button_name, #customize-control-pi_save_theme_options-theme_options-header-button_link, #customize-control-pi_save_theme_options-theme_options-header-overlay_color").fadeIn();
                        obj.pi_hack_trigger("image_fixed", obj);
                    break;
                }
            });

            $("#customize-control-pi_save_theme_options-theme_options-logo-type select").change(function()
            {
                var getVal = $(this).find("option:selected").val();
               
                switch ( getVal )
                {
                    case 'text':
                        $("[id*='logo-logo_nav'], [id*='logo-s_logo']").fadeOut();
                        $("[id*='logo-text'], [id*='logo_color']").fadeIn();
                    break;

                    case 'upload':
                        $("[id*='logo-logo_nav'], [id*='logo-s_logo']").fadeIn();
                        $("[id*='logo-text'], [id*='logo_color']").fadeOut();
                    break;
                }
            }).trigger("change"); 
            
            var $current = $("#customize-control-pi_save_theme_options-theme_options-header-type select").find("option:selected").val();

            switch ($current)
            {
                case 'youtube_bg':
                    $("[id*='img_slider'], [id*='tunna_slider'], [id*='text_slider'], [id*='image_fixed']").fadeOut();
                    $("[id*='youtube'], [id*='video_options'],  [id*='header-title']").fadeIn();
                break;

                case 'img_slider':
                   $("[id*='youtube'], [id*='tunna_slider'], [id*='text_slider'], [id*='image_fixed'], [id*='video_options']").fadeOut();
                   $("[id*='img_slider'],[id*='header-title']").fadeIn();
                   
                break;

                case 'bg_slideshow':
                    $("[id*='img_slider'], [id*='youtube'], [id*='text_slider'], [id*='image_fixed'], [id*='video_options'],[id*='header-title']").fadeOut();
                    $("[id*='tunna_slider']").fadeIn();
                break;

                case 'text_slider':
                    $("[id*='img_slider'], [id*='tunna_slider'], [id*='youtube'], [id*='image_fixed'], [id*='video_options'],  [id*='header-title']").fadeOut();
                    $("[id*='text_slider']").fadeIn();
                   
                break;

                default:
                    $("[id*='img_slider'], [id*='youtube'], [id*='text_slider'], [id*='tunna_slider'], [id*='video_options']").fadeOut();
                    $("[id*='image_fixed'], [id*='header-title']").fadeIn();
                break;
            }
            
            var $hackLogo = $("#customize-control-pi_save_theme_options-theme_options-logo-hack_logo input");
                $hackLogo.val("");
            $("#customize-control-pi_save_theme_options-theme_options-logo-type select").change(function()
            {
                var $select =  $(this).find("option:selected").val();

                if ( $select == 'upload' )
                {
                    $("#customize-control-pi_save_theme_options-theme_options-logo-text, #customize-control-pi_save_theme_options-theme_options-logo-logo_color ").fadeOut();
                    $("#customize-control-pi_save_theme_options-theme_options-logo-upload").fadeIn();
                }else{
                    $("#customize-control-pi_save_theme_options-theme_options-logo-text, #customize-control-pi_save_theme_options-theme_options-logo-logo_color ").fadeIn();
                    $("#customize-control-pi_save_theme_options-theme_options-logo-upload").fadeOut();
                }

                obj.pi_trigger_logo($hackLogo, $select);
            });
        },

        pi_toggle_overlay: function(val)
        {
            $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay").find("input").change(function()
            {
                if ( $(this).is(":checked") )
                {
                    $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay_color").fadeIn();
                }else{
                    $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay_color").fadeOut();
                }
            });
        },

        pi_trigger_logo: function($hackLogo, $selected)
        {
           var _oData = {};

            switch ($selected)
            {
                case 'upload':
                _oData['image'] = $("#customize-control-pi_save_theme_options-theme_options-logo-upload .wo-insert-link").val() ? $("#customize-control-pi_save_theme_options-theme_options-logo-upload .wo-insert-link").val() : 'http://placehold/130x130';
                _oData['type']  = 'image';
                break;
                default:
                 _oData['text'] = $("#customize-control-pi_save_theme_options-theme_options-logo-text input").val() ? $("#customize-control-pi_save_theme_options-theme_options-logo-text input").val() : 'Logo';
                _oData['type']  = 'text';
                _oData['text_color'] = $("#customize-control-pi_save_theme_options-theme_options-logo-logo_color .wp-color-result").css("background-color");
                break;
            }
            $hackLogo.trigger("change");
            $hackLogo.val( encodeURIComponent( JSON.stringify(_oData) ) );
            $hackLogo.trigger("change");
            $hackLogo.val("");
        },

        pi_hack_section_bg: function(val, $bgType)
        {
            var _oData = {},
                $img ="",
                $hack       = $("#customize-control-pi_save_theme_options-theme_options-"+val+"-hack_section_bg input"),
                $attachment = $("#customize-control-pi_save_theme_options-theme_options-"+val+"-bg_img .attachment"),
                $overlay    = $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay input"),
                $color      = $("#customize-control-pi_save_theme_options-theme_options-"+val+"-overlay_color .pi_color_picker");

            if ( $bgType == 'image' )
            {
                if ( $attachment.length > 0 )
                {
                    $img = $attachment.children().data("src");
                }else{
                    $img = "http://placehold.it/1600x1160";
                }
                _oData['image'] = $img;

                _oData['overlay']       = $overlay.is(":checked") ? 1 : 0;
                _oData['overlay_color'] = $color.val();
                _oData['type']  = 'image';
            }else if ( $bgType == 'color' )
            {
                _oData['type']  = 'color';
            }else{
                _oData['type']  = 'none';
            }
           
            $hack.trigger("change");
            $hack.val( encodeURIComponent(JSON.stringify(_oData)) );
            $hack.trigger("change");
            $hack.val("");
            _oData = {};
        },

        pi_hack_trigger: function(target, obj)
        {

            var youtubeTarget = $('#customize-control-pi_save_theme_options-theme_options-header-hack_youtube input'),
                imgsTarget = $('#customize-control-pi_save_theme_options-theme_options-header-hack_img_slider input'),
                imgFixed = $('#customize-control-pi_save_theme_options-theme_options-header-hack_imagefixed input');
            
            var _oData = {};
            
            _oData['title']  = $("#customize-control-pi_save_theme_options-theme_options-header-title input").val();
            _oData['sub_title']  = $("#customize-control-pi_save_theme_options-theme_options-header-sub_title input").val();
            _oData['button_name']  = $("#customize-control-pi_save_theme_options-theme_options-header-button_name input").val();
            _oData['button_link']  = $("#customize-control-pi_save_theme_options-theme_options-header-button_link input").val();
            _oData['description']  = $("#customize-control-pi_save_theme_options-theme_options-header-description textarea").val();
            _oData['overlay_color'] = $("#customize-control-pi_save_theme_options-theme_options-header-overlay_color input").val();

            switch ( target )
            {
                case 'youtube_bg':
                    _oData['link'] = $("#customize-control-pi_save_theme_options-theme_options-header-youtube_link input").val();
                    _oData['mute'] = $("#customize-control-pi_save_theme_options-theme_options-video_options-mute input").is(":checked")  ? 1 : 0;
                    _oData['videoplaceholder'] =  $("#customize-control-pi_save_theme_options-theme_options-video_options-videoplaceholder input").is(":checked")  ? 1 : 0;
                    _oData['quanlity'] =  $("#customize-control-pi_save_theme_options-theme_options-video_options-quality select").find("option:selected").val();

                    youtubeTarget.trigger("change");
                    youtubeTarget.val( encodeURIComponent(JSON.stringify(_oData)) );
                    youtubeTarget.trigger("change");
                                   
                    imgsTarget.val("");
                    imgFixed.val("");
                break;

                case 'img_slider':
                    var $attachments = $("#customize-control-pi_save_theme_options-theme_options-header-img_slider .attachment"), imgs="";
                    if ( $attachments.length > 0 )
                    {
                       $attachments.each(function()
                       {
                            imgs += $(this).children().attr("data-src") + ",";
                       })
                       imgs = imgs.trim(",");
                    }else{
                        imgs = "http://placehold.it/1600x1160, http://placehold.it/1600x1160";
                    }
                    _oData['images']    = imgs;

                    imgsTarget.trigger("change");
                    imgsTarget.val( encodeURIComponent(JSON.stringify(_oData)) );
                    imgsTarget.trigger("change");

                    youtubeTarget.val("");
                    imgFixed.val("");
                break; 

                case 'image_fixed':
                    var $attachment = $("#customize-control-pi_save_theme_options-theme_options-header-image_fixed .attachment"), img="";
                    if ( $attachment.length > 0 )
                    {
                       
                        img = $attachment.children().data("src");
                      
                    }else{
                        img = "http://placehold.it/1600x1160";
                    }
                    _oData['image']    = img;
                    imgFixed.trigger("change");
                    imgFixed.val( encodeURIComponent(JSON.stringify(_oData)) );
                    imgFixed.trigger("change");

                    youtubeTarget.val("");
                    imgsTarget.val("");
                break;

                default:
                    youtubeTarget.val("");
                    imgFixed.val("");
                    imgsTarget.val("");
                break;
            }

            target = "";
        },

        pi_wrap_block: function()
        {
            $("#accordion-section-pi_section_builder .customize-control-pi-title").click(function()
            {
                $(this).nextUntil(".customize-control-pi-title").toggleClass("hidden");
                $(".customize-control-pi-add-new").removeClass("hidden"); 
            }).trigger("click");


        },

        pi_remove_img: function()
        {
            $(document).on("click", ".pi-remove", function(e)
            {
                e.preventDefault();
                var getVal = $(this).closest(".image-wrap").siblings(".wo-insert-link");
                getVal.trigger("keydown");
                var getID = getVal.attr("value");
                
                var index = $(this).data("id"),
                oldids = $.map(getID.split(','), function(value)
                {
                    if (value != "")
                        return parseInt(value);
                });

                if (oldids.length > 1)
                {
                  oldids = $.teThemes.pi_removeId(oldids, index);
                  getVal.val(oldids.join(","));
                }else{
                  getVal.val("");
                }
                
                if ($(this).parent().length > 0)
                {
                   $(this).parent().fadeOut('slow', function() 
                   {
                      $(this).remove();
                   });
                }

                getVal.trigger("change");

            })
        },

        pi_update_section_builder: function(val)
        {
            var $sectionBuilder = $("#customize-control-pi_save_theme_options-theme_options-section_builder .section-order");

            $sectionBuilder.trigger("keydown");
            $sectionBuilder.val("");
            $sectionBuilder.val(val);
            $sectionBuilder.trigger("change");
        },

        pi_sort_section: function()
        {
            
            $(".js_section_order").sortable(
            {
                update: function(event, ui) 
                {
                    var order = [];
                    var $currentParent = "#" + ui.item.parent().attr("id");
                    var $insertTo = $($currentParent).siblings(".section-order");

                    $($currentParent+' li').each( function(e) 
                    {
                        order.push( $(this).attr('data-name') );
                    });
                    // join the array as single variable...
                    var positions = order.join(',');
                    $insertTo.trigger("keydown");
                    $insertTo.val("");
                    $insertTo.val( positions );
                    $insertTo.trigger( "change" );
                    return true;
                }
            })

            $( ".js_section_order" ).disableSelection();
            
        },
        pi_scroll_to: function(){
            var $getId="", $connect = $("iframe").contents(), $offsetX=0;
            $(".customize-control-pi-title").click(function()
            {
                $getId = $(this).children().data("scrollto");

                if ( $getId != '' )
                {

                    if ( $("iframe").contents().find($getId).length > 0 )
                    {
                        $offsetX = $("iframe").contents().find($getId).offset().top;
                      
                        $("iframe").contents().scrollTop($offsetX);
                    }
                }

            })
        },
        pi_create_section: function()
        {
            $("#pi-add-new-section").click(function()
            {
                $(this).parent().next().removeClass("hidden");
                return false;
            })

            $("#pi-create-section").click(function()
            { 
                var _oData = {}, _jsonData="", _isEdit;
                if ( $("#pi-id").val() == '' )
                {
                    alert("Please enter id");
                }else{
                    _oData.enable       = $("#pi-enable-section").val() !='' ? 1 : 0;
                    _oData.name         = $("#pi-id").val();
                    _oData.name         = _oData.name.trim();

                    if ( _oData.name == '' )
                    {
                        alert("Please enter section id");
                    }else{
                    
                        _oData.name         =  _oData.name.toLowerCase();
                        _oData.name         = _oData.name.replace(/\s+/g,"_");
                        

                        _oData.title        = $("#pi-title").val();

                        _oData.sub_title    = $("#pi-sub-title").val();
                        _oData.description  = $("#pi-description").val();
                        _oData.content      = tinyMCE.get('pi_custom_section_content').getContent();

                        _oData.background      = $("[name='theme_options[custom_section][background]']").val();
                        _oData.background      = typeof _oData.background =='undefined' ? 'none' : _oData.background;


                        if ( _oData.background == 'image' )
                        {
                            _oData.bg_img  = $("[name='theme_options[custom_section][bg_img]']").val();
                            if ( $("[name='theme_options[custom_section][overlay]']").is(":checked") )
                            {
                                _oData.overlay = 1;
                                _oData.overlay_color = $("[name='theme_options[custom_section][overlay_color]']").val();
                            }

                            if ( $("[name='theme_options[custom_section][parallax]']").is(":checked") )
                            {
                                _oData.parallax = 1;
                            }
                        }

                        _isEdit             = $("#pi-create-section").attr("data-is_edit");
                        _isEdit             = typeof _isEdit  !='undefined' ? _isEdit : false;

                        // convert to json
                        _jsonData = JSON.stringify(_oData);

                        $.ajax(
                        {
                            type: "POST",
                            url: ajaxurl,
                            data: {action: 'create_section', data: _jsonData, is_edit: _isEdit},
                            success: function(res)
                            {
                                if ( res=='done' )
                                {
                                    $(window).unbind("beforeunload");
                                    location.reload();
                                }else if ( res == 'false' )
                                {
                                    alert("The section id is available, please enter other id");
                                }

                                $("#pi-create-section").attr("data-is_edit", false);
                            }
                        })
                    }
                }
                return false;
            })

        },
        pi_remove_custom_section: function()
        {
            var _sectionID, _confirm, _self;
            $(".pi-remove-custom-section").click(function()
            {
                // if ( $("#customize-control-pi_language .active").length>0 )
                // {
                //     _lang = $("#customize-control-pi_language .active").attr("data-lang");
                // }
                _confirm = confirm("Press Oke to remove, Cancel to leave");
                _self    = $(this);
                _sectionID = $(this).parent().data("key");
                if ( _confirm )
                {
                    $.ajax(
                    {
                        url: ajaxurl,
                        type: "POST",
                        data: {action: "remove_custom_section", section_id: _sectionID},
                        success: function(res)
                        {
                            _self.closest("li").remove();
                            $(window).unbind("beforeunload");
                            location.reload();
                        }
                    })
                }
                return false;
            })
        },
        pi_edit_custom_section: function()
        {
            var _sectionID = "";
            $(".pi-edit-custom-section").click(function()
            {
                _sectionID = $(this).parent().data("key");
                $.ajax(
                {
                    type: "POST",
                    url: ajaxurl,
                    data: {action: "edit_custom_section", sectionid: _sectionID},
                    success: function(res)
                    {
                        if ( !res.enable )
                        {
                            $("#pi-enable-section").attr("checked", "checked");
                        }
                        $("#pi-id").val(_sectionID);
                        $("#pi-id").attr("disabled", "disabled");
                        
                        $("#pi-title").val(res.title);

                        $("#pi-sub-title").val(res.sub_title);
                        $("#pi-description").val(res.description);
                        tinyMCE.get('pi_custom_section_content').setContent(res.content);

                        $("[name='theme_options[custom_section][background]']").find("option").each(function()
                        {
                            if ( $(this).attr("value") == res.background )
                            {
                                $(this).prop("selected", "selected");
                                return false;
                            }
                        })

                        
                        if ( res.background == 'image' )
                        {
                            $("[name='theme_options[custom_section][bg_img]']").val(res.bg_img);
                            $("#pi_custom_section_bg_img img").attr("src", res.bg_img);
                            $("#pi_custom_section_bg_img, #pi_transparent_color_custom_section").css({display:"block"});
                            if ( typeof res.overlay !='undefined' )
                            {
                                 $("[name='theme_options[custom_section][overlay]']").attr("checked", "checked");
                                 $("[name='theme_options[custom_section][overlay_color]']").attr("value", res.overlay_color);
                                 $("#pi_transparent_color_custom_section .sp-preview-inner").css({'background-color': res.overlay_color});
                            }

                            if ( typeof res.parallax !='undefined' )
                            {
                                 $("[name='theme_options[custom_section][parallax]']").attr("checked", "checked");
                            }
                        }

                        $("#customize-control-pi_add_new_section .pi-hidden-here").removeClass("hidden");
                        $("#pi-create-section").attr("data-is_edit", true);
                    }
                })
                return false;
            })
        },
        pi_color_picker: function()
        {
            var _current = $(".pi_color_picker").val();
            $(".pi_color_picker").spectrum(
            {
                showAlpha: true, 
                preferredFormat: "rgb",
                move: function(color) {
                    $(this).attr("value", color);
                    $(this).trigger("change");
                },
                hide: function(color)
                {
                    $(this).attr("value", color);
                    $(this).trigger("change");
                }
            })
        },
        pi_contact_info: function()
        {
            $("#pi-set-contact-info").click(function()
            {
                $(this).next().removeClass("hidden");
                return false;
            })

            $("#table-fa").css({display:"block"});
        }
    }

    $(window).load(function()
    {
        var piControl = new $.piControl(); 

    })

})(jQuery, window, document);