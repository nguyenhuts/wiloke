<?php get_header(); ?>
<?php pi_blog_header($post->ID); ?>	

<!-- BLOG CONTENT -->
<section id="post-<?php the_ID(); ?>" <?php post_class("blog-wrap"); ?>>
	<div class="container">
		<div class="row"> 
			<?php $sidebarPos = pi_sidebar_pos($post->ID); ?>
			<div class="<?php pi_sidebar_class($sidebarPos) ?>">
				<?php  while( have_posts() ) : the_post();  ?>
				<div class="blog-single blog-list">
                    <div class="post post-single">
                    	<?php pi_post_media($post->ID); ?>
						<div class="post-title">
                            <?php if (get_post_format()): ?>
                            <a href="<?php the_permalink() ?>"><span class="post-format-icon <?php echo esc_attr(get_post_format()); ?>"><?php
                               echo apply_filters('pi_post_formats_icon', ''); ?></span></a>
                            <?php endif; ?>
                            <h2 class="h4 title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <!-- Meta data --> 
                        <?php pi_get_meta_data(); ?>
                        
                        <!-- Content -->
                        <div class="post-body">
							<?php the_content(); ?>
							<?php 
							wp_link_pages(); 
							?>
							<?php edit_post_link('Edit this entry.', '<br /><p class="edit-this">', '</p>'); ?>
                        </div>
						
						<!-- Tags -->
						<div class="pi-wrap-sharing-tag">
							
							<?php if ( has_tag() ) : ?>
			                <div class="tags-wrap">
			                	<i class="fa fa-tag"></i>
			                	<div class="tag">
								<?php  the_tags();  ?>
								</div>
			                </div> <!-- /post-tags -->
			            	<?php endif; ?>
			            	<?php pi_sharing_box(); ?>
		            	</div>

						<!-- Post author -->
						<?php 
							pi_post_author($post->post_author, $post->ID);
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
