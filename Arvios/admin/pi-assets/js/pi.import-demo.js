;(function($, window, document)
{
    $(document).ready(function()
    {
        /* import demo data */ 
        $(".import-demo-data").click(function()
        {
            var _self=$(this), wp_nonce = $("input[name=_wp_nonce]").val(), wp_http_referer = $("input[name=_wp_http_referer]").val();
            
         
            $.ajax(
            { 
                type: 'POST',
                url: ajaxurl,
                async: true,
                data: {action: 'wiloke-import', _wp_nonce: wp_nonce, _wp_http_referer: wp_http_referer},
                beforeSend:function()
                {
                    // _self.html("Importing...");
                    $(".processbar").removeClass("hidden");
                    _self.fadeOut();
                    
                    for(var i=0; i<=9; i++)
                    {
                        (function(i)
                        {
                            setTimeout(function(){
                                $(".progress-bar").css({width: i*10+'%'});
                            }, 100*i);
                        })(i);
                    }   
                },
                success: function(res)
                {    
                    $(".progress-bar").css({width: '100%'});
                    $(".progress-bar").removeClass("progress-bar-danger").addClass("progress-bar-success");
                    $(".wo-alert").html(res);
                }

            })
            return false;
        })//end document ready
        

    
    })
})(jQuery, window, document)