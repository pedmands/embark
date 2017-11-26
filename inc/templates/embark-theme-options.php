<h1>Embark Theme Options</h1>
<?php settings_errors(); ?>
<?php 
	// $picture = esc_attr(get_option('profile_picture'));
?>

<form method="post" action="options.php" class="embark-general-form">
	<?php 
		settings_fields('embark-theme-options');
		do_settings_sections('embark_theme_options');
		submit_button();
	?>
</form>
