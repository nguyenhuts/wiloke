<?php

if ( !class_exists('piCore') ) 
{
	class piCore
	{	 
		const LANG = 'wiloke';   
		const VERSION = '1.0';
		// const pi_ADMIN_ 
		public static $piaConfigs;
		public static $menuSlug = 'arvios-menu'; // of theme options

		private $_piaEnableModules = array("posts"=>1, "page"=>1, "avatar"=>1);
 
		public function __construct($piaConfigs)
		{
			self::$piaConfigs = $piaConfigs; 
			   
			add_action('admin_enqueue_scripts', array($this, "pi_admin_enqueue_scripts"));
			$this->pi_modules_init();
			add_action('wp_ajax_hello_ajax', array($this, "pi_ajax_machine"));
			add_action('wp_enqueue_scripts', array($this, "pi_enqueue_scripts"));	
			add_action('admin_footer', array($this, 'pi_include_fontawesome')); 
			add_action('admin_init', array($this, 'pi_set_blog_page'));
			add_filter('pi_is_section_enable', array($this,'pi_is_section_enable'), 20, 1);
			add_filter('pi_the_heading', array($this,'pi_the_heading'), 10, 2);
			add_filter('pi_the_description', array($this,'pi_the_description'), 10, 2);
			add_filter('pi_get_data', array($this,'pi_get_data'), 10, 1);
			add_filter('pi_get_cat', array($this, 'pi_get_cat'), 10, 1);
			add_filter('pi_get_contactform', array($this, 'pi_get_contactform'), 10, 1);

			add_action('wp_ajax_handle_tweet', array($this, 'pi_handle_tweet'));
			add_action('wp_ajax_nopriv_handle_tweet', array($this, 'pi_handle_tweet'));
			add_action('wp_ajax_remove_custom_section', array($this, 'pi_remove_custom_section'));

			add_action('save_post', array($this, 'pi_re_update_theme_options'), 100);
		}  
 		// page_template	 

		public function pi_set_blog_page()
		{
			$getPages =  get_pages( array('post_type'=>'page') );
				
			$hasPageTemplate = get_option("_pi_page_id") ;
			$hasPortfolio    = get_option("_pi_portfolio_id");

			if ( $hasPageTemplate )
			{
				if ( !get_permalink($hasPageTemplate) )
				{
					$hasPageTemplate = false;
				}
			}

			if ( $hasPortfolio )
			{
				if ( !get_permalink($hasPortfolio) )
				{
					$hasPortfolio = false;
				}
			}

			if ( $getPages )
			{
				foreach ( $getPages as $page ) : setup_postdata($page);
					$templatePage =  get_post_meta( $page->ID, '_wp_page_template', true );
					if (  $templatePage  )
					{
						if ( !$hasPageTemplate && $templatePage == 'blog-listing.php')
						{
							$hasPageTemplate = true;
							update_option("_pi_page_id", $page->ID);
						}

						if ( !$hasPortfolio && $templatePage == 'portfolio.php' )
						{
							$hasPortfolio = true;
							update_option("_pi_portfolio_id", $page->ID);
						}
						

						if ( $hasPortfolio && $hasPageTemplate )
						{
							break;
						}
					}
				endforeach;wp_reset_postdata();
			}

			if ( !$hasPageTemplate )
			{
				$reId = wp_insert_post( array('ID'=>'', 'post_name'=>'', 'post_title'=>'Blog - Listing', 'post_type'=>'page', 'page_template'=>'blog-listing.php', 'post_status'=>'publish') );
				update_option('_pi_page_id', $reId);
			}

			if ( !$hasPortfolio  )
			{
				$reId = wp_insert_post( array('ID'=>'', 'post_name'=>'', 'post_title'=>'Portfolio', 'post_type'=>'page', 'page_template'=>'portfolio.php', 'post_status'=>'publish') );
				update_option('_pi_portfolio_id', $reId);
			}
		}

		public function pi_is_ie9()
		{
			if(preg_match('/(?i)msie [1-9]/',$_SERVER['HTTP_USER_AGENT']))
			{
			   return true;
			}
			return false;
		}

		public function pi_include_fontawesome()
		{
			global $typenow;
			
			if ( $typenow == 'pi_expertise' || $typenow == 'pi_services' || $typenow == 'pi_funfacts')
			{
				include ( get_template_directory() . '/admin/pi-modules/table-fa.php' );
			}
		}
 		
		/**
		 * Get shortcode of contact form 7
		 */
		public function pi_get_contactform($id)
		{
			$getID = false;
			if ( has_action('customize_controls_init') )
			{
				if ( isset($_POST['customized']) )
				{
					$parseData = json_decode(wp_unslash( $_POST['customized'] ), true);
					$getID     = isset($parseData['pi_save_theme_options[theme_options][contact][contactform7_shortcode]']) && !empty($parseData['pi_save_theme_options[theme_options][contact][contactform7_shortcode]']) ? $parseData['pi_save_theme_options[theme_options][contact][contactform7_shortcode]'] : false;
					if ( !$getID )
					{
						$getID     		= isset(piThemeOptions::$piOptions['contact']['contactform7_shortcode']) && !empty(piThemeOptions::$piOptions['contact']['contactform7_shortcode'])  ? piThemeOptions::$piOptions['contact']['contactform7_shortcode'] : false;
					}
				}
			}else{
					$getID     		= isset(piThemeOptions::$piOptions['contact']['contactform7_shortcode']) && !empty(piThemeOptions::$piOptions['contact']['contactform7_shortcode'])  ? piThemeOptions::$piOptions['contact']['contactform7_shortcode'] : false;
			}

			if ( $getID )
			{
			  	echo do_shortcode(sprintf( '[contact-form-7 id="%1$d"]', $getID )); 
			}else{
				echo "<h3 class='h3'>[To use contact form, you need Contact form 7 installed. If Contact form 7 is already, please go to Contact (from admin sidebar) and then create  contact form]</h3>";
			}
		}

		/*
		*--------------------------
			Get cat
		*--------------------------
		*/ 
		public function pi_get_cat($cat)
		{	
			$taxonomies = array($cat);
			$terms 		= get_terms($taxonomies);

			return $terms;
		}


		/*
		*--------------------------
			Check get data
		*--------------------------
		*/ 
		public function pi_get_data($section)
		{
			
			if ( $this->pi_check_data($section) )
			{
				$getID  = $this->pi_check_data($section);
			}else{
				$getID     = isset(piThemeOptions::$piOptions[$section]['content']) && !empty(piThemeOptions::$piOptions[$section]['content']) ? piThemeOptions::$piOptions[$section]['content'] : false;
			}

			return $getID;
		}

		public function pi_check_data($target="")
		{
		    if ( has_action('customize_controls_init') )
		    {
		        if ( isset($_POST['customized']) )
		        {   
		            $_POST['customized'] = $this->escapeJsonString(stripslashes($_POST['customized']));

		            $aParse = json_decode($_POST['customized'], true);

		            if ( !$aParse )
		            {
		                $aParse = json_decode( stripslashes($_POST['customized']), true);
		            }


		            if ( isset($aParse["$target"]) && !empty($aParse["$target"]) )
		            {
		                return $this->convertToString($aParse["$target"]);
		            }

		            return false;
		        }

		        return false;
		    }

		    return false;
		}

		public function escapeJsonString($json) 
		{ 
		    $search = array('\\',"\n","\r","\f","\t","\b","'") ;
		    $replace = array('\\\\',"\\n", "\\r","\\f","\\t","\\b", "&#039");
		    $json = str_replace($search,$replace,$json);
		    return $json;
		}

		public function convertToString($string)
		{
		    $replace = array('\\',"\n","\r","\f","\t","\b","'") ;
		    $search = array('\\\\',"\\n", "\\r","\\f","\\t","\\b", "&#039");
		    $string = str_replace($search,$replace,$string);
		    return $string;
		}

 		/*
		*--------------------------
			Check enable section
		*--------------------------
		*/
		public function pi_is_section_enable($section)
		{
			if ( has_action('customize_controls_init') ) return true;

			if ( isset(piThemeOptions::$piOptions[$section]['enable']) && !empty(piThemeOptions::$piOptions[$section]['enable']) )
			{
				return true;
			}else{
				return false;
			}
		}

		/*
		*--------------------------
			The heading
		*--------------------------
		*/
		public function pi_the_heading($section, $addClass="")
		{
			$title = "";

			if ( isset(piThemeOptions::$piOptions[$section]['title']) && !empty(piThemeOptions::$piOptions[$section]['title']) )
			{
				$title = piThemeOptions::$piOptions[$section]['title'];
			}
 
			if ( !empty($title) || ( empty($title) && has_action('customize_controls_init') ) )
			{
				printf( __( ('<h3 class="h3 %s">%s</h3>'), piCore::LANG), $addClass, wp_unslash($title) );
			}
		}

		/*
		*--------------------------
			The description
		*--------------------------
		*/
		public function pi_the_description($section, $addClass="")
		{
			$pidescription ="";

			if ( isset(piThemeOptions::$piOptions[$section]['description']) && !empty(piThemeOptions::$piOptions[$section]['description']) )
			{
				$pidescription = piThemeOptions::$piOptions[$section]['description'];
			}

			if ( !empty($pidescription) || ( empty($pidescription) && has_action('customize_controls_init') ) )
			{
				printf( __( ('<p class="sub-title %s">%s</p><i class="fa fa-bookmark-o"></i>'), piCore::LANG), $addClass, wp_unslash($pidescription) );	
			}else{
				echo '<i class="fa fa-bookmark-o"></i>';
			}
		}

		/*
		*--------------------------
			Get terms
		*--------------------------
		*/
		public static function pi_get_terms($taxName)
		{
			$piTerms = get_terms( $taxName);
			
			$aId = array();

			if ( !empty( $piTerms ) && !is_wp_error( $piTerms ) )
			{
				foreach ($piTerms as $data)
				{
					$aId[$data->name] = $data->term_id;
				}
			}

			return $aId;
		}

		public function pi_enqueue_scripts()
		{
			$piIsStaticPage = pi_is_static_page();
			
			$url = get_template_directory_uri() . '/assets/';
			
			wp_register_style('arvios_boostrap_plugin', $url . 'css/lib/bootstrap.min.css', array(), '3.0.2');
			wp_register_style('arvios_fa_plugin', get_template_directory_uri() . '/admin/pi-assets/css/font-awesome.min.css', array(), '4.0.2');
			wp_register_style('arvios_owl_carousel', $url . 'css/lib/owl.carousel.css', array(), '3.0.2');
			wp_register_style('arvios_googlefont_raleway', '//fonts.googleapis.com/css?family=Raleway:400,600,700,900', array(), self::VERSION);
			wp_register_style('arvios_googlefont_montserrat', 'http://fonts.googleapis.com/css?family=Montserrat:400,700', array(), '1.0');
			wp_register_style('arvios_transitions', $url . 'css/lib/owl.transitions.css', array(), '0.9.9', true);
			
			wp_enqueue_style('arvios_boostrap_plugin');
			
			wp_enqueue_style('arvios_fa_plugin');	
			wp_enqueue_style('arvios_owl_carousel');
			wp_enqueue_script('arvios_transitions');
			wp_enqueue_style('arvios_googlefont_raleway');	
			wp_enqueue_style('arvios_googlefont_montserrat');
		
			
    		if ( is_404() )
    		{
    			wp_register_style('arvios_404', $url . 'css/404.css', array(), '1.0');
    			wp_enqueue_style('arvios_404');
    		}

    		if ( is_page_template("masonry-layout.php") )
    		{
    			wp_register_style('arvios_masonry', $url . 'css/masonry-layout.css', array(), '1.0');
    			wp_enqueue_style('arvios_masonry');
    		}
			
				
			$min = SCRIPT_DEBUG ? ".min" : "";
			
			wp_register_script('arvios_twitter', $url . 'js/lib/tweetie.js', array(), '1.0', true);
			wp_register_script('arvios_extend_infinite_scroll', $url . 'js/infinite-scroll.js', array(), '1.0', true);
			wp_register_script('arvios_bootstrap', $url . 'js/lib/bootstrap.min.js', array(), '3.0.2', true);
			wp_register_script('arvios_isotope', $url . 'js/lib/isotope.pkgd.min.js', array(), '1.0', true);
			wp_register_script('arvios_easing', $url . 'js/lib/jquery.easing.min.js', array(), '1.0', true);
			wp_register_script('arvios_ytplayer', $url . 'js/lib/jquery.mb.YTPlayer.js', array(), '1.0', true);
			wp_register_script('arvios_owl_carousel', $url . 'js/lib/jquery.owl.carousel.min.js', array(), '1.0', true);
			wp_register_script('arvios_parallax', $url . 'js/lib/jquery.parallax-1.1.3.min.js', array(), '1.0', true);
			wp_register_script('arvios_superslides', $url . 'js/lib/jquery.superslides.min.js', array(), '1.0', true);
			wp_register_script('arvios_wow', $url . 'js/lib/jquery.wow.min.js', array(), '1.2', true);
			wp_register_script('arvios_retina', $url . 'js/lib/retina.min.js', array(), '1.0', true);
			wp_register_script('arvios_smoothscroll', $url . 'js/lib/SmoothScroll.js', array(), '3.0.2', true);
			wp_register_script('arvios_infinitescroll', $url . 'js/lib/jquery.infinitescroll.min.js', array(), '0.9.9', true);
			wp_register_script('arvios_soundcloud', $url . 'js/lib/soundcloud.min.js', array(), '0.9.9', true);
			wp_register_script('arvios_scripts', $url . 'js/scripts'.$min.'.js', array(), '1.0', true);
			wp_register_script('arvios_imageloaded', $url . 'js/lib/imageloaded.js', array(), '1.0', true);
			wp_register_script('arvios_googlemap', $url . 'js/map'.$min.'.js', array(), '1.0', false);

			if( isset(piThemeOptions::$piOptions['contact']['enablegooglemap']) )
			{
				wp_enqueue_script('arvios_googlemap');
			}
			
			wp_enqueue_script('jquery');
			wp_enqueue_script('arvios_bootstrap');


			if ( $this->pi_is_ie9() )
			{
				wp_register_script('arvios_html5', $url . 'js/lib/html5.js', array(), '1.0');
				wp_register_script('arvios_css3-mediaqueries', $url . 'js/lib/css3-mediaqueries.js', array(), '1.0');
				wp_enqueue_script('arvios_html5'); 
				wp_enqueue_script('arvios_css3-mediaqueries');
			}
			
			if ( is_page_template('portfolio.php') || ( isset(piThemeOptions::$piOptions['portfolio']['button_type']) && piThemeOptions::$piOptions['portfolio']['button_type']=='loadmore' ) )
			{
				wp_enqueue_script('arvios_infinitescroll');
				wp_enqueue_script('arvios_extend_infinite_scroll');
			}

			
			if ( ( isset(piThemeOptions::$piOptions['header']['type']) && piThemeOptions::$piOptions['header']['type'] =='youtube_bg') || has_action('customize_controls_init') )
			{
				wp_enqueue_script('arvios_ytplayer');
			}
						
			if ( !is_page_template('homepage.php') )
			{
				wp_enqueue_script('arvios_soundcloud');
			}

			wp_enqueue_script('arvios_retina');
			wp_enqueue_script('arvios_imageloaded');
			wp_enqueue_script('arvios_twitter'); 
			wp_enqueue_script('arvios_isotope'); 
			wp_enqueue_script('jquery-masonry'); 
			wp_enqueue_script('arvios_easing');
			wp_enqueue_script('arvios_owl_carousel');
			wp_enqueue_script('arvios_superslides');
			wp_enqueue_script('arvios_parallax');
			wp_enqueue_script('arvios_smoothscroll');
			wp_enqueue_script('arvios_scripts');

			if( is_singular() && !is_page_template('homepage.php') ){
				wp_enqueue_script( "comment-reply" );
			} 
			
			wp_localize_script('arvios_scripts', 'WILOKE', array('ajaxurl'=>admin_url('admin-ajax.php')));
					
		    $lat  = isset(piThemeOptions::$piOptions['contact']['googlemap']['latitude']) && !empty(piThemeOptions::$piOptions['contact']['googlemap']['latitude']) ? piThemeOptions::$piOptions['contact']['googlemap']['latitude'] : '21.027764';
    		$long = isset(piThemeOptions::$piOptions['contact']['googlemap']['longitude']) && !empty(piThemeOptions::$piOptions['contact']['googlemap']['longitude']) ? piThemeOptions::$piOptions['contact']['googlemap']['longitude'] : '105.834160';
    		$type = isset(piThemeOptions::$piOptions['contact']['googlemap']['type']) && !empty(piThemeOptions::$piOptions['contact']['googlemap']['type']) ? piThemeOptions::$piOptions['contact']['googlemap']['type'] : 'ROADMAP';
    		$mapTheme  = isset(piThemeOptions::$piOptions['contact']['googlemap']['theme']) && !empty(piThemeOptions::$piOptions['contact']['googlemap']['theme']) ? piThemeOptions::$piOptions['contact']['googlemap']['theme'] : '';
    		
    		$googleMap = array('lat'=>$lat, 'long'=>$long, 'type'=>$type, 'theme'=>$mapTheme);
    		$username  = isset(piThemeOptions::$piOptions['twitter']['username']) ?  piThemeOptions::$piOptions['twitter']['username']  : 'evanto';
    		

    		wp_localize_script('jquery', 'WILOKE_GOOGLEMAP', $googleMap);

    		wp_localize_script('jquery', 'piAjaxUrl', admin_url('admin-ajax.php'));

    		wp_localize_script('jquery', 'piTwitterUsername', $username);
    		
    		wp_localize_script('jquery', 'piImgs', get_template_directory_uri() . '/admin/pi-assets/images/' );


    		if ( has_action('customize_preview_init') )
    		{
    			wp_localize_script('jquery', 'PI_CONFIG', json_encode(self::$piaConfigs['sections']));
    		}
		}


		/*
		*----------------------------
			Deep slashes
		*----------------------------
		*/
		public function pi_unslashed_before_update($data)
        {   
            $data = is_array($data) ? array_map(array($this,'pi_unslashed_before_update'), $data) : wp_unslash($data);
        	return $data;
        }


		/*
		*----------------------------
			Mr.Ajax
		*----------------------------
		*/
		public function pi_ajax_machine()
		{
			include ( PI_ADMIN_MD . 'pi.mr-ajax.php' );
		}


		/*
		*----------------------------
			Admin scripts
		*----------------------------
		*/
		public function pi_admin_enqueue_scripts()
		{
			global $typenow;

			
			$piUrl = get_template_directory_uri() . '/admin/pi-assets/';

			wp_dequeue_script('autosave');
			wp_enqueue_script('jquery');

			wp_register_style('pi_switchery', $piUrl . 'css/switchery.min.css', array(), '1.0');
			wp_enqueue_style('pi_switchery');

			wp_register_style('pi_plugin_datepicker', $piUrl . 'css/jquery-ui-1.10.4.css', array(), '1.10.4');

			wp_register_style('pi_spectrum', $piUrl . 'css/spectrum.css', array(), '1.0');
			wp_enqueue_style('pi_spectrum');
			// wp_register_script('pi_add_video', $piUrl . 'js/pi.add_video.js', array(), self::VERSION, true);

			wp_register_script('pi_switch_checkbox', $piUrl . 'js/switchery.min.js', array(), self::VERSION, true);
			wp_enqueue_script('pi_switch_checkbox');

			wp_register_style('pi_form_style', $piUrl . 'css/pi.form-style.css', array(), '1.0');
			
			wp_enqueue_script('jquery-ui-datepicker');

			wp_register_script('pi_spectrum', $piUrl . 'js/spectrum.js', array(), '1.0');
			wp_enqueue_script('pi_spectrum');
			wp_enqueue_script('jquery-form');
			wp_enqueue_media();
			wp_enqueue_script('media-upload');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('thickbox');


			wp_register_style('plugin_grid', $piUrl . 'css/grid.css', array(), self::VERSION);
			
			wp_enqueue_style('pi_popupstyle', $piUrl . 'css/pi.font-table.css', array(), self::VERSION); 
			wp_enqueue_style('pi_popupstyle');

			wp_enqueue_style('pi_tablefa', $piUrl . 'css/popup-style.css', array(), self::VERSION); 
			wp_enqueue_style('pi_tablefa');

			wp_register_script('pi_custom', $piUrl . 'js/pi.custom.js', array(), self::VERSION, true);
			wp_register_script('pi_blank', $piUrl . 'js/pi.blank.js', array(), self::VERSION, true);
			
			wp_register_script('pi_media_upload', $piUrl . 'js/pi.media_upload.js', array(), self::VERSION, true);

			wp_enqueue_script('pi_media_upload');	

			wp_enqueue_script('pi_blank');
			wp_enqueue_script('pi_custom');
			if ( $typenow != 'post' ) :
				wp_enqueue_style('plugin_grid');
				wp_enqueue_style('pi_form_style');
				wp_enqueue_style('pi_plugin_datepicker');
			endif;
		}


		public function pi_remove_custom_section()
		{
			$lang = 'en';
			if ( defined('ICL_LANGUAGE_CODE') )
			{
				$lang = ICL_LANGUAGE_CODE;
			}
			$aOption = get_option("pi_save_theme_options_".$lang);
			$aOption = $aOption['theme_options'];
			// $aCustomSection = get_option("pi_custom_section_id_".$lang);
			// $flip 			= array_flip($aCustomSection);
			$sectionOrder	= $aOption['section_builder'];
			$sectionOrder	= explode(",", $sectionOrder);
			$sectionOrder 	= array_flip($sectionOrder);
			$_POST['section_id'] = trim($_POST['section_id']);
			unset($sectionOrder[$_POST['section_id']]);
			$sectionOrder 	= array_flip($sectionOrder);
			$aOption['section_builder'] = implode(",", $sectionOrder);
			
			// unset($flip[$_POST['section_id']]);

			// update_option("pi_custom_section_id_".$lang, array_flip($flip));
			unset($aOption['pi_custom_section'][$_POST['section_id']]);
			$options['theme_options'] =  $aOption;
			update_option("pi_save_theme_options_".$lang, $options);
			wp_die();
		}

		public function pi_modules_init()
		{
			
			/*
			*---------------------------------
				Posts & Tax
			*---------------------------------
			*/
			$fileName = array("class.pi_post.php", "class.pi_page.php", "class.pi_avatar.php");

			foreach ($fileName as $file)
			{
				include (PI_ADMIN_MD . 'pi-taxonomy/' . $file);
			}
			

			/*=========================================*/
			/* Posts
			/*=========================================*/
			if ( $this->_piaEnableModules['posts'] == 1 ) :	
				$piPosts 		= new piPosts();
			endif;

			/*=========================================*/
			/* Page
			/*=========================================*/
			if ( $this->_piaEnableModules['page'] == 1 ) :	
				$piPage 		= new piPage();
			endif;


			/*=========================================*/
			/*	Avatar
			/*=========================================*/
			if ( $this->_piaEnableModules['avatar'] == 1 ) :	
				$piAvatar 	= new piAvatar();
			endif;

			

			/*
			*---------------------------------
				Theme Options
			*---------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-themeoptions/class.pi-themeoptions.php');
			$initThemeOptions = new piThemeOptions();


			/*
			*---------------------------------
				Import Demo data
			*--------------------------------- 
			*/
			include (PI_ADMIN_MD . 'pi-import-demo/class.pi-demo-builder.php');
			$initImportDemoMenu = new piImportDemoBuilder();

			/*
			*--------------------------------
				Register Sidebar
			*--------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-sidebar/func.pi-registersidebar.php');

			/*
			*---------------------------------
				Menu Configs
			*---------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-menu/class.pi_menuconfigs.php');
			$piMenuBoxes = new piMenuBoxes();

			/*
			*--------------------------------
				Update
			*--------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-update/class.update.php');
			$piUpdapi = new piUpdate();

			/*
			*--------------------------------
				Widgets Builder
			*--------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-widgets/class.widget-building.php');
			$piWidgets = new piWidgets();
		

			/*
			*-------------------------------
				Plugin Activation
			*-------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-plugin-activation/class.pi-pluginactivation.php');
			$piPluginActiovation = new piPluginActiovation();

			/*
			*-------------------------------
				Shortcodes
			*-------------------------------
			*/
			// include (PI_ADMIN_MD . 'pi-shortcodes/class.pi-shortcodes.php');
			// $piShortcodes = new piShortcodes();

			/*
			*-------------------------------
				Filters
			*-------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-filters/class.pi-filters.php');
			$piFilters = new piFilters();

			/*
			*-------------------------------
				Filters
			*-------------------------------
			*/
			include (PI_ADMIN_MD . 'pi-customize/class.customize.php');
			$piCustomize = new piCustomize();

			/*=========================================*/
			/*	Woocommerce
			/*=========================================*/
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active("woocommerce/woocommerce.php") )
			{
				include (PI_ADMIN_MD . 'pi-taxonomy/class.pi_product.php');
				$piProduct = new piProduct;
			}
		}


		/*Twitter*/
		public function pi_handle_tweet()
		{
		    $consumerKey 		= isset(piThemeOptions::$piOptions['twitter']['consumer_key']) ? piThemeOptions::$piOptions['twitter']['consumer_key']  : '';
		    $consumerSecret 	= isset(piThemeOptions::$piOptions['twitter']['consumer_secret']) ? piThemeOptions::$piOptions['twitter']['consumer_secret']  : '';
		    $accessToken 		= isset(piThemeOptions::$piOptions['twitter']['access_token']) ? piThemeOptions::$piOptions['twitter']['access_token']  : '';
		    $accessTokenSecret 	= isset(piThemeOptions::$piOptions['twitter']['access_token_secret']) ? piThemeOptions::$piOptions['twitter']['access_token_secret']  : '';

		    if ( empty($consumerKey) || empty($consumerKey) || empty($consumerKey) || empty($consumerKey) )
		    {
		    	echo json_encode(array("mes"=>"Please config twitter"));
		    }else{
				include ( 'pi-modules/pi-libs/twitter/tweet.php' );
				$aAPI = array("consumer_key"=>$consumerKey, "consumer_secret"=>$consumerSecret, "user_token"=>$accessToken, "user_secret"=>$accessTokenSecret);
				$ezTweet = new ezTweet($aAPI);
				
				$ezTweet->fetch();
			}
			die;
		}


		public function pi_setting_builder()
		{
			global $post;
			$type = $post->post_type;
			$aPost = get_post_meta($post->ID, "_post_settings", true);


			// $aPost = $aServices ? $aServices : $aDef['_pi_post_settings'];
			?>
			<tr class="table-row tab-item pi-parent">
	            <td>
					<?php 
						if ( $type == 'page' ) 
						{
							_e('Warning: Below options is not used if this page display to a <a href="http://codex.wordpress.org/Creating_a_Static_Front_Page" target="_blank">Front Page</a>', 'wiloke');
						}
					?>
	                <div class="pi-wrap-content">
	                    <div class="clearfix pi-group wo-flag">
	                        <div class="pi-label">
	                            <b><?php _e('Custom Header Background', 'wiloke') ?></b>
	                            <p>
	                            	<code><?php _e("This setting will overide the setting in Theme Options", "wiloke") ?></code>
	                            </p>
	                        </div>
	                        <div class="pi-wrapsettings">
	                            <input name="post_settings[enable_custom_background]" value="1" class="toggle-settings text-field" type="checkbox" <?php echo isset($aPost['enable_custom_background']) ? 'checked' : ''; ?>>
	                        </div>
	                    </div> 

	                    <div class="clearfix pi-group wo-flag">
	                        <div class="pi-label">
	                            <b><?php _e('Enabel Header Background', 'wiloke') ?></b>
	                        </div>
	                        <div class="pi-wrapsettings">
	                            <input name="post_settings[enable_header_background]" value="1" class="text-field" type="checkbox" <?php echo isset($aPost['enable_header_background']) ? 'checked' : ''; ?>>
	                        </div>
	                    </div> 

						<div class="clearfix pi-group"> 
		                    <div class="pi-label">
		                        <b><?php _e('Image Background', 'wiloke') ?></b>
		                    </div>
		                    <div class="pi-wrapsettings">
		                        <div class="form-avatar">
		                            <a class="upload-image js_upload" data-geturl="true" href="#" data-insertto=".lux-gallery" data-method="html" data-use="find">
		                                <div class="lux-gallery pi-aboutme is-border-none">
		                                    <img  src="<?php echo !empty($aPost['image_bg'])  ? esc_url($aPost['image_bg']) : get_template_directory_uri() . '/admin/pi-assets/images/background-image.gif'; ?>">
		                                </div>
		                            </a>
		                            <input type="hidden" value="<?php echo !empty($aPost['image_bg'])  ? esc_url($aPost['image_bg']) : get_template_directory_uri() . '/admin/pi-assets/images/background-image.gif'; ?>" name="post_settings[image_bg]">
		                            <?php if ( !empty($aPost['image_bg'] ) ) : ?>
		                            <button class="button pi-button button-primary js_remove_image siblings" data-placeholder="<?php echo get_template_directory_uri() . '/admin/pi-assets/images/background-image.gif'; ?>"><?php _e('Remove', 'wiloke'); ?></button>
		                            <?php endif; ?>
		                        </div>
		                    </div>
		                </div>

		                <div class="clearfix pi-group"> 
				            <div class="pi-label">
		                        <b><?php _e('Overlay Color', 'wiloke') ?></b>
		                    </div>
				            <div class="pi-wrapsettings">
				                <input type="text" class="form-control pi_color_picker" name="post_settings[overlay_color]" value="<?php echo isset($aPost['overlay_color']) ? esc_attr($aPost['overlay_color']) : 'rgba(0,0,0,0)';  ?>">
				            </div>
				        </div>

	                </div>

	                <div class="pi-wrap-content">
						<div class="clearfix pi-group">
							<div class="pi-label">
	                            <b><?php _e('Sidebar', 'wiloke') ?></b>
	                            <p>
	                            	<code><?php _e("This setting will overide the setting in Theme Options", "wiloke") ?></code>
	                            </p>
	                        </div>

							<div class="pi-wrapsettings">
								<select name="post_settings[sidebar]">
									<?php 
										$csidebar = isset($aPost['sidebar']) && !empty($aPost['sidebar']) ? $aPost['sidebar'] : 'default';

										self::$piaConfigs['sidebar'] = array_merge( array("default"=>"Default"), self::$piaConfigs['sidebar'] );
	                    				
										foreach ( self::$piaConfigs['sidebar']  as $sidebar => $name ) : 
											$selected = isset($csidebar) && $sidebar ==  $csidebar ? 'selected' : '';
									?>
										<option value="<?php echo $sidebar; ?>" <?php echo $selected; ?>><?php echo $name ?></option>
									<?php 
										endforeach;
									?>
								</select>
							</div>
						</div>
	                </div>
					
					<?php if ( $type !='product' ) : ?>
	                <div class="pi-wrap-content">
						<div class="clearfix pi-group">
							<div class="pi-label">
	                            <b><?php _e('Post Author', 'wiloke') ?></b>
	                            <p>
	                            	<code><?php _e("This setting will overide the setting in Theme Options", "wiloke") ?></code>
	                            </p>
	                        </div>

							<div class="pi-wrapsettings">
								<select name="post_settings[post_author]">
									<?php 
										$choosen = isset($aPost['post_author']) && !empty($aPost['post_author']) ? $aPost['post_author'] : 'default';

										$aChoices = array("default"=>"Default", "enable"=>"Enable", "disable"=>"Disable");
	                    				
										foreach ( $aChoices  as $option => $name ) : 
											$selected = isset($option) && $option ==  $choosen ? 'selected' : '';
									?>
										<option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $name ?></option>
									<?php 
										endforeach;
									?>
								</select>
							</div>
						</div>
	                </div>
	            	<?php endif; ?>

	                <?php 
	                	if ( $type == 'page' ) :
	                ?>
					<div id="pi-portfolio" class="pi-wrap-content">
						<div class="clearfix pi-group">
							<div class="pi-label">
	                            <b><?php _e('Show posts', 'wiloke') ?></b>
	                        </div>

							<div class="pi-wrapsettings">
								<input name="post_settings[portfolio_item_per_page]" type="text" value="<?php echo isset($aPost['portfolio_item_per_page']) ? esc_attr($aPost['portfolio_item_per_page']) : 8; ?>">
							</div>
						</div>
	                
	                	
						<div class="clearfix pi-group">
							<div class="pi-label">
	                            <b><?php _e('Style', 'wiloke') ?></b>
	                        </div>

							<div class="pi-wrapsettings">
								<select name="post_settings[portfolio_style]">
									<option value="style1" <?php echo isset($aPost['portfolio_style']) && $aPost['portfolio_style']=='style1' ? 'selected' : ''; ?>><?php _e('Full width - No padding', 'wiloke'); ?></option>
									<option value="style2"  <?php echo isset($aPost['portfolio_style']) && $aPost['portfolio_style']=='style2' ? 'selected' : ''; ?>><?php _e('Full width - Padding', 'wiloke'); ?></option>
									<option value="style4" <?php echo isset($aPost['portfolio_style']) && $aPost['portfolio_style']=='style4' ? 'selected' : ''; ?>><?php _e('Boxed - Padding', 'wiloke'); ?></option>
									<option value="style3" <?php echo isset($aPost['portfolio_style']) && $aPost['portfolio_style']=='style3' ? 'selected' : ''; ?>><?php _e('Boxed - No Padding', 'wiloke'); ?></option>
								</select>

							</div>
						</div>
	                </div>
	            	<?php 	
	            		endif;
	            	?>

	            </td>
	        </tr>
			<?php
		}

		static public function pi_contact_info($aContact, $button="")
		{
			$button = $button !='' ? $button : 'js_add_icon';
            if ( isset($aContact['info']) && !empty($aContact['info'])  ) :
                foreach ($aContact['info'] as $k => $info) :
        	?>
            <p class="pi_contactinfo">
                <a class="<?php echo $button; ?>" href="#" title="Change Icon">
                    <i class="<?php echo isset($aContact['info_icon'][$k]) ? $aContact['info_icon'][$k] : 'fa fa-refresh'; ?>"></i>
                </a>
                <input type="hidden" name="theme_options[contact][info_icon][]" value="<?php echo isset($aContact['info_icon'][$k]) ? $aContact['info_icon'][$k] : 'fa fa-refresh'; ?>">
                <input type="text" name="theme_options[contact][info][]" placeholder="Info" value="<?php echo  esc_attr($info) ?>">
                <a href="#" class="js_delete_item" title="Delete"><i class="fa fa-times"></i></a>
            </p>
            <?php 
                    endforeach;
                else :
            ?>
            <p class="pi_contactinfo">
                <a class="<?php echo $button; ?>" href="#"><i class="fa fa-refresh"></i></a>
                <input type="hidden" name="theme_options[contact][info_icon][]" value="fa fa-refresh">
                <input type="text" name="theme_options[contact][info][]" placeholder="Info" value="">
                <a href="#" class="js_delete_item"><i class="fa fa-times"></i></a>
            </p>
            <?php 
                endif; 
            ?>
            <button type="button" data-useclass="<?php echo esc_attr($button); ?>" class="button button-primary js_add_info_contact"><?php _e("Add", 'wiloke') ?></button>
        	<?php 
		}

		static public function pi_section_background($target, $aData =array(), $color='')
		{
			?>
	        <div class="form-group">
	            <label class="form-label"><?php _e('Background', 'wiloke') ;?></label>
	            <div class="controls">
	                <?php 
	                    $selected = isset($aData['background']) && !empty($aData['background']) ? $aData['background'] : 'none';
	                ?>
	                <select class="pi_toggle_multi" name="theme_options[<?php echo esc_attr($target) ?>][background]">
	                    <option value="none"  data-hide="#pi_transparent_color_<?php echo esc_attr($target); ?>, #pi_<?php echo esc_attr($target) ?>_bg_img, #pi_about_bg_color_<?php echo esc_attr($target); ?>" <?php selected($selected, 'none') ?>><?php _e('None','wiloke'); ?></option>
	                    <?php if ( $color == '' ) : ?>
	                    <option value="image" data-callback="transparent_id" data-transparentid="#pi_transparent_color_<?php echo esc_attr($target); ?>" data-show="#pi_<?php echo esc_attr($target) ?>_bg_img" data-hide="#pi_about_bg_color_<?php echo $target; ?>, #pi_transparent_color_<?php echo esc_attr($target); ?>" <?php selected($selected, 'image') ?>><?php _e('Image', 'wiloke'); ?></option>
	                	<?php endif; ?>
	                    <option value="color" data-hide="#pi_<?php echo esc_attr($target) ?>_bg_img, #pi_transparent_color_<?php echo esc_attr($target); ?>" data-show="#pi_about_bg_color_<?php echo $target; ?>"  <?php selected($selected, 'color') ?>><?php _e('Color', 'wiloke'); ?></option>
	                </select>
	            </div>
	        </div>
	        
	     	<?php if ( $color == '' ) : ?>
	        <div id="pi_<?php echo esc_attr($target) ?>_bg_img" class="form-group  pi_<?php echo esc_attr($target) ?>_bg pi_<?php echo esc_attr($target) ?>_bg_img">
	            <?php $image = isset($aData['bg_img']) && !empty($aData['bg_img']) ? $aData['bg_img'] : get_template_directory_uri()  . '/admin/pi-assets/images/no-img.jpg'; ?>
	            <div class="image-wrap">
	                <span><img src="<?php echo esc_url($image); ?>"  width="350"></span>
	            </div>
	            <br>
	            <button class="btn btn-white upload-img button button-primary custom_section" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke') ?></button>
	            <input class="insertlink wo-insert-link" type="hidden" value="<?php echo  isset($aData['bg_img']) ? esc_url($aData['bg_img']) : ""; ?>" name="theme_options[<?php echo esc_attr($target) ?>][bg_img]"> 
				<div class="controls">
	                <div class="slider">
	                    <input id="<?php echo esc_attr($target) ?>-parallax" type="checkbox" class="pi_check_toggle"  name="theme_options[<?php echo esc_attr($target) ?>][parallax]" value="1" <?php echo  (isset($aData['parallax']) && !empty ($aData['parallax']) ) ? 'checked' : ''; ?> >
	                    <label for="<?php echo esc_attr($target) ?>-parallax" class="form-label"><?php _e('Enable Parallax', 'wiloke') ?></label>
	                </div>
	            </div>
	            <div class="controls">
	                <div class="slider">
	                    <input type="checkbox" class="pi_check_toggle" data-toggle="#pi_transparent_color_<?php echo esc_attr($target); ?>" id="<?php echo esc_attr($target) ?>-overlay"   name="theme_options[<?php echo esc_attr($target) ?>][overlay]" value="1" <?php echo  (isset($aData['overlay']) && !empty ($aData['overlay']) ) ? 'checked' : ''; ?> >
	                    <label for="<?php echo esc_attr($target) ?>-overlay" class="form-label"><?php _e('Enable overlay', 'wiloke') ?></label>
	                </div>
	            </div>
	        </div>

	        <div id="pi_transparent_color_<?php echo esc_attr($target); ?>" class="pi_transparent_color pi_<?php echo esc_attr($target) ?>_bg  pi_<?php echo esc_attr($target) ?>_bg_color">
	             <input  type="text" class="color-picker pi_color_picker" value="<?php echo  isset($aData['overlay_color']) ? esc_attr($aData['overlay_color']) : "rgba(0,0,0,.3)"; ?>" name="theme_options[<?php echo esc_attr($target) ?>][overlay_color]"> 
	        </div>
	    	<?php 
	    	endif;
	    	?>
	    	<div id="pi_about_bg_color_<?php echo esc_attr($target); ?>">
				<code class="help">
					<?php _e("The main color will also be set Background color for the section - To customize main color, please click on Design-> Color Schemes", "wiloke");?>
	    		</code>
	    	</div>
	    	<?php 
		}

		public function pi_re_update_theme_options()
		{
			if ( defined('ICL_LANGUAGE_CODE') )
			{
				global $sitepress;
				$active_languages = $sitepress->get_active_languages();

				if ( count($active_languages) > 1 && (  !isset($_POST['icl_dupes']) && empty($_POST['icl_dupes']) ) )
				{
					if ( isset($_POST['post_type']) )
					{
						switch ( $_POST['post_type'] )
						{
							case 'pi_aboutus':
								piThemeOptions::$piOptions['aboutus']['content'] = $_POST['ID'];
							break;

							case 'wpcf7':
								piThemeOptions::$piOptions['contact']['contactform7_shortcode'] = $_POST['ID'];
								break;

							case 'pi_skill':
								piThemeOptions::$piOptions['skills']['content'] = $_POST['ID'];
								break;

							case 'pi_services':
								piThemeOptions::$piOptions['services']['content'] = $_POST['ID'];
								break;

							case 'pi_ourteam':
								piThemeOptions::$piOptions['team']['content'] = $_POST['ID'];
								break;

							case 'pi_ourclients':
								piThemeOptions::$piOptions['clients']['content'] = $_POST['ID'];
								break;

							case 'pi_funfacts':
								piThemeOptions::$piOptions['funfacts']['content'] = $_POST['ID'];
								break;

							case 'pi_pricingtable':
								piThemeOptions::$piOptions['pricing']['content'] = $_POST['ID'];
								break;

							case 'pi_testimonials':
								piThemeOptions::$piOptions['testimonials']['content'] = $_POST['ID'];
								break;

							case 'tunna_slider':
								piThemeOptions::$piOptions['header']['tunna_slider'] = $_POST['ID'];
								break;
						}

						$aOption['theme_options']  = piThemeOptions::$piOptions;

						update_option("pi_save_theme_options_".$_POST['icl_post_language'], $aOption);
					}

					
				}

			}
		}
	}

	// pi_configs.php
	$piInit = new piCore($piaConfigs);
}else{
	wp_die("Sorry! It has been confligs class name");
}