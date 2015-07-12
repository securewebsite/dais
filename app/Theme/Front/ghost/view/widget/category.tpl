<div class="list-group">
	<div class="list-group-item list-group-heading"><?= $lang_heading_title; ?></div>
	<?php foreach ($categories as $category): ?>
		<a class="list-group-item<?= ($category['category_id'] == $category_id) ? ' active' : ''; ?>" href="<?= $category['href']; ?>">
			<?= $category['name']; ?><span class="pull-right"><i class="fa fa-bars"></i></span>
		</a>
		<?php if ($category['category_id'] == $category_id): ?>
			<?php foreach ($category['children'] as $child): ?>
				<?php if ($child['category_id'] == $child_id): ?>
					<a class="list-group-item list-group-subitem active" href="<?= $child['href']; ?>"><?= $child['name']; ?></a>
				<?php else: ?>
					<a class="list-group-item list-group-subitem" href="<?= $child['href']; ?>"><?= $child['name']; ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
