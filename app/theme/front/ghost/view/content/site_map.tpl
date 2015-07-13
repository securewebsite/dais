<?= $header; ?>
<?= $post_header; ?>
<div class="row">
	<?= $column_left; ?>
	<div class="col-sm-<?php $span = trim($column_left) ? 9 : 12; $span = trim($column_right) ? $span - 3 : $span; echo $span; ?>">
		<?= $breadcrumb; ?>
		<?= $content_top; ?>
		<div class="page-header"><h1><?= $lang_heading_title; ?></h1></div>
		<div class="row">
			<?php $span = floor($span / 2); ?>
			<div class="col-sm-<?= $span; ?>">
				<ul>
					<?php foreach ($categories as $category_1) { ?>
					<li><a href="<?= $category_1['href']; ?>"><?= $category_1['name']; ?></a>
					<?php if ($category_1['children']) { ?>
					<ul>
						<?php foreach ($category_1['children'] as $category_2) { ?>
						<li><a href="<?= $category_2['href']; ?>"><?= $category_2['name']; ?></a>
							<?php if ($category_2['children']) { ?>
							<ul>
							<?php foreach ($category_2['children'] as $category_3) { ?>
							<li><a href="<?= $category_3['href']; ?>"><?= $category_3['name']; ?></a></li>
							<?php } ?>
							</ul>
							<?php } ?>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-sm-<?= $span; ?>">
				<ul>
					<li><a href="<?= $special; ?>"><?= $lang_text_special; ?></a></li>
					<li><a href="<?= $account; ?>"><?= $lang_text_account; ?></a>
						<ul>
							<li><a href="<?= $edit; ?>"><?= $lang_text_edit; ?></a></li>
							<li><a href="<?= $password; ?>"><?= $lang_text_password; ?></a></li>
							<li><a href="<?= $address; ?>"><?= $lang_text_address; ?></a></li>
							<li><a href="<?= $history; ?>"><?= $lang_text_history; ?></a></li>
							<li><a href="<?= $download; ?>"><?= $lang_text_download; ?></a></li>
						</ul>
					</li>
					<li><a href="<?= $cart; ?>"><?= $lang_text_cart; ?></a></li>
					<li><a href="<?= $checkout; ?>"><?= $lang_text_checkout; ?></a></li>
					<li><a href="<?= $search; ?>"><?= $lang_text_search; ?></a></li>
					<li><?= $lang_text_page; ?>
						<ul>
							<?php foreach ($pages as $page) { ?>
							<li><a href="<?= $page['href']; ?>"><?= $page['title']; ?></a></li>
							<?php } ?>
							<li><a href="<?= $contact; ?>"><?= $lang_text_contact; ?></a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<?= $content_bottom; ?>
	</div>
	<?= $column_right; ?>
</div>
<?= $pre_footer; ?>
<?= $footer; ?>