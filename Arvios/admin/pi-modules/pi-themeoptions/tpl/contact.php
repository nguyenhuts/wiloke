<div id="contact" class="inner-tabs-panel">
    <div class="inner-content"> 
        <div class="panel">
        <div class="panel-heading">
            <div class="panel-title"><?php _e('Contact', 'wiloke'); ?>
                <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></p>
            </div>
        </div>  

        <div class="panel-body wo-flag">
            <div class="form-group">
                <div class="control-button">
                    <div class="slider">
                        <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-contact" name="theme_options[contact][enable]" value="1" <?php echo  (isset($aContact['enable']) && !empty ($aContact['enable']) ) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel-body">
            <div class="form-group">
                <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                <div class="controls">
                    <input type="text" class="form-control" name="theme_options[contact][title]" value="<?php echo isset($aContact['title']) ? esc_attr($aContact['title']) : '';  ?>">
                </div>
            </div>

            <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                    <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></p>
                    <div class="controls">
                        <textarea class="form-control" name="theme_options[contact][description]"><?php  echo isset($aContact['description']) ? esc_textarea($aContact['description']) : ""; ?></textarea>
                    </div>
            </div>
        </div>

        <div class="panel-body"> 
            <div class="form-group wo-flag">
                <div class="slider">
                    <input type="checkbox" id="enable-contactform" class="toggle-settings pi_switch_button" name="theme_options[contact][contact_form]" value="1" <?php echo  (isset($aContact['contact_form']) && !empty ($aContact['contact_form']) ) ? 'checked' : ''; ?>>
                     <label class="form-label" for="enable-contactform"><?php _e('Contact Form', 'wiloke'); ?></label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><?php _e('Contact Form 7', 'wiloke'); ?></label>
                <div class="controls">
                    <?php
                    if (!is_plugin_active('contact-form-7/wp-contact-form-7.php'))
                    {
                        echo '<span class="help">You need <code> Contact Form 7 </code> plugin installed</span>';
                    }else{
                        $contactForm7 = get_posts( array('post_type'=>'wpcf7_contact_form') );

                        if ( !empty($contactForm7) && !is_wp_error($contactForm7) ) :
                        ?>
                    <?php
                            echo '<select name="theme_options[contact][contactform7_shortcode]">';
                            foreach ($contactForm7  as $contactForm) : setup_postdata($contactForm);
                                $checked = isset($aContact['contactform7_shortcode']) && ($aContact['contactform7_shortcode'] == $contactForm->ID) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $contactForm->ID ?>" <?php echo $checked; ?>><?php echo get_the_title($contactForm->ID) ?></option>
                                <?php
                            endforeach;
                            echo '</select>';
                        else :
                            echo 'Opp! You  haven\'t had any post yet. Click <a target="_blank" href="'.admin_url('admin.php').'?page=wpcf7"></a> to create';
                        endif;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="form-group wo-flag">
                <div class="slider">
                    <input type="checkbox" id="enable-googlemap" class="toggle-settings pi_switch_button" name="theme_options[contact][enablegooglemap]" value="1" <?php echo  (isset($aContact['enablegooglemap']) && !empty ($aContact['enablegooglemap']) ) ? 'checked' : ''; ?>>
                    <label class="form-label" for="enable-googlemap"><?php _e('Enable Googlemap', 'wiloke'); ?></label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label"><?php _e('Position', 'wiloke'); ?></label>
                <div class="controls">
                     <input type="text" name="theme_options[contact][googlemap][latitude]" value="<?php echo isset($aContact['googlemap']['latitude']) ? $aContact['googlemap']['latitude'] : '';  ?>" placeholder="Latitude"> <span style="position: relative; top: 9px; margin: 0 10px;"> X </span><input type="text" name="theme_options[contact][googlemap][longitude]" value="<?php echo isset($aContact['googlemap']['longitude']) ? $aContact['googlemap']['longitude'] : '';  ?>" placeholder="Longitude">
                </div>
                <code class="help"><?php _e('Click', 'wiloke'); ?> <a href="http://itouchmap.com/latlong.html" target="_blank"><?php _e('here', 'wiloke'); ?></a><?php _e('to get Latude and Longitude', 'wiloke'); ?></code>
            </div>
            <div class="form-group">
                <label class="form-label"><?php _e('Type', 'wiloke'); ?></label>
                <div class="controls">
                    <select name="theme_options[contact][googlemap][type]">
                        <option value="ROADMAP" <?php echo isset($aContact['googlemap']['type']) && $aContact['googlemap']['type'] == 'ROADMAP' ? 'selected' : ''; ?>><?php _e('ROADMAP', 'wiloke'); ?></option>
                        <option value="SATELLITE" <?php echo isset($aContact['googlemap']['type']) && $aContact['googlemap']['type'] == 'SATELLITE' ? 'selected' : ''; ?>><?php _e('SATELLITE', 'wiloke'); ?></option>
                        <option value="HYBRID" <?php echo isset($aContact['googlemap']['type']) && $aContact['googlemap']['type'] == 'HYBRID' ? 'selected' : ''; ?>><?php _e('HYBRID', 'wiloke'); ?></option>
                        <option value="TERRAIN" <?php echo isset($aContact['googlemap']['type']) && $aContact['googlemap']['type'] == 'TERRAIN' ? 'selected' : ''; ?>><?php _e('TERRAIN', 'wiloke'); ?></option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"><?php _e('Map theme', 'wiloke'); ?></label>
                <div class="controls">
                    <select name="theme_options[contact][googlemap][theme]">
                        <?php 
                            $aThemes=array('grayscale', 'blue', 'dark', 'pink', 'light', 'blueessence', 'bentley', 'retro', 'cobalt', 'brownie');
                            $selected="";
                            foreach ($aThemes as $theme) : 
                                $selected = isset($aContact['googlemap']['theme']) && $aContact['googlemap']['theme'] == $theme ? 'selected' : '';
                        ?>
                            <option value="<?php echo esc_attr($theme); ?>" <?php echo esc_attr($selected);?>><?php echo esc_attr($theme); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </div>

        <div class="panel-body">
            <div class="form-group wo-flag"> 
                <div class="slider">
                    <input type="checkbox" id="enable-contactdetail" class="toggle-settings pi_switch_button" name="theme_options[contact][contact_detail]" value="1" <?php echo  (isset($aContact['contact_detail']) && !empty ($aContact['contact_detail']) ) ? 'checked' : ''; ?>>
                    <label class="form-label" for="enable-contactdetail"><?php _e('Contact Info', 'wiloke'); ?></label>
                </div>
            </div>

            <div class="wrap form-table">
                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[contact][contact_detail_title]" value="<?php echo isset($aContact['contact_detail_title']) ? esc_attr($aContact['contact_detail_title']) : '';  ?>">
                    </div>
                </div>
                <div class="form-group pi-parent contact-wrap">
                    <?php  parent::pi_contact_info($aContact); ?>
                </div>
            </div>
        </div>


        <div class="panel-body">
        <?php parent::pi_section_background('contact', $aContact); ?>
        </div>

        </div>
    </div>
</div>