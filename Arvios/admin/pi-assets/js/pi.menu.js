// create by pirateS&&themeilite - wiloke.com - piratesmorefun@gmail.com
(function($, window, document, undefined)
{
    "use strict";

    $(document).ready(function()
    {
        $(document).on("click", "#pirates-temenu", function(event)
        { 
          
            event.preventDefault(); 
            var _obj = $(this), _appendTo =  $("#menu-to-edit");
           
            $("form#nav-menu-meta").ajaxSubmit(
            {
                type: 'POST',
                url: ajaxurl,
                data: {action:'pi-addmenu',menu: 2},    
                beforeSend: function()
                {
                    _obj.next().fadeIn();
                },
                success: function(res)
                {
                    _obj.next().hide();
                    _appendTo.append(res);
                    var getNth = _appendTo.length;
                    _appendTo.eq(getNth-1).find(".field-description.description, .field-link-target, .field-css-classes, .field-xfn, .edit-menu-item-url").addClass("hidden-field");
                    _appendTo.eq(getNth-1).find(".menus-move-up, .menus-move-down, .menus-move-left, .menus-move-right, .menus-move-top").show();

                    $(".pirates-pi-menu").prop('checked', false);
                }
            })
        })
    })
})(jQuery, window, document)