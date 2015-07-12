<div class="list-group">
	<div class="list-group-item list-group-heading"><?= $lang_heading_title; ?></div>
	<?php foreach ($pages as $page) { ?>
		<a class="list-group-item" href="<?= $page['href']; ?>"><?= $page['title']; ?></a>
	<?php } ?>
	<a class="list-group-item" href="<?= $contact; ?>"><?= $lang_text_contact; ?></a>
	<a class="list-group-item" href="<?= $site_map; ?>"><?= $lang_text_site_map; ?></a>
</div>
