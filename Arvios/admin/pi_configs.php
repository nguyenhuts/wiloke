<?php

$piaConfigs = array
(
	'admin'=>array
			(
				'script'=>array
						(
							 
						),
				'post_type'=>array
							(
								'aboutus'=>array('photo'=>'', 'name'=>'', 'position'=>'', 'intro'=>'', 'resume_cv')
							) 
			),
	'widgets' => array(  
		'pi-sidebar' => array
		(
				
			'search' => array 
			(
				0, 
				array('title'=>'Search...'),
			),

			'categories'  => array
			( 
				0,
				array('title'=>'Categories')
			),

			'recent-posts' => array
			(
				0, 
				array('title'=>'Recent Posts', 'number'=>6)
			),

			'calendar'	=> array
			(
				0, 
				array('title'=>'Calendar')
			),

			'tag_cloud'	=> array
			(
				0,
				array('title'=>'Tag Cloud', 'taxonomy'=>'post_tag')
			),

			'te_flickr_feed' => array
			(
				0,
				array('title'=>'Flickr', 'flickr_id'=>'7520746@N06', 'number_of_photo'=>6)
			),
			
			'text'		=> array
			( 
				0,
				array('text'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ')
			)
 
		)
	),
	'sections' => array(
	 	'aboutus', 'services', 'funfacts', 'idea', 'team', 'skills', 'portfolio', 'clients', 'testimonials', 'pricing', 'twitter',  'blog', 'contact'
	),
	'sections_name'=>array(
		'About', 'Services', 'Fun Facts', 'Idea', 'Team', 'Skills', 'Portfolio',  'Clients', 'Testimonials', 'Pricing Table', 'Twitter', 'Blog', 'Contact Us'
	),
	'options' => array 
	(
		'filename' 		=> 'arvios-options.php',
		'keyoptions'    => 'pi_save_theme_options'
	),
	'menus'   => array(
		'menu_id' 	=> 'arvios_menu',
		'menu_name'	=> 'Arvios'
	),
	'posts_id' => array
	(
		'pi_about'=>48,
		'pi_experience'=>45,	
	),
	'sidebar' => array("r-sidebar" => "Right sidebar", "l-sidebar"=>"Left sidebar", "no-sidebar"=>"No sidebar"),
	'custom_color'=>'custom.css',
	'custom_main' => 'yellow.css',
	'theme_options'=>array(
		'preload'=>array(
			'enable'=>1
		),
		'logo'=>array(
			'enable'=>1
		),
		'header'=>array(
			'enable'=>1,
			'title'=>'We are Wiloke',
			'description'	=>'Our clients succeed online  Say hello to Wiloke',
			'type'=>'image_fixed'
		),
		'text_slider'=>array(
			'title'=>array('Who We Are', 'Our Clients'),
			'description'=>array('We are young team, We are ambitious, growing fast and commited to proving the best services!', 'We\'ve worked with some of the biggest brands on the planet. Are you next?')
		),
		'aboutus'	=>array(
			'enable'=>1,
			'title'=>'WELCOME TO ARVIOS',
			'description'=>'With clients all over the world and expertise in everything digital,  we are ambitious, growing fast and committed to providing the best digital services.'
		),
		'services'=>array(
			'enable'=>1,
			'title'=>'SERVICES',
			'description'=>'We create digital content that enhances your business,and benefits your customers.  From idea to execution,we love doing things better.'
		),
		'funfacts'=>array(
			'enable'=>1,
			'title'=>'FUNFACTS',
			'description'=>'We do best our job for you',
			'background'=>'image',
			'parallax'=>1,
			'bg_img'=>'http://placehold.it/2000x300&text=image',
			'overlay'=>1,
			'overlay_color'=>'rgba(0, 0, 0, 0.45)'
		),
		'idea'=>array(
			'enable'=>1,
			'title'=>'DO YOU HAVE AN IDEAS ?',
			'description'=>'Mauris luctus aliquet nunc quis consectetur. Curabitur elit massa, consequat vel velit sit amet, scelerisque hendrerit mi.',
			'label'=>'Contact Us',
			'link'=>'#contact',
			'background'=>'color'
		),
		'team'=>array(
			'enable'=>1,
			'title'=>'TEAM',
			'description'=>'We are a multidisciplinary team of developers, designers, strategists and marketing specialists.'
		),
		'skills'=>array(
			'enable'=>1,
			'title'=>'OUR SKILLS',
			'description'=>'Take a look our experience',
			'background'=>'image',
			'parallax'=>1,
			'bg_img'=>'http://placehold.it/2000x750&text=image',
			'overlay'=>1,
			'overlay_color'=>'rgba(0, 0, 0, 0.45)'
		),
		'portfolio'=>array(
			'enable'=>1,
			'title'=>'RECENT WORK',
			'description'=>'With clients all over the world and a passion  for everything digital, our work speaks for itself.'
		),
		'clients'=>array(
			'enable'=>1,
			'title'=>'OUR CLIENTS',
			'description'=>'We proud that we work with this company\'s'
		),
		'testimonials'=>array(
			'enable'=>1,
			'title'=>'',
			'description'=>'',
			'bg_img'=>'http://placehold.it/2000x1600&text=image',
			'parallax'=>1,
			'overlay'=>1,
			'overlay_color'=>'rgba(0, 0, 0, 0.45)'
		),
		'twitter'=>array(
			'enable'=>1,
			'title'=>'',
			'description'=>'',
			'bg_img'=>'http://placehold.it/2000x1600&text=image',
			'overlay'=>1,
			'parallax'=>1,
			'overlay_color'=>'rgba(0, 0, 0, 0.45)',
			'access_token_secret'=>'',
			'username'=>'evanto',
			'number_of_tweets'=>5,
			'consumer_key'=>'0LWTFNByJZaTluXiXr0gFXOie',
			'consumer_secret'=>'0bddapcL4fua1LS1hIR7nSspSz8EoaPEVdxhZPzXIBbYWKQ22t',
			'access_token'=>'391151360-iInJmu2ZAegI9vdO4o28i8le0gwAFrSep1d3MTzb',
			'access_token_secret'=>'5iSxoyb4Ep5W9Bexqkdu0wI4zaoiLuqGJOexCXnx3REJT'
		),
		'pricing'=>array(
			'enable'=>1,
			'title'=>'PRICING',
			'description'=>'An eye for detail makes our works excellent'
		),
		'blog'=>array(
			'enable'=>1,
			'title'=>'OUR LATEST NEWS',
			'description'=>'Our latest news and interesting stuff for you.',
			'content'=>7,
		),
		'contact'=>array(
			'enable'=>1,
			'title'=>'CONTACT US',
			'description'=>'We’d love to hear from you!  Send us a message using the form below',
			'enablegooglemap'=>1,
			'googlemap'=>array('latitude'=>'21.542861', 'longitude'=>'105.647118', 'type'=>'ROADMAP'),
			'contact_detail'=>1,
			'contact_detail_title'=>'Contact Info',
			'info'=>array('+0000 987654321', '121 King Street, Melbourne Victoria 3000 Australia', '<a mailto="arvios@info.com">arvios@info.com</a>'),
			'info_icon'=>array('fa fa-mobile', 'fa fa-map-marker', 'fa fa-envelope')
		),
		'footer'=>array(
			'social_link'=>array('#', '#', '#'),
			'social_icon'=>array('fa fa-facebook', 'fa fa-twitter', 'fa fa-dribbble', 'fa fa-youtube'),
			'copyright'=>'© WE ARE ARVIOS. ALL RIGHTS RESERVED'
		),
		'posts_settings'=>array(
			'enable'=>1,
			'background'=>'http://placehold.it/2000x400&text=image'
		)
		
	)
);