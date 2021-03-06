;(function($, window, document, undefined)
{
	
	$(document).ready(function()
	{
		var $postID = $("#post_ID").val();
		
		$(".pi_media_type").change(function()
		{
			var $getData = $(this).find(":selected").data();
			$($getData.hide).fadeOut();
			$($getData.target).fadeIn();
		}).trigger("change");

		$(".pi_add_video").change(function()
		{
			if ($(this).val() != '')
			{
				$(".pi_addvideo").prop("disabled", false);
			}else{
				$(".pi_of_video").val("");
				$(".pi_addvideo").prop("disabled", "disabled");
			}
		})


		$(".pi_addvideo").on("click", function()
		{
			$(this).prop("disabled", "disabled");
			var $getlink, $piVideo;
				$getlink = $(this).next().attr("value");
				$piVideo = $.Pi_MEDIA.init({url:$getlink}), $run = false, $that = $(this);


				if ( typeof $piVideo.type == 'undefined' ) 
				{	
					var img, getdata;
				 	$.ajax(
	                {
	                    async: false,
	                    dataType : 'json',
	                    url: 'http://www.vimeo.com/api/v2/video/' + $piVideo + '.json?callback=?',
	                    // type : 'GET',
	                    success: function(data) 
	                    {
	                    	
	                        ivalue={'type':'vimeo','id':$piVideo,'image':data[0].thumbnail_large};
	                    
	                        img =  [
	                                '<img width="150" height="150" src="'+ivalue.image+'">',
	                               ];
	                        
	                        vimeo = ivalue.id;

	                        $piVideo = {image:img.join(""), id: vimeo, type: 'vimeo', poster: ivalue.image};
	                        piParseVideo($that, $piVideo);
	                    },
	                    statusCode: {
	                    	404: function() {
	                    		alert("Please check your link");
	                    	}
	                    } 
	                })
				}else{
					piParseVideo($that, $piVideo);
				}				
		})	

		getFlickr();
     	$(".js_get_flickr").click( function()
     	{
     		getFlickr(true);
     		return false;
     	})

     	// $(".pi_flickr_changesize").change(function()
     	// {
     	// 	getFlickr(true);
     	// })

        $(".js_toggle_image").click(function() 
        {

            if ( $(this).text() == 'Hide Image' )
            {
                localStorage.setItem("pi_"+$postID, 0);
                $(this).text("Show Image");
            }else{
                 localStorage.setItem("pi_"+$postID, 1);
                 $(this).text("Hide Image");
            }
            $(".pi-gallery").toggleClass("hidden");
            return false;
        })
     	

		// if video is old video link, disable button add video.

	})
	
	function getFlickr(getnew)
 	{
		var $oInfo = {};
		var $aImgs = [];

 		$(".pi-flickr").find(".pi_flickr_info").each(function()
 		{	
 		
 			if ( $(this).prop("tagName") != 'INPUT' )
 			{
 				$oInfo[$(this).data("key")] = $(this).find("option:selected").val();
  			}else{
  				$oInfo[$(this).data("key")] =  $(this).val();
  			}
 		})
 		
 		if(  $oInfo.flickr_id  == '')
 		{
 			if ( getnew == true ) 
 			{
 				alert("Oop! You need to enter flickr id");
 			}
 			return;
 		}

 		$oInfo.flickr_limit = $oInfo.flickr_limit == '' ? 4 : $oInfo.flickr_limit;
 		$('#pi-show-image').html("");
 		$('#pi-show-image').jflickrfeed(
 		{
			limit: $oInfo.flickr_limit,
			qstrings: {
				id: $oInfo.flickr_id
			},
			itemTemplate: 
			'<li>' +
				'<img src="{{'+$oInfo.flickr_image_size+'}}" alt="{{title}}" />' +
			'</li>'
		}, function(data)
		{
			$.each(data.items, function(i, v)
			{
				$aImgs[i] = v[$oInfo.flickr_image_size];
			})

			$aImgs = $.grep($aImgs, function( n, i ) 
			{
				return ( typeof n != 'undefined');
			});

		
			var $imgs = $aImgs.join(",");
			$("#flickr_re_data").val($imgs);
		});
 	}

    function piParseVideo($this, $piVideo)
	{
		var $img="", $oldId;
		$img+='<li class="attachment img-item width-300" data-id="video">';
			$img+=$piVideo.image;
			$img+='<a class="pi-remove js_remove_video" href="#">';
				$img+='<i class="fa fa-times"></i>';
			$img+='</a>';
		$img+='</li>';


		$this.siblings(".pi_type").val($piVideo.type);
		$this.siblings(".video_id").val($piVideo.id);
		$this.siblings(".video_poster").val($piVideo.poster);
		
		$this.closest(".bg-action").siblings(".lux-gallery").html($img);
	}



})(jQuery, window, document)
