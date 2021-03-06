<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <?php _e('Blog Header', 'wiloke'); ?>
        </div>    
    </div>
    <div class="panel-body">
        <div class="panel-body wo-flag">
             <div class="form-group">
                <div class="control-button">
                    <div class="slider">
                        <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-background-blog-header" name="theme_options[posts_settings][enable]" value="1" <?php echo  (isset($aPostSettings['enable']) && !empty ($aPostSettings['enable']) ) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><?php _e('Title', 'wiloke');?></label>
            <div class="controls">
                <input type="text" class="form-control" name="theme_options[posts_settings][title]" value="<?php  echo isset($aPostSettings['title']) ? esc_attr($aPostSettings['title']) : ""; ?>">
            </div>
        </div>

        <div class="form-group">
            <?php $bg = isset($aPostSettings['background']) && !empty($aPostSettings['background']) ? $aPostSettings['background'] : get_template_directory_uri()   . '/admin/pi-assets/images/no-img.jpg'; ?>
            <div class="image-wrap">
                <span><img src="<?php echo esc_url($bg); ?>" width="350"></span>
            </div>
            <br>
            <button class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke'); ?></button>
            <input class="insertlink" type="hidden" value="<?php echo  isset($aPostSettings['background']) ? esc_url($aPostSettings['background']) : ""; ?>" name="theme_options[posts_settings][background]">
        </div>
        <div class="form-group">
            <label class="form-label"><?php _e("Overlay Color", "wiloke"); ?></label>
            <div class="controls">
                <input type="text" class="form-control pi_color_picker" name="theme_options[posts_settings][overlay_color]" value="<?php echo isset($aContact['overlay_color']) ? esc_attr($aContact['overlay_color']) : 'rgba(0,0,0,0)';  ?>">
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
                    $csidebar = isset($aPostSettings['choosidebar']) && !empty($aPostSettings['choosidebar']) ? $aPostSettings['choosidebar'] : 'r-sidebar';
                 
                    foreach (parent::$piaConfigs['sidebar'] as $sidebar => $name) :
                        $active = $sidebar == $csidebar ? 'sidebar-active' :'';
                ?>
                <li>
                    <a href="#" class="<?php echo $active ?> choosidebar" data-sidebar="<?php echo $sidebar ?>"><img src="<?php echo $adminImages , $sidebar , '.png'; ?>" alt=""></a>
                    <span><?php echo $name ?></span>
                </li>
                    <?php endforeach; ?>
                <input class="hidden sidebar-value" name="theme_options[posts_settings][choosidebar]" value="<?php echo esc_attr($csidebar) ?>">
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
                <input type="checkbox" id="enable-sharingbox" name="theme_options[posts_settings][sharingbox]" value="1" <?php echo  (isset($aPostSettings['sharingbox']) && !empty ($aPostSettings['sharingbox']) ) ? 'checked' : ''; ?>>
                <label for="enable-sharingbox"><?php _e("Display sharing box", 'wiloke') ?></label>
            </div>
        </div>
    </div>
</div>


<!-- Panel -->
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <?php _e('Post Author', 'wiloke'); ?>
        </div>    
    </div>

    <div class="panel-body">
         <div class="form-group">
            <div class="slider controls">
                <input type="checkbox" id="enable-post-author" name="theme_options[posts_settings][post_author]" value="1" <?php echo  (isset($aPostSettings['post_author']) && !empty ($aPostSettings['post_author']) ) ? 'checked' : ''; ?>>
                <label for="enable-post-author"><?php _e("Post Author", 'wiloke') ?></label>
            </div>
        </div>
    </div>
</div>