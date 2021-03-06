<div id="portfolio" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="panel"> 

            <div class="panel-heading">
                <div class="panel-title"><?php _e('Work/Portfolio', 'wiloke'); ?></div>
            </div>  
        
            <div class="panel-body wo-flag">
                <div class="form-group"> 
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" id="enable-portfolio" class="toggle-settings pi_switch_button" name="theme_options[portfolio][enable]" value="1" <?php echo  (isset($aPortfolio['enable']) && !empty ($aPortfolio['enable']) ) ? 'checked' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label class="form-label"><?php _e('Title', 'wiloke');?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[portfolio][title]" value="<?php echo isset($aPortfolio['title']) ? esc_attr($aPortfolio['title']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Description', 'wiloke');?></label>
                    <div class="controls">
                        <textarea type="text" class="form-control" name="theme_options[portfolio][description]"><?php echo isset($aPortfolio['description']) ? esc_textarea($aPortfolio['description']) : ''; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Show Posts', 'wiloke');?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[portfolio][showposts]" value="<?php echo isset($aPortfolio['showposts']) ? esc_attr($aPortfolio['showposts']) : 8; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Layout', 'wiloke') ?></label>
                    <div class="controls">
                        <select name="theme_options[portfolio][layout]" class="form-control">
                            <option value="style1" <?php echo isset($aPortfolio['layout']) && $aPortfolio['layout']=='style1' ? 'selected' : ''; ?>><?php _e('Full Width - No Padding', 'wiloke') ?></option>
                            <option value="style2" <?php echo isset($aPortfolio['layout']) && $aPortfolio['layout']=='style2' ? 'selected' : ''; ?>><?php _e('Full Width - Padding', 'wiloke') ?></option>
                            <option value="style4" <?php echo isset($aPortfolio['layout']) && $aPortfolio['layout']=='style4' ? 'selected' : ''; ?>><?php _e('Boxed - Padding', 'wiloke') ?></option>
                            <option value="style3" <?php echo isset($aPortfolio['layout']) && $aPortfolio['layout']=='style3' ? 'selected' : ''; ?>><?php _e('Boxed - No Padding', 'wiloke') ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Hover Effect', 'wiloke');?></label>
                    <div class="controls">
                        <select name="theme_options[portfolio][hover_effect]" class="form-control">
                            <option value="style1" <?php echo isset($aPortfolio['hover_effect']) && $aPortfolio['hover_effect']=='style1' ? 'selected' : ''; ?>><?php _e('Stylel1', 'wiloke');?></option>
                            <option value="style2" <?php echo isset($aPortfolio['hover_effect']) && $aPortfolio['hover_effect']=='style2' ? 'selected' : ''; ?>><?php _e('Style2', 'wiloke');?></option>
                            <option value="style3" <?php echo isset($aPortfolio['hover_effect']) && $aPortfolio['hover_effect']=='style3' ? 'selected' : ''; ?>><?php _e('Style3', 'wiloke');?></option>
                            <option value="style4" <?php echo isset($aPortfolio['hover_effect']) && $aPortfolio['hover_effect']=='style4' ? 'selected' : ''; ?>><?php _e('Style4', 'wiloke');?></option>
                            <option value="style5" <?php echo isset($aPortfolio['hover_effect']) && $aPortfolio['hover_effect']=='style5' ? 'selected' : ''; ?>><?php _e('Style5', 'wiloke');?></option>
                            <option value="style6" <?php echo isset($aPortfolio['hover_effect']) && $aPortfolio['hover_effect']=='style6' ? 'selected' : ''; ?>><?php _e('Style6', 'wiloke');?></option>
                            <option value="random" <?php echo isset($aPortfolio['hover_effect']) && $aPortfolio['hover_effect']=='random' ? 'selected' : ''; ?>><?php _e('Random', 'wiloke');?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?php _e('Button Type', 'wiloke') ?></label>
                    <div class="controls">
                        <select name="theme_options[portfolio][button_type]" class="form-control">
                            <option value="portfolio_page" <?php echo isset($aPortfolio['button_type']) && $aPortfolio['button_type']=='portfolio_page' ? 'selected' : ''; ?>><?php _e('Redirect To Portfolio Page', 'wiloke') ?></option>
                            <option value="loadmore" <?php echo isset($aPortfolio['button_type']) && $aPortfolio['button_type']=='loadmore' ? 'selected' : ''; ?>><?php _e('Loadmore', 'wiloke') ?></option>
                            <option value="0" <?php echo isset($aPortfolio['button_type']) && $aPortfolio['button_type']=='0' ? 'selected' : ''; ?>><?php _e('None', 'wiloke') ?></option>
                        </select>
                    </div>
                </div>

                <?php parent::pi_section_background('portfolio', $aPortfolio); ?>
            </div>

        </div>
    </div>
</div>