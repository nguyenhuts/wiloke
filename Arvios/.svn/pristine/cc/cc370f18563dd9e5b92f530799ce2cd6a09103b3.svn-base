(function($, document, window, undefined)
{

    "user strict";

    $.Pi_MEDIA = $.Pi_MEDIA || {};

    $.Pi_MEDIA.init =  function(options)
    {
        var oDefaults = 
        {
            url      : "",
            targetClass   : ".pi-use-media"
        }

        var $options = $.extend( {}, oDefaults, options);
        

        $.Pi_MEDIA.setup($options);
    }

    $.Pi_MEDIA = 
    {
        setup: function($options)
        {
            this.init($options);
        },

        init: function($options)
        {
           
            var $url = $options.url;

            var $img =    $.Pi_MEDIA.excu_parse($url);
            return $img;
            
        },

        excu_parse: function(getUrl)
        {   
            var getUrl , img="", id_vimeo, getdata={};
               
            
                
                if ( $.Pi_MEDIA.is_youtube(getUrl) )
                {
                    img = $.Pi_MEDIA.get_background_youtube(getUrl);
                    return img;
                }else if( $.Pi_MEDIA.is_vimeo(getUrl) )
                {
                    id_vimeo = $.Pi_MEDIA.get_background_vimdeo(getUrl);
                    return id_vimeo;
                }else{
                    alert("You must be enter to video link");
                    return null;
                }


        },

        get_background_youtube : function(url) 
        {
            var id = url.match("[\\?&]v=([^&#]*)"),ivalue={},img='', data;

            ivalue={'type':'youtube','id':id[1],'image':'http://i.ytimg.com/vi/'+id[1]+'/hqdefault.jpg'};
            
            img = [
                  '<img width="150" height="150" src="'+ivalue['image']+'">',
                  ];
            youtube=[ivalue.id];

            data = {image:img.join(""), id: id[1], type: 'youtube', poster: ivalue.image};
            
            return data;
        },

        get_background_vimdeo: function(url) 
        {
            var id_vimeo,m = url.match(/^.+vimeo.com\/(.*\/)?([^#\?]*)/),ivalue={},img='', vimeo;
            id_vimeo = m ? m[2] || m[1] : null;;

            if(id_vimeo!=undefined)
            {
                return id_vimeo;
            }else alert('Can not get Vimeo ID');
            
            return null;
            // return getdata;
           
            // return;
        },

        is_youtube: function(url)
        {
            var matches = url.match(/youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)/);
            if (url.indexOf('youtube.com') > -1)
                return true;
            if (url.indexOf('youtu.be') > -1)
                return true;
            return false;
        },
        
        is_vimeo: function(url)
        {
            if(url.indexOf('vimeo.com') > -1)
                return true
            return false;
        },



    }

// $("input.media-add-video").get_video();

})(jQuery, document, window)