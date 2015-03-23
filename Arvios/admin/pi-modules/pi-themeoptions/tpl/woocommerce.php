<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <?php _e('Header', 'wiloke'); ?>
        </div>    
    </div>
    <div class="panel-body">
        <div class="panel-body wo-flag">
             <div class="form-group">
                <div class="control-button">
                    <div class="slider">
                        <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-background-blog-header" name="theme_options[woocommerce][enable]" value="1" <?php echo  (isset($aWoocommerce['enable']) && !empty ($aWoocommerce['enable']) ) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><?php _e('Title', 'wiloke');?></label>
            <div class="controls">
                <input type="text" class="form-control" name="theme_options[woocommerce][title]" value="<?php  echo isset($aWoocommerce['title']) ? esc_attr($aWoocommerce['title']) : ""; ?>">
            </div>
        </div>

        <div class="form-group">
            <?php $bg = isset($aWoocommerce['background']) && !empty($aWoocommerce['background']) ? $aWoocommerce['background'] : get_template_directory_uri()   . '/admin/pi-assets/images/no-img.jpg'; ?>
            <div class="image-wrap">
                <span><img src="<?php echo esc_url($bg); ?>" width="350"></span>
            </div>
            <br>
            <button class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke'); ?></button>
            <input class="insertlink" type="hidden" value="<?php echo  isset($aWoocommerce['background']) ? esc_url($aWoocommerce['background']) : ""; ?>" name="theme_options[woocommerce][background]">
        </div>
        <div class="form-group">
            <label class="form-label"><?php _e("Overlay Color", "wiloke"); ?></label>
            <div class="controls">
                <input type="text" class="form-control pi_color_picker" name="theme_options[woocommerce][overlay_color]" value="<?php echo isset($aContact['overlay_color']) ? esc_attr($aContact['overlay_color']) : 'rgba(0,0,0,0)';  ?>">
            </div>
        </div>
    </div>
</div>


<!-- Panel -->
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <?php _e('Sidebar', 'wiloke'); ?>
        </div>    
    </div>
    <div class="panel-body">
        <div class="form-control">
            <ul class="sidebar-op">
                <?php 
                    $csidebar = isset($aWoocommerce['woocommerce']) && !empty($aWoocommerce['woocommerce']) ? $aWoocommerce['woocommerce'] : 'r-sidebar';
                 
                    foreach (parent::$piaConfigs['sidebar'] as $sidebar => $name) :
                        $active = $sidebar == $csidebar ? 'sidebar-active' :'';
                ?>
                <li>
                    <a href="#" class="<?php echo $active ?> choosidebar" data-sidebar="<?php echo $sidebar ?>"><img src="<?php echo $adminImages , $sidebar , '.png'; ?>" alt=""></a>
                    <span><?php echo $name ?></span>
                </li>
                    <?php endforeach; ?>
                <input class="hidden sidebar-value" name="theme_options[woocommerce][choosidebar]" value="<?php echo esc_attr($csidebar) ?>">
            </ul>

        </div>
    </div>
</div>

<!-- Panel -->
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <?php _e('Sharing Box', 'wiloke'); ?>
        </div>    
    </div>

    <div class="panel-body">
         <div class="form-group">
            <div class="slider controls">
                <input type="checkbox" id="enable-woocommerce-sharingbox" name="theme_options[posts_settings][woocommerce]" value="1" <?php echo  (isset($aWoocommerce['woocommerce']) && !empty ($aWoocommerce['woocommerce']) ) ? 'checked' : ''; ?>>
                <label for="enable-woocommerce-sharingbox"><?php _e("Display sharing box", 'wiloke') ?></label>
            </div>
        </div>
    </div>
</div>
