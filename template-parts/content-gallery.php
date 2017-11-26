<?php 
/*
@package embark

Gallery Post Format

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('embark-format-gallery'); ?>>
	<header class="entry-header text-center">

		<?php if(embark_get_attachment()):
		?>
			<div id="post-gallery-<?php the_ID(); ?>" class="carousel slide embark-carousel-thumb" data-interval="3500" data-ride="carousel">

				<div class="carousel-inner" role="listbox">
					<?php
						$attachments = embark_get_bs_slides(embark_get_attachment(7));
						foreach($attachments as $attachment):
						?>
							<div class="carousel-item <?= $attachment['class'] ?> background-image" style="background-image:url(<?= $attachment['url'] ?>); height:500px">
								
								<div class="hide next-image-preview" data-image="<?= $attachment['next_img'] ?>"></div>
								<div class="hide previous-image-preview" data-image="<?= $attachment['prev_img'] ?>"></div>

							<?php if (!empty($attachment['caption'])): ?>
								<div class="entry-excerpt image-caption">
								<p><?php echo $attachment['caption'];?></p>
								</div>
							<?php endif; ?>
						</div><!-- carousel-item -->
					<?php endforeach;?>
				</div><!-- carousel-inner -->
					
					<a class="carousel-control-prev carousel-control" href="#post-gallery-<?php the_ID(); ?>" role="button" data-slide="prev">
						<div class="preview-container">
							<span class="thumbnail-container background-image"></span>
						    <span class="embark-icon embarkchevron-left" aria-hidden="true"></span>
						    <span class="sr-only">Previous</span>
					    </div><!-- preview-container -->
					</a>
					
				
				  <a class="carousel-control-next carousel-control" href="#post-gallery-<?php the_ID(); ?>" role="button" data-slide="next">
				  	<div class="preview-container">
				  		<span class="thumbnail-container background-image"></span>
					    <span class="embark-icon embarkchevron-right" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					</div>
				  </a>

			</div><!-- .carousel slide -->
		<?php endif; ?>


		<?php the_title('<h1 class="entry-title"><a href="'.esc_url( get_permalink()).'" rel="bookmark">','</a></h1>'); ?>
		<div class="entry-meta">
			<?php echo embark_posted_meta(); ?>
		</div>
	</header>
	<div class="entry-content">
		
	<div class="entry-excerpt">
		<?php the_excerpt(); ?>
	</div>
	<div class="button-container text-center">
		<a href="<?php the_permalink(); ?>" class="btn btn-embark"><?php _e('Read More'); ?></a>
	</div>
	</div><!-- entry-content -->
	<footer class="entry-footer">
		
		<?php echo embark_posted_footer(); ?>
	</footer>
</article>
