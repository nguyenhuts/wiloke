<?php

$args = array('post_type' => 'page', 'post_status' => 'publish');
$post = array(
  'ID'             => '',// Are you updating an existing post?
  'post_content'   => '', // The full text of the post.
  'post_name'      => 'blog', // The name (slug) for your post
  'post_title'     => 'Blog', // The title of your post.
  'post_status'    => 'publish',
  'post_type'      => 'page', // Default 'post'.
  'comment_status' => 'open', // Default is the option 'default_comment_status', or 'closed'.
  'page_template'  => 'template-blog.php'// Requires name of template file, eg template.php. Default empty.
);

$pages = get_pages();

$nonexist = true;

foreach ( (array)$pages as $page ) 
{
  if ( get_page_template_slug($page->ID) == 'template-blog.php' )
  {
    $nonexist = false;
  }
}


if (!$nonexist)
{
  // echo 'adu';
}else{
  $post_id = wp_insert_post( $post, $wp_error );
  update_option($this->blogIdfield, $post_id);
}