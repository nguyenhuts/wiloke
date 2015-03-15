;(function($, document, window)
{	
	"use strict"

	$(document).ready(function()
	{
		$(".js_add_social").click(function()
		{
			
			var $html 	= '<p class="pi_contactinfo">\
							<a class="js_add_icon" data-issocial="true" href="#">\
								<i class="fa fa-refresh"></i>\
							</a>\
							<input type="hidden" value="fa fa-refresh" name="theme_options[footer][social_icon][]">\
							<input type="text" value="" placeholder="Link" name="theme_options[footer][social_link][]">\
							<a class="js_delete_item" href="#">\
								<i class="fa fa-times"></i>\
							</a>\
						</p>';
			$(this).before($html);
			return false;
		})

		$(".js_add_info_contact").click(function()
		{
			var useClass = $(this).data("useclass");
			var $html 	= '<p class="pi_contactinfo">\
							<a class="'+useClass+'" href="#">\
								<i class="fa fa-refresh"></i>\
							</a>\
							<input type="hidden" value="fa fa-refresh" name="theme_options[contact][info_icon][]">\
							<input type="text" value="" placeholder="Infomation" name="theme_options[contact][info][]">\
							<a class="js_delete_item" href="#">\
								<i class="fa fa-times"></i>\
							</a>\
						</p>';
				$(this).before($html);
			return false;
		})
	})

})(jQuery, document, window)