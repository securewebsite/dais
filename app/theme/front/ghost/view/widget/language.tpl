<?php if (count($languages) > 1) { ?>
<div class="btn-group">
	<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#"><?= $lang_text_language; ?> <span class="caret"></span></a>
	<ul class="dropdown-menu dropdown-menu-right">
		<?php foreach ($languages as $language) { ?>
			<?php if ($language['code'] == $language_code) { ?>
				<li><a><img src="image/flags/<?= $language['image']; ?>" alt="<?= $language['name']; ?>"> <b><?= $language['name']; ?></b></a></li>
			<?php } else { ?>
				<li><a onclick="$('input[name=\'language_code\']').val('<?= $language['code']; ?>');$('#language').submit();"><img src="image/flags/<?= $language['image']; ?>" alt="<?= $language['name']; ?>"> <?= $language['name']; ?></a></li>
			<?php } ?>
		<?php } ?>
	</ul>
	<form class="hide" action="<?= $action; ?>" method="post" enctype="multipart/form-data" id="language">
		<input type="hidden" name="language_code" value="">
		<input type="hidden" name="redirect" value="<?= $redirect; ?>">
	</form>
</div>
<?php } ?>