<div id="twitter" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel">
            
            <div class="panel-heading">
                <div class="panel-title">
                    <?php _e('Twitter', 'wiloke'); ?> <br>
                    <code><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke'); ?></code>
                    <p><?php _e('Please go to <a href="https://apps.twitter.com/app/new" target="_blank">this page</a> to create a Twitter Application', 'wiloke'); ?></p>
                </div>
            </div>

             <div class="panel-body wo-flag">
                 <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" class="toggle-settings pi_switch_button" id="enable-twitter" name="theme_options[twitter][enable]" value="1" <?php echo  (isset($aTwitter['enable']) && !empty ($aTwitter['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][title]" value="<?php  echo isset($aTwitter['title']) ? esc_attr($aTwitter['title']) : ''; ?>">
                    </div>
                </div>
            </div> 

            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke') ?></label>
                    <div class="controls">
                        <textarea class="form-control" name="theme_options[twitter][description]"><?php echo isset($aTwitter['description']) ? esc_textarea($aTwitter['description']) : ''; ?></textarea>
                    </div>
                </div>
            </div> 
 
            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('User name', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][username]" value="<?php  echo isset($aTwitter['username']) ? esc_attr($aTwitter['username']) : ''; ?>">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="form-label"><?php _e('Number of tweets', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][number_of_tweets]" value="<?php  echo isset($aTwitter['number_of_tweets']) ? esc_attr($aTwitter['number_of_tweets']) : ''; ?>">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="form-label"><?php _e('Consumer Key', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][consumer_key]" value="<?php  echo isset($aTwitter['consumer_key']) ? esc_attr($aTwitter['consumer_key']) : ''; ?>">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="form-label"><?php _e('Consumer Secret', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][consumer_secret]" value="<?php  echo isset($aTwitter['consumer_secret']) ? esc_attr($aTwitter['consumer_secret']) : ''; ?>">
                    </div>
                </div>
                 <div class="form-group">
                    <label class="form-label"><?php _e('Access Token', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][access_token]" value="<?php  echo isset($aTwitter['access_token']) ? esc_attr($aTwitter['access_token']) : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php _e('Access Token Secret', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][access_token_secret]" value="<?php  echo isset($aTwitter['title']) ? esc_attr($aTwitter['access_token_secret']) : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php _e('Cache Interval', 'wiloke') ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[twitter][cache_interval]" value="<?php  echo isset($aTwitter['cache_interval']) ? esc_attr($aTwitter['cache_interval']) : 15; ?>">
                    </div>
                </div>
            </div>

            <div class="panel-body">
               <?php parent::pi_section_background('twitter', $aTwitter); ?>
            </div>

        </div>  
    </div> 
</div>    