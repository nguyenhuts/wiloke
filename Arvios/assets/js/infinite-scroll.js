;(function($, document, window, undefined){
    "use strict"
    
    $.fn.loadmore = function(options)
    {
        // default values
        var _oDefaults = {
            nextSelector : '.wrap-loadmore-button a:first', 
            navSelector: '.wrap-loadmore-button',
            errorCallback: function () { },
            afterSuccess: function(){},
            itemSelector: '.item',
            isClick: true, // unbind load more items when scroll down, just load more when after clicked button
            targetClick: '.fire-loadmore'
        };


        options = $.extend(_oDefaults, options);

        /*Load more code*/

        var $container = $(this);
            $container.infinitescroll(
            {
                debug: true,
                navSelector  : options.navSelector,
                nextSelector : options.nextSelector,
                itemSelector : options.itemSelector,
                animate      : true, 
                loading: {
                   msgText  : 'Loading new items...',      
                   finishedMsg: 'No more items to load.',
                   img: 'http://i.imgur.com/AI0agRP.gif'
                },
                dataType: 'html',
                errorCallback: function () { 

                    options.errorCallback();
                }
            }, function( newElements, data, url ) {
                    options.afterSuccess(newElements, data, url);
                }
            );

            if ( options.isClick )
            {
                $(window).unbind('.infscr');
                $(options.targetClick).bind("click", function()
                {   
                    $container.infinitescroll('retrieve');
                    return false;
                })
            }
    }

    /*=========================================*/
    /* Example
    /*=========================================*/

    var _errorCallback = function()
    {
        $(".fire-loadmore").html("The End").attr("disabled", "disabled");
        $(".wrap-loadmore-button").css({display:'block'});
    }

    var _callback = function(newElements, data, url)
    {
        var $newElements = $(newElements);  

        $(".wrap-loadmore-button").css({display:'block'});


        // initialize Isotope after all images have loaded
        var $container = $('#portfolio-wrap').imagesLoaded( function() {
              $('#portfolio-wrap').isotope( 'insert', $newElements );
              // $('#portfolio-wrap').isotope("reload");
        });
                

        pi_toggle_nav_item_in_portfolio_page();
    }

    $("#portfolio-wrap").loadmore({itemSelector: "#portfolio-wrap .portfolio-item ", afterSuccess: _callback, errorCallback: _errorCallback});

    function pi_toggle_nav_item_in_portfolio_page()
    {
        
        var _target="", $container = $("#portfolio-wrap");
        $("#filters li a").each(function()
        {
            _target = $(this).attr("data-filter");
            
            if ( _target != '*' )
            {
                if ( $container.find(_target).length == 0 )
                {
                    $(this).fadeOut();
                }else{
                    $(this).fadeIn();
                }
            }
        })   
    }

    pi_toggle_nav_item_in_portfolio_page();
    
})(jQuery, document, window);