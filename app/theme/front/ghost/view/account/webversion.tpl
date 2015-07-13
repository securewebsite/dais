<?php if ($webversion): ?>
	<?= $webversion; ?>
<?php else: ?>
	<center><h2><?= $lang_not_available; ?></h2></center>
<?php endif; ?>