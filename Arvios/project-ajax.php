<?php
    $id = get_the_ID();

    $aData      = get_post_meta($id, '_pi_portfolio', true);
    $type       = isset($aData['media_type']) && !empty($aData['media_type']) ?  $aData['media_type'] : '';

?>

<div class="tb">
    <?php 
        if ( $type == 'gallery' || $type == 'flickr' ) :
   
            $gallery  = "";
            if ( $type == 'gallery' )
            {
                $getID = isset($aData['image_id']) && !empty($aData['image_id']) ? $aData['image_id'] : '';

                if ( $getID )
                {
                    $parseID = explode(",", $getID);
                    foreach ( $parseID as $imgId )
                    {
                        if ( wp_attachment_is_image($imgId) )
                        {
                            $gallery .= '<div class="item">' . wp_get_attachment_image( $imgId, 'full' ) .'</div>' ;
                        }
                    }
                } 
 
            }elseif($type == 'flickr'){
                $getAllImages = isset($aData['flickr_get_data']) && !empty($aData['flickr_get_data']) ? $aData['flickr_get_data'] : '';
                if ( $getAllImages )
                {
                    $parse = explode(",", $getAllImages);
                    foreach ( $parse as $img )
                    {
                        $gallery .= '<div class="item"><img src="'.esc_url($img).'" alt="'.esc_attr(get_the_title($id)).'"></div>';  
                    }
                }
            }

            $colMd = !empty($gallery) ? "tb-cell" : "col-md-12";
   
            if ( !empty($gallery) ) : 
    ?>
            <div class="tb-cell">
                <div class="pp-slider">
                   <?php echo $gallery; ?> 
                </div>
            </div>
    <?php  
            endif; 
        else : 

            $video = isset($aData['video_link']) && !empty($aData['video_link']) ? $aData['video_link'] : '';
            if ( !empty($video) ) :
            $colMd = "tb-cell";
    ?> 

            <div class="tb-cell">
                <div class="video embed-responsive embed-responsive-16by9">
                    <?php 
                        if ( $aData['video_type'] == 'youtube' )
                        {
                            echo '<iframe class="embed-responsive-item" src="//www.youtube.com/embed/'.esc_attr($aData['video_id']).'"></iframe>'; 
                        }else{
                            echo '<iframe class="embed-responsive-item" src="//player.vimeo.com/video/'.esc_attr($aData['video_id']).'"></iframe>';
                        }   
                    ?>
                </div>
            </div>
    <?php 
            else :
                $colMd      =  "col-md-12";
            endif;
        endif; 
    ?>
    
    <div class="<?php echo esc_attr($colMd); ?>">
        <div class="about-project">
            <?php printf( (__('<h4>%s</h4>', 'wiloke')), get_the_title($id) ); ?>
            <?php 
               $getPost = get_post( $id );
                if ( $getPost->post_content ) :
                    printf('<p>%s</p>', wp_unslash($getPost->post_content));
                endif;
            ?>
        </div>
       
    </div>
</div>
