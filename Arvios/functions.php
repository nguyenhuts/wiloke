<?php


/**
 * Configure front-end 
 * 
 */
require_once ( 'configs/configs.php' );

 
/* --------------------------- */
/* Defines
/* --------------------------- */
define('PI_ADMIN', get_template_directory() . '/admin/');
define('PI_ADMIN_MD', get_template_directory() . '/admin/pi-modules/');

define('PI_ADMIN_CSS_URL', get_template_directory_uri() . '/admin/pi-assets/css/');
define('PI_ADMIN_JS_URL',  get_template_directory_uri() . '/admin/pi-assets/js/');

 
add_action('wp_enqueue_scripts', 'arvios_enqueue_script', 100);

/*  f
 *  Configs 
*/
include ( PI_ADMIN . 'pi_configs.php' );
include ( PI_ADMIN . 'class.pi_framewokr.php' );

 
if ( ! isset( $content_width ) ) $content_width = 900;

add_theme_support( 'html5', array( 'search-form' ) );
 


function arvios_enqueue_script()
{
    wp_enqueue_style('arvios-style', get_stylesheet_uri(), array(), '1.0' );
    $getSkin = isset(piThemeOptions::$piOptions['design']['color_scheme']) ? piThemeOptions::$piOptions['design']['color_scheme'] : 'default';
            
    $fileUrl = get_template_directory_uri() . '/assets/css/color/';

    if ( $getSkin == 'pi_use_custom_color' )
    {
        $getSkin = "custom";
        $uploads = wp_upload_dir();
        if ( file_exists($uploads['basedir'] . '/wiloke/custom.css') )
        {
            $fileUrl = $uploads['baseurl'] . '/wiloke/';
        }
    }else{
        $getSkin = trim($getSkin);
    }

    if ( $getSkin != 'default' )
    {
        wp_register_style('arvios_skin', $fileUrl . $getSkin . '.css', array('arvios-style'), '1.0');
        wp_enqueue_style('arvios_skin');
    }
}

if (function_exists('add_theme_support'))
{   
    // Add Menu Support$thum 
    add_theme_support( 'woocommerce' );
    add_theme_support('menus');
    add_theme_support('custom-header');
    add_theme_support('custom-background');
    // Add Thumbnail Theme Support
    add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'video', 'audio' ) );
    add_theme_support('post-thumbnails');
    add_theme_support( 'automatic-feed-links' );
    
    add_image_size( 'arvios-grid', 400, 400, true);
    add_image_size( 'arvios-f-masonry', 400, 300, true);
    add_image_size( 'arvios-s-masonry', 300, 200, true);
    
    load_theme_textdomain('wiloke', get_template_directory() . '/languages');
    function pi_theme_add_editor_styles() {
        add_editor_style( 'custom-editor-style.css' );
    }
    add_action( 'after_setup_theme', 'pi_theme_add_editor_styles' );
}



// Pagination
function pi_pagination() 
{


    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }


    
    $pattern = '#(www\.|https?:\/\/){1}[a-zA-Z0-9]{2,254}\.[a-zA-Z0-9]{2,4}[a-zA-Z0-9.?&=_/]*#i';

    $big = 999999999; // need an unlikely integer
    $pager_links = paginate_links( array(
        'base'          => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'        => '?paged=%#%',
        'current'       => max( 1, get_query_var('paged') ),
        'total'         => $GLOBALS['wp_query']->max_num_pages,
        'prev_text'     => __('<i class="fa fa-caret-left"></i>', 'wiloke'),
        'next_text'     => __('<i class="fa fa-caret-right"></i>', 'wiloke'),
        'type'          => 'array',
    ) );
   
    $count_links = count($pager_links);
   
    if ($count_links > 0) { 
        $first_link = $pager_links[0];
        $last_link = $first_link;

        echo  $first_link ;
        for ($i=1; $i<$count_links; $i++) {
            $pager_link =  $pager_links[$i];
            if (!pi_string_contains($pager_link, 'current'))
            {
                echo   $pager_link;
            }
            else
            { 
                echo $pager_link;
            }
            $last_link = $pager_link;
        }
    }
}


function pi_string_contains($haystack, $needle) 
{
    if (strpos($haystack, $needle) !== FALSE)
        return true;
    else
        return false;
}

function pi_sharing_box()
{
    global $post;
    if ( isset(piThemeOptions::$piOptions['posts_settings']['sharingbox']) && !empty(piThemeOptions::$piOptions['posts_settings']['sharingbox']) ) :
    ?>
    <div class="author-social">
        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>"><i class="fa fa-facebook"></i></a>
        <a href="http://twitthis.com/twit?url=<?php the_permalink(); ?>"><i class="fa fa-twitter"></i></a>
        <a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"><i class="fa fa-linkedin"></i></a>
        <a href="http://www.tumblr.com/share/link?url=<?php echo urlencode(esc_url(get_permalink())); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>"><i class="fa fa-tumblr"></i></a>
        <a href="http://google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"><i class="fa fa-google-plus"></i></a>
        <a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>"><i class="fa fa-envelope"></i></a>
    </div>
    <?php  
    endif;
}

function pi_post_author($userID, $postID)
{
   $postMeta = get_post_meta($postID, "_post_settings", true);

   $con = false;
   $allow = false;

   if ( isset($postMeta['post_author']) && $postMeta['post_author'] != 'default' )
   {
        $allow = $postMeta['post_author'] == 'enable' ? true : false;
   }else{
        $con = true;
   }

   if ( $con )
   {
        $allow = isset(piThemeOptions::$piOptions['posts_settings']['post_author']) ? true : false;
   }

    if ( $allow ) :
        $aAuthorData = array_map( function( $a ){ return $a[0]; }, get_user_meta( $userID ) );
    ?>
        <div class="about-author">
            <div class="image-thumb fl">
                <?php if ( isset($aAuthorData['_pi_avatar']) &&  !empty( $aAuthorData['_pi_avatar'] ) ) : ?>
                <img src="<?php echo esc_url( $aAuthorData['_pi_avatar'] ) ?>" alt="<?php echo wp_unslash( $aAuthorData['nickname'] ) ?>">
                <?php else :
                echo get_avatar(  get_the_author_meta( $userID ), 270);
                endif;
                ?>
            </div>
            <div class="author-info">
                <?php printf('<div class="author-name"><h3>%s</h3></div>', wp_unslash( $aAuthorData['nickname'] ) ) ?>
          
                <div class="author-content">
                <?php 
                    if (  !empty( $aAuthorData['description'] )  ) 
                    {
                        printf('<p>%s</p>', wp_unslash( $aAuthorData['description'] ));
                    }
                ?>
                </div>
            </div>
        </div>
    <?php 
    endif;
}

if ( ! function_exists( 'pi_comment' ) ) :

function pi_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <p><?php _e( 'Pingback:', 'wiloke' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'wiloke' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default :
        // Proceed with normal comments.
        global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author">
                <?php
                    echo get_avatar( $comment, 100 );
                ?>
            </div><!-- .comment-meta -->
            <div class="comment-box">
                <?php
                printf( '<cite><b class="fn">%1$s</b></cite>',
                    get_comment_author_link()
                );
                ?>
                <?php
                    printf( '<div class="comment-meta"><span class="time">%1$s</span></div>',
                        /* translators: 1: date, 2: time */
                        sprintf( __( '%1$s at %2$s', 'wiloke' ), get_comment_date(), get_comment_time() )
                    );
                ?>
            

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wiloke' ); ?></p>
                <?php endif; ?>

                <?php comment_text(); ?>
                
                

                <div class="comment-foot">
                    <?php edit_comment_link( __( 'Edit', 'wiloke' ), '', '' ); ?>
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'wiloke' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
            </div>
        </div><!-- #comment-## -->
    <?php
        break;
    endswitch; // end comment_type check
}
endif;



