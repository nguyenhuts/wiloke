<?php 
/* Template Name: Blog - Masonry Layout */ 
?>

<?php  get_header(); ?>
<?php  pi_blog_header($post->ID); ?>
	<section class="blog-wrap">
		<div class="container">
			<div class="row">
				<?php $sidebarPos = pi_sidebar_pos($post->ID); ?>
				<div class="<?php pi_sidebar_class($sidebarPos) ?>">
						<div class="row">
						<?php 
						 	$postPerpage = get_option("posts_per_page");
							$args = array(
								'posts_per_page'      => $postPerpage,
								'post_type'			  => 'post',
								'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1 )
							);
							query_posts($args);
                    		if ( have_posts() ) : 
                    	?>
	                    	<div class="blog-grid-2 pi-post-wrapper">
	                    	<?php 
	                    			while( have_posts() ) : the_post();
	                            		$isSticky = is_sticky() ? 'pi_sticky' : '';
							?>
										<div class="<?php echo esc_attr($isSticky); ?> grid-item post post-single col-sm-6">
				                            <?php 
				                            	$aSize = array("arvios-f-masonry", "arvios-s-masonry", "arvios-grid");
				                            	$random_keys = array_rand($aSize,1);
				                            	$size      = $aSize[$random_keys];
				                            	pi_post_media($post->ID, true, $size);
				                            ?>
				                            <div class="post-title">
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
							</div>
						</div>
						<?php get_template_part("pagination"); ?>
						<?php endif;wp_reset_postdata(); ?>
					
				</div>
				<?php if ( $sidebarPos != 'no-sidebar' ) : ?>
		                <?php get_sidebar();  ?>
		                <?php endif; ?>
			</div>
			
		</div>
	</section>
<?php 
get_footer();
