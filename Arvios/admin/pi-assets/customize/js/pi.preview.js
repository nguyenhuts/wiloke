;(function($, document, window, undefined)
{

	"use strict";
	var windowHeight = $(window).height();
	var $sectionID = $.parseJSON(PI_CONFIG);

	var mapAnchor = document.getElementById("map");
	var  _jsonData={};

    var grayscale = [
        {featureType: 'all',  stylers: [{saturation: -100},{gamma: 0.50}]}
    ],
    blue = [
        {featureType: 'all',  stylers: [{hue: '#0000b0'},{invert_lightness: 'true'},{saturation: -30}]}
    ],
    dark = [
        {featureType: 'all',  stylers: [{ hue: '#ff1a00' },{ invert_lightness: true },{ saturation: -100  },{ lightness: 33 },{ gamma: 0.5 }]}
    ],
    pink = [
        {"stylers": [{ "hue": "#ff61a6" },{ "visibility": "on" },{ "invert_lightness": true },{ "saturation": 40 },{ "lightness": 10 }]}
    ],
    light = [
        {"featureType": "water","elementType": "all","stylers": [{"hue": "#e9ebed"},{"saturation": -78},{"lightness": 67},{"visibility": "simplified"}]
        },{"featureType": "landscape","elementType": "all","stylers": [{"hue": "#ffffff"},{"saturation": -100},{"lightness": 100},{"visibility": "simplified"}]
        },{"featureType": "road","elementType": "geometry","stylers": [{"hue": "#bbc0c4"},{"saturation": -93},{"lightness": 31},{"visibility": "simplified"}]
        },{"featureType": "poi","elementType": "all","stylers": [{"hue": "#ffffff"},{"saturation": -100},{"lightness": 100},{"visibility": "off"}]
        },{"featureType": "road.local","elementType": "geometry","stylers": [{"hue": "#e9ebed"},{"saturation": -90},{"lightness": -8},{"visibility": "simplified"}]
        },{"featureType": "transit","elementType": "all","stylers": [{"hue": "#e9ebed"},{"saturation": 10},{"lightness": 69},{"visibility": "on"}]
        },{"featureType": "administrative.locality","elementType": "all","stylers": [ {"hue": "#2c2e33"},{"saturation": 7},{"lightness": 19},{"visibility": "on"}]
        },{"featureType": "road","elementType": "labels","stylers": [{"hue": "#bbc0c4"},{"saturation": -93},{"lightness": 31},{"visibility": "on"}]
        },{"featureType": "road.arterial","elementType": "labels","stylers": [{"hue": "#bbc0c4"},{"saturation": -93},{"lightness": -2},{"visibility": "simplified"}]}
    ],
    blueessence = [
        {featureType: "landscape.natural",elementType: "geometry.fill",stylers: [{ "visibility": "on" },{ "color": "#e0efef" }]
        },{featureType: "poi",elementType: "geometry.fill",stylers: [{ "visibility": "on" },{ "hue": "#1900ff" },{ "color": "#c0e8e8" }]
        },{featureType: "landscape.man_made",elementType: "geometry.fill"
        },{featureType: "road",elementType: "geometry",stylers: [{ lightness: 100 },{ visibility: "simplified" }]
        },{featureType: "road",elementType: "labels",stylers: [{ visibility: "off" }]
        },{featureType: 'water',stylers: [{ color: '#7dcdcd' }]
        },{featureType: 'transit.line',elementType: 'geometry',stylers: [{ visibility: 'on' },{ lightness: 700 }]}
    ],
    bentley = [
        {featureType: "landscape",stylers: [{hue: "#F1FF00"},{saturation: -27.4},{lightness: 9.4},{gamma: 1}]
        },{featureType: "road.highway",stylers: [{hue: "#0099FF"},{saturation: -20},{lightness: 36.4},{gamma: 1}]
        },{featureType: "road.arterial",stylers: [{hue: "#00FF4F"},{saturation: 0},{lightness: 0},{gamma: 1}]
        },{featureType: "road.local",stylers: [{hue: "#FFB300"},{saturation: -38},{lightness: 11.2},{gamma: 1}]
        },{featureType: "water",stylers: [{hue: "#00B6FF"},{saturation: 4.2},{lightness: -63.4},{gamma: 1}]
        },{featureType: "poi",stylers: [{hue: "#9FFF00"},{saturation: 0},{lightness: 0},{gamma: 1}]}
    ],
    retro = [
        {featureType:"administrative",stylers:[{visibility:"off"}]
        },{featureType:"poi",stylers:[{visibility:"simplified"}]},{featureType:"road",elementType:"labels",stylers:[{visibility:"simplified"}]
        },{featureType:"water",stylers:[{visibility:"simplified"}]},{featureType:"transit",stylers:[{visibility:"simplified"}]},{featureType:"landscape",stylers:[{visibility:"simplified"}]
        },{featureType:"road.highway",stylers:[{visibility:"off"}]},{featureType:"road.local",stylers:[{visibility:"on"}]
        },{featureType:"road.highway",elementType:"geometry",stylers:[{visibility:"on"}]},{featureType:"water",stylers:[{color:"#84afa3"},{lightness:52}]},{stylers:[{saturation:-17},{gamma:0.36}]
        },{featureType:"transit.line",elementType:"geometry",stylers:[{color:"#3f518c"}]}
    ],
    cobalt = [
        {featureType: "all",elementType: "all",stylers: [{invert_lightness: true},{saturation: 10},{lightness: 30},{gamma: 0.5},{hue: "#435158"}]}
    ],
    brownie = [
        {"stylers": [{ "hue": "#ff8800" },{ "gamma": 0.4 }]}
    ];


	/*=========================================*/
	/*	Header Enable
	/*=========================================*/
	wp.customize( 'pi_save_theme_options[theme_options][header][enable]', function(value)
	{
		value.bind(function(newval)
		{	

			if ( newval === true )
			{	
				$('#header').fadeIn();
				var offSet = $("#header").offset().top;
				$(window).scrollTop(offSet);
			}else{
				$('#header').fadeOut();
				if ( $('.fullscreen-video').length >0 )
				{
					$('.fullscreen-video').muteYTPVolume();
				}
			}
		})
	});

	/*=========================================*/
	/* Header title and description
	/*=========================================*/
	wp.customize( 'pi_save_theme_options[theme_options][header][description]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( $(".home-media-content p").length >0 )
			{
				$(".home-media-content p").html(newval);
			}else{
				$(".home-media-content p").append('<p>'+newval+'</p>');
			}

		})
	});

	wp.customize( 'pi_save_theme_options[theme_options][header][title]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( $(".home-media-content h2").length >0 )
			{
				$(".home-media-content h2").html(newval);
			}else{
				$(".home-media-content h2").prepend('<h2 class="h1">'+newval+'</h2>');
			}
		})
	});

	wp.customize( 'pi_save_theme_options[theme_options][header][sub_title]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( $(".home-media-content h4.header-text").length >0 )
			{
				$(".home-media-content h4.header-text").html(newval);
			}else{
				$(".home-media-content").prepend('<h4 class="header-text">'+newval+'</h4>');
			}
		})
	});

	/*=========================================*/
	/*	Button
	/*=========================================*/
	wp.customize( 'pi_save_theme_options[theme_options][header][button_name]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( $(".home-media-content a.btn-style-2").length >0 )
			{
				$(".home-media-content a.btn-style-2").html(newval);
			}else{
				$(".home-media-content").append('<div class="pi-header-button"><a class="h-btn btn-style-2" href="#portfolio">'+newval+'</a></div>');
			}
		})
	});

	wp.customize( 'pi_save_theme_options[theme_options][header][button_link]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( $(".home-media-content a.btn-style-2").length >0 )
			{
				$(".home-media-content a.btn-style-2").attr("href", newval);
			}else{
				$(".home-media-content").append('<div class="pi-header-button"><a class="h-btn btn-style-2" href="'+button_link+'">Button Name</a></div>');
			}
		})
	});


	/*=========================================*/
	/*	Media
	/*=========================================*/
	var $pianchorMedia = $("#pi-wrap-header-media");

	/*Youtube*/
	wp.customize( 'pi_save_theme_options[theme_options][header][hack_youtube]', function(value)
	{
		value.bind(function(newval)
		{	

			if ( newval != '' )
			{
				_jsonData = JSON.parse(decodeURIComponent(newval));
				$pianchorMedia.html('<div class="text-content"><div class="tb">\
					<div class="home-media-content tb-cell text-center text-uppercase">\
						<h2 class="h1"></h2>\
						<hr class="he-divider">\
						<p></p>\
					</div></div>\
				</div>\
				<div id="video-element" class="bg-video js_fullscreen_video video">\
		            <a id="video" class="fullscreen-video player js_player" data-property=""></a>\
		        </div>\
		        <div class="controls-video">\
		            <span class="play"><i class="fa fa-play"></i></span>\
		            <div class="controls-sm">\
		                <span class="pause"><i class="fa fa-pause"></i></span>\
		                <span class="volume"><i class="fa fa-volume-down"></i></span>\
		            </div>\
		        </div>\
		        <div class="video-place"></div>\
		        <div class="bg-overlay"></div>');
				
				$("#video").attr("data-property", "{videoURL:'"+_jsonData.link+"',containment:'#video-element', showControls:0, autoPlay:true, loop:true, mute:"+_jsonData.mute+", startAt:0, opacity:1, addRaster:false, quality: '"+_jsonData.quality+"'}")
				$("#video .video-place").css({'background-image': _jsonData.videoplaceholder});


				
	            $('.fullscreen-video').mb_YTPlayer(
	            {
	                  containment: ".bg-video",
	                  mute: true,
	                  loop: true,
	                  startAt: 0,
	                  autoPlay: true,
	                  showYTLogo: false,
	                  showControls: false
	          	});

	          	var video 	= $('.fullscreen-video'),
	            videoPlay 	= $('.controls-video .play'),
	            videoPause 	= $('.controls-video .pause'),
	            videoVolume = $('.controls-video .volume'),
	            headTitle 	= $('.header-title');
	            videoPlay.hide();
	            headTitle.hide();
	            $('.video-place').hide();
	            videoPlay.on('click', function () 
	            {
	                video.playYTP();
	                videoPause.fadeIn(500);
	                videoVolume.fadeIn(500);
	                headTitle.fadeOut(500);
	                $(this).fadeOut(500);
	                $('.video-place').fadeOut(500);
	            });
	            videoPause.on('click', function () 
	            {
	                video.pauseYTP();
	                videoPlay.fadeIn(500);
	                videoVolume.fadeOut(500);
	                headTitle.fadeIn(500);
	                $(this).fadeOut(500);
	                $('.video-place').fadeIn(500);
	            });
	            videoVolume.on('click', function () 
	            {
	                video.toggleVolume();
	            });

	            $(".home-media-content h2").html(_jsonData.title);
	            $(".home-media-content p").html(_jsonData.description);

	         	_jsonData = {};
         	}
	        
		})
	});

	wp.customize( 'pi_save_theme_options[theme_options][header][youtube_link]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( $("#video").length > 0 )
			{
				$(".fullscreen-video").changeMovie({videoURL: newval});
			}
		})
	});

	wp.customize( 'pi_save_theme_options[theme_options][video_options][mute]', function( value ) 
	{	
		value.bind( function( newval ) 
		{	
			if ( newval === true )
			{
				$(".fullscreen-video").muteYTPVolume();
			}else{
				$(".fullscreen-video").unmuteYTPVolume();
			}
		});	
	})
	/*End youtube*/

	/*Image slider*/
	wp.customize( 'pi_save_theme_options[theme_options][header][hack_img_slider]', function(value)
	{
		value.bind(function(newval)
		{	

			if ( newval != '' )
			{
				_jsonData = JSON.parse(decodeURIComponent(newval));
				
				$pianchorMedia.html('<div class="home-slider" data-background="bg-parallax">\
					<div class="slides-container">\
					</div>\
					<nav class="slides-pagination">\
					<a href="#" class="next"><i class="fa fa-angle-right"></i></a>\
					<a href="#" class="prev"><i class="fa fa-angle-left"></i></a>\
					</nav>\
					</div>');

				var splitImg = _jsonData['images'].split(","), item="", headerText="";
					
					headerText+='<div class="tb">';
                        headerText+='<div class="home-media-content tb-cell text-center text-uppercase">';
                        	headerText+='<h4 class="header-text">'+_jsonData.sub_title+'</h4>';
                            headerText+='<h2 class="h1">'+_jsonData.title+'</h2>';
                            headerText+='<hr class="he-divider">';
                            headerText+='<p>'+_jsonData.description+'</p>';
                            if ( _jsonData.button_link != '' )
                            {
                            	_jsonData.button_name = _jsonData.button_name == '' ? 'Button Name' : _jsonData.button_name;
                            	headerText+='<div  class="pi-header-button"><a class="h-btn btn-style-2" href="'+_jsonData.button_link+'">'+_jsonData.button_name+'</a></div>';
                            }
                        headerText+='</div>';
                    headerText+='</div>';

					$.each(splitImg, function(i,val)
					{
						if ( val !='' )
						{
							item += '<div class="item"><img style="z-index: -3 !important;" src="'+val+'" alt="Wiloke Wordpress Themes"><div class="bg-overlay" style="background-color:'+_jsonData.overlay_color+'"></div>'+headerText+'</div>';
						}
					})
					
					$pianchorMedia.find(".slides-container").html(item);
					item="";
					$(".home-slider").superslides(
					{
			            animation: 'fade',
			            play: 4000,
			            pagination: true
					});

				_jsonData={};
			}	
		})
	});
	/*End Image Slider*/

	/*Tunnar Slider*/
	wp.customize( 'pi_save_theme_options[theme_options][header][tunna_slider]', function(value)
	{
		value.bind(function(newval)
		{	
			if ( newval != '' )
			{
				$.ajax(
				{
					url: WILOKE.ajaxurl,
					type: 'POST',
					data: {action: 'pi_customize_change_header_bg', 'mod':'bg_slideshow', id:newval},
					success: function(res)
					{
						$pianchorMedia.html(res);
					}
				})
			}
		})
	});
	/*End tunnar slider*/
	wp.customize( 'pi_save_theme_options[theme_options][header][type]', function(value)
	{
		value.bind(function(newval)
		{	
			if ( newval == 'bg_slideshow' || newval == 'text_slider' )
			{
				$.ajax(
				{
					url: WILOKE.ajaxurl,
					type: 'POST',
					data: {action: 'pi_customize_change_header_bg', 'mod':newval},
					success: function(res)
					{
						$pianchorMedia.html(res);
					}
				})
			} 
		})
	});

	wp.customize( 'pi_save_theme_options[theme_options][header][overlay_color]', function(value)
	{
		value.bind(function(newval)
		{	
			$(".home-media .bg-overlay").css({'background-color': newval});
		})
	});

	/*Text slider*/
	wp.customize( 'pi_save_theme_options[theme_options][text_slider][text_effect]', function( value ) 
	{	
		value.bind( function( newval ) 
		{	

			if ( $(".text-slider").length>0 )
			{
			 	$(".text-slider").data("owlCarousel").transitionTypes(newval);
			 	$(".text-slider").trigger("owl.next");
		 	}
		});	
	})
	/*End Text slider*/

	
	/*Image Fixed*/
	wp.customize( 'pi_save_theme_options[theme_options][header][hack_imagefixed]', function(value)
	{
		value.bind(function(newval)
		{
			if ( newval != '' )
			{	
				_jsonData = JSON.parse(decodeURIComponent(newval));
				
				$pianchorMedia.html('<div class="bg-parallax"></div><div class="bg-overlay" style="background-color:'+_jsonData.overlay_color+'"></div>\
				<div class="tb">\
				<div class="home-media-content tb-cell text-center text-uppercase">\
				<h4 class="header-text"></h4>\
				<h2 class="h1"></h2>\
				<hr class="he-divider">\
				<p></p>\
				<div  class="pi-header-button"><a class="h-btn btn-style-2" href=""></a></div>\
				</div></div>');

				$pianchorMedia.find(".home-media-content h4.header-text").html(_jsonData.sub_title);
				$pianchorMedia.find(".home-media-content h2").html(_jsonData.title);
				$pianchorMedia.find(".home-media-content p").html(_jsonData.description);
				$pianchorMedia.find(".home-media-content .pi-header-button a").html(_jsonData.button_name);
				$pianchorMedia.find(".home-media-content .pi-header-button a").attr("href",_jsonData.button_link);
				$pianchorMedia.find(".bg-parallax").css({'background-image': 'url('+_jsonData.image + ')'});
				_jsonData={};
			}	
		})
	});
	/*End Fixed*/

	/*=========================================*/
	/* Logo
	/*=========================================*/
	wp.customize( 'pi_save_theme_options[theme_options][logo][enable]', function( value ) 
	{
		value.bind( function( newval ) 
		{
			if (newval===true)
			{
				$(".logo-nav").removeClass("hidden");
			}else{
				$(".logo-nav").addClass("hidden");
			} 
		});  
	})

	wp.customize( 'pi_save_theme_options[theme_options][logo][logo_nav]', function( value ) 
	{
		value.bind( function( newval ) 
		{
			if (newval!='')
			{
				$(".logo-nav a").html("<img src='"+newval+"' alt='Wiloke Wordpress'>");
			}else{
				$(".logo-nav a").html("");
			}
		});  
	})



	/*=========================================*/
	/* Section Order
	/*=========================================*/
	var parseSection="";
	wp.customize('pi_save_theme_options[theme_options][section_builder]', function(value)
	{
		value.bind( function( newval )  
		{	
			parseSection = newval.split(','); 
         	
            if(parseSection.length>0)
            {
                $.each(parseSection, function(i, val)
                {
                	val = val.trim();
                	
                	if ( val == 'blog' )
            		{
            			val = val + '-section';
            		}

                	if ( $("#"+val).length > 0 )
                	{
                		$("#"+val).detach().appendTo("#page-wrap");
                	}
                })

                $("#footer").detach().appendTo("#page-wrap");
            }
			
		});	
	})


		
	/* -------------------------- */
	/* About us  section
	/* -------------------------- */
	pi_live_preview_section('aboutus');

	/* -------------------------- */
	/* Skills  section
	/* -------------------------- */
	pi_live_preview_section('skills');

	/* -------------------------- */
	/* Team  section
	/* -------------------------- */
	pi_live_preview_section('team');

	/* -------------------------- */
	/* Blog  section
	/* -------------------------- */
	pi_live_preview_section('blog');

	/* -------------------------- */
	/* Services  section
	/* -------------------------- */
	pi_live_preview_section('services');

	/* -------------------------- */
	/* Portfolio  section
	/* -------------------------- */
	pi_live_preview_section('portfolio');

	/* -------------------------- */
	/* Clients  section
	/* -------------------------- */
	pi_live_preview_section('clients');

	/* -------------------------- */
	/* idea  section
	/* -------------------------- */
	pi_live_preview_section('idea');

	wp.customize( 'pi_save_theme_options[theme_options][idea][label]', function(value)
	{
		var $target = $("#idea .pi-idea" ).find(".item-link");
		value.bind(function(newval)
		{
			if ( $target.length > 0 )
			{
				$target.find("a").html(newval);
			}else{
				$target.append('<div class="item-link"><a href="#" class="h-btn text-uppercase">'+newval+'</a></div>');
			}
		})
	});

	/* -------------------------- */
	/* testimonials  section
	/* -------------------------- */
	pi_live_preview_section('testimonials');

	/* -------------------------- */
	/* funfacts  section
	/* -------------------------- */
	pi_live_preview_section('funfacts');

	/* -------------------------- */
	/* pricing  section
	/* -------------------------- */
	pi_live_preview_section('pricing');

	/* -------------------------- */
	/* twitter  section
	/* -------------------------- */
	pi_live_preview_section('twitter');

	/* -------------------------- */
	/* Contact section
	/* -------------------------- */
	pi_live_preview_section('contact');


	wp.customize( 'pi_save_theme_options[theme_options][contact][enablegooglemap]', function(value)
	{
		value.bind(function(newval)
		{
			if ( newval === true )
			{
				$("#map").removeClass("hidden");
			}else{
				$("#map").addClass("hidden");
			}
		})
	});

	wp.customize('pi_save_theme_options[theme_options][contact][googlemap][longitude]', function(value)
	{
			
			value.bind(function(newval)
			{
				var myLatlng = new google.maps.LatLng(WILOKE_GOOGLEMAP.lat,newval);
				var mapOptions = {
			    zoom: 14,
			    center: myLatlng,
			    zoomControlOptions: {
			        style: google.maps.ZoomControlStyle.DEFAULT,
			    },
			    draggable: true,
			    scrollwheel: false, // Prevent users to start zooming the map when scrolling down the page
			    overviewMapControlOptions: {
			        opened: false,
			    },
			    styles: eval(WILOKE_GOOGLEMAP.theme),
			    mapTypeId: google.maps.MapTypeId[WILOKE_GOOGLEMAP.type],
			    overviewMapControl: true,
			    streetViewControl: true,
			    panControl: true,
			    scaleControl: true,
			    disableDoubleClickZoom: true,
			    zoomControl: true,
		  	}; 
		 	
		  	var map = new google.maps.Map(document.getElementById('map'),
		      mapOptions);

		  	new google.maps.Marker({
		      position: myLatlng,
		      map: map
		    });
            
		})
	})

	wp.customize('pi_save_theme_options[theme_options][contact][googlemap][theme]', function(value)
	{
		value.bind(function(newval)
		{
			var myLatlng = new google.maps.LatLng(WILOKE_GOOGLEMAP.lat,WILOKE_GOOGLEMAP.long);
			var mapOptions = {
			    zoom: 14,
			    center: myLatlng,
			    zoomControlOptions: {
			        style: google.maps.ZoomControlStyle.DEFAULT,
			    },
			    draggable: true,
			    scrollwheel: false, // Prevent users to start zooming the map when scrolling down the page
			    overviewMapControlOptions: {
			        opened: false,
			    },
			    styles: eval(newval),
			    mapTypeId: google.maps.MapTypeId[WILOKE_GOOGLEMAP.type],
			    overviewMapControl: true,
			    streetViewControl: true,
			    panControl: true,
			    scaleControl: true,
			    disableDoubleClickZoom: true,
			    zoomControl: true,
		  	}; 
		 
		  	var map = new google.maps.Map(document.getElementById('map'),
		      mapOptions);
            new google.maps.Marker({
		      position: myLatlng,
		      map: map
		    });
		})
	})

	wp.customize('pi_save_theme_options[theme_options][contact][googlemap][latitude]', function(value)
	{
		value.bind(function(newval)
		{
			var myLatlng = new google.maps.LatLng(newval,WILOKE_GOOGLEMAP.long);
			var mapOptions = {
			    zoom: 14,
			    center: myLatlng,
			    zoomControlOptions: {
			        style: google.maps.ZoomControlStyle.DEFAULT,
			    },
			    draggable: true,
			    scrollwheel: false, // Prevent users to start zooming the map when scrolling down the page
			    overviewMapControlOptions: {
			        opened: false,
			    },
			    styles: eval(WILOKE_GOOGLEMAP.theme),
			    mapTypeId: google.maps.MapTypeId[WILOKE_GOOGLEMAP.type],
			    overviewMapControl: true,
			    streetViewControl: true,
			    panControl: true,
			    scaleControl: true,
			    disableDoubleClickZoom: true,
			    zoomControl: true,
		  	}; 
		 
		  	var map = new google.maps.Map(document.getElementById('map'),
		      mapOptions);
	  	 	new google.maps.Marker({
		      position: myLatlng,
		      map: map
		    });
		})
	})

	wp.customize('pi_save_theme_options[theme_options][contact][googlemap][type]', function(value)
	{
		value.bind(function(newval)
		{
			value.bind(function(newval)
			{
				var mapOptions = {
			    zoom: 14,
			    center: new google.maps.LatLng(WILOKE_GOOGLEMAP.lat,WILOKE_GOOGLEMAP.long),
			    zoomControlOptions: {
			        style: google.maps.ZoomControlStyle.DEFAULT,
			    },
			    draggable: true,
			    scrollwheel: false, // Prevent users to start zooming the map when scrolling down the page
			    overviewMapControlOptions: {
			        opened: false,
			    },
			    // styles: [{    featureType: 'all',  stylers: [{saturation: -100},{gamma: 0.50}  ]}  ],
			    mapTypeId: google.maps.MapTypeId[newval],
			    overviewMapControl: true,
			    streetViewControl: true,
			    panControl: true,
			    scaleControl: true,
			    disableDoubleClickZoom: true,
			    zoomControl: true,
			  }; 
			 
			  var map = new google.maps.Map(document.getElementById('map'),
			      mapOptions);
			})
		})
	})
	
	wp.customize( 'pi_save_theme_options[theme_options][contact][contact_detail_title]', function(value)
	{
		value.bind(function(newval)
		{
			if ( $(".pi-info-title p").length>0 )
			{
				$(".pi-info-title p").html(newval);
			}else{
				$(".pi-info-title").append('<p>'+newval+'</p>');
			}
			
		})
	});

	wp.customize( 'pi_save_theme_options[theme_options][contact][contact_detail]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( newval === true )
			{
				$("#contact .contact-info").removeClass("hidden");
			}else{
				$("#contact .contact-info").addClass("hidden");
			}
		})
	});

	
	wp.customize( 'pi_save_theme_options[theme_options][contact][contact_form]', function(value)
	{
		value.bind(function(newval)
		{
			
			if ( newval === true )
			{
				
				if ( $("#contact .contact-form").length > 0 )
				{
					$("#contact .contact-form").removeClass("hidden");
				}
			}else{
				$("#contact .contact-form").addClass("hidden");
			}
		})
	});
	

	function pi_live_preview_section(section, diff_id, titleClass, desClass)
	{
		var sectionId = typeof diff_id != 'undefined' ? diff_id : section;
		wp.customize( 'pi_save_theme_options[theme_options]['+section+'][enable]', function(value)
		{
			value.bind(function(newval)
			{
				if ( newval === true )
				{
					if ( $('#'+sectionId).length > 0 )
					{	
						$('#'+sectionId).removeClass("hidden");
						var offSet = $("#"+sectionId).offset().top;
						$(window).scrollTop(offSet);
					}
				
				}else{
					$('#'+sectionId+'').addClass("hidden");
				}
			})
		});

		wp.customize( 'pi_save_theme_options[theme_options]['+section+'][title]', function(value)
		{
			value.bind(function(newval)
			{
				if ( section !='idea' )
				{
					if ( $("#"+sectionId+" .st-heading h3").length > 0 )
					{
						$("#"+sectionId+" .st-heading h3").html(newval);
					}else{
						$("#"+sectionId+" .st-heading").append("<h3 class='h3 "+titleClass+"'>"+newval+"</h3>");
					}
				}else{
					$("#"+sectionId+" .h4.text-uppercase").html(newval);
				}
			})
		});

		wp.customize( 'pi_save_theme_options[theme_options]['+section+'][description]', function(value)
		{
			value.bind(function(newval)
			{
				if ( section !='idea' )
				{
					if ( $("#"+sectionId+" .st-heading .sub-title").length > 0 )
					{
						$("#"+sectionId+" .st-heading .sub-title").html(newval);
					}else{
						$("#"+sectionId+" .st-heading").append("<p class='sub-title "+desClass+"'>"+newval+"</p>");
					}
				}else{
					$("#"+sectionId+" .item-content p").html(newval);
				}
			})
		});
	}



	
	// pi_live_preview_header_and_description('pi_save_theme_options[theme_options][contact][contact_detail_title]', '#map_wrap .info_block h2.block-header', '#map_wrap .info_block', '<h2 class="block-header">', '</h2>', 'prepend');		
	// pi_live_preview_header_and_description('pi_save_theme_options[theme_options][contact][contact_detail_description]', '#contact .contactinfomation p.address', '#contact .contactinfomation', '<p class="address">', '</p>');	
	// pi_live_preview_header_and_description('pi_save_theme_options[theme_options][contact][contact_address_title]', '#contact .contactinfomation h3.detail', '#contact .contactinfomation', '<h3 class="detail">', '</h3>');	
	// pi_live_preview_header_and_description('pi_save_theme_options[theme_options][contact][contact_address_title]', '#contact .contactinfomation p.detail', '#contact .contactinfomation', '<p class="detail">', '</p>');	
	// pi_live_preview_header_and_description('pi_save_theme_options[theme_options][footer][copyright]', '#footer .container p', '#footer .container', '<p>', '</p>');	



	function pi_live_preview_header_and_description(key, check, appendTo, open, close, method)
	{
		method = typeof method != 'undefined' ? method : 'append';
		wp.customize( key, function(value)
		{
			value.bind(function(newval)
			{
				if ( $(check).length > 0 )
				{
					$(check).html(newval);
				}else{
					$(appendTo)[method](open+newval+close);
				}
			})
			
		});
	}
	

 	$.each($sectionID, function(i, val)
 	{
 		pi_change_overlay_color(val, i);
 		pi_background_overlay(val, i);
 		pi_background_parallax(val, i);
 		pi_background_img(val, i);
 		pi_change_section_bg_type(val, i);
	})

	function pi_change_overlay_color(section, i)
	{
		var key = 'pi_save_theme_options[theme_options]['+section+'][overlay_color]';
		wp.customize( key, function(value)
		{
			value.bind(function(newval)
			{
				$("#"+section).find(".bg-color").remove();
				$("#"+section).find(".bg-overlay").css({'background-color': newval});
			})
		});
	}

	function pi_background_parallax(section, i)
	{
		var key = 'pi_save_theme_options[theme_options]['+section+'][parallax]';
		wp.customize( key, function(value)
		{
			value.bind(function(newval)
			{
				if (  newval == 1 )
				{
					$("#"+section).find(".bg-static").attr('class', 'bg-parallax pi-parallax-static');
				}else{
					$("#"+section).find(".bg-parallax").attr('class', 'bg-static pi-parallax-static');
				}
			})
		});
	}

	function pi_background_overlay(section, i)
	{
		var key = 'pi_save_theme_options[theme_options]['+section+'][overlay]', _overlayColor="";
		wp.customize( key, function(value)
		{
			value.bind(function(newval)
			{
				if ( newval == 1 )
				{
					if ( $("#"+section +" .bg-overlay").length > 0 )
					{
						$("#"+section + " .bg-overlay").css({display:"block"});
					}else{
						_overlayColor = $("body", window.parent.document).find("#customize-control-pi_save_theme_options-theme_options-"+section+"-overlay_color .pi_color_picker").val();
						$("#"+section + " .pi-parallax-static").after('<div class="bg-overlay" style="background-color:'+_overlayColor+'"></div>');
					}
					$("#"+section).find('.bg-color').remove();
				}else{
					$("#"+section + " .bg-overlay").css({display:"none"});
				}
			})
			
		});
	}

	function pi_background_img(section, i)
	{
		var key = 'pi_save_theme_options[theme_options]['+section+'][bg_img]';
		wp.customize( key, function(value)
		{
			value.bind(function(newval)
			{
				if($("#"+section + " .pi-parallax-static").length >  0 )
				{
					$("#"+section + " .pi-parallax-static").css({'background-image': 'url('+newval+')'});
				}else{
					$("#"+section).prepend('<div  class="bg-parallax  pi-parallax-static" style="background-image:url('+newval+')"></div>');
				}
				$("#"+section).find('.bg-color').remove();
				$("#"+section).css({'background': 'none'});
			})
			
		});
	}



	function pi_change_section_bg_type(section, i)
	{
		var key = "pi_save_theme_options[theme_options]["+section+"][hack_section_bg]";

		wp.customize( key, function(value)
		{
			value.bind(function(newval)
			{	

				if ( newval != '' )
				{
					_jsonData = JSON.parse(decodeURIComponent(newval));
					
					if ( _jsonData.type == 'image' )
					{
						if ( $("#"+section + " .pi-parallax-static").length>0  )
						{
							$("#"+section + " .pi-parallax-static").css({display:'block'});
						}else{
							if ( _jsonData.parallax == 1 )
							{
								$("#"+section).prepend('<div  class="bg-parallax  pi-parallax-static" style="background-image:url('+_jsonData.image+')"></div>');
							}else{
								$("#"+section).prepend('<div  class="bg-static pi-parallax-static" style="background-image:url('+_jsonData.image+')"></div>');
							}
						}
						if ( _jsonData.overlay == 1 )
						{
							if($("#"+section + " .bg-overlay").length>0)
							{
								$("#"+section + " .bg-overlay").css({display:'block', 'background-color':_jsonData.overlay_color});
							}else{
								$("#"+section + " .pi-parallax-static").after('<div class="bg-overlay" style="background-color:'+_jsonData.overlay_color+'"></div>');
							}
						}
						$("#"+section + " .bg-color").remove();
						$("#"+section).css({'background':'none'});

					}else if ( _jsonData.type == 'color' )
					{
						if ( $("#"+section).find(".bg-color").length > 0 )
						{
							$("#"+section).find(".bg-color").css({display: "block"});
						}else{
							$("#"+section).prepend('<div class="bg-color" style="background-color: '+_jsonData.overlay_color+'"></div>');
						}
						$("#"+section).find(".pi-parallax-static, .bg-overlay").css({display: "none"});
						$("#"+section).css({'background':'none'});
					}else{
						// $("#"+section).removeClass("")
						$("#"+section).find(".bg-parallax, .bg-overlay, .bg-color, .bg-static").remove();
						$("#"+section).css({'background-color':'#f9f9f9'});
					}
				}
			})
			
		});
	}




	function pi_custom_color($color)
	{
	 	var  $customCss = "";
	 	$customCss ='::-moz-selection {\
		    background-color: '+$color+';\
		}\
		::selection {\
		  background-color: '+$color+';\
		}\
		.preloader .ball,\
		.footer .social a:hover:before, .footer .social a:hover:after,\
		.contact_info .pi-social-zone a:hover .fa,\
		.pagination > span.current,\
		.pagination > a.current,\
		.blog-grid .grid-item .post .post-meta .dd,\
		.client-item .item-content h4:after,\
		.portfolio-item .caption h2:after,\
		#filters ul li.select-filter .h-btn:before,\
		#filters ul li.select-filter .h-btn:after,\
		.service-item:hover .h-btn:hover:before,\
		.service-item:hover .h-btn:hover:after,\
		.pi-navigation .close-menu span:hover:before,\
		.pi-navigation .close-menu span:hover:after,\
		.pi-navigation .open-menu:hover .item:before,\
		.pi-navigation .open-menu:hover .item:after,\
		.pi-navigation .open-menu:hover .item,\
		.pi-navigation .nav li.active > a:after,\
		.pi-navigation .nav li.current-menu-item > a:after,\
		.pi-navigation .nav li:hover > a:after,\
		header.header .head-social a:hover:before,\
		header.header .head-social a:hover:after,\
		.owl-carousel .owl-controls .owl-pagination .owl-page.active > span,\
		mark, .mark,\
		.social a:hover:before, .social a:hover:after,\
		.h-btn:hover:before, .h-btn:hover:after,\
		.h-btn:hover a, .h-btn:hover input, .h-btn:hover button,\
		html .bg-color{\
		    background-color: '+$color+';\
		}\
		.footer .social a:hover .fa,\
		.footer .scroll-top:hover .fa,\
		.footer p a,\
		.contact_info .pi-social-zone .fa,\
		.contact_info p a:hover,\
		.contact_info .fa,\
		.contact-form form input[type="submit"]:hover,\
		.widget_calendar table tbody td a,\
		.tagcloud a:hover,\
		.widget_meta ul li a:hover,\
		.widget_pages ul li a:hover,\
		.widget_recent_comments ul li a:hover,\
		.widget_nav_menu ul li a:hover,\
		.widget_categories ul li a:hover,\
		.widget_recent_entries ul li a:hover,\
		.widget_archive ul li a:hover,\
		#comments .commentlist .comment-foot a,\
		#comments .commentlist .comment-box cite a:hover,\
		.pagination > span:hover,\
		.pagination > a:hover,\
		.about-author .author-social a:hover .fa,\
		.tags-wrap .tag a,\
		.pi_sticky .post-title h2:before,\
		.blog-wrap .post-meta a,\
		.blog-list .post .post-title h2 a:hover,\
		.breadcrumb-wrap .breadcrumb li a:hover,\
		.blog-grid .grid-item .post .post-title h3 a:hover,\
		.blog-section .bg-static ~ div .blog-grid .grid-item .post .post-title h3:hover,\
		.blog-section .bg-parallax ~ div .blog-grid .grid-item .post .post-title h3:hover,\
		.client-item .item-content .link .fa,\
		.client-item .item-content .link:hover,\
		.portfolio-item .caption .tag ul li a:hover,\
		.portfolio-item .caption .tag ul li:after,\
		.portfolio-item .caption .tag .fa,\
		.portfolio-item .caption h2 a:hover,\
		.service-item:hover .h-btn:hover a,\
		.service-item:hover .h-btn:hover input,\
		.service-item:hover .h-btn:hover button,\
		.service-item .item-head .h4,\
		.team-item .caption span,\
		.team .bg-static ~ div .owl-carousel .owl-controls .owl-buttons > div:hover,\
		.team .bg-parallax ~ div .owl-carousel .owl-controls .owl-buttons > div:hover,\
		.story .wellcome .h2,\
		.search-box.active .toggle-search .fa,\
		.search-box .toggle-search:hover .fa,\
		.pi-navigation .nav li.active > a,\
		.pi-navigation .nav li.current-menu-item > a,\
		.pi-navigation .nav li:hover > a,\
		.controls-sm span .fa,\
		.controls-video .play .fa,\
		header.header .head-social a:hover .fa,\
		.owl-carousel .owl-controls .owl-buttons > div:hover,\
		.social a:hover .fa,\
		.h-btn:hover a, .h-btn:hover input, .h-btn:hover button{\
		    color: '+$color+';\
		}\
		.footer .social a:hover .fa,\
		.contact_info .pi-social-zone .fa,\
		.contact-form form input[type="submit"]:hover,\
		.tagcloud a:hover,\
		.pagination > span.current,\
		.pagination > a.current,\
		.pagination > span:hover,\
		.pagination > a:hover,\
		.about-author .author-social a:hover .fa,\
		.blog-grid .grid-item .post:hover .post-media > div,\
		.portfolio-item .caption .item-icon:after,\
		.service-item,\
		.search-box .search-form,\
		.controls-sm span .fa,\
		.controls-video .play .fa,\
		.owl-carousel .owl-controls .owl-pagination .owl-page.active > span,\
		blockquote,\
		.social a:hover .fa {\
		    border-color: '+$color+';\
		}\
		#filters ul li.select-filter .h-btn a,\
		.service-item:hover .h-btn:hover a,\
		.service-item:hover .h-btn:hover input,\
		.service-item:hover .h-btn:hover button\
		header.header .head-social a:hover .fa{\
	      	border-right-color: '+$color+';\
  			border-bottom-color: '+$color+';\
		}\
		.wpcf7-submit, .comment-form .form-submit input{\
		    background-color: '+$color+';\
		    border: 3px solid '+$color+';\
		}\
		.wpcf7-submit:hover, .comment-form .form-submit input:hover {\
		    background-color: #fff;\
		    color: '+$color+';\
		}';		

		if ( $("#pi-livechangecolor").length>0  )
		{
			$("#pi-livechangecolor").html($customCss);
		}else{
			$("head").append("<style id='pi-livechangecolor' rel='stylesheet' >"+$customCss+"</style>");
		}
	}
 	
})(jQuery, document, window)