add_action('wp_head', 'pi_custom_some_for_css');
add_action('wp_footer', 'pi_custom_footer_code');

function pi_custom_some_for_css()
{
    ?>
    <script type="text/javascript">
        var woHomeUrl = "<?php echo site_url(); ?>";
    </script>
    <?php 
    $number    = isset(piThemeOptions::$piOptions['twitter']['number_of_tweets']) && !empty(piThemeOptions::$piOptions['twitter']['number_of_tweets'])  ?  piThemeOptions::$piOptions['twitter']['number_of_tweets']  : 5;
    ?>
    <script type="text/javascript">
    var piNumberOfTweets = <?php echo $number; ?>;
    </script>
    <?php 
    if ( isset(piThemeOptions::$piOptions['customcode']['css']) && !empty(piThemeOptions::$piOptions['customcode']['css']) )
    {
        ?>
        <style type="text/css">
        <?php echo stripslashes(piThemeOptions::$piOptions['customcode']['css']) ?> 
        </style>
        <?php 
    }

    if ( isset(piThemeOptions::$piOptions['customcode']['header']) && !empty(piThemeOptions::$piOptions['customcode']['header']) )
    {
        echo stripslashes(piThemeOptions::$piOptions['customcode']['header']);
    }

}

function pi_nav_menu()
{
    if ( pi_is_static_page() && is_page_template('homepage.php') )
    {
        if ( isset(piThemeOptions::$piOptions['design']['nav']) && piThemeOptions::$piOptions['design']['nav'] == 'bottom' )
        {
            echo 'nav-bottom';
        }else{
            echo 'nav-top';
        }
    }else{
        echo 'nav-top';
    }
}

function pi_custom_footer_code()
{
    if ( isset(piThemeOptions::$piOptions['customcode']['footer']) && !empty(piThemeOptions::$piOptions['customcode']['footer']) )
    {
        echo stripslashes(piThemeOptions::$piOptions['customcode']['footer']);
    }
}

function pi_sidebar_class($sidebar="")
{
    if ( empty($sidebar) || $sidebar == 'no-sidebar' )
    {
        echo 'col-md-12';
    }else{
        echo 'col-md-9';
    }
}

// create youtube
function pi_embbed_video($link)
{
    $getId  = "";
    if ( preg_match("#youtube#", $link) )
    {
        $parse = strpos($link, '=');
        $getId = substr($link, $parse);
        $getId = str_replace("=", "", $getId);
        $type  = "youtube";
    }elseif (preg_match("#vimeo#", $link)) {
        $getId = str_replace("http://vimeo.com/", "", $link);
        $type  = "vimeo";
    }

    if (empty($getId)) return;
    


    ?>
    <div class="embed-responsive embed-responsive-16by9">
      <!-- <figure> -->
        <?php if ($type == "youtube") : ?>
        <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/<?php echo $getId ?>" frameborder="0" allowfullscreen ></iframe>
        <?php else : ?>
        <iframe class="embed-responsive-item" src="http://player.vimeo.com/video/<?php echo $getId ?>?title=0&amp;byline=0&amp;portrait=0"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        <?php endif; ?>
      <!-- </figure> -->
    </div>
    <?php
}

// getimage
function pi_get_image($id, $fullsize=false)
{
    $size = !$fullsize ? 'folix-blog' : 'folix-nosidebar';
    echo wp_get_attachment_image($id, $size);
}



function pi_create_nav_filters()
{
    $aNavFilter = get_terms("pi_portfolio_cats");

    if ( !empty($aNavFilter)  && !is_wp_error($aNavFilter) )
    {
        ?>
        <li class="select-filter"><a href="#" data-filter="*"  id="all"><?php _e('All', 'wiloke') ?></a></li>
        <?php 
        foreach ($aNavFilter as $term) 
        {
            $filter = '.wiloke_'.$term->slug.$term->term_id;
            ?>
            <li><a href="#"  data-filter="<?php echo $filter ?>"><?php echo esc_attr($term->name); ?></a></li>
            <?php 
        }
    }else{
        echo "Opp! You haven't created any post yet";
    }

}

function pi_show_gallery($aGallies="")
{
    $showPosts   = isset(piThemeOptions::$piOptions['portfolio']['showposts']) ? piThemeOptions::$piOptions['portfolio']['showposts'] : 8;
    $effect      = isset(piThemeOptions::$piOptions['portfolio']['hover_effect']) ? piThemeOptions::$piOptions['portfolio']['hover_effect'] : 'style1';
    $args        = array("post_type"=>"pi_portfolio", "posts_per_page"=>$showPosts, "post_status"=>"publish");
    $aGallies    = get_posts($args);
    
    $output      = "";
    
    if (!empty($aGallies) && !is_wp_error($aGallies))
    {
        foreach ($aGallies as $gallery) : setup_postdata($gallery);
            $output .= pi_render_portfolio_item($gallery, false, "",  $effect);
        endforeach;
    }

    echo wp_unslash($output);
}

function pi_render_portfolio_item($gallery, $isPageTemplate = false, $style="", $effect="style1")
{   
    if ( $effect == 'random' )
    {
        $aEffect     = array('style1', 'style2', 'style3', 'style4', 'style5', 'style6');
        $random_keys = array_rand($aEffect,1);
        $effect      = $aEffect[$random_keys];
    }

    $output      = "";
    
    $metaData    = get_post_meta($gallery->ID, "_pi_portfolio", true);

    $projectTitle = get_the_title($gallery->ID);
    if ( has_post_thumbnail($gallery->ID) )
    {   
        $data    = "";
        $mediaType      = isset($metaData['media_type']) ? $metaData['media_type'] : '';
        $link = get_permalink($gallery->ID);
        $data = get_permalink($gallery->ID);
        
        $classFilter = "";
        $getTerms = wp_get_post_terms($gallery->ID, 'pi_portfolio_cats');

        


        if (!empty($getTerms) && !is_wp_error($getTerms))
        {
            
            foreach ($getTerms as $term)
            {
                $classFilter .= 'wiloke_'.$term->slug.$term->term_id  . ' ';
            }
        } 

        $thumbnail = "";
        $figcaption = "";


        $thumbnail .= '<a class="image-wrap" href="'. esc_url($link) .'" title="'.get_the_title($gallery->ID).'">';
            $thumbnail .= get_the_post_thumbnail($gallery->ID, 'post-thumbnai');
        $thumbnail .='</a>';

        $figcaption .= '<div class="caption text-center"><div class="tb"><div class="tb-cell">';

            $figcaption .= '<h2 class="h4 text-uppercase"><a href="'.esc_url($link).'">'.get_the_title($gallery->ID).'</a></h2>';
                $figcaption .= isset($gallery->post_excerpt)  && !empty($gallery->post_excerpt) ? '<p>' . wp_unslash($gallery->post_excerpt) . '</p>' : '';
                
                $getTags = wp_get_post_terms( $gallery->ID, 'portfolio_skill' );

                if ( !empty($getTags) && !is_wp_error($getTags) )
                {
                    $figcaption .= '<div class="cat"><ul>';
                    foreach ( $getTags as $tag )
                    {
                       $figcaption .= '<li>'.$tag->name.'</li>';
                    }
                    $figcaption .= '</ul></div>';
                }
               
        $figcaption .= '</div></div></div>';
        

        $colMd =  ($style =='style3' || $style =='style4') ? "col-md-4" : "col-md-3";

        $output .= "<div class='portfolio-item ".$effect." col-xs-12 col-sm-6 ".$colMd." md-work-zoomLg ".$classFilter . "'>";

        $output .=      '<div class="portfolio_item_image">';
            $output .= $thumbnail;
            $output .= $figcaption;
        $output .=      '</div>';
        
        $output .= "</div>";
    }
    return $output;
}


