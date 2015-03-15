 <div id="footer" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="container-12-fluid">
            <div class="container-12-row">
                <div class="large-12">
                                    
                    <div class="panel wo-footer-socials-network">

                        <div class="panel-heading">
                            <div class="panel-title">
                               <?php _e("Social Networks", 'wiloke') ?>
                            </div>
                        </div>
                        
                        <div class="panel-body"> 
                            <h4 for="form-label"><?php _e("Social", 'wiloke') ?></h4>
                            <?php 
                                if ( isset($aFooter['social_link']) && !empty($aFooter['social_link'])  ) :
                                    foreach ($aFooter['social_link'] as $k => $info) :
                            ?>
                            <p class="pi_contactinfo">
                                <a class="js_add_icon" data-issocial="true" href="#" title="Change Icon">
                                    <i class="<?php echo isset($aFooter['social_icon'][$k]) ? $aFooter['social_icon'][$k] : 'fa fa-refresh'; ?>"></i>
                                </a>
                                <input type="hidden" name="theme_options[footer][social_icon][]" value="<?php echo isset($aFooter['social_icon'][$k]) ? $aFooter['social_icon'][$k] : 'fa fa-refresh'; ?>">
                                <input type="text" name="theme_options[footer][social_link][]" placeholder="Link" value="<?php echo  esc_url($info) ?>">
                                <a href="#" class="js_delete_item" title="Delete"><i class="fa fa-times"></i></a>
                            </p>
                            <?php 
                                    endforeach;
                                else :
                            ?>
                            <p class="pi_contactinfo">
                                <a class="js_add_icon" data-issocial="true" href="#">
                                    <i class="fa fa-refresh"></i>
                                </a>
                                <input type="hidden" name="theme_options[footer][social_icon][]" value="fa fa-refresh">
                                <input type="text" name="theme_options[footer][social_link][]" placeholder="Link" value="">
                                <a href="#" class="js_delete_item"><i class="fa fa-times"></i></a>
                            </p>
                            <?php 
                                endif; 
                            ?>
                            <button type="button" class="button js_add_social button-primary"><?php _e("Add", 'wiloke') ?></button>
                        </div>
                    </div>

                    <div class="panel">
                    
                        <div class="panel-body">
                            <label class="form-label"><?php _e('Copyright', 'wiloke'); ?></label>
                            <div class="form-group">
                                <textarea class="form-control" name="theme_options[footer][copyright]"><?php echo isset($aFooter['copyright']) ? htmlspecialchars(stripslashes($aFooter['copyright'])) : ''; ?></textarea>
                            </div>
                        </div> 

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>