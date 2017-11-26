<?php 
/*
@package embark
 ==========================
 ===== AJAX FUNCTIONS =====
 ==========================
*/
 // Hook the JS into this PHP
add_action('wp_ajax_nopriv_embark_load_more','embark_load_more');
add_action('wp_ajax_embark_load_more','embark_load_more');

function embark_load_more(){
 	$paged = $_POST["page"]+1;
 	$prev = $_POST["prev"];
 	$archive = $_POST["archive"];

 	if ($prev == 1 && $_POST["page"] != 1){
 		$paged = $_POST["page"]-1;
 	}

 	$args = array (
 		'post_type'		=> 'post',
 		'post-status'	=> 'publish',
 		'paged'			=> $paged
 	);

 	if($archive != '0'){
 		$archVal = explode('/', $archive);
 		// flip the array to scan the keys
 		$flipped = array_flip($archVal);

 		// Check if category, tag or author
 		switch (isset($flipped)){
 			case $flipped["category"] :
 				$type = "category_name";
	 			$key = "category";
	 			break;
 			case $flipped["tag"] :
 				$type = "tag";
	 			$key = $type;
	 			break;
 			case $flipped["author"] :
 				$type = "author";
	 			$key = $type;
	 			break;
 		}

 			$currKey = array_keys($archVal, $key);
 			$nextKey = $currKey[0]+1;
 			$value = $archVal[$nextKey];

 			$args[ $type ] = $value;

 		// Check page trail and remove "page":
 		if(isset($flipped["page"])){
 			$pageVal = explode('page', $archive);
 			$page_trail = $pageVal[0];
 		} else {
 			$page_trail = $archive;
 		}
 		
 	} else {
 		$page_trail = '/';
 	} // if($archive != '0')

 	$query = new WP_Query( $args );

 	if ($query->have_posts()):
 		echo '<div class="page-limit" data-page="'. $page_trail . 'page/'.$paged.'/">';
		while($query->have_posts()) : $query->the_post();
			get_template_part('template-parts/content', get_post_format());
		endwhile;
		echo '</div>';

	else :
		echo 0;
	endif;

	wp_reset_postdata();

 	die();
 }// embark_load_more()

function embark_check_paged($num = null){
	$output = '';
	if( is_paged() ){
		$output = 'page/' . get_query_var('paged') . '/';
	}
	if ( $num == 1 ){
		$paged = ( get_query_var('paged') == 0 ? 1 : get_query_var('paged') );
		return $paged;
	} else {
		return $output;
	}
} 