function pi_excerpt_length($length)
{
    $uri = isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI']  :'';
    if ( preg_match('/masonry/', $uri) )
    {
        return 40;
    }
    return $length;
}



function pi_auto_excerpt_more() 
{
    return '...';
}

function pi_modify_read_more_link($link) 
{
    $link = preg_replace( '|#more-[0-9]+|', '', $link );
    return $link;
}



add_filter( 'the_content_more_link', 'pi_modify_read_more_link' );

add_filter( 'excerpt_length', 'pi_excerpt_length', 10, 1);

add_filter( 'excerpt_more', 'pi_auto_excerpt_more' );





//wp_get_http_headers(sipi_url(), true);

// require_once dirname(__FILE__) . '/admin/automatic-installation-plugins.php';

add_filter( 'wp_link_pages_args', 'pi_theme_link_pages_args' );

function pi_theme_link_pages_args( $args )
{
    $args = array(
        'before'           => '<div class="link-pages">Page ',
        'after'            => '</div>',
        'link_before'      => '',
        'link_after'       => '',
        'next_or_number'   => 'number',
        'separator'        => '<span>',
        'nextpagelink'     => 'Next Page',
        'previouspagelink' => 'Previous Page',
        'pagelink'         => '%',
        'echo'             => 1
    );
    return $args;
}

add_filter('body_class','pi_class_names');

function pi_class_names($classes)
{
    if( (  !is_404() && !pi_is_static_page() ) )
    {
        $classes[] =  "single single-post";
    }elseif( pi_is_static_page() )
    {
        $classes[] ="home";
    }
    return $classes; 


    return $classes;
}

function pi_is_static_page()
{

    if ( 'page' == get_option( 'show_on_front' )  )
    {
        if ( is_front_page() )
        {
            return true; 
        }
    }
    return false;
}


add_filter( 'previous_post_link', 'pi_filter_prev_post', 10, 2 );
add_filter( 'next_post_link', 'pi_filter_next_post', 10, 2 );
function pi_filter_next_post( $format, $link )
{
    $previous = 'previous_post_link' === current_filter();

    // Get the next/previous post object
    $post = get_adjacent_post(
         false
        ,''
        ,false
    );

    if ( empty($post) ) 
    {
        return null;    
    }

    $title = get_the_title( $post->ID );

    // Copypasta from cores `get_adjacent_post_link()` fn
    ('' === $title && $title == $previous ) ? sprintf( __( 'Previous Post: %s', 'wiloke' ), $title ) : sprintf( __( 'Next Post: %s', 'wiloke' ), $title );

    $format = str_replace(
         'rel="'
        ,sprintf(
             'title="%s" rel="'
            ,$title
         )
        ,$format
    );

    return "<span class='some classes'>{$format}</span>";
}

function pi_filter_prev_post( $format, $link )
{
    $previous = 'previous_post_link' === current_filter();

    // Get the next/previous post object
    $post = get_adjacent_post(
         false
        ,''
        ,true
    );

    if ( empty($post) ) 
    {
        return null;    
    }

    $title = get_the_title( $post->ID );

    // Copypasta from cores `get_adjacent_post_link()` fn
    ('' === $title && $title == $previous )
            ? sprintf( __( 'Previous Post: %s', 'wiloke' ), $title )
            : sprintf( __( 'Next Post: %s', 'wiloke' ), $title );

    $format = str_replace(
         'rel="'
        ,sprintf(
             'title="%s" rel="'
            ,$title
         )
        ,$format
    );

    return "<span class='some classes'>{$format}</span>";
}


// view type
function pi_view_type($id)
{
    $fullsize=false;
    $sidebarType = isset(piThemeOptions::$piOptions['design']['choosidebar']) && !empty(piThemeOptions::$piOptions['design']['choosidebar']) ? piThemeOptions::$piOptions['design']['choosidebar'] : 'r-sidebar';

    if ($sidebarType == 'no-sidebar')
    {
        $fullsize = true;
    }

    $metaData    = get_post_meta($id, 'custompost', true);
    
    $metaData    = $metaData && !is_array($metaData) ? json_decode($metaData, true) : $metaData;
    if (isset($metaData['headertype']))
    {
       
        switch ($metaData['headertype']) 
        {
            case 'imageslideshow':
                $getId = isset($metaData['slideshow']) ? $metaData['slideshow'] : '';
                if (!empty($getId))
                {
                    pi_create_slider($getId, $fullsize);
                }
                break;
            case 'youtube':
                $getLink = isset($metaData['videolink']) ? $metaData['videolink'] : '';
                if (!empty($getLink))
                    pi_embbed_video($getLink);
                break;
            case 'imagestatic':
                $getId = isset($metaData['staticimg']) ? $metaData['staticimg'] : '';
                if (!empty($getId))
                    pi_get_image($getId, $fullsize);
                break;
        }
    }
}

function pi_get_meta_data($style="")
{ 
    global $post;
    $link = get_author_posts_url($post->post_author);
    $format = get_option("date_format");
    $date = get_the_date($format, $post->ID);
    if ( $style == '' ) :
    ?>
    <div class="post-meta">
        <span>
            <i class="fa fa-user"></i>
            <a href="<?php echo esc_url($link) ?>"><?php echo esc_attr( get_the_author() ); ?></a>
        </span>
        <?php if ( !is_page() ) : ?>
        <span>
            <i class="fa fa-th"></i> <?php is_singular('pi_portfolio') ? pi_get_the_terms($post->ID, 'pi_portfolio_cats') :   the_category(" &bull;");  ?>
        </span>
        <?php endif; ?>
        <span>
            <i class="fa fa-comments"></i><a href="<?php the_permalink() ?>"><?php  comments_number('0', '1', '%') ?></a>
        </span>
    </div>
    <?php 
    else :
    ?>
    <div class="post-meta">
        <span>
            <?php echo esc_html($date); ?>
        </span>
        <?php if ( !is_page() ) : ?>
        <span>
            <?php the_category(" &bull;");  ?>
        </span>
        <?php endif; ?>
    </div>
    <?php 
    endif;
}

function pi_get_the_terms($postID, $tax)
{
    $terms = get_the_terms($postID, $tax );

    if ($terms && ! is_wp_error($terms)) :
        $terms_slug_str = "";
        foreach ($terms as $term) 
        {
            $terms_slug_str .= '<a href="'.get_term_link($term).'">'.$term->name.'</a> &bull;';
        }

        $terms_slug_str = trim($terms_slug_str, "&bull;");
        echo wp_unslash($terms_slug_str);
    endif;
}

function pi_blog_metadata()
{
    global $post;
    
    ?>
    <header class="entry-header">
        <div class="entry-thumbnail">
          <h2 class="entry-title">
            <a href="<?php echo get_permalink($post->ID) ?>" rel="bookmark"><?php the_title() ?></a>
          </h2>                                            
          <p class="date">
              <span>
                <a class="pi_comments"  href="<?php the_permalink() ?>">
                    <img src="<?php  echo get_template_directory_uri() . '/assets/img/icon_comments.png'; ?>" class="info_comments" alt="">
                    <span class="entry-comments"><?php  comments_number('No Commment', '1', '%') ?></span>
                </a>
              </span>
                <?php if (get_post_format()): ?>
                 <a href="<?php the_permalink() ?>"><span class="post-format-icon <?php echo esc_attr(get_post_format()); ?>"><?php
                    echo apply_filters('pi_post_formats_icon', ''); ?></span></a>
                <?php endif; ?>
               <span class="entry-date"><?php the_time('M j, Y') ?></span>
          </p>
          <?php 
            if ( has_post_thumbnail($post->ID) )
            {
                echo get_the_post_thumbnail( $post->ID, 'thumbnail', array('class'=>'post-image', 'alt' => trim( strip_tags( $post->post_excerpt ) )) );
            }
          ?>
    </div>
    </header>
    <?php 
}


