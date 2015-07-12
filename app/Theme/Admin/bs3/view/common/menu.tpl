<?php if ($logged): ?>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= $dashboard; ?>"><?= $lang_text_dashboard; ?></a>
		</div>
		<div class="collapse navbar-collapse" id="menu">
			<ul class="nav navbar-nav">
				<li class="dropdown" id="catalog"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_catalog; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?= $category; ?>"><?= $lang_text_category; ?></a></li>
						<li><a href="<?= $manufacturer; ?>"><?= $lang_text_manufacturer; ?></a></li>
						<li><a href="<?= $product; ?>"><?= $lang_text_product; ?></a></li>
						<li><a href="<?= $recurring; ?>"><?= $lang_text_recurring; ?></a></li>
						<li><a href="<?= $filter; ?>"><?= $lang_text_filter; ?></a></li>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_attribute; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $attribute; ?>"><?= $lang_text_attribute; ?></a></li>
								<li><a href="<?= $attribute_group; ?>"><?= $lang_text_attribute_group; ?></a></li>
							</ul>
						</li>
						<li><a href="<?= $option; ?>"><?= $lang_text_option; ?></a></li>
						
						<li><a href="<?= $download; ?>"><?= $lang_text_download; ?></a></li>
						<li><a href="<?= $review; ?>"><?= $lang_text_review; ?></a></li>
					</ul>
				</li>
				<li class="dropdown" id="content"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_content; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="dropdown-header"><?= $lang_text_page; ?></li>
						<li><a href="<?= $page; ?>"><?= $lang_text_page; ?></a></li>
						<div class="divider"></div>
						<li class="dropdown-header"><?= $lang_text_calendar; ?></li>
						<li><a href="<?= $event; ?>"><?= $lang_text_event; ?></a></li>
						<li><a href="<?= $presenter; ?>"><?= $lang_text_presenter; ?></a></li>
						<div class="divider"></div>
						<li class="dropdown-header"><?= $lang_text_blog; ?></li>
						<li><a href="<?= $blog_category; ?>"><?= $lang_text_blog_cats; ?></a></li>
						<li><a href="<?= $blog_post; ?>"><?= $lang_text_blog_post; ?></a></li>
						<li><a href="<?= $blog_comment; ?>"><?= $lang_text_blog_comm; ?></a></li>
					</ul>
				</li>
				<li class="dropdown" id="module"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_module; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="dropdown-header"><?= $lang_text_core_mods; ?></li>
						<li><a href="<?= $menubuilder; ?>"><?= $lang_text_menubuilder; ?></a></li>
						<li><a href="<?= $notification; ?>"><?= $lang_text_notification; ?></a></li>
						<li><a href="<?= $share; ?>"><?= $lang_text_share; ?></a></li>
						<div class="divider"></div>
						<li class="dropdown-header"><?= $lang_text_core_cart; ?></li>
						<li><a href="<?= $shipping; ?>"><?= $lang_text_shipping; ?></a></li>
						<li><a href="<?= $payment; ?>"><?= $lang_text_payment; ?></a></li>
						<li><a href="<?= $total; ?>"><?= $lang_text_total; ?></a></li>
						<li><a href="<?= $feed; ?>"><?= $lang_text_feed; ?></a></li>
					</ul>
				</li>
				<li class="dropdown" id="plugin"><a href="<?= $plugin; ?>" class="dropdown-toggle"><?= $lang_text_plugin; ?></a></li>
				<li class="dropdown" id="widget"><a href="<?= $widget; ?>" class="dropdown-toggle"><?= $lang_text_widget; ?></a></li>
				<li class="dropdown" id="sale"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_sale; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?= $order; ?>"><?= $lang_text_order; ?></a></li>
						<li><a href="<?= $order_recurring; ?>"><?= $lang_text_order_recurring; ?></a></li>
						<li><a href="<?= $return; ?>"><?= $lang_text_return; ?></a></li>
						<li><a href="<?= $coupon; ?>"><?= $lang_text_coupon; ?></a></li>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_gift_card; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $gift_card; ?>"><?= $lang_text_gift_card; ?></a></li>
								<li><a href="<?= $gift_card_theme; ?>"><?= $lang_text_gift_card_theme; ?></a></li>
							</ul>
						</li>
						<?php if ($paypal_express_status) { ?>
							<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_paypal_manage; ?> <b class="fa fa-caret-right"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?= $paypal_express; ?>"><?= $lang_text_paypal_manage; ?></a></li>
									<li><a href="<?= $paypal_express_search; ?>"><?= $lang_text_paypal_search; ?></a></li>
								</ul>
							</li>
						<?php } ?>
					</ul>
				</li>
				<li class="dropdown" id="people"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_people; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php if ($allowed): ?>
						<li><a href="<?= $affiliate; ?>"><?= $lang_text_affiliate; ?></a></li>
						<?php endif; ?>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_customer; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $customer; ?>"><?= $lang_text_customer; ?></a></li>
								<li><a href="<?= $customer_group; ?>"><?= $lang_text_customer_group; ?></a></li>
								<li><a href="<?= $customer_ban_ip; ?>"><?= $lang_text_customer_ban_ip; ?></a></li>
							</ul>
						</li>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_users; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $user; ?>"><?= $lang_text_user; ?></a></li>
								<li><a href="<?= $user_group; ?>"><?= $lang_text_user_group; ?></a></li>
							</ul>
						</li>
						<div class="divider"></div>
						<li><a href="<?= $contact; ?>"><?= $lang_text_contact; ?></a></li>
					</ul>
				</li>
				<li class="dropdown" id="system"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_system; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="<?= $setting; ?>"><?= $lang_text_setting; ?></a></li>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_design; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $layout; ?>"><?= $lang_text_layout; ?></a></li>
								<li><a href="<?= $route; ?>"><?= $lang_text_route; ?></a></li>
								<li><a href="<?= $banner; ?>"><?= $lang_text_banner; ?></a></li>
							</ul>
						</li>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_locale; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $language; ?>"><?= $lang_text_language; ?></a></li>
								<li><a href="<?= $currency; ?>"><?= $lang_text_currency; ?></a></li>
								<li><a href="<?= $stock_status; ?>"><?= $lang_text_stock_status; ?></a></li>
								<li><a href="<?= $order_status; ?>"><?= $lang_text_order_status; ?></a></li>
								<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_return; ?> <b class="fa fa-caret-right"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?= $return_status; ?>"><?= $lang_text_return_status; ?></a></li>
										<li><a href="<?= $return_action; ?>"><?= $lang_text_return_action; ?></a></li>
										<li><a href="<?= $return_reason; ?>"><?= $lang_text_return_reason; ?></a></li>
									</ul>
								</li>
								<li><a href="<?= $country; ?>"><?= $lang_text_country; ?></a></li>
								<li><a href="<?= $zone; ?>"><?= $lang_text_zone; ?></a></li>
								<li><a href="<?= $geo_zone; ?>"><?= $lang_text_geo_zone; ?></a></li>
								<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_tax; ?> <b class="fa fa-caret-right"></b></a>
									<ul class="dropdown-menu">
										<li><a href="<?= $tax_class; ?>"><?= $lang_text_tax_class; ?></a></li>
										<li><a href="<?= $tax_rate; ?>"><?= $lang_text_tax_rate; ?></a></li>
									</ul>
								</li>
								<li><a href="<?= $length_class; ?>"><?= $lang_text_length_class; ?></a></li>
								<li><a href="<?= $weight_class; ?>"><?= $lang_text_weight_class; ?></a></li>
							</ul>
						</li>
						<li><a href="<?= $error_log; ?>"><?= $lang_text_error_log; ?></a></li>
						<li><a href="<?= $backup; ?>"><?= $lang_text_backup; ?></a></li>
						<li><a href="<?= $testing; ?>"><?= $lang_text_testing; ?></a></li>
					</ul>
				</li>
				<li class="dropdown" id="reports"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_reports; ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_sale; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $report_sale_order; ?>"><?= $lang_text_report_sale_order; ?></a></li>
								<li><a href="<?= $report_sale_tax; ?>"><?= $lang_text_report_sale_tax; ?></a></li>
								<li><a href="<?= $report_sale_shipping; ?>"><?= $lang_text_report_sale_shipping; ?></a></li>
								<li><a href="<?= $report_sale_return; ?>"><?= $lang_text_report_sale_return; ?></a></li>
								<li><a href="<?= $report_sale_coupon; ?>"><?= $lang_text_report_sale_coupon; ?></a></li>
							</ul>
						</li>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_product; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $report_product_viewed; ?>"><?= $lang_text_report_product_viewed; ?></a></li>
								<li><a href="<?= $report_product_purchased; ?>"><?= $lang_text_report_product_purchased; ?></a></li>
							</ul>
						</li>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_customer; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $report_customer_online; ?>"><?= $lang_text_report_customer_online; ?></a></li>
								<li><a href="<?= $report_customer_order; ?>"><?= $lang_text_report_customer_order; ?></a></li>
								<li><a href="<?= $report_customer_reward; ?>"><?= $lang_text_report_customer_reward; ?></a></li>
								<li><a href="<?= $report_customer_credit; ?>"><?= $lang_text_report_customer_credit; ?></a></li>
							</ul>
						</li>
						<?php if ($allowed): ?>
						<li class="dropdown-submenu"><a class="dropdown-toggle" data-toggle="dropdown"><?= $lang_text_affiliate; ?> <b class="fa fa-caret-right"></b></a>
							<ul class="dropdown-menu">
								<li><a href="<?= $report_affiliate_commission; ?>"><?= $lang_text_report_affiliate_commission; ?></a></li>
							</ul>
						</li>
						<?php endif; ?>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown" id="store">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<span class="label label-danger pull-left visible-label"><?= $alerts; ?></span> 
						<i class="fa fa-bell fa-lg visible-label"></i>
						
						<span class="label label-danger pull-right hidden-md hidden-lg"><?= $alerts; ?></span> 
						<span class="hidden-md hidden-lg"><?= $lang_text_alerts; ?></span>
						<b class="caret hidden-md hidden-lg"></b>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown-header visible-md visible-lg"><?= $lang_text_order; ?></li>
						<li>
							<a href="<?= $alert_order_status; ?>" style="display: block; overflow: auto;">
								<?= $lang_text_pending_status; ?> <span class="label label-warning pull-right"><?= $order_status_total; ?></span>
							</a>
						</li>
						<li>
							<a href="<?= $alert_complete_status; ?>">
								<?= $lang_text_complete_status; ?> <span class="label label-success pull-right"><?= $complete_status_total; ?></span>
							</a>
						</li>
						<li>
							<a href="<?= $alert_return; ?>">
								<?= $lang_text_return; ?> <span class="label label-danger pull-right"><?= $return_total; ?></span>
							</a>
						</li>
						<li class="divider visible-md visible-lg"></li>
						<li class="dropdown-header visible-md visible-lg"><?= $lang_text_customer; ?></li>
						<?php if ($online_total): ?>
						<li>
							<a href="<?= $alert_online; ?>">
								<?= $lang_text_online; ?> <span class="label label-success pull-right"><?= $online_total; ?></span>
							</a>
						</li>
						<?php endif; ?>
						<li>
							<a href="<?= $alert_customer_approval; ?>">
								<?= $lang_text_approval; ?> <span class="label label-danger pull-right"><?= $customer_total; ?></span>
							</a>
						</li>
						<li class="divider visible-md visible-lg"></li>
						<li class="dropdown-header visible-md visible-lg"><?= $lang_text_product; ?></li>
						<li>
							<a href="">
								<?= $lang_text_stock; ?> <span class="label label-danger pull-right"><?= $product_total; ?>
							</a>
						</li>
						<li>
							<a href="<?= $alert_review; ?>">
								<?= $lang_text_review_approve; ?> <span class="label label-danger pull-right"><?= $review_total; ?></span>
							</a>
						</li>
					</ul>
				</li>
				<li class="dropdown" id="help">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-cog fa-lg visible-label"></i>
						<span class="hidden-md hidden-lg"><?= $lang_text_info; ?></span>
						<b class="caret hidden-md hidden-lg"></b>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown-header visible-md visible-lg">
							<?= $lang_text_store; ?> <i class="fa fa-shopping-cart"></i>
						</li>
						<li><a href="<?= $store; ?>" target="_blank"><?= $lang_text_front; ?></a></li>
						<?php foreach ($stores as $store) { ?>
						<li><a href="<?= $store['href']; ?>" target="_blank"><?= $store['name']; ?></a></li>
						<?php } ?>
						<li class="divider visible-md visible-lg"></li>
						<li class="dropdown-header visible-md visible-lg"><?= $lang_text_help; ?> <i class="fa fa-question-circle"></i></li>
						<li><a href="http://dais.io" target="_blank"><?= $lang_text_dais; ?></a></li>
						<li><a href="<?= $help; ?>"><?= $lang_text_documentation; ?></a></li>
						<li><a href="http://forum.dais.io" target="_blank"><?= $lang_text_support; ?></a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user fa-lg visible-label"></i>
						<span class="hidden-md hidden-lg"><?= $lang_text_setting; ?></span>
						<b class="caret hidden-md hidden-lg"></b>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown-header"><?= $logged; ?></li>
						<li><a href="<?= $alert_store_setting; ?>"><?= $lang_text_setting; ?></a></li>
						<li><a href="<?= $logout; ?>"><?= $lang_text_logout; ?></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php endif; ?>