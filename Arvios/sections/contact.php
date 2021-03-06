<?php  
  if ( apply_filters('pi_is_section_enable', 'contact') ) :
?>

<?php 
  do_action("pi_arvios_before_contact");
?> 
<section id="contact" class="section section-contact pd-bottom-none<?php pi_add_hidden('contact');?>">
  <?php pi_get_background('contact'); ?>
  <div class="container">
  
    <div class="st-heading text-center">
        <?php apply_filters( 'pi_the_heading', 'contact' ); ?>
        <?php apply_filters( 'pi_the_description', 'contact' ); ?>
    </div>
    
    <div class="st-body">
      <div class="row">
      
        <?php if ( has_action('customize_controls_init') || ( isset(piThemeOptions::$piOptions['contact']['contact_form']) && !empty(piThemeOptions::$piOptions['contact']['contact_form']) ) ) : ?>
        <?php do_action('pi_arvios_before_contact_form'); ?>
          <div class="col-md-7">
            <div class="contact-form pi-fix-display-one <?php pi_add_hidden('contact', 'contact_form'); ?>">                     
               <?php 
                  apply_filters('pi_get_contactform', 'wiloke');
                ?>
            </div>
          </div>
        <?php do_action('pi_arvios_after_contact_form'); ?>
        <?php endif; ?>

        <?php if ( has_action('customize_controls_init') || ( isset(piThemeOptions::$piOptions['contact']['contact_detail']) && !empty(piThemeOptions::$piOptions['contact']['contact_detail']) ) ) : ?>
        <div class="col-md-5">
        <div class="contact-info <?php pi_add_hidden('contact', 'contact_detail'); ?> pi-fix-display-one">
              <div class="pi-info-title">
                  <?php printf( __('<p>%s</p>', 'wiloke'), wp_unslash(piThemeOptions::$piOptions['contact']['contact_detail_title']) ); ?>
              </div>
              <?php
                if ( isset(piThemeOptions::$piOptions['contact']['info']) ) :
                  do_action('pi_arvios_before_contact_info');
                  foreach ( piThemeOptions::$piOptions['contact']['info'] as $key => $info ) :
              ?>
                  <div class="item">
                      <i class="<?php echo wp_unslash(piThemeOptions::$piOptions['contact']['info_icon'][$key]); ?>"></i>
                      <span class="text-uppercase"><?php printf( __('%s', 'wiloke'), wp_unslash($info) ); ?></span>
                  </div>
              <?php 
                  endforeach;
                  do_action('pi_arvios_after_contact_info');
                endif;
              ?>    
        </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php if ( has_action('customize_controls_init') || ( isset(piThemeOptions::$piOptions['contact']['enablegooglemap']) && !empty(piThemeOptions::$piOptions['contact']['enablegooglemap']) ) ) : 
  ?>
  <div id="map" class="<?php pi_add_hidden('contact', 'enablegooglemap'); ?>"></div>
  <?php endif; ?>



</section>
<?php 
  do_action("pi_arvios_after_contact");
?>
<?php 
endif;
?>