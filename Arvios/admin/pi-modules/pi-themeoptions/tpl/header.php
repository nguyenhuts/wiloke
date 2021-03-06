<div id="header" class="inner-tabs-panel">
    <div class="inner-content">


        <div class="panel">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php _e("Header", 'wiloke') ?>
                    <p class="help"><?php _e('Allow use tags : &lt;span>, &lt; br />,  &lt;i>, &lt;b>', 'wiloke');?></p>
                </div>
            </div>

            <div class="panel-body wo-flag"> 
                <div class="form-group">
                    <div class="control-button">
                        <div class="slider">
                            <input type="checkbox" id="enable-header" class="toggle-settings pi_switch_button"  name="theme_options[header][enable]" value="1" <?php echo  (isset($aHeader['enable']) && !empty ($aHeader['enable']) ) ? 'checked' : ''; ?> >
                        </div>
                    </div>
                </div> 
            </div>

            <div class="panel-body"> 
                <div class="form-group">
                    <h4 class="form-label"><?php _e('Type', 'wiloke'); ?></h4>
 
                    <div class="controls">
                        <select class="select_header_type" name="theme_options[header][type]">
                            <?php 
                                $headerChecked = isset($aHeader['type']) ? $aHeader['type'] : 'slider';
                                $headerType = array('youtube_bg'=>'Youtube Background', 'img_slider' => 'Image Slider', 'bg_slideshow'=>'Slider Background', 'text_slider' => 'Text Slider', 'image_fixed'=>'Image Static');
                                
                                foreach ($headerType as $k => $val) :   
                                $checked = $k == $headerChecked ? 'selected' : '';
                            ?>
                            <option <?php echo $checked ?> value="<?php echo esc_attr($k) ?>"><?php echo esc_attr($val) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group header-settings img_slider">
                    <ul class="lux-gallery"> 
                        <?php 
                            $imgIds = isset($aHeader['img_slider']) && !empty($aHeader['img_slider']) ? $aHeader['img_slider'] : '';

                            if ( !empty($imgIds) )
                            {
                                $parseId = explode(",", $imgIds);

                                foreach ( $parseId as $imgId )
                                {
                                    ?>
                                    <li class="attachment img-item width-300" data-id="<?php echo $imgId ?>">
                                        <img src="<?php echo wp_get_attachment_url($imgId); ?>">
                                        <a class="pi-remove" href="#">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                        ?>
                    </ul>
                    <div class="bg-action">
                        <button class="button button-primary js_upload blog-img multiple" data-func="siblings" data-target=".lux-gallery"><?php _e('Get image', 'wiloke'); ?></button>
                        <input class="insertlink box-image-id" type="hidden" value="<?php echo  isset($aHeader['img_slider']) ? $aHeader['img_slider'] : ""; ?>" name="theme_options[header][img_slider]">
                    </div>
                </div>

                <div class="form-group header-settings bg_slideshow">
                    <label class="form-label"><?php _e('Choose a slider', 'wiloke'); ?></label>
                    <?php if (!is_plugin_active('tunna-slider/tunna-slider.php')) : echo '<span class="help">Please active the <code>Tunna Slider</code> plugin</span>' ?>
                    <?php 
                         else : 
                        ?>
                        <div class="controls">
                        <?php
                        $aTunnaSlider = $this->pi_get_custom_post_content('tunna_slider');

                        if ( empty($aTunnaSlider) )
                        {
                            ?>

                            <p><?php _e('You haven\'t had any slider yet. Please go to', 'wiloke'); ?>
                                <a  class="help" target="_blank" href="<?php echo admin_url('edit.php'); ?>?post_type=tunna_slider"><?php _e('and create', 'wiloke');?></a>
                            </p>

                        <?php
                        }else
                        {
                        ?>
                            <select name="theme_options[header][tunna_slider]" id="">
                                <?php
                                foreach ( $aTunnaSlider as $k => $getId ) : setup_postdata($getId);
                                    if (isset($aHeader['tunna_slider']) && !empty($aHeader['tunna_slider']) && $aHeader['tunna_slider'] == $getId->ID )
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
                                    <option value="<?php echo esc_attr($getId->ID); ?>" <?php echo $selected ?> ><?php echo esc_attr($getId->post_title); ?></option>
                                <?php
                                $selected="";
                                endforeach;wp_reset_postdata();
                               
                                ?>
                            </select>
                        <?php  } ?>
                        </div>
                        <?php 

                         endif;
                        ?> 
                </div>

                <div class="form-group header-settings youtube_bg contact-wrap">
                    <p class=" alert alert-warning"><?php _e('Please note that, Youtube background will not be auto played on  mobile device. We recommend you use image background on  mobile device, checking "Image for mobile" to enable this function', 'wiloke');?></p>
                    <label class="form-label"><?php _e('Enter Youtube Link', 'wiloke'); ?></label>
                    <div class="controls">
                        <input type="text" class="form-control" name="theme_options[header][youtube_link]" value="<?php  echo  isset($aHeader['youtube_link']) ? esc_url($aHeader['youtube_link']) : ""; ?>">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="form-label"><?php _e('Video Options', 'wiloke'); ?></label>
                        <div class="control-button">
                            <div class="slider">
                                <input type="checkbox" id="enable-mutevideo" class="toggle-settings "  name="theme_options[header][video_options][mute]" value="1" <?php echo  (isset($aHeader['video_options']['mute']) && !empty ($aHeader['video_options']['mute']) ) ? 'checked' : ''; ?> >
                                <label for="enable-mutevideo"><?php _e('Mute', 'wiloke'); ?></label>
                            </div>
                        </div>

                        <label class="form-label"><?php _e('Quality', 'wiloke'); ?></label>
                        <div class="control-button">
                            <select name="theme_options[header][video_options][quality]">
                              <?php 
                                $aQuality = array('default', 'hd720', 'hd1080', 'highres');
                                $selected = isset($aHeader['video_options']['quality']) ?  $aHeader['video_options']['quality'] : 'default';
                                foreach (  $aQuality as $quality )
                                {
                                    ?>
                                    <option value="<?php echo $quality ?>" <?php echo $quality==$selected ? 'selected' : ''; ?>><?php echo ucfirst($quality); ?></option>
                                    <?php 
                                }
                              ?>
                            </select>
                        </div>

                        <div>
                            <div class="form-group wo-flag">
                                <div class="control-button">
                                    <div class="slider">
                                        <input type="checkbox" id="enable-videoplaceholder" class="toggle-settings "  name="theme_options[header][video_options][videoplaceholder]" value="1" <?php echo  (isset($aHeader['video_options']['videoplaceholder']) && !empty ($aHeader['video_options']['videoplaceholder']) ) ? 'checked' : ''; ?> >
                                        <label for="enable-videoplaceholder"><?php _e('Image for mobile', 'wiloke'); ?></label>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <?php $imageplaceholder = isset($aHeader['video_options']['imageplaceholder']) && !empty($aHeader['video_options']['imageplaceholder']) ? wp_get_attachment_url($aHeader['video_options']['imageplaceholder']) : $adminImages  . 'no-img.jpg'; ?>
                                <div class="image-wrap">
                                    <span><img src="<?php echo esc_url($imageplaceholder); ?>"  width="350"></span>
                                </div>
                                <br>
                                <button class="button button-primary upload-img blog-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke'); ?></button>
                                <input class="insertlink" type="hidden" value="<?php echo  isset($aHeader['video_options']['imageplaceholder']) ? esc_attr($aHeader['video_options']['imageplaceholder']) : ""; ?>" name="theme_options[header][video_options][imageplaceholder]">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group header-settings image_fixed">
                    <?php $imageFixed = isset($aHeader['image_fixed']) && !empty($aHeader['image_fixed']) ? wp_get_attachment_url($aHeader['image_fixed']) : $adminImages  . 'no-img.jpg'; ?>
                    <div class="image-wrap">
                        <span><img src="<?php echo $imageFixed; ?>"  width="350"></span>
                    </div>
                    <br>
                    <button class="button button-primary upload-img blog-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke'); ?></button>
                    <input class="insertlink" type="hidden" value="<?php echo  isset($aHeader['image_fixed']) ? esc_attr($aHeader['image_fixed']) : ""; ?>" name="theme_options[header][image_fixed]">
                </div>
 
                <div class="form-group header-settings text_slider">
                    <?php $textSlider = isset($aHeader['text_slider']) && !empty($aHeader['text_slider']) ? wp_get_attachment_url($aHeader['text_slider']) : $adminImages  . 'no-img.jpg'; ?>
                    <div class="image-wrap">
                        <span><img src="<?php echo $textSlider; ?>"  width="350"></span>
                    </div>
                    <br>
                    <button class="button button-primary upload-img blog-img" data-insertlink=".wo-insert-link" data-append=".image-wrap"><?php _e('Get image', 'wiloke');?></button>
                    <input class="insertlink" type="hidden" value="<?php echo  isset($aHeader['text_slider']) ? $aHeader['text_slider'] : ""; ?>" name="theme_options[header][text_slider]">
                </div>
                
                <div class="panel-body header-settings image_fixed youtube_bg img_slider contact-wrap">
                   <h5><?php _e('Settings', 'wiloke'); ?></h5>
                    
                    <div class="form-group">
                        <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                        <div class="form-control">
                            <input type="text" class="form-control" placeholder="Title" name="theme_options[header][title]" value="<?php  echo isset($aHeader['title']) ? esc_attr($aHeader['title']) : ""; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?php _e('Sub title', 'wiloke'); ?></label>
                        <div class="form-control">
                            <input type="text" class="form-control"  name="theme_options[header][sub_title]" value="<?php echo  (isset($aHeader['sub_title']) && !empty ($aHeader['sub_title']) ) ? $aHeader['sub_title'] : ''; ?>" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                        <div class="form-control">
                            <textarea class="form-control"  name="theme_options[header][description]"><?php  echo isset($aHeader['description']) ? esc_textarea($aHeader['description']) : ""; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="panel-body header-settings image_fixed img_slider">
                    <div class="form-group">
                        <label class="form-label"><?php _e('Button', 'wiloke'); ?></label>
                        <div class="form-control">
                            <input type="text" class="form-control"  name="theme_options[header][button_name]" value="<?php echo  (isset($aHeader['button_name']) && !empty ($aHeader['button_name']) ) ? $aHeader['button_name'] : ''; ?>" placeholder="Button Name">
                        </div>
                        <div class="form-control">
                            <input type="text" class="form-control"  name="theme_options[header][button_link]" value="<?php echo  (isset($aHeader['button_link']) && !empty ($aHeader['button_link']) ) ? $aHeader['button_link'] : ''; ?>" placeholder="Link To">
                        </div>
                    </div>
                </div>

                <div class="panel-body header-settings text_slider form-table contact-wrap">
                    <h5><?php _e('Text Effect', 'wiloke'); ?></h5>
                    
                    <select name="theme_options[text_slider][text_effect]">
                        <option value="fade" <?php echo isset($aTextSlider['text_effect']) && $aTextSlider['text_effect'] =='fade' ? 'selected' : ''; ?>>Fade</option>
                        <option value="animate" <?php echo isset($aTextSlider['text_effect']) && $aTextSlider['text_effect'] =='animate' ? 'selected' : ''; ?>>Animate</option>
                        <option value="goDown" <?php echo isset($aTextSlider['text_effect']) && $aTextSlider['text_effect'] =='goDown' ? 'selected' : ''; ?>>goDown</option>
                        <option value="backSlide" <?php echo isset($aTextSlider['text_effect']) && $aTextSlider['text_effect'] =='backSlide' ? 'selected' : ''; ?>>backSlide</option>
                        <option value="fadeUp" <?php echo isset($aTextSlider['text_effect']) && $aTextSlider['text_effect'] =='fadeUp' ? 'selected' : ''; ?>>fadeUp</option>
                    </select>

                    <h5><?php _e('Settings', 'wiloke'); ?></h5>

                    <?php
                        $count =   isset($aTextSlider['description']) && is_array($aTextSlider['description']) ? count($aTextSlider['description']) : 1;
                        for( $i = 0; $i < $count; $i ++ ) :
                    ?>
                    <div class="clearfix group-settings text_slider_settings pi-parent pi-top contact-wrap ">
                        <a class="pi-toggle inner is_active" data-method="siblings" data-target=".form-group, .pi-button" href="#">
                            <i class="fa fa-plus-square"></i>
                        </a>
                        
                        <div class="form-group children">
                            <label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
                            <div class="form-control">
                                <input type="text" class="form-control text-slider-title" placeholder="Title" name="theme_options[text_slider][title][]" value="<?php  echo isset($aTextSlider['title'][$i]) && !empty($aTextSlider['title'][$i] )? esc_attr($aTextSlider['title'][$i]) : ""; ?>" title="Title">
                            </div>
                        </div>
                        <div class="form-group children">
                            <label class="form-label"><?php _e('Sub title', 'wiloke'); ?></label>
                            <div class="form-control">
                                <input type="text" class="form-control text-slider-title" placeholder="Title" name="theme_options[text_slider][sub_title][]" value="<?php  echo isset($aTextSlider['sub_title'][$i]) && !empty($aTextSlider['sub_title'][$i] )? esc_attr($aTextSlider['sub_title'][$i]) : ""; ?>" title="Sub title">
                            </div>
                        </div>
                        <div class="form-group children">
                            <label class="form-label"><?php _e('Description', 'wiloke'); ?></label>
                            <div class="form-control">
                                <textarea class="form-control text-slider-des"   name="theme_options[text_slider][description][]" required><?php  echo isset($aTextSlider['description'][$i]) && !empty($aTextSlider['description'][$i]) ?  wp_unslash($aTextSlider['description'][$i]) : ""; ?></textarea>
                                <code class="help">Allow use tags: &lt;h1>, &lt;h2>, &lt;h3>, &lt;h4>, &lt;h5>, &lt;h6>, &lt;span>, &lt;p>, the text inner &lt;span> tag will be displayed as highline</code>
                            </div>
                        </div>

                        <div class="form-group children">
                            <label class="form-label"><?php _e('Button', 'wiloke'); ?></label>
                            <div class="form-control">
                                <input type="text" class="form-control"  name="theme_options[text_slider][button_name][]" value="<?php echo  (isset($aTextSlider['button_name'][$i]) && !empty ($aTextSlider['button_name'][$i]) ) ? esc_attr($aTextSlider['button_name'][$i]) : ''; ?>" placeholder="Button Name">
                            </div>
                            <div class="form-control">
                                <input type="text" class="form-control"  name="theme_options[text_slider][button_link][]" value="<?php echo  (isset($aTextSlider['button_link'][$i]) && !empty ($aTextSlider['button_link'][$i]) ) ? esc_attr($aTextSlider['button_link'][$i]) : ''; ?>" placeholder="Link To">
                            </div>
                        </div>
                       
                        <button class="pi-button button button-primary pi-detele-tab children" href="JavaScript:void(0)" data-count=".group-settings"><?php _e('Remove', 'wiloke'); ?></button>
                    </div>
                    <?php endfor; ?>

                    <div class="pi-wrap-add pi-top">
                        <button class="pi_button button button-primary pi_add_textslider"><?php _e('Add More', 'wiloke'); ?></button>
                    </div>
                </div>

                <div class="panel-body header-settings text_slider image_fixed youtube_bg img_slider">
                    <div class="form-group">
                        <label class="form-label"><?php _e('Overlay Color', 'wiloke'); ?></label>
                        <div class="form-control">
                            <input type="text" class="form-control pi_color_picker"  name="theme_options[header][overlay_color]" value="<?php echo  (isset($aHeader['overlay_color']) && !empty ($aHeader['overlay_color']) ) ? $aHeader['overlay_color'] : 'rgba(0,0,0,0.0)'; ?>">
                        </div>
                    </div>
                </div>

            </div> <!--/end section1 of ourservices -->
            
        </div><!-- END Panel -->
    </div>
</div>