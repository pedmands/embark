<?php 
/*
@package embark

Image Post Format

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('embark-format-image'); ?>>


	<header class="entry-header text-center background-image" style="background-image: url(<?= embark_get_attachment(); ?>);">
		<?php the_title('<h1 class="entry-title"><a href="'.esc_url( get_permalink()).'" rel="bookmark">','</a></h1>'); ?>
		<div class="entry-meta">
			<?php echo embark_posted_meta(); ?>
		</div>

		<div class="entry-excerpt image-caption">
			<?php the_excerpt(); ?>
		</div>
	</header>

	<footer class="entry-footer">
		
		<?php echo embark_posted_footer(); ?>
	</footer>
</article>
