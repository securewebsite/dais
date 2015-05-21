<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?= $title; ?></title>
<style>
body{color:#000;font-family:Arial,Helvetica,sans-serif}
body,td,th,input,textarea,select,a{font-size:12px}
p{margin-top:0;margin-bottom:20px}
a,a:visited,a b{color:#378DC1;text-decoration:underline;cursor:pointer}
a:hover{text-decoration:none}
a img{border:none}
#container{width:680px}
</style>
</head>
<body>
<div id="container">
	<div style="float:right;margin-left:20px;"><a href="<?= $store_url; ?>" title="<?= $store_name; ?>"><img src="<?= $image; ?>" alt="<?= $store_name; ?>"></a></div>
	<div>
		<p><?= $lang_text_greeting; ?></p>
		<p><?= $lang_text_from; ?></p>
		<?php if ($message) { ?>
		<p><?= $lang_text_message; ?></p>
		<p><?= $message; ?></p>
		<?php } ?>
		<p><?= $lang_text_redeem; ?></p>
		<p><a href="<?= $store_url; ?>" title="<?= $store_name; ?>"><?= $store_url; ?></a></p>
		<p><?= $lang_text_footer; ?></p>
	</div>
</div>
</body>
</html>
