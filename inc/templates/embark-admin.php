<h1>Embark Sidebar Settings</h1>
<?php settings_errors(); ?>
<?php 
	$picture = esc_attr(get_option('profile_picture'));
	$firstName = esc_attr(get_option('first_name'));
 	$lastName = esc_attr(get_option('last_name'));
 	$fullName = $firstName . ' ' . $lastName;
 	$description = esc_attr(get_option('user_description'));

 	$twitter_icon = esc_attr( get_option( 'twitter_handle' ) );
	$facebook_icon = esc_attr( get_option( 'facebook_handle' ) );
	$gplus_icon = esc_attr( get_option( 'gplus_handle' ) );
?>
<div class="embark-sidebar-preview">
	<div class="embark-sidebar">
		<div class="image-container">
			<div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?= $picture; ?>);">
			</div>
		</div><!-- .image-container -->
		<h1 class="embark-username"><?= $fullName; ?></h1>
		<h2 class="embark-description"><?= $description; ?></h2>
		<div class="icons-wrapper">
			<?php if( !empty( $twitter_icon ) ): ?>
				<span class="embark-social-icon embark-sidebar-icon embark-social-twitter"></span>
			<?php endif; 
			if( !empty( $gplus_icon ) ): ?>
				<span class="embark-social-icon embark-sidebar-icon embark-social-google"></span>
			<?php endif; 
			if( !empty( $facebook_icon ) ): ?>
				<span class="embark-social-icon embark-sidebar-icon embark-social-facebook"></span>
			<?php endif; ?>
		</div>
	</div><!-- embark-sidebar -->
</div>
<form method="post" action="options.php" class="embark-general-form">
	<?php 
		settings_fields('embark-settings-group');
		do_settings_sections('embark_options');
		submit_button('Save Changes', 'primary','btnSubmit');
	?>
</form>
