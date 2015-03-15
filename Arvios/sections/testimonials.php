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
        <span class="h3"><i class="fa fa-quote-right"></i></span>
        <?php apply_filters( 'pi_the_heading', 'testimonials' ); ?>
        <?php apply_filters( 'pi_the_description', 'testimonials' ); ?>
      </div>
      <?php 
        if ( count($piaData) > 0 ) :
      ?>
        <div class="row">
          <div class="st-body">
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