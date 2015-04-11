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

namespace Front\Controller\Catalog;
use Dais\Engine\Controller;

class Special extends Controller {
    public function index() {
        $data = $this->theme->language('catalog/special');
        
        $this->theme->model('catalog/product');
        $this->theme->model('tool/image');
        
        $this->javascript->register('storage.min', 'jquery.min');
        
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }
        
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_catalog_limit');
        }
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['page'])) {
            $url.= '&page=' . $this->request->get['page'];
        }
        
        if (isset($this->request->get['limit'])) {
            $url.= '&limit=' . $this->request->get['limit'];
        }
        
        $this->breadcrumb->add('lang_heading_title', 'catalog/special', $url);
        
        $data['text_compare'] = sprintf($this->language->get('lang_text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
        
        $data['compare'] = $this->url->link('catalog/compare');
        
        $data['image_width'] = $this->config->get('config_image_product_width');
        
        $data['products'] = array();
        
        $filter = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit);
        
        $product_total = $this->model_catalog_product->getTotalProductSpecials($filter);
        
        $results = $this->model_catalog_product->getProductSpecials($filter);
        
        foreach ($results as $result) {
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
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
            
            if ($this->config->get('config_tax')) {
                $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
            } else {
                $tax = false;
            }
            
            if ($this->config->get('config_review_status')) {
                $rating = (int)$result['rating'];
            } else {
                $rating = false;
            }
            
            $data['products'][] = array('product_id' => $result['product_id'], 'event_id' => $result['event_id'], 'thumb' => $image, 'name' => $result['name'], 'description' => $this->encode->substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..', 'price' => $price, 'special' => $special, 'tax' => $tax, 'rating' => $rating, 'reviews' => sprintf($this->language->get('lang_text_reviews'), (int)$result['reviews']), 'href' => $this->url->link('catalog/product', 'product_id=' . $result['product_id'] . $url));
        }
        
        $url = '';
        
        if (isset($this->request->get['limit'])) {
            $url.= '&limit=' . $this->request->get['limit'];
        }
        
        $data['sorts'] = array();
        
        $data['sorts'][] = array('text' => $this->language->get('lang_text_default'), 'value' => 'p.sort_order-ASC', 'href' => $this->url->link('catalog/special', 'sort=p.sort_order&order=ASC' . $url));
        
        $data['sorts'][] = array('text' => $this->language->get('lang_text_name_asc'), 'value' => 'pd.name-ASC', 'href' => $this->url->link('catalog/special', 'sort=pd.name&order=ASC' . $url));
        
        $data['sorts'][] = array('text' => $this->language->get('lang_text_name_desc'), 'value' => 'pd.name-DESC', 'href' => $this->url->link('catalog/special', 'sort=pd.name&order=DESC' . $url));
        
        $data['sorts'][] = array('text' => $this->language->get('lang_text_price_asc'), 'value' => 'ps.price-ASC', 'href' => $this->url->link('catalog/special', 'sort=ps.price&order=ASC' . $url));
        
        $data['sorts'][] = array('text' => $this->language->get('lang_text_price_desc'), 'value' => 'ps.price-DESC', 'href' => $this->url->link('catalog/special', 'sort=ps.price&order=DESC' . $url));
        
        if ($this->config->get('config_review_status')) {
            $data['sorts'][] = array('text' => $this->language->get('lang_text_rating_desc'), 'value' => 'rating-DESC', 'href' => $this->url->link('catalog/special', 'sort=rating&order=DESC' . $url));
            
            $data['sorts'][] = array('text' => $this->language->get('lang_text_rating_asc'), 'value' => 'rating-ASC', 'href' => $this->url->link('catalog/special', 'sort=rating&order=ASC' . $url));
        }
        
        $data['sorts'][] = array('text' => $this->language->get('lang_text_model_asc'), 'value' => 'p.model-ASC', 'href' => $this->url->link('catalog/special', 'sort=p.model&order=ASC' . $url));
        
        $data['sorts'][] = array('text' => $this->language->get('lang_text_model_desc'), 'value' => 'p.model-DESC', 'href' => $this->url->link('catalog/special', 'sort=p.model&order=DESC' . $url));
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        $data['limits'] = array();
        
        $limits = array_unique(array($this->config->get('config_catalog_limit'), 32, 64, 88, 112));
        
        sort($limits);
        
        foreach ($limits as $value) {
            $data['limits'][] = array('text' => $value, 'value' => $value, 'href' => $this->url->link('catalog/special', $url . '&limit=' . $value));
        }
        
        $url = '';
        
        if (isset($this->request->get['sort'])) {
            $url.= '&sort=' . $this->request->get['sort'];
        }
        
        if (isset($this->request->get['order'])) {
            $url.= '&order=' . $this->request->get['order'];
        }
        
        if (isset($this->request->get['limit'])) {
            $url.= '&limit=' . $this->request->get['limit'];
        }
        
        $data['pagination'] = $this->theme->paginate($product_total, $page, $limit, $this->language->get('lang_text_pagination'), $this->url->link('catalog/special', $url . '&page={page}'));
        
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['limit'] = $limit;
        
        $cookie = 'list';
        
        if (isset($this->request->cookie['display'])):
            $cookie = $this->request->cookie['display'];
        endif;
        
        $data['display'] = $cookie;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->theme->set_controller('header', 'shop/header');
        $this->theme->set_controller('footer', 'shop/footer');
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('catalog/special', $data));
    }
}
