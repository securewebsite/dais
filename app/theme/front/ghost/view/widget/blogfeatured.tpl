<div class="list-group widget">
	<div class="list-group-item list-group-heading"><?= $lang_heading_title; ?></div>
	<?php foreach ($posts as $post): ?>
		<a class="list-group-item clearfix" href="<?= $post['href']; ?>">
			<img class="img-responsive" src="<?= $post['thumb']; ?>" title="<?= $post['name']; ?>" alt="<?= $post['name']; ?>"> 
			<span><?= $post['name']; ?></span>
		</a>
	<?php endforeach; ?>
</div>
