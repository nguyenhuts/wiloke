(function($) {
	"use strict"

	$(document).ready(function() 
	{ 
			$(window).on('load resize', function() {
				$('.inner-content').css('min-height', $(window).height());
			});
			if ($("#main-tab").length > 0 )
			{
				$( "#main-tab" ).tabs({
					  	active   : $.cookie('activetab'),
					    activate : function( event, ui ){
					        $.cookie( 'activetab', ui.newTab.index(),{
					            expires : 10
					        });
					    }
				});
			}
			if ($(".wo-wrap-subtabs").length > 0 )
			{
				$( ".wo-wrap-subtabs" ).tabs({
					  	active   : $.cookie('subtabs'),
					    activate : function( event, ui ){
					        $.cookie( 'subtabs', ui.newTab.index(),{
					            expires : 10
					        });
					    }
				});
			}

			if ($(".inner-tab").length > 0 )
			{
				$( ".inner-tab" ).tabs({
					active   : $.cookie('activeinnertab'),
				    activate : function( event, ui ){
				        $.cookie( 'activeinnertab', ui.newTab.index(),{
				            expires : 10
				        });
				    }
				});
			}
			
			if ($("#accordion").length > 0 )
			{
				$( "#accordion" ).accordion();
			}


			$("input[name=export-theme-options]").click(function()
			{
				$.download(ajaxurl,'action=export_theme_options_data');
				return false;
			});
			$.download = function(url, data, method){
				if( url && data ){
					data = typeof data == 'string' ? data : jQuery.param(data);
					var inputs = '';
					jQuery.each(data.split('&'), function(){
						var pair = this.split('=');
						inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />';
					});
					jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
						.appendTo('body').submit().remove();
				};
			};

			$(".text_slider_settings .children").hide();
			$(".pi_add_textslider").click(function()
			{
				if ( $(".text-slider-title").last().val() == '' || $(".text-slider-des").last().val() =='')
				{
					alert("Please fill all data");
				}else{
					var $content = "";
					var count = $(".text_slider_settings").length;
					console.log(count);
					$content = $(this).parent().prev().clone(true);
					$content.find("input[type=text]").val("");
					$content.find("textarea").html("");
					$(".pi-toggle.inner").removeClass("is_active").children().attr("class", "fa fa-plus-square");
					($(".text_slider_settings:lt("+count+")").children(".children")).hide();
					$content.find(".pi-toggle.inner").addClass("is_active");
					$(this).parent().before($content);
					$(".text_slider_settings").last().children().show();
				}
				return false;

			})

			$(".pi-header-toggle").slideToggle();

			$(".wo-logo-type").change(function()
			{	
				var logoType = $(this).val();
				
				if (logoType == 'text')
				{
					$(".upload-logo").hide();
					// $(".image_fixed").hide();
					$(".logo-text").show();
				}else{
					$(".logo-text").hide();
					// $(".image_fixed").hide();
					$(".upload-logo").show();
				}
			}).trigger("change");

			$(".pi-nav_design").change(function()
			{
				var $val = $(this).find("option:selected").val();
					$val = typeof $val == 'undefined' ? 1 : $val;
				if ( $val == 1 )
				{
					$(".pi-withoutnavigation").hide();
					$(".pi-withnavigation").show();
				}else{
					$(".pi-withoutnavigation").show();
					$(".pi-withnavigation").hide();
				}
			}).trigger("change");

			var formSocial1 =  '<div class="form-group item form-social fix-form wrap-social wo-footer-socials">\
                                              <a class="icon thickbox available-panel"href="#TB_inline?width=600&height=500&inlineId=table-fa"><i class="fa fa-refresh"></i></a>\
                                              <input type="hidden" name="theme_options[footer][social][social_icon][]" value="fa fa-refresh">\
                                              <input type="text" name="theme_options[footer][social][social_link][]" value="" placeholder="Link">\
                                              <a class="remove-socials" data-class="remove"><i class="fa fa-times"></i></a>\
                                   </div>';

			$(".wo-footer-addsocial").on("click", function(event)
			{
				event.preventDefault();
				

                $(this).parents(".wo-add-social").before(formSocial1);                   
			})

			$(".remove-socials").live("click", function(event)
			{
				event.preventDefault();
				$(this).parents(".wo-footer-socials").hide("slow", function(){$(this).remove()});

	
				if ( ($(".wo-footer-socials").length == 1) )
				{
					$(".wo-add-social").before(formSocial1);         
				}
			})

			$(document).on("click", ".upload-img",function()
			{

	            var current = $(this), insertTo = current.data("append"), insertLink=current.data("insertLink");
	           
	            var send_attachment_bkp = wp.media.editor.send.attachment;
	            wp.media.editor.send.attachment = function(props, attachment) 
	            {

	                var image_size =  props.size;
	                var image_url = "";

	                if ( typeof attachment.sizes !== 'undefined' )
	                {
	                	image_url = attachment.sizes[image_size].url
	                }else{
	                	image_url = attachment.url;
	                }

	                var insert_link = "";
	                
	                if ( current.hasClass("blog-img") )
	                {
	                	insert_link = attachment.id;
	                }else{
	                	insert_link = attachment.url;
	                }


	                current.siblings(insertTo).html('<span><img src="'+image_url+'"></span>');
	                current.siblings(insertLink).val(insert_link);
	                wp.media.editor.send.attachment = send_attachment_bkp;
	            }
	            wp.media.editor.open();
	            return false;
	        });


		  	$(document).on("click", ".qva-design li", function(event)
	        {
	        	event.preventDefault();
	        	var keyData = $(this).attr("data-key");
	        	
	        	$(this).parent().find(".skin-active").removeClass("skin-active");
	        	$(this).parent().next().attr("value", keyData);
	        	$(this).addClass("skin-active");

	        	if ( keyData == 'pi_use_custom_color' )
	        	{
	        		$(".picolor.custom_color").removeClass("hidden");
	        	}else{
	        		$(".picolor.custom_color").addClass("hidden");
	        	}     	
	        })
			
		 	// order section
		 	$(".section-order-reset").on("click",function()
		 	{
		 	   	var $target = $(this).data("target");
	            var order = PI_CONFIG.sections;
	            var aReset = [];
	            var gindex = 0;


	           	for(var i=0;i<order.length;i++)
	           	{
	               $("#pi-sortable li[data-name='"+order[i]+"']").detach().appendTo("#pi-sortable");
	           	}

	           	$("#pi-sortable li").each(function()
	           	{
	           		aReset.push($(this).attr("data-name"));
	           	})
		 	    
	           	aReset = aReset.join(",");
           	 	$(".section-order").val(aReset);
	           	return false;
	        });


		 	if ($(".js_section_order").length>0)
		 	{
		 		$(".js_section_order").sortable(
		 		{
		 			update: function(event, ui) 
		 			{
	                    var order = [];
	                    var $currentParent = "#" + ui.item.parent().attr("id");
	                    $($currentParent+' li').each( function(e) 
	                    {
	                        order.push( $(this).attr('data-name'));
	                    });
	                    // join the array as single variable...
	                    var positions = order.join(',');
	                    $(".section-order").val( positions );
	                    return true;
	                }
		 		})
		 	}

		 	$(".js_builder_mode").change(function()
		 	{
		 		$("#form-section-builder .section-builder").hide().removeClass("active");
		 		var $target = $(this).find("option:selected").data("target");
		 		$($target).show().addClass("active");
		 	}).trigger("change");

			$(document).on("click", ".js_delete_item", function(event)
			{
				event.preventDefault();
				$(this).closest(".pi_contactinfo").remove();
			})
 			
	        $(".choosidebar").click( function()
	        {
	            var sidebar="";
	                $(".choosidebar").removeClass("sidebar-active");
	                $(this).addClass("sidebar-active"); 
	                sidebar = $(this).data("sidebar");
	                $("input.sidebar-value").attr("value",sidebar);
	            return false;
	        })

        	$("input[name=import-theme-options]").click(function()
			{
				
				var _dataImport = $("textarea[name=data-import]").val(),  _self=$(this), wp_nonce = $("input[name=_wo_nonce]").val(), wp_http_referer = $("input[name=_wp_http_referer]").val();
				if (_dataImport == '')
				{
					alert("Please fill your data");
				}else{
					$.ajax(
					{
						url: ajaxurl,
						type: 'POST',
						data: {action: 'import_theme_options', data: _dataImport, _wp_nonce: wp_nonce, _wp_http_referer: wp_http_referer },
						beforeSend: function()
						{
							_self.val("Importing...");
							_self.prop("disable", true);
						},
						success: function(res)
						{
							var _parse = $.parseJSON(res);
							// alert(_parse.mes);
							// _self.val("Import");
							if (!_parse.error)
							{
								$("#pi-success").show();
								_self.val("");
							}else{
								$("#pi-empty-data").show();
							}
							setTimeout(function(){
								$(".alert").hide('slow');
								_self.prop("disable", false);
							}, 2000);
							_self.val("Import");
						}
					})
				}

				return false;
			})

	        // save themoptions
	        $("button[name=pi-save-options]").click(function()
	        {	
	        	var $getBlog = $(".pi-js_chosen").val();
	        		$(".pi-js_chosen").after("<input id='pi-tempo' type='hidden' name='theme_options[blog][content]' value='"+$getBlog+"'>");
	        	

	        	var wp_nonce = $("input[name=_wo_nonce]").val(), wp_http_referer = $("input[name=_wp_http_referer]").val();
	        	var $data = $("#wpbody-content form").serialize();
	        	var _current_lang = $("#pi_current_lang").val();

	        	$.ajax(
	        	{
	        		url: ajaxurl,
	        		type: "POST",
	        		data: {action: 'save_theme_options', _wp_nonce: wp_nonce, _wp_http_referer: wp_http_referer, data: $data, lang:_current_lang},
	        		beforeSend: function()
	        		{
	        			$(".pi-saving").css({display: 'block'});
	        		},
	        		success: function(res)
	        		{
	        			var $parse = $.parseJSON(res);

	        			setTimeout(function()
	        			{
	        				$(".pi-saving").css({display: 'none'});
	        				$("#pi-tempo").remove();
	        				if ($parse.status=='1')
	        				{
	        					$("#pi-success").show();
        						setTimeout(function()
			        			{
			        				$("#pi-success").hide();	
			        			}, 1000);
	        				}else{
	        					$("#pi-empty-data").show();
        						setTimeout(function()
			        			{
			        				$("#pi-empty-data").hide();	
			        			}, 1000);
	        				}
	        			}, 1000);
	        		}
	        	})

	        	return false;
	        })

			// Dropabble
			var $piBuilderElements  = $("#pi-builder-elements"),
				$piCustomizeSection	= $("#pi-customize-section"), 
				piSection = {};
			$( "#pi-builder-elements, #pi-customize-section" ).sortable(
			{
				connectWith: ".pi-conected-sortable",
				receive: function(event, ui)
				{
					// myArguments = assembleData(this,myArguments);
				},
				update: function(e,ui) 
				{
					// console.log(ui.item.parent().attr("id"));
					if (this === ui.item.parent()[0]) 
					{
						  // In case the change occures in the same container 	
						if (ui.item.parent().attr("id") == 'pi-customize-section') 
						{
						 	assembleData(this,piSection);		
						} 
					}
				},
				remove: function(e, ui)
				{
					if (ui.item.parent().attr("id") != 'pi-customize-section') 
					{
						assembleData(this,piSection);
					}
				}		
			})
		

			function assembleData(obj, args)
			{
				var data = $(obj).sortable('toArray', {attribute: 'data-id'}); // Get array data 
				
				$("#pi-customize-section input.section-order").attr("value",data.join(","));
			}
  
			            
			var elems = Array.prototype.slice.call(document.querySelectorAll('.pi_switch_button'));

			elems.forEach(function(html) {
			  var switchery = new Switchery(html, {color: '#41b7f1'});
			});


			// Chosen
			$(".pi-js_chosen").chosen();
          	$("#pi_blog_type").change(function()
          	{
          		var $getVal = $(this).find("option:selected").val();
          		if ( 'custom' == $getVal )
          		{
          			$("#pi_custom_latest_post").show();
          		}else{
          			$("#pi_custom_latest_post").hide();
          		}
          	}).trigger("change");
			// if (init.markedAsSwitched()) {}

			/*add new section*/
			var oListSection = {};
			var $i = 0;
			$("#pi-sortable li").each(function()
			{
				oListSection[($(this).data("sectioname").toLowerCase() ).replace(/\s+/g,"_")] = $i;
				$i++;
			});
			
			$(".pi-addnew-section").click(function()
			{
				var $sectionName = $("#pi_section_id").val();
					$sectionName = $sectionName.trim();
				var $toLowwer    = $sectionName.toLowerCase();
					$toLowwer	 = $toLowwer.replace(/\s+/g,"_");
				
				if ( typeof $(this).attr("data-refresh") != 'undefined' && $(this).attr("data-refresh") == 1 )
				{
					$("#pi-sortable li").each(function()
					{
						oListSection[($(this).data("sectioname").toLowerCase() ).replace(/\s+/g,"_")] = $i;
						$i++;
					});
				}



				if ( $sectionName == '' )
				{
					alert("Oop! Please fill section name");
				}else{
					if ( typeof oListSection[$toLowwer] != 'undefined'  )
					{
						alert("The section " + $sectionName + " is already exist! Please enter another name" );
					}else{
						$(this).attr("data-refresh", 1);

						$.ajax(
						{
							url: ajaxurl,
							type: "POST",
							data: {action: 'pi_add_new_section', section_name:$sectionName, section_key: $toLowwer},
							success: function(res)
							{
								// if ( $(".pi_color_picker").length>0 )
								// {
								// 	$(".pi_color_picker").spc();
								// }
								$("#pi-sortable").append(res);
								$("#pi-sortable").sortable("refresh");
								var $currentVal = $(".section-order").val();
									$currentVal += "," + $toLowwer;
									$(".section-order").val($currentVal);
								var $windowHeight = $(window).height();
								$(window).scrollTop($windowHeight);
								$(".pi-wrapsection.latest .pi_color_picker").spectrum({showAlpha: true, preferredFormat: "rgb"});
								$(".pi-wrapsection").removeClass("latest");
							}
						})

						
					}
				}
				return false;
			})

			$(".select_header_type").change(function()
			{	
				var headerType = $(this).find("option:selected").val();
				$(".header-settings").fadeOut();
				$(this).closest(".panel-body").find("."+headerType).fadeIn("slow");
			}).trigger("change");
	

			function pi_new_section($sectionName, $sectionKey)
			{
				var $section = "";
				$section += '<li  data-name="'+$sectionKey+'" data-sectioname="'+$sectionName+'" ><span class="pi-list-section ui-icon ui-icon-arrowthick"></span><span class="pi-toggle-settings-zone dashicons dashicons-welcome-write-blog pi-absolute pi-right"></span>'+'<h3 class="pi-section-name">'+$sectionName+'</h3>';
					$section += '<div class="wrap-custom-section-settings hidden">';
						$section += '<input type="text" name="theme_options[pi_custom_section]['+$sectionKey+'][name]" value="'+$sectionName+'">';
						$section += '<input type="text" name="theme_options[pi_custom_section]['+$sectionKey+']["name"]" value="'+$sectionName+'">';
					  	$section+= '<div class="panel-body">';
		                     $section+= '<div class="form-group">';
		                        $section+= '<div class="slider controls">';
		                            $section+= '<input type="checkbox" id="enable-'+$sectionKey+'" name="theme_options[pi_custom_section]['+$sectionKey+'][enable]" value="1" checked>';
		                            $section+= '<label for="enable-'+$sectionKey+'">Enable Section</label>';
		                        $section+= '</div>';
		                    $section+= '</div>';
		                $section+= '</div>';

						$section+= '<div class="form-group">';
							$section += '<label>Title</label>';
							$section += '<div class="controls">';
				       	 		$section += '<input type="text" name="theme_options[pi_custom_section]['+$sectionKey+'][title]" value="">';
				       	 	$section += '</div>';
					    $section += '</div>';

						$section+= '<div class="form-group">';
							$section += '<label>Description</label>';
							$section += '<div class="controls">';
				       	 		$section += '<textarea  name="theme_options[pi_custom_section]['+$sectionKey+'][description]"></textarea>';
				       	 	$section += '</div>';
					    $section += '</div>';

						$section+= '<div class="form-group">';
							$section += '<label>Content</label>';
							$section += '<div class="controls hidden pi_custom_section_content">';
				       	 		$section += '<textarea name="theme_options[pi_custom_section]['+$sectionKey+'][content]"></textarea>';
				       	 	$section += '</div>';
				       	 	$section += '<input type="submit" class="pi-edit-content btn btn-red" value="Edit content">';
					    $section += '</div>';

				     	$section += '<div class="form-control">';
		                    $section += '<select name="theme_options[pi_custom_section]['+$sectionKey+'][background]" class="wo-logo-type">';
		                        $section += '<option value="image">Background image</option>';	
		                        $section += '<option value="color">Background Color</option>';	
		                        $section += '<option value="none">None</option>';	
		                    $section += '</select>';
		                $section += '</div>';

		                $section += '<div class="form-group  pi-background pi-image">';	
		                    $section += '<div class="image-wrap wrap-logo">';	
		                        
		                    $section += '</div>';	
		                    $section += '<br>';	
		                    $section += '<button class="btn btn-white button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap">Get image</button>';	
		                    $section += '<input class="insertlink" type="hidden" value="" name="theme_options[pi_custom_section]['+$sectionKey+'][image_bg]">';	
		                $section += '</div>';	

		                $section += '<div class="form-group  pi-background pi-color">';	
		                    $section += '<input class="pi_color_picker" type="text" value="" name="theme_options[pi_custom_section]['+$sectionKey+'][color_bg]">';	
		                $section += '</div>';	

					    $section += '<div class="form-group">';
					        $section += '<button class="pi-remove-customsection">Remove</button>';
					    $section += '</div>';
					$section += '</div>';
				$section += '</li>';

				return $section;
			}

			$("#pi-sortable").on("click", ".pi-toggle-settings-zone", function(event)
			{
				event.preventDefault();
				$(this).siblings(".wrap-custom-section-settings").toggleClass("hidden");
			})

			$("#pi-sortable").on("click", ".pi-edit-content", function(event)
			{
				event.preventDefault();
				$("#pi_popup").removeClass("hidden");
				var $getContent = $(this).siblings(".pi_custom_section_content").find("textarea").val();
				tinyMCE.get('pi_add_new_section').setContent($getContent);
				$(this).addClass("current");
			})

			$(".pi-popup-close").click(function()
			{
				pi_close_wp_editor();
				return false;
			})

			$(".pi-popup-save").click(function()
			{
				var $getContent = tinyMCE.get('pi_add_new_section').getContent();
				$(".pi-edit-content.current").siblings(".pi_custom_section_content").find("textarea").val($getContent);
				pi_close_wp_editor();
			})

			$("#pi-sortable").on("click", ".pi-remove-customsection", function(event)
			{
				event.preventDefault();
				var $that = $(this);
				var $key =  $(this).data("key");
				var areusure = confirm("Click Oke to move, cancel to leave");
				

				if ( areusure === true )
				{
					var $currentOrder = $(".section-order").val();
					var $convertToarray =  $currentOrder.split(",");
					var $getIndex = $convertToarray.indexOf($key);	
					$convertToarray.splice($getIndex, 1);
					$currentOrder = $convertToarray.join(",");
					$that.closest(".pi-wrapsection").remove();
					$(".section-order").val($currentOrder);
				
					$.ajax(
					{
						url: ajaxurl,
						type: "POST",
						data: {action: "remove_custom_section", section_id: $key},
						success: function(res)
						{
							
						}
					})
				}
			})

			function pi_close_wp_editor()
			{
				$("#pi_popup").addClass("hidden");
				$(".pi-edit-content").removeClass("current");
			}
	})	
})(jQuery);	