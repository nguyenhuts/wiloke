<?php

define('THEMENAME', '');
    
class piWidgets extends piCore
{


    public function __construct()
    {
        add_action('widgets_init', array($this, 'pi_widgets_building') );
        add_action('wp_enqueue_scripts', array($this, 'pi_widgets_scripts'));
    }

    public function pi_widgets_scripts()
    {
        if ( !is_page_template("homepage.php") )
        {
            $url  = get_template_directory_uri() . '/assets/';
            wp_register_script('pi_jflickrfeed', $url . 'js/lib/jflickrfeed.min.js', array(), '3.0.2', true);
            wp_enqueue_script('pi_jflickrfeed');
        }
    }



    public function  pi_widgets_building()
    {
        $aListWidgets = array('pi_flickr_feed', 'pi_facebook_likebox');

        foreach ($aListWidgets as $widget)
        {
            register_widget( $widget );
        }
    }

}

class pi_flickr_feed extends WP_Widget
{
    public function __construct()
    {
        $args = array('classname'=>'pi_flickr_feed', 'description'=>'');
        parent::__construct("pi_flickr_feed", THEMENAME . 'Flickr Feed ', $args);
    }

    public function form($instance)
    {
        $defaults = array( 'title' =>'Flickr', 'flickr_id'=>'', 'number_of_photo' => '6' , 'flickr_display' => 'latest' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" type="text" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'flickr_id' ); ?>">Flickr ID</label>
            <input id="<?php echo $this->get_field_id( 'flickr_id' ); ?>" name="<?php echo $this->get_field_name( 'flickr_id' ); ?>" value="<?php echo esc_attr($instance['flickr_id']); ?>" class="widefat" type="text" />
            <span class="help"> Find Your ID at( <a target="_blank" style="color:red" href="http://www.idgettr.com">idGettr</a> )</span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'number_of_photo' ); ?>">Number of photos to show </label>
            <input id="<?php echo $this->get_field_id( 'number_of_photo' ); ?>" name="<?php echo $this->get_field_name( 'number_of_photo' ); ?>" value="<?php echo esc_attr($instance['number_of_photo']); ?>" type="text" size="3" />
        </p>

        <?php
    }

    public  function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title']              = strip_tags( $new_instance['title'] );
        $instance['number_of_photo']    = (int)$new_instance['number_of_photo'];
        $instance['flickr_id']          = strip_tags( $new_instance['flickr_id'] );
        return $instance;
    }

    public function widget( $args, $instance )
    {
        extract( $args, EXTR_SKIP );
        $title          = apply_filters('widget_title', $instance['title'] );
        $no_of_photos   = $instance['number_of_photo'];
        $flickr_id      = $instance['flickr_id'];


        $output = "";
        $output .= $before_widget;
        $output .= '<div class="widget_flickr">';
        if(!empty($title))
        $output .= $before_title.esc_attr($title).$after_title;
        $output .= '<div class="box-content">';
        $output .= "<ul id='pi-flickr-widget' class='thumbs rs clearfix'>";
        $output .= '</ul>';
        $output .= '</div>';
        $output .='<script type="text/javascript">';
        $output .= 'jQuery(document).ready(function($){';
        $output .= '$("#pi-flickr-widget").jflickrfeed({';
        $output .= 'limit: ' . $no_of_photos . ',';
        $output .= 'qstrings: {';
        $output .= "id: '".$flickr_id."',";
        $output .= '},';
        $output .= 'itemTemplate: \'<li class="transition"><a href="{{image}}" target="_blank"><img alt="{{title}}" src="{{image_s}}" /></a></li>\'';
        $output .= '})';
        $output .= '})';
        $output .= '</script>';
        $output .= '</div>';
        $output .= $after_widget;

        echo $output;
    }
}

class pi_facebook_likebox extends WP_Widget
{
    public function __construct()
    {
        $args = array('classname'=>'pi_facebook_likebox', 'description'=>'');
        parent::__construct("pi_facebook_likebox", THEMENAME . 'Facebook Like Box ', $args);
    }

    public function form($instance)
    {
        $defaults = array( 'title' =>'Fanpage', 'facebook_likebox_title'=>'Fan page', 'facebook_likebox_embed' => '');
        $instance = wp_parse_args( (array) $instance, $defaults );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'wiloke'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" type="text" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_likebox_embed' ); ?>"><?php _e('Embed Iframe', 'wiloke'); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'facebook_likebox_embed' ); ?>" name="<?php echo $this->get_field_name( 'facebook_likebox_embed' ); ?>" class="widefat"><?php echo htmlentities($instance['facebook_likebox_embed']); ?></textarea>
            <span class="help"><?php _e('To get iframe code, please click', 'wiloke') ?><a target="_blank" style="color:red" href="https://developers.facebook.com/docs/plugins/like-box-for-pages"><?php _e(' here','wiloke');?></a>, <?php _e('then click on Get Code->iFrame', 'wiloke') ?></span>
        </p>
        <?php
    }

    public  function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title']                      = strip_tags( $new_instance['title'] );
        $instance['facebook_likebox_embed']     = $new_instance['facebook_likebox_embed'];
        return $instance;
    }

    public function widget( $args, $instance )
    {
        extract( $args, EXTR_SKIP );
        $title          = apply_filters('widget_title', $instance['title'] );

        
        $output = "";
        $output .= $before_widget;
        $output .= '<div class="facebook_likebox">';
        if(!empty($title))
        $output .= $before_title.esc_attr($title).$after_title;
        $output .= '<div class="box-content">';
        $output .= isset($instance['facebook_likebox_embed']) ? $instance['facebook_likebox_embed'] : '';
        $output .= '</div>';
        $output .= $after_widget;

        echo $output;
    }
}