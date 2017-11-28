<?php

/*
@package embark
 ===================================
 ===== ADMIN ENQUEUE FUNCTIONS =====
 ===================================
*/

 function embark_load_admin_scripts($hook){
 	//echo $hook;

 	// register css admin section
 	wp_register_style( 'raleway-admin', 'https://fonts.googleapis.com/css?family=Raleway:200,300,500' );
 	wp_register_style( 'embark_admin', get_template_directory_uri() . '/css/embark.admin.css', array(), '1.0.0', 'all' );

 	//register js admin section
 	wp_register_script( 'embark_admin_script', get_template_directory_uri() . '/js/embark.admin.js', array('jquery'), '1.0.0', true);

 	$pages_array = array(
		'toplevel_page_embark_options',
		'embark_page_embark_options_css',
		'embark_page_embark_contact_options',
		'embark_page_embark_theme_options'
	);

	if(in_array($hook, $pages_array)){
		wp_enqueue_style( 'embark_admin' );
		wp_enqueue_style( 'raleway_admin' );
	}

 	if ($hook == 'toplevel_page_embark_options'){ // adding media uploader & styles to Sidebar Options
	 	// add media uploader:
	 	wp_enqueue_media();
	 	
	 	wp_enqueue_script( 'embark_admin_script' );
	} 
	
	if ( $hook == 'embark_page_embark_options_css' ){// adding ace to backend for Schweet Syntax Editor

		wp_enqueue_style('ace-style', get_template_directory_uri() . '/css/embark.ace.css', array(), '1.0.0', 'all' );
		wp_enqueue_script( 'embark-ace', get_template_directory_uri() . '/js/ace/ace.js', array('jquery'), '1.2.9', true );
		wp_enqueue_script( 'embark-custom-css-script',  get_template_directory_uri() . '/js/embark.custom_css.js', array('jquery'), '1.0.0', true );

 	} 
 }
 add_action( 'admin_enqueue_scripts', 'embark_load_admin_scripts' );

 /*
  =======================================
  ===== FRONT-END ENQUEUE FUNCTIONS =====
  =======================================
*/
function embark_load_scripts(){
	
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.0.0', 'all' );
	wp_enqueue_style('embark', get_template_directory_uri() . '/css/embark.css', array(), '1.0.0', 'all' );
	wp_enqueue_style('raleway', 'https://fonts.googleapis.com/css?family=Raleway:200,300,500');

	wp_deregister_script( 'jquery' );
	wp_enqueue_script('jquery','https://code.jquery.com/jquery-3.2.1.min.js', array(), '3.2.1', true);
	wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js', array(), '1.12.3', true);
	wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js', array('jquery'), '4.0.0', true);
	wp_enqueue_script( 'embark_gallery_script', get_template_directory_uri() . '/js/embark.js', array('jquery'), '1.0.0', true);
	wp_enqueue_script('embark-disqus', 'https://embark-theme.disqus.com/count.js"', array(), '1.0.0', true);
	

}
add_action('wp_enqueue_scripts', 'embark_load_scripts');

 
