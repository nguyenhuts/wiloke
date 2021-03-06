<?php 
/* Template Name: Portfolio  */ 
?>
<?php  get_header(); ?>
<?php  pi_blog_header($post->ID); ?>
<?php 
    $showPosts = get_option('show_portfolio_'.$post->ID);
    $style     = get_option('portfolio_style_'.$post->ID);

?>
<!-- PORTFOLIO -->
<section id="page-portfolio" class="portfolio <?php echo esc_attr($style); ?>">
    <div class="container">
        <div id="filters" class="text-center">
            <ul>
               <?php pi_create_nav_filters(); ?>
            </ul>
        </div> 
    </div>

    <?php 
        $page = get_query_var('paged') ? get_query_var('paged') : 1;
        query_posts( array('post_type'=>'pi_portfolio', 'posts_per_page'=>$showPosts, 'paged'=>$page) );
    ?>
    
    <?php if ( have_posts() ) : ?>
    <div id="portfolio-wrap">
       <?php 
            while( have_posts() ) : the_post();
                echo pi_render_portfolio_item($post, true, $style);
            endwhile;
       ?>
    </div>
    <div class="load-more text-center wrap-loadmore-button" style="padding: 50px 0">
        <?php next_posts_link(); ?>
        <a href="#" class="h-btn fire-loadmore text-uppercase"><?php _e('Load more', 'wiloke'); ?></a>
    </div>
    <?php endif; wp_reset_query(); ?>

</section>
<!-- END / PORTFOLIO -->
<?php get_footer(); ?>