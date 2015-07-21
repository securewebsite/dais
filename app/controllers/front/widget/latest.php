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

namespace App\Controllers\Front\Widget;

use App\Controllers\Controller;

class Latest extends Controller {
    
    public function index($setting) {
        $data = Theme::language('widget/latest');
        
        Theme::model('catalog/product');
        
        Theme::model('tool/image');
        
        $data['products'] = array();
        
        $filter = array('sort' => 'p.date_added', 'order' => 'desc', 'start' => 0, 'limit' => $setting['limit']);
        
        $results = CatalogProduct::getProducts($filter);
        
        foreach ($results as $result) {
            if ($result['image']) {
                $image = ToolImage::resize($result['image'], $setting['image_width'], $setting['image_height']);
            } else {
                $image = false;
            }
            
            if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                $price = \Currency::format(Tax::calculate($result['price'], $result['tax_class_id'], Config::get('config_tax')));
            } else {
                $price = false;
            }
            
            if ((float)$result['special']) {
                $special = \Currency::format(Tax::calculate($result['special'], $result['tax_class_id'], Config::get('config_tax')));
            } else {
                $special = false;
            }
            
            if (Config::get('config_review_status')) {
                $rating = $result['rating'];
            } else {
                $rating = false;
            }
            
            $data['products'][] = array(
                'product_id' => $result['product_id'], 
                'event_id'   => $result['event_id'], 
                'thumb'      => $image, 
                'name'       => $result['name'], 
                'price'      => $price, 
                'special'    => $special, 
                'rating'     => $rating, 
                'reviews'    => sprintf(Lang::get('lang_text_reviews'), (int)$result['reviews']), 
                'href'       => Url::link('catalog/product', 'path=' . $result['paths'] . '&product_id=' . $result['product_id'])
            );
        }
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::make('widget/latest', $data);
    }
}
