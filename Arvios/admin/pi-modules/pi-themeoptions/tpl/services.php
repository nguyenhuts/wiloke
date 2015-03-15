<div id="services" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php _e('Services', 'wiloke'); ?>
                    <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></p>
                </div>
            </div>

             <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-services" name="theme_options[services][enable]" value="1" <?php echo  (isset($aOurServices['enable']) && !empty ($aOurServices['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>



            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[services][title]" value="<?php  echo isset($aOurServices['title']) ? esc_attr($aOurServices['title']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                    <div class="controls">
                        <textarea type="text" class="form-control" name="theme_options[services][description]"><?php  echo isset($aOurServices['description']) ? esc_textarea($aOurServices['description']) : ''; ?></textarea>
                    </div>
                </div>
            </div> <!--/end section1 of ourservices -->

            <div class="panel-body">
               
                <div class="form-group">
                    <label class="form-label"><?php _e('Choose your service', 'wiloke'); ?></label>
                    <div class="controls">
                        <?php
                        $aPostMetaServices = $this->pi_get_custom_post_content('pi_services');

                        if ( empty($aPostMetaServices) )
                        {
                            ?>

                            <p><?php _e('You haven\'t had any post yet.', 'wiloke'); ?>
                                <a  target="_blank" class="help" href="<?php echo admin_url('edit.php'); ?>?post_type=pi_services">Create </a>
                            </p>

                        <?php
                        }else
                        {
                        ?>
                        <select name="theme_options[services][content]" id="">
                            <?php
                            foreach ( $aPostMetaServices as $k => $postService ) : setup_postdata($postService);
                                if (isset($aOurServices['content']) && !empty($aOurServices['content']) && $aOurServices['content'] == $postService->ID )
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
                                <option value="<?php echo $postService->ID; ?>" <?php echo $selected ?> ><?php echo esc_attr($postService->post_title); ?></option>
                            <?php
                            $selected="";
                            endforeach;wp_reset_postdata();
                           
                            ?>
                        </select>
                        <?php  } ?>
                    </div>
                </div>
                <?php parent::pi_section_background('services', $aOurServices); ?>
            </div> <!--/end the section-2 of ourservices-->

        </div>  
    </div> 
</div>    