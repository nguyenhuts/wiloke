<div id="testimonials" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel">
 
            <div class="panel-heading">
                <div class="panel-title"><?php _e('Testimonial', 'wiloke'); ?></div>
            </div>
            
            <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-team" name="theme_options[testimonials][enable]" value="1" <?php echo  (isset($aTestimonial['enable']) && !empty ($aTestimonial['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body"> 
                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[testimonials][title]" value="<?php echo isset($aTestimonial['title']) ? esc_attr($aTestimonial['title']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                    <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></p>
                    <div class="controls">
                        <textarea type="text" class="form-control" name="theme_options[testimonials][description]"><?php echo isset($aTestimonial['description']) ? esc_attr($aTestimonial['description']) : ''; ?></textarea>
                    </div>
                </div>

            </div>
                
            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Testimonial','wiloke'); ?></label>
                    <div class="controls">
                        <?php
                        $aPostMetaTeam = $this->pi_get_custom_post_content('pi_testimonials');

                        if ( empty($aPostMetaTeam) )
                        {
                            ?>
                            <p><?php _e('You  haven\'t had any post yet', 'wiloke'); ?>
                                <a target="_blank" class="help" target="_blank" href="<?php echo admin_url('edit.php'); ?>?post_type=pi_testimonials"><?php _e('Create', 'wiloke'); ?></a>
                            </p>
                        <?php
                        }else
                        {
                        ?> 
                        <select name="theme_options[testimonials][content]">
                            <?php
                            foreach ( $aPostMetaTeam as $k => $postExp ) : setup_postdata($postExp);

                                if ( isset($aTestimonial['content']) && !empty($aTestimonial['content']) && $aTestimonial['content'] == $postExp->ID )
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

                <?php parent::pi_section_background('testimonials', $aTestimonial); ?>
            </div> <!--/end panel -->

        </div> <!--/end large-12-->
    </div>
</div>