function pi_post_media($postID, $innerPostMedia=false, $size="full", $postType="post")
{
    if ( $postType == 'post' )
    {
        $getFormat  = get_post_format($postID);
        $formatData = get_post_meta($postID, "custompost", true);
    }

    $output = "";

    $output .= '<div class="post-media">';
        if ( !is_single() && !is_page() )
        {
           if ( has_post_thumbnail($postID) )
           {
                $output .= get_the_post_thumbnail($postID, $size);
                if ( $innerPostMedia )
                {
                    if ( $getFormat )
                    {
                        $output .='<a class="pi-wrap-post-format" href="'.get_the_permalink($postID).'"><span class="post-format-icon '.$getFormat.'">'.apply_filters('pi_post_formats_icon', '').'</span></a>';
                    }
                }
           }
        }else{

            if ( $postType != 'post' )
            {
                $metaData = get_post_meta($postID, "_pi_portfolio", true);
                $getFormat = isset($metaData['media_type']) ? $metaData['media_type']  : '';
                
                switch ($getFormat)
                {
                    case 'gallery':
                        $formatData['slideshow'] = isset($metaData['image_id']) ? $metaData['image_id'] : '';
                        break;
                    case 'video':
                        $formatData['videolink'] = isset($metaData['video_link']) ? $metaData['video_link'] : '';
                        break;
                } 
            }
            
            switch ($getFormat) 
            {
                case 'gallery':
                    if ( isset($formatData['slideshow']) && !empty($formatData['slideshow']) )
                    {
                        $parse = explode(",", $formatData['slideshow']);
                        $output .= '<div class="post-slider">';
                        foreach ( $parse as $id )
                        {
                            $output .= '<div class="item">';
                                $output .= '<img src="'.wp_get_attachment_url($id).'" alt="'.get_the_title($postID).'">';
                            $output .= '</div>';
                        }
                        $output .= '</div>';
                    }
                    break;
                case 'audio':

                    if ( isset($formatData['audiolink']) && !empty($formatData['audiolink']) ) :
                   
                    $output .= '<div class="audio-wrap">';
                   
                        if(preg_match("/\/sets\//i",$formatData['audiolink']) || preg_match("/\/sets\//i",$formatData['audiolink']))
                        {
                            $maxheight = "450px";
                        }else{
                            $maxheight = "166px";
                        } 
                       
                        $output .= '<div id="audio-play-'.esc_attr($postID).'" class="audio-play" data-url="'.esc_url($formatData['audiolink']) .'" data-maxheight="'. esc_attr($maxheight) .'"></div>';
                        
                    $output .= '</div>';
                   
                    endif;
                    break;
                case 'quote':
                    $output .=  '<blockquote class="quote">';
                    $output .= '<i class="fa fa-quote-right"></i>';
                    if ( isset($formatData['quote']) && !empty($formatData['quote']) )
                    {
                        $output .= sprintf("<p>%s</p>", wp_unslash($formatData['quote']));
                    }
                    if ( isset($formatData['quote_author']) && !empty($formatData['quote_author']) )
                    {
                        $output .= sprintf("<cite>%s</cite>", wp_unslash($formatData['quote_author']));
                    }
                    $output .=  '</blockquote>';
                    break;
                case 'video':
                    if ( isset($formatData['videolink']) && !empty($formatData['videolink']) )
                    {

                        $output .= '<div class="video embed-responsive embed-responsive-16by9">';
                        $parseVideo = pi_parse_video($formatData['videolink']);
                        if ($parseVideo['type'] == "youtube")
                        {
                            $output .= '<iframe class="embed-responsive-item" src="http://www.youtube.com/embed/'.$parseVideo['id'].'" frameborder="0" allowfullscreen ></iframe>';
                        }else{
                            $output .= '<iframe class="embed-responsive-item" src="http://player.vimeo.com/video/'.$parseVideo['id'].'?title=0&amp;byline=0&amp;portrait=0"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                        }
                        $output .= '</div>'; 
                    }
                    break;
                case 'image':
                    $output .= '<div class="image-wrap">';
                        $output .= get_the_post_thumbnail($postID);
                    $output .= '</div>';
                    break;
                default:
                    // if ( has_post_thumbnail($postID) )
                    // {
                    //     $output .= '<div class="image-wrap">';
                    //         $output .= get_the_post_thumbnail($postID);
                    //     $output .= '</div>';
                    // }
                    break;
            }
           
        }
    $output .= '</div>';

    print($output);
}

function pi_parse_video($link)
{
    $getId  = "";
    if ( preg_match("#youtube#", $link) )
    {
        $parse = strpos($link, '=');
        $getId = substr($link, $parse);
        $getId = str_replace("=", "", $getId);
        $type  = "youtube";
    }elseif (preg_match("#vimeo#", $link)) {
        $getId = str_replace("http://vimeo.com/", "", $link);
        $type  = "vimeo";
    }

    return array('type'=>$type, 'id'=>$getId);
}

function pi_get_comment_info($postID)
{
   
    $num_comments = get_comments_number($postID); 
    $output = "";

    if ( comments_open() ) {
        if ( $num_comments == 0 ) {
            $comments = __('No Comments', 'wiloke');
        } elseif ( $num_comments > 1 ) {
            $comments = $num_comments . __(' Comments', 'wiloke');
        } else {
            $comments = __('1 Comment', 'wiloke');
        }
        $output .= ' <a href="' . get_comments_link() .'">'. $comments.'</a>';
    }

    echo $output;
}

function pi_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'wiloke'), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'pi_wp_title', 10, 2 );



/**
 * Header Background
*/

function pi_custom_section($key)
{
    if ( empty($key) ) return '';

    $aData = isset(piThemeOptions::$piOptions['pi_custom_section'][$key]) && !empty(piThemeOptions::$piOptions['pi_custom_section'][$key]) ? piThemeOptions::$piOptions['pi_custom_section'][$key] : '';

    if ( !empty($aData) )
    {
        if ( (isset($aData['enable']) && !empty($aData['enable'])) || has_action('customize_controls_init') ) :
        $backgroundType = isset($aData['background']) ? $aData['background'] : 'none';
        if ( $backgroundType == 'image' )
        {
            // $background['bg_type'] = 'image';
            $getImage     = isset($aData['bg_img']) ? esc_url($aData['bg_img']) : 'http://placehold.it/1600x1160';
            $overlay = isset($aData['overlay']) ? (int)$aData['overlay'] : 0;
            $parallax = isset($aData['parallax']) ? (int)$aData['parallax'] : 0;

            if ( !empty($overlay) )
            {
                $overlay_color = isset($aData['overlay_color']) ? $aData['overlay_color'] : 'rgba(0,0,0,0.3)';
            }
        }

        ?>
        <section id="<?php echo esc_attr($key) ?>" class="section custom-section">
            <?php
            switch ( $backgroundType )
            {
                case 'color':
                    echo '<div class="bg-color"></div>';
                break;

                case 'image':
                    if ( $parallax==1 )
                    {
                        echo '<div class="bg-parallax pi-parallax-static" style="background-image:url('.esc_url($getImage).')"></div>';
                    }else{
                        echo '<div class="bg-static pi-parallax-static" style="background-image:url('.esc_url($getImage).')"></div>';
                    }

                    if ( $overlay == 1 )
                    {
                        echo '<div class="bg-overlay" style="background-color:'.wp_unslash($overlay_color).'"></div>';
                    }
                break;
            }
            ?>
            <div class="container">
                <div class="st-heading text-center">
                <?php if ( isset($aData['title']) ) : ?>
                <h2 class="h3"><?php printf( ( __("%s", 'wiloke') ), wp_unslash($aData['title'])  ); ?></h2><hr class="he-divider">
                <?php  endif; ?>
                <?php if ( isset($aData['description']) ) : ?>
                <p class="sub-title"><?php printf(  (__("%s", 'wiloke')), wp_unslash($aData['description'])  ); ?></p>
                <?php  endif; ?>
                </div>
            
                <?php if ( isset($aData['content']) ) : ?>
                <div class="row">
                    <div class="st-body">
                        <div class="col-sm-12 col-lg-12 col-md-12">
                        <?php printf( (__("%s", 'wiloke') ), do_shortcode(wp_unslash($aData['content']))); ?>
                        </div>   
                    </div>
                </div>
                <?php  endif; ?>
            </div>
        </section>
        <?php 
        endif;
    }
}

