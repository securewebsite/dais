<?php if ($widgets): ?>
<hr>
<div class="row">
<?php foreach($widgets as $widget): ?>
	<div class="col-sm-<?= $class; ?>">
		<?= $widget; ?>
	</div>
<?php endforeach; ?>
</div>
<?php endif; ?>