<?php if ($widgets): ?> 
<div class="row" style="margin-bottom:20px;">
<?php foreach ($widgets as $widget): ?>
	<div class="col-sm-<?= $class; ?>">
		<?= $widget; ?>
	</div>
<?php endforeach; ?>
</div>
<?php endif; ?>