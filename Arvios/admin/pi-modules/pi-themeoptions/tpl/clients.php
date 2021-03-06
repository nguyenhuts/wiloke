
<div id="clients" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel">

            <div class="panel-heading">
                <div class="panel-title"><?php _e('Clients', 'wiloke'); ?>
                </div>
            </div>

 
            <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-clients" name="theme_options[clients][enable]" value="1" <?php echo  (isset($aClients['enable']) && !empty ($aClients['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>


            <div class="panel-body">

                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[clients][title]" value="<?php echo isset($aClients['title']) ? esc_attr($aClients['title']) : '';  ?>">
                    </div>
                </div>

                <div class="form-group">
                        <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                        <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></p>
                        <div class="controls">
                            <textarea class="form-control" name="theme_options[clients][description]"><?php  echo isset($aClients['description']) ? esc_textarea($aClients['description']) : ""; ?></textarea>
                        </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Choose your section setting', 'wiloke'); ?></label>
                    <div class="controls">
                        <?php
                        $aPostMetaClients = $this->pi_get_custom_post_content('pi_ourclients');

                        if ( empty($aPostMetaClients) )
                        {
                            ?>

                            <p><?php _e('You  haven\'t had any post yet', 'wiloke'); ?>
                                <a target="_blank"  class="help" href="<?php echo admin_url('edit.php'); ?>?post_type=pi_ourclients">Create</a>
                            </p>

                        <?php
                        }else
                        {
                        ?> 
                        <select name="theme_options[clients][content]">
                            <?php
                            foreach ( $aPostMetaClients as $k => $postAboutUs ) : setup_postdata($postAboutUs);
                                if (isset($aClients['content']) && !empty($aClients['content']) && $aClients['content'] == $postAboutUs->ID )
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

                <?php parent::pi_section_background('clients', $aClients); ?>

            </div> <!--/end panel -->

        </div> <!--/end large-12-->
    </div>
</div>