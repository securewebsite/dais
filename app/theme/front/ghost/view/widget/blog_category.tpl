<div class="list-group">
	<div class="list-group-item list-group-heading"><?= $lang_heading_title; ?></div>
	<?php foreach ($blog_categories as $blog_category): ?>
		<a class="list-group-item<?= ($blog_category['category_id'] == $blog_category_id) ? ' active' : ''; ?>" href="<?= $blog_category['href']; ?>"><?= $blog_category['name']; ?>
			<span class="pull-right"><i class="fa fa-bars"></i></span></a>
		<?php if ($blog_category['category_id'] == $blog_category_id): ?>
			<?php foreach ($blog_category['children'] as $child): ?>
				<?php if ($child['category_id'] == $child_id): ?>
					<a class="list-group-item list-group-subitem active" href="<?= $child['href']; ?>"><?= $child['name']; ?></a>
				<?php else: ?>
					<a class="list-group-item list-group-subitem" href="<?= $child['href']; ?>"><?= $child['name']; ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
