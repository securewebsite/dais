<!doctype html>
<html dir="<?= $direction; ?>" lang="<?= $lang; ?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?= $title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<base href="<?= $base; ?>">
<?php if ($description): ?>
<meta name="description" content="<?= $description; ?>">
<?php endif; ?>
<?php if ($keywords): ?>
<meta name="keywords" content="<?= $keywords; ?>">
<?php endif; ?>
<?php if ($icon): ?>
<link rel="shortcut icon" href="<?= $icon; ?>">
<?php endif; ?>
<?php foreach ($links as $link): ?>
<link href="<?= $link['href']; ?>" rel="<?= $link['rel']; ?>">
<?php endforeach; ?>
<link rel="stylesheet" href="<?= $css_link; ?>">
</head>
<body itemscope itemtype="http://schema.org/Product">
<div class="page-wrapper">
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-top">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?= $home; ?>"><?= $name; ?></a>
			</div>
			<div class="collapse navbar-collapse" id="nav-top">
				<ul class="nav navbar-nav">
					<li id="<?= $text_nav; ?>"><a href="<?= $alternate; ?>"><?= $text_alternate; ?></a></li>
					<li id="nav-wishlist"><a href="<?= $wishlist; ?>" id="wishlist-total"><?= $text_wishlist; ?></a></li>
					<li id="nav-account"><a href="<?= $account; ?>"><?= $lang_text_account; ?></a></li>
					<li id="nav-cart"><a href="<?= $shopping_cart; ?>"><?= $lang_text_shopping_cart; ?></a></li>
					<li id="nav-checkout"><a href="<?= $checkout; ?>"><?= $lang_text_checkout; ?></a></li>
				</ul>
				<form id="search-navbar" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="search" name="search" value="<?= $search; ?>" class="form-control search" placeholder="<?= $lang_text_search; ?>">
					</div>
					<button type="submit" form="search-navbar" class="btn btn-sm">
						<i class="fa fa-search"></i> <?= $lang_text_search; ?>
					</button>
				</form>
			</div>
		</div>
	</div>
	<div class="top-spacer"></div>
	<div class="container app">
		<div class="row">
			<div class="row-table">
				<div class="col-xs-12 col-sm-6 spacer">
				<?php if ($logo): ?>
					<h1 class="logo">
						<a href="<?= $home; ?>">
							<img src="<?= $logo; ?>" class="img-responsive" title="<?= $name; ?>" alt="<?= $name; ?>">
						</a>
					</h1>
				<?php else: ?>
					<h1 class="logo"><a href="<?= $home; ?>"><?= $name; ?></a></h1>
				<?php endif; ?>
				</div>
				<div class="col-xs-12 col-sm-6 col-td spacer">
					<div class="clearfix">
						<div class="btn-toolbar pull-right">
							<?= $currency; ?>
							<?= $language; ?>
							<?= $cart; ?>
						</div>
					</div>
					<div class="clearfix text-right">
						<p><?= ($logged) ? $text_logged : $text_welcome; ?></p>
					</div>
				</div>
			</div>
		</div>
		<?= $menu; ?>