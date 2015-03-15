<?php

/*
Created by pirateS 
Data: 11/09/2014
copyright: wiloke themes
*/

class piFilters extends piCore
{
	public function __construct()
	{
		add_filter('pi_post_formats_icon', array($this, 'pi_post_format_icon'));
	}

	/** 
	 * Fontawesome based post format icon
	 */
	public function pi_post_format_icon() 
	{
		$icon = "";
		switch (get_post_format())  
		{
			case 'image':
				$icon = 'fa fa-picture-o';
				break;

			case 'gallery':
				$icon = 'fa fa-picture-o';
				break;
			
			case 'video';
				$icon = 'fa fa-youtube-play';
				break;
				
			case 'audio':
				$icon = 'fa fa-microphone';
				break;
			
			case 'quote': 
				$icon = 'fa fa-quote-left';
				break;

			case 'chat':
				$icon = 'fa fa-wechat';
				break;

			case 'aside':
				$icon = 'fa fa-file-text-o';
				break;

			case 'status':
				$icon = 'fa fa-tint';
				break;

			case 'link':
				$icon = 'fa fa-link';
				break;

			default:
				$icon = '';
			break;
		}	
		
		if ( !empty($icon) )
		{
			return '<i class="' . $icon .'"></i>';
		}else{
			return '';
		}
	}
}