<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|   (c) Vince Kronlein <vince@dais.io>
|    
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
|   Your table prefix has been included so that you can easily write your 
|   migrations to include the proper prefix.
|   
|   $users = $this->create_table("{$this->prefix}users");
|
|   Obviously if you have no table prefix, this variable will be empty.
|   
*/

namespace Database\Migration;
use Egress\Library\Migration\MigrationBase;

class CreateInstallSchema_20150528223247 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        // address
        $table = $this->create_table("{$this->prefix}address", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('address_id', 'integer', array('primary_key' => true, 'unsigned' => true, 'auto_increment' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('firstname', 'string', array('limit' => 32));
        $table->column('lastname', 'string', array('limit' => 32));
        $table->column('company', 'string', array('limit' => 32));
        $table->column('company_id', 'string', array('limit' => 32));
        $table->column('tax_id', 'string', array('limit' => 32));
        $table->column('address_1', 'string', array('limit' => 128));
        $table->column('address_2', 'string', array('limit' => 128));
        $table->column('city', 'string', array('limit' => 128));
        $table->column('postcode', 'string', array('limit' => 10));
        $table->column('country_id', 'integer', array('unsigned' => true));
        $table->column('zone_id', 'integer', array('unsigned' => true));

        $table->finish();

        // affiliate_route
        $table = $this->create_table("{$this->prefix}affiliate_route", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('route_id', 'integer', array('primary_key' => true, 'unsigned' => true, 'auto_increment' => true));
        $table->column('route', 'string', array('primary_key' => true, 'limit' => 55));
        $table->column('query', 'string');
        $table->column('slug', 'string', array('primary_key' => true));

        $table->finish();

        // attribute
        $table = $this->create_table("{$this->prefix}attribute", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('attribute_id', 'integer', array('primary_key' => true, 'unsigned' => true, 'auto_increment' => true));
        $table->column('attribute_group_id', 'integer', array('unsigned' => true));
        $table->column('sort_order', 'tinyinteger', array('limit' =>  3, 'unsigned' => true));
        
        $table->finish();

        // attribute_description
        $table = $this->create_table("{$this->prefix}attribute_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('attribute_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('language_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        // attribute group
        $table = $this->create_table("{$this->prefix}attribute_group", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('attribute_group_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('sort_order', 'tinyinteger', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // attribute_group_description
        $table = $this->create_table("{$this->prefix}attribute_group_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('attribute_group_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('language_id', 'integer', array('primary_key' => true, 'unsigned' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        // banner
        $table = $this->create_table("{$this->prefix}banner", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('banner_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 64));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        
        $table->finish();

        // banner_image
        $table = $this->create_table("{$this->prefix}banner_image", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('banner_image_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('banner_id', 'integer', array('unsigned' => true));
        $table->column('link', 'string');
        $table->column('image', 'string');
        
        $table->finish();

        // banner_image_description
        $table = $this->create_table("{$this->prefix}banner_image_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('banner_image_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('banner_id', 'integer', array('unsigned' => true));
        $table->column('title', 'string', array('limit' => 64));
        
        $table->finish();

        // blog_category
        $table = $this->create_table("{$this->prefix}blog_category", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('image', 'string');
        $table->column('parent_id', 'integer', array('unsigned' => true));
        $table->column('top', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('columns', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));

        $table->finish();

        // blog_category_description
        $table = $this->create_table("{$this->prefix}blog_category_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string');
        $table->column('description', 'text');
        $table->column('meta_description', 'string');
        $table->column('meta_keyword', 'string');
        
        $table->finish();

        // blog_category_to_layout
        $table = $this->create_table("{$this->prefix}blog_category_to_layout", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('layout_id', 'integer', array('unsigned' => true));
        
        $table->finish();

        // blog_category_to_store
        $table = $this->create_table("{$this->prefix}blog_category_to_store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // blog_comment
        $table = $this->create_table("{$this->prefix}blog_comment", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('comment_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('post_id', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('author', 'string', array('limit' => 64));
        $table->column('email', 'string', array('limit' => 96));
        $table->column('website', 'string', array('limit' => 96));
        $table->column('text', 'text');
        $table->column('rating', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // blog_post
        $table = $this->create_table("{$this->prefix}blog_post", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('image', 'string', array('null' => true));
        $table->column('author_id', 'integer', array('unsigned' => true));
        $table->column('date_available', 'date');
        $table->column('sort_order', 'integer', array('unsigned' => true));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('visibility', 'tinyinteger', array('unsigned' => true, 'limit' => 3, 'default' => '1'));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('viewed', 'integer', array('unsigned' => true));

        $table->finish();

        // blog_post_description
        $table = $this->create_table("{$this->prefix}blog_post_description", array(
            'id'      => false, 
            'options' => 'Engine=' . SERVER_VERSION
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string');
        $table->column('description', 'text');
        $table->column('meta_description', 'string');
        $table->column('meta_keyword', 'string');
        
        $table->finish();

        // blog_post_image
        $table = $this->create_table("{$this->prefix}blog_post_image", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_image_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('post_id', 'integer', array('unsigned' => true));
        $table->column('image', 'string', array('null' => true));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // blog_post_related
        $table = $this->create_table("{$this->prefix}blog_post_related", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('related_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // blog_post_to_category
        $table = $this->create_table("{$this->prefix}blog_post_to_category", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // blog_post_to_layout
        $table = $this->create_table("{$this->prefix}blog_post_to_layout", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('layout_id', 'integer', array('unsigned' => true));
        
        $table->finish();

        // blog_post_to_store
        $table = $this->create_table("{$this->prefix}blog_post_to_store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // category
        $table = $this->create_table("{$this->prefix}category", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('image', 'string', array('null' => true));
        $table->column('parent_id', 'integer', array('unsigned' => true));
        $table->column('top', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('columns', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // category_description
        $table = $this->create_table("{$this->prefix}category_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string');
        $table->column('description', 'text');
        $table->column('meta_description', 'string');
        $table->column('meta_keyword', 'string');
        
        $table->finish();

        // category_filter
        $table = $this->create_table("{$this->prefix}category_filter", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('filter_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // category_path
        $table = $this->create_table("{$this->prefix}category_path", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('path_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('level', 'integer', array('unsigned' => true));
        
        $table->finish();

        // category_to_layout
        $table = $this->create_table("{$this->prefix}category_to_layout", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('layout_id', 'integer', array('unsigned' => true));
        
        $table->finish();

        // category_to_store
        $table = $this->create_table("{$this->prefix}category_to_store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // country
        $table = $this->create_table("{$this->prefix}country", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('country_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 128));
        $table->column('iso_code_2', 'string', array('limit' => 2));
        $table->column('iso_code_3', 'string', array('limit' => 3));
        $table->column('address_format', 'text');
        $table->column('postcode_required', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 1));
        
        $table->finish();

        // coupon
        $table = $this->create_table("{$this->prefix}coupon", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('coupon_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 128));
        $table->column('code', 'string', array('limit' => 10));
        $table->column('type', 'char', array('limit' => 1));
        $table->column('discount', 'decimal', array('unsigned' => true, 'scale' => 4, 'precision' => 15));
        $table->column('logged', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('shipping', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('total', 'decimal', array('unsigned' => true, 'scale' => 4, 'precision' => 15));
        $table->column('date_start', 'date', array('default' => '0000-00-00'));
        $table->column('date_end', 'date', array('default' => '0000-00-00'));
        $table->column('uses_total', 'integer', array('unsigned' => true));
        $table->column('uses_customer', 'string', array('limit' => 11));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // coupon_category
        $table = $this->create_table("{$this->prefix}coupon_category", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('coupon_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // coupon_history
        $table = $this->create_table("{$this->prefix}coupon_history", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('coupon_history_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('coupon_id', 'integer', array('unsigned' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // coupon_product
        $table = $this->create_table("{$this->prefix}coupon_product", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('coupon_product_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('coupon_id', 'integer', array('unsigned' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        
        $table->finish();

        // currency
        $table = $this->create_table("{$this->prefix}currency", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('currency_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('title', 'string', array('limit' => 32));
        $table->column('code', 'string', array('limit' => 3));
        $table->column('symbol_left', 'string', array('limit' => 12));
        $table->column('symbol_right', 'string', array('limit' => 12));
        $table->column('decimal_place', 'char', array('limit' => 1));
        $table->column('value', 'float', array('unsigned' => true, 'precision' => 15, 'scale' => 8));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // customer
        $table = $this->create_table("{$this->prefix}customer", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('store_id', 'integer', array('unsigned' => true));
        $table->column('username', 'string', array('primary_key' => true, 'limit' => 16));
        $table->column('firstname', 'string', array('limit' => 32));
        $table->column('lastname', 'string', array('limit' => 32));
        $table->column('email', 'string', array('limit' => 96));
        $table->column('telephone', 'string', array('limit' => 32));
        $table->column('password', 'string', array('limit' => 40));
        $table->column('salt', 'string', array('limit' => 9));
        $table->column('reset', 'string', array('limit' => 40));
        $table->column('cart', 'text', array('null' => true));
        $table->column('wishlist', 'text', array('null' => true));
        $table->column('newsletter', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('address_id', 'integer', array('unsigned' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true));
        $table->column('referral_id', 'integer', array('unsigned' => true, 'default' => 0));
        $table->column('is_affiliate', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        $table->column('affiliate_status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('company', 'string', array('limit' => 32));
        $table->column('website', 'string');
        $table->column('code', 'string', array('limit' => 64));
        $table->column('commission', 'decimal', array('unsigned' => true, 'precision' => 4, 'scale' => 2, 'default' => '0.00'));
        $table->column('tax_id', 'string', array('limit' => 64));
        $table->column('payment_method', 'string', array('limit' => 6));
        $table->column('cheque', 'string', array('limit' => 100));
        $table->column('paypal', 'string', array('limit' => 64));
        $table->column('bank_name', 'string', array('limit' => 64));
        $table->column('bank_branch_number', 'string', array('limit' => 64));
        $table->column('bank_swift_code', 'string', array('limit' => 64));
        $table->column('bank_account_name', 'string', array('limit' => 64));
        $table->column('bank_account_number', 'string', array('limit' => 64));
        $table->column('ip', 'string', array('limit' => 40, 'default' => '0'));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('approved', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('token', 'string');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // customer_ip_ban
        $table = $this->create_table("{$this->prefix}customer_ban_ip", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_ban_ip_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('ip', 'string', array('limit' => 40));
        
        $table->finish();

        // customer_commission
        $table = $this->create_table("{$this->prefix}customer_commission", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_commission_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('description', 'text');
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // customer_credit
        $table = $this->create_table("{$this->prefix}customer_credit", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_credit_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('description', 'text');
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // customer_group
        $table = $this->create_table("{$this->prefix}customer_group", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_group_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('approval', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('company_id_display', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('company_id_required', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('tax_id_display', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('tax_id_required', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // customer_group_description
        $table = $this->create_table("{$this->prefix}customer_group_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_group_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 32));
        $table->column('description', 'text');
        
        $table->finish();

        // customer_history
        $table = $this->create_table("{$this->prefix}customer_history", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_history_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('comment', 'text');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // customer_inbox
        $table = $this->create_table("{$this->prefix}customer_inbox", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));
        
        $table->column('notification_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'limit' => 13));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('subject', 'string', array('limit' => 64));
        $table->column('message', 'text');
        $table->column('is_read', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        
        $table->finish();

        // customer_ip
        $table = $this->create_table("{$this->prefix}customer_ip", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_ip_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('ip', 'string', array('limit' => 40));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // customer_notification
        $table = $this->create_table("{$this->prefix}customer_notification", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'default' => 0));
        $table->column('settings', 'text');
        
        $table->finish();

        // customer_online
        $table = $this->create_table("{$this->prefix}customer_online", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('ip', 'string', array('limit' => 40, 'primary_key' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('url', 'text');
        $table->column('referer', 'text');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // customer_reward
        $table = $this->create_table("{$this->prefix}customer_reward", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('customer_reward_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('description', 'text');
        $table->column('points', 'integer', array('unsigned' => true));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // download
        $table = $this->create_table("{$this->prefix}download", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('download_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('filename', 'string', array('limit' => 128));
        $table->column('mask', 'string', array('limit' => 128));
        $table->column('remaining', 'integer', array('unsigned' => true));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // download_description
        $table = $this->create_table("{$this->prefix}download_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('download_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        // email
        $table = $this->create_table("{$this->prefix}email", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('email_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('email_slug', 'string', array('limit' => 55));
        $table->column('configurable', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        $table->column('priority', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 2));
        $table->column('config_description', 'text');
        $table->column('recipient', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 1));
        $table->column('is_system', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 1));
        
        $table->finish();

        // email_content
        $table = $this->create_table("{$this->prefix}email_content", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('email_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'default' => 1));
        $table->column('subject', 'string', array('limit' => 128));
        $table->column('text', 'text');
        $table->column('html', 'text');
        
        $table->finish();

        // event
        $table = $this->create_table("{$this->prefix}event", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('event_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('store_id', 'integer', array('unsigned' => true));
        $table->column('event', 'string', array('primary_key' => true));
        $table->column('handlers', 'text');
        
        $table->finish();

        //event_manager
        $table = $this->create_table("{$this->prefix}event_manager", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('event_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('event_name', 'string', array('limit' => 150));
        $table->column('model', 'string', array('limit' => 50));
        $table->column('sku', 'string', array('limit' => 50));
        $table->column('visibility', 'integer', array('unsigned' => true, 'limit' => 3, 'default' => 1));
        $table->column('event_length', 'string', array('limit' => 40));
        $table->column('event_days', 'text');
        $table->column('event_class', 'string', array('limit' => 40, 'default' => 'event'));
        $table->column('date_time', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('online', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        $table->column('link', 'string', array('limit' => 200));
        $table->column('location', 'string', array('limit' => 200));
        $table->column('telephone', 'string', array('limit' => 25));
        $table->column('cost', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('seats', 'integer', array('unsigned' => true, 'default' => 0));
        $table->column('filled', 'integer', array('unsigned' => true, 'default' => 0));
        $table->column('presenter_tab', 'string', array('limit' => 50));
        $table->column('roster', 'mediumtext');
        $table->column('presenter_id', 'integer', array('unsigned' => true, 'default' => 0));
        $table->column('description', 'mediumtext');
        $table->column('refundable', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 0));
        $table->column('date_end', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('product_id', 'integer', array('unsigned' => true, 'default' => 0));
        $table->column('page_id', 'integer', array('unsigned' => true, 'default' => 0));
        
        $table->finish();

        // event_wait_list
        $table = $this->create_table("{$this->prefix}event_wait_list", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('event_wait_list_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('event_id', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        
        $table->finish();

        // filter
        $table = $this->create_table("{$this->prefix}filter", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('filter_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('filter_group_id', 'integer', array('unsigned' => true));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));

        $table->finish();

        // filter_description
        $table = $this->create_table("{$this->prefix}filter_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('filter_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('filter_group_id', 'integer', array('unsigned' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        // filter_group
        $table = $this->create_table("{$this->prefix}filter_group", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('filter_group_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // filter_group_description
        $table = $this->create_table("{$this->prefix}filter_group_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('filter_group_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        // geo_zone
        $table = $this->create_table("{$this->prefix}geo_zone", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('geo_zone_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 32));
        $table->column('description', 'string');
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // gift_card
        $table = $this->create_table("{$this->prefix}gift_card", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('gift_card_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('code', 'string', array('limit' => 10));
        $table->column('from_name', 'string', array('limit' => 64));
        $table->column('from_email', 'string', array('limit' => 96));
        $table->column('to_name', 'string', array('limit' => 64));
        $table->column('to_email', 'string', array('limit' => 96));
        $table->column('gift_card_theme_id', 'integer', array('unsigned' => true));
        $table->column('message', 'text');
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // gift_card_history
        $table = $this->create_table("{$this->prefix}gift_card_history", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('gift_card_history_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('gift_card_id', 'integer', array('unsigned' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // gift_card_theme
        $table = $this->create_table("{$this->prefix}gift_card_theme", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('gift_card_theme_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('image', 'string');
        
        $table->finish();

        // gift_card_theme_description
        $table = $this->create_table("{$this->prefix}gift_card_theme_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('gift_card_theme_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 32));
        
        $table->finish();

        // hook
        $table = $this->create_table("{$this->prefix}hook", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('hook_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('store_id', 'integer', array('unsigned' => true));
        $table->column('hook', 'string', array('primary_key' => true));
        $table->column('handlers', 'text');
        
        $table->finish();

        // language
        $table = $this->create_table("{$this->prefix}language", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 32));
        $table->column('code', 'string', array('limit' => 5));
        $table->column('locale', 'string');
        $table->column('image', 'string', array('limit' => 64));
        $table->column('directory', 'string', array('limit' => 32));
        $table->column('filename', 'string', array('limit' => 64));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        
        $table->finish();

        // layout
        $table = $this->create_table("{$this->prefix}layout", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('layout_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 64));
        
        $table->finish();

        // layout_route
        $table = $this->create_table("{$this->prefix}layout_route", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('layout_route_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('layout_id', 'integer', array('unsigned' => true));
        $table->column('store_id', 'integer', array('unsigned' => true));
        $table->column('route', 'string');
        
        $table->finish();

        // length_class
        $table = $this->create_table("{$this->prefix}length_class", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('length_class_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('value', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8));
        
        $table->finish();

        // length_class_description
        $table = $this->create_table("{$this->prefix}length_class_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('length_class_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('title', 'string', array('limit' => 32));
        $table->column('unit', 'string', array('limit' => 4));
        
        $table->finish();

        // manufacturer
        $table = $this->create_table("{$this->prefix}manufacturer", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('manufacturer_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 64));
        $table->column('image', 'string', array('null' => true));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // manufacturer_to_store
        $table = $this->create_table("{$this->prefix}manufacturer_to_store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('manufacturer_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // menu
        $table = $this->create_table("{$this->prefix}menu", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('menu_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('primary_key' => true, 'limit' => 32));
        $table->column('type', 'string', array('limit' => 32));
        $table->column('items', 'text');
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        
        $table->finish();

        // module
        $table = $this->create_table("{$this->prefix}module", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('module_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('type', 'string', array('limit' => 32));
        $table->column('code', 'string', array('limit' => 32));
        
        $table->finish();

        // notification queue
        $table = $this->create_table("{$this->prefix}notification_queue", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('queue_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('email', 'string', array('primary_key' => true, 'limit' => 96));
        $table->column('name', 'string', array('limit' => 96));
        $table->column('subject', 'string', array('limit' => 128));
        $table->column('text', 'text');
        $table->column('html', 'text');
        $table->column('sent', 'tinyinteger', array('unsigned' => true, 'primary_key' => true, 'limit' => 1, 'default' => 0));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_sent', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // option
        $table = $this->create_table("{$this->prefix}option", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('option_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('type', 'string', array('limit' => 32));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));

        $table->finish();

        // option_description
        $table = $this->create_table("{$this->prefix}option_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('option_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 128));
        
        $table->finish();

        // option_value
        $table = $this->create_table("{$this->prefix}option_value", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('option_value_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('option_id', 'integer', array('unsigned' => true));
        $table->column('image', 'string');
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // option_value_description
        $table = $this->create_table("{$this->prefix}option_value_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('option_value_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('option_id', 'integer', array('unsigned' => true));
        $table->column('name', 'string', array('limit' => 128));
        
        $table->finish();

        // order
        $table = $this->create_table("{$this->prefix}order", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('invoice_no', 'integer', array('unsigned' => true));
        $table->column('invoice_prefix', 'string', array('limit' => 26));
        $table->column('store_id', 'integer', array('unsigned' => true));
        $table->column('store_name', 'string', array('limit' => 64));
        $table->column('store_url', 'string');
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true));
        $table->column('firstname', 'string', array('limit' => 32));
        $table->column('lastname', 'string', array('limit' => 32));
        $table->column('email', 'string', array('limit' => 96));
        $table->column('telephone', 'string', array('limit' => 32));
        $table->column('payment_firstname', 'string', array('limit' => 32));
        $table->column('payment_lastname', 'string', array('limit' => 32));
        $table->column('payment_company', 'string', array('limit' => 32));
        $table->column('payment_company_id', 'string', array('limit' => 32));
        $table->column('payment_tax_id', 'string', array('limit' => 32));
        $table->column('payment_address_1', 'string', array('limit' => 128));
        $table->column('payment_address_2', 'string', array('limit' => 128));
        $table->column('payment_city', 'string', array('limit' => 128));
        $table->column('payment_postcode', 'string', array('limit' => 10));
        $table->column('payment_country', 'string', array('limit' => 128));
        $table->column('payment_country_id', 'integer', array('unsigned' => true));
        $table->column('payment_zone', 'string', array('limit' => 128));
        $table->column('payment_zone_id', 'integer', array('unsigned' => true));
        $table->column('payment_address_format', 'text');
        $table->column('payment_method', 'string', array('limit' => 128));
        $table->column('payment_code', 'string', array('limit' => 128));
        $table->column('shipping_firstname', 'string', array('limit' => 32));
        $table->column('shipping_lastname', 'string', array('limit' => 32));
        $table->column('shipping_company', 'string', array('limit' => 32));
        $table->column('shipping_address_1', 'string', array('limit' => 128));
        $table->column('shipping_address_2', 'string', array('limit' => 128));
        $table->column('shipping_city', 'string', array('limit' => 128));
        $table->column('shipping_postcode', 'string', array('limit' => 10));
        $table->column('shipping_country', 'string', array('limit' => 128));
        $table->column('shipping_country_id', 'integer', array('unsigned' => true));
        $table->column('shipping_zone', 'string', array('limit' => 128));
        $table->column('shipping_zone_id', 'integer', array('unsigned' => true));
        $table->column('shipping_address_format', 'text');
        $table->column('shipping_method', 'string', array('limit' => 128));
        $table->column('shipping_code', 'string', array('limit' => 128));
        $table->column('comment', 'text');
        $table->column('total', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('order_status_id', 'integer', array('unsigned' => true));
        $table->column('affiliate_id', 'integer', array('unsigned' => true));
        $table->column('commission', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('language_id', 'integer', array('unsigned' => true));
        $table->column('currency_id', 'integer', array('unsigned' => true));
        $table->column('currency_code', 'string', array('limit' => 3));
        $table->column('currency_value', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8, 'default' => '1.00000000'));
        $table->column('ip', 'string', array('limit' => 40));
        $table->column('forwarded_ip', 'string', array('limit' => 40));
        $table->column('user_agent', 'string');
        $table->column('accept_language', 'string');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // order_download
        $table = $this->create_table("{$this->prefix}order_download", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_download_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('order_product_id', 'integer', array('unsigned' => true));
        $table->column('name', 'string', array('limit' => 64));
        $table->column('filename', 'string', array('limit' => 128));
        $table->column('mask', 'string', array('limit' => 128));
        $table->column('remaining', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // order_fraud
        $table = $this->create_table("{$this->prefix}order_fraud", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('country_match', 'string', array('limit' => 3));
        $table->column('country_code', 'string', array('limit' => 2));
        $table->column('high_risk_country', 'string', array('limit' => 3));
        $table->column('distance', 'integer', array('unsigned' => true));
        $table->column('ip_region', 'string');
        $table->column('ip_city', 'string');
        $table->column('ip_latitude', 'decimal', array('precision' => 10, 'scale' => 6));
        $table->column('ip_longitude', 'decimal', array('precision' => 10, 'scale' => 6));
        $table->column('ip_isp', 'string');
        $table->column('ip_org', 'string');
        $table->column('ip_asnum', 'integer', array('unsigned' => true));
        $table->column('ip_user_type', 'string');
        $table->column('ip_country_confidence', 'string', array('limit' => 3));
        $table->column('ip_region_confidence', 'string', array('limit' => 3));
        $table->column('ip_city_confidence', 'string', array('limit' => 3));
        $table->column('ip_postal_confidence', 'string', array('limit' => 3));
        $table->column('ip_postal_code', 'string', array('limit' => 10));
        $table->column('ip_accuracy_radius', 'integer', array('unsigned' => true));
        $table->column('ip_net_speed_cell', 'string');
        $table->column('ip_metro_code', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('ip_area_code', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('ip_time_zone', 'string');
        $table->column('ip_region_name', 'string');
        $table->column('ip_domain', 'string');
        $table->column('ip_country_name', 'string');
        $table->column('ip_continent_code', 'string', array('limit' => 2));
        $table->column('ip_corporate_proxy', 'string', array('limit' => 3));
        $table->column('anonymous_proxy', 'string', array('limit' => 3));
        $table->column('proxy_score', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('is_trans_proxy', 'string', array('limit' => 3));
        $table->column('free_mail', 'string', array('limit' => 3));
        $table->column('carder_email', 'string', array('limit' => 3));
        $table->column('high_risk_username', 'string', array('limit' => 3));
        $table->column('high_risk_password', 'string', array('limit' => 3));
        $table->column('bin_match', 'string', array('limit' => 10));
        $table->column('bin_country', 'string', array('limit' => 2));
        $table->column('bin_name_match', 'string', array('limit' => 3));
        $table->column('bin_name', 'string');
        $table->column('bin_phone_match', 'string', array('limit' => 3));
        $table->column('bin_phone', 'string', array('limit' => 32));
        $table->column('customer_phone_in_billing_location', 'string', array('limit' => 8));
        $table->column('ship_forward', 'string', array('limit' => 3));
        $table->column('city_postal_match', 'string', array('limit' => 3));
        $table->column('ship_city_postal_match', 'string', array('limit' => 3));
        $table->column('score', 'decimal', array('unsigned' => true, 'precision' => 10, 'scale' => 5));
        $table->column('explanation', 'text');
        $table->column('risk_score', 'decimal', array('unsigned' => true, 'precision' => 10, 'scale' => 5));
        $table->column('queries_remaining', 'integer', array('unsigned' => true));
        $table->column('maxmind_id', 'string', array('limit' => 8));
        $table->column('error', 'text');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // order_gift_card
        $table = $this->create_table("{$this->prefix}order_gift_card", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_gift_card_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('gift_card_id', 'integer', array('unsigned' => true));
        $table->column('description', 'string');
        $table->column('code', 'string', array('limit' => 10));
        $table->column('from_name', 'string', array('limit' => 64));
        $table->column('from_email', 'string', array('limit' => 96));
        $table->column('to_name', 'string', array('limit' => 64));
        $table->column('to_email', 'string', array('limit' => 96));
        $table->column('gift_card_theme_id', 'integer', array('unsigned' => true));
        $table->column('message', 'text');
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        
        $table->finish();

        // order_history
        $table = $this->create_table("{$this->prefix}order_history", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_history_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('order_status_id', 'integer', array('unsigned' => true, 'limit' => 5));
        $table->column('notify', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('comment', 'text');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // order_option
        $table = $this->create_table("{$this->prefix}order_option", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_option_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('order_product_id', 'integer', array('unsigned' => true));
        $table->column('product_option_id', 'integer', array('unsigned' => true));
        $table->column('product_option_value_id', 'integer', array('unsigned' => true));
        $table->column('name', 'string');
        $table->column('value', 'text');
        $table->column('type', 'string', array('limit' => 32));
        
        $table->finish();

        // order_product
        $table = $this->create_table("{$this->prefix}order_product", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_product_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('name', 'string');
        $table->column('model', 'string', array('limit' => 64));
        $table->column('quantity', 'integer', array('unsigned' => true, 'limit' => 4));
        $table->column('price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('total', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('tax', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('reward', 'integer', array('unsigned' => true, 'limit' => 8));

        $table->finish();

        // order_recurring
        $table = $this->create_table("{$this->prefix}order_recurring", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_recurring_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('created', 'datetime');
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 4));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('product_name', 'string');
        $table->column('product_quantity', 'integer', array('unsigned' => true));
        $table->column('recurring_id', 'integer', array('unsigned' => true));
        $table->column('recurring_name', 'string');
        $table->column('recurring_description', 'string');
        $table->column('recurring_frequency', 'string', array('limit' => 25));
        $table->column('recurring_cycle', 'smallinteger', array('unsigned' => true, 'limit' => 6));
        $table->column('recurring_duration', 'smallinteger', array('unsigned' => true, 'limit' => 6));
        $table->column('recurring_price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('trial', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('trial_frequency', 'string', array('limit' => 25));
        $table->column('trial_cycle', 'smallinteger', array('unsigned' => true, 'limit' => 6));
        $table->column('trial_duration', 'smallinteger', array('unsigned' => true, 'limit' => 6));
        $table->column('trial_price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('reference', 'string');
        
        $table->finish();

        // order_recurring_transaction
        $table = $this->create_table("{$this->prefix}order_recurring_transaction", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_recurring_transaction_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_recurring_id', 'integer', array('unsigned' => true));
        $table->column('created', 'datetime');
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('type', 'string');
        
        $table->finish();

        // order_status
        $table = $this->create_table("{$this->prefix}order_status", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_status_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 32));
        
        $table->finish();

        // order_total
        $table = $this->create_table("{$this->prefix}order_total", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('order_total_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('code', 'string', array('limit' => 32));
        $table->column('title', 'string');
        $table->column('text', 'string');
        $table->column('value', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // page
        $table = $this->create_table("{$this->prefix}page", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('page_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('bottom', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 1));
        $table->column('visibility', 'tinyinteger', array('unsigned' => true, 'limit' => 3, 'default' => 1));
        $table->column('event_id', 'integer', array('unsigned' => true, 'default' => 0));
        
        $table->finish();

        // page_description
        $table = $this->create_table("{$this->prefix}page_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('page_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('title', 'string', array('limit' => 64));
        $table->column('description', 'text');
        $table->column('meta_description', 'string');
        $table->column('meta_keywords', 'string');
        
        $table->finish();

        // page_to_layout
        $table = $this->create_table("{$this->prefix}page_to_layout", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('page_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('layout_id', 'integer', array('unsigned' => true));
        
        $table->finish();

        // page_to_store
        $table = $this->create_table("{$this->prefix}page_to_store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('page_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // paypal_order
        $table = $this->create_table("{$this->prefix}paypal_order", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('paypal_order_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('date_added', 'datetime');
        $table->column('date_modified', 'datetime');
        $table->column('capture_status', 'enum', array('null' => true, 'values' => array('Complete', 'NotComplete')));
        $table->column('currency_code', 'char', array('limit' => 3));
        $table->column('authorization_id', 'string', array('limit' => 32));
        $table->column('total', 'decimal', array('unsigned' => true, 'precision' => 10, 'scale' => 2));
        
        $table->finish();

        // paypal_order_transaction
        $table = $this->create_table("{$this->prefix}paypal_order_transaction", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('paypal_order_transaction_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('paypal_order_id', 'integer', array('unsigned' => true));
        $table->column('transaction_id', 'char', array('limit' => 20));
        $table->column('parent_transaction_id', 'char', array('limit' => 20));
        $table->column('date_added', 'datetime');
        $table->column('note', 'string');
        $table->column('msgsubid', 'char', array('limit' => 38));
        $table->column('receipt_id', 'char', array('limit' => 20));
        $table->column('payment_type', 'enum', array('null' => true, 'values' => array('none', 'echeck', 'instant', 'refund', 'void')));
        $table->column('payment_status', 'char', array('limit' => 20));
        $table->column('pending_reason', 'char', array('limit' => 50));
        $table->column('transaction_entity', 'char', array('limit' => 50));
        $table->column('amount', 'decimal', array('unsigned' => true, 'precision' => 10, 'scale' => 2));
        $table->column('debug_data', 'text');
        $table->column('call_data', 'text');
        
        $table->finish();

        // presenter
        $table = $this->create_table("{$this->prefix}presenter", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('presenter_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('presenter_name', 'string', array('limit' => 150));
        $table->column('image', 'string');
        $table->column('facebook', 'string', array('limit' => 128));
        $table->column('twitter', 'string', array('limit' => 128));
        $table->column('bio', 'mediumtext');
        
        $table->finish();

        // product
        $table = $this->create_table("{$this->prefix}product", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('event_id', 'integer', array('unsigned' => true, 'default' => 0));
        $table->column('model', 'string', array('limit' => 64));
        $table->column('sku', 'string', array('limit' => 64));
        $table->column('upc', 'string', array('limit' => 12));
        $table->column('ean', 'string', array('limit' => 14));
        $table->column('jan', 'string', array('limit' => 13));
        $table->column('isbn', 'string', array('limit' => 13));
        $table->column('mpn', 'string', array('limit' => 64));
        $table->column('location', 'string', array('limit' => 128));
        $table->column('visibility', 'integer', array('unsigned' => true, 'limit' => 3, 'default' => 1));
        $table->column('quantity', 'integer', array('unsigned' => true, 'limit' => 4));
        $table->column('stock_status_id', 'integer', array('unsigned' => true));
        $table->column('image', 'string', array('null' => true));
        $table->column('manufacturer_id', 'integer', array('unsigned' => true));
        $table->column('shipping', 'boolean', array('unsigned' => true));
        $table->column('price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('points', 'integer', array('limit' => 8));
        $table->column('tax_class_id', 'integer', array('unsigned' => true));
        $table->column('date_available', 'date');
        $table->column('end_date', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('weight', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8, 'default' => '0.00000000'));
        $table->column('weight_class_id', 'integer', array('unsigned' => true));
        $table->column('length', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8, 'default' => '0.00000000'));
        $table->column('width', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8, 'default' => '0.00000000'));
        $table->column('height', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8, 'default' => '0.00000000'));
        $table->column('length_class_id', 'integer', array('unsigned' => true));
        $table->column('subtract', 'boolean', array('unsigned' => true, 'default' => 1));
        $table->column('minimum', 'integer', array('unsigned' => true, 'default' => 1));
        $table->column('sort_order', 'integer', array('unsigned' => true));
        $table->column('status', 'boolean', array('unsigned' => true));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('viewed', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true, 'default' => 0));

        $table->finish();

        // product_attribute
        $table = $this->create_table("{$this->prefix}product_attribute", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('attribute_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('text', 'text');
        
        $table->finish();

        // product_description
        $table = $this->create_table("{$this->prefix}product_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string');
        $table->column('description', 'text');
        $table->column('meta_description', 'string');
        $table->column('meta_keyword', 'string');
        
        $table->finish();

        // product_discount
        $table = $this->create_table("{$this->prefix}product_discount", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_discount_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true));
        $table->column('quantity', 'integer', array('unsigned' => true, 'limit' => 4));
        $table->column('priority', 'integer', array('unsigned' => true, 'limit' => 5, 'default' => 1));
        $table->column('price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('date_start', 'date', array('default' => '0000-00-00'));
        $table->column('date_end', 'date', array('default' => '0000-00-00'));
        
        $table->finish();

        // product_filter
        $table = $this->create_table("{$this->prefix}product_filter", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('filter_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // product_image
        $table = $this->create_table("{$this->prefix}product_image", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_image_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('image', 'string', array('null' => true));
        $table->column('sort_order', 'integer', array('unsigned' => true, 'limit' => 3));
        
        $table->finish();

        // product_option
        $table = $this->create_table("{$this->prefix}product_option", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_option_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('option_id', 'integer', array('unsigned' => true));
        $table->column('option_value', 'text');
        $table->column('required', 'boolean', array('unsigned' => true));

        $table->finish();

        // product_option_value
        $table = $this->create_table("{$this->prefix}product_option_value", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_option_value_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('product_option_id', 'integer', array('unsigned' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('option_id', 'integer', array('unsigned' => true));
        $table->column('option_value_id', 'integer', array('unsigned' => true));
        $table->column('quantity', 'integer', array('unsigned' => true));
        $table->column('subtract', 'boolean', array('unsigned' => true));
        $table->column('price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('price_prefix', 'string', array('limit' => 1));
        $table->column('points', 'integer', array('unsigned' => true, 'limit' => 8));
        $table->column('points_prefix', 'string', array('limit' => 1));
        $table->column('weight', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8));
        $table->column('weight_prefix', 'string', array('limit' => 1));
        
        $table->finish();

        // product_recurring
        $table = $this->create_table("{$this->prefix}product_recurring", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('recurring_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // product_related
        $table = $this->create_table("{$this->prefix}product_related", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('related_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // product_reward
        $table = $this->create_table("{$this->prefix}product_reward", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_reward_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true));
        $table->column('points', 'integer', array('unsigned' => true));
        
        $table->finish();

        // product_special
        $table = $this->create_table("{$this->prefix}product_special", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_special_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true));
        $table->column('priority', 'integer', array('unsigned' => true, 'limit' => 5, 'default' => 1));
        $table->column('price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('date_start', 'date', array('default' => '0000-00-00'));
        $table->column('date_end', 'date', array('default' => '0000-00-00'));
        
        $table->finish();

        // product_to_category
        $table = $this->create_table("{$this->prefix}product_to_category", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('category_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // product_to_download
        $table = $this->create_table("{$this->prefix}product_to_download", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('download_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // product_to_layout
        $table = $this->create_table("{$this->prefix}product_to_layout", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('layout_id', 'integer', array('unsigned' => true));
        
        $table->finish();

        // product_to_store
        $table = $this->create_table("{$this->prefix}product_to_store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('product_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // recurring
        $table = $this->create_table("{$this->prefix}recurring", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('recurring_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('frequency', 'enum', array('values' => array('day', 'week', 'semi_month', 'month', 'year')));
        $table->column('duration', 'integer', array('unsigned' => true));
        $table->column('cycle', 'integer', array('unsigned' => true));
        $table->column('trial_status', 'boolean', array('unsigned' => true, 'limit' => 4));
        $table->column('trial_price', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4));
        $table->column('trial_frequency', 'enum', array('values' => array('day', 'week', 'semi_month', 'month', 'year')));
        $table->column('trial_duration', 'integer', array('unsigned' => true));
        $table->column('trial_cycle', 'integer', array('unsigned' => true));
        $table->column('status', 'boolean', array('unsigned' => true, 'limit' => 4));
        $table->column('sort_order', 'integer', array('unsigned' => true));
        
        $table->finish();

        // recurring_description
        $table = $this->create_table("{$this->prefix}recurring_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('recurring_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string');
        
        $table->finish();

        // return
        $table = $this->create_table("{$this->prefix}return", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('return_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('order_id', 'integer', array('unsigned' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('firstname', 'string', array('limit' => 32));
        $table->column('lastname', 'string', array('limit' => 32));
        $table->column('email', 'string', array('limit' => 96));
        $table->column('telephone', 'string', array('limit' => 32));
        $table->column('product', 'string');
        $table->column('model', 'string', array('limit' => 64));
        $table->column('quantity', 'integer', array('unsigned' => true, 'limit' => 4));
        $table->column('opened', 'boolean', array('unsigned' => true));
        $table->column('return_reason_id', 'integer', array('unsigned' => true));
        $table->column('return_action_id', 'integer', array('unsigned' => true));
        $table->column('return_status_id', 'integer', array('unsigned' => true));
        $table->column('comment', 'text', array('null' => true));
        $table->column('date_ordered', 'date');
        $table->column('date_added', 'datetime');
        $table->column('date_modified', 'datetime');
        
        $table->finish();

        // return_action
        $table = $this->create_table("{$this->prefix}return_action", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('return_action_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 64));

        $table->finish();

        // return_history
        $table = $this->create_table("{$this->prefix}return_history", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('return_history_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('return_id', 'integer', array('unsigned' => true));
        $table->column('return_status_id', 'integer', array('unsigned' => true));
        $table->column('notify', 'boolean', array('unsigned' => true));
        $table->column('comment', 'text');
        $table->column('date_added', 'datetime');
        
        $table->finish();

        // return_reason
        $table = $this->create_table("{$this->prefix}return_reason", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('return_reason_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 128));

        $table->finish();

        // return_status
        $table = $this->create_table("{$this->prefix}return_status", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('return_status_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 32));
        
        $table->finish();

        // review
        $table = $this->create_table("{$this->prefix}review", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('review_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('product_id', 'integer', array('unsigned' => true));
        $table->column('customer_id', 'integer', array('unsigned' => true));
        $table->column('author', 'string', array('limit' => 64));
        $table->column('text', 'text');
        $table->column('rating', 'integer', array('unsigned' => true, 'limit' => 1));
        $table->column('status', 'boolean', array('unsigned' => true));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // route
        $table = $this->create_table("{$this->prefix}route", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('route_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('route', 'string', array('primary_key' => true, 'limit' => 55));
        $table->column('query', 'string');
        $table->column('slug', 'string', array('primary_key' => true));
        
        $table->finish();

        // setting
        $table = $this->create_table("{$this->prefix}setting", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('setting_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('store_id', 'integer', array('unsigned' => true));
        $table->column('section', 'string', array('limit' => 32));
        $table->column('item', 'string', array('limit' => 64));
        $table->column('data', 'text');
        $table->column('serialized', 'boolean', array('unsigned' => true));
        
        $table->finish();

        // stock_status
        $table = $this->create_table("{$this->prefix}stock_status", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('stock_status_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string', array('limit' => 32));
        
        $table->finish();

        // store
        $table = $this->create_table("{$this->prefix}store", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('store_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 64));
        $table->column('url', 'string');
        $table->column('ssl', 'string');
        
        $table->finish();

        // tag
        $table = $this->create_table("{$this->prefix}tag", array(
            'id'      => false, 
            'options' => 'Engine=' . SERVER_VERSION
        ));

        $table->column('tag_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('section', 'string', array('limit' => 55));
        $table->column('element_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('tag', 'string', array('limit' => 128));
        
        $table->finish();

        // tax_class
        $table = $this->create_table("{$this->prefix}tax_class", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('tax_class_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('title', 'string', array('limit' => 32));
        $table->column('description', 'string');
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // tax_rate
        $table = $this->create_table("{$this->prefix}tax_rate", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('tax_rate_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('geo_zone_id', 'integer', array('unsigned' => true));
        $table->column('name', 'string', array('limit' => 32));
        $table->column('rate', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 4, 'default' => '0.0000'));
        $table->column('type', 'char', array('limit' => 1));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // tax_rate_to_customer_group
        $table = $this->create_table("{$this->prefix}tax_rate_to_customer_group", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('tax_rate_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('customer_group_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        
        $table->finish();

        // tax_rule
        $table = $this->create_table("{$this->prefix}tax_rule", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('tax_rule_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('tax_class_id', 'integer', array('unsigned' => true));
        $table->column('tax_rate_id', 'integer', array('unsigned' => true));
        $table->column('based', 'string', array('limit' => 10));
        $table->column('priority', 'integer', array('unsigned' => true, 'limit' => 5, 'default' => 1));
        
        $table->finish();

        // user
        $table = $this->create_table("{$this->prefix}user", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('user_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('user_group_id', 'integer', array('unsigned' => true));
        $table->column('user_name', 'string', array('limit' => 20));
        $table->column('password', 'string', array('limit' => 40));
        $table->column('salt', 'string', array('limit' => 9));
        $table->column('firstname', 'string', array('limit' => 32));
        $table->column('lastname', 'string', array('limit' => 32));
        $table->column('email', 'string', array('limit' => 96));
        $table->column('code', 'string', array('limit' => 40));
        $table->column('ip', 'string', array('limit' => 40));
        $table->column('status', 'boolean', array('unsigned' => true));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('last_access', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // user_group
        $table = $this->create_table("{$this->prefix}user_group", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('user_group_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 64));
        $table->column('permission', 'text');
        
        $table->finish();

        // vanity_route
        $table = $this->create_table("{$this->prefix}vanity_route", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('route_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('route', 'string', array('primary_key' => true, 'limit' => 55));
        $table->column('query', 'string');
        $table->column('slug', 'string', array('primary_key' => true));
        
        $table->finish();

        // weight_class
        $table = $this->create_table("{$this->prefix}weight_class", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('weight_class_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('value', 'decimal', array('unsigned' => true, 'precision' => 15, 'scale' => 8, 'default' => '0.00000000'));
        
        $table->finish();

        // weight_class_description
        $table = $this->create_table("{$this->prefix}weight_class_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('weight_class_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('title', 'string', array('limit' => 32));
        $table->column('unit', 'string', array('limit' => 4));
        
        $table->finish();

        // zone
        $table = $this->create_table("{$this->prefix}zone", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('zone_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('country_id', 'integer', array('unsigned' => true));
        $table->column('name', 'string', array('limit' => 128));
        $table->column('code', 'string', array('limit' => 32));
        $table->column('status', 'boolean', array('unsigned' => true, 'default' => 1));
        
        $table->finish();

        // zone_to_geo_zone
        $table = $this->create_table("{$this->prefix}zone_to_geo_zone", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('zone_to_geo_zone_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('country_id', 'integer', array('unsigned' => true));
        $table->column('zone_id', 'integer', array('unsigned' => true));
        $table->column('geo_zone_id', 'integer', array('unsigned' => true));
        $table->column('date_added', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->column('date_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        
        $table->finish();

        // add indexes
        $this->add_index("{$this->prefix}address", "customer_id", array('name' => 'customer_id_idx'));
        $this->add_index("{$this->prefix}blog_category_description", "name", array('name' => 'name_idx'));
        $this->add_index("{$this->prefix}blog_comment", "post_id", array('name' => 'post_id_idx'));
        $this->add_index("{$this->prefix}blog_post_description", "name", array('name' => 'name_idx'));
        $this->add_index("{$this->prefix}blog_post_description", "description", array('name' => 'description_idx', 'fulltext' => true));
        $this->add_index("{$this->prefix}category_description", "name", array('name' => 'name_idx'));
        $this->add_index("{$this->prefix}category_description", "description", array('name' => 'description_idx', 'fulltext' => true));
        $this->add_index("{$this->prefix}customer_ban_ip", "ip", array('name' => 'ip_idx'));
        $this->add_index("{$this->prefix}customer_inbox", "customer_id", array('name' => 'customer_id_idx'));
        $this->add_index("{$this->prefix}customer_ip", "ip", array('name' => 'ip_idx'));
        $this->add_index("{$this->prefix}language", "name", array('name' => 'name_idx'));
        $this->add_index("{$this->prefix}order_total", "order_id", array('name' => 'order_id_idx'));
        $this->add_index("{$this->prefix}product_description", "name", array('name' => 'name_idx'));
        $this->add_index("{$this->prefix}product_description", "description", array('name' => 'description_idx', 'fulltext' => true));
        $this->add_index("{$this->prefix}product_special", "product_id", array('name' => 'product_id_idx'));
        $this->add_index("{$this->prefix}review", "product_id", array('name' => 'product_id_idx'));
        $this->add_index("{$this->prefix}tag", "tag", array('name' => 'tag_idx', 'fulltext' => true));
    }

    public function down() {
        $this->drop_table("{$this->prefix}address");
        $this->drop_table("{$this->prefix}affiliate_route");
        $this->drop_table("{$this->prefix}attribute");
        $this->drop_table("{$this->prefix}attribute_description");
        $this->drop_table("{$this->prefix}attribute_group");
        $this->drop_table("{$this->prefix}attribute_group_description");
        $this->drop_table("{$this->prefix}banner");
        $this->drop_table("{$this->prefix}banner_image");
        $this->drop_table("{$this->prefix}banner_image_description");
        $this->drop_table("{$this->prefix}blog_category");
        $this->drop_table("{$this->prefix}blog_category_description");
        $this->drop_table("{$this->prefix}blog_category_to_layout");
        $this->drop_table("{$this->prefix}blog_category_to_store");
        $this->drop_table("{$this->prefix}blog_comment");
        $this->drop_table("{$this->prefix}blog_post");
        $this->drop_table("{$this->prefix}blog_post_description");
        $this->drop_table("{$this->prefix}blog_post_image");
        $this->drop_table("{$this->prefix}blog_post_related");
        $this->drop_table("{$this->prefix}blog_post_to_category");
        $this->drop_table("{$this->prefix}blog_post_to_layout");
        $this->drop_table("{$this->prefix}blog_post_to_store");
        $this->drop_table("{$this->prefix}category");
        $this->drop_table("{$this->prefix}category_description");
        $this->drop_table("{$this->prefix}category_filter");
        $this->drop_table("{$this->prefix}category_path");
        $this->drop_table("{$this->prefix}category_to_layout");
        $this->drop_table("{$this->prefix}category_to_store");
        $this->drop_table("{$this->prefix}country");
        $this->drop_table("{$this->prefix}coupon");
        $this->drop_table("{$this->prefix}coupon_category");
        $this->drop_table("{$this->prefix}coupon_history");
        $this->drop_table("{$this->prefix}coupon_product");
        $this->drop_table("{$this->prefix}currency");
        $this->drop_table("{$this->prefix}customer");
        $this->drop_table("{$this->prefix}customer_ban_ip");
        $this->drop_table("{$this->prefix}customer_commission");
        $this->drop_table("{$this->prefix}customer_credit");
        $this->drop_table("{$this->prefix}customer_group");
        $this->drop_table("{$this->prefix}customer_group_description");
        $this->drop_table("{$this->prefix}customer_history");
        $this->drop_table("{$this->prefix}customer_inbox");
        $this->drop_table("{$this->prefix}customer_ip");
        $this->drop_table("{$this->prefix}customer_notification");
        $this->drop_table("{$this->prefix}customer_online");
        $this->drop_table("{$this->prefix}customer_reward");
        $this->drop_table("{$this->prefix}download");
        $this->drop_table("{$this->prefix}download_description");
        $this->drop_table("{$this->prefix}email");
        $this->drop_table("{$this->prefix}email_content");
        $this->drop_table("{$this->prefix}event");
        $this->drop_table("{$this->prefix}event_manager");
        $this->drop_table("{$this->prefix}event_wait_list");
        $this->drop_table("{$this->prefix}filter");
        $this->drop_table("{$this->prefix}filter_description");
        $this->drop_table("{$this->prefix}filter_group");
        $this->drop_table("{$this->prefix}filter_group_description");
        $this->drop_table("{$this->prefix}geo_zone");
        $this->drop_table("{$this->prefix}gift_card");
        $this->drop_table("{$this->prefix}gift_card_history");
        $this->drop_table("{$this->prefix}gift_card_theme");
        $this->drop_table("{$this->prefix}gift_card_theme_description");
        $this->drop_table("{$this->prefix}hook");
        $this->drop_table("{$this->prefix}language");
        $this->drop_table("{$this->prefix}layout");
        $this->drop_table("{$this->prefix}layout_route");
        $this->drop_table("{$this->prefix}length_class");
        $this->drop_table("{$this->prefix}length_class_description");
        $this->drop_table("{$this->prefix}manufacturer");
        $this->drop_table("{$this->prefix}manufacturer_to_store");
        $this->drop_table("{$this->prefix}menu");
        $this->drop_table("{$this->prefix}module");
        $this->drop_table("{$this->prefix}notification_queue");
        $this->drop_table("{$this->prefix}option");
        $this->drop_table("{$this->prefix}option_description");
        $this->drop_table("{$this->prefix}option_value");
        $this->drop_table("{$this->prefix}option_value_description");
        $this->drop_table("{$this->prefix}order");
        $this->drop_table("{$this->prefix}order_download");
        $this->drop_table("{$this->prefix}order_fraud");
        $this->drop_table("{$this->prefix}order_gift_card");
        $this->drop_table("{$this->prefix}order_history");
        $this->drop_table("{$this->prefix}order_option");
        $this->drop_table("{$this->prefix}order_product");
        $this->drop_table("{$this->prefix}order_recurring");
        $this->drop_table("{$this->prefix}order_recurring_transaction");
        $this->drop_table("{$this->prefix}order_status");
        $this->drop_table("{$this->prefix}order_total");
        $this->drop_table("{$this->prefix}page");
        $this->drop_table("{$this->prefix}page_description");
        $this->drop_table("{$this->prefix}page_to_layout");
        $this->drop_table("{$this->prefix}page_to_store");
        $this->drop_table("{$this->prefix}paypal_order");
        $this->drop_table("{$this->prefix}paypal_order_transaction");
        $this->drop_table("{$this->prefix}presenter");
        $this->drop_table("{$this->prefix}product");
        $this->drop_table("{$this->prefix}product_attribute");
        $this->drop_table("{$this->prefix}product_description");
        $this->drop_table("{$this->prefix}product_discount");
        $this->drop_table("{$this->prefix}product_filter");
        $this->drop_table("{$this->prefix}product_image");
        $this->drop_table("{$this->prefix}product_option");
        $this->drop_table("{$this->prefix}product_option_value");
        $this->drop_table("{$this->prefix}product_recurring");
        $this->drop_table("{$this->prefix}product_related");
        $this->drop_table("{$this->prefix}product_reward");
        $this->drop_table("{$this->prefix}product_special");
        $this->drop_table("{$this->prefix}product_to_category");
        $this->drop_table("{$this->prefix}product_to_download");
        $this->drop_table("{$this->prefix}product_to_layout");
        $this->drop_table("{$this->prefix}product_to_store");
        $this->drop_table("{$this->prefix}recurring");
        $this->drop_table("{$this->prefix}recurring_description");
        $this->drop_table("{$this->prefix}return");
        $this->drop_table("{$this->prefix}return_action");
        $this->drop_table("{$this->prefix}return_history");
        $this->drop_table("{$this->prefix}return_reason");
        $this->drop_table("{$this->prefix}return_status");
        $this->drop_table("{$this->prefix}review");
        $this->drop_table("{$this->prefix}route");
        $this->drop_table("{$this->prefix}setting");
        $this->drop_table("{$this->prefix}stock_status");
        $this->drop_table("{$this->prefix}store");
        $this->drop_table("{$this->prefix}tag");
        $this->drop_table("{$this->prefix}tax_class");
        $this->drop_table("{$this->prefix}tax_rate");
        $this->drop_table("{$this->prefix}tax_rate_to_customer_group");
        $this->drop_table("{$this->prefix}tax_rule");
        $this->drop_table("{$this->prefix}user");
        $this->drop_table("{$this->prefix}user_group");
        $this->drop_table("{$this->prefix}vanity_route");
        $this->drop_table("{$this->prefix}weight_class");
        $this->drop_table("{$this->prefix}weight_class_description");
        $this->drop_table("{$this->prefix}zone");
        $this->drop_table("{$this->prefix}zone_to_geo_zone");
    }
}
