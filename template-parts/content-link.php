<?php 
/*
@package embark

Link Post Format

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('embark-format-link'); ?>>
	<header class="entry-header text-center">
		<?php 
		$link = embark_grab_url();
		the_title('<h1 class="entry-title"><a href="'.$link.'" target="_blank">','<div class="link-icon"><span class="embark-icon embarklink"></span></div></a></h1>');

		 ?>
	</header>
	<footer class="entry-footer">
		<?php echo embark_posted_footer(); ?>
	</footer>
</article>
