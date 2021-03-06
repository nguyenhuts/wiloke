function piGoogleMap() {
  var mapID = document.getElementById('map'); 
  if ( mapID )
  {     
        function isMyScriptLoaded(url)
        {
            if ( typeof url == 'undefined')
            {
                url = "maps.googleapis";
            }

            var scripts = document.getElementsByTagName('script');
            for (var i = scripts.length; i--;)
            {
                if ( (scripts[i].src).search(url) != -1 )
                {
                    return true;
                    break;
                }
            }
            return false;
        }

        if ( !isMyScriptLoaded() )
        {
            function loadScript()
            {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&' +
                  'callback=initialize';
                document.body.appendChild(script);
            }

           loadScript();
        }
  }
}
window.onload = piGoogleMap;


(function($, window, document, undefined) {
    "use strict";

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    }

    $(window).load( function()
    {
        piPreloader();
        piCalPortfolio();
        piSupperSlider();
        piNavigation();
        piCalPricing();
        piYoutubeBg();
        parallaxInit();

        $(window).resize(function()
        {
            piCalPortfolio();
            piNavigation();
            piCalPricing();
        })
    })

   

    function piPreloader()
    {
        // windowload
        $('.preloader').fadeOut(1000);   
    }

    function piCalPortfolio()
    {
        // window load resize
        var windowHeight = 0,
            adminbarHeight = 0;
            windowHeight = $(window).height();

        if ( $("#wpadminbar").length>0 )
        {
            adminbarHeight = $("#wpadminbar").height();
            $(".pi-navigation .nav.nav-mobile").css({top: adminbarHeight});
        }

        if ( $(".pi-navigation.nav-bottom").length>0 )
        {
            windowHeight = windowHeight - adminbarHeight; 
        }
        $('.home-media, .text-slider .item').height(windowHeight);

        if ( $(".error404").length>0 )
        {
            $(".page-not-found-bg .tb").height( windowHeight -   $("#footer").outerHeight() );
        }

        if ( $("#page-portfolio").length > 0 && ( $("#page-portfolio").hasClass("style1") || $("#page-portfolio").hasClass("style2") ) )
        {
            $("#page-portfolio #portfolio-wrap").css({'max-width': $(window).width()});
        }
    }

    function piSupperSlider()
    {
        // window load
        setTimeout(function() {
            $('.home-slider').superslides({
                animation: 'fade',
                play: 4000,
                pagination: true,
                navigation: true
            });
        },50);
    }

    function piTabs()
    {
        if ( $(".pi-tabs").length > 0 )
        {
            $(".pi-tabs").tabs();
        }
    }

    function piAccordion()
    {
        if ( $(".pi-accordion").length > 0 )
        {
            $( ".pi-accordion" ).accordion();
        }
    }

    function piEvents()
    {
        $('.toggle-search').on('click', function() {
            $('.search-box').toggleClass('active');
        });
        $('html').on('click', function() {
            $('.search-box').removeClass('active');
        });
        $('.search-box').on('click', function(evt) {
            evt.stopPropagation();
        });

        if ( $("body.page-template-homepage").length < 1 )
        {
            if ( $(".pi-navigation").length > 0 )
            {
                var _getLink  = "", _self;
                $("#pi-main-menu li a").each(function()
                {
                    _self = $(this);
                    _getLink = _self.attr("href");
                    
                    if ( hasThang( _getLink ) )
                    {
                        _self.attr("href", woHomeUrl + '/' +_getLink);
                    }
                })
            }
        }

        if ( $(".pi-navigation").length>0 )
        {
            $(window).on('scroll', function() 
            {
                var scrollTop = $(window).scrollTop(),
                    navOffset = $('.pi-navigation').offset().top,
                    navHeight = $('.pi-navigation').height(),
                    windowHeight = $(window).height();

                if (scrollTop > 0) {
                    $('.home .pi-navigation').addClass('nav-fixed');
                } 
                if (scrollTop <= 0) {
                    $('.home .pi-navigation').removeClass('nav-fixed');
                }
            });
        }

        if (window.innerWidth < 900) 
        {
            $('.home-media')
                .closest('body')
                .find('.pi-navigation').css({
                    'position': 'fixed',
                    'top': '0',
                    'bottom': 'auto'
                });
        }
        $('.home-media')
            .closest('.home')
            .find('.pi-navigation')
                .addClass('nav-absolute');

        $('.page-template-homepage .pi-navigation').find('.nav > li').on('click', '> a', function(evt) {
           
            var $anchor = $(this);
            if ( hasThang($anchor.attr("href") ) && !$(this).parent().hasClass("menu-item-language") )
            {
                var offset = $($anchor.attr('href')).offset();
                evt.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: offset.top
                }, 400, 'easeInOutExpo', function(){
                    $('.nav-mobile').removeClass('nav-active');
                });
            }
        });



        $('.pi-navigation .sub-menu').each(function() {
            var offsetLeft = $(this).offset().left,
                width = $(this).width(),
                offsetRight = ($(window).width() - (offsetLeft + width));
          
            if (offsetRight < 100) {
                $(this)
                .removeClass('left')
                .addClass('right');
            } else {
                $(this)
                .removeClass('right');
            }
            if (offsetLeft < 100) {
                $(this)
                    .removeClass('right')
                    .addClass('left');
            } else {
                $(this)
                    .removeClass('left');
            }
        });

        $('.menu-item-has-children, .nav > .menu-item-language-current')
                .children('a')
                .after(
                    '<span class="submenu-toggle"></span>'
                );
        $('.submenu-toggle').on('click', function() {
            $(this).siblings('.sub-menu').addClass('translate');
        });
        $('.pi-navigation .sub-menu').each(function() {
            $(this).prepend('<li class="back-mb"><a href="#"></a></li>');
            $('.back-mb').on('click', 'a', function(evt) {
                evt.preventDefault();
                $(this)
                  .parent()
                  .parent()
                  .removeClass('translate');
            });
        });

        $('.open-menu').on('click', function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            $('.nav-mobile').addClass('nav-active');
        });

        $(".pi-navigation").on('click', '.close-menu', function(evt) {
            evt.preventDefault();
            $('.nav-mobile').removeClass('nav-active');
            $('.sub-menu').removeClass('translate');
        });

        $('.do-you-have-an-ideas .item-link, .story-content, .pi-header-button').on('click', '> a', function(evt) {
           
            var $anchor = $(this);
            if ( hasThang($anchor.attr("href") ) )
            {
                evt.preventDefault();
                var offset = $($anchor.attr('href')).offset();
                $('html, body').stop().animate({
                    scrollTop: offset.top
                }, 400, 'easeInOutExpo');
            }
        });

        if ($('.skill-bar').length) {
          $.each($('.skill-bar'), function()
          {
            var $skillbar = $(this),
                $pie = $skillbar.find('.pie'),
                $pie1 = $skillbar.find('.pie.pie1'),
                $pie2 = $skillbar.find('.pie.pie2'),
                $percent = $skillbar.find('.percent'),
                per = $percent.text().split('%')[0],
                deg = per*3.6,
                duration = $skillbar.data('duration').split('s')[0],
                size = $skillbar.data('size'),
                size2 = size/2,
                border = $skillbar.data('widthbar'),
                lhper = size - border*2;
            if (window.innerWidth >= 1280) {
              var Timeout = (duration/(per*2/100))*1000;
            } else {
              var Timeout = 0;
            }
            $pie1.wrap('<div class="half"></div>');
            var $half = $skillbar.find('.half');
            $skillbar.css({
              'width': size + 'px',
              'height': size + 'px'
            });
            $percent.css({
              'lineHeight': lhper + 'px',
              'border-style': 'solid',
              'border-width': border + 'px'
            });
            $pie.css({
              'clip': 'rect(0,' + size2 + 'px,' + size + 'px,0)',
              'border-style': 'solid',
              'border-width': border + 'px'
            });
            $half.css({
              'clip': 'rect(0,' + size + 'px,' + size + 'px,' + size2 + 'px)'
            });
            function skillbarrun() {
              if (window.innerWidth >= 1280) {
                $pie1.css({
                  '-webkit-transition': '-webkit-transform ' + duration + 's linear',
                  '-moz-transition': '-moz-transform ' + duration + 's linear',
                  '-ms-transition': '-ms-transform ' + duration + 's linear',
                  '-o-transition': '-o-transform ' + duration + 's linear',
                  'transition': 'transform ' + duration + 's linear'
                });
              }
              $pie1.css({
                '-webkit-transform': 'rotate(' + deg + 'deg)',
                '-moz-transform': 'rotate(' + deg + 'deg)',
                '-ms-transform': 'rotate(' + deg + 'deg)',
                '-o-transform': 'rotate(' + deg + 'deg)',
                'transform': 'rotate(' + deg + 'deg)'
              });
              if (deg >= 180) {
                setTimeout(function(){
                  $half.css({
                    'clip': 'rect(0,' + size + 'px,' + size + 'px,0)'
                  });
                  $pie2.css({
                    'visibility': 'visible'
                  });
                }, Timeout);
              }
            }

            if ( isMobile.any() )
            {
                skillbarrun();
            }else{
                $(window).on('scroll', function() {
                    var windowHeight = $(window).height(),
                        windowScroll = $(window).scrollTop(),
                        offset = $('.skill').offset().top,
                        heightSkill = $('.skill').height();
                    if ((windowHeight + windowScroll) > offset && windowScroll < (offset + heightSkill)) {
                        skillbarrun();
                    }
                });
            }

          });
        }
        $('.scroll-top').on('click', function () {
            $('html, body').animate({
                scrollTop: 0
            }, 800, 'easeInOutExpo');
        });
    }


    function piNavigation()
    {
        if ( $(".pi-navigation").length>0 )
        {
            // window load resize
            var menuType = $('.pi-navigation').data('menu-type'),
                windowWidth = window.innerWidth;
            if (windowWidth <= menuType) {
                $('.open-menu')
                    .show();
                $('.pi-navigation')
                    .find('.nav')
                        .css('height', $(window).height())
                        .removeClass('nav-hover')
                        .addClass('nav-mobile');
                $('.navigation .container').css('position', 'static');
                if ($('.close-menu').length == 0) {
                    $('.pi-navigation')
                        .find('.nav')
                            .append('<li class="close-menu"><span></span></li>');
                }
                $('.navigation .nav > .menu-item-has-children').addClass('hideAfter');
                
                var adminbarHeight = $('#wpadminbar').height();
                if ($('.navigation').hasClass('nav-fixed') == false) {
                    $('#wpadminbar')
                        .closest('body')
                        .find('.nav')
                            .outerHeight($(window).height() - adminbarHeight)
                            .css('top', adminbarHeight);
                }
            } else {
                $('.open-menu')
                    .hide();
                $('.search-box')
                    .removeClass('search-mobile');
                $('.pi-navigation')
                    .find('.nav')
                        .css({
                            'height': 'auto',
                            'top': '0'
                        })
                        .addClass('nav-hover')
                        .removeClass('nav-mobile');
                $('.navigation .container').css('position', 'relative');
                $('.navigation .nav > .menu-item-has-children').removeClass('hideAfter');
            }
        }
    }

    function piOwlCarousel()
    {

        if ($(".team-slider").length) 
        {
            $(".team-slider").owlCarousel({
                autoPlay: false,
                items: 4,
                itemsDesktop : [1199,3],
                itemsDesktopSmall : [992,2],
                itemsTablet: [767,2],
                itemsTabletSmall: [600,1],
                slideSpeed: 200,
                navigation: false,
                pagination: true,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']  
            });
        }

        if ($(".client-slider").length) {
            $(".client-slider").owlCarousel({
                autoPlay: false,
                items: 4,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [992,3],
                itemsTablet: [767,2],
                itemsTabletSmall: [600,1],
                slideSpeed: 200,
                navigation: false,
                pagination: true,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']  
            });
        }

        /*==============================
            Testimonial slider
        ==============================*/
        if ($(".testimonial-slider").length) {
            $(".testimonial-slider").owlCarousel({
                autoPlay: false,
                slideSpeed: 300,
                navigation: true,
                pagination: false,
                singleItem: true,
                autoHeight: true,
                transitionStyle: 'goDown',
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']  
            });
        }

        if ($('.post-slider').length) {
            $('.post-slider').owlCarousel({
                autoPlay: false,
                slideSpeed: 200,
                singleItem: true,
                pagination: false,
                navigation: true,
                autoHeight: true,
                transitionStyle: 'fade',
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right "></i>']
            });
        }

        if ($('.text-slider').length) 
        {
            var $effect = $('.text-slider').data("effect");
            $('.text-slider').owlCarousel({
                autoPlay: true,
                navigation: true,
                slideSpeed: 200,
                singleItem: true,
                pagination: false,
                transitionStyle: $effect,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']  
            });
        }
    }   


    function piYoutubeBg()
    {
        if ( $("#video-element").length > 0 )
        {
          if(isMobile.any()) {
              $('.controls-video').hide();
          } else {
            $('.fullscreen-video').mb_YTPlayer({
                  containment: ".bg-video",
                  loop: true,
                  startAt: 0,
                  autoPlay: true,
                  showYTLogo: false,
                  showControls: false
              });
              var video = $('.fullscreen-video'),
            videoPlay = $('.controls-video .play'),
            videoPause = $('.controls-video .pause'),
            videoVolume = $('.controls-video .volume'),
            headTitle = $('.header-title');
            videoPlay.hide();
            headTitle.hide();
            $('.video-place').hide();
            videoPlay.on('click', function () {
                video.playYTP();
                videoPause.fadeIn(500);
                videoVolume.fadeIn(500);
                headTitle.fadeOut(500);
                $(this).fadeOut(500);
                $('.video-place').fadeOut(500);
            });
            videoPause.on('click', function () { 
                video.pauseYTP();
                videoPlay.fadeIn(500);
                videoVolume.fadeOut(500);
                headTitle.fadeIn(500);
                $(this).fadeOut(500);
                $('.video-place').fadeIn(500);
            });
            videoVolume.on('click', function () {
                video.toggleVolume();
            });
          }
        }
    }

    function piIsotop()
    {
       if ($('.portfolio').length) 
       {
            $('.load-more')
                .closest('#portfolio')
                .find('#portfolio-wrap')
                    .css({
                        'padding-bottom': '161px',
                        'margin-bottom': '30px'
                    });

            var $container = $('.portfolio #portfolio-wrap');
            $container.imagesLoaded(function()
            {
                $container.isotope({
                    transitionDuration: '0.4s',
                    hiddenStyle: {
                        opacity: 0,
                        transform: 'scale(0.001)'
                    },
                    visibleStyle: {
                        opacity: 1,
                        transform: 'scale(1)'
                    }
                });
            });

            $('.portfolio #filters').on('click', 'a', function() 
            {
                $('.select-filter').removeClass('select-filter');
                $(this).parent('li').addClass('select-filter');
                var selector = $(this).attr('data-filter');
                $container.isotope({ filter: selector });
                return false;
            });
        }
    }

    function piCalHeight()
    {
        var pHeight = 0;
        pHeight = $('.about-project').parent().prev().children().outerHeight() - 60;
        
        $('.about-project').height(pHeight);
    }

    function piPortfolioStyle()
    {
        /*If the section, which next to portfolio using background, will remove margin of the portffolio*/
        if ( $("#portfolio").next().children(".bg-parallax").length>0 )
        {
            $("#portfolio").css({'padding-bottom': 0});
        }

        if ( $("#portfolio .pi-has-button").length == 0 )
        {
            $("#portfolio.style3, #portfolio.style4").css({'padding-bottom':'85px'});
        }
    }

    function piCalSounclound()
    {
        /*=========================================*/
        /*  Media 
        /*=========================================*/
        if ( $(".audio-play").length>0 )
        {   
                var $sdata = {};
               $(".audio-play").each(function()
               {  
                  $sdata = $(this).data();
                  SC.oEmbed($sdata.url, { color: "ff0066",auto_play: false, maxheight:$sdata.maxheight},  document.getElementById( $(this).attr("id"))  );
             })
        }
    }


    function piSetBgForHomeSlider()
    {
        var background = $('.home-slider').data('background');
        $('.home-slider .item img')
            .css('opacity', '0')
            .before(function () {
                var srcImg = $(this).attr('src');
                return '<div class="' + background +  '" style="background-image: url(' + srcImg + ')">';
            });
    }     
    
    function piSwitchClientStyle()
    {
        if (isMobile.any()) {
            $('.client-slider')
                .css('height', 'auto')
                .find('.owl-pagination')
                    .css('position', 'static');
            $('.client-item')
                .css({
                    'height': 'auto',
                    'border': '1px solid #efefef'
                });
            $('.client-item')
                .find('.item-content')
                    .css('opacity', '1');
        }
    }

    function parallaxInit() 
    {
        setTimeout(function() {
            if ( $('.bg-parallax').length > 0 )
            {
                if (window.innerWidth >= 1199) 
                {
                    $('.bg-parallax').each(function() {
                            $(this).parallax("50%", 0.4);
                    });
                }
            }
        }, 10);
    }

    function hasThang($target)
    {
        if ( $target == '' || $target.search("#") == -1 )
        {
            return false;
        }else{
            return true;
        }
    }

    function piTwitter()
    {
        if ( $("#twitter").length > 0 )
        {
            $('.twitter-slider').owlCarousel({
                autoPlay: false,
                slideSpeed: 300,
                navigation: true,
                pagination: false,
                singleItem: true,
                autoHeight: true,
                transitionStyle: 'fade',
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']  
            });
        }
    };

    function piFixFooter()
    {
        if ( $(".blog-single").length > 0 )
        {
            var _height=0, _window=0;
            _height = $("#footer").offset().top + $("#footer").outerHeight();
            _window = $(window).outerHeight();

            if ( _window - _height > 0 )
            {
                $("#footer").css({position:'fixed', bottom: 0, left:0, width: '100%'});
            }

        }
    }

    function piSidebarPos()
    {
        var $container = $(".container");
        if ( $(".l-sidebar").length > 0 )
        {
            $container.find(".col-md-9").addClass("col-md-push-3");
            $container.find(".col-md-3").addClass("col-md-pull-9");
        }
    }

    function piMasonryLayout()
    {
        var $container = $('.blog-grid-2');
        if ($container.length) 
        {
          $container.imagesLoaded(function()
          {
            $container.masonry({
                columnWidth: 0,
                itemSelector: '.grid-item'
            });
          })
        }
    }

    function piSwitchBgStyle()
    {
        $('.bg-parallax, .bg-static, .bg-color')
            .parent('section')
                .css('background', 'none');

        var $target = $('.post-format-icon').closest(".post-title");
        if ( $('.post-format-icon').closest(".post-title").length > 0 )
        {
            $target.addClass('title-format');
        }    
    }

    function piSwithcSharingTag() {
        if ( $(".pi-wrap-sharing-tag").children().length < 1 )
        {
            $(".pi-wrap-sharing-tag").remove();
        }else{
            $(".post.post-single").css({'border-bottom':0});
        }
    }

    function piSwitchWrapClass()
    {
        $('.blog-wrap .col-md-12')
        .find('.blog-grid-2')
        .find('.grid-item')
        .addClass('col-md-4');
    }

    function piPlaceholder()
    {
        var $ph = $('input[type="search"], input[type="text"], input[type="url"], input[type="email"], textarea');
        $ph.each(function() {
            var value = $(this).val();
            $(this).focus(function() {
                if ($(this).val() === value) {
                    $(this).val('');
                }
            });
            $(this).blur(function() {
                if ($(this).val() === '') {
                    $(this).val(value);
                }
            });
        });
    }

    /*==============================
        BLOG GRID
    ==============================*/
    function piMasonry() {
        var $container = $('.blog-grid');
        if ($container.length) {
            $container.imagesLoaded(function(){
               $container.masonry({
                    columnWidth: '.grid-sizer',
                    itemSelector: '.post'
                });
            })
        }
    }

    //Equalize
    $.fn.equalize = function() {
        var maxHeight = 0;
        this.each(function(){
            if( $(this).height() > maxHeight ) {
                maxHeight = $(this).height();
            }
        });
        this.height(maxHeight);
    };

    function piCalPricing()
    {
        //window load resize
        var windowWidth = window.innerWidth;
        if (windowWidth > 767) {
            $('.service-item').equalize();
        } else {
            $('.service-item').height('auto');
        }
        if (windowWidth > 600) {
            $('.pricing-item').equalize();
        } else {
            $('.pricing-item').height('auto');
        }
    }


    // LOAD JS
    $(document).ready(function() {
        
        piEvents();
        piCalHeight();
        piTabs();
        piAccordion();
        piOwlCarousel();
        
        
        piPortfolioStyle();
        piCalSounclound();
        piSetBgForHomeSlider();
        piSwitchClientStyle();
        piTwitter();
        piIsotop();
        piSwitchBgStyle();
        piSidebarPos();
        piSwithcSharingTag();

        piFixFooter();
        piSwitchWrapClass();
        piPlaceholder();


        piMasonryLayout();
        piMasonry();
    

        if ( $(".pi-fix-display-one").length == 1 )
        {
            $(".pi-fix-display-one").parent().attr("class", "col-md-6 col-offset-3");
        }

        $('.st-heading').each(function() 
        {
            if ($(this).children().length == 0) {
                $(this).siblings('.st-body').css('margin-top', '0');
            }
        });

        
        if(isMobile.any()) {
            $('.team-item')
                .addClass('click-mobile')
                .removeClass('hover-team');
        } else {
            $('.team-item')
                .addClass('hover-team')
                .removeClass('click-mobile');
        }

        $("#team").on('click', ".team-item.click-mobile", function(e) 
        {
            $('.team-item').addClass('social-show');
            e.stopPropagation();
        });

        $('html').on('click', function() 
        {
            $('.team-item').removeClass('social-show');
        });

        if (window.innerWidth <= 600) {
            $('#wpadminbar')
                .closest('body.home')
                .find('.navigation')
                    .css('top', '46px');
        }

        $('.st-heading').each(function() {
            var $this = $(this);
            if ($this.children('.fa-bookmark-o').siblings().length == 0) {
                $this.next('.st-body').css('margin-top', '0');
            }
        });

    });
})(jQuery, window, document);
