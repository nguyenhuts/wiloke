<?php  
if ( apply_filters('pi_is_section_enable', 'team') ) :
?>
<?php 
  do_action("pi_arvios_before_team");
?>
<section id="team" class="team<?php pi_add_hidden('team');?>">
  <?php pi_get_background('team'); ?>
  <div class="container"> 
      
      <!-- Title and description -->
      <div class="st-heading text-center">
          <?php apply_filters( 'pi_the_heading', 'team' ); ?>
          <?php apply_filters( 'pi_the_description', 'team'); ?> 
      </div>

    <div class="st-body">
        <div class="row">
            <div class="team-slider">

            <?php 
              $getID = apply_filters('pi_get_data', 'team'); 

              if ( $getID ) :  
                $piaData = get_post_meta($getID, "_pi_ourteam", true);
                  foreach ( $piaData as $data ) :
            ?>
                  <figure class="team-item text-center">
                    <div class="image-wrap">
                      <?php if ( isset($data['photo']) && !empty($data['photo']) ) : ?>
                      <img src="<?php echo esc_url(wp_get_attachment_url($data['photo'])) ?>"  alt="<?php echo get_post_meta($data['photo'], '_wp_attachment_image_alt', true); ?>">
                      <?php  endif;  ?>
                      <div class="team-social social">
                        <?php if ( isset($data['social_link']) && !empty($data['social_link']) ) : ?>
                        <?php pi_social_render($data); ?>
                        <?php endif; ?>
                      </div>
                    </div> 
                    <figcaption class="caption">
                        <?php printf(__(('<h4 class="h5 text-uppercase">%s</h4>'), 'wiloke'), (esc_attr($data['name'])) ); ?>
                        <?php printf(__(('<span>%s</span>'), 'wiloke'), (esc_attr($data['position'])) ); ?>
                        <?php //printf(__(('<p>%s</p>'), 'wiloke'), (esc_attr($data['intro'])) ); ?>
                    </figcaption>
                  </figure>
            <?php 
                  endforeach;
              endif; 
            ?>

          </div>
        </div>
    </div>

</div>
</section>
<?php 
  do_action("pi_arvios_after_team");
?>
<?php 
endif;
?>