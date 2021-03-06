<?php

// userfull: http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/

// created by pirateS - wiloke theme 
class piCustomize extends piCore
{
    static $aCurrentLang;
    public $wp_customize; 
    public $piaOptions; 
    public $priority;
    public $sectionPriority; 
    
    public function __construct()
    {  
        add_action('init', array($this, 'refresh_options'));
        
        add_action( 'customize_preview_init' ,  array( $this, 'pi_customize_live_preview' ) );
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'pi_customize_enqueue_script' ) );
        add_action( 'customize_register',  array( $this, 'pi_customizer_register' ));     
        add_action( 'wp_ajax_pi_customize_change_header_bg', array($this, 'pi_customize_change_header_bg' ));
        add_action( 'customize_controls_footer', array($this, 'pi_add_footer' ));
        add_action( 'wp_ajax_create_section', array($this, 'pi_creating_custom_section' ));
        add_action( 'wp_ajax_edit_custom_section', array($this, 'pi_edit_custom_section' ));
        add_action( 'wp_ajax_pi_contact_info', array($this, 'pi_set_contact_info' ) );
        add_action( 'customize_save_after', array($this, 'pi_update_option'), 99);
    }

    public function refresh_options()
    {   
        if ( has_action('customize_controls_init') )
        {
            $con    = true;
            $lang = "en";
            if ( defined('ICL_LANGUAGE_CODE') )
            {
                $lang = ICL_LANGUAGE_CODE;
            }

            if ( $lang !='en' )
            {
                $aOtherOptions = get_option("pi_save_theme_options_".$lang);
                if ( $aOtherOptions  )
                {
                    $this->piaOptions = $aOtherOptions['theme_options'];
                    $con = false;
                }
            }

            

            piCustomize::$aCurrentLang = $lang;

            if ( $con )
            { 
                $this->piaOptions = get_option("pi_save_theme_options_en");
                $this->piaOptions = isset($this->piaOptions['theme_options']) ? $this->piaOptions['theme_options'] : array();
                $this->piaOptions = $this->pi_unslashed_before_update($this->piaOptions);
            }
           
            $fixOptions['theme_options'] = $this->piaOptions;
            update_option("pi_save_theme_options", $fixOptions);
        }
    }

    public function pi_set_contact_info()
    {
        if ( check_ajax_referer('pi_contact_detail_action', 'nonce' ) )
        {
            if ( !empty($_POST['data']) )
            {
                parse_str($_POST['data'], $aData);
                
                piThemeOptions::$piOptions['contact']['info']       =  isset($aData['theme_options']['contact']['info']) ? $aData['theme_options']['contact']['info'] : array();
                piThemeOptions::$piOptions['contact']['info_icon']  =  isset($aData['theme_options']['contact']['info_icon']) ? $aData['theme_options']['contact']['info_icon'] : array();
                $options['theme_options'] = piThemeOptions::$piOptions;

                $lang = defined("ICL_LANGUAGE_CODE")  ? ICL_LANGUAGE_CODE : 'en';

                update_option("pi_save_theme_options_".$lang, $options);
            }
        }
        wp_die();
    }

    public function pi_edit_custom_section()
    {
        $aCustomSection = piThemeOptions::$piOptions['pi_custom_section'];
        $sectionid      = $_POST['sectionid'];

        if ( empty($sectionid) )
        {
            echo 0;
        }else{
            $aData = $aCustomSection[$sectionid];
            echo wp_send_json($aData);
        }
        wp_die();
    }

    public function pi_creating_custom_section()
    {   
        // $customSection = get_option("pi_custom_section_id_".self::$aCurrentLang);
        $con           = true;
        $isEdit        =  false;

        $parseData     = json_decode(stripslashes($_POST['data']), true);
        $lang          = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en';
        $parseData['name'] = trim($parseData['name']);
        $aSection = isset(piThemeOptions::$piOptions['section_builder']) && !empty(piThemeOptions::$piOptions['section_builder']) ? explode(",", piThemeOptions::$piOptions['section_builder']) : piCore::$piaConfigs['sections'];

        if ( $_POST['is_edit'] == 'false' )
        {
            if ( in_array($parseData['name'], $aSection) )
            {
                $con = false;
            }
        }else{
            $isEdit = true;
        }

        if ( $con )
        {
            if ( !$isEdit )
            {
                piThemeOptions::$piOptions['section_builder'] = isset(piThemeOptions::$piOptions['section_builder']) ? piThemeOptions::$piOptions['section_builder'] : implode(",",piCore::$piaConfigs['sections']);
                piThemeOptions::$piOptions['section_builder'] .= "," . $parseData['name'];
            }

            piThemeOptions::$piOptions['pi_custom_section'][$parseData['name']] = $parseData;
            piThemeOptions::$piOptions['theme_options']   = piThemeOptions::$piOptions;
            

            update_option("pi_save_theme_options_".$lang, piThemeOptions::$piOptions);

            echo "done";
        }else{
            echo "false";
        }

        wp_die();
    }


    public function pi_update_option()
    {
        $aNewData  = get_option("pi_save_theme_options");
        $aNewData  = $aNewData['theme_options'];

        $aOldData  = get_option("pi_save_theme_options_".self::$aCurrentLang);
        $aOldData  = isset($aOldData['theme_options']) ? $aOldData['theme_options'] : array();

        $aNewData['theme_options']  = array_merge($aOldData, $aNewData);

        update_option("pi_save_theme_options_".self::$aCurrentLang, $aNewData);
    }


    public function pi_customize_change_header_bg()
    {   
        $type   = $_POST['mod'];
        $res    =  "";

        switch ($type) 
        {
            case 'bg_slideshow':

                if ( !isset($_POST['id']) )
                {
                    $tunnarId = isset(piThemeOptions::$piOptions['header']['tunna_slider']) && !empty(piThemeOptions::$piOptions['header']['tunna_slider']) ? piThemeOptions::$piOptions['header']['tunna_slider'] : '';
                }else{
                    $tunnarId  = trim($_POST['id']);
                }
                if ( empty($tunnarId) )
                {
                    $res = '<p class="text-center"><code>[Oop! You haven\'t created any slider yet ]</code></p>';
                }else{
                    echo do_shortcode('[tunna_slider id="'.$tunnarId.'"]');
                    wp_die();
                }
                break;
            
            case 'text_slider':
                $img =  isset( piThemeOptions::$piOptions['header']['text_slider'] ) && !empty( piThemeOptions::$piOptions['header']['text_slider'] ) ? piThemeOptions::$piOptions['header']['text_slider'] : 'http://placehold.it/1600x1160';
                $textEffect  = isset(piThemeOptions::$piOptions['text_slider']['text_effect']) && !empty(piThemeOptions::$piOptions['text_slider']['text_effect']) ? piThemeOptions::$piOptions['text_slider']['text_effect'] : 'fade';
                $getTitle    =  isset(piThemeOptions::$piOptions['text_slider']['title']) && !empty(piThemeOptions::$piOptions['text_slider']['title']) ? piThemeOptions::$piOptions['text_slider']['title'] : array('We are Axpo', 'We love what we do');
                $getTitle    = implode(",", $getTitle);
                $getSubTitle    =  isset(piThemeOptions::$piOptions['text_slider']['sub_title']) && !empty(piThemeOptions::$piOptions['text_slider']['sub_title']) ? piThemeOptions::$piOptions['text_slider']['sub_title'] : array('Stay Hungry', 'Stay Foolish');
                $getSubTitle    = implode(",", $getSubTitle);
                $getButtonName    =  isset(piThemeOptions::$piOptions['text_slider']['button_name']) && !empty(piThemeOptions::$piOptions['text_slider']['button_name']) ? piThemeOptions::$piOptions['text_slider']['button_name'] : array('Our Work', 'Meet Team');
                $getButtonName    = implode(",", $getButtonName);
                $getButtonLink    =  isset(piThemeOptions::$piOptions['text_slider']['button_link']) && !empty(piThemeOptions::$piOptions['text_slider']['button_link']) ? piThemeOptions::$piOptions['text_slider']['button_link'] : array('#portfolio', '#team');
                $getButtonLink    = implode(",", $getButtonLink);
                $overlay_color    = isset(piThemeOptions::$piOptions['header']['overlay_color']) && !empty(piThemeOptions::$piOptions['header']['overlay_color']) ? piThemeOptions::$piOptions['header']['overlay_color'] : 'rgba(0,0,0,0)';

                echo do_shortcode('[pi_text_slider overlay_color="'.$overlay_color.'" title="'.$getTitle.'" button_name="'.$getButtonName.'" button_link="'.$getButtonLink.'" sub_title="'.$getSubTitle.'"  effect="'.$textEffect.'" img="'.$img.'"]');
                wp_die();
            break;

            default:
            break;
        }
        echo $res;
        wp_die();
    }
    
    public function pi_customize_live_preview()
    {
        $url = get_template_directory_uri() . '/admin/pi-assets/customize/';
      
        $uri = get_template_directory_uri() . '/assets/';
        $min = ".min.";
        wp_register_script('pi_customize_preview', $url . 'js/pi.preview.js', array(), '1.0', true);

        wp_enqueue_script('pi_customize_preview');
        wp_localize_script('pi_customize_preview', 'PI_AJAX', admin_url('admin-ajax.php'));
        $aSection = parent::$piaConfigs['sections'];
        $status = array();

        $parseData = json_decode(wp_unslash( $_POST['customized'] ), true);

        foreach ($aSection as $value) 
        {
            $status[$value]   = isset($parseData['pi_save_theme_options[theme_options]['.$value.'][enable]']) && !empty($parseData['pi_save_theme_options[theme_options]['.$value.'][enable]']) ? 1 : 0;
        }

        $aContacts = array("contact_detail", "contact_form", "enablegooglemap");
        $contact =array();
        foreach ($aContacts as $value) 
        {
            $contact[$value] = isset($parseData['pi_save_theme_options[theme_options][contact]['.$value.']']) && !empty($parseData['pi_save_theme_options[theme_options][contact]['.$value.']']) ? 1 : 0;
        }
        wp_localize_script('pi_customize_preview', 'PISECTIONSTATUS', json_encode($status));
        wp_localize_script('pi_customize_preview', 'PICONTACT', json_encode($contact));
    }

    public function pi_customize_enqueue_script()
    {
        $url = get_template_directory_uri() . '/admin/pi-assets/customize/';
       
        wp_enqueue_script('jquery');
        wp_enqueue_media();

        wp_register_style('pi_plugin_fontawesome', get_template_directory_uri() . '/admin/pi-assets/css/font-awesome.min.css', array(), '4.0.2');
        wp_enqueue_style('pi_plugin_fontawesome');

        wp_register_style('pi_customize_spectrum', get_template_directory_uri() . '/admin/pi-assets/css/spectrum.css', array(), '1.0');
        wp_enqueue_style('pi_customize_spectrum');

        wp_register_style('pi_customize_css', $url . 'css/style.css', array(), '1.0');
        wp_enqueue_style('pi_customize_css');

        wp_register_style('pi_customize_popup', get_template_directory_uri() . '/admin/pi-assets/css/popup-style.css', array(), '1.0');
        wp_enqueue_style('pi_customize_popup');

        wp_register_script('pi_customize_spectrum', get_template_directory_uri()  . '/admin/pi-assets/js/spectrum.js', array(), '1.0', true);
        wp_enqueue_script('pi_customize_spectrum');

        wp_register_script('pi_customize_controls', $url  . 'js/pi.controls.js', array(), '1.0', true);
        wp_enqueue_script('pi_customize_controls');

        wp_register_script('pi_customize_add_icon', get_template_directory_uri()  . '/admin/pi-assets/js/pi.add_icon.js', array(), '1.0', true);
        wp_enqueue_script('pi_customize_add_icon');

        $aSections = array("sections"=>parent::$piaConfigs['sections'], "name"=>parent::$piaConfigs['sections_name']);

        wp_localize_script("pi_customize_controls", "PI_CONFIG", json_encode($aSections));
    }

    public function pi_customize_print_script()
    {
       
    }

    public function pi_sanitize_callback($value) 
    {
        return $value;
    }
    
    public function pi_customizer_register($wp_customize)
    {  
        $uri = get_template_directory_uri() . '/admin/pi-assets/images/';
        $this->priority = 0;
        $this->sectionPriority = 0;

        $aOptions = isset($this->piaOptions) && !empty($this->piaOptions) ? $this->piaOptions : array();

        $this->wp_customize = $wp_customize;

        // Logo and favicon
        $wp_customize->add_section('pi_logo_favicon', array(
            'title'    => __('Logo & Favicon', 'wiloke'),
            'priority' => $this->sectionPriority++,
        ));

        // Enable Logo
        $this->pi_create_title('pi_logo_favicon', 'pi_logo_title', __('Logo', 'wiloke'));
        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][logo][enable]',
            array(
                'default'        => (isset($aOptions['logo']['enable'])?$aOptions['logo']['enable'] : ''),
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( 
            'theme_options[logo][enable]'
            ,array(
                'label'    => __('Enable Logo', 'wiloke'),
                'section'  => 'pi_logo_favicon',
                'settings' => 'pi_save_theme_options[theme_options][logo][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        ); 
        $wp_customize->get_setting( 'pi_save_theme_options[theme_options][logo][enable]' )->transport = 'postMessage';
     

        /*Type*/
        $wp_customize->add_setting(
            'pi_save_theme_options[theme_options][logo][type]',
            array(
                'default'=>isset($aOptions['logo']['type'])?$aOptions['logo']['type']:'',
                'type'   => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control('pi_save_theme_options[theme_options][logo][type]',
            array(
                'label' => __('Logo Type', 'wiloke'),
                'section' => 'pi_logo_favicon',
                'settings' => 'pi_save_theme_options[theme_options][logo][type]',
                'priority'      => $this->priority++,
                'type' => 'select',
                'choices' => array(
                    'upload' => 'Upload an image',
                    'text' => 'Text',
                ),
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][logo][type]')->transport = 'postMessage';


        /*=========================================*/
        /* Text Logo
        /*=========================================*/
        $wp_customize->add_setting(
            'pi_save_theme_options[theme_options][logo][text]',
            array(
                'default'=>isset($aOptions['logo']['text']) ? wp_unslash($aOptions['logo']['text']):'',
                'type'   => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control('pi_save_theme_options[theme_options][logo][text]',
            array(
                'label' => __('Enter Text', 'wiloke'),
                'section' => 'pi_logo_favicon',
                'settings' => 'pi_save_theme_options[theme_options][logo][text]',
                'priority'      => $this->priority++,
                'type' => 'text',
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][logo][text]')->transport = 'postMessage';


        $wp_customize->add_setting(
            "pi_save_theme_options[theme_options][logo][logo_color]",
            array(
                'default'       =>  isset($aOptions['logo']['logo_color']) ? $aOptions['logo']['logo_color'] :'#000',
                'type'          => 'option',
                'capability'    => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( 
            new WP_Customize_Color_Control( 
                $wp_customize, 
                "pi_save_theme_options[theme_options][logo][logo_color]",
                array(
                    'label'      => __( 'Text Color', 'wiloke' ),
                    'section'    => 'pi_logo_favicon',
                    'priority'   => $this->priority++,
                    'settings'   => "pi_save_theme_options[theme_options][logo][logo_color]"
                ) 
            ) 
        );
        $wp_customize->get_setting("pi_save_theme_options[theme_options][logo][logo_color]")->transport = 'postMessage'; 

        /*=========================================*/
        /* Logo 1
        /*=========================================*/
        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][logo][logo_nav]',
            array(
                'default'        => isset($aOptions['logo']['logo_nav']) ? $aOptions['logo']['logo_nav']: $uri . 'logo-nav.png',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
                
            )
        );
        $wp_customize->add_control( new piUploadImages($wp_customize, 'pi_save_theme_options[theme_options][logo][logo_nav]',array(
                'label'     => "Logo 1 - Display at the navigation",
                'section'   => 'pi_logo_favicon',
                'settings'  => 'pi_save_theme_options[theme_options][logo][logo_nav]',
                'priority'  => $this->priority++,
                'button_class'=>'is_logo',
            )
        ) );
        $wp_customize->get_setting( 'pi_save_theme_options[theme_options][logo][logo_nav]' )->transport = 'postMessage';

        /*=========================================*/
        /* Logo 2
        /*=========================================*/
        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][logo][retina_logo]',
            array(
                'default'        => isset($aOptions['logo']['retina_logo']) ? $aOptions['logo']['retina_logo']: $uri . 'logo.png',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piUploadImages($wp_customize, 'pi_save_theme_options[theme_options][logo][retina_logo]',array(
                'label'     => "Retina",
                'section'   => 'pi_logo_favicon',
                'settings'  => 'pi_save_theme_options[theme_options][logo][retina_logo]',
                'priority'  => $this->priority++,
                'button_class'=>'is_logo',
            )
        ) );
        $wp_customize->get_setting( 'pi_save_theme_options[theme_options][logo][retina_logo]' )->transport = 'postMessage';



        // enable favicon
        $this->pi_create_title('pi_logo_favicon', 'pi_favicon_title', 'Favicon');

        $wp_customize->add_setting
        (
            'pi_save_theme_options[theme_options][favicon_touch][enable]',
            array(
                'default'=>isset($aOptions['favicon_touch']['enable'])?$aOptions['favicon_touch']['enable']:'',
                'type'   => 'option',
                'capability'     => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control
        (
            'pi_save_theme_options[theme_options][favicon_touch][enable]',
            array(
                'label'=>__('Enable Favicon & Touch', 'wiloke'),
                'section'=>'pi_logo_favicon',
                'settings'=>'pi_save_theme_options[theme_options][favicon_touch][enable]',
                'priority'=>$this->priority++,
                'type'=>'checkbox'
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][favicon_touch][enable]')->transport = 'postMessage';

        // $this->pi_create_des('pi_logo_favicon', 'pi_upload_favicon_title','Upload Favicon', 6);
        $wp_customize->add_setting
        (
            'pi_save_theme_options[theme_options][favicon_touch][favicon]',
            array(
                'default'=>isset($aOptions['favicon_touch']['favicon'])?$aOptions['favicon_touch']['favicon']:'',
                'type'   => 'option',
                'capability'     => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piUploadImages($wp_customize, 'pi_save_theme_options[theme_options][favicon_touch][favicon]', array(
                'label' => "Upload Favicon",
                'section' => 'pi_logo_favicon',
                'settings' => 'pi_save_theme_options[theme_options][favicon_touch][favicon]',
                'priority' => $this->priority++,
                'button_class'=>'is_favicon'
            )
        ) );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][favicon_touch][favicon]')->transport = 'postMessage';
        // $this->pi_create_des('pi_logo_favicon', 'pi_upload_touch_title','Upload Touch', 8);
        $wp_customize->add_setting
        (
            'pi_save_theme_options[theme_options][favicon_touch][touch]',
            array(
                'default'=>isset($aOptions['favicon_touch']['touch'])?$aOptions['favicon_touch']['touch']:'',
                'type'   => 'option',
                'capability'     => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piUploadImages($wp_customize, 'pi_save_theme_options[theme_options][favicon_touch][touch]',array(
                'label' => "Upload Touch",
                'section' => 'pi_logo_favicon',
                'settings' => 'pi_save_theme_options[theme_options][favicon_touch][touch]',
                'priority' => $this->priority++,
                'button_class'=>'is_touch'
            )
        ) );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][favicon_touch][touch]')->transport = 'postMessage';

        // Section builder
        $wp_customize->add_section('pi_section_builder', array(
            'title'    => __('Section', 'wiloke'),
            'priority' => $this->sectionPriority++,
        ));



        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][hack_section_builder]',
            array(
                'default'        => '',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piHidden($wp_customize, 'pi_save_theme_options[theme_options][header][hack_section_builder]',array(
                'label'     => "Hack Section Builder",
                'section'   => 'pi_section_builder',
                'settings'  => 'pi_save_theme_options[theme_options][header][hack_section_builder]',
                'priority'  => $this->priority++,
            )
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][hack_section_builder]')->transport = 'postMessage';

        // Header Section theme_options[][]
        $this->pi_create_title('pi_section_builder', 'pi_header_section_title', 'Header', '#page-top');
        

        $wp_customize->add_setting ( 
                "pi_save_theme_options[theme_options][header][enable]",
                array(
                    'default'        => isset($aOptions['header']['enable']) ? $aOptions['header']['enable']:0,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][header][enable]'
            ,array(
                'label'    => __('Enable Header', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][header][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][enable]')->transport = 'postMessage';


        $wp_customize->add_setting(
            'pi_save_theme_options[theme_options][header][type]',
            array(
                'default'=>isset($aOptions['header']['type'])?$aOptions['header']['type']:'',
                'type'   => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control('pi_save_theme_options[theme_options][header][type]',
            array(
                'label' => __('Header', 'wiloke'),
                'section' => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][header][type]',
                'priority'      => $this->priority++,
                'type' => 'select',
                'choices' => array(
                    'youtube_bg' => 'Youtube Background',
                    'img_slider' => 'Image Slider',
                    'bg_slideshow' => 'Slider Background',
                    'text_slider' => 'Text Slider',
                    'image_fixed' => 'Image Static',
                ),
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][type]')->transport = 'postMessage';

        // Youtube
        // $this->pi_create_title('pi_section_builder', 'pi_youtube_title', 'Youtube', $this->priority++);
        $this->pi_create_des('pi_section_builder', 'pi_youtube_des', 'Please note that, Youtube background will not be auto played on mobile device. We recommend you use image background on mobile device, checking "Image for mobile" to enable this function ', $this->priority++);

        $wp_customize->add_setting(
            'pi_save_theme_options[theme_options][header][youtube_link]',
            array(
                'default'=>isset($aOptions['header']['youtube_link'])?esc_url($aOptions['header']['youtube_link']):'',
                'type'   => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control('pi_save_theme_options[theme_options][header][youtube_link]',
            array(
                'label' => __('Enter Youtube Link', 'wiloke'),
                'section' => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][header][youtube_link]',
                'priority'      => $this->priority++,
                'type' => 'text',
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][youtube_link]')->transport = 'postMessage';
        // Video Options
        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][video_options][mute]',
            array(
                'default'        => isset($aOptions['video_options']['mute'])?$aOptions['video_options']['mute']:'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][video_options][mute]'
            ,array(
                'label'    => __('Mute', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][video_options][mute]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][video_options][mute]')->transport = 'postMessage';


        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][video_options][videoplaceholder]',
            array(
                'default'        => isset($aOptions['video_options']['videoplaceholder'])?$aOptions['video_options']['videoplaceholder']:'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][video_options][videoplaceholder]'
            ,array(
                'label'    => __('Image For Mobile', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][video_options][videoplaceholder]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][video_options][videoplaceholder]')->transport = 'postMessage';

        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][hack_youtube]',
            array(
                'default'        => '',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piHidden($wp_customize, 'pi_save_theme_options[theme_options][header][hack_youtube]',array(
                'label'     => "Hack Youtube",
                'section'   => 'pi_section_builder',
                'settings'  => 'pi_save_theme_options[theme_options][header][hack_youtube]',
                'priority'  => $this->priority++,
            )
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][hack_youtube]')->transport = 'postMessage';

        // Image Slider
        // $this->pi_create_title('pi_section_builder', 'pi_image_slider_title', '', $this->priority++);
        // upload logo theme_options[header][img_slider]
        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][img_slider]',
            array(
                'default'        => isset($aOptions['header']['img_slider']) ? $aOptions['header']['img_slider'] :'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piUploadImages($wp_customize, 'pi_save_theme_options[theme_options][header][img_slider]',array(
                'label' => "Image Slider",
                'section' => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][header][img_slider]',
                'priority' => $this->priority++,
                'button_class'=>'img_slider multiple'
            )
        ) );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][img_slider]')->transport = 'postMessage';


        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][hack_img_slider]',
            array(
                'default'        => '',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piHidden($wp_customize, 'pi_save_theme_options[theme_options][header][hack_img_slider]',array(
                'label'     => "Hack Image Slider",
                'section'   => 'pi_section_builder',
                'settings'  => 'pi_save_theme_options[theme_options][header][hack_img_slider]',
                'priority'  => $this->priority++,
            )
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][hack_img_slider]')->transport = 'postMessage';
        // // Slider Bg
        // $this->pi_create_title('pi_section_builder', 'pi_image_slider_bg', '', $this->priority++);
        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][tunna_slider]',
            array(
                'default'        => isset($aOptions['header']['tunna_slider'])?$aOptions['header']['tunna_slider']:'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        ); 
        $wp_customize->add_control(  'pi_save_theme_options[theme_options][header][tunna_slider]',array(
                'label' => "Slider Background",
                'section' => 'pi_section_builder',
                'type' => 'select',
                'settings' => 'pi_save_theme_options[theme_options][header][tunna_slider]',
                'priority' => $this->priority++,
                'choices' => $this->pi_get_tunnar_slider()
        )   );

        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][tunna_slider]')->transport = 'postMessage';

        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][hack_tunna_slider]',
            array(
                'default'        => '',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piHidden($wp_customize, 'pi_save_theme_options[theme_options][header][hack_tunna_slider]',array(
                'label'     => "Hack Youtube",
                'section'   => 'pi_section_builder',
                'settings'  => 'pi_save_theme_options[theme_options][header][hack_tunna_slider]',
                'priority'  => $this->priority++,
            )
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][hack_tunna_slider]')->transport = 'postMessage';

        $this->pi_create_link("pi_section_builder", "pi_save_theme_options[header][text_slider]", "?page=".piCore::$menuSlug, "Click here to change/add slide");
        
        $wp_customize->add_setting(
            'pi_save_theme_options[theme_options][text_slider][text_effect]',
            array(
                'default'=>isset($aOptions['header']['type'])?$aOptions['header']['type']:'',
                'type'   => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control('pi_save_theme_options[theme_options][text_slider][text_effect]',
            array(
                'label' => __('Header', 'wiloke'),
                'section' => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][text_slider][text_effect]',
                'priority'      => $this->priority++,
                'type' => 'select',
                'choices' => array(
                    'fade' => 'fade',
                    'goDown' => 'goDown',
                    'backSlide' => 'backSlide',
                    'fadeUp' => 'fadeUp',
                ),
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][text_slider][text_effect]')->transport="postMessage";

      

        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][image_fixed]',
            array(
                'default'        => isset($aOptions['header']['image_fixed'])?$aOptions['header']['image_fixed']:'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piUploadImages($wp_customize, 'pi_save_theme_options[theme_options][header][image_fixed]',array(
                'label' => "Upload an image",
                'section' => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][header][image_fixed]',
                'priority' => $this->priority++,
                'button_class'=>'image_fixed'
            )
        ) );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][image_fixed]')->transport = 'postMessage';

        

        /*=========================================*/
        /*  Image Fixed
        /*=========================================*/
        $wp_customize->add_setting (
            'pi_save_theme_options[theme_options][header][hack_imagefixed]',
            array(
                'default'        => '',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( new piHidden($wp_customize, 'pi_save_theme_options[theme_options][header][hack_imagefixed]',array(
                'label'     => "Hack Image Fixed",
                'section'   => 'pi_section_builder',
                'settings'  => 'pi_save_theme_options[theme_options][header][hack_imagefixed]',
                'priority'  => $this->priority++,
            )
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][header][hack_imagefixed]')->transport = 'postMessage';

        /*=========================================*/
        /* Header Title
        /*=========================================*/

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][header][title]",
                array(
                    'default'        => isset($aOptions['header']['title']) ? $aOptions['header']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  "pi_save_theme_options[theme_options][header][title]",array(
                'label'     => "Title",
                'section'   => 'pi_section_builder',
                'type'      => 'text',
                'settings'  => "pi_save_theme_options[theme_options][header][title]",
                'priority'  => $this->priority++
        ) );
        $wp_customize->get_setting( "pi_save_theme_options[theme_options][header][title]" )->transport = 'postMessage';

        /*=========================================*/
        /*  Sub Title
        /*=========================================*/
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][header][sub_title]",
                array(
                    'default'        => isset($aOptions['header']['sub_title']) ? $aOptions['header']['sub_title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  "pi_save_theme_options[theme_options][header][sub_title]",array(
                'label'     => "Sub title",
                'section'   => 'pi_section_builder',
                'type'      => 'text',
                'settings'  => "pi_save_theme_options[theme_options][header][sub_title]",
                'priority'  => $this->priority++
        ) );
        $wp_customize->get_setting( "pi_save_theme_options[theme_options][header][sub_title]" )->transport = 'postMessage';

        /*=========================================*/
        /*  Button
        /*=========================================*/
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][header][button_name]",
                array(
                    'default'        => isset($aOptions['header']['button_name']) ? $aOptions['header']['button_name']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  "pi_save_theme_options[theme_options][header][button_name]",array(
                'label'     => "Button Name",
                'section'   => 'pi_section_builder',
                'type'      => 'text',
                'settings'  => "pi_save_theme_options[theme_options][header][button_name]",
                'priority'  => $this->priority++
        ) );
        $wp_customize->get_setting( "pi_save_theme_options[theme_options][header][button_name]" )->transport = 'postMessage';

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][header][button_link]",
                array(
                    'default'        => isset($aOptions['header']['button_link']) ? $aOptions['header']['button_link']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  "pi_save_theme_options[theme_options][header][button_link]",array(
                'label'     => "Link To",
                'section'   => 'pi_section_builder',
                'type'      => 'text',
                'settings'  => "pi_save_theme_options[theme_options][header][button_link]",
                'priority'  => $this->priority++
        ) );
        $wp_customize->get_setting( "pi_save_theme_options[theme_options][header][button_link]" )->transport = 'postMessage';

        /*=========================================*/
        /*  Overlay Color 
        /*=========================================*/
        $wp_customize->add_setting (
            "pi_save_theme_options[theme_options][header][overlay_color]",
            array(
                'default'        => isset($aOptions['header']['overlay_color']) ? $aOptions['header']['overlay_color']:'rgba(0,0,0,0)',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( 
            new PI_COLOR_PICKER( 
            $wp_customize, 
            "pi_save_theme_options[theme_options][header][overlay_color]",
            array(
                'label'      => __( 'Overlay Color', 'wiloke' ),
                'has_lable'  => true,
                'section'    => 'pi_section_builder',
                'priority'   => $this->priority++,
                'settings'   => "pi_save_theme_options[theme_options][header][overlay_color]"
            ) ) 
        );

        $wp_customize->get_setting( "pi_save_theme_options[theme_options][header][overlay_color]" )->transport = 'postMessage';


        /*=========================================*/
        /* Header Description
        /*=========================================*/
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][header][description]",
                array(
                    'default'        => isset($aOptions['header']['description'])? wp_unslash($aOptions['header']['description']) :'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
             "pi_save_theme_options[theme_options][header][description]",
             array(
                'label' => "Description",
                'des'   => 'Allowed HTML tags: from &lt;i> to &lt;br>, &lt;span>, &lt;b>, &lt;strong>.',
                'section' => 'pi_section_builder',
                'type' => 'text',
                'settings' => "pi_save_theme_options[theme_options][header][description]",
                'priority' => $this->priority++
            ) 
        ));

        $wp_customize->get_setting( "pi_save_theme_options[theme_options][header][description]" )->transport = 'postMessage';

        /*About Us*/
        $this->pi_create_title('pi_section_builder', 'pi_aboutus_title', 'About Us', '#aboutus');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][aboutus][enable]",
                array(
                    'default'        => isset($aOptions['aboutus']['enable'])?$aOptions['aboutus']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        

        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][aboutus][enable]'
            ,array(
                'label'    => __('Enable About Us', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][aboutus][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][aboutus][enable]')->transport='postMessage';

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][aboutus][title]",
                array(
                    'default'        => isset($aOptions['aboutus']['title'])?$aOptions['aboutus']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  
            'pi_save_theme_options[theme_options][aboutus][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][aboutus][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][aboutus][title]')->transport='postMessage';

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][aboutus][description]",
            array(
                'default'        => isset($aOptions['aboutus']['description'])? wp_unslash($aOptions['aboutus']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][aboutus][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][aboutus][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][aboutus][description]')->transport="postMessage";

        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][aboutus][content]", "About us" , "aboutus", "pi_aboutus");
        $this->pi_section_bg("aboutus", "pi_section_builder");


        /*Fun facts*/
        $this->pi_create_title('pi_section_builder', 'pi_funfacts_title', 'Fun facts', '#funfacts');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][funfacts][enable]",
                array(
                    'default'        => isset($aOptions['funfacts']['enable'])?$aOptions['funfacts']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        

        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][funfacts][enable]'
            ,array(
                'label'    => __('Enable Fun facts', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][funfacts][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][funfacts][enable]')->transport='postMessage';

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][funfacts][title]",
                array(
                    'default'        => isset($aOptions['funfacts']['title'])?$aOptions['funfacts']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  
            'pi_save_theme_options[theme_options][funfacts][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][funfacts][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][funfacts][title]')->transport='postMessage';

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][funfacts][description]",
            array(
                'default'        => isset($aOptions['funfacts']['description'])? wp_unslash($aOptions['funfacts']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][funfacts][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][funfacts][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][funfacts][description]')->transport="postMessage";

        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][funfacts][content]", "Fun facts" , "funfacts", "pi_funfacts");
        $this->pi_section_bg("funfacts", "pi_section_builder");
        /*End Fun facts*/


        /*Pricing Table*/
        $this->pi_create_title('pi_section_builder', 'pi_pricing_title', 'Pricing Table', '#pricing');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][pricing][enable]",
                array(
                    'default'        => isset($aOptions['pricing']['enable'])?$aOptions['pricing']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        

        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][pricing][enable]'
            ,array(
                'label'    => __('Enable Fun facts', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][pricing][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][pricing][enable]')->transport='postMessage';

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][pricing][title]",
                array(
                    'default'        => isset($aOptions['pricing']['title'])?$aOptions['pricing']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  
            'pi_save_theme_options[theme_options][pricing][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][pricing][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][pricing][title]')->transport='postMessage';

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][pricing][description]",
            array(
                'default'        => isset($aOptions['pricing']['description'])? wp_unslash($aOptions['pricing']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][pricing][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][pricing][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][pricing][description]')->transport="postMessage";

        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][pricing][content]", "Pricing Table" , "pricing", "pi_pricing");
        $this->pi_section_bg("pricing", "pi_section_builder");
        /*End pricing table*/

        /*Idea*/
        $this->pi_create_title('pi_section_builder', 'pi_idea_title', 'Idea', '#idea');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][idea][enable]",
                array(
                    'default'        => isset($aOptions['idea']['enable'])?$aOptions['idea']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        

        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][idea][enable]'
            ,array(
                'label'    => __('Enable Idea', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][idea][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][idea][enable]')->transport='postMessage';

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][idea][title]",
                array(
                    'default'        => isset($aOptions['idea']['title']) ? $aOptions['idea']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  
            'pi_save_theme_options[theme_options][idea][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][idea][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][idea][title]')->transport='postMessage';

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][idea][description]",
            array(
                'default'        => isset($aOptions['idea']['description'])? wp_unslash($aOptions['idea']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][idea][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][idea][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][idea][description]')->transport="postMessage";

        $wp_customize->add_setting(
            "pi_save_theme_options[theme_options][idea][label]",
            array(
                'default'        => isset($aOptions['idea']['label']) ? $aOptions['idea']['label']:'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );

        $wp_customize->add_control(  
            'pi_save_theme_options[theme_options][idea][label]'
            ,array(
                'label'    => __('Label', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][idea][label]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][idea][label]')->transport='postMessage';


        $wp_customize->add_setting (
            "pi_save_theme_options[theme_options][idea][link]",
            array(
                'default'        => isset($aOptions['link']['label']) ? $aOptions['link']['label']:'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control(  
            'pi_save_theme_options[theme_options][link][label]'
            ,array(
                'label'    => __('Link', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][idea][link]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][idea][link]')->transport='postMessage';

        $this->pi_section_bg("idea", "pi_section_builder");
        /*End idea*/

        /*Skills*/
        $this->pi_create_title('pi_section_builder', 'pi_skills_title', 'Skills', '#skills');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][skills][enable]",
                array(
                    'default'        => isset($aOptions['skills']['enable'])?$aOptions['skills']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        

        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][skills][enable]'
            ,array(
                'label'    => __('Enable Skills', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][skills][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][skills][enable]')->transport='postMessage';

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][skills][title]",
                array(
                    'default'        => isset($aOptions['skills']['title'])?$aOptions['skills']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control(  
            'pi_save_theme_options[theme_options][skills][title]'
            ,array(
                'label'    => __('Skills title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][skills][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][skills][title]')->transport='postMessage';

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][skills][description]",
            array(
                'default'        => isset($aOptions['skills']['description'])? wp_unslash($aOptions['skills']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][skills][description]'
                ,array(
                    'label'    => __('Skills description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][skills][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][skills][description]')->transport="postMessage";
        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][skills][content]", "Our Skills" , "skills", "pi_skill");
        $this->pi_section_bg("skills", "pi_section_builder");

        

        // Team
        $this->pi_create_title('pi_section_builder', 'pi_team_title', 'Team', '#team');

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][team][enable]",
                array(
                    'default'        => isset($aOptions['team']['enable']) ? $aOptions['team']['enable']:0,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][team][enable]'
            ,array(
                'label'    => __('Enable Team', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][team][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][team][enable]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][team][title]",
                array(
                    'default'        => isset($aOptions['team']['title'])?$aOptions['team']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][team][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][team][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][team][title]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][team][description]",
            array(
                'default'        => isset($aOptions['team']['title']) ? wp_unslash($aOptions['team']['title']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][team][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][team][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][team][description]')->transport="postMessage";
        // $section: my parent || $id: this is name of setting || $label: label || $key: $aOptions[$key]['content'] || $posttype
        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][team][content]", "Our team", "team", "pi_ourteam");
        $this->pi_section_bg("team", "pi_section_builder");

       /*Clients*/ 
        $this->pi_create_title('pi_section_builder', 'pi_clients_title', 'Clients', '#clients');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][clients][enable]",
                array(
                    'default'        => isset($aOptions['clients']['enable']) ? $aOptions['clients']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][clients][enable]'
            ,array(
                'label'    => __('Enable clients', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][clients][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][clients][enable]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][clients][title]",
                array(
                    'default'        => isset($aOptions['clients']['title'])?$aOptions['clients']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][clients][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][clients][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][clients][title]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][clients][description]",
            array(
                'default'        => isset($aOptions['clients']['description']) ? wp_unslash($aOptions['clients']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][clients][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][clients][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][clients][description]')->transport="postMessage";
        // $section: my parent || $id: this is name of setting || $label: label || $key: $aOptions[$key]['content'] || $posttype
        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][clients][content]", "Our clients", "clients", "pi_ourclients");
        $this->pi_section_bg("clients", "pi_section_builder");



        /*Testimonial*/
        $this->pi_create_title('pi_section_builder', 'pi_testimonial_title', 'Testimonials', '#testimonials');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][testimonials][enable]",
                array(
                    'default'        => isset($aOptions['testimonials']['enable']) ? $aOptions['testimonials']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][testimonials][enable]'
            ,array(
                'label'    => __('Enable Testimonials', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][testimonials][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][testimonials][enable]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][testimonials][title]",
                array(
                    'default'        => isset($aOptions['testimonials']['title']) ? $aOptions['testimonials']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][testimonials][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][testimonials][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][testimonials][title]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][testimonials][description]",
            array(
                'default'        => isset($aOptions['testimonials']['description']) ? wp_unslash($aOptions['testimonials']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][testimonials][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][testimonials][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][testimonials][description]')->transport="postMessage";
        // $section: my parent || $id: this is name of setting || $label: label || $key: $aOptions[$key]['content'] || $posttype
        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][testimonials][content]", "Testimonials", "testimonials", "pi_testimonials");
        $this->pi_section_bg("testimonials", "pi_section_builder");
        //end testimonial


        /*Twitter*/
        $this->pi_create_title('pi_section_builder', 'pi_twitter_title', 'Twitter', '#twitter');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][twitter][enable]",
                array(
                    'default'        => isset($aOptions['twitter']['enable']) ? $aOptions['twitter']['enable']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][twitter][enable]'
            ,array(
                'label'    => __('Enable Twitter', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][twitter][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][twitter][enable]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][twitter][title]",
                array(
                    'default'        => isset($aOptions['twitter']['title']) ? $aOptions['twitter']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][twitter][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][twitter][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][twitter][title]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][twitter][description]",
            array(
                'default'        => isset($aOptions['twitter']['description']) ? wp_unslash($aOptions['twitter']['description']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][twitter][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][twitter][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][twitter][description]')->transport="postMessage";
        $this->pi_section_bg("twitter", "pi_section_builder");
        /*End Twitter*/


        /*Portfolio*/
       $this->pi_create_title('pi_section_builder', 'pi_portfolio_title', 'Portfolio', '#portfolio');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][portfolio][enable]",
                array(
                    'default'        => isset($aOptions['portfolio']['enable'])?$aOptions['portfolio']['enable']:0,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][portfolio][enable]'
            ,array(
                'label'    => __('Enable Portfolio', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][portfolio][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][portfolio][enable]')->transport="postMessage";


        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][portfolio][title]",
                array(
                    'default'        => isset($aOptions['portfolio']['title'])? wp_unslash($aOptions['portfolio']['title']):'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][portfolio][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][portfolio][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][portfolio][title]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][portfolio][description]",
            array(
                'default'        => isset($aOptions['portfolio']['title']) ? wp_unslash($aOptions['portfolio']['title']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][portfolio][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][portfolio][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][portfolio][description]')->transport="postMessage";
        $this->pi_section_bg("portfolio", "pi_section_builder");

        /*Blog*/
        $this->pi_create_title('pi_section_builder', 'pi_blog_title', 'Blog', '#blog-section');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][blog][enable]",
                array(
                    'default'        => isset($aOptions['blog']['enable'])?$aOptions['blog']['enable']:0,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][blog][enable]'
            ,array(
                'label'    => __('Enable Blog', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][blog][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][blog][enable]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][blog][title]",
                array(
                    'default'        => isset($aOptions['blog']['title'])? wp_unslash($aOptions['blog']['title']):'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][blog][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][blog][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][blog][title]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][blog][description]",
            array(
                'default'        => isset($aOptions['blog']['title']) ? wp_unslash($aOptions['blog']['title']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][blog][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][blog][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][blog][description]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][blog][content]",
            array(
                'default'        => isset($aOptions['blog']['content']) ? wp_unslash($aOptions['blog']['content']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
       $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][blog][content]'
            ,array(
                'label'    => __('Show Posts', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][blog][content]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
       $this->pi_section_bg("blog", "pi_section_builder");

        // Services
        $this->pi_create_title('pi_section_builder', 'pi_services_title', 'Services', '#services');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][services][enable]",
                array(
                    'default'        => isset($aOptions['services']['enable']) ? $aOptions['services']['enable'] : 0,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][services][enable]'
            ,array(
                'label'    => __('Enable Services', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][services][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][services][enable]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][services][title]",
                array(
                    'default'        => isset($aOptions['services']['title'])?$aOptions['services']['title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][services][title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][services][title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][services][title]')->transport="postMessage";

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][services][description]",
            array(
                'default'        => isset($aOptions['services']['title']) ? wp_unslash($aOptions['services']['title']):'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        $wp_customize->add_control( new piTextarea($wp_customize,
                'pi_save_theme_options[theme_options][services][description]'
                ,array(
                    'label'    => __('Description', 'wiloke'),
                    'section'  => 'pi_section_builder',
                    'settings' => 'pi_save_theme_options[theme_options][services][description]',
                    'type'      => 'text',
                    'priority'   => $this->priority++,
                )
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][services][description]')->transport="postMessage";
        // $section: my parent || $id: this is name of setting || $label: label || $key: $aOptions[$key]['content'] || $posttype
        $this->pi_create_other_section("pi_section_builder", "pi_save_theme_options[theme_options][services][content]", "Our services", "services", "pi_services");
        $this->pi_section_bg("services", "pi_section_builder");
       

        // Contact
        $this->pi_create_title('pi_section_builder', 'pi_contact_title', 'Contact', '#contact');
        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][contact][enable]",
                array(
                    'default'        => isset($aOptions['contact']['enable'])?$aOptions['contact']['enable']:0,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][contact][enable]'
            ,array(
                'label'    => __('Enable Contact', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][enable]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][enable]')->transport="postMessage";
        $this->pi_section_bg("contact", "pi_section_builder", "color");

        /*Contact Form*/
        $wp_customize->add_setting (
            "pi_save_theme_options[theme_options][contact][contact_form]",
            array(
                'default'        => isset($aOptions['contact_form'])?$aOptions['contact_form']:'',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][contact][contact_form]'
            ,array(
                'label'    => __('Enable Contact Form', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][contact_form]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][contact_form]')->transport="postMessage";


        $getCf7 = $this->pi_create_contactformseven_setting();
        if ( array_key_exists(-2, $getCf7) )
        {
            $this->pi_create_des("pi_section_builder", "pi_save_theme_options[theme_options][contact][contactform7_shortcode]",$getCf7[-2],$this->priority++);
        }elseif(array_key_exists(-1, $getCf7))
        {
            $this->pi_create_link("pi_section_builder", "pi_save_theme_options[theme_options][contact][contactform7_shortcode]", "?page=wpcf7");
        }else{
            $wp_customize->add_setting(
                "pi_save_theme_options[theme_options][contact][contactform7_shortcode]",
                array(
                    'default'        => isset($aOptions['contactform7_shortcode'])?$aOptions['contactform7_shortcode']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
            );

            $this->wp_customize->add_control(
                'pi_save_theme_options[theme_options][contact][contactform7_shortcode]',
                array(
                    'label'=>__('Contact form 7', 'wiloke'),
                    'type' => 'select',
                    'section'  => 'pi_section_builder',
                    'settings' => "pi_save_theme_options[theme_options][contact][contactform7_shortcode]",
                    'priority'   => $this->priority++,
                    'choices' => $getCf7
                )
            );
        }
        // $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][contactform7_shortcode]')->transport="postMessage";
        /*Contact Info*/
       

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][contact][contact_detail]",
                array(
                    'default'        => isset($aOptions['contact_detail']) ? $aOptions['contact_detail']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][contact][contact_detail]'
            ,array(
                'label'    => __('Enable Contact Info', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][contact_detail]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][contact_detail]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][contact][contact_detail_title]",
                array(
                    'default'        => isset($aOptions['contact_detail_title']) ? $aOptions['contact_detail_title']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][contact][contact_detail_title]'
            ,array(
                'label'    => __('Title', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][contact_detail_title]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][contact_detail_title]')->transport="postMessage";

        $wp_customize->add_setting("pi_set_contact_info");
        $wp_customize->add_control( new piSetContactInfo($wp_customize, 'pi_set_contact_info',array(
                'label'     => "",
                'section'   => 'pi_section_builder',
                'settings'  => 'pi_set_contact_info',
                'data'      => isset($aOptions['contact']) ? $aOptions['contact'] : array(),
                'priority'  => $this->priority++,
            )
        ));

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][contact][enablegooglemap]",
                array(
                    'default'        => isset($aOptions['contact']['enablegooglemap'])?$aOptions['contact']['enablegooglemap']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][contact][enablegooglemap]'
            ,array(
                'label'    => __('Enable GoogleMap', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][enablegooglemap]',
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][enablegooglemap]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][contact][googlemap][latitude]",
                array(
                    'default'        => isset($aOptions['contact']['googlemap']['latitude']) ? $aOptions['contact']['googlemap']['latitude']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            "pi_save_theme_options[theme_options][contact][googlemap][latitude]"
            ,array(
                'label'    => __('Latitude', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][googlemap][latitude]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][googlemap][latitude]')->transport="postMessage";

        $wp_customize->add_setting (
                "pi_save_theme_options[theme_options][contact][googlemap][longitude]",
                array(
                    'default'        => isset($aOptions['contact']['googlemap']['longitude'])?$aOptions['contact']['googlemap']['longitude']:'',
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
        );
        $wp_customize->add_control( 
            'pi_save_theme_options[theme_options][contact][googlemap][longitude]'
            ,array(
                'label'    => __('Longitude', 'wiloke'),
                'section'  => 'pi_section_builder',
                'settings' =>  'pi_save_theme_options[theme_options][contact][googlemap][longitude]',
                'type'      => 'text',
                'priority'   => $this->priority++,
            )
        );
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][googlemap][longitude]')->transport="postMessage";

        $wp_customize->add_setting(
            'pi_save_theme_options[theme_options][contact][googlemap][type]',
            array(
                'default'=>isset($aOptions['contact']['googlemap']['type']) ? $aOptions['contact']['googlemap']['type']:'ROADMAP',
                'type'   => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control('pi_save_theme_options[theme_options][contact][googlemap][type]',
            array(
                'label' => __('Map Type', 'wiloke'),
                'section' => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][googlemap][type]',
                'priority'      => $this->priority++,
                'type' => 'select',
                'choices' => array(
                    'ROADMAP' => 'ROADMAP',
                    'SATELLITE' => 'SATELLITE',
                    'HYBRID'    => 'HYBRID',
                    'TERRAIN' => 'TERRAIN'
                ),
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][googlemap][type]')->transport = 'postMessage';

        $wp_customize->add_setting(
            'pi_save_theme_options[theme_options][contact][googlemap][theme]',
            array(
                'default'=>isset($aOptions['contact']['googlemap']['theme']) ? $aOptions['contact']['googlemap']['theme']:'',
                'type'   => 'option',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $wp_customize->add_control('pi_save_theme_options[theme_options][contact][googlemap][theme]',
            array(
                'label' => __('Map Theme', 'wiloke'),
                'section' => 'pi_section_builder',
                'settings' => 'pi_save_theme_options[theme_options][contact][googlemap][theme]',
                'priority'      => $this->priority++,
                'type' => 'select',
                'choices' =>array('grayscale'=>'grayscale', 'blue'=>'blue', 'dark'=>'dark', 'pink'=>'pink', 'light'=>'light', 'blueessence'=>'blueessence', 'bentley'=>'bentley', 'retro'=>'retro', 'cobalt'=>'cobalt', 'brownie'=>'brownie')
        ));
        $wp_customize->get_setting('pi_save_theme_options[theme_options][contact][googlemap][theme]')->transport = 'postMessage';

        /*Display Custom Section*/
        // $acustomSections =  get_option("pi_custom_section_id_".self::$aCurrentLang);
        $aSectionBuilder =  isset($this->piaOptions['section_builder']) ? $this->piaOptions['section_builder'] : array();
        
        if ( !empty($aSectionBuilder) )
        {
          
            $aSectionBuilder = explode(",", $aSectionBuilder);  
            

            $acustomSections = array_diff($aSectionBuilder, piCore::$piaConfigs['sections']);
            if ( $acustomSections  && !empty($acustomSections) )
            {
                foreach ( $acustomSections as $section_id )
                {
                    $this->pi_create_title('pi_section_builder', 'pi_'.$section_id.'_title', $section_id, '#'.$section_id, "custom_section");
                }
            }
        }

        $wp_customize->add_setting("pi_add_new_section");
        $wp_customize->add_control( new piAddNewSection($wp_customize, 'pi_add_new_section',array(
                'label'     => "",
                'section'   => 'pi_section_builder',
                'settings'  => 'pi_add_new_section',
                'priority'  => $this->priority++,
            )
        ));


        // Footer
        $wp_customize->add_section('pi_change_order', array(
            'title'    => __('Change Order', 'wiloke'),
            'priority' => $this->sectionPriority++,
        ));

        $aDefSection    = array_combine(parent::$piaConfigs['sections'], parent::$piaConfigs['sections_name']);
        $sectionDefault = implode(",", parent::$piaConfigs['sections']);
      
        if ( isset($aOptions['section_builder']) && !empty($aOptions['section_builder']) )
        {
           $ordersection = $aOptions['section_builder'];
        }else{
           $ordersection = $sectionDefault;
        }

        $wp_customize->add_setting ( 
            "pi_save_theme_options[theme_options][section_builder]",
            array(
                'default'        => $ordersection,
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )  
        );
        
        $wp_customize->add_control(new piSortSectionOrder($wp_customize,
                "pi_save_theme_options[theme_options][section_builder]"
                ,array(
                    'label'    => __('Change Order', 'wiloke'),
                    'section'  => 'pi_change_order',
                    'settings' => 'pi_save_theme_options[theme_options][section_builder]',
                    'aOptions' => $aOptions,
                    'priority' => $this->priority++
                )
            )
        );

      

        $wp_customize->get_setting('pi_save_theme_options[theme_options][section_builder]')->transport="postMessage";       
    }  

    public function pi_create_contactformseven_setting()
    {
        $return = array();
        
        if ( !function_exists('is_plugin_active') )
        {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
        }

        if (!is_plugin_active('contact-form-7/wp-contact-form-7.php'))
        {
            $return[-2] = "You must be installed contact form";
        }else{
            $contactForm7 = get_posts( array('post_type'=>'wpcf7_contact_form') );

            if ( !empty($contactForm7) && !is_wp_error($contactForm7) ) :       
                foreach ($contactForm7  as $contactForm) : setup_postdata($contactForm);
                   $return[$contactForm->ID] = get_the_title($contactForm->ID);
                endforeach;
            else :
               $return[-1] = "Error";
            endif;
        }
        return $return;
    }

    public function pi_choose_section($posttype)
    {
        $get = $this->pi_get_custom_post_content($posttype);
        
        $return = array();

        if ( empty($get) )
        {
           $return[-1] = "Opp! There is no post";
        }else{
            foreach ( $get as $k => $post ) : setup_postdata($post);
                $return[$post->ID] = !empty($post->post_title) ? esc_attr( $post->post_title ) : '(no title)'; 
            endforeach;
        }

        return $return;
    }

    public function pi_create_other_section($section,$id,$label,$key,$posttype="")
    {
        $getPost = $this->pi_choose_section($posttype);

        if ( array_key_exists(-1, $getPost) )
        {
            $this->pi_create_link($section, $id, $posttype);
        }else{
            $val = isset($aOptions[$key]['content']) ? wp_unslash($aOptions[$key]['content']) : '';
            $this->wp_customize->add_setting ( 
                $id,
                array(
                    'default'        => $val,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )  
            );
            $this->wp_customize->add_control(
                $id,
                array(
                    'label'=>$label,
                    'type' => 'select',
                    'section'  => 'pi_section_builder',
                    'settings' => $id,
                    'priority'   => $this->priority++,
                    'choices' => $getPost
                )
            );
            // $this->wp_customize->get_setting($id)->transport="postMessage";
        }
    }

    public function pi_create_link($section,$id,$posttype,$title="")
    {
        $this->wp_customize->add_setting($id);
        $this->wp_customize->add_control( new piLinkTo($this->wp_customize, $id
            , array(
                'label'    => $posttype,
                'section'  => $section,
                'settings' => $id,
                'title'    => $title,
                'priority' => $this->priority++,
        )));
    }

    public function pi_text_slider_description_settings($current)
    {
        $total = 0;

        if ( isset($current['description']) && !empty($current['description']) )
        { 
            $total = count($current['description']);
        }


        for ( $i=0; $i<=$total; $i++ )
        {
            $desc =  isset($current['description'][$i]) ? wp_unslash($current['description'][$i]) : "";
            

            $this->wp_customize->add_setting (
                "pi_save_theme_options[theme_options][text_slider][description][$i]",
                array(
                    'default'        => $desc,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
            );

            $this->wp_customize->add_control( new piTextarea($this->wp_customize,
                 "pi_save_theme_options[theme_options][text_slider][description][$i]",
                 array(
                    'label' => "Slogan",
                    'section' => 'pi_section_builder',
                    'type' => 'text',
                    'settings' => "pi_save_theme_options[theme_options][text_slider][description][$i]",
                    'des'   => 'Allowed HTML tags: From &lt;h1> to &lt;h6, &ltspan>, &ltp> ',
                    'priority' => $this->priority++
                ) 
            ));

            $this->wp_customize->get_setting( "pi_save_theme_options[theme_options][text_slider][description][$i]" )->transport = 'postMessage';

            $linkTitle =  isset($current['link_title'][$i]) ? $current['link_title'][$i] : "";
            $this->wp_customize->add_setting (
                "pi_save_theme_options[theme_options][text_slider][link_title][$i]",
                array(
                    'default'        => $linkTitle,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
            );

           

            $this->wp_customize->add_control(  "pi_save_theme_options[theme_options][text_slider][link_title][$i]",array(
                    'label' => "Button Name",
                    'section' => 'pi_section_builder',
                    'type' => 'text',
                    'settings' => "pi_save_theme_options[theme_options][text_slider][link_title][$i]",
                    'priority' => $this->priority++
                
            ) );
            $this->wp_customize->get_setting( "pi_save_theme_options[theme_options][text_slider][link_title][$i]" )->transport = 'postMessage';

            $link =  isset($current['link'][$i]) ? $current['link'][$i] : "";
            $this->wp_customize->add_setting (
                "pi_save_theme_options[theme_options][text_slider][link][$i]",
                array(
                    'default'        => $link,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
            );
            $this->wp_customize->add_control(  "pi_save_theme_options[theme_options][text_slider][link_title][$i]",array(
                    'label' => "Link",
                    'section' => 'pi_section_builder',
                    'type' => 'text',
                    'settings' => "pi_save_theme_options[theme_options][text_slider][link][$i]",
                    'priority' => $this->priority++
                
            ) );
            $this->wp_customize->get_setting( "pi_save_theme_options[theme_options][text_slider][link][$i]" )->transport = 'postMessage';

          
        }
        
        $this->pi_create_button("pi_section_builder", "pi-text_slider-addmore", "Add", "addmore");  
    }

    public function pi_footer_social_settings($aCurrent, $social, $key, $priority)
    {

            if ( $social == 'google_plus' )
            {
                $name = 'Google+';
            }else{
                $name = ucfirst($social);
            }

            $socialLink =  isset($aCurrent[$social]) ? $aCurrent[$social] : "";
            $this->wp_customize->add_setting (
                "pi_save_theme_options[theme_options][$key][social][$social]",
                array(
                    'default'        => $socialLink,
                    'capability'     => 'edit_theme_options',
                    'type'           => 'option',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
            );
            $this->wp_customize->add_control(  "pi_save_theme_options[theme_options][$key][social][$social]",array(
                    'label' => $name,
                    'section' => 'pi_section_builder',
                    'type' => 'text',
                    'settings' => "pi_save_theme_options[theme_options][$key][social][$social]",
                    'priority' => $this->priority++
                
            ) );
            $this->wp_customize->get_setting( "pi_save_theme_options[theme_options][$key][social][$social]" )->transport = 'postMessage';  
    }

    public function pi_create_title($section,$id,$label, $scroll_to="", $custom_section="")
    {
        $this->wp_customize->add_setting($id);
        $this->wp_customize->add_control( new piCreateTitle($this->wp_customize, $id
            , array(
                'label'    => $label,
                'section'  => $section,
                'settings' => $id,
                'scroll_to'=> $scroll_to,
                'priority' => $this->priority++,
                'custom_section' => $custom_section
        )));
    }

    public function pi_create_button($section,$id,$label,$class="")
    {
        $this->wp_customize->add_setting($id);
        $this->wp_customize->add_control( new piCreateButton($this->wp_customize, $id
            , array(
                'label'    => $label,
                'section'  => $section,
                'settings' => $id,
                'priority' => $this->priority++,
        )));
    }

    public function pi_create_des($section,$id,$label,$priority)
    {
        $this->wp_customize->add_setting($id);
        $this->wp_customize->add_control( new piCreateDes($this->wp_customize, $id
            , array(
                'label'    => $label,
                'section'  => $section,
                'settings' => $id,
                'priority' => $priority
        )));
    }

    public function pi_get_tunnar_slider()
    {
        
        if ( !function_exists('is_plugin_active') )
        {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
        }

        if (!is_plugin_active('tunna-slider/tunna-slider.php'))
        {
            return array('error'=>'You must be actived tunnar slider plugin');
        }

        $aTunnaSlider = $this->pi_get_custom_post_content('tunna_slider');

        if ( empty($aTunnaSlider) )
        {
           return array('error'=>'There is no slider, Please go to Tunnar Slider and create a slider');
        }else{
            $aSlides = array();
            foreach ( $aTunnaSlider as $k => $getId ) : setup_postdata($getId);
                $aSlides[$getId->ID] = wp_unslash($getId->post_title);    
            endforeach;wp_reset_postdata();  
            return $aSlides;
        }
    }

    public function pi_get_custom_post_content($posttype)
    {
        if ( empty($posttype) ) die('Post type must  not empty!');

        $aPostMeta = get_posts( array('post_type'=> $posttype) );

        return $aPostMeta;
    }

    public function pi_hidden($section,$id,$label,$priority)
    {
        $this->wp_customize->add_setting($id);
         $this->wp_customize->add_control( new piHidden($this->wp_customize, $id
            , array(
                'label'    => $label,
                'section'  => $section,
                'settings' => $id,
                'priority' => $priority
        )));
    }

    public function pi_section_bg($section, $of_section, $only="")
    { 
        $getData = $this->piaOptions[$section] ? $this->piaOptions[$section] : array();

        if ( $only == "" )
        {
            $bgtype = array(
                'none'  => 'None',
                'image' => 'Image',
                'color' => 'color'
            );
        }else{
            $bgtype = array(
                'none'  => 'None',
                'image' => 'Image'
            );
        }

        $this->wp_customize->add_setting(
            "pi_save_theme_options[theme_options][$section][background]",
            array(
                'default'       =>  isset($getData['background']) && !empty($getData['background']) ? $getData['background'] :'none',
                'type'          => 'option',
                'capability'    => 'edit_theme_options',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $this->wp_customize->add_control("pi_save_theme_options[theme_options][$section][background]",
            array(
                'label'         => __('Background Type', 'wiloke'),
                'section'       => $of_section,
                'settings'      => "pi_save_theme_options[theme_options][$section][background]",
                'priority'      => $this->priority++,
                'type'          => 'select',
                'choices'       => $bgtype
        ));
        $this->wp_customize->get_setting("pi_save_theme_options[theme_options][$section][background]")->transport = 'postMessage'; 
          
        
        $this->wp_customize->add_setting (
            "pi_save_theme_options[theme_options][$section][bg_img]",
            array(
                'default'        => isset($getData['bg_img']) ? $getData['bg_img'] : 'http://placehold.it/1600x1160',
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );

        $this->wp_customize->add_control( new piUploadImages($this->wp_customize, "pi_save_theme_options[theme_options][$section][bg_img]",array(
                'label'     => "Get Image",
                'section'   => $of_section,
                'settings'  => "pi_save_theme_options[theme_options][$section][bg_img]",
                'priority'  => $this->priority++,
                'button_class'=>'section_bg'
            )
        ) );
        $this->wp_customize->get_setting("pi_save_theme_options[theme_options][$section][bg_img]")->transport = 'postMessage'; 


        $this->wp_customize->add_setting (
            "pi_save_theme_options[theme_options][$section][parallax]",
            array(
                'default'        => isset($getData['parallax']) && !empty($getData['parallax']) ? 1 : 0,
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $this->wp_customize->add_control( 
            "pi_save_theme_options[theme_options][$section][parallax]"
            ,array(
                'label'    => __('Enable Parallax', 'wiloke'),
                'section'  => $of_section,
                'settings' => "pi_save_theme_options[theme_options][$section][parallax]",
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
                
            )
        );
        $this->wp_customize->get_setting( "pi_save_theme_options[theme_options][$section][parallax]" )->transport = 'postMessage';

        $this->wp_customize->add_setting (
            "pi_save_theme_options[theme_options][$section][overlay]",
            array(
                'default'        => isset($getData['overlay']) && !empty($getData['overlay']) ? 1 : 0,
                'capability'     => 'edit_theme_options',
                'type'           => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );
        $this->wp_customize->add_control( 
            "pi_save_theme_options[theme_options][$section][overlay]"
            ,array(
                'label'    => __('Enable overlay', 'wiloke'),
                'section'  => $of_section,
                'settings' => "pi_save_theme_options[theme_options][$section][overlay]",
                'type'      => 'checkbox',
                'priority'   => $this->priority++,
                
            )
        );
        $this->wp_customize->get_setting( "pi_save_theme_options[theme_options][$section][overlay]" )->transport = 'postMessage';



        $this->wp_customize->add_setting (
            "pi_save_theme_options[theme_options][$section][hack_section_bg]",
            array(
                'default'           => "",
                'capability'        => 'edit_theme_options',
                'type'              => 'option',
                'sanitize_callback' => array($this, 'pi_sanitize_callback')
            )
        );

        $this->wp_customize->add_control
        (
            new piHidden
            (
                $this->wp_customize, 
                "pi_save_theme_options[theme_options][$section][hack_section_bg]",
                array(
                    'label'     => "Hack Section Background",
                    'section'   => $of_section,
                    'settings'  => "pi_save_theme_options[theme_options][$section][hack_section_bg]",
                    'priority'  => $this->priority++
                )
            )
        );
        $this->wp_customize->get_setting("pi_save_theme_options[theme_options][$section][hack_section_bg]")->transport = 'postMessage'; 

        if ( $only == "" )
        {
            $this->wp_customize->add_setting(
                "pi_save_theme_options[theme_options][$section][overlay_color]",
                array(
                    'default'       =>  isset($getData['overlay_color']) ?    esc_attr($getData['overlay_color']):'rgba(0,0,0,.3)',
                    'type'          => 'option',
                    'capability'    => 'edit_theme_options',
                    'sanitize_callback' => array($this, 'pi_sanitize_callback')
                )
            );
            $this->wp_customize->add_control( 
                new PI_COLOR_PICKER( 
                $this->wp_customize, 
                "pi_save_theme_options[theme_options][$section][overlay_color]",
                array(
                    'label'      => __( 'Color', 'wiloke' ),
                    'section'    => $of_section,
                    'priority'   => $this->priority++,
                    'settings'   => "pi_save_theme_options[theme_options][$section][overlay_color]"
                ) ) 
            );
            $this->wp_customize->get_setting("pi_save_theme_options[theme_options][$section][overlay_color]")->transport = 'postMessage'; 
        }
    }
}


if (class_exists('WP_Customize_Control'))
{
    class piUploadImages extends WP_Customize_Control
    {
        public $type = 'pi-single-image';
        public $desc;
        public $button_class;

        public function render_content()
        {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php if($this->desc!='' || !empty($this->desc)):?><p><?php echo $this->desc;?></p><?php endif;?>
                <div class="form-group upload-logo">
                    <ul class="image-wrap wrap-logo clearfix">
                        
                        <?php 
                            if($this->value()!='') : 
                                if ( preg_match('/([0-9]*),/', $this->value()) ) :
                                    $parseId = explode(",", $this->value());
                                else :
                                    $parseId[0] = $this->value();
                                endif;
                                
                                foreach ( $parseId as $id ) :
                                    $tool = "";
                                    if ( !preg_match("/http/", $id) ) 
                                    {   
                                        $thumbnail = wp_get_attachment_url($id, 'thumbnail');
                                        $fullwidth = wp_get_attachment_url($id);
                                        $tool .=  '<a class="pi-remove is-customize" data-id="'.$id.'" href="#">';
                                        $tool .=    '<span class="dashicons dashicons-no"></span>';
                                        $tool .= '</a>';
                                    }else{
                                        $tool = "";
                                        $thumbnail = $fullwidth = $id;
                                    } 
                        ?>
                                    <li class="attachment">
                                        <img data-src="<?php echo $fullwidth; ?>" class="customize-image" src="<?php echo  $thumbnail; ?>">
                                        <?php echo $tool; ?>
                                    </li>
                        <?php   endforeach;endif; ?>
                    </ul>
                    <br>
                    <button class="btn btn-white upload-img button-primary <?php echo $this->button_class; ?>" data-append=".image-wrap" data-insertlink=".wo-insert-link"><?php _e('Get image', 'wiloke'); ?></button>
                    <input class="insertlink wo-insert-link" type="hidden" <?php $this->link(); ?> value="<?php echo wp_unslash($this->value()); ?>">
                </div>
            </label>
        <?php
        }
    }

    class PI_COLOR_PICKER extends WP_Customize_Control
    {
        public $type = 'pi-colorpicker';
        public $has_lable = false;
        public function render_content() 
        {
            if ( $this->has_lable )
            {
               ?>
            <h4 class="customize-control-title"><?php echo $this->label; ?></h4>
               <?php 
            }
        ?>
            <input type="text" <?php $this->link(); ?> class="pi_color_picker" value="<?php echo $this->value(); ?>">
        <?php
        }
    }

    class piCreateTitle extends WP_Customize_Control {
        public $type = 'pi-title';
        public $scroll_to;
        public $custom_section;
        public function render_content() 
        {
            if ( $this->custom_section == '' ) :
        ?>
            <h4 class="pi-customize-title" data-scrollto="<?php echo $this->scroll_to ?>"><?php echo esc_html( $this->label ); ?></h4>
        <?php
            else :
        ?>
            <h4 class="pi-customize-title pi-is-custom-section" data-key="<?php echo esc_attr($this->label);  ?>" data-scrollto="<?php echo $this->scroll_to ?>"><?php echo "Section id - " . esc_html( $this->label ); ?>
                <span class="pi-remove-custom-section dashicons dashicons-no"></span>
                <span class="pi-edit-custom-section dashicons dashicons-welcome-write-blog"></span>
            </h4>
        <?php 
            endif;
        }
    }

    class piCreateDes extends WP_Customize_Control {
        public $type = 'description';
        public function render_content() {
            ?>
            <p class="pi-description"><?php echo esc_html( $this->label ); ?></p>
        <?php
        }
    }

    class piCreateButton extends WP_Customize_Control
    {
        public $type = 'pi-button';

        public function render_content() 
        {
        ?>
            <button class="pi-button button button-primary"><?php echo esc_html( $this->label ); ?></h4>
        <?php
        }
    }

    class piTextarea extends WP_Customize_Control
    {
        public $type = 'textarea';
        public $des;

        public function render_content()
        {
            ?>
             <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php 
                    if( !empty($this->des) ) 
                    {
                        printf(  ( __( ('<p>%s</p>'), 'wiloke')),  $this->des);
                    }  
                ?>
                <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo stripslashes( $this->value() ); ?></textarea>
            </label>
            <?php 
        }
    }
    
    class piLinkTo extends WP_Customize_Control
    {
        public $type = 'linkto';
        public $label;
        public $title;

        public function render_content()
        {
            $postype = preg_match("#page#", $this->label) ? $this->label : '?post_type='.$this->label;
            ?>
             <label>
                <a href="<?php echo admin_url('edit.php') . $postype ?>" target="blank"><span class="customize-control-title"><?php echo isset($this->title) && !empty($this->title) ? $this->title : __("Opp! There is no post. Click here to create", 'wiloke'); ?></span></a>
            </label>
            <?php 
        }
    }

    class piHidden extends WP_Customize_Control
    {
        public $type='hidden';
        public $label;
        public function render_content()
        {
            ?>
            <input type="hidden" <?php $this->link(); ?> value="<?php echo wp_unslash($this->value()) ?>">
            <?php 
        }
    } 

    class piSortSectionOrder extends WP_Customize_Control
    {
        public $type = 'section-order';
        public $incase;
        public $adefault;

        public function render_content()
        {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <ul id="pi-change_order_section" class="js_section_order wo-sortable">
                    <?php
                        $sections = array();
                        
                        if($this->value()!='')
                        {
                            $sections = explode(',',$this->value());
                        }

                        if( count($sections)>0 ) :
                            $addClass = "";
                            foreach($sections as $section): 
                                if (!empty($section) ) :
                            ?>
                                <li class="item-wrapper" data-name="<?php echo trim($section);?>">
                                    <span class="ui-icon ui-icon-arrowthick"></span><?php echo ucwords($section);?>
                                </li>
                            <?php 
                                endif;
                            endforeach;
                                
                        endif; 
                    ?>
                </ul>
                <input type="hidden" class="section-order" style="width:100%;" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" data-target="<?php echo trim($this->incase); ?>">
            </label>

            <?php
        }
    }

    class piAddSocialIcon extends WP_Customize_Control
    {
        public function render_content()
        {
            include ( get_template_directory() . '/admin/pi-modules/table-fa.php' );
        }
    } 

    /*if wpml installed, show langauge bar*/
    class piShowLanguage extends WP_Customize_Control
    {
        public $type = "pi-language";
        public function render_content()
        {
            if ( defined('ICL_LANGUAGE_CODE') )
            {
                $langs       =  icl_get_languages();
                $home_url    = get_option("siteurl");

                foreach ( $langs as $lang => $info )
                {
                    $return = $home_url . '?lang=' . $lang;
                    $return = urlencode($return);
                    $selected = piCustomize::$aCurrentLang == $lang ? 'active' : '';

                    echo '<a data-lang="'.$lang.'" href="'.admin_url('customize.php?return=?').$return.'" class="'.$selected.'">'.$info['translated_name'].'</a> <br />';
                }
            }else{
                _e('The function is available if you are using wmpl plugin', 'wiloke');
            }
        }
    }

    class piAddNewSection extends WP_Customize_Control
    {
        public $type = "pi-add-new";

        public function render_content()
        {
            echo '<p class="pi-wrap-btn-addnew">';
                echo '<button id="pi-add-new-section" class="button button-primary">'.__('Add New Section', 'wiloke').'</button>';
            echo '</p>';
            echo '<div class="hidden pi-hidden-here">';
            echo '<div id="pi-custom-section-popup" class="pi-wrap-editor add-section pi-popup">';
            echo '<div class="tb-cell">';
            echo '<div class="pi-inner-wrap-editor">';
                echo '<div class="pi-element">';
                    echo '<label class="form-label">';
                    echo '<input type="checkbox" id="pi-enable-section" class="form-control" checked>';
                    echo ' Enable Section</label>';
                echo '</div>';

                echo '<div class="pi-element">';
                    echo '<label class="form-label">Id - required</label>';
                    echo '<input type="text" id="pi-id" class="form-control" required>';
                echo '</div>';

                echo '<div class="pi-element">';
                    echo '<label class="form-label">Title</label>';
                    echo '<input type="text" id="pi-title" class="form-control">';
                echo '</div>';

                echo '<div class="pi-element">';
                    echo '<label class="form-label">Description</label>';
                    echo '<textarea  id="pi-description"  class="form-control"></textarea>';
                echo '</div>';

                echo '<div class="pi-element pi-content">';
                    wp_editor( "", 'pi_custom_section_content', $settings=array('textarea_name'=>'pi_custom_section_content','wpautop'=>false,'textarea_rows'=>60));
                    print_footer_scripts();
                    _WP_Editors::enqueue_scripts();
                    _WP_Editors::editor_js();
                    // _WP_Editors::wp_fullscreen_html();

                echo '</div>';

                echo '<div class="pi-element pi-content panel-body">';
                    piCore::pi_section_background("custom_section");
                echo '</div>';

                echo '<div class="pi-element pi-footer">';
                    echo '<button class="pi-cancel button button-primary">Cancel</button>';
                    echo '<button id="pi-create-section" class="button button-primary">Save</button>';
                echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="back-drop js_backdrop pi-popup-backdrop"></div>';
            echo '</div>';

            include ( get_template_directory() . '/admin/pi-modules/tpl.shortcodes.php' );
        }
    }

    class piFontAwesome extends WP_Customize_Control
    {
        public $type = "pi-fontawesome";

        public function render_content()
        {
           
        }
    }

    class piSetContactInfo extends WP_Customize_Control
    {
        public $type = "pi-contact-info";
        public $data;
        public function render_content()
        {
           ?>
            <button id="pi-set-contact-info" class="button button-primary"><?php _e('Set Contact Info', 'wiloke'); ?></button>

            <div class="hidden pi-hidden-here">
                <div class="pi-wrap-editor pi-popup">
                    <div class="pi-settings">
                       <?php
                            piCore::pi_contact_info($this->data, 'js_change_icon');
                       ?>
                    </div>
                    <div class="pi-fontawesome">
                        <?php 
                            include ( get_template_directory() . '/admin/pi-modules/table-fa.php' );
                        ?>
                    </div>
                    <div class="pi-element pi-footer">
                       <button class="pi-cancel button button-primary"><?php _e('Cancel', 'wiloke');?></button>
                       <button id="pi-save-contact-detail" class="button button-primary"><?php _e('Save', 'wiloke');?></button>
                       <input type="hidden" name="_pi_contact_detail_nonce" value="<?php echo wp_create_nonce("pi_contact_detail_action"); ?>">
                    </div>
                </div>
                <div class="back-drop js_backdrop pi-popup-backdrop"></div>
            </div>
           <?php
        }
    }

    class piShortcodeTpl extends WP_Customize_Control
    {
        public $type = "pi-shortcode-tpl";

        public function render_content()
        {
            include (get_template_directory() . "/admin/pi-modules/tpl.shortcodes.php");
        }
    }
}


