
<?php if ($menu_blocks): ?>
<?php foreach($menu_blocks as $item => $menu): ?>
<div class="list-group">
	<div class="list-group-item list-group-heading"><?= $menu['menu_name']; ?></div>
	<?php if(isset($menu['menu_items'])): ?>
	<?php foreach($menu['menu_items'] as $item): ?>
		<?php if (isset($item['external'])): ?>
		<?= $item['external']; ?>
		<?php else: ?>
		<a class="list-group-item<?= (isset($menu['menu_item_id']) && (isset($item['id'])) && ($item['id'] === $menu['menu_item_id'])) ? ' active' : ''; ?>" href="<?= $item['href']; ?>">
			<?= $item['name']; ?>
			<span class="pull-right"><i class="fa fa-bars"></i></span></a>
		<?php endif; ?>
		<?php if (isset($item['children'])): ?>
		<?php if (isset($menu['menu_item_id']) && ($item['id'] === $menu['menu_item_id'])): ?>
		<?php foreach($item['children'] as $item): ?>
			<?php if (isset($menu['menu_child_id']) && ($child['id'] === $menu['menu_child_id'])): ?>
				<a class="list-group-item list-group-subitem active" href="<?= $child['href']; ?>"><?= $child['name']; ?></a>
			<?php else: ?>
				<a class="list-group-item list-group-subitem" href="<?= $child['href']; ?>"><?= $child['name']; ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php endif; ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
