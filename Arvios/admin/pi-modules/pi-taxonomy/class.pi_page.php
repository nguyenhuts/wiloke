<?php

class piPage extends piCore
{
 
	public function __construct()
	{
		add_action('save_post', array($this, 'pi_save_data'));
		add_action('add_meta_boxes', array($this, 'pi_create_settings'));
		add_action('admin_enqueue_scripts', array($this, 'pi_enqueue_scripts'));
	}


	public function pi_save_data($postID)
	{
		if (!current_user_can('edit_post', $postID) ) return;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if ( !isset($_POST['post_type']) || empty($_POST['post_type']) ) return;
        
        
        if  ( $_POST['post_type'] == 'page' ) :
	    	$data = isset($_POST['post_settings']) ? $_POST['post_settings'] : array();
	    	$data = $this->pi_unslashed_before_update($data);
	    	

	    	$showPosts = isset($data['portfolio_item_per_page']) && !empty($data['portfolio_item_per_page']) ? $data['portfolio_item_per_page'] : 8;
    		update_option('show_portfolio_'.$postID, $showPosts);

    		$style = isset($data['portfolio_style']) && !empty($data['portfolio_style']) ? $data['portfolio_style'] : 'style1';
    		update_option('portfolio_style_'.$postID, $style);
    		
    		update_post_meta($postID, "_post_settings", $data);
	    endif;
	} 

	public function pi_enqueue_scripts()
	{
		global $typenow;

		if ($typenow == 'page')
		{
			$url = get_template_directory_uri() . '/admin/pi-assets/';		
			wp_register_script('pi_page', $url . 'js/pi.page.js', array(), piCore::VERSION, true);
			wp_enqueue_script('pi_page');
		}
	}


	public function pi_create_settings()
	{
		add_meta_box(
			'pi-custom-post-settings',
			__('Page Settings', 'wiloke'),
			array($this, 'pi_setting_builder'),
			'page',
			'normal',
			'default'
		);

	}

}