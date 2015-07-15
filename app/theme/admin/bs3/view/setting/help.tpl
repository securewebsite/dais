<?= $header; ?>
<?= $breadcrumb; ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="clearfix">
			<div class="pull-left h2"><i class="hidden-xs fa fa-question-circle"></i><?= $lang_heading_title; ?></div>
		</div>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li><a href="#tab-welcome" data-toggle="tab"><?= $lang_tab_welcome; ?></a></li>
			<li><a href="#tab-events" data-toggle="tab"><?= $lang_tab_events; ?></a></li>
		</ul>
		<div class="tab-content">
			<div id="tab-welcome" class="tab-pane">
				<div class="col-sm-12">
					<?= $lang_text_welcome; ?>
				</div>
			</div>
			<div id="tab-events" class="tab-pane">
				<div class="col-sm-12 table-responsive">
					<div class="col-sm-8"><?= $lang_text_events; ?></div>
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th><?= $lang_column_event; ?></th>
								<th><?= $lang_column_param; ?></th>
								<th><?= $lang_column_class; ?></th>
							</tr>
						</thead>
						<tbody>
							<!-- admin attribute -->
							<tr>
								<td>admin_add_attribute</td>
								<td>(array)attribute_id</td>
								<td>Admin\Model\Catalog\Attribute\addAttribute</td>
							</tr>
							<tr>
								<td>admin_edit_attribute</td>
								<td>(array)attribute_id</td>
								<td>Admin\Model\Catalog\Attribute\editAttribute</td>
							</tr>
							<tr>
								<td>admin_delete_attribute</td>
								<td>(array)attribute_id</td>
								<td>Admin\Model\Catalog\Attribute\deleteAttribute</td>
							</tr>
							<!-- admin attribute_group -->
							<tr>
								<td>admin_add_attribute_group</td>
								<td>(array)attribute_group_id</td>
								<td>Admin\Model\Catalog\Attributegroup\addAttributeGroup</td>
							</tr>
							<tr>
								<td>admin_edit_attribute_group</td>
								<td>(array)attribute_group_id</td>
								<td>Admin\Model\Catalog\Attributegroup\editAttributeGroup</td>
							</tr>
							<tr>
								<td>admin_delete_attribute_group</td>
								<td>(array)attribute_group_id</td>
								<td>Admin\Model\Catalog\Attributegroup\deleteAttributeGroup</td>
							</tr>
							<!-- admin catalog category -->
							<tr>
								<td>admin_add_category</td>
								<td>(array)catagory_id</td>
								<td>Admin\Model\Catalog\Category\addCategory</td>
							</tr>
							<tr>
								<td>admin_edit_category</td>
								<td>(array)catagory_id</td>
								<td>Admin\Model\Catalog\Category\editCategory</td>
							</tr>
							<tr>
								<td>admin_delete_category</td>
								<td>(array)catagory_id</td>
								<td>Admin\Model\Catalog\Category\deleteCategory</td>
							</tr>
							<!-- admin download -->
							<tr>
								<td>admin_add_download</td>
								<td>(array)download_id</td>
								<td>Admin\Model\Catalog\Download\addDownload</td>
							</tr>
							<tr>
								<td>admin_edit_download</td>
								<td>(array)download_id</td>
								<td>Admin\Model\Catalog\Download\editDownload</td>
							</tr>
							<tr>
								<td>admin_delete_download</td>
								<td>(array)download_id</td>
								<td>Admin\Model\Catalog\Download\deleteDownload</td>
							</tr>
							<!-- admin catalog events -->
							<tr>
								<td>admin_add_event</td>
								<td>(array)event_id</td>
								<td>Admin\Model\Catalog\Event\addEvent</td>
							</tr>
							<tr>
								<td>admin_edit_event</td>
								<td>(array)event_id</td>
								<td>Admin\Model\Catalog\Event\editEvent</td>
							</tr>
							<tr>
								<td>admin_delete_event</td>
								<td>(array)event_id</td>
								<td>Admin\Model\Catalog\Event\deleteEvent</td>
							</tr>
							<!-- admin filter -->
							<tr>
								<td>admin_add_filter</td>
								<td>(array)filter_id</td>
								<td>Admin\Model\Catalog\Filter\addFilter</td>
							</tr>
							<tr>
								<td>admin_edit_filter</td>
								<td>(array)filter_id</td>
								<td>Admin\Model\Catalog\Filter\editFilter</td>
							</tr>
							<tr>
								<td>admin_delete_filter</td>
								<td>(none)</td>
								<td>Admin\Model\Catalog\Filter\deleteFilter</td>
							</tr>
							<!-- admin manufacturer -->
							<tr>
								<td>admin_add_manufacturer</td>
								<td>(array)manufacturer_id</td>
								<td>Admin\Model\Catalog\Manufacturer\addManufacturer</td>
							</tr>
							<tr>
								<td>admin_edit_manufacturer</td>
								<td>(array)manufacturer_id</td>
								<td>Admin\Model\Catalog\Manufacturer\editManufacturer</td>
							</tr>
							<tr>
								<td>admin_delete_manufacturer</td>
								<td>(array)manufacturer_id</td>
								<td>Admin\Model\Catalog\Manufacturer\deleteManufacturer</td>
							</tr>
							<!-- admin product option -->
							<tr>
								<td>admin_add_option</td>
								<td>(array)option_id</td>
								<td>Admin\Model\Catalog\Option\addOption</td>
							</tr>
							<tr>
								<td>admin_edit_option</td>
								<td>(array)option_id</td>
								<td>Admin\Model\Catalog\Option\editOption</td>
							</tr>
							<tr>
								<td>admin_delete_option</td>
								<td>(array)option_id</td>
								<td>Admin\Model\Catalog\Option\deleteOption</td>
							</tr>
							<!-- admin product -->
							<tr>
								<td>admin_add_product</td>
								<td>(array)product_id</td>
								<td>Admin\Model\Catalog\Product\addProduct</td>
							</tr>
							<tr>
								<td>admin_edit_product</td>
								<td>(array)product_id</td>
								<td>Admin\Model\Catalog\Product\editProduct</td>
							</tr>
							<tr>
								<td>admin_delete_product</td>
								<td>(array)product_id</td>
								<td>Admin\Model\Catalog\Product\deleteProduct</td>
							</tr>
							<!-- admin recurring -->
							<tr>
								<td>admin_add_recurring</td>
								<td>(array)recurring_id</td>
								<td>Admin\Model\Catalog\Recurring\addRecurring</td>
							</tr>
							<tr>
								<td>admin_edit_recurring</td>
								<td>(array)recurring_id</td>
								<td>Admin\Model\Catalog\Recurring\editRecurring</td>
							</tr>
							<tr>
								<td>admin_delete_recurring</td>
								<td>(array)recurring_id</td>
								<td>Admin\Model\Catalog\Recurring\deleteRecurring</td>
							</tr>
							<!-- admin product review -->
							<tr>
								<td>admin_add_review</td>
								<td>(array)review_id</td>
								<td>Admin\Model\Catalog\Review\addReview</td>
							</tr>
							<tr>
								<td>admin_edit_review</td>
								<td>(array)review_id</td>
								<td>Admin\Model\Catalog\Review\editReview</td>
							</tr>
							<tr>
								<td>admin_delete_review</td>
								<td>(array)review_id</td>
								<td>Admin\Model\Catalog\Review\deleteReview</td>
							</tr>
							<!-- admin blog category -->
							<tr>
								<td>admin_blog_add_category</td>
								<td>(array)blog_category_id</td>
								<td>Admin\Model\Content\Category\addCategory</td>
							</tr>
							<tr>
								<td>admin_blog_edit_category</td>
								<td>(array)blog_category_id</td>
								<td>Admin\Model\Content\Category\editCategory</td>
							</tr>
							<tr>
								<td>admin_blog_delete_category</td>
								<td>(array)blog_category_id</td>
								<td>Admin\Model\Content\Category\deleteCategory</td>
							</tr>
							<!-- admin blog comments -->
							<tr>
								<td>admin_blog_add_comment</td>
								<td>(array)blog_comment_id</td>
								<td>Admin\Model\Content\Comment\addComment</td>
							</tr>
							<tr>
								<td>admin_blog_edit_comment</td>
								<td>(array)blog_comment_id</td>
								<td>Admin\Model\Content\Comment\editComment</td>
							</tr>
							<tr>
								<td>admin_blog_delete_comment</td>
								<td>(array)blog_comment_id</td>
								<td>Admin\Model\Content\Comment\deleteComment</td>
							</tr>
							<tr>
								<td>admin_blog_comment_approved</td>
								<td>(array)blog_comment_id</td>
								<td>
									Admin\Model\Content\Comment\addComment<br>
									Admin\Model\Content\Comment\editComment
								</td>
							</tr>
							<!-- admin page -->
							<tr>
								<td>admin_add_page</td>
								<td>(array)page_id</td>
								<td>Admin\Model\Content\Page\addPage</td>
							</tr>
							<tr>
								<td>admin_edit_page</td>
								<td>(array)page_id</td>
								<td>Admin\Model\Content\Page\editPage</td>
							</tr>
							<tr>
								<td>admin_delete_page</td>
								<td>(array)page_id</td>
								<td>Admin\Model\Content\Page\deletePage</td>
							</tr>
							<!-- admin blog post -->
							<tr>
								<td>admin_blog_add_post</td>
								<td>(array)blog_post_id</td>
								<td>Admin\Model\Content\Post\addPost</td>
							</tr>
							<tr>
								<td>admin_blog_edit_post</td>
								<td>(array)blog_post_id</td>
								<td>Admin\Model\Content\Post\editPost</td>
							</tr>
							<tr>
								<td>admin_blog_delete_post</td>
								<td>(array)blog_post_id</td>
								<td>Admin\Model\Content\Post\deletePost</td>
							</tr>
							<!-- admin design banner -->
							<tr>
								<td>admin_add_banner</td>
								<td>(array)banner_id</td>
								<td>Admin\Model\Design\Banner\addBanner</td>
							</tr>
							<tr>
								<td>admin_edit_banner</td>
								<td>(array)banner_id</td>
								<td>Admin\Model\Design\Banner\editBanner</td>
							</tr>
							<tr>
								<td>admin_delete_banner</td>
								<td>(array)banner_id</td>
								<td>Admin\Model\Design\Banner\deleteBanner</td>
							</tr>
							<!-- admin design layout -->
							<tr>
								<td>admin_add_layout</td>
								<td>(array)layout_id</td>
								<td>Admin\Model\Design\Layout\addLayout</td>
							</tr>
							<tr>
								<td>admin_edit_layout</td>
								<td>(array)layout_id</td>
								<td>Admin\Model\Design\Layout\editLayout</td>
							</tr>
							<tr>
								<td>admin_delete_layout</td>
								<td>(array)layout_id</td>
								<td>Admin\Model\Design\Layout\deleteLayout</td>
							</tr>
							<!-- admin module notification -->
							<tr>
								<td>admin_add_notification</td>
								<td>(array)notification_id</td>
								<td>Admin\Model\Module\Notification\addNotification</td>
							</tr>
							<tr>
								<td>admin_edit_notification</td>
								<td>(array)notification_id</td>
								<td>Admin\Model\Module\Notification\editNotification</td>
							</tr>
							<tr>
								<td>admin_delete_notification</td>
								<td>(array)notification_id</td>
								<td>Admin\Model\Module\Notification\deleteNotification</td>
							</tr>
							<!-- admin people affiliate -->
							<tr>
								<td>admin_add_affiliate</td>
								<td>(array)affiliate_id</td>
								<td>Admin\Model\People\Affiliate\addAffiliate</td>
							</tr>
							<tr>
								<td>admin_edit_affiliate</td>
								<td>(array)affiliate_id</td>
								<td>Admin\Model\People\Affiliate\editAffiliate</td>
							</tr>
							<tr>
								<td>admin_delete_affiliate</td>
								<td>(array)affiliate_id</td>
								<td>Admin\Model\People\Affiliate\deleteAffiliate</td>
							</tr>
							<tr>
								<td>admin_approve_affiliate</td>
								<td>(array)affiliate_id</td>
								<td>Admin\Model\People\Affiliate\approve</td>
							</tr>
							<tr>
								<td>admin_add_affiliate_transaction</td>
								<td>(array)affiliate_transaction_id</td>
								<td>Admin\Model\People\Affiliate\addTransaction</td>
							</tr>
							<tr>
								<td>admin_delete_affiliate_transaction</td>
								<td>(array)affiliate_transaction_id</td>
								<td>Admin\Model\People\Affiliate\deleteTransaction</td>
							</tr>
							<!-- admin customer -->
							<tr>
								<td>admin_add_customer</td>
								<td>(array)customer_id</td>
								<td>Admin\Model\People\Customer\addCustomer</td>
							</tr>
							<tr>
								<td>admin_edit_customer</td>
								<td>(array)customer_id</td>
								<td>Admin\Model\People\Customer\editCustomer</td>
							</tr>
							<tr>
								<td>admin_delete_customer</td>
								<td>(array)customer_id</td>
								<td>Admin\Model\People\Customer\deleteCustomer</td>
							</tr>
							<tr>
								<td>admin_approve_customer</td>
								<td>(array)customer_id</td>
								<td>Admin\Model\People\Customer\approve</td>
							</tr>
							<tr>
								<td>admin_add_history</td>
								<td>(array)customer_id</td>
								<td>Admin\Model\People\Customer\addHistory</td>
							</tr>
							<tr>
								<td>admin_add_customer_credit</td>
								<td>(array)customer_id</td>
								<td>Admin\Model\People\Customer\addCredit</td>
							</tr>
							<tr>
								<td>admin_delete_customer_credit</td>
								<td>(array)order_id</td>
								<td>Admin\Model\People\Customer\deleteCredit</td>
							</tr>
							<tr>
								<td>admin_add_reward</td>
								<td>(array)customer_id</td>
								<td>Admin\Model\People\Customer\addReward</td>
							</tr>
							<!-- admin sale coupon -->
							<tr>
								<td>admin_add_coupon</td>
								<td>(array)coupon_id</td>
								<td>Admin\Model\Sale\Coupon\addCoupon</td>
							</tr>
							<tr>
								<td>admin_edit_coupon</td>
								<td>(array)coupon_id</td>
								<td>Admin\Model\Sale\Coupon\editCoupon</td>
							</tr>
							<tr>
								<td>admin_delete_coupon</td>
								<td>(array)coupon_id</td>
								<td>Admin\Model\Sale\Coupon\deleteCoupon</td>
							</tr>
							<!-- admin setting store -->
							<tr>
								<td>admin_add_store</td>
								<td>(array)store_id</td>
								<td>Admin\Model\Setting\Store\addStore</td>
							</tr>
							<tr>
								<td>admin_edit_store</td>
								<td>(array)store_id</td>
								<td>Admin\Model\Setting\Store\editStore</td>
							</tr>
							<tr>
								<td>admin_delete_store</td>
								<td>(array)store_id</td>
								<td>Admin\Model\Setting\Store\deleteStore</td>
							</tr>
							<!-- admin tool backup -->
							<tr>
								<td>admin_backup</td>
								<td>(none)</td>
								<td>Admin\Model\Tool\Backup\backup</td>
							</tr>
							<!-- front account login -->
							<tr>
								<td>front_customer_login</td>
								<td>(array)customer_id</td>
								<td>Front\Controller\Account\Login\index</td>
							</tr>
							<!-- front account logout -->
							<tr>
								<td>front_customer_logout</td>
								<td>(array)customer_id</td>
								<td>Front\Controller\Account\Logout\index</td>
							</tr>
							<!-- front account address -->
							<tr>
								<td>front_customer_add_address</td>
								<td>(array)address_id</td>
								<td>Front\Model\Account\Address\addAddress</td>
							</tr>
							<tr>
								<td>front_customer_edit_address</td>
								<td>(array)address_id</td>
								<td>Front\Model\Account\Address\editAddress</td>
							</tr>
							<tr>
								<td>front_customer_delete_address</td>
								<td>(array)address_id</td>
								<td>Front\Model\Account\Address\deleteAddress</td>
							</tr>
							<!-- front account customer -->
							<tr>
								<td>front_add_customer</td>
								<td>(array)customer_id</td>
								<td>Front\Model\Account\Customer\addCustomer</td>
							</tr>
							<tr>
								<td>front_edit_customer</td>
								<td>(array)customer_id</td>
								<td>Front\Model\Account\Customer\editCustomer</td>
							</tr>
							<tr>
								<td>front_customer_edit_password</td>
								<td>(array)customer_id</td>
								<td>Front\Model\Account\Customer\editPassword</td>
							</tr>
							<tr>
								<td>front_customer_edit_newsletter</td>
								<td>(array)customer_id</td>
								<td>Front\Model\Account\Customer\editNewsletter</td>
							</tr>
							<!-- front account returns -->
							<tr>
								<td>front_return_add</td>
								<td>(array)return_id</td>
								<td>Front\Model\Account\Returns\addReturn</td>
							</tr>
							<!-- front affiliate affiliate -->
							<tr>
								<td>front_affiliate_add</td>
								<td>(array)affiliate_id</td>
								<td>Front\Model\Affiliate\Affiliate\addAffiliate</td>
							</tr>
							<tr>
								<td>front_affiliate_edit</td>
								<td>(array)affiliate_id</td>
								<td>Front\Model\Affiliate\Affiliate\editAffiliate</td>
							</tr>
							<tr>
								<td>front_affiliate_edit_payment</td>
								<td>(array)affiliate_id</td>
								<td>Front\Model\Affiliate\Affiliate\editPayment</td>
							</tr>
							<tr>
								<td>front_affiliate_edit_password</td>
								<td>(array)affiliate_id</td>
								<td>Front\Model\Affiliate\Affiliate\editPassword</td>
							</tr>
							<!-- front catalog review -->
							<tr>
								<td>front_review_add</td>
								<td>(array)review_id</td>
								<td>Front\Model\Catalog\Review\addReview</td>
							</tr>
							<!-- front checkout order -->
							<tr>
								<td>front_order_add</td>
								<td>(array)order_id</td>
								<td>Front\Model\Checkout\Order\addOrder</td>
							</tr>
							<tr>
								<td>front_order_confirm</td>
								<td>(array)order_id</td>
								<td>Front\Model\Checkout\Order\confirm</td>
							</tr>
							<tr>
								<td>front_order_update</td>
								<td>(array)order_id</td>
								<td>Front\Model\Checkout\Order\update</td>
							</tr>
							<!-- front content comment -->
							<tr>
								<td>front_comment_add_approved</td>
								<td>(array)comment_id</td>
								<td>Front\Model\Content\Comment\addComment</td>
							</tr>
							<tr>
								<td>front_comment_add_unapproved</td>
								<td>(array)comment_id</td>
								<td>Front\Model\Content\Comment\addComment</td>
							</tr>
							<!-- front content post -->
							<tr>
								<td>front_post_update_viewed</td>
								<td>(array)post_id</td>
								<td>Front\Model\Content\Post\updateViewed</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?= $footer; ?>