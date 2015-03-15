<?php 

 

if ( apply_filters('pi_is_section_enable', 'portfolio') ) :
?>
<?php 
  do_action("pi_arvios_before_portfolio");
  $layout       = isset(piThemeOptions::$piOptions['portfolio']['layout']) ? piThemeOptions::$piOptions['portfolio']['layout'] : 'style1';
  $showPosts   = isset(piThemeOptions::$piOptions['portfolio']['showposts']) ? piThemeOptions::$piOptions['portfolio']['showposts'] : 8;
  $effect      = isset(piThemeOptions::$piOptions['portfolio']['hover_effect']) ? piThemeOptions::$piOptions['portfolio']['hover_effect'] : 'style1';
  $args        = array("post_type"=>"pi_portfolio", "posts_per_page"=>$showPosts, "post_status"=>"publish");
?>
<section id="portfolio" class="home-portfolio portfolio<?php pi_add_hidden('portfolio');?> <?php echo esc_attr($layout);?>">
    <?php pi_get_background('portfolio'); ?>
    <div class="container">   
        <div class="st-heading text-center">
            <?php apply_filters( 'pi_the_heading', 'portfolio' ); ?>
            <?php apply_filters( 'pi_the_description', 'portfolio' ); ?>       
        </div>
        <div id="filters" class="text-center">
          <ul> 
            <?php pi_create_nav_filters(); ?>
          </ul>
        </div>    
    </div>
    <?php  
        $page = get_query_var('page') ? get_query_var('page') : 1;
        query_posts( array('post_type'=>'pi_portfolio', 'posts_per_page'=>$showPosts, 'paged'=>$page) ); 
        if ( have_posts() ) :
    ?>
          <div id="portfolio-wrap">
              <?php while( have_posts() ) : the_post(); ?>
              <?php echo pi_render_portfolio_item($post, false, $layout, $effect); ?>
              <?php endwhile; ?>
          </div>
          
          <?php if ( isset(piThemeOptions::$piOptions['portfolio']['button_type']) && !empty(piThemeOptions::$piOptions['portfolio']['button_type']) ) : ?>
          <?php if ( piThemeOptions::$piOptions['portfolio']['button_type'] == 'loadmore' )  : ?>
          <div class="load-more pi-has-button text-center wrap-loadmore-button" style="padding: 50px 0">
              <?php next_posts_link(); ?>
              <a href="#" class="h-btn fire-loadmore text-uppercase"><?php _e('Load more', 'wiloke'); ?></a>
          </div>
          <?php else : ?>
          <div class="view-more-work pi-has-button">
            <a href="<?php echo get_permalink( get_option('_pi_portfolio_id') ); ?>" class="h-btn btn-style-1 text-uppercase"><?php _e('View more work', 'wiloke') ?></a>
          </div>
          <?php endif; ?>
          <?php endif; ?>
    <?php endif; wp_reset_postdata(); ?>
</section>
<?php 
  do_action("pi_arvios_after_portfolio");
?>
<?php 
endif;
?>