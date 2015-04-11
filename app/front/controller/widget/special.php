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

namespace Front\Controller\Widget;
use Dais\Engine\Controller;

class Special extends Controller {
    public function index($setting) {
        $data = $this->theme->language('widget/special');
        
        $this->theme->model('catalog/product');
        
        $this->theme->model('tool/image');
        
        $data['products'] = array();
        
        $filter = array('sort' => 'pd.name', 'order' => 'ASC', 'start' => 0, 'limit' => $setting['limit']);
        
        $results = $this->model_catalog_product->getProductSpecials($filter);
        
        foreach ($results as $result) {
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']);
            } else {
                $image = false;
            }
            
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $price = false;
            }
            
            if ((float)$result['special']) {
                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $special = false;
            }
            
            if ($this->config->get('config_review_status')) {
                $rating = $result['rating'];
            } else {
                $rating = false;
            }
            
            $data['products'][] = array('product_id' => $result['product_id'], 'event_id' => $result['event_id'], 'thumb' => $image, 'name' => $result['name'], 'price' => $price, 'special' => $special, 'rating' => $rating, 'reviews' => sprintf($this->language->get('lang_text_reviews'), (int)$result['reviews']), 'href' => $this->url->link('catalog/product', 'product_id=' . $result['product_id']));
        }
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/special', $data);
    }
}
