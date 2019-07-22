<?php
 ?>

<?php wp_nonce_field(DroneFunc::stringID($group->name), DroneFunc::stringID($group->name.'_wpnonce', '_')); ?>

<table class="widefat fixed post-options<?php if (empty($group->description)) echo ' no-border'; ?>">
	<tbody>
		<?php $group->html()->ehtml(); ?>
	</tbody>
</table>

<?php if (!empty($group->description)): ?>
	<p class="description"><?php echo $group->description; ?></p>
<?php endif; ?>