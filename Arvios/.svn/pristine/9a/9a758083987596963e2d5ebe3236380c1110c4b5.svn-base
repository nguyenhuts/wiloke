<div class="panel-heading">
    <div class="panel-title"><?php _e('404 Page', 'wiloke'); ?></div>
</div>

<div class="panel-body">
    <h4><?php _e('Background', 'wiloke'); ?></h4>
    <div class="form-group">
        <?php $pnfBg = isset($aPageNotFound['background']) && !empty($aPageNotFound['background']) ? $aPageNotFound['background'] : get_template_directory_uri()   . '/admin/pi-assets/images/no-img.jpg'; ?>
        <div class="image-wrap">
            <span><img src="<?php echo esc_url($pnfBg); ?>" width="350"></span>
        </div>
        <br>
        <a class="button button-primary upload-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke'); ?></a>
        <input class="insertlink" type="hidden" value="<?php echo  isset($aPageNotFound['background']) ? esc_url($aPageNotFound['background']) : ""; ?>" name="theme_options[404][background]">
    </div>
</div>
