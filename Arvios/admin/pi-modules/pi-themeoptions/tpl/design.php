<div class="menu-left">
    <ul class="tab-left">
        <li><a href="#colorskin"><i class="fa fa-laptop"></i><?php _e('Color Schemes', 'wiloke'); ?></a></li>
    </ul>
</div>


<div id="colorskin" class="inner-tabs-panel">
    <div class="inner-content">
        <div class="container-12-fluid">
            <div class="container-12-row">
                <div class="large-12">
                  
                    <div class="panel">

                        <div class="panel-heading">
                            <div class="panel-title">
                                <?php _e('Choose Skin', 'wiloke'); ?>
                            </div>
                        </div>

                        <div class="panel-body">
                            <h3><?php _e('Color Schemes', 'wiloke'); ?></h3>
                            <div class="form-control">
                                    <?php 
                                       $color_scheme = isset($aDesign['color_scheme']) && !empty($aDesign['color_scheme']) ? ltrim($aDesign['color_scheme'])  : "default";
                                        $aSettings = array("default", "blue", "cyan", "green", "yellow","pi_use_custom_color");
                                        $customColor = get_option("pi_custom_color");
                                        $customColor = $customColor ? $customColor : '#000';
                                        ?>
                                        <ul class="skin-color qva-design">
                                             <?php 
                                                foreach ($aSettings as $v) :
                                                    $active = ($v == $color_scheme) ? " skin-active" : '';
                                                    
                                                    $useCustomColor =  $v == 'pi_use_custom_color' ? 'style="background-color:' . $customColor . '"' : '';
                                                   
                                                    ?>
                                                    <li class="<?php echo $v .  $active; ?>" <?php echo $useCustomColor; ?> data-key="<?php echo $v ?>"><a href="#" title="<?php echo $v == 'pi_use_custom_color' ? 'Custom Color' : ''; ?>"><i  class="<?php echo $v == 'pi_use_custom_color' ? 'fa fa-fire-extinguisher' : 'fa fa-check '?>"></i></a></li>

                                                    <?php 
                                                endforeach;
                                            ?>
                                        </ul>
                                        <input class="hidden" name="theme_options[design][color_scheme]" value="<?php echo esc_attr($color_scheme) ?>">

                                        <div class="picolor custom_color <?php echo ($color_scheme == 'pi_use_custom_color') ? '' : 'hidden'; ?>">
                                            <input type="text" class="pi_color_picker color-picker" name="pi_custom_color" value="<?php echo $customColor; ?>">
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

