<div class="inner-content">
    <div class="container-12-fluid">
        <div class="container-12-row">
            <div class="large-12">

                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">
                           <?php _e("Preload", 'wiloke') ?> 
                        </div>
                    </div>

                    <div class="panel-body wo-flag"> 
                        <div class="form-group">
                            <div class="control-button">
                                <div class="slider">
                                    <input type="checkbox" id="enable-preload" class="toggle-settings pi_switch_button"  name="theme_options[preload][enable]" value="1" <?php echo  (isset($aOptions['preload']['enable']) && !empty ($aOptions['preload']['enable']) ) ? 'checked' : ''; ?> >
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">
                           <?php _e("Logo", 'wiloke') ?>
                        </div>
                    </div>
                    <div class="panel-body wo-flag"> 
                        <div class="form-group">
                            <div class="control-button">
                                <div class="slider">
                                    <input type="checkbox" id="enable-header" class="toggle-settings pi_switch_button"  name="theme_options[logo][enable]" value="1" <?php echo  (isset($aLogo['enable']) && !empty ($aLogo['enable']) ) ? 'checked' : ''; ?> >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group upload-logo">
                            <?php $logoImage = isset($aLogo['logo_nav']) && !empty($aLogo['logo_nav']) ? $aLogo['logo_nav'] : $adminImages  . 'logo.png'; ?>
                            <div class="image-wrap wrap-logo">
                                <span><img src="<?php echo esc_url($logoImage); ?>" ></span>
                            </div>
                            <br>
                            <button class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e("Get image", 'wiloke') ?></button>
                            <input class="insertlink" type="hidden" value="<?php echo  esc_url($logoImage); ?>" name="theme_options[logo][logo_nav]">
                        </div>
                        
                        
                        <div class="form-group upload-logo">
                            <label class="form-label"><?php _e("Retina", 'wiloke') ?></label>
                            <?php $retinaLogo = isset($aLogo['retina_logo']) && !empty($aLogo['retina_logo']) ? $aLogo['retina_logo'] : $adminImages  . 'logo.png'; ?>
                            <div class="image-wrap wrap-logo">
                                <span><img src="<?php echo esc_url($retinaLogo); ?>" ></span>
                            </div>
                            <br>
                            <button class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e("Get image", 'wiloke') ?></button>
                            <input class="insertlink" type="hidden" value="<?php echo  esc_url($retinaLogo); ?>" name="theme_options[logo][retina_logo]">
                        </div>

                    </div>
                </div>
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">
                           <?php _e("Favicon & Touch", 'wiloke') ?> 
                        </div>
                    </div>

                    <div class="panel-body wo-flag"> 
                        <div class="form-group">
                            <div class="control-button">
                                <div class="slider">
                                    <input type="checkbox" id="enable-header" class="toggle-settings pi_switch_button"  name="theme_options[favicon_touch][enable]" value="1" <?php echo  (isset($aFT['enable']) && !empty ($aFT['enable']) ) ? 'checked' : ''; ?> >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <h4><?php _e("Favicon", 'wiloke') ?></h4>
                        <div class="form-group">
                            <?php $logoImage = isset($aFT['favicon']) && !empty($aFT['favicon']) ? $aFT['favicon'] : $adminImages  . 'favicon.ico'; ?>
                            <div class="image-wrap wrap-logo">
                                <span><img src="<?php echo esc_url($logoImage); ?>" ></span>
                            </div>
                            <br>
                            <button class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e("Get image", 'wiloke') ?></button>
                            <input class="insertlink" type="hidden" value="<?php echo  esc_url($logoImage); ?>" name="theme_options[favicon_touch][favicon]">
                        </div>
                        
                        <h4><?php _e("Touch", 'wiloke') ?></h4>
                         <div class="form-group">
                            <?php $logoImage = isset($aFT['touch']) && !empty($aFT['touch']) ? $aFT['touch'] : $adminImages  . 'touch.png'; ?>
                            <div class="image-wrap wrap-logo">
                                <span><img src="<?php echo esc_url($logoImage); ?>" ></span>
                            </div>
                            <br>
                            <button class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e("Get image", 'wiloke') ?></button>
                            <input class="insertlink" type="hidden" value="<?php echo  esc_url($logoImage); ?>" name="theme_options[favicon_touch][touch]">
                        </div>


                    </div>
                </div> 

                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">
                           <?php _e("Menu", 'wiloke') ?> 
                        </div>
                    </div>

                   
                    <div class="panel-body">
                        <h4><?php _e("Menu Config", 'wiloke') ?></h4>
                        
                        <div class="form-group">
                            <div class="controls">
                                <label class="form-label"><?php _e("Show three line menu  (☰)   if the browser’s viewport is smaller than", "wiloke") ?></label>
                                <input class="form-control" type="text" value="<?php echo isset($aOptions['menu_config']) ? esc_attr($aOptions['menu_config']) : 1300; ?>" name="theme_options[menu_config]" placeholder="Ex: 1300">
                                <p></p>
                                <code><?php _e('Unit - pixel', 'wiloke');?></code>
                            </div>
                        </div>
                    </div>
                </div> 

            </div>
        </div>
    </div>
</div>