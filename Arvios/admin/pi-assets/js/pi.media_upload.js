// created by pirateS - wiloke.com - piratesmorefun@gmail.com
;(function($, window, document, undefined)
{
        "use strict";


		var _self, file_frame, teInsertTo= "", isMultile=true, liveInsertMe=false, $getData="", $realTime="", $jsUpload = ".js_upload", $caseSpecial="";
        
        /* Multiple or single Upload */

        $(document).on("click", $jsUpload, function(event)
        {
            event.preventDefault();

            _self = $(this);
            $getData = _self.data();

            if ( !$(this).hasClass("multiple") )
            {
                isMultile = false;
            }else{
                isMultile = true;
            }

            $caseSpecial = typeof $getData.special != 'undefined' ? $getData.special : '';

            /* get id of input that will insert image src or images id to */
            teInsertTo = $(this).next();

         	if ( file_frame ) 
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
                            attachment 	= attachment.toJSON();
                            ids.push(attachment.id);

                            if (typeof attachment.sizes.thumbnail !== 'undefined')
                            {
                                urls.push(attachment.sizes.thumbnail.url);
                            }else{
                                urls.push(attachment.url);
                            }
                        });

                        var oldids = $.map($(teInsertTo).val().split(","), function(value)
                        {
                            if (value != "")
                                return parseInt(value, 10);
                        });
                        var $imgs = "";
                        for (var j = 0; j < ids.length; j++)
                        {
                            oldids.push(ids[j]); 

                            $imgs += '<li class="attachment img-item width-300" data-id="'+ids[j]+'">';
                                $imgs += '<img  src="' + urls[j] + '" />';
                                $imgs += '<a class="pi-remove" href="#">';
                                    $imgs += '<i class="fa fa-times"></i>';
                                $imgs += '</a>';
                            $imgs += '</li>';
                        }


                        teInsertTo.val(oldids);

                        _self.closest(".bg-action")[$getData.func]($getData.target).append($imgs);

                        break;

                    case false:


                            var logoUrl, origionUrl, getId;
                            selection.map(function(attachment)
                            {
                                attachment = attachment.toJSON();
                                getId 	   =  attachment.id;

                                logoUrl = attachment.url;
                       
                                origionUrl = attachment.url;
                            });

                            if ( typeof $getData.geturl !='undefined' )
                            {
                                teInsertTo.val(logoUrl);
                            }else{
                              teInsertTo.val(getId);  
                            }
                            

                            var img = '<img width="260" height="270" src="'+logoUrl+'">';
                            
                            if ($caseSpecial == 'logo')
                            {
                                img = '<span>' + img + '</span>';
                            }

                            _self[$getData.use]($getData.insertto)[$getData.method](img);


                        
                        break;
                }
                
            })

            /* Finally,  open the modal */
            file_frame.open();
        })

        $(".js_attachment").on("click",function()
        {
            var self = $(this);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            wp.media.editor.send.attachment = function(props, attachment) 
            {
                self.parent().find("input:text").val(attachment.url);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open();
            return false;
        });

})(jQuery, window, document);