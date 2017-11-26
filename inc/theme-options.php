<?php

/*
@package embark
 ==============================
 ===== THEME OPTIONS PAGE =====
 ==============================
*/
$options = get_option('post_formats');
$formats = array('aside','gallery','link','image','quote','status','video','audio','chat');
$output = array();
 	foreach($formats as $format){
 		$output[] = (@$options[$format] == 1 ? $format : '');
 	}
 
 if (!empty($options)){
 	add_theme_support('post-formats', $output);
 }
$header = get_option('custom_header');
if (@$header == 1){
	add_theme_support( 'custom-header' );
}
$background = get_option('custom_background');
if (@$background == 1){
	add_theme_support( 'custom-background' );
}

add_theme_support('post-thumbnails');

// Activate Nav Menu
function embark_register_nav_menu(){
	register_nav_menu('primary','Header Navigation Menu');
}
add_action('after_setup_theme','embark_register_nav_menu');

// Activeate HTML5 features
add_theme_support('html5',array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

/*
 =============================
 ===== SIDEBAR FUNCTIONS =====
 =============================
*/
function embark_sidebar_init(){
	register_sidebar(
		array(
			'name'			=> esc_html__('Sunset Sidebar', 'embark'),
			'id'			=> 'embark-sidebar',
			'description'	=> 'Dynamic Right Sidebar',
			'before_widget'	=> '<section id=%1$s class="embark-widget %2$s">',
			'after_widget'	=> '</section>',
			'before_title'	=> '<h2 class=""embark-widget-title>',
			'after_title'	=> '</h2>'
		));
}

/*
 ======================================
 ===== BLOG LOOP CUSTOM FUNCTIONS =====
 ======================================
*/

// Custom meta function
function embark_posted_meta(){
	$posted_on = human_time_diff(get_the_time('U'),current_time('timestamp'));
	$categories = get_the_category();
	$separator = ', ';
	$output = '';
	$i = 1;

	if(!empty($categories)){
		foreach($categories as $category){
			if($i > 1){
				$output .= $separator;
			}
			$output .= '<a href="'.esc_url(get_category_link($category->term_id)).'" alt="'.esc_attr('View all posts in %s', $category->name).'">'.esc_html($category->name).'</a>';
			$i++;
		}
	}

	return '<span class="posted-on">Posted <a href="'.esc_url(get_permalink()).'">'. $posted_on .'</a> ago </span> / <span class="posted-in">'. $output .'</span>';
}
// Custom footer function
function embark_posted_footer(){
	$comments_num = get_comments_number();
	if(comments_open()){
		//get comments link
		if($comments_num == 0){
			$comments = __('No Comments');
		} elseif ($comments_num >1){
			$comments = $comments_num . __(' Comments');
		} else {
			$comments = __('1 Comment');
		}
		$comments = '<a class="comments-link" href="'.get_comments_link().'">'.$comments.' <span class="embark-icon embarkcomment"></span></a>';
	} else {
		$comments = __('Comments are closed');
	}

	return '<div class="post-footer-container"><div class="row"><div class="col-12 col-sm-6">'.get_the_tag_list('<div class="tags-list"><span class="embark-icon embarktag"></span>', ' ', '</div>').'</div><div class="col-12 col-sm-6 text-right">'.$comments.'</div></div></div>';
}
// Image Post Function
function embark_get_attachment($num = 1){
	$output = '';
		if(has_post_thumbnail() && $num == 1):
			$output = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
		else:
			$attachments = get_posts(array(
				'post_type'		=> 'attachment',
				'posts_per_page'	=> $num,
				'post_parent'	=> get_the_ID()
			));
			if ($attachments && $num == 1):
				foreach($attachments as $attachment){
					$output = wp_get_attachment_url($attachment->ID);
				}
			elseif($attachments && $num > 1):
				$output= $attachments;
			endif;
			wp_reset_postdata();
		endif;
			return $output;
}

// Extract embedded media
function embark_get_embedded_media($type = array()){
	$content = do_shortcode(apply_filters('the_content', get_the_content()));
	$embed = get_media_embedded_in_content( $content, $type );
	if(in_array('audio', $type)){
		if($embed[0]){
		$output = str_replace( '?visual=true', '?visual=false', $embed[0]);
		} else {
		$output = '';
		}
	} else {
		if($embed[0]){
			$output = $embed[0];
		}
	}
	
	return $output;
	wp_reset_postdata();
}
// Check if user is Admin, display edit button.
function embark_edit_button(){
	$current_user = wp_get_current_user();
	$output = '';
	if (user_can( $current_user, 'administrator' )) {
	  $output = edit_post_link( 'Edit Post', '', '', get_the_ID(), 'embark-edit-post' );
	}
	return $output;
}

// Function to build array of thumbnails for Gallery Post Type
function embark_get_bs_slides($attachments){
	$output = array();
	$count = count($attachments)-1;

	for($i = 0; $i <= $count; $i++): 
		$active = ($i == 0 ? ' active' : '');

		$n = ($i == $count ? 0 : $i+1 );
		$nextImg = wp_get_attachment_thumb_url($attachments[$n]->ID);

		$p = ($i == 0 ? $count : $i-1 );
		$prevImg = wp_get_attachment_thumb_url($attachments[$p]->ID);

		$output[$i] = array(
			'class' 	=> $active, 
			'url'		=> wp_get_attachment_url($attachments[$i]->ID),
			'next_img'	=> $nextImg,
			'prev_img'	=> $prevImg,
			'caption'	=> $attachments[$i]->post_excerpt
		);
	endfor;
	return $output;
}

// Function to grab URL from Link Post Type
function embark_grab_url(){
	if( ! preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $links)){
		return false;
	}
	return esc_url_raw($links[1]);
}

