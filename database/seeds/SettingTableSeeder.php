<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('setting')->delete();
        
		\DB::table('setting')->insert(array (
			0 => 
			array (
				'setting_id' => 4288,
				'store_id' => 0,
				'section' => 'post_wall_widget',
				'item' => 'postwall_widget',
				'data' => 'a:1:{i:0;a:10:{s:5:"limit";s:2:"12";s:4:"span";s:1:"4";s:6:"height";s:0:"";s:9:"post_type";s:6:"latest";s:11:"description";s:1:"1";s:6:"button";s:1:"1";s:9:"layout_id";s:2:"14";s:8:"position";s:11:"content_top";s:6:"status";s:1:"0";s:10:"sort_order";s:1:"1";}}',
				'serialized' => 1,
			),
			1 => 
			array (
				'setting_id' => 9740,
				'store_id' => 0,
				'section' => 'banner',
				'item' => 'banner_widget',
				'data' => 'a:1:{i:0;a:7:{s:9:"banner_id";s:1:"6";s:5:"width";s:3:"267";s:6:"height";s:3:"267";s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}}',
				'serialized' => 1,
			),
			2 => 
			array (
				'setting_id' => 9748,
				'store_id' => 0,
				'section' => 'carousel',
				'item' => 'carousel_widget',
				'data' => 'a:2:{i:0;a:9:{s:9:"banner_id";s:1:"8";s:5:"limit";s:1:"5";s:6:"scroll";s:1:"2";s:5:"width";s:2:"80";s:6:"height";s:2:"80";s:9:"layout_id";s:1:"2";s:8:"position";s:10:"pre_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:1;a:9:{s:9:"banner_id";s:1:"8";s:5:"limit";s:1:"5";s:6:"scroll";s:1:"3";s:5:"width";s:2:"80";s:6:"height";s:2:"80";s:9:"layout_id";s:2:"14";s:8:"position";s:10:"pre_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}',
				'serialized' => 1,
			),
			3 => 
			array (
				'setting_id' => 9749,
				'store_id' => 0,
				'section' => 'category',
				'item' => 'category_widget',
				'data' => 'a:4:{i:0;a:4:{s:9:"layout_id";s:1:"4";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:4:{s:9:"layout_id";s:1:"5";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:2;a:4:{s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:3;a:4:{s:9:"layout_id";s:2:"12";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}',
				'serialized' => 1,
			),
			4 => 
			array (
				'setting_id' => 9750,
				'store_id' => 0,
				'section' => 'featured',
				'item' => 'product',
				'data' => '',
				'serialized' => 0,
			),
			5 => 
			array (
				'setting_id' => 9751,
				'store_id' => 0,
				'section' => 'featured',
				'item' => 'featured_product',
				'data' => '43,40,42,49,46,47,28',
				'serialized' => 0,
			),
			6 => 
			array (
				'setting_id' => 9752,
				'store_id' => 0,
				'section' => 'featured',
				'item' => 'featured_widget',
				'data' => 'a:1:{i:0;a:7:{s:5:"limit";s:1:"6";s:11:"image_width";s:3:"191";s:12:"image_height";s:3:"180";s:9:"layout_id";s:1:"2";s:8:"position";s:14:"content_bottom";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}',
				'serialized' => 1,
			),
			7 => 
			array (
				'setting_id' => 9754,
				'store_id' => 0,
				'section' => 'masonry_widget',
				'item' => 'masonry_widget',
				'data' => 'a:1:{i:0;a:10:{s:5:"limit";s:2:"12";s:4:"span";s:1:"2";s:6:"height";s:0:"";s:12:"product_type";s:6:"latest";s:11:"description";s:1:"1";s:6:"button";s:1:"1";s:9:"layout_id";s:1:"2";s:8:"position";s:11:"content_top";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}}',
				'serialized' => 1,
			),
			8 => 
			array (
				'setting_id' => 11053,
				'store_id' => 0,
				'section' => 'account',
				'item' => 'account_widget',
				'data' => 'a:2:{i:0;a:4:{s:9:"layout_id";s:1:"6";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:4:{s:9:"layout_id";s:2:"18";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}',
				'serialized' => 1,
			),
			9 => 
			array (
				'setting_id' => 12700,
				'store_id' => 0,
				'section' => 'credit',
				'item' => 'credit_status',
				'data' => '1',
				'serialized' => 0,
			),
			10 => 
			array (
				'setting_id' => 12701,
				'store_id' => 0,
				'section' => 'credit',
				'item' => 'credit_sort_order',
				'data' => '3',
				'serialized' => 0,
			),
			11 => 
			array (
				'setting_id' => 12702,
				'store_id' => 0,
				'section' => 'handling',
				'item' => 'handling_total',
				'data' => '',
				'serialized' => 0,
			),
			12 => 
			array (
				'setting_id' => 12703,
				'store_id' => 0,
				'section' => 'handling',
				'item' => 'handling_fee',
				'data' => '',
				'serialized' => 0,
			),
			13 => 
			array (
				'setting_id' => 12704,
				'store_id' => 0,
				'section' => 'handling',
				'item' => 'handling_tax_class_id',
				'data' => '0',
				'serialized' => 0,
			),
			14 => 
			array (
				'setting_id' => 12705,
				'store_id' => 0,
				'section' => 'handling',
				'item' => 'handling_status',
				'data' => '0',
				'serialized' => 0,
			),
			15 => 
			array (
				'setting_id' => 12706,
				'store_id' => 0,
				'section' => 'handling',
				'item' => 'handling_sort_order',
				'data' => '5',
				'serialized' => 0,
			),
			16 => 
			array (
				'setting_id' => 12712,
				'store_id' => 0,
				'section' => 'reward',
				'item' => 'reward_status',
				'data' => '1',
				'serialized' => 0,
			),
			17 => 
			array (
				'setting_id' => 12713,
				'store_id' => 0,
				'section' => 'reward',
				'item' => 'reward_sort_order',
				'data' => '9',
				'serialized' => 0,
			),
			18 => 
			array (
				'setting_id' => 12714,
				'store_id' => 0,
				'section' => 'shipping',
				'item' => 'shipping_estimator',
				'data' => '1',
				'serialized' => 0,
			),
			19 => 
			array (
				'setting_id' => 12715,
				'store_id' => 0,
				'section' => 'shipping',
				'item' => 'shipping_status',
				'data' => '1',
				'serialized' => 0,
			),
			20 => 
			array (
				'setting_id' => 12716,
				'store_id' => 0,
				'section' => 'shipping',
				'item' => 'shipping_sort_order',
				'data' => '7',
				'serialized' => 0,
			),
			21 => 
			array (
				'setting_id' => 12717,
				'store_id' => 0,
				'section' => 'tax',
				'item' => 'tax_status',
				'data' => '1',
				'serialized' => 0,
			),
			22 => 
			array (
				'setting_id' => 12718,
				'store_id' => 0,
				'section' => 'tax',
				'item' => 'tax_sort_order',
				'data' => '4',
				'serialized' => 0,
			),
			23 => 
			array (
				'setting_id' => 12719,
				'store_id' => 0,
				'section' => 'total',
				'item' => 'total_status',
				'data' => '1',
				'serialized' => 0,
			),
			24 => 
			array (
				'setting_id' => 12720,
				'store_id' => 0,
				'section' => 'total',
				'item' => 'total_sort_order',
				'data' => '10',
				'serialized' => 0,
			),
			25 => 
			array (
				'setting_id' => 14013,
				'store_id' => 0,
				'section' => 'gift_card',
				'item' => 'gift_card_status',
				'data' => '1',
				'serialized' => 0,
			),
			26 => 
			array (
				'setting_id' => 14014,
				'store_id' => 0,
				'section' => 'gift_card',
				'item' => 'gift_card_sort_order',
				'data' => '8',
				'serialized' => 0,
			),
			27 => 
			array (
				'setting_id' => 14949,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_name',
				'data' => 'Your Site',
				'serialized' => 0,
			),
			28 => 
			array (
				'setting_id' => 14950,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_owner',
				'data' => 'Your Name',
				'serialized' => 0,
			),
			29 => 
			array (
				'setting_id' => 14951,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_address',
				'data' => '77 Massachusetts Ave,
Cambridge, MA 02139',
				'serialized' => 0,
			),
			30 => 
			array (
				'setting_id' => 14952,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_email',
				'data' => 'vkronlein@icloud.com',
				'serialized' => 0,
			),
			31 => 
			array (
				'setting_id' => 14953,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_telephone',
			'data' => '(123) 456-7890',
				'serialized' => 0,
			),
			32 => 
			array (
				'setting_id' => 14954,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_default_visibility',
				'data' => '1',
				'serialized' => 0,
			),
			33 => 
			array (
				'setting_id' => 14955,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_free_customer',
				'data' => '2',
				'serialized' => 0,
			),
			34 => 
			array (
				'setting_id' => 14956,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_top_customer',
				'data' => '4',
				'serialized' => 0,
			),
			35 => 
			array (
				'setting_id' => 14957,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_site_style',
				'data' => 'content',
				'serialized' => 0,
			),
			36 => 
			array (
				'setting_id' => 14958,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_home_page',
				'data' => '0',
				'serialized' => 0,
			),
			37 => 
			array (
				'setting_id' => 14959,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_title',
				'data' => 'Your Store',
				'serialized' => 0,
			),
			38 => 
			array (
				'setting_id' => 14960,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_meta_description',
				'data' => 'My Store',
				'serialized' => 0,
			),
			39 => 
			array (
				'setting_id' => 14961,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_theme',
				'data' => 'ghost',
				'serialized' => 0,
			),
			40 => 
			array (
				'setting_id' => 14962,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_admin_theme',
				'data' => 'bs3',
				'serialized' => 0,
			),
			41 => 
			array (
				'setting_id' => 14963,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_layout_id',
				'data' => '2',
				'serialized' => 0,
			),
			42 => 
			array (
				'setting_id' => 14964,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_country_id',
				'data' => '223',
				'serialized' => 0,
			),
			43 => 
			array (
				'setting_id' => 14965,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_zone_id',
				'data' => '3616',
				'serialized' => 0,
			),
			44 => 
			array (
				'setting_id' => 14966,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_language',
				'data' => 'en',
				'serialized' => 0,
			),
			45 => 
			array (
				'setting_id' => 14967,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_admin_language',
				'data' => 'en',
				'serialized' => 0,
			),
			46 => 
			array (
				'setting_id' => 14968,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_currency',
				'data' => 'USD',
				'serialized' => 0,
			),
			47 => 
			array (
				'setting_id' => 14969,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_currency_auto',
				'data' => '1',
				'serialized' => 0,
			),
			48 => 
			array (
				'setting_id' => 14970,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_length_class_id',
				'data' => '3',
				'serialized' => 0,
			),
			49 => 
			array (
				'setting_id' => 14971,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_weight_class_id',
				'data' => '5',
				'serialized' => 0,
			),
			50 => 
			array (
				'setting_id' => 14972,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_catalog_limit',
				'data' => '16',
				'serialized' => 0,
			),
			51 => 
			array (
				'setting_id' => 14973,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_admin_limit',
				'data' => '10',
				'serialized' => 0,
			),
			52 => 
			array (
				'setting_id' => 14974,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_product_count',
				'data' => '0',
				'serialized' => 0,
			),
			53 => 
			array (
				'setting_id' => 14975,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_review_status',
				'data' => '1',
				'serialized' => 0,
			),
			54 => 
			array (
				'setting_id' => 14976,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_review_logged',
				'data' => '0',
				'serialized' => 0,
			),
			55 => 
			array (
				'setting_id' => 14977,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_download',
				'data' => '0',
				'serialized' => 0,
			),
			56 => 
			array (
				'setting_id' => 14978,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_posted_by',
				'data' => 'user_name',
				'serialized' => 0,
			),
			57 => 
			array (
				'setting_id' => 14979,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_comment_status',
				'data' => '1',
				'serialized' => 0,
			),
			58 => 
			array (
				'setting_id' => 14980,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_comment_logged',
				'data' => '0',
				'serialized' => 0,
			),
			59 => 
			array (
				'setting_id' => 14981,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_comment_require_approve',
				'data' => '1',
				'serialized' => 0,
			),
			60 => 
			array (
				'setting_id' => 14982,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_admin_group_id',
				'data' => '1',
				'serialized' => 0,
			),
			61 => 
			array (
				'setting_id' => 14983,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_thumb_width',
				'data' => '200',
				'serialized' => 0,
			),
			62 => 
			array (
				'setting_id' => 14984,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_thumb_height',
				'data' => '200',
				'serialized' => 0,
			),
			63 => 
			array (
				'setting_id' => 14985,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_popup_width',
				'data' => '600',
				'serialized' => 0,
			),
			64 => 
			array (
				'setting_id' => 14986,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_popup_height',
				'data' => '600',
				'serialized' => 0,
			),
			65 => 
			array (
				'setting_id' => 14987,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_post_width',
				'data' => '900',
				'serialized' => 0,
			),
			66 => 
			array (
				'setting_id' => 14988,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_post_height',
				'data' => '300',
				'serialized' => 0,
			),
			67 => 
			array (
				'setting_id' => 14989,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_additional_width',
				'data' => '130',
				'serialized' => 0,
			),
			68 => 
			array (
				'setting_id' => 14990,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_additional_height',
				'data' => '130',
				'serialized' => 0,
			),
			69 => 
			array (
				'setting_id' => 14991,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_related_width',
				'data' => '200',
				'serialized' => 0,
			),
			70 => 
			array (
				'setting_id' => 14992,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'blog_image_related_height',
				'data' => '200',
				'serialized' => 0,
			),
			71 => 
			array (
				'setting_id' => 14993,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_gift_card_min',
				'data' => '25.00',
				'serialized' => 0,
			),
			72 => 
			array (
				'setting_id' => 14994,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_gift_card_max',
				'data' => '1000.00',
				'serialized' => 0,
			),
			73 => 
			array (
				'setting_id' => 14995,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_tax',
				'data' => '0',
				'serialized' => 0,
			),
			74 => 
			array (
				'setting_id' => 14996,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_vat',
				'data' => '0',
				'serialized' => 0,
			),
			75 => 
			array (
				'setting_id' => 14997,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_tax_default',
				'data' => '',
				'serialized' => 0,
			),
			76 => 
			array (
				'setting_id' => 14998,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_tax_customer',
				'data' => 'shipping',
				'serialized' => 0,
			),
			77 => 
			array (
				'setting_id' => 14999,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_customer_online',
				'data' => '0',
				'serialized' => 0,
			),
			78 => 
			array (
				'setting_id' => 15000,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_customer_group_id',
				'data' => '2',
				'serialized' => 0,
			),
			79 => 
			array (
				'setting_id' => 15001,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_customer_group_display',
				'data' => 'a:1:{i:0;s:1:"2";}',
				'serialized' => 1,
			),
			80 => 
			array (
				'setting_id' => 15002,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_customer_price',
				'data' => '0',
				'serialized' => 0,
			),
			81 => 
			array (
				'setting_id' => 15003,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_account_id',
				'data' => '3',
				'serialized' => 0,
			),
			82 => 
			array (
				'setting_id' => 15004,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_cart_weight',
				'data' => '1',
				'serialized' => 0,
			),
			83 => 
			array (
				'setting_id' => 15005,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_guest_checkout',
				'data' => '1',
				'serialized' => 0,
			),
			84 => 
			array (
				'setting_id' => 15006,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_checkout_id',
				'data' => '5',
				'serialized' => 0,
			),
			85 => 
			array (
				'setting_id' => 15007,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_order_edit',
				'data' => '100',
				'serialized' => 0,
			),
			86 => 
			array (
				'setting_id' => 15008,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_invoice_prefix',
				'data' => 'INV-2013-00',
				'serialized' => 0,
			),
			87 => 
			array (
				'setting_id' => 15009,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_order_status_id',
				'data' => '2',
				'serialized' => 0,
			),
			88 => 
			array (
				'setting_id' => 15010,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_complete_status_id',
				'data' => '5',
				'serialized' => 0,
			),
			89 => 
			array (
				'setting_id' => 15011,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_stock_display',
				'data' => '1',
				'serialized' => 0,
			),
			90 => 
			array (
				'setting_id' => 15012,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_stock_warning',
				'data' => '0',
				'serialized' => 0,
			),
			91 => 
			array (
				'setting_id' => 15013,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_stock_checkout',
				'data' => '0',
				'serialized' => 0,
			),
			92 => 
			array (
				'setting_id' => 15014,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_stock_status_id',
				'data' => '5',
				'serialized' => 0,
			),
			93 => 
			array (
				'setting_id' => 15015,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_affiliate_allowed',
				'data' => '1',
				'serialized' => 0,
			),
			94 => 
			array (
				'setting_id' => 15016,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_affiliate_terms',
				'data' => '8',
				'serialized' => 0,
			),
			95 => 
			array (
				'setting_id' => 15017,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_commission',
				'data' => '10',
				'serialized' => 0,
			),
			96 => 
			array (
				'setting_id' => 15018,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_return_id',
				'data' => '7',
				'serialized' => 0,
			),
			97 => 
			array (
				'setting_id' => 15019,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_return_status_id',
				'data' => '2',
				'serialized' => 0,
			),
			98 => 
			array (
				'setting_id' => 15020,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_logo',
				'data' => 'data/logo.png',
				'serialized' => 0,
			),
			99 => 
			array (
				'setting_id' => 15021,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_icon',
				'data' => 'data/favicon.png',
				'serialized' => 0,
			),
			100 => 
			array (
				'setting_id' => 15022,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_category_width',
				'data' => '180',
				'serialized' => 0,
			),
			101 => 
			array (
				'setting_id' => 15023,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_category_height',
				'data' => '180',
				'serialized' => 0,
			),
			102 => 
			array (
				'setting_id' => 15024,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_thumb_width',
				'data' => '451',
				'serialized' => 0,
			),
			103 => 
			array (
				'setting_id' => 15025,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_thumb_height',
				'data' => '451',
				'serialized' => 0,
			),
			104 => 
			array (
				'setting_id' => 15026,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_popup_width',
				'data' => '600',
				'serialized' => 0,
			),
			105 => 
			array (
				'setting_id' => 15027,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_popup_height',
				'data' => '600',
				'serialized' => 0,
			),
			106 => 
			array (
				'setting_id' => 15028,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_product_width',
				'data' => '213',
				'serialized' => 0,
			),
			107 => 
			array (
				'setting_id' => 15029,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_product_height',
				'data' => '213',
				'serialized' => 0,
			),
			108 => 
			array (
				'setting_id' => 15030,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_additional_width',
				'data' => '88',
				'serialized' => 0,
			),
			109 => 
			array (
				'setting_id' => 15031,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_additional_height',
				'data' => '88',
				'serialized' => 0,
			),
			110 => 
			array (
				'setting_id' => 15032,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_related_width',
				'data' => '180',
				'serialized' => 0,
			),
			111 => 
			array (
				'setting_id' => 15033,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_related_height',
				'data' => '180',
				'serialized' => 0,
			),
			112 => 
			array (
				'setting_id' => 15034,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_compare_width',
				'data' => '140',
				'serialized' => 0,
			),
			113 => 
			array (
				'setting_id' => 15035,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_compare_height',
				'data' => '140',
				'serialized' => 0,
			),
			114 => 
			array (
				'setting_id' => 15036,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_wishlist_width',
				'data' => '70',
				'serialized' => 0,
			),
			115 => 
			array (
				'setting_id' => 15037,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_wishlist_height',
				'data' => '70',
				'serialized' => 0,
			),
			116 => 
			array (
				'setting_id' => 15038,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_cart_width',
				'data' => '60',
				'serialized' => 0,
			),
			117 => 
			array (
				'setting_id' => 15039,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_image_cart_height',
				'data' => '60',
				'serialized' => 0,
			),
			118 => 
			array (
				'setting_id' => 15040,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_ftp_host',
				'data' => 'dais.local',
				'serialized' => 0,
			),
			119 => 
			array (
				'setting_id' => 15041,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_ftp_port',
				'data' => '21',
				'serialized' => 0,
			),
			120 => 
			array (
				'setting_id' => 15042,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_ftp_username',
				'data' => '',
				'serialized' => 0,
			),
			121 => 
			array (
				'setting_id' => 15043,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_ftp_password',
				'data' => '',
				'serialized' => 0,
			),
			122 => 
			array (
				'setting_id' => 15044,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_ftp_root',
				'data' => '',
				'serialized' => 0,
			),
			123 => 
			array (
				'setting_id' => 15045,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_ftp_status',
				'data' => '0',
				'serialized' => 0,
			),
			124 => 
			array (
				'setting_id' => 15046,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_mail_protocol',
				'data' => 'smtp',
				'serialized' => 0,
			),
			125 => 
			array (
				'setting_id' => 15047,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_mail_parameter',
				'data' => '',
				'serialized' => 0,
			),
			126 => 
			array (
				'setting_id' => 15048,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_smtp_host',
				'data' => 'smtp.mailgun.org',
				'serialized' => 0,
			),
			127 => 
			array (
				'setting_id' => 15049,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_smtp_username',
				'data' => 'postmaster@dais.io',
				'serialized' => 0,
			),
			128 => 
			array (
				'setting_id' => 15050,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_smtp_password',
				'data' => 'aaa9faf2deacc1442df84eae4b6a02a2',
				'serialized' => 0,
			),
			129 => 
			array (
				'setting_id' => 15051,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_smtp_port',
				'data' => '587',
				'serialized' => 0,
			),
			130 => 
			array (
				'setting_id' => 15052,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_smtp_timeout',
				'data' => '10',
				'serialized' => 0,
			),
			131 => 
			array (
				'setting_id' => 15053,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_admin_email_user',
				'data' => '1',
				'serialized' => 0,
			),
			132 => 
			array (
				'setting_id' => 15054,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_html_signature',
				'data' => '&lt;p style=&quot;margin-top: 0;color: #212425;font-family: sans-serif;font-size: 16px;line-height: 24px;margin-bottom: 24px&quot;&gt;
&lt;em&gt;
Thanks so much,
&lt;/em&gt;
&lt;/p&gt;
&lt;p style=&quot;margin-top: 0;color: #212425;font-family: sans-serif;font-size: 16px;line-height: 24px;margin-bottom: 24px&quot;&gt;
&lt;em&gt;
!store_name! Administration
&lt;br&gt;
&lt;a href=&quot;!store_url!&quot; target=&quot;_blank&quot;&gt;
!store_url!
&lt;/a&gt;
&lt;/em&gt;
&lt;/p&gt;',
				'serialized' => 0,
			),
			133 => 
			array (
				'setting_id' => 15055,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_text_signature',
				'data' => 'Thanks so much,

!store_name! Administration
!store_url!',
				'serialized' => 0,
			),
			134 => 
			array (
				'setting_id' => 15056,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_mail_twitter',
				'data' => 'TwitterHandle',
				'serialized' => 0,
			),
			135 => 
			array (
				'setting_id' => 15057,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_mail_facebook',
				'data' => 'FacebookPage',
				'serialized' => 0,
			),
			136 => 
			array (
				'setting_id' => 15058,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_alert_mail',
				'data' => '0',
				'serialized' => 0,
			),
			137 => 
			array (
				'setting_id' => 15059,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_account_mail',
				'data' => '0',
				'serialized' => 0,
			),
			138 => 
			array (
				'setting_id' => 15060,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_alert_emails',
				'data' => '',
				'serialized' => 0,
			),
			139 => 
			array (
				'setting_id' => 15061,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_fraud_detection',
				'data' => '0',
				'serialized' => 0,
			),
			140 => 
			array (
				'setting_id' => 15062,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_fraud_key',
				'data' => '',
				'serialized' => 0,
			),
			141 => 
			array (
				'setting_id' => 15063,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_fraud_score',
				'data' => '',
				'serialized' => 0,
			),
			142 => 
			array (
				'setting_id' => 15064,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_fraud_status_id',
				'data' => '7',
				'serialized' => 0,
			),
			143 => 
			array (
				'setting_id' => 15065,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_secure',
				'data' => '0',
				'serialized' => 0,
			),
			144 => 
			array (
				'setting_id' => 15066,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_shared',
				'data' => '0',
				'serialized' => 0,
			),
			145 => 
			array (
				'setting_id' => 15067,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_top_level',
				'data' => '0',
				'serialized' => 0,
			),
			146 => 
			array (
				'setting_id' => 15068,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_ucfirst',
				'data' => '0',
				'serialized' => 0,
			),
			147 => 
			array (
				'setting_id' => 15069,
				'store_id' => 0,
				'section' => 'config',
				'item' => 'config_robots',
				'data' => 'abot
dbot
ebot
hbot
kbot
lbot
mbot
nbot
obot
pbot
rbot
sbot
tbot
vbot
ybot
zbot
bot.
bot/
_bot
.bot
/bot
-bot
:bot
(bot
crawl
slurp
spider
seek
accoona
acoon
adressendeutschland
ah-ha.com
ahoy
altavista
ananzi
anthill
appie
arachnophilia
arale
araneo
aranha
architext
aretha
arks
asterias
atlocal
atn
atomz
augurfind
backrub
bannana_bot
baypup
bdfetch
big brother
biglotron
bjaaland
blackwidow
blaiz
blog
blo.
bloodhound
boitho
booch
bradley
butterfly
calif
cassandra
ccubee
cfetch
charlotte
churl
cienciaficcion
cmc
collective
comagent
combine
computingsite
csci
curl
cusco
daumoa
deepindex
delorie
depspid
deweb
die blinde kuh
digger
ditto
dmoz
docomo
download express
dtaagent
dwcp
ebiness
ebingbong
e-collector
ejupiter
emacs-w3 search engine
esther
evliya celebi
ezresult
falcon
felix ide
ferret
fetchrover
fido
findlinks
fireball
fish search
fouineur
funnelweb
gazz
gcreep
genieknows
getterroboplus
geturl
glx
goforit
golem
grabber
grapnel
gralon
griffon
gromit
grub
gulliver
hamahakki
harvest
havindex
helix
heritrix
hku www octopus
homerweb
htdig
html index
html_analyzer
htmlgobble
hubater
hyper-decontextualizer
ia_archiver
ibm_planetwide
ichiro
iconsurf
iltrovatore
image.kapsi.net
imagelock
incywincy
indexer
infobee
informant
ingrid
inktomisearch.com
inspector web
intelliagent
internet shinchakubin
ip3000
iron33
israeli-search
ivia
jack
jakarta
javabee
jetbot
jumpstation
katipo
kdd-explorer
kilroy
knowledge
kototoi
kretrieve
labelgrabber
lachesis
larbin
legs
libwww
linkalarm
link validator
linkscan
lockon
lwp
lycos
magpie
mantraagent
mapoftheinternet
marvin/
mattie
mediafox
mediapartners
mercator
merzscope
microsoft url control
minirank
miva
mj12
mnogosearch
moget
monster
moose
motor
multitext
muncher
muscatferret
mwd.search
myweb
najdi
nameprotect
nationaldirectory
nazilla
ncsa beta
nec-meshexplorer
nederland.zoek
netcarta webmap engine
netmechanic
netresearchserver
netscoop
newscan-online
nhse
nokia6682/
nomad
noyona
nutch
nzexplorer
objectssearch
occam
omni
open text
openfind
openintelligencedata
orb search
osis-project
pack rat
pageboy
pagebull
page_verifier
panscient
parasite
partnersite
patric
pear.
pegasus
peregrinator
pgp key agent
phantom
phpdig
picosearch
piltdownman
pimptrain
pinpoint
pioneer
piranha
plumtreewebaccessor
pogodak
poirot
pompos
poppelsdorf
poppi
popular iconoclast
psycheclone
publisher
python
rambler
raven search
roach
road runner
roadhouse
robbie
robofox
robozilla
rules
salty
sbider
scooter
scoutjet
scrubby
search.
searchprocess
semanticdiscovery
senrigan
sg-scout
shai\'hulud
shark
shopwiki
sidewinder
sift
silk
simmany
site searcher
site valet
sitetech-rover
skymob.com
sleek
smartwit
sna-
snappy
snooper
sohu
speedfind
sphere
sphider
spinner
spyder
steeler/
suke
suntek
supersnooper
surfnomore
sven
sygol
szukacz
tach black widow
tarantula
templeton
/teoma
t-h-u-n-d-e-r-s-t-o-n-e
theophrastus
titan
titin
tkwww
toutatis
t-rex
tutorgig
twiceler
twisted
ucsd
udmsearch
url check
updated
vagabondo
valkyrie
verticrawl
victoria
vision-search
volcano
voyager/
voyager-hc
w3c_validator
w3m2
w3mir
walker
wallpaper
wanderer
wauuu
wavefire
web core
web hopper
web wombat
webbandit
webcatcher
webcopy
webfoot
weblayers
weblinker
weblog monitor
webmirror
webmonkey
webquest
webreaper
websitepulse
websnarf
webstolperer
webvac
webwalk
webwatch
webwombat
webzinger
whizbang
whowhere
wild ferret
worldlight
wwwc
wwwster
xenu
xget
xift
xirq
yandex
yanga
yeti
yodao
zao
zippp
zyborg',
					'serialized' => 0,
				),
				148 => 
				array (
					'setting_id' => 15070,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_file_extension_allowed',
					'data' => 'txt
png
jpe
jpeg
jpg
gif
bmp
ico
tiff
tif
svg
svgz
zip
rar
msi
cab
mp3
qt
mov
pdf
psd
ai
eps
ps
doc
rtf
xls
ppt
odt
ods',
					'serialized' => 0,
				),
				149 => 
				array (
					'setting_id' => 15071,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_file_mime_allowed',
					'data' => 'text/plain
image/png
image/jpeg
image/jpeg
image/jpeg
image/gif
image/bmp
image/vnd.microsoft.icon
image/tiff
image/tiff
image/svg+xml
image/svg+xml
application/zip
application/x-rar-compressed
application/x-msdownload
application/vnd.ms-cab-compressed
audio/mpeg
video/quicktime
video/quicktime
application/pdf
image/vnd.adobe.photoshop
application/postscript
application/postscript
application/postscript
application/msword
application/rtf
application/vnd.ms-excel
application/vnd.ms-powerpoint
application/vnd.oasis.opendocument.text
application/vnd.oasis.opendocument.spreadsheet',
					'serialized' => 0,
				),
				150 => 
				array (
					'setting_id' => 15072,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_maintenance',
					'data' => '0',
					'serialized' => 0,
				),
				151 => 
				array (
					'setting_id' => 15073,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_password',
					'data' => '1',
					'serialized' => 0,
				),
				152 => 
				array (
					'setting_id' => 15074,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_encryption',
					'data' => 'fd2c415aaad40d03f81f4e3197eb9f1d',
					'serialized' => 0,
				),
				153 => 
				array (
					'setting_id' => 15075,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_compression',
					'data' => '',
					'serialized' => 0,
				),
				154 => 
				array (
					'setting_id' => 15076,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_error_display',
					'data' => '1',
					'serialized' => 0,
				),
				155 => 
				array (
					'setting_id' => 15077,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_error_log',
					'data' => '1',
					'serialized' => 0,
				),
				156 => 
				array (
					'setting_id' => 15078,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_error_filename',
					'data' => 'error.txt',
					'serialized' => 0,
				),
				157 => 
				array (
					'setting_id' => 15079,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_google_analytics',
					'data' => '',
					'serialized' => 0,
				),
				158 => 
				array (
					'setting_id' => 15080,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_cache_type_id',
					'data' => 'file',
					'serialized' => 0,
				),
				159 => 
				array (
					'setting_id' => 15081,
					'store_id' => 0,
					'section' => 'config',
					'item' => 'config_cache_status',
					'data' => '0',
					'serialized' => 0,
				),
				160 => 
				array (
					'setting_id' => 15082,
					'store_id' => 0,
					'section' => 'page',
					'item' => 'page_widget',
					'data' => 'a:3:{i:0;a:4:{s:9:"layout_id";s:2:"11";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:4:{s:9:"layout_id";s:2:"21";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:2;a:4:{s:9:"layout_id";s:2:"22";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}',
					'serialized' => 1,
				),
				161 => 
				array (
					'setting_id' => 15101,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'facebook_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				162 => 
				array (
					'setting_id' => 15102,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'twitter_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				163 => 
				array (
					'setting_id' => 15103,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'google_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				164 => 
				array (
					'setting_id' => 15104,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'linkedin_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				165 => 
				array (
					'setting_id' => 15105,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'pinterest_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				166 => 
				array (
					'setting_id' => 15106,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'tumblr_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				167 => 
				array (
					'setting_id' => 15107,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'digg_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				168 => 
				array (
					'setting_id' => 15108,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'stumbleupon_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				169 => 
				array (
					'setting_id' => 15109,
					'store_id' => 0,
					'section' => 'sharebar',
					'item' => 'delicious_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				170 => 
				array (
					'setting_id' => 15110,
					'store_id' => 0,
					'section' => 'git',
					'item' => 'git_provider',
					'data' => '2',
					'serialized' => 0,
				),
				171 => 
				array (
					'setting_id' => 15111,
					'store_id' => 0,
					'section' => 'git',
					'item' => 'git_url',
					'data' => 'git@github.com:19peaches/dais.git',
					'serialized' => 0,
				),
				172 => 
				array (
					'setting_id' => 15112,
					'store_id' => 0,
					'section' => 'git',
					'item' => 'git_branch',
					'data' => 'master',
					'serialized' => 0,
				),
				173 => 
				array (
					'setting_id' => 15113,
					'store_id' => 0,
					'section' => 'git',
					'item' => 'git_status',
					'data' => '1',
					'serialized' => 0,
				),
				174 => 
				array (
					'setting_id' => 15120,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'facebook_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				175 => 
				array (
					'setting_id' => 15121,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'twitter_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				176 => 
				array (
					'setting_id' => 15122,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'google_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				177 => 
				array (
					'setting_id' => 15123,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'linkedin_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				178 => 
				array (
					'setting_id' => 15124,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'pinterest_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				179 => 
				array (
					'setting_id' => 15125,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'tumblr_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				180 => 
				array (
					'setting_id' => 15126,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'digg_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				181 => 
				array (
					'setting_id' => 15127,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'stumbleupon_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				182 => 
				array (
					'setting_id' => 15128,
					'store_id' => 0,
					'section' => 'share_bar',
					'item' => 'delicious_enabled',
					'data' => '1',
					'serialized' => 0,
				),
				183 => 
				array (
					'setting_id' => 15129,
					'store_id' => 0,
					'section' => 'blog_hot_topics',
					'item' => 'blog_hot_topics_widget',
					'data' => 'a:4:{i:0;a:5:{s:5:"limit";s:1:"5";s:9:"layout_id";s:2:"15";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}i:1;a:5:{s:5:"limit";s:1:"5";s:9:"layout_id";s:2:"14";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}i:2;a:5:{s:5:"limit";s:1:"5";s:9:"layout_id";s:2:"16";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}i:3;a:5:{s:5:"limit";s:1:"5";s:9:"layout_id";s:2:"17";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}}',
					'serialized' => 1,
				),
				184 => 
				array (
					'setting_id' => 15130,
					'store_id' => 0,
					'section' => 'blog_featured',
					'item' => 'post',
					'data' => '',
					'serialized' => 0,
				),
				185 => 
				array (
					'setting_id' => 15131,
					'store_id' => 0,
					'section' => 'blog_featured',
					'item' => 'blog_featured_post',
					'data' => '1',
					'serialized' => 0,
				),
				186 => 
				array (
					'setting_id' => 15132,
					'store_id' => 0,
					'section' => 'blog_featured',
					'item' => 'blog_featured_widget',
					'data' => 'a:4:{i:0;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"15";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}i:1;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"14";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}i:2;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"16";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}i:3;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"17";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}}',
					'serialized' => 1,
				),
				187 => 
				array (
					'setting_id' => 15133,
					'store_id' => 0,
					'section' => 'blog_category',
					'item' => 'blog_category_widget',
					'data' => 'a:4:{i:0;a:4:{s:9:"layout_id";s:2:"15";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:1;a:4:{s:9:"layout_id";s:2:"14";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:2;a:4:{s:9:"layout_id";s:2:"11";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:3;a:4:{s:9:"layout_id";s:2:"16";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}}',
					'serialized' => 1,
				),
				188 => 
				array (
					'setting_id' => 15134,
					'store_id' => 0,
					'section' => 'blog_latest',
					'item' => 'blog_latest_widget',
					'data' => 'a:4:{i:0;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"15";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"5";}i:1;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"14";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"5";}i:2;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"16";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"5";}i:3;a:7:{s:5:"limit";s:1:"5";s:11:"image_width";s:2:"40";s:12:"image_height";s:2:"30";s:9:"layout_id";s:2:"17";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"5";}}',
					'serialized' => 1,
				),
				189 => 
				array (
					'setting_id' => 15135,
					'store_id' => 0,
					'section' => 'blog_search',
					'item' => 'blog_search_widget',
					'data' => 'a:4:{i:0;a:4:{s:9:"layout_id";s:2:"15";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:4:{s:9:"layout_id";s:2:"14";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:2;a:4:{s:9:"layout_id";s:2:"16";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:3;a:4:{s:9:"layout_id";s:2:"17";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}',
					'serialized' => 1,
				),
				190 => 
				array (
					'setting_id' => 15136,
					'store_id' => 0,
					'section' => 'footer_blocks',
					'item' => 'footer_blocks_widget',
					'data' => 'a:8:{i:0;a:5:{s:7:"menu_id";s:1:"5";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"shop_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:5:{s:7:"menu_id";s:1:"7";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"shop_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:2;a:5:{s:7:"menu_id";s:1:"8";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"shop_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}i:3;a:5:{s:7:"menu_id";s:2:"13";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"shop_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}i:4;a:5:{s:7:"menu_id";s:2:"10";s:9:"layout_id";s:1:"1";s:8:"position";s:14:"content_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:5;a:5:{s:7:"menu_id";s:1:"8";s:9:"layout_id";s:1:"1";s:8:"position";s:14:"content_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:6;a:5:{s:7:"menu_id";s:1:"5";s:9:"layout_id";s:1:"1";s:8:"position";s:14:"content_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"3";}i:7;a:5:{s:7:"menu_id";s:2:"16";s:9:"layout_id";s:1:"1";s:8:"position";s:14:"content_footer";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}}',
					'serialized' => 1,
				),
				191 => 
				array (
					'setting_id' => 15137,
					'store_id' => 0,
					'section' => 'header_menu',
					'item' => 'header_menu_widget',
					'data' => 'a:3:{i:0;a:5:{s:7:"menu_id";s:2:"17";s:9:"layout_id";s:1:"1";s:8:"position";s:11:"shop_header";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:5:{s:7:"menu_id";s:1:"4";s:9:"layout_id";s:1:"1";s:8:"position";s:14:"content_header";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:2;a:5:{s:7:"menu_id";s:1:"3";s:9:"layout_id";s:1:"1";s:8:"position";s:14:"content_header";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}}',
					'serialized' => 1,
				),
				192 => 
				array (
					'setting_id' => 15138,
					'store_id' => 0,
					'section' => 'side_bar_menu',
					'item' => 'side_bar_menu_widget',
					'data' => 'a:3:{i:0;a:5:{s:7:"menu_id";s:2:"14";s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:1;a:5:{s:7:"menu_id";s:2:"15";s:9:"layout_id";s:2:"14";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"4";}i:2;a:5:{s:7:"menu_id";s:2:"16";s:9:"layout_id";s:2:"14";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}}',
					'serialized' => 1,
				),
				193 => 
				array (
					'setting_id' => 15139,
					'store_id' => 0,
					'section' => 'slide_show',
					'item' => 'slide_show_widget',
					'data' => 'a:2:{i:0;a:7:{s:9:"banner_id";s:1:"9";s:5:"width";s:4:"1170";s:6:"height";s:3:"340";s:9:"layout_id";s:1:"2";s:8:"position";s:11:"post_header";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:7:{s:9:"banner_id";s:1:"9";s:5:"width";s:4:"1170";s:6:"height";s:3:"340";s:9:"layout_id";s:2:"14";s:8:"position";s:11:"post_header";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}',
					'serialized' => 1,
				),
				194 => 
				array (
					'setting_id' => 15140,
					'store_id' => 0,
					'section' => 'free_checkout',
					'item' => 'free_checkout_order_status_id',
					'data' => '1',
					'serialized' => 0,
				),
				195 => 
				array (
					'setting_id' => 15141,
					'store_id' => 0,
					'section' => 'free_checkout',
					'item' => 'free_checkout_status',
					'data' => '1',
					'serialized' => 0,
				),
				196 => 
				array (
					'setting_id' => 15142,
					'store_id' => 0,
					'section' => 'free_checkout',
					'item' => 'free_checkout_sort_order',
					'data' => '1',
					'serialized' => 0,
				),
				197 => 
				array (
					'setting_id' => 15143,
					'store_id' => 0,
					'section' => 'coupon',
					'item' => 'coupon_status',
					'data' => '1',
					'serialized' => 0,
				),
				198 => 
				array (
					'setting_id' => 15144,
					'store_id' => 0,
					'section' => 'coupon',
					'item' => 'coupon_sort_order',
					'data' => '2',
					'serialized' => 0,
				),
				199 => 
				array (
					'setting_id' => 15145,
					'store_id' => 0,
					'section' => 'sub_total',
					'item' => 'sub_total_status',
					'data' => '1',
					'serialized' => 0,
				),
				200 => 
				array (
					'setting_id' => 15146,
					'store_id' => 0,
					'section' => 'sub_total',
					'item' => 'sub_total_sort_order',
					'data' => '1',
					'serialized' => 0,
				),
				201 => 
				array (
					'setting_id' => 15147,
					'store_id' => 0,
					'section' => 'google_site_map',
					'item' => 'google_site_map_status',
					'data' => '1',
					'serialized' => 0,
				),
				202 => 
				array (
					'setting_id' => 15148,
					'store_id' => 0,
					'section' => 'google_base',
					'item' => 'google_base_status',
					'data' => '1',
					'serialized' => 0,
				),
			));
	}

}
