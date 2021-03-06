<div id="blog" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel">

            <div class="panel-heading">
                <div class="panel-title"><?php _e('Blog', 'wiloke');?></div>
            </div>
            
            <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-blog" name="theme_options[blog][enable]" value="1" <?php echo  (isset($aBlog['enable']) && !empty ($aBlog['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div> 
            </div>

            <div class="panel-body"> 

                    <div class="form-group">
                        <label class="form-label"><?php _e('Title', 'wiloke');?></label>
                        <div class="controls">
                            <input type="text" class="form-control" name="theme_options[blog][title]" value="<?php  echo isset($aBlog['title']) ? esc_attr($aBlog['title']) : ""; ?>">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="form-label"><?php _e('Description', 'wiloke');?></label>
                        <div class="controls">
                            <textarea class="form-control" name="theme_options[blog][description]"><?php  echo isset($aBlog['description']) ? esc_attr($aBlog['description']) : ""; ?></textarea>
                        </div>
                    </div>

                   <div class="form-group">
                        <label class="form-label"><?php _e('Show Posts','wiloke');?></label>
                        <div class="controls">
                            <input type="text" class="form-control" name="theme_options[blog][content]" value="<?php  echo isset($aBlog['content']) && !empty($aBlog['content']) ? esc_attr($aBlog['content']) : 6; ?>">
                        </div>
                    </div>
            
                    <?php parent::pi_section_background('blog', $aBlog); ?>
            </div> <!--/end section1 of ourservices -->
        </div>
    </div>
</div>