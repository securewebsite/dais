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
<link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsRAAALEQF/ZF+RAAAAB3RJTUUH1QkaCxgledlRSQAABAxJREFUOMullX9MlHUcx1/PcQIp4KGWcoSIzWlWwgmjDe4WhbgWCs5labKmFstq/eFYCxnu25PEUf/QBuTI1ppjLcwtc9omsWkt2JQfZzupQyV2uziQHpEuQLg7nqc/5Lkd50Ftfbdnez7Pvs9r7+/n834/j0TEEkII4P258j2gV5bldv7vEkJoo7dHtJmZac3l+k0TQmgVFRXFgPQvr0qAQS8MUTaYmz49gaaqpJrN7Nu3l4SEhPOAthA8p7wl5YMT59Sc8pZTkWBJCJEFIMvyMGC2133EzPQ9MjIyIlVFQrMA77HDOzEvZ01OeUu7Dpaqq6tlwCGEOK7DrVYrkvTAgdQogh1dn+2np6eHg/nLCi3p8YUARmBJTEzMsTcPl2OIiX0XqN6yZQubNm1E01QkScI/M3lFCJEly/K1KGoZGBjA4/Hw4feTAObQ0Zqbm52lJTufXLr0IQJ+P5qmoWlaCJBkSqa21g5gnmuVDnV0Nr1E3tun9a2W7pNl10JgIURKfHz8r89vLzQ9/sRTSJIUmpVv/O59+HITtfY6APMF74bVgONq8yvB3De+MgJF3SfL2qMOQwiRlZ6e/rnb7c7Wn+Xm5ga2bStc8vdf42iaxrLEJFpbW2nqjOXnhhexvnNmnspwrrSIn1MAG9BaVXWUsTsK12/+wcdn3Xx7vJiCI2cXhAKa9B8CkwU41lqKOXHhBt9U5VP1RTclmwO4XP2WsIHq/Yvuy3DTK0Mer16vSk3jcv0uDtS1scsSz8slRdTU1OgDHQVmFzV8OHTP9o1kbl6PoozxScsVVqWmUbEjBbPJyPqMdaQ+moYsywCWSCsaFoO+WmpFnVBINJkotCShDHlw9f6EzWYjPi6WO3/e5v43C4ee3KhgHfr67kwO7X6Gtos/8GNPPxiMzAaDIa/KsszKh1cjSdKCcEMk9OhrVvYX53H6u3a6+gbJs9lwuW4R8E8D4PP5FL/fny3LMitWPQIQgsfFxYXgBj1FypDHK7/1LHu2Z3PqzEUGPV6KiktwuW7hdd+ko1/FGBzdUF9ff9dut98YGRmx6spn/H4OHjxAZWUlgCMEVoY8jiNlT1NakEnrucsMerzYniucBw2M9lqmFHcSsAJY6XQ6A06ns1iWZcypaTQ2NuLz+UKdMOp36evSmFU1RocGH4BO/N5WoLguBeaEJAOGzs7OIDA8MTGxt6Gh4euxsTFUVb0aCATsoeSte8Gu7cg3Y8m28FiKiV/6bnG1q4uOfpUp96X80b42JWImaphVZ4EZYBKYBoLArBFgxZqUrec7vL16g+5NTdDRrxJnmCxQk1PHASXM9zpQ/6Ooc/CgDp0X6a2HvrSMjQz36nVCYuza660VI+ExDYNKUWKszl0aoP0DjPbe8WKg6ioAAAAASUVORK5CYII=">
</head>
<body>
<?php if ($logged) { ?>
<?= $menu; ?>
<?php } ?>
<div id="content" class="container-fluid">
	<div id="notification"></div>

