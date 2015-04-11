<?php if ($breadcrumbs): ?>
<ul class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb): ?>
	<li><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>