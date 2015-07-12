<?php if ($menu_blocks): ?>
<?php foreach ($menu_blocks as $item => $menu): ?>
<div class="col-sm-<?= $menu['class']; ?>">
	<h5 class="media-heading"><strong><?= $menu['menu_name']; ?></strong></h5>
	<ul class="list-unstyled">
		<?php if (isset($menu['menu_items'])): ?>
		<?php foreach($menu['menu_items'] as $item): ?>
		<?php if (isset($item['external'])): ?>
		<li><?= $item['external']; ?></li>
		<?php else: ?>
		<li><a href="<?= $item['href']; ?>"><?= $item['name']; ?></a></li>
		<?php endif; ?>
		<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>
<?php endforeach; ?>
<?php endif; ?>