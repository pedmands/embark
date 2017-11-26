jQuery(document).ready(function($){
/*	@package embark
	Gallery Post Type Functions
*/

	/* 
		===== INIT  FUNCTIONS =====
	*/

	// Reveal posts all nice and animate-y:
	revealPosts();

	// variables
	var last_scroll = 0;

	/* 
		===== CAROUSEL  FUNCTIONS =====
	*/

	$(document).on('click', '.embark-carousel-thumb', function(){
		var id = $('#' + $(this).attr("id"));
		console.log(id);
		$(id).on('slid.bs.carousel', function(){
			embark_get_bs_thumbs(id);
		});
	}); // Load thumbs on click 

	$(document).on('mouseenter', '.embark-carousel-thumb', function(){
		var id = $('#' + $(this).attr("id"));
		embark_get_bs_thumbs(id);
	});// Load thumbs on mouse enter

	// Load the thumbnails for  carousel prev and next images
	function embark_get_bs_thumbs(id){
		// Retrieve the image data from the HTML5 element:
		var nextThumb = $(id).find('.carousel-item.active').find('.next-image-preview').data('image');
		var prevThumb = $(id).find('.carousel-item.active').find('.previous-image-preview').data('image');

		// Add the image data to the elements background:
		$(id).find('.carousel-control-next.carousel-control').find('.thumbnail-container').css({'background-image' : 'url('+nextThumb+')'});
		$(id).find('.carousel-control-prev.carousel-control').find('.thumbnail-container').css({'background-image' : 'url('+prevThumb+')'});
	}// embark_get_bs_thumbs()

	/* 
		===== AJAX  FUNCTIONS =====
	*/

	// Loading Functions
	$(document).on('click','.embark-load-more:not(.loading)', function(){
		var that = $(this);
		var page = that.data('page');
		var newPage = page+1;
		var ajaxurl = that.data('url');
		var prev = that.data('prev');
		var archive = that.data('archive');

		if(typeof prev === 'undefined'){
			prev = 0;
		}

		if(typeof archive === 'undefined'){
			archive = 0;
		}

		that.addClass('loading').find('.text').slideUp(320);
		that.find('.embark-icon').addClass('spin');

		$.ajax({
			url : ajaxurl,
			type : 'post',
			data : {
				page : page,
				prev : prev,
				archive : archive,
				action : 'embark_load_more'
			}, 
			error : function(response){
				console.log(response);
			}, 
			success : function(response){
				if(response == 0){
					that.slideUp(320);
					$('.embark-posts-container').append('<div class="text-center"><h3>You\'ve reached the end of the line</h3><p>No more posts to load</p></div>');
				} else {
					setTimeout(function(){
					
					if( prev == 1){
						// Append posts to parent container
						$('.embark-posts-container').prepend(response);
						newPage = page-1;
					} else {
						// Append posts to parent container
						$('.embark-posts-container').append(response);
					}
					if (newPage == 1){
						that.slideUp(320);
					} else {
						that.data('page', newPage);
						// reveal text and stop spinning
						that.removeClass('loading').find('.text').slideDown(320);
						that.find('.embark-icon').removeClass('spin');
					}
					
					revealPosts();
					}, 1000);
				}
			} // success
		});// $.AJAX
	}); // Loading Functions

	/* 
		===== SCROLL  FUNCTIONS =====
	*/

	$(window).scroll(function(){
		var scroll = $(window).scrollTop();

		if(Math.abs(scroll - last_scroll) > $(window).height()*0.1 ){
			last_scroll = scroll;

			$('.page-limit').each(function(index){
				if(isVisible($(this))){
					history.replaceState(null, null, $(this).attr("data-page"));
					return (false);
				}
			});
		}
	});

	/* 
		===== HELPER  FUNCTIONS =====
	*/

	function revealPosts(){

		$('[data-toggle="tooltip"]').tooltip();

		$('[data-toggle="popover"]').popover();
	
		var posts = $('article:not(.reveal)');
		var i = 0;

		setInterval(function(){
			if(i >= posts.length) return false;

			var el = posts[i];
			$(el).addClass('reveal').find('.embark-carousel-thumb').carousel();
			i++
		}, 200);
	} // revealPosts()

	function isVisible(element){
		var scroll_pos = $(window).scrollTop();
		var window_height = $(window).height();
		var el_top = $(element).offset().top;
		var el_height = $(element).height();
		var el_bottom = el_top + el_height;

		return ((el_bottom - el_height*0.25 > scroll_pos ) && (el_top < (scroll_pos+0.5*window_height)));
	} // isVisible()

});
