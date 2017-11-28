<?php 
/*
@package embark
 ===================
 ===== WIDGETS =====
 ===================
*/
class Embark_Profile_Widget extends WP_Widget {
	// Setup the widget name, description, etc
	public function __construct() {
		$widget_ops = array(
			'classname' 	=> 'embark-profile-widget',
			'description'	=> 'Custom Embark Profile Widget',
		);
		parent::__construct('embark_profile', 'Embark Profile', $widget_ops);
	}

	// Back-end display of widget
	public function form($instance){
		echo '<p><strong>No options for this widget.</strong><br />You can modify this widget on the <a href="./admin.php?page=embark_options">Sidebar Options Page</a></p>';
	}

	// Front-end display of widget
	public function widget($args, $instance){
		$picture = esc_attr(get_option('profile_picture'));
		$firstName = esc_attr(get_option('first_name'));
	 	$lastName = esc_attr(get_option('last_name'));
	 	$fullName = $firstName . ' ' . $lastName;
	 	$description = esc_attr(get_option('user_description'));

	 	$twitter_icon = esc_attr( get_option( 'twitter_handle' ) );
		$facebook_icon = esc_attr( get_option( 'facebook_handle' ) );
		$gplus_icon = esc_attr( get_option( 'gplus_handle' ) );

		echo $args['before_widget'];
		?>
		<div class="text-center">
			<div class="image-container">
				<div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?= $picture; ?>);">
				</div>
			</div><!-- .image-container -->
			<h1 class="embark-username"><?= $fullName; ?></h1>
			<h2 class="embark-description"><?= $description; ?></h2>
			<div class="icons-wrapper">
				<?php if( !empty( $twitter_icon ) ): ?>
					<a href="https://twitter.com/<?= $twitter_icon; ?>" target="_blank"><span class="embark-social-icon embark-sidebar-icon embark-social-twitter"></span></a>
				<?php endif; 
				if( !empty( $gplus_icon ) ): ?>
					<a href="https://plus.google.com/u/0/+<?= $gplus_icon; ?>" target="_blank"><span class="embark-social-icon embark-sidebar-icon embark-social-google"></span></a>
				<?php endif; 
				if( !empty( $facebook_icon ) ): ?>
					<a href="https://facebook.com/<?= $facebook_icon; ?>" target="_blank"><span class="embark-social-icon embark-sidebar-icon embark-social-facebook"></span></a>
				<?php endif; ?>
			</div>
		</div><!-- .text-center -->
		<?php
		echo $args['after_widget'];
	}
} // Embark Profile Widget

add_action('widgets_init', function(){
	register_widget('Embark_Profile_Widget');
}); // Embark Profile Widget

// Edit default WordPress widgets
function embark_tag_cloud_font_fix($args){
	$args['smallest'] = 8;
	$args['largest'] = 8;

	return $args;
}
add_filter('widget_tag_cloud_args', 'embark_tag_cloud_font_fix');

function embark_list_categories_output_change( $links ) {
	
	$links = str_replace('</a> (', '</a> <span>', $links);
	$links = str_replace(')', '</span>', $links);
	
	return $links;
	
}
add_filter( 'wp_list_categories', 'embark_list_categories_output_change' );

// Save Posts views
function embark_save_post_views($postID){
	$metaKey = 'embark_post_views';
	$views = get_post_meta($postID, $metaKey, true);

	$count = ( empty($views) ? 0 : $views);
	$count++;

	update_post_meta($postID, $metaKey, $count);

	echo $views;
}
// Remove the previous and next postIDs to prevent false count increases triggered
// by the previous and next posts navigation.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
