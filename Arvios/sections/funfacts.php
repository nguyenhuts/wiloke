<?php 
if ( apply_filters('pi_is_section_enable', 'funfacts') ) :
?>
<?php 
  do_action("pi_arvios_before_funfacts");
?>
<section id="funfacts" class="funfact<?php pi_add_hidden('funfacts');?>">
  <?php pi_get_background('funfacts'); ?>
  <div class="container">
    <div class="st-heading text-center">
        <?php apply_filters( 'pi_the_heading', 'funfacts' ); ?>
        <?php apply_filters( 'pi_the_description', 'funfacts' ); ?> 
    </div>
    <div class="st-body">
    <div class="row">
      <?php  
        $getID = apply_filters('pi_get_data', 'funfacts'); if ( $getID ) : $piaData = get_post_meta($getID, "_pi_funfacts", true); 
        if ( !empty($piaData) ) :
            foreach ( $piaData as $data ) :
      ?>  
        <div class="col-xs-6 col-md-3">

          <div class="funfact-item text-center">
              <?php printf( '<i class="%s"></i>', wp_unslash($data['icon']) );?>
              <?php printf(__(('<span class="countup">%s</span>'), 'wiloke'), (wp_unslash($data['total'])) ); ?>
              <?php printf(__(('<h4 class="h6 text-uppercase">%s</h4>'), 'wiloke'), (wp_unslash($data['name'])) ); ?>
          </div>

        </div> 

      <?php  endforeach; endif; endif; ?>  
    </div>
    </div>
  </div>
</section> 
<?php 
  do_action("pi_arvios_after_funfacts");
?>
<?php 
endif;
?>   