function pi_get_background($section)
{   

    $bgType =""; $getImage=""; $getColor="";
    
    if ( isset(piThemeOptions::$piOptions[$section]['background']) && !empty(piThemeOptions::$piOptions[$section]['background']) )
    {

        $bgType =  piThemeOptions::$piOptions[$section]['background'];

        if ( $bgType == 'image' )
        {
            $getImage =  isset(piThemeOptions::$piOptions[$section]['bg_img']) && !empty(piThemeOptions::$piOptions[$section]['bg_img'])  ? piThemeOptions::$piOptions[$section]['bg_img']: '';
            if ( $getImage != '' )
            {
                if ( !preg_match("/http/", $getImage) )
                {
                    if ( wp_attachment_is_image($getImage) )
                    {
                        $getImage = wp_get_attachment_url($getImage);
                    }else{
                        $getImage = "http://placehold.it/1600x1160";
                    }
                }
            }else{
                $getImage = "http://placehold.it/1600x1160";
            }
            $overlay =  isset(piThemeOptions::$piOptions[$section]['overlay']) && !empty(piThemeOptions::$piOptions[$section]['overlay'])  ? piThemeOptions::$piOptions[$section]['overlay']: 0;
            $parallax =  isset(piThemeOptions::$piOptions[$section]['parallax']) && !empty(piThemeOptions::$piOptions[$section]['parallax'])  ? 1 : 0;

            $getColor =   isset(piThemeOptions::$piOptions[$section]['overlay_color']) && !empty(piThemeOptions::$piOptions[$section]['overlay_color'])  ? piThemeOptions::$piOptions[$section]['overlay_color']: 'rgba(0, 0, 0, 0.3)';
        }
    }
    

    switch ( $bgType )
    {
        case 'color':
            echo '<div class="bg-color"></div>';
        break;

        case 'image':
           
            if ( $parallax == 1  )
            {
                echo '<div class="bg-parallax pi-parallax-static" style="background-image:url('.esc_url($getImage).')"></div>';
            }else{
                echo '<div class="bg-static pi-parallax-static" style="background-image:url('.esc_url($getImage).')"></div>';
            }

            if ( $overlay == 1 )
            {
                echo '<div class="bg-overlay" style="background-color:'.wp_unslash($getColor).'"></div>';
            }

        break;
    }   
}
/**
 * Social
*/

function pi_social($pos="foot-social")
{
    if (isset(piThemeOptions::$piOptions['footer']['social_link']) && !empty(piThemeOptions::$piOptions['footer']['social_link']) ) :
?>
        <div class="<?php echo esc_attr($pos); ?> social text-center">
        <?php
        foreach ( piThemeOptions::$piOptions['footer']['social_link'] as $k => $link ) : if ( !empty($link) ) :
        ?>
        <a href="<?php echo esc_url($link) ?>" target="_blank"><i class="<?php echo esc_attr(piThemeOptions::$piOptions['footer']['social_icon'][$k]) ?>"></i></a>
        <?php endif;endforeach; ?>
        </div>
<?php 
    endif;
}


/*Display Header background*/
function pi_image_fixed($aData)
{
    if ( !isset($aData['image_fixed']) || empty($aData['image_fixed']) ) 
    {
        ?>
        <div class="bg-parallax" style="background:  url('http://placehold.it/2000x1600&text=image') no-repeat fixed center center / cover rgba(0, 0, 0, 0);"></div>
        <div class="bg-overlay"></div>
        <?php
    }else{
       
        if ( !preg_match("/http/", $aData['image_fixed']) )
        {
            if ( !wp_attachment_is_image($aData['image_fixed']) )
            {
                ?>
                <div class="bg-parallax" style="background:  url('http://placehold.it/2000x1600&text=Broken%20image,%20please%20re-upload') no-repeat fixed center center / cover rgba(0, 0, 0, 0);"></div>
                <div class="bg-overlay"></div>
                <?php 
            }else{
                ?>
                <div class="bg-parallax" style="background:  url('<?php echo  esc_url(wp_get_attachment_url($aData['image_fixed'])) ?>') no-repeat fixed center center / cover rgba(0, 0, 0, 0);"></div>
                <div class="bg-overlay" style="background-color: <?php echo isset($aData['overlay_color']) ? $aData['overlay_color'] : ''; ?>"></div>
                <?php 
            }
        }else{
            
            ?>
            <div class="bg-parallax" style="background:  url('<?php echo esc_url($aData['image_fixed']) ?>') no-repeat fixed center center / cover rgba(0, 0, 0, 0);"></div>
            <div class="bg-overlay" style="background-color: <?php echo isset($aData['overlay_color']) ? $aData['overlay_color'] : ''; ?>"></div>
            <?php
        }  
    }

    pi_header_text($aData);
}

