<!DOCTYPE html>
<html dir="<?= $direction; ?>" lang="<?= $lang; ?>">
<head>
<meta charset="UTF-8">
<title><?= $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<base href="<?= $base; ?>">
<link href="<?= $css_link; ?>" rel="stylesheet">
<?php foreach ($links as $link) { ?>
<link href="<?= $link['href']; ?>" rel="<?= $link['rel']; ?>">
<?php } ?>
<script>
var text_confirm='<?= $lang_text_confirm; ?>';
</script>
<link rel="shortcut icon" href="../asset/bs3/img/setting.png">
</head>
<body>
<?php if ($logged) { ?>
<?= $menu; ?>
<?php } ?>
<div id="content" class="container-fluid">
	<div id="notification"></div>