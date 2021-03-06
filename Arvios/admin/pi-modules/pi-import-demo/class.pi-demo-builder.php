<?php 
class piImportDemoBuilder extends piCore
{
    public $piaDefaultConfigs = array();
    public $importMenuSlug = "pi-import-demo";

    public function __construct()
    {
        add_action('admin_menu', array($this, 'pi_add_submenu'));
        add_action('admin_enqueue_scripts', array($this, 'pi_enqueue_scripts'));
        add_action('wp_ajax_wiloke-import', array($this, 'pi_parse_before_import')); 
    }

    
    public function pi_enqueue_scripts()
    {
        $screen = get_current_screen();

        if ( isset($screen->id) && preg_match('/pi-import-demo/', $screen->id) )
        {  
            $url = get_template_directory_uri() . '/admin/pi-assets/';
            wp_register_script('pi-import', $url . 'js/pi.import-demo.js', array(), '1.0', true);
            wp_enqueue_script('pi-import');
        }
    }

    public function pi_add_submenu()
    {
        add_theme_page('Import Demo', 'Import Demo', 'edit_theme_options', 'pi-import-demo', array($this, 'pi_setting_demo'));  
    }

    public function pi_setting_demo()
    {
        include ( dirname(__FILE__) . '/tpl.demo-builder.php' );
    }

    public function pi_parse_before_import()
    {
        if ( check_ajax_referer('wo-nonce', '_wp_nonce') && isset($_REQUEST['_wp_http_referer']) &&  preg_match("/page={$this->importMenuSlug}/i",$_REQUEST['_wp_http_referer']) )
        {
           
            $dir = get_template_directory() . '/admin/pi-modules/';
            $importFile = 'demo_data.xml';
            $optionsFile = 'arvios-options.php';

            if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
                require_once ABSPATH . 'wp-admin/includes/import.php';
            $importer_error = false;
            if ( !class_exists( 'WP_Importer' ) ) {
                $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
                if ( file_exists( $class_wp_importer ) ){
                    require_once($class_wp_importer);
                }
                else{
                    $importer_error = true;
                }
            }

            if ( !class_exists( 'WP_Import' ) ) {
                $class_wp_import = $dir . 'pi-libs/wp-importer/class.wp-importer.php';
                if ( file_exists( $class_wp_import ) )
                    require_once($class_wp_import);
                else
                    $importerError = true;
            } 

            if($importer_error){
                echo "<div class=\"alert-box alert-error\"><strong>Error!</strong> The Auto importing script could not be loaded. please use the wordpress importer and import the XML file that is located in your themes folder manually. :(</div>";
                exit();
            }else{
                if ( class_exists( 'WP_Import' ))
                {
                    include_once( $dir  . 'pi-import-demo/class.import-demo-data.php');
                }
                if(!is_file( $dir . 'pi-import-demo/'.$importFile)){
                    echo "<div class=\"alert-box alert-error\"><strong>Error!</strong> The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually :(</div>";
                    exit();
                }
                else{  
                    $wp_import = new piImport(piCore::$piaConfigs);
                    $wp_import->remove_all_posts();
                    $wp_import->fetch_attachments = true;
                    $wp_import->import( $dir . 'pi-import-demo/'.$importFile );
                    $wp_import->set_widgets();
                    $wp_import->checkMenuExists();
                    $wp_import->set_menus();
                    $wp_import->set_static_page();
                    $wp_import->update_theme_options($optionsFile);
                    $wp_import->pi_set_aboutus();
                    $wp_import->set_contact_form();
                    $wp_import->pi_reupdate_theme_options();
                }

                echo "<div class=\"alert-box alert-success\"><strong>Success!</strong> Import Demo Ok :))</div>";
            }
        }else{
            echo '<div class="alert-box alert-error">Opp! Import Error:(</div>';
        }

        die();
    }
}

