<?php

/**
 * WP Theme Updater based on the Envato WordPress Toolkit Library and Pixelentity class from ThemeForest forums
 *
 * @package WordPress
 * @link http://themeforest.net/forums/thread/simple-theme-updapi-class-using-envato-api/73278 Thread on ThemeForest Forums
 * @author Pixelentity
 */
class piUpdate extends piCore
{

    const UPDATE_OPTIONS = "pi-update-options";
    public $default_configs;
    public $update_options = array(
        'license_key'   =>  '',
        'active'        =>  false,
        'username'      =>  '',
        'api_key'       =>  '',
    );
    public function __construct()
    {
        $this->default_configs = piCore::$piaConfigs;
        $options = $this->refresh_update_options();
 

        if ( is_admin() )
        {
            add_action('admin_menu', array($this, 'pi_update_menu'));
        }

        if(!empty($options['apikey']) && !empty($options['username']))
        {
            // add_action( "init", array( &$this, "te_check" ) );
            add_filter( "pre_set_site_transient_update_themes", array( &$this, "pi_check" ) );
            // add_filter( "pre_set_site_transient_update_themes", array( &$this, "qva_check" ) );

            if( get_option( 'wpu_update_available' ) )
            {
                add_action( 'admin_notices', array(&$this, 'pi_update_notice') );
            }
        }
    }

    public function pi_update_notice()
    {
        global $pagenow;
        if ($pagenow != 'update-core.php') :
        ?>
        <div class="update-nag">
            <a href="<?php echo admin_url('update-core.php'); ?>"><?php _e('Please Update Arvios new version', 'wiloke'); ?></a>
        </div>
        <?php 
        endif;
    }


    public function pi_update_menu()
    {
        
        $menu = add_theme_page('Update', 'Update', 'edit_theme_options', 'pi-update', array($this, 'pi_intergrate_update'));
        add_action('admin_print_styles-'.$menu, array($this, "pi_extend_themeoptions_style"));
       
    }

    public function pi_extend_themeoptions_style()
    {
        $screen = get_current_screen();

        if ( isset($screen->id) && preg_match('/pi-update/', $screen->id) )
        {  
            $url = get_template_directory_uri() . '/admin/pi-assets/';   
            wp_register_style("update-style", $url . 'css/extend-themeoptions.css', array(), '1.0');
            wp_enqueue_style('update-style');
        }
    }

    public function pi_intergrate_update()
    {
        $aOptions = get_option(self::UPDATE_OPTIONS);

        include ( dirname(__FILE__)  . '/update.php' );
    }

    public function refresh_update_options()
    {
        if(isset($_POST['reset-update'])) delete_option(self::UPDATE_OPTIONS);
        if(isset($_POST['save-update']))
        {
            if(check_admin_referer('wo-update-save','_wpnonce'))
            {
                $options = update_option(self::UPDATE_OPTIONS, $_POST);
            }
        }else {
            $options = get_option(self::UPDATE_OPTIONS);
        }
        return $options;
    }




    /**
     * check fro the updates
     */
    public function pi_check($updates)
    {
        $libDir = get_template_directory() . '/admin/pi-modules/pi-libs/';

        $theme_data = wp_get_theme();
        $authors = array('wiloke');
        $options = $this->refresh_update_options();

        if ( !$options['username'] || !$options['apikey'] || ! isset( $updates->checked ) )
            return $updates;

        if ( ! class_exists( "Envato_Protected_API" ) ) {
            require_once( $libDir."envato-wordpress-toolkit-library/class-envato-protected-api.php" );
        }

        $api = new Envato_Protected_API( $options['username'],$options['apikey'] );
        add_filter( "http_request_args", array( &$this, "http_timeout" ), 10, 1 );
        $purchased = $api->wp_list_themes( true );

        $installed = wp_get_themes();
        $filtered = array();

        foreach ( $installed as $theme ) {
            if ( $authors && ! in_array( $theme->{'Author Name'}, $authors ) )
                continue;
            $filtered[$theme->Name] = $theme;
        }

        foreach ( $purchased as $theme ) {
            if ( isset( $filtered[$theme->theme_name] ) ) {
                // gotcha, compare version now
                $current = $filtered[$theme->theme_name];
                if ( version_compare( $current->Version, $theme->version, '<' ) ) {
                    // bingo, inject the update
                    if ( $url = $api->wp_download( $theme->item_id ) ) 
                    {
                        $update = array(
                            "url"         => "http://themeforest.net/item/theme/{$theme->item_id}",
                            "new_version" => $theme->version,
                            "package"     => $url
                        );

                        $updates->response[$current->Stylesheet] = $update;
                        update_option( 'wpu_update_available', true );
                    }else{
                        update_option( 'wpu_update_available', false );
                    }
                }
            }
        }

        remove_filter( "http_request_args", array( &$this, "http_timeout" ) );

        return $updates;
    }
    /**
     * Increase timeout for api request
     * @param  Array $req
     * @return Array
     */
    public function http_timeout( $req ) {
        $req["timeout"] = 300;
        return $req;
    }
}

