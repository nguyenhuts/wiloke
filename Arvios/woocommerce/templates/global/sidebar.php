<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="col-md-3">
	<?php 
		$postID = "";
		if ( is_single() || is_page() )
		{
			$postID = $post->ID;
		}
	?>
    <aside class="sidebar <?php echo pi_sidebar_pos($postID); ?>">
    	<?php if ( is_active_sidebar( 'pi-woorcomerce' ) ) : ?>
    	<?php dynamic_sidebar( 'pi-woorcomerce' ); ?>
    	<?php else : ?>
		<?php echo sprintf( __( ('<code>%1$s <a href="%2$s" target="_blank">%3$s</a>%4$s</code>'), 'wiloke'), "There is no sidebar content, go ", admin_url("widgets.php"), " here ", " to config"); ?> 
    	<?php endif; ?>
     </aside>
</div>  