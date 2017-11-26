<?php 
/*
@package embark

Comments

*/
if(post_password_required()){
	return;
}
?>

<div id="comments" class="embark-comments-area">
	<?php 
		if(have_comments()):
		// we have comments!
	?>
		<h2 class="comments-title">
			<?php 
				printf(
					esc_html( _nx('One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'embark' )),
					number_format_i18n( get_comments_number()),
					'<span>' . get_the_title() . '</span>'
				);
			?>
		</h2>
	
		<?php embark_get_comment_navigation(); ?>

		<ul class="comment-list">
			<?php 
				$args = array(
					'walker'			=> null,
					'max_depth'			=> 4,
					'style'				=> 'ul',
					'callback'			=> null,
					'end-callback'		=> null,
					'type'				=> 'all',
					'reply_text'		=> 'Reply',
					'page'				=> '',
					'per_page'			=> '',
					'avatar_size'		=> 40,
					'reverse_top_level'	=> null,
					'reverse_children'	=> null,
					'format'			=> 'html5',
					'short_ping'		=> false,
					'echo'				=> true
				);
				wp_list_comments($args);
			?>	
		</ol>

		<?php embark_get_comment_navigation(); ?>

		<?php if(!comments_open() && get_comments_number()): ?>
			<p class="no-comments"><?php esc_html_e('Comments are closed.', 'embark'); ?></p>
		<?php endif; ?>		

	<?php 
		endif; 
	?>

	<?php 
		$fields = array(
			'auhor'	=> 
				'<div class="form-group"><label for="author">' . __( 'Name', 'embark' ) . '</label> <span class="required">*</span> <input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" required="required" /></div>',
			'email' =>
				'<div class="form-group"><label for="email">' . __( 'Email', 'domainreference' ) . '</label> <span class="required">*</span> <input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" required="required" /></div>',
			'url' =>
				'<div class="form-group"><label for="url">' . __( 'Website', 'domainreference' ) . '</label> <input id="url" class="form-control last-field" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" /></div>'

		);
		$args = array(
			'class_submit'		=> 'btn btn-block btn-lg btn-warning',
			'label_submit'		=> __('Submit Comment'),
			'fields'			=> apply_filters('comment_form_default_fields', $fields),
			'comment_field' =>
				'<div class="form-group"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" class="form-control" name="comment" rows="4" aria-required="true" required="required"></textarea></div>'

		);
		comment_form($args); 
	?>

</div><!-- embark-comments-area -->
