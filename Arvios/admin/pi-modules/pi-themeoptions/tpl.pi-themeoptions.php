<?php
/*
 * author: wiloke && phan tien hien
 * author uri: wiloke.com
 * date: 05/01/2014
 * time: 12:40 PM
 */

$aOptions        = self::$piOptions;
$aWoocommerce    = isset($aOptions['woocommerce']) ? $aOptions['woocommerce'] : ''; 
$aPostSettings   = isset($aOptions['posts_settings']) ? $aOptions['posts_settings'] : ''; 
$aTestimonial    = isset($aOptions['testimonials']) ? $aOptions['testimonials'] : ''; 
$aTwitter        = isset($aOptions['twitter']) ? $aOptions['twitter'] : '';
$aOurServices    = isset($aOptions['services']) ? $aOptions['services'] : '';
$aPricing        = isset($aOptions['pricing']) ? $aOptions['pricing'] : '';
$aIdea           = isset($aOptions['idea']) && !empty($aOptions['idea']) ? $aOptions['idea'] : '';
$aFunfacts       = isset($aOptions['funfacts']) && !empty($aOptions['funfacts']) ? $aOptions['funfacts'] : '';
$aAboutUs        = isset($aOptions['aboutus']) && !empty($aOptions['aboutus']) ? $aOptions['aboutus'] : '';
$aSkills         = isset($aOptions['skills']) && !empty($aOptions['skills']) ? $aOptions['skills'] : '';

$aDesign         = isset($aOptions['design']) && !empty($aOptions['design']) ? $aOptions['design'] : '';
$aTeam           = isset($aOptions['team']) && !empty($aOptions['team']) ? $aOptions['team'] : '';
$aPortfolio      = isset($aOptions['portfolio']) && !empty($aOptions['portfolio']) ? $aOptions['portfolio'] : '';
$aClients        = isset($aOptions['clients']) && !empty($aOptions['clients']) ? $aOptions['clients'] : '';
$aContact        = isset($aOptions['contact']) && !empty($aOptions['contact']) ? $aOptions['contact'] : '';
$aFooter         = isset($aOptions['footer']) && !empty($aOptions['footer']) ? $aOptions['footer'] : '';
$aHeader         = isset($aOptions['header']) && !empty($aOptions['header']) ? $aOptions['header'] : '';
$aTextSlider     = isset($aOptions['text_slider']) && !empty($aOptions['text_slider']) ? $aOptions['text_slider'] : '';
$aSocial         = isset($aOptions['social']) && !empty($aOptions['social']) ? $aOptions['social'] : '';
$aBlog           = isset($aOptions['blog']) && !empty($aOptions['blog']) ? $aOptions['blog'] : '';
$aLogo           = isset($aOptions['logo'])  && !empty($aOptions['logo']) ? $aOptions['logo'] : '';
$aFT             = isset($aOptions['favicon_touch'])  && !empty($aOptions['favicon_touch']) ? $aOptions['favicon_touch'] : '';
$sBuilderSection = isset($aOptions['section_builder']) && !empty($aOptions['section_builder']) ? $aOptions['section_builder'] : '';
$aPageNotFound   = isset($aOptions['404'])  && !empty($aOptions['404']) ? $aOptions['404'] : '';
$aBlog           = isset($aOptions['blog'])  && !empty($aOptions['blog']) ? $aOptions['blog'] : '';
$aCustomcode     = isset($aOptions['customcode'])  && !empty($aOptions['customcode']) ? $aOptions['customcode'] : '';

$adminImages = get_template_directory_uri()  . '/admin/pi-assets/images/';


?>

<!-- <div id="qva-settings" class="alert alert-success" style="display:none">Successfully!</div> -->
<div class="fl-wrapper" style="padding-top: 20px">
    <div class="container-12-fluid">
        <div class="container-12-row">
            <div class="large-12">
                <div id="pi-success" class="alert alert-success" style="display:none"><?php _e("Success!", 'wiloke') ?></div>
                <div id="pi-empty-data" class="alert alert-danger" style="display:none"><?php _e("Opp, Something go to error", 'wiloke') ?></div>
            </div>
        </div>
    </div>
</div>


<form action="" method="POST">

<?php  wp_nonce_field("process-save-options", "init-save-options"); ?>

