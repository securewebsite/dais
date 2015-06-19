<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard();

		$this->call('AddressTableSeeder');
		$this->call('AffiliateRouteTableSeeder');
		$this->call('AttributeTableSeeder');
		$this->call('AttributeDescriptionTableSeeder');
		$this->call('AttributeGroupTableSeeder');
		$this->call('AttributeGroupDescriptionTableSeeder');
		$this->call('BannerTableSeeder');
		$this->call('BannerImageTableSeeder');
		$this->call('BannerImageDescriptionTableSeeder');
		$this->call('BlogCategoryTableSeeder');
		$this->call('BlogCategoryDescriptionTableSeeder');
		$this->call('BlogCategoryToLayoutTableSeeder');
		$this->call('BlogCategoryToStoreTableSeeder');
		$this->call('BlogCommentTableSeeder');
		$this->call('BlogPostTableSeeder');
		$this->call('BlogPostDescriptionTableSeeder');
		$this->call('BlogPostImageTableSeeder');
		$this->call('BlogPostRelatedTableSeeder');
		$this->call('BlogPostToCategoryTableSeeder');
		$this->call('BlogPostToLayoutTableSeeder');
		$this->call('BlogPostToStoreTableSeeder');
		$this->call('CategoryTableSeeder');
		$this->call('CategoryDescriptionTableSeeder');
		$this->call('CategoryFilterTableSeeder');
		$this->call('CategoryPathTableSeeder');
		$this->call('CategoryToLayoutTableSeeder');
		$this->call('CategoryToStoreTableSeeder');
		$this->call('CountryTableSeeder');
		$this->call('CouponTableSeeder');
		$this->call('CouponCategoryTableSeeder');
		$this->call('CouponHistoryTableSeeder');
		$this->call('CouponProductTableSeeder');
		$this->call('CurrencyTableSeeder');
		$this->call('CustomerTableSeeder');
		$this->call('CustomerBanIpTableSeeder');
		$this->call('CustomerCommissionTableSeeder');
		$this->call('CustomerCreditTableSeeder');
		$this->call('CustomerGroupTableSeeder');
		$this->call('CustomerGroupDescriptionTableSeeder');
		$this->call('CustomerHistoryTableSeeder');
		$this->call('CustomerInboxTableSeeder');
		$this->call('CustomerIpTableSeeder');
		$this->call('CustomerNotificationTableSeeder');
		$this->call('CustomerOnlineTableSeeder');
		$this->call('CustomerRewardTableSeeder');
		$this->call('CustomRouteTableSeeder');
		$this->call('DownloadTableSeeder');
		$this->call('DownloadDescriptionTableSeeder');
		$this->call('EmailTableSeeder');
		$this->call('EmailContentTableSeeder');
		$this->call('EventTableSeeder');
		$this->call('EventManagerTableSeeder');
		$this->call('EventWaitListTableSeeder');
		$this->call('FilterTableSeeder');
		$this->call('FilterDescriptionTableSeeder');
		$this->call('FilterGroupTableSeeder');
		$this->call('FilterGroupDescriptionTableSeeder');
		$this->call('GeoZoneTableSeeder');
		$this->call('GiftCardTableSeeder');
		$this->call('GiftCardHistoryTableSeeder');
		$this->call('GiftCardThemeTableSeeder');
		$this->call('GiftCardThemeDescriptionTableSeeder');
		$this->call('HookTableSeeder');
		$this->call('LanguageTableSeeder');
		$this->call('LayoutTableSeeder');
		$this->call('LayoutRouteTableSeeder');
		$this->call('LengthClassTableSeeder');
		$this->call('LengthClassDescriptionTableSeeder');
		$this->call('ManufacturerTableSeeder');
		$this->call('ManufacturerToStoreTableSeeder');
		$this->call('MenuTableSeeder');
		$this->call('ModuleTableSeeder');
		$this->call('NotificationQueueTableSeeder');
		$this->call('OptionTableSeeder');
		$this->call('OptionDescriptionTableSeeder');
		$this->call('OptionValueTableSeeder');
		$this->call('OptionValueDescriptionTableSeeder');
		$this->call('OrderTableSeeder');
		$this->call('OrderDownloadTableSeeder');
		$this->call('OrderFraudTableSeeder');
		$this->call('OrderGiftCardTableSeeder');
		$this->call('OrderHistoryTableSeeder');
		$this->call('OrderOptionTableSeeder');
		$this->call('OrderProductTableSeeder');
		$this->call('OrderRecurringTableSeeder');
		$this->call('OrderRecurringTransactionTableSeeder');
		$this->call('OrderStatusTableSeeder');
		$this->call('OrderTotalTableSeeder');
		$this->call('PageTableSeeder');
		$this->call('PageDescriptionTableSeeder');
		$this->call('PageToLayoutTableSeeder');
		$this->call('PageToStoreTableSeeder');
		$this->call('PaypalOrderTableSeeder');
		$this->call('PaypalOrderTransactionTableSeeder');
		$this->call('PresenterTableSeeder');
		$this->call('ProductTableSeeder');
		$this->call('ProductAttributeTableSeeder');
		$this->call('ProductDescriptionTableSeeder');
		$this->call('ProductDiscountTableSeeder');
		$this->call('ProductFilterTableSeeder');
		$this->call('ProductImageTableSeeder');
		$this->call('ProductOptionTableSeeder');
		$this->call('ProductOptionValueTableSeeder');
		$this->call('ProductRecurringTableSeeder');
		$this->call('ProductRelatedTableSeeder');
		$this->call('ProductRewardTableSeeder');
		$this->call('ProductSpecialTableSeeder');
		$this->call('ProductToCategoryTableSeeder');
		$this->call('ProductToDownloadTableSeeder');
		$this->call('ProductToLayoutTableSeeder');
		$this->call('ProductToStoreTableSeeder');
		$this->call('RecurringTableSeeder');
		$this->call('RecurringDescriptionTableSeeder');
		$this->call('ReturnTableSeeder');
		$this->call('ReturnActionTableSeeder');
		$this->call('ReturnHistoryTableSeeder');
		$this->call('ReturnReasonTableSeeder');
		$this->call('ReturnStatusTableSeeder');
		$this->call('ReviewTableSeeder');
		$this->call('RouteTableSeeder');
		$this->call('SearchIndexTableSeeder');
		$this->call('SettingTableSeeder');
		$this->call('StockStatusTableSeeder');
		$this->call('StoreTableSeeder');
		$this->call('TagTableSeeder');
		$this->call('TaxClassTableSeeder');
		$this->call('TaxRateTableSeeder');
		$this->call('TaxRateToCustomerGroupTableSeeder');
		$this->call('TaxRuleTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('UserGroupTableSeeder');
		$this->call('VanityRouteTableSeeder');
		$this->call('WeightClassTableSeeder');
		$this->call('WeightClassDescriptionTableSeeder');
		$this->call('ZoneTableSeeder');
		$this->call('ZoneToGeoZoneTableSeeder');
		
		Model::reguard();
	}
}
