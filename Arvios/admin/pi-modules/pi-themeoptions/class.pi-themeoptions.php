<?php

class piThemeOptions extends piCore
{
	public static $piOptions;
	public static $currentLang;
	public function __construct()
	{
		$this->refresh_options();
		add_action('admin_menu', array($this, "pi_theme_options"));
		add_action('admin_enqueue_scripts', array($this, 'pi_enqueue_scripts')); 
		add_action('wp_ajax_import_theme_options', array($this, 'pi_import_qva_callback'));
		add_action('wp_ajax_export_theme_options_data', array($this, 'pi_export_qva_callback'));    
		add_action('wp_ajax_save_theme_options', array($this, 'pi_save_theme_options'));
		add_action('pi_theme_options', array($this, "pi_add_code"));
		add_action('wp_ajax_pi_add_new_section', array($this, 'pi_ajax_add_new_section'));
		add_action("after_switch_theme", array($this, "arvios_update_themeoptions"));
	}
 	
	public function arvios_update_themeoptions()
	{
		$aOptions = get_option("pi_save_theme_options_en");

		if ( !$aOptions )
		{
			$aOptions['theme_options'] = self::$piaConfigs['theme_options'];
			update_option("pi_save_theme_options_en", $aOptions);
		}
	}

	public function pi_save_theme_options() 
	{
		if ( check_ajax_referer('qva-secure', '_wp_nonce') && isset($_REQUEST['_wp_http_referer']) &&  preg_match("/page=".piCore::$menuSlug."/i",$_REQUEST['_wp_http_referer']) )
        {
        	$data = $_POST['data'];
        	parse_str($data, $aData);
        	$this->pi_unslashed_before_update($aData);
		  	if ( isset($aData['theme_options']['design']['color_scheme']) && !empty($aData['theme_options']['design']['color_scheme'])  )
        	{
        		$notRe =  $this->pi_custom_color($aData['pi_custom_color']);
        	}
        	if ( isset($aData['pi_custom_color']) && !empty($aData['pi_custom_color'])  )
        	{
        		update_option("pi_custom_color", $aData['pi_custom_color']);
        	}
		    unset($aData['_wp_http_referer']);
		    unset($aData['init-save-options']); 
		    unset($aData['_wo_nonce']); 
		    unset($aData['pi-save-options']);
		    unset($aData['data-import']);
	    	update_option("pi_save_theme_options_".piThemeOptions::$currentLang, $aData);
        	echo json_encode(array("status"=>1));
        }else{

        	echo json_encode(array("status"=>0));
        }

        die();
	}

	public function pi_export_qva_callback()
	{
        // userfull info http://davidwalsh.name/php-serialize-unserialize-issues
        $Option = get_option("pi_save_theme_options_".piThemeOptions::$currentLang);

        $content = serialize($Option);
        header("HTTP/1.1 200 OK");
        $file_name = "arvios-options.txt";
        header('Content-Type: text/csv');
        $fsize = strlen($content);
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-Disposition: attachment; filename=" . $file_name . ".".piThemeOptions::$currentLang);
        header("Content-Length: ".$fsize);
        header("Expires: 0");
        header("Pragma: public");
        echo $content;
	}

	public function pi_custom_color($color="")
	{
	 	if( !is_admin() )
	 	{
        	return;
        }
 
		$current 		= get_option("pi_current_custom_color");

		$current 		= $current && !empty($current) ?  $current : '';
		$changeColor 	= "#fdb813";

		if ( $current != $changeColor &&  $color != $current )
		{
			$file_source = self::$piaConfigs['custom_main'];
            update_option('pi_current_custom_color',$color);
            /** Define some vars **/
            $css_dir = get_template_directory() . '/assets/css/color/'; // Shorten code, save 1 call 	

 

		  	/** Capture CSS output **/
            ob_start();
            require($css_dir . $file_source);
            $css = ob_get_clean();
         	$css = str_replace($changeColor,$color,$css);

            if ( $css != ''  )
            {

	            /** Write to options.css file **/
	            WP_Filesystem();
	            global $wp_filesystem;

	           
            	$uploads = wp_upload_dir();

        	    if( !$wp_filesystem->is_dir( $uploads['basedir'] . '/wiloke/' ) ) 
			    {
					$wp_filesystem->mkdir( $uploads['basedir'] . '/wiloke/' );
				}

				$css_dir = $uploads['basedir'] . '/wiloke/';
            

	            if ( ! $wp_filesystem->put_contents( $css_dir . 'custom.css', $css, 0644) ) 
	            {
	                return false;
	            }  
            }
		}
	}

