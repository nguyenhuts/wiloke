;(function($, window, document, undefined)
{
	"use strict";

	$(document).ready(function()
	{
		if ($(".pi_charts").length>0)
		{
			$(".pi_charts").easyPieChart();
		}


		$("#pi_skills").on("blur", ".pi_skill_value", function()
		{
			var $percent = $(this).val();
			var $target  = $(this).siblings(".pi_charts");
			$target.data('easyPieChart').update($percent);
 			$target.find(".percent").text($percent+ '%');
		})
	})


})(jQuery, window, document)