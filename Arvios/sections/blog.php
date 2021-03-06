<?php 
  if ( apply_filters('pi_is_section_enable', 'blog') ) :
?>
<?php 
  do_action("pi_arvios_before_blog");
?>

<!-- BLOG -->
<section id="blog-section" class="blog-section<?php pi_add_hidden('blog');?>">
  <?php pi_get_background('blog'); ?>
  <div class="container">

    <div class="st-heading text-center">
      <?php apply_filters( 'pi_the_heading', 'blog' ); ?>
      <?php apply_filters( 'pi_the_description', 'blog' ); ?>
    </div>
    
    <div class="st-body">
      <div class="row">
          <div class="blog-grid">
            <div class="grid-sizer"></div>

                <?php  
                    $showPosts = apply_filters('pi_get_data', 'blog');

                    if ( !$showPosts )
                    {
                      $showPosts = get_option('posts_per_page');
                    }
                    $args  = array("posts_per_page"=>$showPosts, "post_status"=>"publish");
                    $piBlogId = get_option("_pi_page_id");

                    $i = 0;
                    query_posts($args);
                   
                    if( have_posts() ) : while ( have_posts() ) : the_post();
                    $addw2 = $i == 0 ? "" : "";
                ?>         
                  <div class="post post-single <?php echo esc_attr($addw2); ?>">
                      <div class="post-media">
                        <?php  the_post_thumbnail('arvios-grid'); ?>
                        <?php if (get_post_format()): ?>
                         <a class="pi-wrap-post-format" href="<?php the_permalink() ?>"><span class="post-format-icon <?php echo esc_attr(get_post_format()); ?>"><?php
                            echo apply_filters('pi_post_formats_icon', ''); ?></span></a>
                        <?php endif; ?>
                      </div>
                      <!-- .entry-header -->
                      <div class="post-body">
                        <div class="post-title">
                          <h2 class="h6"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <!-- .entry-content -->
                        <?php pi_get_meta_data(); ?>
                      </div>
                  </div>
                <?php 
                    $i++;
                  endwhile; endif; wp_reset_query();
                ?>
              
            
          </div>
      </div>
    </div>

   <?php if ( $piBlogId && !empty($piBlogId) ) : ?>
    <div class="st-footer pi-wrap-blogbutton text-center">
        <a class="h-btn btn-style-2" href="<?php echo get_permalink($piBlogId); ?>"><?php _e('View All Posts', 'wiloke') ?></a>
    </div>
    <?php endif; ?>
    
   </div>
</section>

<?php 
  do_action("pi_arvios_after_blog");
?>
<?php 
endif;
?>

