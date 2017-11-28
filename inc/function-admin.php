<?php

/*
@package embark
 ======================
 ===== ADMIN PAGE =====
 ======================
*/

 function embark_add_admin_page(){
 	// Add the main Embark Admin page
 	add_menu_page( 'Embark Theme Options', 'Embark', 'manage_options', 'embark_options', 'embark_theme_sidebar_page', get_template_directory_uri() . '/img/embark-icon.png', 110);
 	// Add Embark Admin sub pages
 	add_submenu_page( 'embark_options', 'Embark Sidebar Settings', 'Sidebar', 'manage_options', 'embark_options', 'embark_theme_sidebar_page' );
 	add_submenu_page( 'embark_options', 'Embark Theme Options', 'Theme Options', 'manage_options', 'embark_theme_options', 'embark_theme_options_page');
 	add_submenu_page( 'embark_options', 'Embark Contact Form', 'Contact Form', 'manage_options', 'embark_contact_options', 'embark_theme_contact_page' );
 	add_submenu_page( 'embark_options', 'Embark CSS Options', 'Custom CSS', 'manage_options', 'embark_options_css', 'embark_theme_css_page' );

 	// Activate custom settings
 	add_action('admin_init', 'embark_custom_settings');

 }
 add_action('admin_menu', 'embark_add_admin_page');

 function embark_custom_settings(){
 	// Sidebar Options
 	register_setting( 'embark-settings-group', 'profile_picture' );
 	register_setting( 'embark-settings-group', 'first_name' );
 	register_setting( 'embark-settings-group', 'last_name' );
 	register_setting( 'embark-settings-group', 'user_description' );
 	register_setting( 'embark-settings-group', 'twitter_handle', 'embark_sanitize_twitter_handle' );
 	register_setting( 'embark-settings-group', 'facebook_handle' );
 	register_setting( 'embark-settings-group', 'gplus_handle' );

 	add_settings_section('embark-sidebar-options', 'Sidebar Options', 'embark_sidebar_options', 'embark_options');

 	add_settings_field( 'sidebar-profile-picture', 'Profile Picture', 'embark_sidebar_profile', 'embark_options', 'embark-sidebar-options' );
 	add_settings_field( 'sidebar-name', 'Full Name', 'embark_sidebar_name', 'embark_options', 'embark-sidebar-options' );
 	add_settings_field( 'sidebar-description', 'Description', 'embark_sidebar_description', 'embark_options', 'embark-sidebar-options' );
 	add_settings_field( 'sidebar-twitter', 'Twitter Handle','embark_sidebar_twitter', 'embark_options', 'embark-sidebar-options');
 	add_settings_field( 'sidebar-facebook', 'Facebook Handle','embark_sidebar_facebook', 'embark_options', 'embark-sidebar-options');
 	add_settings_field( 'sidebar-gplus', 'Google+ Handle','embark_sidebar_gplus', 'embark_options', 'embark-sidebar-options');

 	// Theme Options
 	register_setting('embark-theme-options', 'post_formats');
 	register_setting('embark-theme-options', 'custom_header');
 	register_setting('embark-theme-options', 'custom_background');

 	add_settings_section('embark-theme-options-group','Theme Options', 'embark_theme_settings','embark_theme_options');

 	add_settings_field('post-formats', 'Post Formats', 'embark_post_formats', 'embark_theme_options', 'embark-theme-options-group');
 	add_settings_field('custom-header', 'Custom Header', 'embark_custom_header', 'embark_theme_options', 'embark-theme-options-group');
 	add_settings_field('custom-background', 'Custom Background', 'embark_custom_background', 'embark_theme_options', 'embark-theme-options-group');

 	// Contact Form Options
 	register_setting('embark-contact-options', 'activate_contact');

 	add_settings_section('embark-contact-section', 'Contact Form', 'embark_contact_section', 'embark_contact_options');

 	add_settings_field('activate-form', 'Activate Contact Form', 'embark_activate_contact', 'embark_contact_options', 'embark-contact-section');

 	// Custom CSS Options
 	register_setting('embark-custom-css-options','embark_css', 'embark_sanitize_custom_css');

 	add_settings_section('embark-custom-css-section', 'Custom CSS','embark_custom_css_section_callback','embark_options_css');

 	add_settings_field('custom-css','Insert Your Custom CSS', 'embark_custom_css_callback', 'embark_options_css', 'embark-custom-css-section');

 }
 // Custom CSS Functions
  function embark_custom_css_section_callback(){
 	echo 'Customize Embark with your home-baked CSS.';
 }
 function embark_custom_css_callback(){
 	$css = get_option('embark_css');
 	$css = ( empty($css) ? '/* Get Stylish */' : $css );
 	echo '<div id="customCss">'.$css.'</div><textarea id="embark_css" name="embark_css" style="display:none;visibility:hidden;">'.$css.'</textarea>';
 }
 function embark_sanitize_custom_css($input){
	$output = esc_textarea( $input );
	return $output;
 }

