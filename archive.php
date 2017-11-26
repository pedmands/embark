<?php 
/*
@package embark

*/
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site" role="main">

		<header class="archive-header text-center">
				<?php the_archive_title('<h1 class="page-title">', '</h1>'); ?>
		</header>

		<?php if(is_paged()) : ?>
			<div class="container text-center container-load-previous archive-load-previous">
				<a class="btn-embark-load embark-load-more" data-prev="1" data-page="<?php echo embark_check_paged(1); ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>" data-archive="<?php echo embark_grab_current_uri(); ?>">
					<span class="embark-icon embarkloading"></span> 
					<span class="text">Load Previous</span>
				</a>
			</div><!-- .container -->
		<?php endif; ?>

		<div class="container embark-posts-container">
			<?php 
			if (have_posts()):
		
				echo '<div class="page-limit" data-page="'. $_SERVER["REQUEST_URI"] .'">';
				while(have_posts()) : the_post();

					get_template_part('template-parts/content', get_post_format());
				endwhile;

				echo '</div>';
				
			endif;
			?>
		</div><!-- .container .embark-posts-container -->

		<div class="container text-center">
			<a class="btn-embark-load embark-load-more" data-page="<?php echo embark_check_paged(1); ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>" data-archive="<?php echo embark_grab_current_uri(); ?>">
				<span class="embark-icon embarkloading"></span> 
				<span class="text">Load More</span>
			</a>
		</div><!-- .container -->

	</main>
</div><!-- #primary -->


<?php get_footer(); ?>
