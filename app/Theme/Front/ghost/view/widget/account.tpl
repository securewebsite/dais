<div class="list-group">
	<div class="list-group-item list-group-heading"><?= $lang_heading_title; ?></div>
<?php if ($logged): ?>
	<a class="list-group-item" href="<?= $account; ?>"><?= $lang_text_account; ?></a>
	<a class="list-group-item" href="<?= $notification; ?>">
		<?= $lang_text_notification; ?>
		<?php if ($unread): ?>
			<span id="notify-badge" class="badge badge-danger"><?= $unread; ?></span>
		<?php endif; ?>
	</a>
	<?php if ($product): ?>
	<a class="list-group-item" href="<?= $product; ?>"><?= $lang_text_product; ?></a>
	<?php endif; ?>
	<?php if ($reward): ?>
	<a class="list-group-item" href="<?= $reward; ?>"><?= $lang_text_reward; ?></a>
	<?php endif; ?>
	<?php if ($download): ?>
	<a class="list-group-item" href="<?= $download; ?>"><?= $lang_text_download; ?></a>
	<?php endif; ?>
	<a class="list-group-item" href="<?= $wishlist; ?>"><?= $lang_text_wishlist; ?></a>
	<a class="list-group-item" href="<?= $order; ?>"><?= $lang_text_order; ?></a>
	<a class="list-group-item" href="<?= $return; ?>"><?= $lang_text_return; ?></a>
	<a class="list-group-item" href="<?= $recurring; ?>"><?= $lang_text_recurring; ?></a>
	<a class="list-group-item" href="<?= $credit; ?>"><?= $lang_text_credit; ?></a>
	<a class="list-group-item" href="<?= $edit; ?>"><?= $lang_text_edit; ?></a>
	<?php if ($affiliate): ?>
	<a class="list-group-item" href="<?= $affiliate; ?>"><?= $lang_text_affiliate; ?></a>
	<?php endif; ?>
	<a class="list-group-item" href="<?= $password; ?>"><?= $lang_text_password; ?></a>
	<a class="list-group-item" href="<?= $address; ?>"><?= $lang_text_address; ?></a>
	<a class="list-group-item" href="<?= $newsletter; ?>"><?= $lang_text_newsletter; ?></a>
	<a class="list-group-item" href="<?= $logout; ?>"><?= $lang_text_logout; ?></a>
<?php else: ?>
	<a class="list-group-item" href="<?= $login; ?>"><?= $lang_text_login; ?></a>
	<a class="list-group-item" href="<?= $register; ?>"><?= $lang_text_register; ?></a>
	<a class="list-group-item" href="<?= $forgotten; ?>"><?= $lang_text_forgotten; ?></a>
<?php endif; ?>
</div>