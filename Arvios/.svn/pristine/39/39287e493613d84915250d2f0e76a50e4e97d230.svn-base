<?php

class piPosts extends piCore
{
 
	public function __construct()
	{
		add_action('edit_form_after_title', array($this, 'pi_builder'));
		add_action('admin_enqueue_scripts', array($this, 'pi_enqueue_scripts'));
		add_action('save_post', array($this, 'pi_save_data'));
		add_action('add_meta_boxes', array($this, 'pi_create_settings'));
	}


	public function pi_save_data($postID)
	{
		if (!current_user_can('edit_post', $postID) ) return;

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

        if ( !isset($_POST['post_type']) || empty($_POST['post_type']) ) return;
        
        
        if  ( $_POST['post_type'] == 'post' ) :
        	$data = isset($_POST['custompost']) ? $_POST['custompost'] : array();
	        $data = $this->pi_unslashed_before_update($data);
	    	update_post_meta($postID, "custompost", $data);

	    	$data = isset($_POST['post_settings']) ? $_POST['post_settings'] : array();
	    	$data = $this->pi_unslashed_before_update($data);
	    	update_post_meta($postID, "_post_settings", $data);
	    endif;
	} 

	public function pi_enqueue_scripts()
	{
		global $typenow;

		if ($typenow == 'post')
		{
			$url = get_template_directory_uri() . '/admin/pi-assets/';
			wp_register_style('pi_plugin_fa', $url . 'css/font-awesome.min.css', array(), '4.0.2');
			wp_enqueue_style('pi_plugin_fa');
			

			// wp_register_style('pi_portfolio_style', $url . 'css/pi.portfolio.css', array(), piCore::VERSION);
			// wp_enqueue_style('pi_portfolio_style');

			wp_register_style('pi_form_style', $url . 'css/pi.form-style.css', array(), piCore::VERSION);
			wp_enqueue_style('pi_form_style');

			wp_register_style('pi_post_style', $url . 'css/pi.post.css', array(), piCore::VERSION);
			wp_enqueue_style('pi_post_style');

			wp_register_script('pi_posts', $url . 'js/pi.posts.js', array(), piCore::VERSION, true);

			wp_enqueue_script('pi_posts');

		}
	}

	public function pi_create_settings()
	{
		add_meta_box(
			'pi-custom-post-settings',
			__('Post Settings', piCore::LANG),
			array($this, 'pi_setting_builder'),
			'post',
			'normal',
			'default'
		);
	}

	public function pi_builder()
	{
		$screen = get_current_screen();
		$id = get_the_ID();
		if ( $screen->post_type == 'post' )
		{
			// wp_nonce_field("custompost_action", "custompost_nonce");
			$aData = get_post_meta($id, "custompost", true);
			
			$aHeaderType = array('imagestatic'=>'Image Static', 'imageslideshow'=>'Image Slideshow', 'youtube'=>'Video');
			$checked = isset($aData['headertype']) && !empty($aData['headertype']) ? $aData['headertype'] : 'imagestatic';
			?>
			<div>
				<div>
					<div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3 class="hndle"><span><?php _e('Post head Options', 'wiloke'); ?></span></h3>
						<div class="inside">
							<div id="pi-header-type" class="form-table panel">
								<div class="panel-body">

									<!-- <div class="zone-of-image zone-of-standard form-group">
										<p>
											<?php _e("<code>Click on <b>Set featured image</b>", 'wiloke'); ?>
										</p>
									</div> -->

									<div class="zone-of-slideshow form-group">			
										<div class="tbl-right controls">
											<label class="form-label">
												<b><?php _e('Images', 'wiloke'); ?></b>
											</label>
											<div class="controls wrap-upload bg-action">
												<input type="button" class="blue-btn button button-primary btn btn-info upload-image multiple	 js_upload" value="Upload Images" data-target=".lux-gallery" data-func="siblings">
												<input id="slideshow" class="input-photo img-id box-image-id" type="text" size="70" value="<?php echo isset($aData['slideshow']) && !empty($aData['slideshow']) ? $aData['slideshow'] : ''; ?>" name="custompost[slideshow]" >
											</div>
											<ul class="lux-gallery posttype-post textalign-left">
												<?php 

													if (isset($aData['slideshow']) && !empty($aData['slideshow']))
													{
														$aId = explode(",", $aData['slideshow']);
														foreach ($aId as $id) {
															echo '<li class="attachment img-item width-300" data-id="'. $id . '">';
															echo wp_get_attachment_image($id, 'thumbnail');
															?>
															<a class="pi-remove" href="#">
																<i class="fa fa-times dashicons dashicons-dismiss"></i>
															</a>
															</li>
															<?php 
														}
													}
												?>
											</ul>
										</div>
									</div>

									<div class="zone-of-image form-group">			
										<div class="tbl-right controls">
											<label class="form-label">
												<b><?php _e('Image', 'wiloke'); ?></b>
											</label>
											<div class="controls wrap-upload bg-action">
												<input type="button" class="blue-btn button button-primary btn btn-info upload-image js_upload" value="Upload Image" data-insertinto=".lux-gallery" data-method="html" data-use="siblings">
												<input id="slideshow" class="input-photo img-id box-image-id" type="text" size="70" value="<?php echo isset($aData['image']) && !empty($aData['image']) ? $aData['image'] : ''; ?>" name="custompost[image]" >

												<ul class="lux-gallery posttype-post textalign-left">
												<?php 
													if( isset($aData['image']) && !empty($aData['image']) )
													{
														 echo wp_get_attachment_image($aData['image'], 'thumbnail');	
													}
												?>
											</ul>
											</div>

										</div>
									</div>

									<div class="zone-of-youtube form-group">
										<div class="controls">
											<label class="form-label">
												<b><?php _e('Youtube/Vimeo', 'wiloke'); ?></b>
											</label>
											<input class="wiloke_input form-control" type="text" placeholder="Video Link" type="text" name="custompost[videolink]" value="<?php echo isset($aData['videolink']) && !empty($aData['videolink']) ? esc_url($aData['videolink']) : ''; ?>">
											<p class="help"><?php _e('Enter Youtube like this : https://www.youtube.com/watch?v=dOD_DnxikWs  or Vimeo Link like this: http://vimeo.com/25708134', 'wiloke');?><br>
											</p>
										</div>
									</div>

									<div class="zone-of-audio form-group">
										<div class="controls">
											<label class="form-label">
												<b>Link</b>
											</label>
											<input class="wiloke_input form-control" type="text" placeholder="Audio Link" type="text" name="custompost[audiolink]" value="<?php echo isset($aData['audiolink']) && !empty($aData['audiolink']) ? esc_url($aData['audiolink']) : ''; ?>">
											<p class="help">Enter <a href="https://soundcloud.com/" target="_blank"><?php _e('soundcloud link', 'wiloke') ?></a></p>
										</div>
									</div>

									<div class="zone-of-quote form-group">
										
										<div class="controls">
											<p>
												<label class="form-label"><b><?php _e('Quote', 'wiloke') ?></b></label>
												<textarea class="form-control" name="custompost[quote]"><?php echo isset($aData['quote']) && !empty($aData['quote']) ? esc_textarea($aData['quote']) : ''; ?></textarea>
											</p>
											<p>
												<label class="form-label"><b><?php _e('Author', 'wiloke') ?></b></label>
												<input class="wiloke_input form-control" type="text" placeholder="Author" type="text" name="custompost[quote_author]" value="<?php echo isset($aData['quote_author']) && !empty($aData['quote_author']) ? esc_attr($aData['quote_author']) : ''; ?>">
											</p>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<?php 
		}
	}

	
}