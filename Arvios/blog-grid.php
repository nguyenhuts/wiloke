<?php 
/* Template Name: Blog - Grid */ 
?>

<?php  get_header(); ?>
<?php  pi_blog_header($post->ID); ?>
    <!-- BLOG CONTENT -->
    <section class="blog-wrap">

        <div class="container">
            <div class="row">
                <?php $sidebarPos = pi_sidebar_pos($post->ID); ?>
                    <div class="<?php pi_sidebar_class($sidebarPos) ?>">
                        <div class="row">
                            <?php 
                                /*Main Content*/
                                $postPerPages = get_option("posts_per_page");
                                $args = array(
                                    'posts_per_page'      => $postPerPages,
                                    'post_type'           => 'post',
                                    'paged'                => ( get_query_var('paged') ? get_query_var('paged') : 1 )
                                );
                                query_posts($args);
                                if ( have_posts() ) : 
                                $isSticky = is_sticky() ? 'pi_sticky' : '';
                            ?>
                                <div class="blog-grid pi-modern-listing">
                                    <?php  while( have_posts() ) : the_post(); ?>
                                    <div class="grid-sizer"></div>
                                	
            					 	<!-- POST -->
                                    <div class="<?php echo esc_attr($isSticky); ?> post post-single">
                                        <?php 
                                        	pi_post_media($post->ID, true, 'arvios-grid');
                                        ?>
                                        <div class="post-body">
                                            <div class="post-title"><h2 class="h6"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
                                            <?php 
                                                pi_get_meta_data();
                                            ?>
                                        </div>
                                    </div>
                                    <?php 
                                    	endwhile;
                                    ?>
                                </div>

                                <!-- PAGINATION -->
                                <?php get_template_part("pagination"); ?>
                                <?php endif;wp_reset_query(); ?>
                        </div>
                    </div>
                <?php if ( $sidebarPos != 'no-sidebar' ) : ?>
                <?php get_sidebar();  ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>
