(function($, window, document, undefined)
{
    "user strict";
    $(document).ready(function()
    {
        var $wilDis = "", $getChecked = "";
        $("#post-formats-select .post-format").change(function()
        {
           $getChecked = $("#post-formats-select .post-format:checked").val();
           pi_switch_header_options($getChecked);   
        });

        $getChecked = $("#post-formats-select .post-format:checked").val(); 
        pi_switch_header_options($getChecked);

        function pi_switch_header_options($getChecked)
        {
          switch ( $getChecked  )
          {
            case 'gallery':
                $wilDis = ".zone-of-slideshow";
                break;

            case 'quote':
                $wilDis = ".zone-of-quote";
                break;

            case 'video':
                $wilDis = ".zone-of-youtube";
                break;

            case 'audio':
                $wilDis = ".zone-of-audio";
                break; 
            case 'image':
                $wilDis = ".zone-of-image";
                break;
            default:
                $wilDis = ".zone-of-standard";
                break;
          }



          $("#pi-header-type .form-group").fadeOut();
          $("#pi-header-type "+ $wilDis).fadeIn();
        }

        
    })
})(jQuery, window, document);