function pi_text_slider($aData)
{ 
    
    $img = isset($aData['text_slider']) && !empty($aData['text_slider']) ? $aData['text_slider'] :  'http://placehold.it/1600x1160';
    $textEffect  = isset(piThemeOptions::$piOptions['text_slider']['text_effect']) && !empty(piThemeOptions::$piOptions['text_slider']['text_effect']) ? piThemeOptions::$piOptions['text_slider']['text_effect'] : 'fade';
    $getTitle    =  isset(piThemeOptions::$piOptions['text_slider']['title']) && !empty(piThemeOptions::$piOptions['text_slider']['title']) ? piThemeOptions::$piOptions['text_slider']['title'] : array('We Love Design and Creatve Stuff', 'We love what we do');  
    $getDescription    =  isset(piThemeOptions::$piOptions['text_slider']['description']) && !empty(piThemeOptions::$piOptions['text_slider']['description']) ? piThemeOptions::$piOptions['text_slider']['description'] : array('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur diam felis, lacinia eget<br> mattis ut, mollis id turpis class aptent tacit', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantiumo<br> mattis ut, mollis id turpis class aptent tacit');
    $aSubTitle        =  isset(piThemeOptions::$piOptions['text_slider']['sub_title']) && !empty(piThemeOptions::$piOptions['text_slider']['sub_title']) ? piThemeOptions::$piOptions['text_slider']['sub_title'] : array('Creative Angency', 'Stay Hungry Stay Foolish');
    $aButtonName        =  isset(piThemeOptions::$piOptions['text_slider']['button_name']) && !empty(piThemeOptions::$piOptions['text_slider']['button_name']) ? piThemeOptions::$piOptions['text_slider']['button_name'] : array('Our Work', 'Meet Team');
    $aButtonLink        =  isset(piThemeOptions::$piOptions['text_slider']['button_link']) && !empty(piThemeOptions::$piOptions['text_slider']['button_link']) ? piThemeOptions::$piOptions['text_slider']['button_link'] : array('#portfolio', '#team');
    ?>

    <?php 
        if ( !preg_match("/http/", $img) )
        {  
            if ( !wp_attachment_is_image($img) )
            {
                _e('<h2 class="alert alert-danger">Broken image, please re-upload</h2>', 'wiloke');
            }else{
            ?>
            <div class="bg-parallax" style="background:  url('<?php echo wp_get_attachment_url($img)  ?>') no-repeat fixed center center / cover rgba(0, 0, 0, 0);"></div>
            <div class="bg-overlay" style="background-color: <?php echo isset($aData['overlay_color']) ? $aData['overlay_color'] : ''; ?>"></div>
            <?php
            } 
        }else{
            ?>
            <div class="bg-parallax" style="background:  url('<?php echo esc_url($img);  ?>') no-repeat fixed center center / cover rgba(0, 0, 0, 0);"></div>
            <div class="bg-overlay" style="background-color: <?php echo isset($aData['overlay_color']) ? $aData['overlay_color'] : ''; ?>"></div>
            <?php 
        }
    ?>
    <div class="pi-textslider text-slider" data-effect="<?php echo esc_attr($textEffect) ?>">
    <?php 
        foreach ( $getTitle as $k => $title ) :
    ?>
    <div class="item">
        <div class="tb">
            <div class="home-media-content tb-cell text-center text-uppercase">
                <?php if ( isset($aSubTitle[$k]) && !empty($aSubTitle[$k])  )  :  ?>
                <?php printf( (__("<h4 class='header-text'>%s</h4>", 'wiloke') ), wp_unslash($aSubTitle[$k]) ); ?>
                <?php endif; ?>
                <?php if ( !empty($title) ) : ?>
                <h2 class="h1"><?php printf( __('%s', 'wiloke'), wp_unslash($title) ); ?></h2>
                <hr class="he-divider">
                <?php endif; ?>
                <?php 
                    if ( isset($getDescription[$k]) && !empty($getDescription[$k]) ) :
                ?>
                <?php printf( __('<p>%s</p>', 'wiloke'), wp_unslash($getDescription[$k]) ); ?>
                <?php endif; ?>
                <?php 
                    if ( isset($aButtonLink[$k]) && !empty($aButtonLink[$k]) ) :
                        printf( (__("<div  class='pi-header-button'><a class='h-btn btn-style-2' href='%s'>%s</a></div>", 'wiloke') ), wp_unslash($aButtonLink[$k]), $aButtonName[$k]);
                    endif;
                ?>
            </div>
        </div>
    </div>
    <?php 
        endforeach;
    ?>
  </div>

    
    <?php 
}

function pi_tunna_slider($aData)
{
    if ( !isset($aData['tunna_slider']) || empty($aData['tunna_slider']) ) 
    {
        _e('<h2 class="alert alert-danger">Please create slider</h2>', 'wiloke');
    }else{
    
    }
}

function pi_image_slider($aData)
{
    $imgs = isset($aData['img_slider']) && !empty($aData['img_slider']) ? $aData['img_slider'] : 'placehold.it/1600x1160,http://placehold.it/1600x1160/ffffff/000000';
    $overlay_color = isset($aData['overlay_color']) ? $aData['overlay_color'] : 'rgba(0,0,0,0.0)';
    $parseID = explode(",", $imgs);
    ?>
    <div class="home-slider" data-background="bg-parallax">
        
        <div class="slides-container">
            <?php 
                foreach ( $parseID as $id ) : 
                    ?>
                    <div class="item">
                    <?php 
                    if ( !preg_match("/http/", $id) )
                    {
                        if ( wp_attachment_is_image($id) ) :
                        ?>
                        <img src="<?php echo esc_url(wp_get_attachment_url($id)); ?>" alt="<?php echo esc_attr(get_post_meta( $id, '_wp_attachment_image_alt', true )); ?>"> 
                        <div class='bg-overlay' style='background-color:<?php echo $overlay_color; ?>'></div>
                        <?php 
                        endif;
                    }else{
                        ?>
                        <img src="<?php echo esc_url($id); ?>" alt="Wiloke Theme">
                        <div class='bg-overlay' style='background-color:<?php echo $overlay_color; ?>'></div>
                        <?php   
                    }
                   
                    pi_header_text($aData); 
                    ?>

                    </div>
            <?php 
                   
                endforeach;
            ?>
        </div>
        <nav class="slides-pagination">
        </nav>
        
    </div> 
    <?php  
}

function pi_youtube_bg($aData)
{       
    $link       = isset($aData['youtube_link']) || !empty($aData['youtube_link']) ? $aData['youtube_link'] : 'https://www.youtube.com/watch?v=BbBYXYO-J_E';
    $mute       = isset($aData['video_options']['mute']) && !empty($aData['video_options']['mute']) ? true : false;
    $quality    = isset($aData['video_options']['quality']) && !empty($aData['video_options']['quality']) ? $aData['video_options']['quality'] : 'default';
    $placeholder= isset($aData['video_options']['imageplaceholder']) && !empty($aData['video_options']['imageplaceholder']) && wp_attachment_is_image($aData['video_options']['imageplaceholder']) ? $aData['video_options']['imageplaceholder'] : '';
    if ( !empty($placeholder) )
    {
        if ( !preg_match("/http/", $placeholder) )
        {
            $placeholder = wp_get_attachment_url($placeholder);
        }
    }
    ?>
    <div class="text-content">
    <?php pi_header_text($aData); ?>
    </div>
    
    <div id="video-element" class="bg-video js_fullscreen_video video">
        <a id="video" class="player js_player fullscreen-video" data-property="{videoURL:'<?php echo esc_url($link); ?>',containment:'#video-element', showControls:0, autoPlay:true, loop:true, mute:<?php if($mute){ ?>true<?php }else{ ?> false <?php }  ?>, startAt:0, opacity:1, addRaster:false, quality: '<?php echo esc_attr($quality); ?>'}"><?php _e("Youtube Background", 'wiloke') ?></a> 
    </div>
    
    <div class="controls-video">
        <span class="play"><i class="fa fa-play"></i></span>
        <div class="controls-sm">
            <span class="pause"><i class="fa fa-pause"></i></span>
            <span class="volume"><i class="fa fa-volume-down"></i></span>
        </div>
    </div>
    <div class="video-place" <?php if ( !empty($placeholder) ){ ?> style="background-image: url('<?php echo esc_url($placeholder); ?>');" <?php  } ?>></div>
    <div class="overlay-pattern"></div>
    <?php          
}

function pi_header_text($aData)
{
    if ( (isset($aData['title']) && !empty($aData['title']) ) || ( isset($aData['description']) && !empty($aData['description']) ) ) :
    ?>
    <div class="tb">
        <div class="home-media-content tb-cell text-center text-uppercase">
            <?php if ( isset($aData['sub_title']) && !empty($aData['sub_title'])  ) : ?>
            <?php printf( (__("<h4 class='header-text'>%s</h4>", 'wiloke') ), wp_unslash($aData['sub_title']) ); ?>
            <?php endif; ?>
            <?php if ( isset($aData['title']) && !empty($aData['title'])  ) : ?>
            <?php printf( (__("<h2 class='h1'>%s</h2>", 'wiloke') ), wp_unslash($aData['title']) ); ?>
            <hr class="he-divider">
            <?php endif; ?>
            <?php if ( isset($aData['description']) && !empty($aData['description'])  ) : ?>
            <?php printf( (__("<p>%s</p>", 'wiloke') ), wp_unslash($aData['description']) ); ?>
            <?php endif; ?>
            <?php 
                if ( isset($aData['button_link']) && !empty($aData['button_link']) ) :
                    $buttonName  = isset($aData['button_name']) && !empty($aData['button_name']) ? wp_unslash($aData['button_name']) : "Button Name";
                    printf( (__("<div  class='pi-header-button'><a class='h-btn btn-style-2' href='%s'>%s</a></div>", 'wiloke') ), wp_unslash($aData['button_link']), $buttonName);
                endif;
            ?>
        </div>
    </div>
    <?php 
    endif;
}

function pi_display_logo()
{
    if ( isset(piThemeOptions::$piOptions['logo']['enable']) || has_action('customize_controls_init') )
    {
        $logo  = "";
        $src   = "";
       
        $src = isset(piThemeOptions::$piOptions['logo']['logo_nav']) && !empty(piThemeOptions::$piOptions['logo']['logo_nav']) ? piThemeOptions::$piOptions['logo']['logo_nav'] : get_template_directory_uri() . '/admin/pi-assets/images/logo.png';
            

        if ( empty($src) && has_action('customize_controls_init') )
        {
            $src = 'http://placehold.it/134x25&text=logo';
        }

        ob_start();
        pi_add_hidden('logo');
        $logoHidden = ob_get_clean();


        $logo .= '<div class="logo-nav '.$logoHidden.'">';
            $logo .= '<a href="'.home_url().'">';
                $logo .= '<img src="'.esc_url($src).'" alt="'.wp_unslash( get_option('blogname') ).'">';
            $logo .= '</a>';
        $logo .= '</div>';
       
   
        echo wp_unslash($logo);
    }
}
function pi_get_map_info($name)
{
    $get  = isset(piThemeOptions::$piOptions['contact']['googlemap'][$name]) && !empty(piThemeOptions::$piOptions['contact']['googlemap'][$name]) ? esc_attr(piThemeOptions::$piOptions['contact']['googlemap'][$name]) : "";

    if ( empty($get) && has_action('customize_controls_init') )
    { 
        if ( $name == 'longitude' )
        {
            $get = '21.019131';
        }else{
            $get = '105.832629';
        }
    }

    return $get;
}


function pi_the_description($section, $addClass="")
{
    $pidescription ="";$allow=false;
    
    if ( isset(piThemeOptions::$piOptions[$section]['description']) && !empty(piThemeOptions::$piOptions[$section]['description']) )
    {
        $pidescription = piThemeOptions::$piOptions[$section]['description'];
    }

    if ( has_action('customize_controls_init') )
    { 
        $allow = true;
    }else{
        if ( !empty($pidescription) )
        {
            $allow = true;
        }
    }


    if ( $allow )
    {
        printf( __( ('<div class="section-description %s"><p>%s</p></div>'), 'wiloke'), $addClass, wp_unslash($pidescription) );    
    }
}

function pi_header_bg()
{
    $getHeader = isset(piThemeOptions::$piOptions['header']) && !empty(piThemeOptions::$piOptions['header']) ? piThemeOptions::$piOptions['header'] : '';
   
    $type      = isset($getHeader['type']) && !empty($getHeader['type']) ? $getHeader['type']  : 'image_fixed';
    $overlay_color = isset($getHeader['overlay_color']) ? $getHeader['overlay_color'] : 'rgba(0,0,0,0.0)';
    ob_start();
    pi_add_hidden('header');
    $class = ob_get_clean();
    if ( !empty($type) )
    {
        echo '<div id="pi-wrap-header-media" class="home-media '.esc_attr($class).'">';
            switch ( $type )
            {
                case 'youtube_bg':
                    pi_youtube_bg($getHeader);
                break;

                case 'img_slider':
                    pi_image_slider($getHeader);
                break;

                case 'bg_slideshow':
                if ( isset($getHeader['tunna_slider']) && !empty($getHeader['tunna_slider']) ) :
                    echo do_shortcode("[tunna_slider id='".$getHeader['tunna_slider']."']");
                else :
                    _e('You haven\'t created slider yet');
                endif;
                break;

                case 'text_slider':
                    pi_text_slider($getHeader);
                break;

                case 'image_fixed':
                    pi_image_fixed($getHeader);
                break;
            }
        echo '</div>';
    }
}

if ( ! function_exists( 'pi_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 */
function pi_comment_nav() {
    // Are there comments to navigate through?
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    ?>
    <nav class="navigation comment-navigation" role="navigation">
        <h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'wiloke' ); ?></h2>
        <div class="nav-links">
            <?php
                if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'wiloke' ) ) ) :
                    printf( '<div class="nav-previous">%s</div>', $prev_link );
                endif;

                if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'wiloke' ) ) ) :
                    printf( '<div class="nav-next">%s</div>', $next_link );
                endif;
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .comment-navigation -->
    <?php
    endif;
}
endif;

