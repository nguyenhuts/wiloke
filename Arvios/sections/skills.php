<?php 
if ( apply_filters('pi_is_section_enable', 'skills') ) :
?> 
<?php 
  do_action("pi_arvios_before_skills");
?>
<section id="skills" class="skill<?php pi_add_hidden('skills');?>">
  <?php pi_get_background('skills'); ?>
  <div class="container">

    <div class="st-heading text-center">
        <?php apply_filters( 'pi_the_heading', 'skills' ); ?>
        <?php apply_filters( 'pi_the_description', 'skills' ); ?>  
    </div>
  
    <div class="st-body text-center">
      <div class="row">

      <?php  $getID = apply_filters('pi_get_data', 'skills'); if ( $getID ) : $piaData = get_post_meta($getID, "_pi_skill", true); if ( !empty($piaData) ) : 
            foreach ( $piaData as $data ) : ?>
          
          <div class="col-xs-6 col-md-3">
            <!-- ITEM -->
            <div class="skill-item">

                <div class="skill-bar" data-duration="1.5s" data-size="120" data-widthbar="5" data-colorbar="rgba(255,255,255,.3)" data-colorpie="#3498DB">
                    <div class="pie pie1"></div>
                    <div class="pie pie2"></div>
                    <div class="percent"><?php echo isset($data['percent']) ? (int)$data['percent'] : 100 ?>%</div>
                </div>

                <!-- Description -->
                <?php
                  if ( isset($data['skill']) && !empty($data['skill']) )
                  {
                    printf(__(('<h5 class="h5">%s</h5>'), 'wiloke'), (wp_unslash($data['skill'])) );
                  }else{
                    echo "<h5 class='h5'>Skill</h5>";
                  }
                ?>     
            </div>
            <!-- END / ITEM -->
          </div>
      <?php  endforeach; endif; endif; ?> 

     </div>
    </div>

  </div>

</section>
<?php 
  do_action("pi_arvios_after_skills");
?>
<?php 
endif;
?>