	public function pi_import_qva_callback()
	{

		if ( check_ajax_referer('qva-secure', '_wp_nonce') && isset($_REQUEST['_wp_http_referer']) &&  preg_match("/page=".piCore::$menuSlug."/i",$_REQUEST['_wp_http_referer']) )
        {
        	$data = $_POST['data'];

            if ( empty($data) )
            {
                $res = array("error"=>true, "mes"=>"You have successfully");
            }else{
            	$data 	 = stripslashes($data);
                $content = unserialize($data);
                if ( $content )
                {
       				update_option("pi_save_theme_options_".piThemeOptions::$currentLang, $content);
                	$res = array("error"=>false, "mes"=>"You have successfully");
            	}else{
            		$res = array("error"=>true, "mes"=>"Opp! Something go error :(");
            	}
            }
        }else{
            $res = array("error"=>true, "mes"=>"Opp! Something go error :(");
        }

        echo json_encode($res);
        die();
	}

    public  function pi_fix_corrupted_serialized_string($string) 
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

	public function refresh_options()
	{	
		$selected = ''; $con = true;
		if ( defined('ICL_LANGUAGE_CODE') )
		{
			$aOtherOptions = get_option("pi_save_theme_options_".ICL_LANGUAGE_CODE);

			if ( $aOtherOptions  )
			{
				self::$piOptions = $aOtherOptions['theme_options'];
				$con = false;
			}
			self::$currentLang = ICL_LANGUAGE_CODE;
		}else{
			self::$currentLang = 'en';
		}
		
		if ( $con )
		{
			self::$piOptions = get_option("pi_save_theme_options_en");
			// update_option("pi_save_theme_options_en", self::$piOptions);
			self::$piOptions = isset(self::$piOptions['theme_options']) ? self::$piOptions['theme_options'] : array();
			self::$piOptions = $this->pi_unslashed_before_update(self::$piOptions);
		}	
	}

	public function pi_theme_options()
	{
		add_theme_page('Theme Options', 'Theme Options', 'edit_theme_options',  piCore::$menuSlug, array($this, 'pi_theme_options_builder'), '', 4);
	}

	public function pi_theme_options_builder()
	{
		include ( 'tpl.pi-themeoptions.php' );
	}

	public function pi_get_custom_post_content($posttype)
    {
        if ( empty($posttype) ) die('Post type must  not empty!');
        $aPostMeta = get_posts( array('post_type'=> $posttype) );
        return $aPostMeta;
    }

	public function pi_enqueue_scripts()
	{
		$screen = get_current_screen();
		$url = get_template_directory_uri() . '/admin/pi-assets/';
		if ( preg_match('/'.piCore::$menuSlug.'/', $screen->base) )
		{
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-accordion');

			wp_register_style('pi_plugin_googlefont', 'https://www.google.com/fonts#ChoosePlace:select/Collection:Open+Sans:400,600,700,800,300italic,400italic,300');
			wp_register_style('pi_plugin_fontawesome', $url . 'css/font-awesome.min.css', array(), '4.0.2');
			wp_register_style('pi_themeoptions_style', $url . 'css/pi.themeoptions.css', array(), '1.0');
			wp_register_style('pi_themeoptions_smoothui', $url . 'css/jquery-ui-1.10.4.css', array(), '1.0');

			wp_register_style('pi_plugin_chosen', $url . 'css/chosen.css', array(), '1.0.2');
			wp_enqueue_style('pi_plugin_chosen');

			wp_enqueue_style('wp-color-picker');
			wp_enqueue_style('pi_plugin_googlefont');
			wp_enqueue_style('pi_plugin_fontawesome');
			wp_enqueue_style('pi_themeoptions_smoothui');
			wp_enqueue_style('pi_themeoptions_style');

			wp_register_script('pi-themeoptions-js', $url . 'js/pi.themeoptions.js', array(), '1.0', true);
			wp_register_script('pi-plugin-chosen', $url . 'js/chosen.jquery.js', array(), '1.0.2', true);
			wp_register_script('pi_plugin_cooke', $url . 'js/jquery.cookie.js', array(), '1.4.1');
			wp_register_script('pi_plugin_switch_checkbox', $url . 'js/switchery.min.js', array(), '0.6.2', true);

	        wp_register_script('pi_themeoptions_add_icon', $url  . 'js/pi.add_icon.js', array(), '1.0', true);
        

			wp_enqueue_script('wp-color-picker');
			wp_enqueue_script('pi-plugin-chosen'); 
			wp_enqueue_script('pi_plugin_switch_checkbox');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('pi_plugin_cooke');
			wp_enqueue_script('pi_themeoptions_add_icon');
			wp_enqueue_script('pi-themeoptions-js');
			

			wp_localize_script('pi-themeoptions-js', 'PI_CONFIG', array('sections'=>parent::$piaConfigs['sections']));
		}
		
		if ( preg_match("/pi-import-demo/", $screen->base) )
		{
			wp_register_style('pi-import-style', $url . 'css/pi.import.css', array(), '1.0');
			wp_enqueue_style('pi-import-style');
		}
	}

