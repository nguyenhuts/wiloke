(function($, window, document, undefined)
{
    "user strict";
    $(document).ready(function()
    {
		$("#page_template").change(function()
        {
            var _selected = $(this).val();
            if ( _selected == 'portfolio.php' )
            {
                $("#pi-portfolio").fadeIn();
            }else{
                $("#pi-portfolio").fadeOut();
            }
        }).trigger("change");
     })
 })(jQuery, window, document);