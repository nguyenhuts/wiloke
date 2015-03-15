;(function($, window, document, undefined)
{
	"use strict";

	$(document).ready(function()
	{
		if ($(".pi_charts").length>0)
		{
			$(".pi_charts").easyPieChart();
		}

		$(".pi_append_here").on("click", ".skill-del", function(event)
		{
			event.preventDefault();

			var _confirm = confirm("Press OK to remove, Cancel to leave");

			if ( _confirm )
			{
				$(this).closest(".pi-delete").fadeOut(function()
				{
					$(this).remove();
				})
			}

		})

		$("#pi_skills").on("blur", ".pi_skill_value", function()
		{
			var $percent = $(this).val();
			var $target  = $(this).siblings(".pi_charts");
			$target.data('easyPieChart').update($percent);
 			$target.find(".percent").text($percent+ '%');
		})
	})


})(jQuery, window, document)