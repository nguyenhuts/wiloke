<?php
// create by pirateS&&themeilite - wiloke.com - piratesmorefun@gmail.com

if ( !isset($_POST['render']) ) wp_die("R U kidding me");
 
$teRender = ltrim($_POST['render']);

switch ($teRender) :
	case 'add_menu':

	break;

	case 'expertise':
		$order  = $_POST['max'];
		?>
		<div class="container-12-row exp-row pi-delete">
			<div class="medium-4">
				<div class="exp-form exp-left">
				<div class="expertiesico">
				<!-- 	<span class="ico">
						<i class="<?php echo $aData['icon']  ?>"></i>
					</span> -->
					<a class="ico icon  available-panel pi_expertise js_add_icon"href="#TB_inline?width=600&height=500&inlineId=table-fa"><i class="fa fa-refresh fa-5x"></i>
	                </a>
	                <input type="text" class="pi-input pi-iconname" name="pi_expertise[<?php echo $order ?>][icon]" value="fa fa-fresh fa-5x">
				</div>
			</div>
			</div>
			<div class="medium-8">
				<div class="exp-form exp-right">
					<a class="del-exp-btn" href="#"><i class="dashicons dashicons-no"></i></a>
				<input class="exp-title pi-input" type="text" name="pi_expertise[<?php echo $order ?>][expertise]" placeholder="Your expertise" value="">  
				<!-- <input class="exp-desc" type="text" name="pi_expertise[<?php echo $k ?>][des]" placeholder="Position" value="<?php echo $aData['des'] ?>">   -->
				<textarea class="exp-content pi-textarea" name="pi_expertise[<?php echo $order ?>][small_intro]" placeholder="Small Intro"></textarea>
				</div>
			</div>
		</div>
		<?php 
	break;

	case 'fact':
		$k  = $_POST['max'];
		?>
		<div class="medium-4 pi-delete te-delete pricing-table">
			<div class="pi-form">
				<a class="skill-del del-exp-btn pi-delete-item" href="#" title="Delete"><i class="dashicons dashicons-no"></i></a>
	 			<a href="#" class="js_add_icon"><i class="fa fa-refresh"></i></a>
	 			<input type="hidden" title="Icon" class="pi_title" name="pi_funfacts[<?php echo $k ?>][icon]" placeholder="Icon" value="fa fa-refresh">
	 			<input type="text" class="pi_title" title="Ex: any numbers" name="pi_funfacts[<?php echo $k ?>][total]" placeholder="Ex: any numbers" value="">  
	 			<textarea class="pi_des" name="pi_funfacts[<?php echo $k ?>][name]" placeholder="Ex: Coffe Cups, Awwards"></textarea>
	 		</div>
 		</div>	
		<?php 
		break; 

	case 'skill':
		$k = $_POST['max'];
		$te_chartID = uniqid("pi_charts_");
		$teSliderId = uniqid("pi_slider_");
		?>
		<div class="medium-4 pi-delete">
			<div class="pi-form">
				<a class="skill-del pi-delete-item" href="#" title="Delete"><i class="dashicons dashicons-no"></i></a>
				<div id="<?php echo $te_chartID ?>" class="pi_charts" data-percent="50"><span class="percent">50%</span></div>
				<div id="<?php echo $teSliderId ?>" class="pi_slider"></div>
				<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery("#<?php echo $teSliderId ?>").slider(
					{
						min: 0, 
						max: 100, 
						value: 50, 
						// stop: function(event, ui)
						// {
						// 	jQuery(this).next().next().attr("value", ui.value);
						// 	jQuery(this).prev().data('easyPieChart').update(ui.value);
						// 	jQuery(this).prev().find(".percent").text(ui.value + '%');
						// },
						change: function(event, ui)
						{
							jQuery(this).next().next().attr("value", ui.value);
							jQuery(this).prev().data('easyPieChart').update(ui.value);
							jQuery(this).prev().find(".percent").text(ui.value + '%');
						}
					});
					jQuery("#<?php echo $te_chartID ?>").easyPieChart();
				})
				</script>
 				<input type="text" class="pi_skill_value" name="pi_skill[<?php echo $k ?>][percent]" placeholder="Percent" value="50">
 				<br>
 				<input type="text" class="" name="pi_skill[<?php echo $k ?>][skill]" placeholder="Skill" value="">  <br>
 				

	 		</div>
 		</div>	
		<?php 
	break; 

	case 'service': 
	$k = $_POST['max'];
	?>
		<div class="medium-4 pi-delete te-delete pricing-table">
			<div class="pi-form">
				<a class="skill-del del-exp-btn pi-delete-item" href="#" title="Delete"><i class="dashicons dashicons-no"></i></a>
	 			<a href="#" class="js_add_icon"><i class="fa fa-refresh"></i></a>
	 			<input type="hidden" title="Icon" class="pi_title" name="pi_services[<?php echo $k ?>][icon]" placeholder="Icon" value="fa fa-refresh">  
	 			<input type="text" class="pi_title" title="Service" name="pi_services[<?php echo $k ?>][service]" placeholder="Service" value="">  
	 			<textarea class="pi_des" title="Small intro about service" name="pi_services[<?php echo $k ?>][small_intro]" placeholder="Small Intro"></textarea>
	 		</div>
 		</div>	
 	<?php
	break;

	case 'pricing':
	$k = $_POST['max'];
	?>
	<div class="pi-parent medium-4 te-delete pi-delete">
		
		<div class="form-group">
			<label class="form-label"><b><?php _e('Title', 'wiloke'); ?></b></label>
			<div class="controls">
				<input class="form-control pi-required" type="text" value="" name="pi_pricingtable[<?php  echo $k ?>][title]" placeholder="Basic">
			</div>
		</div>
		
		<div class="form-group">
			<label class="form-label"><b><?php _e('Currency', 'wiloke'); ?></b></label>
			<div class="controls">
				<input class="form-control pi-required" type="text" value="" name="pi_pricingtable[<?php  echo $k ?>][currency]" placeholder="$">
			</div>
		</div>
		
		<div class="form-group">
			<label class="form-label"><b><?php _e('Price', 'wiloke'); ?></b></label>
			<div class="controls">
				<input class="form-control pi-required" type="text" value="" name="pi_pricingtable[<?php  echo $k ?>][price]" placeholder="">
			</div>
		</div>
		
		<div class="form-group">
			<label class="form-label"><b><?php _e('Duration', 'wiloke'); ?></b></label>
			<div class="controls">
				<input class="form-control pi-required" type="text" value="" name="pi_pricingtable[<?php  echo $k ?>][duration]" placeholder="per month">
			</div>
		</div>
		<div class="form-group">
			<label class="form-label"><b><?php _e('Offers', 'wiloke'); ?></b></label>
			<div class="controls">
				<div class="pi-wrap-offer-item">
					<input class="form-control pi-offer-item" type="text" value="" name="pi_pricingtable[<?php  echo $k ?>][offers][]" placeholder="">
					<a class="pi-remove-offer dashicons dashicons-trash" href="#"></a>
				</div>
				<button class="pi-add-offer button button-primary" href="#" data-key="<?php echo $k; ?>">Add Offer</button>
			</div>
		</div>
        
        <div class="form-group">
            <label class="form-label"><b><?php _e('Button Name', 'wiloke'); ?></b></label>
            <div class="controls">
                <input class="form-control" type="text" value="" name="pi_pricingtable[<?php  echo $k ?>][button_name]" placeholder="sign up">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label"><b><?php _e('Button Url', 'wiloke'); ?></b></label>
            <div class="controls">
                <input class="form-control" type="text" value="" name="pi_pricingtable[<?php  echo $k ?>][url]" placeholder="your link">
            </div>
        </div>

        <div class="form-group">
            <div class="controls">
                <label class="form-label">
                    <input class="form-control" type="checkbox" value="1" name="pi_pricingtable[<?php  echo $k ?>][highlight]">
                    <b><?php _e('High light', 'wiloke'); ?></b>
                </label>
            </div>
        </div>

		<a class="pi-delete-item" data-hasrequired="true" title="Delete" href="#">
			<i class="dashicons dashicons-no"></i>
		</a>
	</div>		
	<?php 
	break;

endswitch;

die();