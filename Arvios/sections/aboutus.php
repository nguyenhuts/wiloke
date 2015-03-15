<?php 
if ( apply_filters('pi_is_section_enable', 'aboutus') ) :
?> 
<?php  
do_action("pi_arvios_before_about"); 
?>

  <section id="aboutus" class="story<?php pi_add_hidden('aboutus');?>">
    <?php pi_get_background('aboutus'); ?>
    <div class="container">

      <div class="wellcome st-heading text-center">
          <?php apply_filters( 'pi_the_heading', 'aboutus', 'welcome' ); ?>
          <?php apply_filters( 'pi_the_description', 'aboutus' ); ?>
      </div>
     
      
      <?php 
        $getID = apply_filters('pi_get_data', 'aboutus');
        
        if ( $getID ) : 
          $piaData = get_post_meta($getID, "_pi_aboutus", true);
      ?>
      <div class="story-body">
        <div class="row">
            <div class="col-md-5 col-md-push-7">
              <?php 
                if ( isset($piaData['photo']) && !empty($piaData['photo']) ) : 
              ?>
                  <div class="image-wrap">
                    <img src="<?php echo esc_url(wp_get_attachment_url($piaData['photo'])) ?>"  alt="<?php echo get_post_meta($piaData['photo'], '_wp_attachment_image_alt', true); ?>">
                  </div>
              <?php 
                endif; 
              ?>
            </div>

            <div class="col-md-6 col-md-pull-5">
              <?php if (isset($piaData['title'])) : ?>
              <div class="story-head">
                  <?php printf( __('<h4 class="h5 text-uppercase">%s</h4>', 'wiloke'), wp_unslash($piaData['title']) ); ?>
                  <hr class="he-divider">
              </div>
              <?php endif; ?>
              <div class="story-content">
              <?php 
                if ( isset($piaData['intro']) && !empty($piaData['intro']) )
                {
                  echo do_shortcode($piaData['intro']);
                }
              ?>
              </div>  
            </div>
        </div>
      </div>
    <?php 
      endif; 
    ?>
    </div>
  </section>
  
<?php 
  do_action("pi_arvios_after_about");
?>
<?php 
endif;
?>