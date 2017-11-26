<nav class="comment-navigation" role="navigation">
	<div class="row">
		<div class="col-12 col-sm-6">
			<div class="post-link-nav">
				<span class="embark-icon embarkchevron-left" aria-hidden="true"></span> 
				<?php previous_comments_link(esc_html__('Older Comments', 'embark')); ?>
			</div>
		</div>
		<div class="col-12 col-sm-6 text-right">
			<div class="post-link-nav">
				<?php next_comments_link(esc_html__('Newer Comments', 'embark')); ?>
				<span class="embark-icon embarkchevron-right" aria-hidden="true"></span>
			</div>
		</div>
	</div><!-- .row -->
</nav>
