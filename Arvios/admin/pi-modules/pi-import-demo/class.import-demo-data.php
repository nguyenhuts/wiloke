<?php
if ( class_exists( 'WP_Import' ))
{
    class piImport extends WP_Import
    {
        public $theme_options_name;
        public $default_configs;
        public $aErrors = array();
        public function __construct($default_configs)
        {
            parent::__construct();
            $this->default_configs = $default_configs;
        } 


        public function set_widgets()  
        {
            if(isset($this->default_configs['widgets']) && is_array($this->default_configs['widgets']) && count($this->default_configs['widgets'])>0)
            {
                update_option('sidebars_widgets', '');
                foreach($this->default_configs['widgets'] as $sidebar => $widgets)
                    if(is_array($widgets) && count($widgets)>0)
                        foreach($widgets as $widget => $options)
                            $this->add_widget_sidebar($sidebar,$widget,$options[0],$options[1]);
            }
        }

        public function checkMenuExists()
        {
            //get all registered menu locations
            $locations = get_theme_mod('nav_menu_locations');

            $theme_locations = get_nav_menu_locations();

            $menuExist = false;
           
            $menuID = $this->default_configs['menus']['menu_id'];

            if ( $theme_locations && !empty($theme_locations) )
            {
                if ( array_key_exists($menuID, $theme_locations) )
                {
                    $menuExist = true;
                }
            }

            if ($menuExist) :
                /* If menu already exist, reset menu */
                $term_id = $theme_locations[$menuID];
                $getMenuItems = wp_get_nav_menu_items($term_id);   

                if ( $getMenuItems && !empty($getMenuItems) )
                {
                    foreach ($getMenuItems as $controlMenuId) 
                    {
                        wp_delete_post($controlMenuId->ID);
                    }
                }
            endif;   
        }

        public function pi_set_aboutus()
        {
            $getPost = get_posts( array("post_type"=>"pi_aboutus") );

            if ( !empty($getPost) && !is_wp_error($getPost)  )
            {
                $i = 0;
                foreach ( $getPost  as $post ) : setup_postdata($post);
                    if ( $i==1 )
                    {
                        break;
                    }

                    $content = array(
                        "photo"=>225,
                        "title"=>"What We Do?",
                        "intro"=>"Orem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus adipiscing eget augue at tristique. Aliquam sit amet sodales dui, eget blandit metus. Nam fermentum purus eu est cursus tincidunt. Proin ut justo lorem. Mauris luctus aliquet nunc quis consectetur.

Mauris luctus aliquet nunc quis consectetur. Curabitur elit massa, consequat vel velit sit amet, scelerisque hendrerit mi.

[pi_wiloke_button button_name='Our Team' contextual='h-btn' size='btn-default' link='#team']"
                    );
                    update_post_meta($post->ID, "_pi_aboutus", $content);
                    $i++;
                endforeach;wp_reset_postdata();
            }
        }

        public function solved_blank_content($version)
        {
            $dir = get_template_directory() . '/admin/pi-modules/pi-import-demo/';
            $key    = isset($this->default_configs['options']['keyoptions']) ? $this->default_configs['options']['keyoptions'] : '';
            $getOptions = get_option($key);
        }

        public function set_menus()
        {
            $menuID = $this->default_configs['menus']['menu_id'];
            
            // $theme_locations['xpro_menu'];$menu_obj = get_term( $theme_locations['xpro_menu'], 'nav_menu' );
            
            $created_menus = wp_get_nav_menus();
            $founded = false;
            $aMenuLocation = array();
            if(!empty($created_menus) && is_array($this->default_configs))
            {

                foreach($created_menus as $menu) 
                {
                    if(is_object($menu))
                    {
                        if($menu->name == $this->default_configs['menus']['menu_name'])
                        {
                            //if we have found a menu with the correct menu name apply the id to the menu location
                            $locations[$menuID] = $menu->term_id;
                            echo "<p class=\"success\">Set default menu successfully!</p>";
                            set_theme_mod( 'nav_menu_locations', $locations);
                            $founded = true;
                        }
                    }
                }
            }
            if(!$founded)
            {
                echo "<p class=\"error\">Can not set default menu!</p>";
            }    
        }



        public function set_contact_form()
        {
            $contactForm7 = get_posts( array('post_type'=>'wpcf7_contact_form') );
            $contact = '<p class="form-item form-name">
    [text* your-name "Your name"]
</p>

<p class="form-item form-email">
    [email* your-email "Your email"]
</p>

<p class="form-item form-subject">
    [text your-subject "Subject"]
</p>
<p class="form-item form-captcha">
[captchac captcha-566] 
[captchar captcha-566]
</p>
<p class="form-item form-textarea">
    [textarea your-message "Message"]
</p>

<p class="form-item">
[submit "Send"]
</p>';

            if ( isset($contactForm7[0]) && !empty($contactForm7[0]) )
            {
                $cf7ID = $contactForm7[0]->ID;   
            }else{
                $cf7ID = wp_insert_post(
                    array(
                        'post_title'=>'Contact Form',
                        'post_status'=>'publish',
                        'post_content'=>'',
                        'post_type'=>'wpcf7_contact_form'
                    )
                );  
            }

            wp_update_post(
                $cf7ID,
                array(
                    "post_content"=>$contact
                )
            );

            update_post_meta($cf7ID, "_form", $contact);

            $options = get_option("pi_save_theme_options");
            $options['theme_options']['contact']['contactform7_shortcode'] = $cf7ID;
            update_option("pi_save_theme_options", $options);
        }


        public function set_static_page()
        {
            update_option('show_on_front', 'page');
            
            $args = array('post_type'=>'page', 'posts_per_page'=>-1);

            $pages = get_posts($args);

            if ( !empty($pages) && !is_wp_error($pages)  )
            {
                foreach ($pages as $page) : setup_postdata($page);
               
                    if ( get_the_title($page->ID) != 'Home' ) 
                    {
                        continue;
                    }else{
                        update_option('page_on_front', $page->ID);
                    }

                endforeach;
            }

            update_option('posts_per_page', 6);

            if ( function_exists('flush_rewrite_rules') )
            {
                flush_rewrite_rules();
            }
        }

        public function add_widget_sidebar($sidebarSlug, $widgetSlug, $countMod, $widgetSettings = array())
        {
            $sidebarOptions = get_option('sidebars_widgets');
            if(!isset($sidebarOptions[$sidebarSlug])){
                $sidebarOptions[$sidebarSlug] = array('_multiwidget' => 1);
            }
            $newWidget = get_option('widget_'.$widgetSlug);
            if(!is_array($newWidget))$newWidget = array();
            $count = count($newWidget)+1+$countMod;
            $sidebarOptions[$sidebarSlug][] = $widgetSlug.'-'.$count;

            $newWidget[$count] = $widgetSettings;

            update_option('sidebars_widgets', $sidebarOptions);
            update_option('widget_'.$widgetSlug, $newWidget);
        }

        public function remove_all_posts() 
        {   
            $posts = get_posts( array("post_type"=>"post", "posts_per_page"=>-1) );

            foreach ( $posts as $post ) : setup_postdata($post);
                wp_delete_post($post->ID, true);
            endforeach;wp_reset_postdata();

            $pages = get_posts( array("post_type"=>"page", "posts_per_page"=>-1) );

            foreach ( $pages as $page ) : setup_postdata($page);
                wp_delete_post($page->ID, true);
            endforeach;wp_reset_postdata();

            $portfolios = get_posts( array("post_type"=>"pi_portfolio", "posts_per_page"=>-1) );

            foreach ( $portfolios as $portfolio ) : setup_postdata($portfolio);
                wp_delete_post($portfolio->ID, true);
            endforeach;wp_reset_postdata();
        }

        public function update_theme_options($fileName = "")
        {
            $key    = isset($this->default_configs['options']['keyoptions']) ? $this->default_configs['options']['keyoptions'] : '';

            if (empty($fileName) || empty($key))
            {
                $aErrors[]  =  '<p class="error">Empty key or data</div>';    
            }

            if ( empty($aErrors) )
            {
                $dir = get_template_directory() . '/admin/pi-modules/pi-import-demo/';
                $directFile  = $dir . $fileName;

                if ( !file_exists($directFile) )
                {
                    $aErrors[] = "<p class='error'>Files doest not exist!</p>";
                }else{

                    $getContent = file_get_contents($directFile);
                    
                    if ( !empty($getContent) )
                    {
                        // $getContent = stripslashes($getContent);
                        // $getContent = $this->fix_corrupted_serialized_string($getContent);

                        $content = unserialize($getContent);
                       
                        delete_option($key);
                        
                        if ( !$content  )
                        {
                            $content = array();
                        }
                        
                        update_option("pi_save_theme_options_en", $content);
                     
                    }else{
                        $aErrors[] = '<p class="error">Empty the '.$fileName.' data</p>';
                    }
                }
            }

            if ( !empty($aErrors) )
            {
                foreach ($aErrors as $error)
                {
                    echo $error . "\n";
                }
            } 
        }

        public function pi_reupdate_theme_options()
        {
            $aOptions = get_option("pi_save_theme_options_en");
            $aReUpdate = array("pi_aboutus", "pi_services", "pi_funfacts", "pi_ourteam", "pi_skill", "pi_ourclients", "pi_testimonials", "pi_pricingtable", "wpcf7_contact_form");
            $aReThemeOptions=array("aboutus", "services", "funfacts", "team", "skills", "clients", "testimonials", "pricing", "contactform7_shortcode");
           
            foreach ( $aReUpdate as $order => $post_type )
            {
                $getPost = get_posts( array("post_type"=>$post_type) );

                $i = 0;
                
                if ( $getPost && !is_wp_error($getPost) )
                {
                    foreach ( $getPost as $post ) : setup_postdata($post);
                   
                    $key = $aReThemeOptions[$order];
                    
                    if ( $post_type == 'wpcf7_contact_form' )
                    {
                        $aOptions['theme_options']['contact']['contact_form'] = 1;   
                    }
                    $aOptions['theme_options']['contact'][$key] = $post->ID;

                    if ( $i==1 )
                    {
                        break;
                    }
                    $i++;
                    endforeach;wp_reset_postdata();
                }
            }

            $getPost = get_posts( array("post_type"=>"tunna_slider") );
            if ( $getPost && !is_wp_error($getPost) )
            {
                foreach ( $getPost as $post ) : setup_postdata($post);
                $i=0;
                $aOptions['theme_options']['header']['tunna_slider'] = $post->ID;

                if ( $i==1 )
                {
                    break;
                }
                $i++;
                endforeach;wp_reset_postdata();
            }

            
            update_option("pi_save_theme_options_en", $aOptions);
        }



        public  function fix_corrupted_serialized_string($string) 
        {
            $tmp = explode(':"', $string);
            $length = count($tmp);
            for($i = 1; $i < $length; $i++) {    
                list($string) = explode('"', $tmp[$i]);
                $str_length = strlen($string);    
                $tmp2 = explode(':', $tmp[$i-1]);
                $last = count($tmp2) - 1;    
                $tmp2[$last] = $str_length;         
                $tmp[$i-1] = join(':', $tmp2);
            }
            return join(':"', $tmp);
        } 
    }
}