function pi_social_render($aData=array())
{

    if ( empty($aData) )
    {
        $aData = isset(piThemeOptions::$piOptions['social']) ? piThemeOptions::$piOptions['social']  : array();
    }

    if ( !empty($aData) ) :
    foreach ( $aData['social_link'] as $key => $link ) :
      if (  !empty($link) ) :
    ?>
    <a href="<?php echo esc_url($link) ?>"><i class="<?php echo esc_attr($aData['social_icon'][$key]); ?>"></i></a>
    <?php 
      endif;
    endforeach;
    endif;
}

function pi_add_hidden($section, $child="")
{
    if ( has_action('customize_controls_init') )
    {
        if ( $child != '' )
        {
            if ( !isset(piThemeOptions::$piOptions[$section][$child]) )
            {
                $class = " hidden";
            }else{
                $class = "";
            }
        }else{
            if ( !isset(piThemeOptions::$piOptions[$section]['enable']) )
            {
                $class = " hidden";
            }else{
                $class = "";
            }
        }

        echo esc_attr($class);
    }
}

function pi_blog_header($postID="")
{
    $keep = true;$allow=false;$title=""; $isWoocommerce=false;

    if ( is_page() || is_single() )
    {
        $postMeta = get_post_meta($postID, "_post_settings", true);
        if ( isset($postMeta['enable_custom_background']) )
        {
            if ( $postMeta['enable_header_background'] )
            {
                $allow        = true;
                $img          = isset($postMeta['image_bg']) ? $postMeta['image_bg'] : 'http://placehold.it/1500x200&text=image';
                $overlayColor = isset($postMeta['overlay_color']) ? $postMeta['overlay_color'] : 'rgba(0,0,0,0)';
            }
            $keep = false;
        }
    }

    if ( $keep )
    {
        if ( is_page() && is_page_template("default") )
        {
            global $post;
            if ( has_shortcode($post->post_content, "woocommerce_cart") || has_shortcode($post->post_content, "woocommerce_checkout") || has_shortcode($post->post_content, "woocommerce_my_account") )
            {
                $isWoocommerce = true;
            }
        }elseif( is_post_type_archive('product') ||  is_tax("product_cat") || is_singular("product") )
        {
            $isWoocommerce = true;
        }

        if ( $isWoocommerce )
        {
            if ( isset(piThemeOptions::$piOptions['woocommerce']['enable']) && !empty(piThemeOptions::$piOptions['woocommerce']['enable']) )
            {
                $allow = true;
            }
        }else{
            if ( isset(piThemeOptions::$piOptions['posts_settings']['enable']) && !empty(piThemeOptions::$piOptions['posts_settings']['enable']) )
            {
                $allow = true;
            }
        }

    }
    if ( $allow ) :
        if ( is_page_template("portfolio.php") )
        {
            $title = get_the_title($postID);
        }elseif( is_search() )
        {
            $title =  sprintf( __( '<span class="text-center">Search Results for: <span class="pi-target">%s</span></span>', 'wiloke' ), get_search_query() );
        }else{
            if ( $isWoocommerce )
            {
                $title =  isset(piThemeOptions::$piOptions['woocommerce']['title']) ? wp_unslash(piThemeOptions::$piOptions['woocommerce']['title']) : "";
            }else{
                $title =  isset(piThemeOptions::$piOptions['posts_settings']['title']) ? wp_unslash(piThemeOptions::$piOptions['posts_settings']['title']) : "";
            }
        }

        if ( $keep )
        {
            if ( $isWoocommerce )
            {
                $img          = isset(piThemeOptions::$piOptions['woocommerce']['background']) ? piThemeOptions::$piOptions['woocommerce']['background'] : 'http://placehold.it/1500x200&text=image';
                $overlayColor = isset(piThemeOptions::$piOptions['woocommerce']['overlay_color']) ? piThemeOptions::$piOptions['woocommerce']['overlay_color'] : 'rgba(0,0,0,0)';
                
            }else{
                $img          = isset(piThemeOptions::$piOptions['posts_settings']['background']) ? piThemeOptions::$piOptions['posts_settings']['background'] : 'http://placehold.it/1500x200&text=image';
                $overlayColor = isset(piThemeOptions::$piOptions['posts_settings']['overlay_color']) ? piThemeOptions::$piOptions['posts_settings']['overlay_color'] : 'rgba(0,0,0,0)';
                
            }
        }
            
       
    ?>
        <section class="blog-heading text-center">
            <div class="bg-static" style="background-image:url(<?php echo esc_url($img); ?>)"></div>
            <div class="bg-overlay" style="background-color:<?php echo esc_attr($overlayColor);  ?>"></div>
            <div class="container">
                <?php printf( (__('<h2 class="h1 text-uppercase">%s</h2>', 'wiloke')), $title ); ?>
            </div>
        </section>
    <?php 
    endif;
}

