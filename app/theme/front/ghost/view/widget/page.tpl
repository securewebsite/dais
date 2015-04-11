<div class="list-group">
	<div class="list-group-item list-group-heading"><?= $lang_heading_title; ?></div>
	<?php foreach ($pages as $page) { ?>
		<a class="list-group-item" href="<?= $page['href']; ?>"><?= $page['title']; ?></a>
	<?php } ?>
	<a class="list-group-item" href="<?= $contact; ?>"><?= $lang_text_contact; ?></a>
	<a class="list-group-item" href="<?= $sitemap; ?>"><?= $lang_text_sitemap; ?></a>
</div>
