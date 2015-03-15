<?php get_header(); ?>
<?php pi_blog_header($post->ID); ?>	

<!-- BLOG CONTENT -->
<section id="post-<?php the_ID(); ?>" <?php post_class("blog-wrap"); ?>>
	<div class="container">
		<div class="row"> 
			
			<div class="col-md-10 col-md-offset-1">
				
				<div class="blog-single blog-list">
					<?php  while( have_posts() ) : ?>
					<div class="nav-portfolio">
						<?php previous_post_link( '&laquo; %link', 'Prev' );  ?>
						<a href="<?php echo get_permalink( get_option('_pi_portfolio_id') ); ?>"><i class="fa fa-th-large"></i></a> 
						<?php next_post_link( '%link &raquo;', 'Next' );  ?>
						
					</div>
					<?php the_post();  ?>
                    <div class="post post-single">

                    	<?php pi_post_media($post->ID, false, 'full', 'portfolio'); ?>
						<div class="post-title">
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
					</div>
					<?php comments_template(); ?>
					<?php endwhile; ?>
                </div>
            	
			</div>


		</div>
	</div>
</section>

<?php get_footer(); ?>
