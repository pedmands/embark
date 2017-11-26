<?php 
/*
@package embark

Aside Post Format

*/
// This is for setting the reveal class without using JS (see index.php)
// $class = get_query_var('post-class');
// If using the above, use this post class function instead: post_class(array('embark-format-aside', $class));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('embark-format-aside'); ?>>
	<div class="aside-container">
	<div class="row">
		<div class="col-12 col-md-4 col-lg-3 text-center">
			<?php if(embark_get_attachment()):?>
			
				<div class="aside-featured background-image" style="background-image: url(<?= embark_get_attachment() ?>);"></div>
			
			<?php endif; ?>
		</div><!-- col-lg-3 -->
		<div class="col-12 col-md-8 col-lg-9">
			<header class="entry-header">
		
				<div class="entry-meta">
					<?php echo embark_posted_meta(); ?>
				</div>

			</header>

			<div class="entry-content">
				
				<div class="entry-excerpt">
					<?php the_content(); ?>
				</div>
			
			</div><!-- entry-content -->
		</div><!-- col-lg-9 -->
	</div><!-- row -->
	
	<footer class="entry-footer">
		<div class="row">
			<div class="col-md-8 offset-md-4 col-lg-9 offset-lg-3">
				<?php echo embark_posted_footer(); ?>
			</div><!-- col-lg-9 -->
			
		</div>
	</footer>
</div><!-- aside-container -->
</article>