// Contact Form Functions
 function embark_contact_section(){
 	echo 'Activate and Deactivate the Built-in Contact Form.';
 }
 function embark_activate_contact(){
 	$options = get_option('activate_contact');
 	$checked = (@$options == 1 ? 'checked' : '');
 	echo '<input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.'/><br>';
 }

// Theme Options Functions
 function embark_theme_settings(){
 	echo 'Activate and Deactivate specific Theme Support Options';
 }

 function embark_post_formats(){
 	$options = get_option('post_formats');
 	$formats = array('aside','gallery','link','image','quote','status','video','audio','chat');
 	$output = '';
 	foreach($formats as $format){
 		$checked = (@$options[$format] == 1 ? 'checked' : '');
 		$output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.'/>'.$format.'</label><br>';
 	}
 	echo $output;
 }
function embark_custom_header(){
 	$options = get_option('custom_header');
 	$checked = (@$options == 1 ? 'checked' : '');
 	echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.'/>Activate Custom Header</label><br>';
 }
function embark_custom_background(){
 	$options = get_option('custom_background');
 	$checked = (@$options == 1 ? 'checked' : '');
 	echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.'/>Activate Custom Background</label><br>';
 }


// Sidebar Options Functions
 function embark_sidebar_options(){
 	echo 'Customize the sidebar.';
 }
function embark_sidebar_profile(){
	$picture = esc_attr( get_option('profile_picture'));
	if(empty($picture)){
		echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload-button" /> <input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'" />';
	} else {
		echo '<input type="button" class="button button-secondary" value="Replace Profile Picture" id="upload-button" /> <input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'" /> <input type="button" class="button button-secondary" value="Remove" id="remove-picture" />';
	}
}
 function embark_sidebar_name(){
 	$firstName = esc_attr(get_option('first_name'));
 	$lastName = esc_attr(get_option('last_name'));
 	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name" /> <input type="text" name="last_name" value="'.$lastName.'" placeholder="Last Name" />';
 }
 function embark_sidebar_description(){
	$description = esc_attr(get_option('user_description'));
 	echo '<input type="text" name="user_description" value="'.$description.'" placeholder="Description" /><p class="description">Write something smart.</p>';
}
function embark_sidebar_twitter(){
	$twitter = esc_attr(get_option('twitter_handle'));
 	echo '<input type="text" name="twitter_handle" value="'.$twitter.'" placeholder="Twitter Handle" /><p class="description">Enter your twitter handle without the @ character.</p>';
}
function embark_sidebar_facebook(){
	$facebook = esc_attr(get_option('facebook_handle'));
 	echo '<input type="text" name="facebook_handle" value="'.$facebook.'" placeholder="Facebook Handle" />';
}
function embark_sidebar_gplus(){
	$gplus = esc_attr(get_option('gplus_handle'));
 	echo '<input type="text" name="gplus_handle" value="'.$gplus.'" placeholder="Google Plus Handle" />';
}

// Remove the @ from Twitter Handle SANITIZE
function embark_sanitize_twitter_handle($input){
	$output = sanitize_text_field( $input );
	$output = str_replace('@', '', $output);
	return $output;
}

 function embark_theme_sidebar_page(){
 	// Pull in the HTML for Sidebar Settings page
 	require_once(get_template_directory().'/inc/templates/embark-admin.php');
 }
 function embark_theme_options_page(){
 	// Pull in the HTML for the Theme Options page
 	require_once(get_template_directory().'/inc/templates/embark-theme-options.php');
 }
 function embark_theme_contact_page(){
 	require_once(get_template_directory().'/inc/templates/embark-contact-options.php');
 }

 function embark_theme_css_page(){
 	// generate html for Embark Custom CSS page
 	require_once(get_template_directory().'/inc/templates/embark-css-options.php');
 }
