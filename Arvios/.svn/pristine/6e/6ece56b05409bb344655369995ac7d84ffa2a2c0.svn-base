
<div id="aboutus" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel">

            <div class="panel-heading"> 
                <div class="panel-title"><?php _e('About Us', 'wiloke'); ?>
                </div>
            </div>

            <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-aboutus" name="theme_options[aboutus][enable]" value="1" <?php echo  (isset($aAboutUs['enable']) && !empty ($aAboutUs['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div> 
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[aboutus][title]" value="<?php echo isset($aAboutUs['title']) ? esc_attr($aAboutUs['title']) : '';  ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                    <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke');?></p>
                    <div class="controls">
                        <textarea class="form-control" name="theme_options[aboutus][description]"><?php  echo isset($aAboutUs['description']) ? esc_attr($aAboutUs['description']) : ""; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Choose your section setting', 'wiloke') ?></label>
                    <div class="controls">
                        <?php
                        $aPostMetaAboutUs = $this->pi_get_custom_post_content('pi_aboutus');

                        if ( empty($aPostMetaAboutUs) )
                        {
                            ?>

                            <p><?php _e('You  haven\'t had any post yet', 'wiloke');?>
                                <a  class="help" target="_blank" href="<?php echo admin_url('edit.php'); ?>?post_type=pi_aboutus"><?php _e('Create', 'wiloke');?></a>
                            </p>

                        <?php
                        }else
                        {
                        ?> 
                        <select name="theme_options[aboutus][content]">
                            <?php
                            foreach ( $aPostMetaAboutUs as $k => $postAboutUs ) : setup_postdata($postAboutUs);
                                if (isset($aAboutUs['content']) && !empty($aAboutUs['content']) && $aAboutUs['content'] == $postAboutUs->ID )
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
                                <option value="<?php echo $postAboutUs->ID; ?>" <?php echo $selected ?> ><?php echo esc_attr( $postAboutUs->post_title ); ?></option>
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

                <?php 
                    parent::pi_section_background('aboutus', $aAboutUs); 
                ?>

            </div> <!--/end panel -->

        </div> <!--/end large-12-->
    </div>
</div>