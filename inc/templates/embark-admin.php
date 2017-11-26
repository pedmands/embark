<h1>Embark Sidebar Settings</h1>
<?php settings_errors(); ?>
<?php 
	$picture = esc_attr(get_option('profile_picture'));
	$firstName = esc_attr(get_option('first_name'));
 	$lastName = esc_attr(get_option('last_name'));
 	$fullName = $firstName . ' ' . $lastName;
 	$description = esc_attr(get_option('user_description'));
?>
<div class="embark-sidebar-preview">
	<div class="embark-sidebar">
		<div class="image-container">
			<div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?= $picture; ?>);">
			</div>
		</div>
		<h1 class="embark-username"><?= $fullName; ?></h1>
		<h2 class="embark-description"><?= $description; ?></h2>
		<div class="icons-wrapper">
			
		</div>
	</div>
</div>
<form method="post" action="options.php" class="embark-general-form">
	<?php 
		settings_fields('embark-settings-group');
		do_settings_sections('embark_options');
		submit_button('Save Changes', 'primary','btnSubmit');
	?>
</form>
