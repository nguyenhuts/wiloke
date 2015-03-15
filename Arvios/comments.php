<div id="comments">
	<div class="comments-inner-wrap">
		<?php if (post_password_required()) : ?>
		<p><?php _e( 'Post is password protected. Enter the password to view any comments.', 'wiloke' ); ?></p>
		<?php return; endif; ?>

		<?php if (have_comments()) : ?>
 
			<h3 id="comments-title" class="h3"><?php comments_number('No Comment', 'Comment [1]', '% Comments'); ?></h3>
			<?php pi_comment_nav(); ?>
			<ul class="commentlist">
				<?php wp_list_comments('type=comment&callback=pi_comment'); // Custom callback in functions.php ?>
			</ul>

		<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

			<p><?php _e( 'Comments are closed here.', 'wiloke' ); ?></p>

		<?php endif; ?>
	</div>
</div> 

<div id="wrap-respond">
<?php 
$commenter = wp_get_current_commenter();
$commenter['comment_author'] = $commenter['comment_author'] == '' ? 'Name': $commenter['comment_author'];
$commenter['comment_author_email'] = $commenter['comment_author_email'] == '' ? 'Email': $commenter['comment_author_email'];
$commenter['comment_author_url'] = $commenter['comment_author_url'] == '' ? 'Url': $commenter['comment_author_url'];

$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$comment_args = array(
	'title_reply'       => __( '<div class="reply-title"><h3 class="h3">Leave a Comment</h3></div>', 'wiloke' ),
	'label_submit'      => __( 'leave comment', 'wiloke' ),
	'fields' => apply_filters( 'comment_form_default_fields', array(
		'author' => '<div class="comment-form-author form-item"><input type="text" id="author" name="author"  tabindex="1" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' /></div>',  
		'email'  => '<div class="comment-form-email form-item"><input type="text" id="email" name="email" tabindex="2" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' /></div>',
		'url'    => '<div class="form-item website"><input type="text" name="url" name="url"  tabindex="3" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="32"' . $aria_req . ' /></div>' )),
	'comment_field' => '<div class="comment-form-comment form-textarea-wrapper"><textarea id="comment" name="comment"  tabindex="4"	class="tb-eff"></textarea></div>',
	'comment_notes_after' => '',
	'comment_notes_before' => '',
	);
comment_form($comment_args);

?>
</div>

