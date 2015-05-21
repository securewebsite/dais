<?php if ($menu_items): ?>
	<div id="menu" class="navbar navbar-menu">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-menu-items">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="nav-menu-items">
			<ul class="nav navbar-nav">
				<?php $mid = floor(count($menu_items)/2); ?>
				<?php foreach ($menu_items as $z => $menu_item): ?>
					<?php if (!empty($menu_item['children'])): ?>
					<li class="dropdown dropdown-columns">
						<a href="<?= $menu_item['href']; ?>" data-toggle="dropdown" class="dropdown-toggle">
							<?= $menu_item['name']; ?> <b class="caret"></b>
						</a>
						<ul style="min-width:<?= (180 * $menu_item['column']); ?>px;" class="dropdown-menu slim-row<?= ($z > $mid) ? ' dropdown-menu-right' : ''; ?>">
						<?php foreach (array_chunk($menu_item['children'], ceil(count($menu_item['children']) / $menu_item['column'])) as $children): ?>
							<li class="slim-col-sm-<?= (12 / $menu_item['column']); ?>">
								<ul class="nav">
									<?php foreach ($children as $child): ?>
										<li><a href="<?= $child['href']; ?>"><?= $child['name']; ?></a></li>
									<?php endforeach; ?>
								</ul>
							</li>
						<?php endforeach; ?>
							<li role="presentation" class="slim-col-sm-12 divider"></li>
							<li class="slim-col-sm-12"><a href="<?= $menu_item['href']; ?>" class="see-all"><?= $menu_item['name']; ?></a></li>
						</ul>
					</li>
					<?php else: ?>
					<li><a href="<?= $menu_item['href']; ?>"><?= $menu_item['name']; ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif; ?>