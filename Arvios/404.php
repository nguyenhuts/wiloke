<?php 
	get_header(); 
?>	
	<div class="background-page page-not-found-bg">
			
		<div class="bg-parallax" style="background-image:url(<?php echo isset(piThemeOptions::$piOptions['404']['background']) && !empty(piThemeOptions::$piOptions['404']['background']) ?  esc_url(piThemeOptions::$piOptions['404']['background']) : 'http://placehold.it/2000x1600&text=image'; ?>)"></div>
		<div class="bg-overlay">
		</div><!-- /overlay -->
		<div class="container">
			<div class="tb">
				<div class="tb-cell">
					<div class="st-body text-center">
						<!--
						* 
						*==============	Page not found ==============
						*
						-->
						<div class="st-heading text-center">
							<h2 class="h1 text-uppercase"><?php _e('Page Not Found !', 'wiloke') ?></h2>
							<hr class="he-divider">
							<p class="sub-title"><?php _e('You look lost',  'wiloke') ?></p>
							<a class="h-btn" href="<?php echo esc_url( home_url() ) ?>" title=""><?php _e('Go to home',  'wiloke') ?></a>
						</div>
						<!-- /page-not-found -->
					</div>
				</div>
			</div><!-- /tbl --> 
			
		</div>	
	</div><!-- /background-page -->
<?php 
	get_footer();
?>