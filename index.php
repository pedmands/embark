<?php 
/*
@package embark

*/
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site" role="main">

		<?php if(is_paged()) : ?>
			<div class="container text-center container-load-previous">
				<a class="btn-embark-load embark-load-more" data-prev="1" data-page="<?php echo embark_check_paged(1); ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
					<span class="embark-icon embarkloading"></span> 
					<span class="text">Load Previous</span>
				</a>
			</div><!-- .container -->
		<?php endif; ?>

		<div class="container embark-posts-container">
			<?php 
			if (have_posts()):
				echo '<div class="page-limit" data-page="/'.embark_check_paged().'">';
				while(have_posts()) : the_post();
					// Reveal posts without using JS (less animated) !You MUST use get_query_var in each content template with this option!
					// $class = 'reveal';
					// set_query_var( 'post-class', $class );

					get_template_part('template-parts/content', get_post_format());
				endwhile;

				echo '</div>';
				
			endif;
			?>
		</div><!-- .container .embark-posts-container -->

		<div class="container text-center">
			<a class="btn-embark-load embark-load-more" data-page="<?php echo embark_check_paged(1); ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
				<span class="embark-icon embarkloading"></span> 
				<span class="text">Load More</span>
			</a>
		</div><!-- .container -->

	</main>
</div><!-- #primary -->


<?php get_footer(); ?>
