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

namespace App\Controllers\Front\Account;

use App\Controllers\Controller;

class Product extends Controller {
    
    public function index() {
        if (!Customer::isLogged()) {
            Session::p()->data['redirect'] = Url::link('account/product', '', 'SSL');
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/product');
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_dashboard', 'account/dashboard', '', true, 'SSL');
        Breadcrumb::add('lang_heading_title', 'account/product', '', true, 'SSL');
        
        $products = Customer::getCustomerProducts();
        
        $results = array();
        
        if (!empty($products)):
            Theme::model('account/product');
            foreach ($products as $product):
                $results[] = AccountProduct::getProduct($product['product_id'], Customer::getId());
            endforeach;
        else:
            return Response::redirect(Url::link('account/dashboard', '', 'SSL'));
        endif;
        
        Theme::model('tool/image');
        
        $data['products'] = array();
        
        foreach ($results as $result) {
            if ($result['image']) {
                $image = ToolImage::resize($result['image'], Config::get('config_image_product_width'), Config::get('config_image_product_height'));
            } else {
                $image = false;
            }
            
            if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                $price = Currency::format(Tax::calculate($result['price'], $result['tax_class_id'], Config::get('config_tax')));
            } else {
                $price = false;
            }
            
            if ((float)$result['special']) {
                $special = Currency::format(Tax::calculate($result['special'], $result['tax_class_id'], Config::get('config_tax')));
            } else {
                $special = false;
            }
            
            if (Config::get('config_tax')) {
                $tax = Currency::format((float)$result['special'] ? $result['special'] : $result['price']);
            } else {
                $tax = false;
            }
            
            if (Config::get('config_review_status')) {
                $rating = (int)$result['rating'];
            } else {
                $rating = false;
            }
            
            $data['products'][] = array('product_id' => $result['product_id'], 'event_id' => $result['event_id'], 'thumb' => $image, 'name' => $result['name'], 'description' => Encode::substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..', 'price' => $price, 'special' => $special, 'tax' => $tax, 'rating' => $rating, 'reviews' => sprintf(Lang::get('lang_text_reviews'), (int)$result['reviews']), 'href' => Url::link('catalog/product', 'product_id=' . $result['product_id']));
        }
        
        $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/customer_product', $data));
    }
}
