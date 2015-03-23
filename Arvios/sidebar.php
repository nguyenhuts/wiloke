<div class="col-md-3">
	<?php 
		$postID = "";
		if ( is_single() || is_page() )
		{
			$postID = $post->ID;
		}
	?>
    <aside class="sidebar <?php echo pi_sidebar_pos($postID); ?>">
    	<?php
    		$exist = false;
    		$isProduct=false;
			if ( is_tax('product_cat')  || is_post_type_archive('product') || is_singular('product') ) 
			{
				$isProduct=true;
				
			}else{
				if ( is_page() && is_page_template("default") )
				{
					global $post;
					if ( has_shortcode($post->post_content, "woocommerce_cart") || has_shortcode($post->post_content, "woocommerce_checkout") || has_shortcode($post->post_content, "woocommerce_my_account") )
					{
						$isProduct = true;
					}
				}
			}

			if ( $isProduct )
			{
				if ( is_active_sidebar( 'pi-woocommerce' ) ) {
					dynamic_sidebar( 'pi-woocommerce' );
					$exist = true;
				}
			}else{
				if ( is_active_sidebar( 'pi-sidebar' ) ){
					dynamic_sidebar( 'pi-sidebar' );
					$exist = true;
				}
			}

			

 			if ( !$exist ) {
				echo sprintf( __( ('<code>%1$s <a href="%2$s" target="_blank">%3$s</a>%4$s</code>'), 'wiloke'), "There is no sidebar content, go ", admin_url("widgets.php"), " here ", " to config"); 
	 		}
    	 ?>
     </aside>
</div>  