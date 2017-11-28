<?php 
/*
@package embark
 ===================
 ===== SIDEBAR =====
 ===================
*/
if(!is_active_sidebar('embark-sidebar')){
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	
	<?php dynamic_sidebar('embark-sidebar'); ?>
</aside>
