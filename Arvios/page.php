<?php get_header(); ?>
	
<?php pi_blog_header($post->ID); ?>	

<!-- BLOG CONTENT -->
<section class="blog-wrap"> 
	<div class="container">
		<div class="row">
			<?php $sidebarPos = pi_sidebar_pos($post->ID); ?>
			<div class="<?php pi_sidebar_class($sidebarPos) ?>">
				<?php  while( have_posts() ) : the_post();  ?>
				<div class="blog-single blog-list">

                    <div class="post post-single">
                    	<?php 
						$allow = true;
						if ( is_page_template("default")  )
						{
							if ( has_shortcode($post->post_content, "woocommerce_cart") || has_shortcode($post->post_content, "woocommerce_checkout") || has_shortcode($post->post_content, "woocommerce_my_account") )
							{
								$allow = false;
							}
						}
						if ( $allow )
						{
                    		pi_post_media($post->ID);
                    	}
                    	?>
						<div class="post-title">
                            <h2 class="h4 title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <!-- Meta data --> 
                        <?php 
                        if ( $allow )
                        {
                        	pi_get_meta_data(); 
                        }
                        ?>

                        <!-- Content -->
                        <div class="post-body">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
							<?php edit_post_link('Edit this entry.', '<br /><p class="edit-this">', '</p>'); ?>
                        </div>
						<?php 
						if ( $allow ) :
						?>
						<!-- Tags -->
						<div class="pi-wrap-sharing-tag">
		            	<?php pi_sharing_box(); ?>
		            	</div>

						<!-- Post author -->
						<?php
							pi_post_author($post->post_author, $post->ID);
						endif;
						?>	
					</div>
                 	<!-- COMMENTS -->
					<?php comments_template(); ?>

                </div>
            	<?php endwhile; ?>
			</div>
		 	<?php if ( $sidebarPos != 'no-sidebar' ) : ?>
            <?php get_sidebar();  ?>
            <?php endif; ?>

		</div>
	</div>
</section>

<?php get_footer(); ?>
