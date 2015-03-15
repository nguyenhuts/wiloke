<div id="idea" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel"> 
            <div class="panel-heading">
                <div class="panel-title">
                    <?php _e('Idea', 'wiloke'); ?>
                    <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></p>
                </div>
            </div>

             <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-services" name="theme_options[idea][enable]" value="1" <?php echo  (isset($aIdea['enable']) && !empty ($aIdea['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[idea][title]" value="<?php  echo isset($aIdea['title']) ? esc_attr($aIdea['title']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                    <div class="controls">
                        <textarea type="text" class="form-control" name="theme_options[idea][description]"><?php  echo isset($aIdea['description']) ? esc_textarea($aIdea['description']) : ''; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Label', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[idea][label]" value="<?php  echo isset($aIdea['label']) ? esc_attr($aIdea['label']) : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php _e('URL', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[idea][link]" value="<?php  echo isset($aIdea['link']) ? esc_url($aIdea['link']) : ''; ?>">
                    </div>
                </div>
                <?php parent::pi_section_background('idea', $aIdea); ?>
            </div> <!--/end section1 of ourservices -->
        </div>  
    </div> 
</div>    