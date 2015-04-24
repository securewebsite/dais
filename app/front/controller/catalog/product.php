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
use Front\Controller\Tool\Captcha;

class Product extends Controller {
    
    public function index() {
        $data = $this->theme->language('catalog/product');
        
        $this->theme->model('catalog/category');
        
        $this->javascript->register('ajaxupload.min', 'bootstrap.min')
            ->register('datetimepicker.min', 'bootstrap.min')
            ->register('gallery.min', 'bootstrap.min');
        
        if (isset($this->request->get['path'])) {
            $path = '';
            
            $parts = explode('_', (string)$this->request->get['path']);
            
            $category_id = (int)array_pop($parts);
            
            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path.= '_' . $path_id;
                }
                
                $category_info = $this->model_catalog_category->getCategory($path_id);
                
                if ($category_info) {
                    $this->breadcrumb->add($category_info['name'], 'catalog/category', 'path=' . $path);
                }
            }
            
            // Set the last category breadcrumb
            $category_info = $this->model_catalog_category->getCategory($category_id);
            
            if ($category_info) {
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
                
                $this->breadcrumb->add($category_info['name'], 'catalog/category', 'path=' . $this->request->get['path'] . $url);
            }
        }
        
        $this->theme->model('catalog/manufacturer');
        
        if (isset($this->request->get['manufacturer_id'])) {
            $this->breadcrumb->add('lang_text_brand', 'catalog/manufacturer');
            
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
            
            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
            
            if ($manufacturer_info) {
                $this->breadcrumb->add($manufacturer_info['name'], 'catalog/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url);
            }
        }
        
        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . $this->request->get['search'];
            }
            
            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . $this->request->get['tag'];
            }
            
            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }
            
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
            
            $this->breadcrumb->add('lang_text_search', 'catalog/search', $url);
        }
        
        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }
        
        $data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
        $data['config_url']               = $this->config->get('config_url');
        $data['image_width']              = $this->config->get('config_image_related_width');
        
        $this->theme->model('catalog/product');
        
        $product_info = $this->model_catalog_product->getProduct($product_id);
        
        if ($product_info) {
            $url = '';
            
            if (isset($this->request->get['path'])) {
                $url.= '&path=' . $this->request->get['path'];
            }
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
            }
            
            if (isset($this->request->get['manufacturer_id'])) {
                $url.= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }
            
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . $this->request->get['search'];
            }
            
            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . $this->request->get['tag'];
            }
            
            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }
            
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
            
            $this->breadcrumb->add($product_info['name'], 'catalog/product', 'product_id=' . $this->request->get['product_id'] . $url);
            
            $this->theme->setTitle($product_info['name']);
            $this->theme->setDescription($product_info['meta_description']);
            $this->theme->setKeywords($product_info['meta_keyword']);
            $this->theme->setOgType('product');
            $this->theme->setOgDescription(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8'));
            
            $data['heading_title'] = $product_info['name'];
            
            $data['text_minimum'] = sprintf($this->language->get('lang_text_minimum'), $product_info['minimum']);
            
            $this->theme->model('catalog/review');
            
            $data['tab_review'] = sprintf($this->language->get('lang_tab_review'), $product_info['reviews']);
            
            $data['product_id']    = $this->request->get['product_id'];
            $data['manufacturer']  = $product_info['manufacturer'];
            $data['manufacturers'] = $this->url->link('catalog/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
            $data['model']         = $product_info['model'];
            $data['reward']        = $product_info['reward'];
            $data['points']        = $product_info['points'];
            
            if ($product_info['event_id'] > 0):
                $data['event_id']    = $product_info['event_id'];
                $data['unavailable'] = 0;
                $data['registered']  = 0;
                
                if ($this->customer->isLogged()):
                    $registered = $this->model_catalog_product->getRoster($product_info['event_id'], $this->customer->getId());
                    if ($registered):
                        $data['registered'] = 1;
                    endif;
                else:
                    $data['unavailable'] = 1;
                endif;
                
                $event_info = $this->model_catalog_product->getEvent($product_info['event_id']);
                
                $data['event_name']            = html_entity_decode($event_info['event_name'], ENT_QUOTES, 'UTF-8');
                $data['event_date']            = date($this->language->get('lang_date_format_short'), strtotime($event_info['date_time']));
                $data['event_time']            = date($this->language->get('lang_time_format'), strtotime($event_info['date_time']));
                $data['event_days']            = unserialize($event_info['event_days']);
                $data['event_length']          = $event_info['event_length'];
                $data['seats']                 = $event_info['seats'];
                $data['available']             = $event_info['seats'] - $event_info['filled'];
                
                $data['text_unavailable_info'] = '';
                $data['button_waitlist']       = '';
                $data['text_already_on']       = '';
                
                if ($data['available'] < 1):
                    $customer_waitlist = $this->model_catalog_product->checkWaitList($product_info['event_id'], $this->customer->getId());
                    
                    if (!$customer_waitlist):
                        $data['text_unavailable_info'] = sprintf($this->language->get('lang_text_unavailable_info'), $data['event_name']);
                        $data['button_waitlist'] = $this->language->get('lang_button_waitlist');
                    else:
                        $data['text_already_on'] = $this->language->get('lang_text_already_on');
                    endif;
                endif;
                
                if ($event_info['refundable']):
                    $data['refundable'] = $this->language->get('lang_text_yes');
                else:
                    $data['refundable'] = $this->language->get('lang_text_no');
                endif;
                
                $data['telephone']     = $event_info['telephone'];
                $data['location']      = nl2br($event_info['location']);
                $data['presenter']     = '';
                $data['presenter_bio'] = '';
                $data['tab_presenter'] = '';
                
                if ($event_info['presenter_id']):
                    $data['tab_presenter'] = !empty($event_info['presenter_tab']) ? $event_info['presenter_tab'] : $this->language->get('lang_tab_presenter');
                    $presenter             = $this->model_catalog_product->getPresenterName($event_info['presenter_id']);
                    $presenter_bio         = $this->model_catalog_product->getPresenterBio($event_info['presenter_id']);
                    $data['presenter']     = html_entity_decode($presenter, ENT_QUOTES, 'UTF-8');
                    $data['presenter_bio'] = html_entity_decode($presenter_bio, ENT_QUOTES, 'UTF-8');
                    if ($event_info['presenter_tab']):
                        $data['text_presenter_info'] = sprintf($this->language->get('lang_text_presenter_info'), $event_info['presenter_tab']);
                        $data['text_presenter']      = sprintf($this->language->get('lang_text_presenter'), $event_info['presenter_tab']);
                        $data['text_presenter_bio']  = sprintf($this->language->get('lang_text_presenter_bio'), $event_info['presenter_tab']);
                    else:
                        $data['text_presenter_info'] = sprintf($this->language->get('lang_text_presenter_info'), $this->language->get('lang_tab_presenter'));
                        $data['text_presenter']      = sprintf($this->language->get('lang_text_presenter'), $this->language->get('lang_tab_presenter'));
                        $data['text_presenter_bio']  = sprintf($this->language->get('lang_text_presenter_bio'), $this->language->get('lang_tab_presenter'));
                    endif;
                endif;
            endif;
            
            if ($product_info['quantity'] <= 0) {
                $data['stock'] = $product_info['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $data['stock'] = $product_info['quantity'];
            } else {
                $data['stock'] = $this->language->get('lang_text_instock');
            }
            
            $this->theme->model('tool/image');
            
            if ($product_info['image']) {
                $data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                $this->theme->setOgImage($this->model_tool_image->resize($product_info['image'], 600, 600, 'h'));
            } else {
                $data['popup'] = 'placeholder.png';
            }
            
            if ($product_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));
            } else {
                $data['thumb'] = 'placeholder.png';
            }
            
            $data['images'] = array();
            
            $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
            
            foreach ($results as $result) {
                $data['images'][] = array('popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')), 'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height')));
            }
            
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                $data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $data['price'] = false;
            }
            
            if ((float)$product_info['special']) {
                $data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
            } else {
                $data['special'] = false;
            }
            
            if ($this->config->get('config_tax')) {
                $data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
            } else {
                $data['tax'] = false;
            }
            
            $discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
            
            $data['discounts'] = array();
            
            foreach ($discounts as $discount) {
                $data['discounts'][] = array('quantity' => $discount['quantity'], 'price' => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))));
            }
            
            $data['options'] = array();
            
            foreach ($this->model_catalog_product->getProductOptions($this->request->get['product_id']) as $option) {
                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                    $option_value_data = array();
                    
                    foreach ($option['option_value'] as $option_value) {
                        if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                            if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                                $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                            } else {
                                $price = false;
                            }
                            
                            $option_value_data[] = array('product_option_value_id' => $option_value['product_option_value_id'], 'option_value_id' => $option_value['option_value_id'], 'name' => $option_value['name'], 'image' => $this->model_tool_image->resize($option_value['image'], 50, 50), 'price' => $price, 'price_prefix' => $option_value['price_prefix']);
                        }
                    }
                    
                    $data['options'][] = array('product_option_id' => $option['product_option_id'], 'option_id' => $option['option_id'], 'name' => $option['name'], 'type' => $option['type'], 'option_value' => $option_value_data, 'required' => $option['required']);
                } elseif ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                    $data['options'][] = array('product_option_id' => $option['product_option_id'], 'option_id' => $option['option_id'], 'name' => $option['name'], 'type' => $option['type'], 'option_value' => $option['option_value'], 'required' => $option['required']);
                }
            }
            
            if ($product_info['minimum']) {
                $data['minimum'] = $product_info['minimum'];
            } else {
                $data['minimum'] = 1;
            }
            
            $data['review_allowed'] = false;
            
            if ($this->config->get('config_review_status')):
                if ($this->customer->isLogged()):
                    $data['review_allowed'] = true;
                else:
                    if ($this->config->get('config_review_logged')):
                        $data['review_allowed'] = true;
                    endif;
                endif;
            endif;
            
            $data['review_status']    = $this->config->get('config_review_status');
            $data['reviews']          = sprintf($this->language->get('lang_text_reviews'), (int)$product_info['reviews']);
            $data['rating']           = (int)$product_info['rating'];
            $data['description']      = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
            $data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
            
            $data['products'] = array();
            
            $results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
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
                    $rating = (int)$result['rating'];
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
                    'reviews'    => sprintf($this->language->get('lang_text_reviews'), (int)$result['reviews']), 
                    'href'       => $this->url->link('catalog/product', 'product_id=' . $result['product_id'])
                );
            }
            
            $data['tags'] = false;
            
            if (!empty($product_info['tag'])):
                $tags = explode(',', $product_info['tag']);
                
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => $this->url->link('search/tag', 'tag=' . trim($tag))
                    );
                endforeach;
            endif;
            
            $data['social_href'] = $this->url->link('catalog/product', 'product_id=' . $product_info['product_id']);
            $data['social_desc'] = urlencode($product_info['name'] . "\n" . substr(strip_tags($data['description']), 0, 500) . "...");
            $data['social_buff'] = urlencode(substr(str_replace("\t", "", strip_tags($product_info['description'])), 0, 500) . " ... " . "\n" . $product_info['name']);
            $data['social_site'] = $this->config->get('config_name');
            
            $data['recurrings'] = $this->model_catalog_product->getAllRecurring($product_info['product_id']);
            
            $this->model_catalog_product->updateViewed($this->request->get['product_id']);
            
            $this->theme->loadjs('javascript/catalog/product', $data);
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $this->theme->set_controller('header', 'shop/header');
            $this->theme->set_controller('footer', 'shop/footer');
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('catalog/product', $data));
        } else {
            $url = '';
            
            if (isset($this->request->get['path'])) {
                $url.= '&path=' . $this->request->get['path'];
            }
            
            if (isset($this->request->get['filter'])) {
                $url.= '&filter=' . $this->request->get['filter'];
            }
            
            if (isset($this->request->get['manufacturer_id'])) {
                $url.= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }
            
            if (isset($this->request->get['search'])) {
                $url.= '&search=' . $this->request->get['search'];
            }
            
            if (isset($this->request->get['tag'])) {
                $url.= '&tag=' . $this->request->get['tag'];
            }
            
            if (isset($this->request->get['description'])) {
                $url.= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url.= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url.= '&sub_category=' . $this->request->get['sub_category'];
            }
            
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
            
            $this->breadcrumb->add('lang_text_error', 'catalog/product', 'product_id=' . $product_id . $url);
            
            $this->theme->setTitle($this->language->get('lang_text_error'));
            
            $data['heading_title'] = $this->language->get('lang_text_error');
            
            $data['continue'] = $this->url->link('shop/home');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            
            $this->theme->set_controller('header', 'shop/header');
            $this->theme->set_controller('footer', 'shop/footer');
            
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('error/notfound', $data));
        }
    }
    
    public function join_wait_list() {
        $json = array();
        
        $this->theme->language('catalog/product');
        $this->theme->model('catalog/product');
        
        $results = $this->model_catalog_product->joinWaitList($this->request->post['event_id'], $this->customer->getId());
        
        if ($results) {
            $message = '<div class="alert alert-success">' . $this->language->get('lang_text_join_success') . '</div>';
        } else {
            $message = '<div class="alert alert-success">' . $this->language->get('lang_text_join_failed') . '</div>';
        }
        
        $json = array('success' => $results, 'message' => $message);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function review() {
        $data = $this->theme->language('catalog/product');
        
        $this->theme->model('catalog/review');
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        
        $data['reviews'] = array();
        
        $review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
        
        $results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
        
        foreach ($results as $result) {
            $data['reviews'][] = array('author' => $result['author'], 'text' => $result['text'], 'rating' => (int)$result['rating'], 'reviews' => sprintf($this->language->get('lang_text_reviews'), (int)$review_total), 'date_added' => date($this->language->get('lang_date_format_short'), strtotime($result['date_added'])));
        }
        
        $data['pagination'] = $this->theme->paginate($review_total, $page, 5, $this->language->get('lang_text_pagination'), $this->url->link('catalog/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}'));
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $this->response->setOutput($this->theme->view('catalog/review', $data));
    }
    
    public function getRecurringDescription() {
        $this->theme->language('catalog/product');
        $this->theme->model('catalog/product');
        
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        if (isset($this->request->post['recurring_id'])) {
            $recurring_id = $this->request->post['recurring_id'];
        } else {
            $recurring_id = 0;
        }
        
        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }
        
        $product_info   = $this->model_catalog_product->getProduct($product_id);
        $recurring_info = $this->model_catalog_product->getRecurring($product_id, $recurring_id);
        
        $json = array();
        
        if ($product_info && $recurring_info) {
            
            if (!$json) {
                $frequencies = array('day' => $this->language->get('lang_text_day'), 'week' => $this->language->get('lang_text_week'), 'semi_month' => $this->language->get('lang_text_semi_month'), 'month' => $this->language->get('lang_text_month'), 'year' => $this->language->get('lang_text_year'),);
                
                if ($recurring_info['trial_status'] == 1) {
                    $price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
                    $trial_text = sprintf($this->language->get('lang_text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }
                
                $price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')));
                
                if ($recurring_info['duration']) {
                    $text = $trial_text . sprintf($this->language->get('lang_text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                } else {
                    $text = $trial_text . sprintf($this->language->get('lang_text_payment_until_canceled_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                }
                
                $json['success'] = $text;
            }
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function write() {
        $this->theme->language('catalog/product');
        $this->theme->model('catalog/review');
        
        $json = array();
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (($this->encode->strlen($this->request->post['name']) < 3) || ($this->encode->strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('lang_error_name');
            }
            
            if (($this->encode->strlen($this->request->post['text']) < 25) || ($this->encode->strlen($this->request->post['text']) > 1000)) {
                $json['error'] = $this->language->get('lang_error_text');
            }
            
            if (empty($this->request->post['rating'])) {
                $json['error'] = $this->language->get('lang_error_rating');
            }
            
            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
                $json['error'] = $this->language->get('lang_error_captcha');
            }
            
            if (!isset($json['error'])) {
                unset($this->session->data['captcha']);
                
                $this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);
                
                $json['success'] = $this->language->get('lang_text_success');
            }
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function captcha() {
        $captcha = new Captcha();
        
        $this->session->data['captcha'] = $captcha->getCode();
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
        
        $captcha->showImage();
    }
    
    public function upload() {
        $this->theme->language('catalog/product');
        
        $json = array();
        
        if (!empty($this->request->files['file']['name'])) {
            $filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
            
            if (($this->encode->strlen($filename) < 3) || ($this->encode->strlen($filename) > 64)) {
                $json['error'] = $this->language->get('lang_error_filename');
            }
            
            // Allowed file extension types
            $allowed = array();
            
            $filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", $this->config->get('config_file_extension_allowed')));
            
            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }
            
            if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
                $json['error'] = $this->language->get('lang_error_filetype');
            }
            
            // Allowed file mime types
            $allowed = array();
            
            $filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", $this->config->get('config_file_mime_allowed')));
            
            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }
            
            if (!in_array($this->request->files['file']['type'], $allowed)) {
                $json['error'] = $this->language->get('lang_error_filetype');
            }
            
            // Check to see if any PHP files are trying to be uploaded
            $content = file_get_contents($this->request->files['file']['tmp_name']);
            
            if (preg_match('/\<\?php/i', $content)) {
                $json['error'] = $this->language->get('lang_error_filetype');
            }
            
            if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
                $json['error'] = $this->language->get('lang_error_upload_' . $this->request->files['file']['error']);
            }
        } else {
            $json['error'] = $this->language->get('lang_error_upload');
        }
        
        if (!$json && is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
            $file = basename($filename) . '.' . md5(mt_rand());
            
            // Hide the uploaded file name so people can not link to it directly.
            $json['file'] = $this->encryption->encrypt($file);
            
            move_uploaded_file($this->request->files['file']['tmp_name'], $this->app['path.download'] . $file);
            
            $json['success'] = $this->language->get('lang_text_upload');
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
}
