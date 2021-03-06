<div id="form-section-builder" class="form-control">


    <div class="form-group clearfix">
        <input type="text" id="pi_section_id" value="">
        <button  class="pi-addnew-section btn btn-danger" data-target="pi-sections"><?php _e('Add Section', 'wiloke'); ?></button>
    </div>
   
     <?php 
        do_action('pi_before_section_builder');
    ?> 
    <div id="pi-sections" class="section-builder clearfix">
        <ul id="pi-sortable" class="js_section_order wo-sortable">
            <?php
                $aName  = array_combine(parent::$piaConfigs['sections'], parent::$piaConfigs['sections_name']);

                $getSection = isset($sBuilderSection) && !empty($sBuilderSection) ? explode(",", $sBuilderSection) : parent::$piaConfigs['sections'];

                // $getSection = parent::$piaConfigs['sections'];

                $aDefCustomSection = array('enable'=>0, "title"=>'No Title', 'description'=>'', 'content'=>'', 'background'=>'none', 'image_bg'=>'http://placehold.it/350x150', 'color_bg'=>'#FFF');
                foreach ($getSection as $v)
                {   
                    $key            = strtolower($v);
                    $key            = ltrim($key);
                    $default        = in_array($key, parent::$piaConfigs['sections']) ? true : false;

                    $piEdit         = '';

                    if ( !$default )
                    {
                        $aCustomSection = $aOptions['pi_custom_section'][$key];
                        $aCustomSection = wp_parse_args( $aCustomSection, $aDefCustomSection );
                        $piEdit = '<span class="pi-toggle-settings-zone dashicons dashicons-welcome-write-blog pi-absolute pi-right"></span>';
                    }
                    ?> 
                    <li   data-name="<?php echo $key ?>" data-sectioname="<?php echo $default ? $aName[$key] : $aCustomSection['name'];  ?>"  class="pi-wrapsection"><span class="pi-list-section ui-icon ui-icon-arrowthick"></span><?php echo $piEdit; ?><h3 class="pi-section-name"><?php echo $default ? $aName[$key] : $aCustomSection['name'];  ?></h3>
                        <?php  
                            if ( !$default ) 
                            {
                                $aCustomSection = array_merge($aDefCustomSection, $aCustomSection);
                                $this->pi_custom_section_settings($aCustomSection['name'], $key, $aCustomSection);
                            }
                        ?>
                    </li>
                    <?php 
                }
              
             ?>
            
        </ul>
        <p>
        <input type="hidden" class="section-order" name="theme_options[section_builder]" value="<?php echo isset($sBuilderSection) && !empty($sBuilderSection) ? $sBuilderSection : implode(",", parent::$piaConfigs['sections']); ?>">
        <button  class="section-order-reset btn btn-danger" data-target="personal">Reset</button>
        </p>
    </div>
    
    
    <?php 
        do_action('pi_after_section_builder');
    ?>

</div>


