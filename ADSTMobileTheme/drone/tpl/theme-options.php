<?php
 ?>

<div class="wrap">

	<?php screen_icon('themes'); ?>
	<h2><?php printf(__('%s Options', $this->name), $this->theme->name); ?></h2>

	<?php
 if (isset($_GET['settings-updated'])) { add_settings_error($this->name, 'settings_updated', __('Settings saved.'), 'updated'); } settings_errors(); ?>

	<form method="post" action="<?php echo self::WP_OPTIONS_URL; ?>">
		<?php settings_fields($this->name); ?>
		<div class="theme-options">
			<ul class="nav"></ul>
			<div class="save">
				<input id="submit" name="submit" type="submit" value="<?php _e('Save Changes'); ?>" class="button-primary" />
			</div>
			<div class="pages"><?php $this->theme_options->html()->ehtml(); ?></div>
		</div>
	</form>

</div>