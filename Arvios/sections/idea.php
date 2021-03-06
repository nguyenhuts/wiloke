<?php 
if ( apply_filters('pi_is_section_enable', 'idea') ) :
?>
<?php 
  do_action("pi_arvios_before_idea");
  $data       = isset(piThemeOptions::$piOptions['idea']) ? piThemeOptions::$piOptions['idea'] : array();
?>
<section id="idea" class="do-you-have-an-ideas<?php pi_add_hidden('idea');?>">
  <?php pi_get_background('idea'); ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="tb">
          <div class="tb-cell">
                <div class="item-content">
                    <?php 
                      if ( isset($data['title']) ) :
                         printf(__(('<h4 class="h4 text-uppercase">%s</h4>'), 'wiloke'), (wp_unslash($data['title'])) );
                      elseif( !isset($data['title']) && has_action('customize_controls_init') ) :
                         echo '<h4 class="h4 text-uppercase"></h4>';
                      endif;
                    ?>

                    <?php 
                      if ( isset($data['description']) ) :
                        printf(__(('<p>%s</p>'), 'wiloke'), (wp_unslash($data['description'])) );
                      elseif ( !isset($data['description']) && has_action('customize_controls_init') ) :
                        echo '<p></p>';
                      endif;
                    ?>
                </div>
            </div>
            
            <div class="tb-cell pi-idea">
                <?php  if ( !empty($data['link']) ) : ?>
                  <div class="item-link">
                      <a href="<?php echo esc_url($data['link']); ?>" class="h-btn text-uppercase"><?php printf(__(('%s'), 'wiloke'), (wp_unslash($data['label'])) ); ?></a>
                  </div>
                <?php endif; ?>
            </div>
        </div>
      </div> 
    </div>
  </div>   
</section> 
<?php 
  do_action("pi_arvios_after_idea");
?>
<?php 
endif;
?> 
