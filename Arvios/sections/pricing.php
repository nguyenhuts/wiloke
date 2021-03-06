<?php 
if ( apply_filters('pi_is_section_enable', 'pricing') ) :
?> 
<?php 
  do_action("pi_arvios_before_pricing");
?>
<section id="pricing" class="pricing<?php pi_add_hidden('pricing');?>">
  <?php pi_get_background('pricing'); ?>
  <div class="container">

    <div class="st-heading text-center">
        <?php apply_filters( 'pi_the_heading', 'pricing' ); ?>
        <?php apply_filters( 'pi_the_description', 'pricing' ); ?> 
    </div>
    
    <div class="st-body">
      <div class="row">
        <?php  
          $getID = apply_filters('pi_get_data', 'pricing'); 
          if ( $getID ) : 
            $piaData = get_post_meta($getID, "_pi_pricingtable", true); 
            if ( !empty($piaData) ) :
                foreach ( $piaData as $data ) :
        ?>  
                  <div class="col-md-4">
                    <div class="pricing-item text-center <?php echo isset($data['highlight']) && !empty($data['highlight']) ? 'light-item' : ''; ?>">
                        <div class="item-heading">
                            <?php  printf(__(('<h4 class="h4 text-uppercase">%s</h4>'), 'wiloke'), (wp_unslash($data['title'])) );?>
                        </div>
                        <div class="item-price">
                            <span class="amount">
                                <?php echo isset($data['currency']) ? wp_unslash($data['currency']) : ''; ?><?php echo isset($data['price']) ? wp_unslash($data['price']) : ''; ?>
                            </span>
                            <?php echo isset($data['duration']) ? '<span class="pi-duration">'.  wp_unslash($data['duration']) . '</span>' : ''; ?>
                        </div>
                        <div class="item-body">
                            <?php if ( isset($data['offers']) && count($data['offers']) > 0 ) : ?>
                            <ul>
                                <?php foreach ( $data['offers'] as $offer ) : ?>
                                <?php  printf(__(('<li>%s</li>'), 'wiloke'), (wp_unslash($offer)) );?>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                        <?php if ( isset($data['url'])  ) : ?>
                        <div class="item-footer">
                            <a class="h-btn text-uppercase" href="<?php echo esc_url($data['url']); ?>" target="_blank"><?php  printf(__(('%s'), 'wiloke'), (wp_unslash($data['button_name'])) );?></a>
                        </div>
                        <?php endif; ?>
                    </div>
                  </div> 

        <?php  endforeach; 
            endif; 
          endif; 
        ?>      
      </div> 
    </div>
  </div>   
       
</section> 
<?php 
  do_action("pi_arvios_after_pricing");
?>
<?php 
endif;
?>