	public function pi_new_section_button()
	{
		include ( "popup.php" );
	}
	
	public function pi_add_code()
	{
		if ( isset($_GET['page']) && $_GET['page'] == piCore::$menuSlug)
		{
			include ( "popup.php" );
		}
	}

	public function pi_ajax_add_new_section()
	{
		$customSection   = get_option("pi_custom_section_id_".piThemeOptions::$currentLang);
		$customSection[] = $_POST['section_name'];
		update_option("pi_custom_section_id_".piThemeOptions::$currentLang, $customSection);

		$def = array(
			'enable'=>1,
			'title'=>'',
			'description'=>'',
			'content'=>'',
			'background'=>'none',
			'image_bg'=>'http://placehold.it/150&text=background-image',
			'color_bg'=>'#fff'
		);
		echo '<li class="pi-wrapsection latest"  data-name="'.$_POST['section_key'].'" data-sectioname="'.$_POST['section_name'].'" ><span class="pi-list-section ui-icon ui-icon-arrowthick"></span><span class="pi-toggle-settings-zone dashicons dashicons-welcome-write-blog pi-absolute pi-right"></span><h3 class="pi-section-name">'.$_POST['section_name'].'</h3>';
		$this->pi_custom_section_settings($_POST['section_name'], $_POST['section_key'], $def);
		echo '</li>';
		die();
	}

