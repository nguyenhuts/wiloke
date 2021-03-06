<div id="pi-wrap-shortcode"  class="pi-wrap-editor add-section pi-popup hidden">
	<div class="tb-cell">
		<div class="pi-inner-wrap-editor">
			<form id="pi-reset" class="clearfix" style="width:100%; height:auto; display:block">

				<!-- Progress bar -->
				<div id="pi-progress-sc" class="pi-shortcode-settings" style="display: none">
					<div class="form-group">
						<label  class="form-label"><?php _e('Percent', 'wiloke'); ?></label>
						<input type="text" name="percent" value="50" class="form-control">
					</div>
					<div class="form-group">
						<label  class="form-label"><?php _e('Contextual', 'wiloke'); ?></label>
						<div class="controls">
							<select name="contextual" class="form-control">
								<option value="success"><?php _e('Success', 'wiloke'); ?></option>
								<option value="danger"><?php _e('Danger', 'wiloke'); ?></option>
								<option value="info"><?php _e('Info', 'wiloke'); ?></option>
								<option value="warning"><?php _e('Warning', 'wiloke'); ?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label  class="form-label">	
							<input type="checkbox" class="form-control" name="striped" value="striped" checked>
							Striped
						</label>
					</div>

					<div class="form-group">
						<label  class="form-label">
							<input type="checkbox" name="active" value="active" class="form-control" checked>
							Animation
						</label>
					</div>

					<div class="pi-preview">
						<div class="progress">
						  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"  style="width: 50%">
						  </div>
						</div>
					</div>	
				</div>

				<div id="pi-tabs-sc" class="pi-shortcode-settings" style="display: none">
					<div class="pi-item pi-item-toggle">
						<span class="dashicons dashicons-admin-settings"></span>
						<div class="wrap-setting">
							<div class="form-group">
								<label  class="form-label"><?php _e('Title', 'wiloke'); ?></label>
								<div class="controls">
									<input type="text" class="form-control" name="title" value="Tab title">
								</div>
							</div>
							<div class="form-group">
								<label  class="form-label"><?php _e('Content', 'wiloke'); ?></label>
								<div class="controls">
									<textarea name="content" class="form-control">Tab Content</textarea>
								</div>
							</div>
							<div class="dashicons dashicons-no pi-removetab"></div>
						</div>
					</div>
					<div class="form-group">
						<button class="button button-primary pi-addtabs"><?php _e('Add Tabs', 'wiloke'); ?></button>
					</div>
				</div>

				<!-- Tabs  -->
				<div id="pi-accordion-sc" class="pi-shortcode-settings" style="display: none">
					<div class="pi-item pi-item-toggle">
						<span class="dashicons dashicons-admin-settings"></span>
						<div class="wrap-setting">
							<div class="form-group">
								<label  class="form-label"><?php _e('Title', 'wiloke'); ?></label>
								<div class="controls">
									<input type="text" class="form-control" name="title" value="Title">
								</div>
							</div>
							<div class="form-group">
								<label  class="form-label"><?php _e('Content', 'wiloke'); ?></label>
								<div class="controls">
									<textarea name="content" class="form-control">Content</textarea>
								</div>
							</div>
							<div class="dashicons dashicons-no pi-removeitem"></div>
						</div>
					</div>
					<div class="form-group">
						<button class="button button-primary pi-addaccordion"><?php _e('Add Item', 'wiloke'); ?></button>
					</div>
				</div>
				
				<!-- Button  -->
				<div id="pi-button-sc" class="pi-shortcode-settings" style="display: none">
					<div class="form-group">
						<label  class="form-label"><?php _e('Button Name', 'wiloke'); ?></label>
						<div class="controls">
							<input type="text" class="form-control" name="button_name" value="Button">
						</div>
					</div>
					<!-- <div class="form-group">
						<label  class="form-label"><?php _e('Contextual', 'wiloke'); ?></label>
						<div class="controls">
							<select name="contextual" class="form-control">
								<option value="btn-primary"><?php _e('Primary', 'wiloke'); ?></option>
								<option value="btn-success"><?php _e('Success', 'wiloke'); ?></option>
								<option value="btn-info"><?php _e('Info', 'wiloke'); ?></option>
								<option value="btn-warning"><?php _e('Warning', 'wiloke'); ?></option>
								<option value="btn-danger"><?php _e('Danger', 'wiloke'); ?></option>
							</select>
						</div>
					</div> -->

					<div class="form-group">
						<label  class="form-label"><?php _e('Size', 'wiloke'); ?></label>
						<div class="controls">
							<select name="size" class="form-control">
								<option value="btn-default"><?php _e('Normal', 'wiloke'); ?></option>
								<option value="btn-lg"><?php _e('Large', 'wiloke'); ?></option>
								<option value="btn-sm"><?php _e('Small', 'wiloke'); ?></option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label  class="form-label"><?php _e('Link', 'wiloke'); ?></label>
						<div class="controls">
							<input type="text" class="form-control" name="link" value="#">
						</div>
					</div>

					<div class="pi-preview">
						<button type="button" class="h-btn btn btn-default btn-primary">
						<?php _e('Button', 'wiloke'); ?>
					</div>
				</div>

				<!-- Quote  -->
				<div id="pi-quote-sc" class="pi-shortcode-settings" style="display: none">
					<div class="form-group">
						<label class="form-label"><?php _e('Quote', 'wiloke'); ?></label>
						<div class="controls">
							<textarea name="quote" class="form-control">Curabitur quam neque, porta vel velit vitae tempor posuere arcu Integer a arcu id mauris ultricies ullamcorper id a lectus</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label"><?php _e('Author', 'wiloke'); ?></label>
						<div class="controls">
							<input type="text" class="form-control" name="author" value="Robert Smith">
						</div>
					</div>
					
					<div class="pi-preview">
						<blockquote class="blockquote text-uppercase">
						<i class="icon icon_quotations"></i>
						<p>Curabitur quam neque, porta vel velit vitae tempor posuere arcu Integer a arcu id mauris ultricies ullamcorper id a lectus</p>
						<cite>Robert Smith</cite>
						</blockquote>
					</div>
				</div>

				<!-- Alert  -->
				<div id="pi-alert-sc" class="pi-shortcode-settings" style="display: none">
					<div class="form-group">
						<label class="form-label"><?php _e('Alert', 'wiloke'); ?></label>
						<div class="controls">
							<textarea name="alert" class="form-control">Well done! You successfully read this important alert message. </textarea>
						</div>
					</div>
					<div class="form-group">
						<label  class="form-label"><?php _e('Contextual', 'wiloke'); ?></label>
						<div class="controls">
							<select name="contextual" class="form-control">
								<option value="alert-success"><?php _e('Success', 'wiloke'); ?></option>
								<option value="alert-warning"><?php _e('Warning', 'wiloke'); ?></option>
								<option value="alert-danger"><?php _e('Danger', 'wiloke'); ?></option>
								<option value="alert-info"><?php _e('Info', 'wiloke'); ?></option>
							</select>
						</div>
					</div>

					<div class="pi-preview">
						<div class="alert alert-success" role="alert">Well done! You successfully read this important alert message.</div>
					</div>
				</div>	

				<!-- Panel  -->
				<div id="pi-panel-sc" class="pi-shortcode-settings" style="display: none">
					<div class="form-group">
						<label class="form-label"><?php _e('Title', 'wiloke'); ?></label>
						<div class="controls">
							<input type="text" class="form-control" name="title" value="Panel title">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label"><?php _e('Content', 'wiloke'); ?></label>
						<div class="controls">
							<textarea name="content" class="form-control">Panel content</textarea>
						</div>
					</div>
					<div class="form-group">
						<label  class="form-label"><?php _e('Contextual', 'wiloke'); ?></label>
						<div class="controls">
							<select name="contextual" class="form-control">
								<option value="panel-primary"><?php _e('Primary', 'wiloke'); ?></option>
								<option value="panel-success"><?php _e('Success', 'wiloke'); ?></option>
								<option value="panel-warning"><?php _e('Warning', 'wiloke'); ?></option>
								<option value="panel-danger"><?php _e('Danger', 'wiloke'); ?></option>
								<option value="panel-info"><?php _e('Info', 'wiloke'); ?></option>
							</select>
						</div>
					</div>

					<div class="pi-preview">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title"><?php _e('Panel title', 'wiloke'); ?></h3>
							</div>
							<div class="panel-body"> <?php _e('Panel content', 'wiloke'); ?></div>
						</div>
					</div>
				</div>

				<!-- Custom Content  -->
				<div id="pi-customcontent-sc" class="pi-shortcode-settings" style="display: none">
					<div class="form-group">
						<label class="form-label"><?php _e('Image', 'wiloke'); ?> </label>
						<div class="controls">
				            <div class="image-wrap">
				                <span><img src="http://placehold.it/240x200&text=image"></span>
				            </div>
				            <br>
				            <button class="btn btn-white upload-img button-primary js_upload" data-use="siblings" data-geturl="true" data-method="html" data-insertlink=".wo-insert-link" data-insertto=".image-wrap"><?php _e('Get image', 'wiloke')?></button>
				            <input class="insertlink form-control" type="text" value="" placeholder="image" name="image">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label"><?php _e('Title', 'wiloke'); ?> </label>
						<div class="controls">
							<input type="text" class="form-control" name="title" value="Thumbnail label">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label"><?php _e('Content', 'wiloke'); ?> </label>
						<div class="controls">
							<textarea name="content" class="form-control">Enter you content here</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="form-label"><?php _e('Button Name', 'wiloke'); ?> </label>
						<div class="controls">
							<input type="text" class="form-control" name="button_name" value="Button">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label"><?php _e('Link', 'wiloke'); ?></label>
						<div class="controls">
							<input type="text" class="form-control" name="link" value="#">
						</div>
					</div>
				</div>	
				
				
				<div id="pi-footer-sc">
					<button id="pi-cancel-shortcode" class="button button-primary"><?php _e('Cancel', 'wiloke'); ?></button>
					<button id="pi-insert-shortcode" class="button button-primary"><?php _e('Insert Shortcode', 'wiloke'); ?></button>
				</div>
				
			</form>
		<div>
	<div>
</div>
