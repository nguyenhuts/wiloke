<?php 
  if ( apply_filters('pi_is_section_enable', 'clients') ) :
    $getID = apply_filters('pi_get_data', 'clients');
 
  do_action("pi_arvios_before_clients");
?>

<section id="clients" class="client<?php pi_add_hidden('clients');?>">
  <?php pi_get_background('clients'); ?>
  <div class="container"> 
      <div class="st-heading text-center">
          <?php apply_filters( 'pi_the_heading', 'clients' ); ?>
          <?php apply_filters( 'pi_the_description', 'clients' ); ?>
      </div>
          
      <div class="st-body">
        <div class="row">

          <?php  
            if ( !empty($getID) ) : 
              $piaData = get_post_meta($getID, "_pi_ourclients", true); 

              if ( $piaData ) :
          ?>
              <div class="client-slider">  
              <?php  if ( count($piaData) > 0 ) : foreach ( $piaData as $data ) : ?>
                 <!-- CLIENT ITEM -->
                <div class="client-item">
                    <?php  if ( isset($data['photo']) && !empty($data['photo']) ) :  ?>
                    <div class="image-wrap">
                      <a href="<?php echo isset($data['link']) ? esc_url($data['link']) : '#'; ?>">
                        <img  src="<?php echo wp_get_attachment_url($data['photo']) ?>"  alt="<?php echo get_the_title($getID); ?>">
                      </a>
                    </div>
                    <?php endif; ?>
                </div>
              <?php endforeach; endif; ?>
              </div>

          <?php endif;endif; ?>
        </div>
      </div>

  </div>
</section>

<?php 
  do_action("pi_arvios_after_clients");
  endif;
?>
