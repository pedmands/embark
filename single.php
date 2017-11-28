<?php 
/*
@package embark

Single Post

*/
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site" role="main">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-10 col-md-10 col-lg-8 offset-sm-1 offset-md-1 offset-lg-2">
					<?php 
					if (have_posts()):
						while(have_posts()) : the_post();
							// Save posts views
							embark_save_post_views(get_the_ID());
							
							get_template_part('template-parts/single', get_post_format());
							echo embark_post_navigation();
							if(comments_open()){
								comments_template();
							}
						endwhile;
					endif;
					?>
				</div><!-- col-lg-8 -->
			</div> <!-- .row -->
		</div> <!-- .container -->

		

	</main>
</div><!-- #primary -->


<?php get_footer(); ?>