	public function pi_custom_section_settings($sectionName, $sectionKey, $aData)
	{
		?>
		<div class="wrap-custom-section-settings hidden">
			<input type="hidden" name="theme_options[pi_custom_section][<?php echo $sectionKey ?>][name]" value="<?php echo esc_attr($sectionName); ?>">

			<div class="panel-body">
                <div class="form-group">
                    <div class="slider controls">
                        <input type="checkbox" id="enable-<?php echo $sectionKey ?>" name="theme_options[pi_custom_section][<?php echo $sectionKey ?>][enable]" value="1" <?php echo ($aData['enable'] == 1) ? 'checked' : ''; ?>>
                        <label for="enable-<?php echo $sectionKey ?>" class="form-label">Enable Section</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                <div class="controls">
                    <input type="text" class="form-control" name="theme_options[pi_custom_section][<?php echo $sectionKey ?>][title]" value="<?php echo esc_attr($aData['title']) ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                <div class="controls">
                    <textarea class="form-control"  name="theme_options[pi_custom_section][<?php echo $sectionKey ?>][description]"><?php echo esc_textarea($aData['description']) ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="form-control hidden pi_custom_section_content">
                    <textarea  class="form-control" name="theme_options[pi_custom_section][<?php echo $sectionKey ?>][content]"><?php echo esc_textarea($aData['content']) ?></textarea>
                </div>
                <input type="submit" class="pi-edit-content btn btn-red" value="Edit content">
            </div>
			

            <div class="form-group">
	            <label class="form-label"><?php _e('Background', 'wiloke') ;?></label>
	            <div class="controls">
	                <select class="pi_toggle_multi" name="theme_options[pi_custom_section][<?php echo $sectionKey ?>][background]">
	                    <option value="none"  data-hide="#pi_transparent_color_<?php echo esc_attr($sectionKey); ?>, #pi_<?php echo esc_attr($sectionKey) ?>_bg_img, #pi_about_bg_color_<?php echo esc_attr($sectionKey); ?>" <?php selected($aData['background'], 'none') ?>><?php _e('None','wiloke'); ?></option>
	                    <option value="image" data-callback="transparent_id" data-transparentid="#pi_transparent_color_<?php echo esc_attr($sectionKey); ?>" data-show="#pi_<?php echo esc_attr($sectionKey) ?>_bg_img, #pi_transparent_color_<?php echo esc_attr($sectionKey); ?>" data-hide="#pi_about_bg_color_<?php echo $sectionKey; ?>" <?php selected($aData['background'], 'image') ?>><?php _e('Image', 'wiloke'); ?></option>
	                    <option value="color" data-hide="#pi_<?php echo esc_attr($sectionKey) ?>_bg_img, #pi_transparent_color_<?php echo esc_attr($sectionKey); ?>" data-show="#pi_about_bg_color_<?php echo $sectionKey; ?>" <?php selected($aData['background'], 'color') ?>><?php _e('Color', 'wiloke'); ?></option>
	                </select>
	            </div>
	        </div>

            <div id="pi_<?php echo esc_attr($sectionKey) ?>_bg_img" style="display:none" class="form-group  pi_<?php echo esc_attr($sectionKey) ?>_bg pi_<?php echo esc_attr($sectionKey) ?>_bg_img">
	            <?php $image = isset($aData['bg_img']) && !empty($aData['bg_img']) ? $aData['bg_img'] : get_template_directory_uri()  . '/admin/pi-assets/images/no-img.jpg'; ?>
	            <div class="image-wrap">
	                <span><img src="<?php echo esc_url($image); ?>"  width="350"></span>
	            </div>
	            <br>
	            <button class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke') ?></button>
	            <input class="insertlink wo-insert-link" type="hidden" value="<?php echo  isset($aData['bg_img']) ? esc_url($aData['bg_img']) : ""; ?>" name="theme_options[pi_custom_section][<?php echo esc_attr($sectionKey) ?>][bg_img]"> 
	            
				<div class="controls">
	                <div class="slider">
	                    <input id="<?php echo esc_attr($sectionKey) ?>-parallax" type="checkbox" class="pi_check_toggle"  name="theme_options[pi_custom_section][<?php echo esc_attr($sectionKey) ?>][parallax]" value="1" <?php echo  (isset($aData['parallax']) && !empty ($aData['parallax']) ) ? 'checked' : ''; ?> >
	                    <label for="<?php echo esc_attr($sectionKey) ?>-parallax" class="form-label"><?php _e('Enable Parallax', 'wiloke') ?></label>
	                </div>
	            </div>

	            <div class="controls">
	                <div class="slider">
	                    <input type="checkbox" class="pi_check_toggle" data-toggle="#pi_transparent_color_<?php echo esc_attr($sectionKey); ?>" id="<?php echo esc_attr($sectionKey) ?>-overlay"   name="theme_options[pi_custom_section][<?php echo esc_attr($sectionKey) ?>][overlay]" value="1" <?php echo  (isset($aData['overlay']) && !empty ($aData['overlay']) ) ? 'checked' : ''; ?> >
	                    <label for="<?php echo esc_attr($sectionKey) ?>-overlay" class="form-label"><?php _e('Enable overlay', 'wiloke') ?></label>
	                </div>
	            </div>
	        </div>
			
            <div id="pi_transparent_color_<?php echo esc_attr($sectionKey); ?>"  style="display:none" class="pi_transparent_color pi_<?php echo esc_attr($sectionKey) ?>_bg  pi_<?php echo esc_attr($sectionKey) ?>_bg_color">
	             <input  type="text" class="pi_color_picker" value="<?php echo  isset($aData['overlay_color']) ? esc_attr($aData['overlay_color']) : "rgba(0,0,0,.3)"; ?>" name="theme_options[pi_custom_section][<?php echo esc_attr($sectionKey) ?>][overlay_color]"> 
	        </div>
	    	
	    	<div id="pi_about_bg_color_<?php echo esc_attr($sectionKey); ?>" style="display:none">
				<code class="help"><?php _e("The main color will also be set Background color for the section - To customize main color, please click on Design-> Color Schemes", "wiloke");?></code>
	    	</div>
	    	
			
            <div class="form-group" style="margin-top: 20px;" style="display:none">
			    <button class="pi-remove-customsection btn btn-danger" data-key="<?php echo $sectionKey; ?>">Remove</button>
			</div>

        </div>
        <?php 
	}
}