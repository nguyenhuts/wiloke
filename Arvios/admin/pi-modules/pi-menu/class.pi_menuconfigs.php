<?php

class piMenuBoxes extends piCore
{
	public $blogId = "";

	public function __construct()
	{
	    /*
	     * @get blog id
	     */
		add_action('init', array($this, 'pi_register_nav_menu'));
		add_action('admin_head', array($this, 'add_nav_menu_meta_boxes'));
		
	}



	public function pi_register_nav_menu()
	{
		$key = parent::$piaConfigs['menus']['menu_id'];
		$name = parent::$piaConfigs['menus']['menu_name'];
		register_nav_menus( array($key => $name) );
	}

	public function add_nav_menu_meta_boxes()
	{
		add_meta_box(piCore::$menuSlug.'-box-id', parent::$piaConfigs['menus']['menu_name'], array($this, 'pi_menu_box_builder'), 'nav-menus', 'side', 'high');
	}

	public function pi_menu_box_builder()
	{
		include (dirname(__FILE__) . '/tpl.pi_menubuilder.php');
	}


}
