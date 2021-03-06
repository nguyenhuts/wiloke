<?php 
if ( apply_filters('pi_is_section_enable', 'services') ) :
?> 
<?php 
  do_action("pi_arvios_before_services");
?>
<section id="services" class="service<?php pi_add_hidden('services');?>">
  <?php pi_get_background('services'); ?>
  <div class="container">

    <div class="st-heading text-center">
        <?php apply_filters( 'pi_the_heading', 'services' ); ?>
        <?php apply_filters( 'pi_the_description', 'services' ); ?> 
    </div>
    
    <div class="st-body">
    <div class="row"> 
      <?php  
        $getID = apply_filters('pi_get_data', 'services'); if ( $getID ) : $piaData = get_post_meta($getID, "_pi_services", true); 
        if ( !empty($piaData) ) :
            foreach ( $piaData as $data ) :
      ?>  
        <div class="col-sm-6 col-md-4">

          <div class="service-item">
            <div class="item-head">
              <?php  printf(__(('<i class="%s"></i>'), 'wiloke'), (wp_unslash($data['icon'])) );?>
              <?php printf(__(('<h4 class="h6 text-uppercase">%s</h4>'), 'wiloke'), (wp_unslash($data['service'])) ); ?>
            </div>
            <?php printf(__(('<div class="item-content"><p>%s</p></div>'), 'wiloke'), (wp_unslash($data['small_intro'])) ); ?>
          </div>

        </div> 

      <?php  endforeach; endif; endif; ?> 
      </div>
    </div> 
  </div>   
       
</section> 
<?php 
  do_action("pi_arvios_after_services");
?>
<?php 
endif;
?>