<div id="main-tab" class="fl-wrapper main-tab">

    <ul class="main-ui">
        <li><a href="#main-1"><?php _e("General", 'wiloke') ?></a></li>
        <li><a href="#main-2">Design</a></li>
        <li><a href="#main-3"><?php _e("Import-Export", 'wiloke') ?></a></li>
    </ul>

    <div id="main-1" class="main-tabs-panel">
        <div id="inner-tab" class="inner-tab">
            <div class="menu-left">
                <ul class="tab-left"> 
                    <li><a href="#basic"><i class="fa fa-wrench"></i><?php _e("Basic", 'wiloke') ?></a></li>
                    <li><a href="#section"><i class="fa fa-laptop"></i><?php _e("Section", 'wiloke') ?></a></li>
                    <li><a href="#sectionbuilder"><i class="fa fa-laptop"></i><?php _e("Section Builder", 'wiloke') ?></a></li>
                    <li><a href="#postssettings"><i class="fa fa-file-zip-o"></i><?php _e("Posts Settings", 'wiloke') ?></a></li>
                    <?php if ( is_plugin_active('woocommerce/woocommerce.php') ) : ?>
                    <li><a href="#woocommerce"><i class="fa fa-money"></i><?php _e("Woocommerce", 'wiloke') ?></a></li>
                    <?php endif; ?>
                    <li><a href="#pagenotfound"><i class="fa fa-file-zip-o"></i><?php _e("404", 'wiloke') ?></a></li>
                    <li><a href="#customcode"><i class="fa fa-code"></i><?php _e("Custom Code", 'wiloke') ?></a></li>
                    <li><a href="#rateit"><span></span><?php _e("Rate Arvios", 'wiloke') ?></a></li>
                </ul>
            </div>

            <div id="rateit" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <p class="alert alert-danger">
                                            <?php _e('If you feel contented with our theme and  support service, don\'t hesitate to leave us <a target="_blank" href="http://themeforest.net/downloads?ref=wiloke" style="color:green"><strong> 5 stars</strong></a>. If you\'re about to rate less than 5 stars,  please let us know what we shoud do to improve our theme.', 'wiloke') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="basic" class="inner-tabs-panel">
               <?php include ("tpl/general.php"); ?>
            </div>

            <div id="section" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <div class="wo-wrap-subtabs">
                                    <ul class="wo-subtabs">
                                        <li><a href="#header"><?php _e('Introduction Screen', 'wiloke'); ?></a></li>
                                        <li><a href="#aboutus"><?php _e('About Us', 'wiloke'); ?></a></li>  
                                        <li><a href="#services"><?php _e('Services', 'wiloke'); ?></a></li>   
                                        <li><a href="#funfacts"><?php _e('Fun Facts', 'wiloke'); ?></a></li>     
                                        <li><a href="#idea"><?php _e('Idea', 'wiloke'); ?></a></li>
                                        <li><a href="#team"><?php _e('Team', 'wiloke'); ?></a></li>
                                        <li><a href="#skills"><?php _e('Skills', 'wiloke'); ?></a></li>
                                        <li><a href="#portfolio"><?php _e('Portfolio', 'wiloke'); ?></a></li>
                                        <li><a href="#clients"><?php _e('Clients', 'wiloke'); ?></a></li>
                                        <li><a href="#testimonials"><?php _e('Testimonials', 'wiloke'); ?></a></li>
                                        <li><a href="#pricing"><?php _e('Pricing Table', 'wiloke'); ?></a></li>
                                        <li><a href="#twitter"><?php _e('Twitter', 'wiloke'); ?></a></li>
                                        <li><a href="#blog"><?php _e('Blog', 'wiloke'); ?></a></li>
                                        <li><a href="#contact"><?php _e('Contact', 'wiloke'); ?></a></li>
                                        <li><a href="#footer"><?php _e('Footer', 'wiloke'); ?></a></li>
                                    </ul>
                               
                                    <div class="wo-subtabs-content">    
                                        <?php 
                                            $aFiles = array("header.php", "aboutus.php", "funfacts.php", "skills.php", "clients.php", "portfolio.php","contact.php", "team.php", "idea.php", "services.php", "footer.php", "blog.php", "pricing-table.php", "twitter.php", "testimonial.php");

                                            foreach ($aFiles as $file)
                                            {
                                                include ( dirname(__FILE__) . '/tpl/' . $file );
                                            }
                                        ?>  
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="sectionbuilder" class="inner-tabs-panel"> 
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <!-- Panel -->
                                <div class="panel">

                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <?php _e('Section Builder', 'wiloke'); ?> 
                                        </div>
                                    </div>

                                    <div class="panel-body clearfix">
                                        <div class="ui-widget ui-helper-clearfix">
                                            <?php include( dirname(__FILE__) . '/tpl/section-builder.php' ); ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div id="postssettings" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <?php include( dirname(__FILE__) . '/tpl/posts-settings.php' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ( is_plugin_active('woocommerce/woocommerce.php') ) : ?>
            <div id="woocommerce" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <?php include( dirname(__FILE__) . '/tpl/woocommerce.php' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div id="pagenotfound" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <div class="panel">
                                    <?php include( dirname(__FILE__) . '/tpl/404.php' ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="customcode" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <div class="panel">

                                    <div class="panel-body">
                                        <h3><?php _e('Header Code', 'wiloke'); ?></h3>
                                        <div class="form-group">
                                            <textarea class="form-control" name="theme_options[customcode][header]"><?php echo isset($aCustomcode['header']) ? htmlspecialchars(stripslashes($aCustomcode['header'])) : ''; ?></textarea>
                                            <code class="help"><?php _e('The code will be included before &lt/header> tags. Allow use all html tags', 'wiloke'); ?></code>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <h3><?php _e('Footer Code', 'wiloke'); ?></h3>
                                        <div class="form-group">
                                            <textarea class="form-control" name="theme_options[customcode][footer]"><?php echo isset($aCustomcode['footer']) ? htmlspecialchars(stripslashes($aCustomcode['footer'])) : ''; ?></textarea>
                                            <code class="help"><?php _e('The code will be included before &lt/body> tags Allow use all html tags', 'wiloke'); ?></code>
                                        </div>
                                    </div>

                                    <div class="panel-body">
                                        <h3><?php _e('Css Code', 'wiloke'); ?></h3>
                                        <div class="form-group">
                                            <textarea class="form-control" name="theme_options[customcode][css]"><?php echo isset($aCustomcode['css']) ? htmlspecialchars(stripslashes($aCustomcode['css'])) : ''; ?></textarea>
                                            <code class="help"><?php _e('Without &ltstyle> tag', 'wiloke'); ?></code>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div id="main-2" class="main-tabs-panel">
        <div id="inner-tab1" class="inner-tab"> 
           <?php include ( 'tpl/design.php' ); ?>
        </div>
    </div>
   
    <div id="main-3" class="main-tabs-panel">
        <div id="inner-tab1" class="inner-tab">

            <div class="menu-left">
                <ul class="tab-left">
                    <li><a href="#imex"><i class="fa fa-cloud-upload"></i><?php _e('Import/Export', 'wiloke'); ?></a></li>
                </ul>   
            </div>


            <div id="imex" class="inner-tabs-panel">
                <div class="inner-content">
                    <div class="container-12-fluid">
                        <div class="container-12-row">
                            <div class="large-12">
                                <!-- Panel -->
                                <div class="panel">
                                       
                                        <div class="panel-body">
                                            <h3><?php _e('Import your settings', 'wiloke'); ?></h3>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <textarea class="form-control data-import" name="data-import"></textarea>
                                                    <br>
                                                    <input type="submit" name="import-theme-options" class="btn btn-red import-theme-options red" value="Import">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <h3><?php _e('Export', 'wiloke'); ?></h3>
                                            <div class="form-group">
                                                <?php 
                                                    $exOptions['theme_options'] = self::$piOptions;
                                                    $export = serialize($exOptions); 
                                                ?>
                                                <textarea class="form-control"><?php echo $export; ?></textarea>
                                                <input type="hidden" name="_wo_nonce" value="<?php echo wp_create_nonce("qva-secure") ?>">
                                               <?php  wp_referer_field(); ?>
                                               <br>
                                               <input type="submit" name="export-theme-options" class="btn btn-red export-theme-options red" value="Save to file">
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/#imex -->
    </div>

</div>
<div class="button-footer">
    <div class="wo-wrap-button container-12-fluid">
        <div class="form-group">
            <button type="submit" name="pi-save-options" value="Save" class="btn btn-red"><?php _e('Save', 'wiloke'); ?></button>
            <!-- <button type="submit" class="btn btn-black">Reset</button> -->
        </div>
    </div>
</div>
<input type="hidden" value="<?php echo isset($_GET['lang']) ? $_GET['lang'] : '' ?>" id="pi_current_lang">
</form><!-- form -->

<div class="pi-saving" style="display:none">
    <img src="<?php echo get_template_directory_uri() . '/admin/pi-assets/images/saving.gif' ?>">
</div>

<?php 

include ( get_template_directory() . '/admin/pi-modules/table-fa.php' );

do_action('pi_theme_options');