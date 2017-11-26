<?php 
/*
@package embark
 =============================
 ===== SHORTCODE OPTIONS =====
 =============================
*/

function embark_tooltip($atts, $content = null){
	// get the attributes
	$atts = shortcode_atts(
		array(
			'placement' => 'top',
			'title' 	=> '',
			'html'		=> 'false'
		),
		$atts,
		'tooltip'
	);
	$title = ($atts['title'] == '' ? $content : $atts['title']);

	// return HTML
	return '<span class="embark-tooltip" data-toggle="tooltip" data-html="'.$atts['html'].'" data-placement="'.$atts['placement'].'" title="'.$title.'">'.$content.'</span>';
}
add_shortcode('tooltip', 'embark_tooltip');

function embark_popover($atts, $content = null){
	// get the attributes
	$atts = shortcode_atts(
		array(
			'placement' => 'top',
			'title' 	=> '',
			'content' 	=> '',
			'dismissable' => false,
			'html'		=> 'false',
			'trigger'	=> 'click'
		),
		$atts,
		'popover'
	);
	// check if dismissable
	if ($atts['dismissable'] == 'true'){
		$dismiss = 'tabindex="0" data-trigger="focus"';
	} else {
		$dismiss = '';
	}
	$title = ($atts['title'] == '' ? '' : 'title="'.$atts['title'].'"');
	$popover_content = ($atts['content'] == '' ? $content : $atts['content']);

	// return HTML
	return '<span class="embark-popover" data-toggle="popover" data-trigger="'.$atts['trigger'].'" data-html="'.$atts['html'].'" data-placement="'.$atts['placement'].'" '.$title.' data-content="'.$popover_content.'"'.$dismiss.'>'.$content.'</span>';
}
add_shortcode('popover', 'embark_popover');
