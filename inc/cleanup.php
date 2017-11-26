<?php

/*
@package embark
 ===================
 ===== CLEANUP =====
 ===================
*/

/*
  =============================
  ===== REMOVE WP VERSION =====
  =============================
*/
// Remove version string from js and css
function embark_remove_wp_version_strings($src){
	global $wp_version;
	parse_str(parse_url($src,PHP_URL_QUERY), $query);
	if(!empty($query['ver']) && $query['ver'] === $wp_version){
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
add_filter('script_loader_src','embark_remove_wp_version_strings');
add_filter('style_loader_src', 'embark_remove_wp_version_strings');

// Remove metatag generator from header
function embark_remove_meta_version(){
	return '';
}
add_filter('the_generator', 'embark_remove_meta_version');

/*
  ========================
  ===== EMOJI A-BOMB =====
  ========================
*/
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

// Remove emojis from TinyMCE
function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}
// Remove DNS prefetch (fuckin' emojis...)
add_filter( 'emoji_svg_url', '__return_false' );
