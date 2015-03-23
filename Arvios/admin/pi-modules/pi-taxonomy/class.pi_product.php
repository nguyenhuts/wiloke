<?php

class piProduct extends piCore
{
 
	public function __construct()
	{
		add_action('admin_enqueue_scripts', array($this, 'pi_enqueue_scripts'));
		add_action('save_post', array($this, 'pi_save_data'));
		add_action('add_meta_boxes', array($this, 'pi_create_settings'));
	}


	public function pi_save_data($postID)
	{
		if (!current_user_can('edit_post', $postID) ) return;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if ( !isset($_POST['post_type']) || empty($_POST['post_type']) ) return;

	    if ( $_POST['post_type'] == 'product' ) :
	    	$data = isset($_POST['post_settings']) ? $_POST['post_settings'] : array();
	    	$data = $this->pi_unslashed_before_update($data);
	    	update_post_meta($postID, "_post_settings", $data);
	    endif;
	} 

	public function pi_enqueue_scripts()
	{
		global $typenow;

		if ($typenow == 'product')
		{
			$url = get_template_directory_uri() . '/admin/pi-assets/';
			wp_register_style('pi_plugin_fa', $url . 'css/font-awesome.min.css', array(), '4.0.2');
			wp_enqueue_style('pi_plugin_fa');
			
			wp_register_style('pi_form_style', $url . 'css/pi.form-style.css', array(), piCore::VERSION);
			wp_enqueue_style('pi_form_style');

			wp_register_style('pi_post_style', $url . 'css/pi.post.css', array(), piCore::VERSION);
			wp_enqueue_style('pi_post_style');

			wp_register_script('pi_posts', $url . 'js/pi.posts.js', array(), piCore::VERSION, true);
			wp_enqueue_script('pi_posts');

		}
	}

	public function pi_create_settings()
	{
		add_meta_box(
			'pi-custom-product-settings',
			__('Settings', piCore::LANG),
			array($this, 'pi_setting_builder'),
			'product',
			'normal',
			'default'
		);
	}
	
}