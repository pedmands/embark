<?php 
/*
@package embark
 ===================
 ===== WIDGETS =====
 ===================
*/

 /*
 	==============================[ Edit Default WP Widgets ]==============================
 */ 
// Limit the size of the tag cloud font to be uniform.
function embark_tag_cloud_font_fix($args){
	$args['smallest'] = 8;
	$args['largest'] = 8;

	return $args;
}
add_filter('widget_tag_cloud_args', 'embark_tag_cloud_font_fix');

// Add span tags to the post count for Categories.
function embark_list_categories_output_change( $links ) {
	
	$links = str_replace('</a> (', '</a> <span>', $links);
	$links = str_replace(')', '</span>', $links);
	
	return $links;
	
}
add_filter( 'wp_list_categories', 'embark_list_categories_output_change' );

 /*
 	==============================[ Embark Profile Widget ]==============================
 */ 
class Embark_Profile_Widget extends WP_Widget {
	// Setup the widget name, description, etc.
	public function __construct() {
		$widget_ops = array(
			'classname' 	=> 'embark-profile-widget',
			'description'	=> 'Custom Embark Profile Widget',
		);
		parent::__construct('embark_profile', 'Embark Profile', $widget_ops);
	}

	// Back-end display of widget.
	public function form($instance){
		echo '<p><strong>No options for this widget.</strong><br />You can modify this widget on the <a href="./admin.php?page=embark_options">Sidebar Options Page</a></p>';
	}

	// Front-end display of widget.
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
});

 /*
 	==============================[ Embark Popular Posts Widget ]==============================
 */ 

// Save Posts views
function embark_save_post_views($postID){
	$metaKey = 'embark_post_views';
	$views = get_post_meta($postID, $metaKey, true);

	$count = ( empty($views) ? 0 : $views);
	$count++;

	update_post_meta($postID, $metaKey, $count);
}

// Remove the previous and next postIDs to prevent 
// false count increases triggered by the previous
// and next posts navigation.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Construct the Popular Posts Widget.
class Embark_Popular_Posts_Widget extends WP_Widget {
	// Setup the widget name, description, etc.
	public function __construct() {
		$widget_ops = array(
			'classname' 	=> 'embark-popular-posts',
			'description'	=> 'Popular Posts Widget',
		);
		parent::__construct('embark_popular_posts', 'Embark Popular Posts', $widget_ops);
	}

	// Back-end display of widget.
	public function form($instance){
		$title = ( !empty($instance['title']) ? $instance['title'] : 'Popular Posts' );
		$tot = ( !empty($instance['tot']) ? absint($instance['tot']) : 4 );

		$output = '<p>';
		$output .= '<label for="'. esc_attr($this->get_field_id('title')) .'">Title:</label>';
		$output .= '<input type="text" class="widefat" id="'. esc_attr($this->get_field_id('title')) .'" name="'. esc_attr($this->get_field_name('title')) .'" value="'.esc_attr($title).'">';
		$output .= '</p>';

		$output .= '<p>';
		$output .= '<label for="'. esc_attr($this->get_field_id('tot')) .'">Number of Posts:</label>';
		$output .= '<input type="number" class="widefat" id="'. esc_attr($this->get_field_id('tot')) .'" name="'. esc_attr($this->get_field_name('tot')) .'" value="'.esc_attr($tot).'">';
		$output .= '</p>';

		echo $output;
	}

	// Update widget.
	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = ( !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '' );
		$instance['tot'] = ( !empty($new_instance['tot']) ? absint(strip_tags($new_instance['title'])) : 0 );

		return $instance;
	}

	// Front-end display of widget.
	public function widget($args,$instance){
		$tot = absint($instance['tot']);
		$posts_args = array(
			'post_type'			=> 'post',
			'posts_per_page'	=> $tot,
			'meta_key'			=> 'embark_post_views',
			'orderby'			=> 'meta_value_num',
			'order'				=> 'DESC'
		);

		$posts_query = new WP_Query( $posts_args );

		echo $args['before_widget'];
		if( !empty($instance['title'])):
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		endif;
		if($posts_query->have_posts()):
			echo '<ul>';
				while($posts_query->have_posts() ) : $posts_query->the_post();
					echo '<li>' .get_the_title().'</li>';
				endwhile;
			echo '</ul>';
		endif;
		echo $args['after_widget'];
	}

} // Embark Popular Posts Widget
add_action('widgets_init', function(){
	register_widget('Embark_Popular_Posts_Widget');
});
