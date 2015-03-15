<?php get_header(); ?>
<?php pi_blog_header(); ?>


    <!-- BLOG CONTENT -->
    <section class="blog-wrap">

        <div class="container">
            <div class="row">
                <?php $sidebarPos = pi_sidebar_pos(); ?>
                <div class="<?php pi_sidebar_class($sidebarPos) ?>">
                    <div class="blog-list">

                    	<?php 
                    	if ( have_posts() ) :
                    		while( have_posts() ) : the_post();
                            $isSticky = is_sticky() ? 'pi_sticky' : '';
                    	?>
					 	<!-- POST -->
                        <div class="<?php echo esc_attr($isSticky); ?> post post-single">
                            <?php 
                            	pi_post_media($post->ID);
                            ?>
                            <div class="post-title">
                                <?php if (get_post_format()): ?>
                                <a href="<?php the_permalink() ?>"><span class="post-format-icon <?php echo esc_attr(get_post_format()); ?>"><?php
                                   echo apply_filters('pi_post_formats_icon', ''); ?></span></a>
                                <?php endif; ?>
                                <h2 class="h4 title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <?php 
                                pi_get_meta_data();
                            ?>
                            <div class="post-body"> 
								<?php the_excerpt(); ?>
                            </div>
                            <div class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="h-btn"><?php _e('Read more', 'wiloke'); ?></a>
                            </div>
                        </div>
                        <?php 
                        	endwhile;
                        ?>

                        <!-- PAGINATION -->
						<?php get_template_part("pagination"); ?>
						<?php endif; ?>

                    </div>
                </div>
                <?php if ( $sidebarPos !='no-sidebar' ) : ?> 
                <?php get_sidebar();  ?>
                <?php endif; ?>
            </div>
        </div>

    </section>

<?php get_footer(); ?>
