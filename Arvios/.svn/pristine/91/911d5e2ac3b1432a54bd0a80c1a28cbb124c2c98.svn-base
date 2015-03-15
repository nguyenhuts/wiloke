;(function($, window, document, undefined)
{
	"use strict";
	var $doc;
	$doc = $(document);
	$.teThemes =  $.teThemes || {};
	$(document).ready(function()
	{
		//add more 
		$doc.on("click", ".pi_addmore", function()
		{
			var $getData, $this = $(this), $maxData, $current, $innerButton = "";
			$getData = $(this).data();
			$current = $this.attr("data-currentmaxorder");
			$innerButton = $this.html();
			$this.html("Adding...");
			$maxData = parseInt($current) + 1;
			$this.attr("data-currentmaxorder", $maxData);
			$.ajax(
			{ 
				url: ajaxurl,
				data:{action:'hello_ajax', render: $getData.type, max: $current},
				type: "POST",
				success: function(res)
				{ 
					if ($getData.type == 'skill' || $getData.type == 'service' || $getData.type == 'fact' || $getData.type == 'pricing')
					{
						$this.closest('.pi_wrap_button').prev().append(res);
					}else{
						$this.closest('.pi_wrap_button').siblings('.pi_append_here').prepend(res);
						if ($(res).find(".js_date_picker").length>0)
						{
							$(".js_date_picker").datepicker({dateFormat: "M, yy"});
		 				}
					}
					$this.html($innerButton);
				}
			})
		})


		$.teThemes.pi_remove_image(".pi-remove");

		var elems = Array.prototype.slice.call(document.querySelectorAll('.pi_switch_checkbox'));

		elems.forEach(function(html) {
		  var switchery = new Switchery(html, {color: '#41b7f1'});
		});
				
  		$(".pi-toggle").each(function()
		{
			pi_toggle($(this));
		})
		$doc.on("click", ".pi-toggle", function(event)
		{
			event.preventDefault();
			pi_toggle($(this));
		});

		function pi_toggle($this)
		{
			var $getData = $this.data();

			var $method = $getData.method;
			var $target = $getData.target;

			if ( $this.hasClass("is_active") )
			{
				$this[$method]($target).fadeOut();
				$this.removeClass("is_active");
				$this.children().attr("class", "fa fa-plus-square");
			}else{
				$this[$method]($target).fadeIn();
				$this.addClass("is_active");
				$this.children().attr("class", "fa fa-minus-square-o");
			}
		}

		$doc.on("click", ".pi-detele-tab", function(event)
		{
			event.preventDefault();

			if ( $(this).closest(".form-table").find(".pi-parent").length <= 1 )
			{
				alert("Opp, You need at least one item "); 
			}else{
				var $getMes = confirm("Press OK to delete, Cancel to leave");
			
				if ( $getMes === true ) 
				{
					$(this).closest(".pi-parent").remove();
				}
			}
		})

		$(".pi-add-tabs").click(function()
		{
			var $incrementIcon = $(this).data("iinceament") ? $(this).data("iinceament") : "";
			var $keyName = $(this).data("name") ? $(this).data("name") : null;
			var $img = $(this).data("img") ? $(this).data("img")  : "";

			$(".pi-parent").each(function()
			{
				$(this).find(".pi-toggle").removeClass("is_active");
				$(this).find(".pi-toggle").children().attr("class", "fa fa-plus-square");
				$(this).find(".pi-wrap-content").css({display: 'none'});
			})
			// $(".pi-parent").find(".pi-toggle").removeClass("is_active");
			// $(".pi-parent").find(".pi-toggle").children().attr("class", "fa fa-plus-square");
			// $(".pi-parent").find(".pi-wrap-content").fadeOut();

			var $clone =  $(this).closest(".pi-wrap-add").prev().clone(true);
				$($clone).find("input").val("");
				$($clone).find("textarea").html("");
				$($clone).find(".js_date_picker").attr("id", "");
				$($clone).find(".js_add_icon i.fa").attr("class", "fa fa-refresh " + $incrementIcon);
				$($clone).find(".pi-toggle").addClass("is_active");
				$($clone).find(".pi-wrap-content").fadeIn();
				$($clone).find(".pi-toggle").children().attr("class", "fa fa-minus-square-o");
				$($clone).find(".pi-insert-icon").val("fa fa-refresh " + $incrementIcon);

				if ( $keyName !== null )
				{
					var reg = new RegExp('('+$keyName+'\\[)([^\\]]*)(.*)', 'g');
					var $randomKey  = Math.floor((Math.random() * 10000000) + 1);
					$($clone).find("input, textarea, select").each(function()
					{
						var $getName = $(this).attr("name");

						var $newName = $getName.replace(reg, function(match, first, change, last)
						{
							
							return first + $randomKey + last;
						});

						$(this).attr("name", $newName);
					})
				}

				if ( $img != "" )
				{
					$clone.find(".lux-gallery  img").attr("src", $img);
				}

				$(this).closest(".pi-wrap-add").before($clone);

				if ( $($clone).find(".js_date_picker") )
				{
					$(".js_date_picker").datepicker("destroy");
					$(".js_date_picker").datepicker();
				}

			return false;
		})

		if ($(".js_date_picker").length>0)
		{
			$(".js_date_picker").datepicker({dateFormat: "M, yy"});
		}

	 	$(".pi-add-contact").click(function()
		{
			var $clone = "";
			$clone = $(this).prev().clone();
			$($clone).find("input, textarea").val("");
			$(this).before($clone);
			return false;
		})

		$(".pi-wrapsettings").on("click", ".js_remove_image", function(event)
	  	{
	  		event.preventDefault();

	  		$(this).prev().prev().find("img").attr("src", $(this).data("placeholder"));
	  		$(this).prev().val("");
	  	})

		$(".toggle-settings").change(function()
	 	{
	 		if ($(this).is(":checked"))
	 		{
	 			($(this).closest(".wo-flag").nextAll()).fadeIn();
	 		}else{
	 			($(this).closest(".wo-flag").nextAll()).fadeOut();
	 		}
	 	}).trigger('change');

	 	$(".pi_color_picker").spectrum({showAlpha: true, preferredFormat: "rgb"});

	 	
	 	function pi_check_toggle()
		{
			var _toggle;
			$(".pi_check_toggle").change(function()
			{
				_toggle = $(this).attr("data-toggle");
				
				if ( $(this).is(":checked")  )
				{
					$(_toggle).show();
					
				}else{

					$(_toggle).hide();
				}
				
			});
			$(".pi_check_toggle").trigger("change");
		}
		pi_check_toggle();
		
		function pi_check_overlay($this)
		{

		}

		function pi_toggle_multi()
		{
			var $selected = "", $show="", $hide="", _fcallback="";
			$(".panel-body").on("change", ".pi_toggle_multi", function()
			{
				$selected =  $(this).find("option:selected");
				$show 	  = $selected.attr("data-show");
				$hide 	  = $selected.attr("data-hide");
				_fcallback = $selected.attr("data-callback");
				
				if ( $hide )
				{
					$($hide).hide();
				}

				if ( $show )
				{
					$($show).show();
				}

				if ( _fcallback == 'transparent_id'  )
				{
					if ( $($selected.attr("data-transparentid")).is(":checked") )
					{
						$($selected.attr("data-transparentid")).fadeIn();
					}
				}

			});

			$(".pi_toggle_multi").trigger("change");
		}
		pi_toggle_multi();

		$doc.on("click", ".pi-delete-item", function()
		{
			if (  $(this).closest(".pi_append_here").children().length > 1 )
			{
				var _confirm = confirm("Press Oke to remove, Cancel to leave");
				if (_confirm)
				{
					$(this).closest(".pi-delete").remove();
				}
			}else{
				alert("Opp,You need at least one item");
			}
			return false;
		})

		$doc.on("click", ".js_add_icon", function(event)
	    {	
    	 	event.preventDefault();
		 	$(this).addClass("active");
		 	

		 	if ( $(this).attr("data-issocial") )
		 	{
		 		$("#fa-table-list .pi-collection:not(.pi-socials)").hide();
		 	}else{
		 		$("#table-fa .pi-collection").show();
		 	}

		 	var _self = "";
		 		_self = $(this);	

	    	tb_show("Choose Icon", "#TB_inline?height=500&amp;width=400&amp;inlineId=table-fa");
	    	
	    	$("#fa-table-list").on("click", "li", function()
	    	{

		        var codeFa = $(this).children().attr("class");
	         	$(".js_add_icon.active").find("i.fa").attr("class", codeFa);
	         	$(".js_add_icon.active").next().val(codeFa);
	         	$(".js_add_icon.active").removeClass("active");

	         	tb_remove();
	         	
		    });  
	    });
	})

    $.teThemes.pi_remove_image = function(className)
    {
        $(document).on("click", className, function(event)
        {
            // console.log("a");
            event.preventDefault();
            if ( !$(this).hasClass("js_remove_video") )
            {
            	if ( !$(this).hasClass("customize-control") )
            	{
            		var getVal = $(this).parent().parent().next().find(".box-image-id");
            		console.log(getVal);
            	}else{
            		var getVal = $(this).closest(".image-wrap").siblings(".wo-insert-link");
	                getVal.trigger("keydown");
            	}
	            
	            var index = $(this).parent().data("id"),
	            oldids = $.map(getVal.val().split(','), function(value)
	             {
	                if (value != "")
	                    return parseInt(value);
	             });

	            if (oldids.length > 1)
	            {
	              oldids = $.teThemes.pi_removeId(oldids, index);
	              getVal.val(oldids.join(","));
	            }else{
	              getVal.val("");
	            }
	            
	           	if ($(this).parent().length > 0)
	           	{
	               $(this).parent().fadeOut('slow', function() 
	               {
	                  $(this).remove();
	               });
	            }

	            getVal.trigger("change");
	        }else{
	        	$(this).closest(".lux-gallery").html("");
	        	$(".pi_of_video").val("");
	        }
        });
    };

    $.teThemes.pi_removeId = function(arr, id)
    {

    	for(var i=0; i<arr.length; i++)
        {
           if (arr[i] == id || typeof arr[i] == id)
           {
              arr.splice(i, 1);
           }
        }
	  
        return arr;
    }

})(jQuery, window, document)