function pi_sidebar_pos($postID="")
{   
    if ( is_page() && is_page_template("default") )
    {

        global $post;

        if ( has_shortcode($post->content, 'woocommerce_checkout') )
        {
            return "no-sidebar";
        }
    }

    $allow = false; $con = true;
   
    if ( $postID != '' )
    {
        $postMeta = get_post_meta($postID, "_post_settings", true);

        if ( isset($postMeta['sidebar']) && $postMeta['sidebar'] !='default' )
        {
            $sidebar = $postMeta['sidebar'];
            $con = false;
        }
    }
    
    if ( $con )
    {
        if ( is_post_type_archive('product') || is_singular("product") || is_tax("product_cat") )
        {
            $sidebar = isset(piThemeOptions::$piOptions['posts_settings']['choosidebar']) ? piThemeOptions::$piOptions['posts_settings']['choosidebar'] : 'r-sidebar';
        }else{
            $sidebar = isset(piThemeOptions::$piOptions['woocommerce']['choosidebar']) ? piThemeOptions::$piOptions['woocommerce']['choosidebar'] : 'r-sidebar';
        }
    }

    return $sidebar;
}


// Render about us
function pi_aboutus_photo($piaData)
{
    ?>
    <div class="tb-cell">
        <?php 
            if ( isset($piaData['photo']) && !empty($piaData['photo']) ) : 
        ?>
            <div class="image-wrap">
                <img src="<?php echo esc_url(wp_get_attachment_url($piaData['photo'])) ?>"  alt="<?php echo get_post_meta($piaData['photo'], '_wp_attachment_image_alt', true); ?>">
            </div>
        <?php 
            endif; 
        ?>
    </div>
    <?php 
}

function pi_aboutus_intro($piaData)
{
    ?>
    <div class="tb-cell">
        <?php if (isset($piaData['title'])) : ?>
        <div class="story-head">
              <?php printf( __('<h4 class="h5 text-uppercase">%s</h4>', 'wiloke'), wp_unslash($piaData['title']) ); ?>
              <hr class="he-divider">
        </div>
        <?php endif; ?>
        <div class="story-content">
        <?php 
            if ( isset($piaData['intro']) && !empty($piaData['intro']) )
            {
                $piaData['intro'] = utf8_decode($piaData['intro']);
                echo '<p>'.wp_unslash($piaData['intro']).'</p>';
            }

            if ( isset($piaData['link']) && !empty($piaData['link']) )
            {
                echo '<p><a class="btn h-btn btn-default" href="'.$piaData['link'].'">'.wp_unslash($piaData['button']).'</a></p>';
            }
          ?>
        </div>  
    </div>
    <?php 
}

/*=========================================*/
/*  Twitter Feed
/*=========================================*/
function pi_twitter_feed()
{
    if( empty(piThemeOptions::$piOptions['twitter']['consumer_key']) || empty(piThemeOptions::$piOptions['twitter']['consumer_secret']) || empty(piThemeOptions::$piOptions['twitter']['access_token']) || empty(piThemeOptions::$piOptions['twitter']['access_token_secret']) )
    {
        echo  "<p class='text-center'>[Please config twitter]</div>";
    }else{
        $output = "";
        $path = get_template_directory() . '/admin/pi-modules/pi-libs/twitter/';


        $limit    = !empty(piThemeOptions::$piOptions['number_of_tweets']) ? piThemeOptions::$piOptions['number_of_tweets'] : 4;
        $username = !empty(piThemeOptions::$piOptions['username']) ? piThemeOptions::$piOptions['username'] : 'envato';

        $consumerKey        = isset(piThemeOptions::$piOptions['twitter']['consumer_key']) ? trim(piThemeOptions::$piOptions['twitter']['consumer_key'])  : '';
        $consumerSecret     = isset(piThemeOptions::$piOptions['twitter']['consumer_secret']) ? trim(piThemeOptions::$piOptions['twitter']['consumer_secret'])  : '';
        $accessToken        = isset(piThemeOptions::$piOptions['twitter']['access_token']) ? trim(piThemeOptions::$piOptions['twitter']['access_token'])  : '';
        $accessTokenSecret  = isset(piThemeOptions::$piOptions['twitter']['access_token_secret']) ? trim(piThemeOptions::$piOptions['twitter']['access_token_secret'])  : '';
        $cacheInterval      = isset(piThemeOptions::$piOptions['twitter']['cache_interval']) ? (int)piThemeOptions::$piOptions['twitter']['cache_interval'] : 15;

        require_once($path.'twitteroauth.php');
        $twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret, $path, $cacheInterval);
        $twitter->ssl_verifypeer=true;
        $tweets = $twitter->get('statuses/user_timeline', array('screen_name' => $username, 'exclude_replies' => 'false', 'include_rts' => 'false', 'count' => $limit));

        if ( !empty($tweets) )
        {
            $tweets = json_decode($tweets);

            if(is_array($tweets) )
            {
                $output .= '<div class="twitter-slider">';
                
                if ( isset($tweets->errors) )
                {   
                    $output .= "Sorry! That page does not exist!";
                }else{
                    foreach($tweets as $control)
                    {
                        $status =   preg_replace('/http:\/\/([^\s]+)/i', '<a href="http://$1" target="_blank">$1</a>', $control->text);
                        $output .= '<div class="twitter-item text-center"><p>' . $status . '</p></div>';
                    }
                }
                $output .= '</div>';
            }
            
        }else{
            $output .= '<p class="text-center">Could not retrieve data from twitter!</div>';
        }

        echo $output;
    }
}

/*=========================================*/
/*  Woocomerce
/*=========================================*/
