<?php if ($breadcrumbs): ?>
<div class="breadcrumb">
<?php foreach ($breadcrumbs as $breadcrumb): ?>
	<?= $breadcrumb['separator']; ?><a href="<?= $breadcrumb['href']; ?>"><?= $breadcrumb['text']; ?></a>
<?php endforeach; ?>
</div>
<?php endif; ?>