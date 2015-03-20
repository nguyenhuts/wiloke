<?php
  if ( apply_filters('pi_is_section_enable', 'testimonials') ) :
  $getID = apply_filters('pi_get_data', 'testimonials');

  do_action("pi_arvios_before_testimonials");
  if ( $getID ) :   $piaData = get_post_meta($getID,"_pi_testimonials", true);
?>
<section id="testimonials" class="testimonial<?php pi_add_hidden('testimonials');?>">
  <?php pi_get_background('testimonials'); ?>
  <div class="container">
      <div class="st-heading text-center">
        <?php apply_filters( 'pi_the_heading', 'testimonials' ); ?>
        <?php apply_filters( 'pi_the_description', 'testimonials' ); ?>
      </div>
      <?php 
        if ( count($piaData) > 0 ) :
      ?>
        <div class="st-body">
          <div class="row">
            <div class="testimonial-slider">
                <?php 
                  foreach ( $piaData as $k => $data ) :
                ?>
                <!-- ITEM -->
                <div class="item text-center">
                  <blockquote>
                    <?php  if ( isset($data['testimonial']) && !empty($data['testimonial']) ) : ?>
                    <?php printf(__(('<p>%s</p>'), 'wiloke'), (wp_unslash($data['testimonial'])) ); ?>
                    <?php endif; ?>
                    <div class="testimonial-photo">
                      <?php
                      if ( isset($data['photo']) && !empty($data['photo']) ) :
                      ?>
                        <img src="<?php echo esc_url(wp_get_attachment_url($data['photo'])) ?>"  alt="<?php echo get_post_meta($data['photo'], '_wp_attachment_image_alt', true); ?>">
                      <?php
                      endif;
                      ?>
                    </div>
                    <footer>
                    <?php  
                      if ( isset($data['author']) && !empty($data['author']) ) : 
                        printf(__(('<span class="author">%s</span>'), 'wiloke'), (wp_unslash($data['author'])) );
                      endif; 
                      if ( isset($data['website']) && !empty($data['website']) ) : 
                        printf(__(('<a class="website" href="%1$s">%2$s</a>'), 'wiloke'), (esc_url($data['website'])), wp_unslash($data['website']) );
                      endif; 
                    ?>
                    </footer>
                  </blockquote>
                </div>
                <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php  endif; ?>
        
     
  </div>
</section>
<?php endif;
  do_action("pi_arvios_after_testimonials");
endif; 
?>