function embark_grab_current_uri(){
	$http = (isset($_SERVER["HTTPS"]) ? 'https://' : 'http://');
	$referer = $http . $_SERVER["HTTP_HOST"];
	$archive_url = $referer . $_SERVER["REQUEST_URI"];

	return $archive_url;
}

/*
 =============================================
 ===== SINGLE POST LOOP CUSTOM FUNCTIONS =====
 =============================================
*/
function embark_post_navigation(){
	$nav = '<div class="row">';

	$prev = get_previous_post_link('<div class="post-link-nav"><span class="embark-icon embarkchevron-left" aria-hidden="true"></span> %link</div>', '%title');
	$nav .= '<div class="col-12 col-sm-6">'.$prev.'</div>';

	$next = get_next_post_link('<div class="post-link-nav">%link <span class="embark-icon embarkchevron-right" aria-hidden="true"></span></div>', '%title');
	$nav .= '<div class="col-12 col-sm-6 text-right">'.$next.'</div>';

	$nav .= '</div>';


	return $nav;
}
// Social Sharing Section
function embark_share_this($content){

	if(is_single()){
		$output = '<div class="embark-share-this"><h4>Share This</h4>';
		
		$title = get_the_title();
		$permalink = get_permalink();
		$twitterHandle = (get_option('twitter_handle') ? '&amp;via='.esc_attr(get_option('twitter_handle')) : '');

		$twitter = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$permalink.$twitterHandle.'';
		$facebook = 'https://facebook.com/sharer/sharer.php?u=' . $permalink;
		$google = 'https://plus.google.com/share?url=' . $permalink;
			
		$output .=	'<ul>';
		$output .=	'<li><a href="'.$twitter.'" rel="nofollow" target="_blank"><span class="embark-social-icon embark-social-twitter"></span></a></li>';
		$output .=	'<li><a href="'.$facebook.'" rel="nofollow" target="_blank"><span class="embark-social-icon embark-social-facebook"></span></a></li>';
		$output .=	'<li><a href="'.$google.'" rel="nofollow" target="_blank"><span class="embark-social-icon embark-social-google"></span></a></li>';
		$output .=	'</ul></div><!-- embark-share -->';

		return $content.$output;
	} else {
		return $content;
	}

}// embark_share_this()
add_filter('the_content', 'embark_share_this');

function embark_get_comment_navigation(){
	if(get_comment_pages_count() > 1 && get_option('page_comments')){
		require(get_template_directory() . '/inc/templates/embark-comment-nav.php');
	}
}
