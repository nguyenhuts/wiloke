<div id="skills" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel">

            <div class="panel-heading">
                <div class="panel-title"><?php _e('Skills', 'wiloke'); ?></code>
                   
                </div>
            </div>

            <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-skills" name="theme_options[skills][enable]" value="1" <?php echo  (isset($aSkills['enable']) && !empty ($aSkills['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke');?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[skills][title]" value="<?php echo isset($aSkills['title']) ? esc_attr($aSkills['title']) : ''; ?>">
                    </div>
                </div>
 
                <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                    <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></p>
                    <div class="controls">
                        <textarea type="text" class="form-control" name="theme_options[skills][description]"><?php echo isset($aSkills['description']) ? esc_textarea($aSkills['description']) : ''; ?></textarea>
                    </div>
                </div>

            </div>
                
            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Choose your skills', 'wiloke'); ?></label>
                    <div class="controls">
                        <?php
                        $aPostMetaSkills = $this->pi_get_custom_post_content('pi_skill');

                       

                        if ( empty($aPostMetaSkills) )
                        {
                            ?>
                            <p><?php _e('You  haven\'t had any post yet', 'wiloke'); ?>
                                <a  target="_blank" class="help" href="<?php echo admin_url('edit.php'); ?>?post_type=pi_skill"><?php _e('Create', 'wiloke'); ?></a>
                            </p>
                        <?php
                        }else
                        {
                        ?> 
                        <select name="theme_options[skills][content]">
                            <?php
                            foreach ( $aPostMetaSkills as $k => $postExp ) : setup_postdata($postExp);

                                if ( isset($aSkills['content']) && !empty($aSkills['content']) && $aSkills['content'] == $postExp->ID )
                                {
                                    $selected = 'selected';
                                }else{
                                    if ($k == 0)
                                    {
                                        $selected = 'selected';
                                    }else{
                                        $selected = '';
                                    }
                                }

                                ?>
                                <option value="<?php echo $postExp->ID; ?>" <?php echo $selected ?> ><?php echo esc_attr( $postExp->post_title ); ?></option>
                            <?php
                            $selected="";
                            endforeach;wp_reset_postdata();
                            ?>
                        </select>
                         <?php 
                            }
                        ?>
                    </div>
                </div>
           
            <?php parent::pi_section_background('skills', $aSkills); ?>
            </div>

        </div> <!--/end large-12-->
    </div>
</div>