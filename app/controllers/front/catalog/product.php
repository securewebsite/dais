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

namespace App\Controllers\Front\Catalog;

use App\Controllers\Controller;
use App\Controllers\Front\Tool\Captcha;

class Product extends Controller {
    
    public function index() {
        $data = Theme::language('catalog/product');
        
        Theme::model('catalog/category');
        
        JS::register('ajaxupload.min', 'bootstrap.min')
            ->register('datetimepicker.min', 'bootstrap.min')
            ->register('gallery.min', 'bootstrap.min');
        
        if (isset(Request::p()->get['path'])) {
            $path = '';
            
            $parts = explode('_', (string)Request::p()->get['path']);
            
            $category_id = (int)array_pop($parts);
            
            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path.= '_' . $path_id;
                }
                
                $category_info = CatalogCategory::getCategory($path_id);
                
                if ($category_info) {
                    Breadcrumb::add($category_info['name'], 'catalog/category', 'path=' . $path);
                }
            }
            
            // Set the last category breadcrumb
            $category_info = CatalogCategory::getCategory($category_id);
            
            if ($category_info) {
                $url = '';
                
                if (isset(Request::p()->get['sort'])) {
                    $url.= '&sort=' . Request::p()->get['sort'];
                }
                
                if (isset(Request::p()->get['order'])) {
                    $url.= '&order=' . Request::p()->get['order'];
                }
                
                if (isset(Request::p()->get['page'])) {
                    $url.= '&page=' . Request::p()->get['page'];
                }
                
                if (isset(Request::p()->get['limit'])) {
                    $url.= '&limit=' . Request::p()->get['limit'];
                }
                
                Breadcrumb::add($category_info['name'], 'catalog/category', 'path=' . Request::p()->get['path'] . $url);
            }
        }
        
        Theme::model('catalog/manufacturer');
        
        if (isset(Request::p()->get['manufacturer_id'])) {
            Breadcrumb::add('lang_text_brand', 'catalog/manufacturer');
            
            $url = '';
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            $manufacturer_info = CatalogManufacturer::getManufacturer(Request::p()->get['manufacturer_id']);
            
            if ($manufacturer_info) {
                Breadcrumb::add($manufacturer_info['name'], 'catalog/manufacturer/info', 'manufacturer_id=' . Request::p()->get['manufacturer_id'] . $url);
            }
        }
        
        if (isset(Request::p()->get['search']) || isset(Request::p()->get['tag'])) {
            $url = '';
            
            if (isset(Request::p()->get['search'])) {
                $url.= '&search=' . Request::p()->get['search'];
            }
            
            if (isset(Request::p()->get['tag'])) {
                $url.= '&tag=' . Request::p()->get['tag'];
            }
            
            if (isset(Request::p()->get['description'])) {
                $url.= '&description=' . Request::p()->get['description'];
            }
            
            if (isset(Request::p()->get['category_id'])) {
                $url.= '&category_id=' . Request::p()->get['category_id'];
            }
            
            if (isset(Request::p()->get['sub_category'])) {
                $url.= '&sub_category=' . Request::p()->get['sub_category'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            Breadcrumb::add('lang_text_search', 'catalog/search', $url);
        }
        
        if (isset(Request::p()->get['product_id'])) {
            $product_id = (int)Request::p()->get['product_id'];
        } else {
            $product_id = 0;
        }
        
        $data['config_image_thumb_width'] = Config::get('config_image_thumb_width');
        $data['config_url']               = Config::get('config_url');
        $data['image_width']              = Config::get('config_image_related_width');
        
        Theme::model('catalog/product');
        
        $product_info = CatalogProduct::getProduct($product_id);
        
        if ($product_info) {
            $url = '';
            
            if (isset(Request::p()->get['path'])) {
                $url.= '&path=' . Request::p()->get['path'];
            }
            
            if (isset(Request::p()->get['filter'])) {
                $url.= '&filter=' . Request::p()->get['filter'];
            }
            
            if (isset(Request::p()->get['manufacturer_id'])) {
                $url.= '&manufacturer_id=' . Request::p()->get['manufacturer_id'];
            }
            
            if (isset(Request::p()->get['search'])) {
                $url.= '&search=' . Request::p()->get['search'];
            }
            
            if (isset(Request::p()->get['tag'])) {
                $url.= '&tag=' . Request::p()->get['tag'];
            }
            
            if (isset(Request::p()->get['description'])) {
                $url.= '&description=' . Request::p()->get['description'];
            }
            
            if (isset(Request::p()->get['category_id'])) {
                $url.= '&category_id=' . Request::p()->get['category_id'];
            }
            
            if (isset(Request::p()->get['sub_category'])) {
                $url.= '&sub_category=' . Request::p()->get['sub_category'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            Breadcrumb::add($product_info['name'], 'catalog/product', 'product_id=' . Request::p()->get['product_id'] . $url);
            
            Theme::setTitle($product_info['name']);
            Theme::setDescription($product_info['meta_description']);
            Theme::setKeywords($product_info['meta_keyword']);
            Theme::setOgType('product');
            Theme::setOgDescription(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8'));
            
            $data['heading_title'] = $product_info['name'];
            
            $data['text_minimum'] = sprintf(Lang::get('lang_text_minimum'), $product_info['minimum']);
            
            Theme::model('catalog/review');
            
            $data['tab_review'] = sprintf(Lang::get('lang_tab_review'), $product_info['reviews']);
            
            $data['product_id']    = Request::p()->get['product_id'];
            $data['manufacturer']  = $product_info['manufacturer'];
            $data['manufacturers'] = Url::link('catalog/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
            $data['model']         = $product_info['model'];
            $data['reward']        = $product_info['reward'];
            $data['points']        = $product_info['points'];
            $data['paths']         = $product_info['paths'];
            
            if ($product_info['event_id'] > 0):
                $data['event_id']    = $product_info['event_id'];
                $data['unavailable'] = 0;
                $data['registered']  = 0;
                
                if (Customer::isLogged()):
                    $registered = CatalogProduct::getRoster($product_info['event_id'], Customer::getId());
                    if ($registered):
                        $data['registered'] = 1;
                    endif;
                else:
                    $data['unavailable'] = 1;
                endif;
                
                $event_info = CatalogProduct::getEvent($product_info['event_id']);
                
                $data['event_name']            = html_entity_decode($event_info['event_name'], ENT_QUOTES, 'UTF-8');
                $data['event_date']            = date(Lang::get('lang_date_format_short'), strtotime($event_info['date_time']));
                $data['event_time']            = date(Lang::get('lang_time_format'), strtotime($event_info['date_time']));
                $data['event_days']            = unserialize($event_info['event_days']);
                $data['event_length']          = $event_info['event_length'];
                $data['seats']                 = $event_info['seats'];
                $data['available']             = $event_info['seats'] - $event_info['filled'];

                if ($event_info['event_length'] == 1):
                    $plural = Lang::get('lang_text_event_hour');
                else:
                    $plural = Lang::get('lang_text_event_hours');
                endif;

                if (count($data['event_days']) > 1):
                    $data['event_length_text'] = sprintf(Lang::get('lang_text_event_each'), $plural);
                else:
                    $data['event_length_text'] = $plural;
                endif;
                
                $data['text_unavailable_info'] = '';
                $data['button_waitlist']       = '';
                $data['text_already_on']       = '';
                
                if ($data['available'] < 1):
                    $customer_waitlist = CatalogProduct::checkWaitList($product_info['event_id'], Customer::getId());
                    
                    if (!$customer_waitlist):
                        $data['text_unavailable_info'] = sprintf(Lang::get('lang_text_unavailable_info'), $data['event_name']);
                        $data['button_waitlist'] = Lang::get('lang_button_waitlist');
                    else:
                        $data['text_already_on'] = Lang::get('lang_text_already_on');
                    endif;
                endif;
                
                if ($event_info['refundable']):
                    $data['refundable'] = Lang::get('lang_text_yes');
                else:
                    $data['refundable'] = Lang::get('lang_text_no');
                endif;
                
                $data['telephone']     = $event_info['telephone'];
                
                /**
                 * If this is an online event, we should have an empty location,
                 * and a link should exist to the web event.
                 * We'll override any existing location with the link for the
                 * online event here.
                 */
                
                $data['online'] = false;
                
                if ($event_info['online']):
                    $data['online'] = true;
                    $data['location'] = $event_info['link'];
                else:
                    $data['location'] = ($event_info['location']) ? nl2br($event_info['location']) : false;
                endif;

                $data['presenter']     = '';
                $data['presenter_bio'] = '';
                $data['tab_presenter'] = '';
                
                if ($event_info['presenter_id']):
                    $data['tab_presenter'] = !empty($event_info['presenter_tab']) ? $event_info['presenter_tab'] : Lang::get('lang_tab_presenter');
                    $presenter             = CatalogProduct::getPresenterName($event_info['presenter_id']);
                    $presenter_bio         = CatalogProduct::getPresenterBio($event_info['presenter_id']);
                    $data['presenter']     = html_entity_decode($presenter, ENT_QUOTES, 'UTF-8');
                    $data['presenter_bio'] = html_entity_decode($presenter_bio, ENT_QUOTES, 'UTF-8');
                    if ($event_info['presenter_tab']):
                        $data['text_presenter_info'] = sprintf(Lang::get('lang_text_presenter_info'), $event_info['presenter_tab']);
                        $data['text_presenter']      = sprintf(Lang::get('lang_text_presenter'), $event_info['presenter_tab']);
                        $data['text_presenter_bio']  = sprintf(Lang::get('lang_text_presenter_bio'), $event_info['presenter_tab']);
                    else:
                        $data['text_presenter_info'] = sprintf(Lang::get('lang_text_presenter_info'), Lang::get('lang_tab_presenter'));
                        $data['text_presenter']      = sprintf(Lang::get('lang_text_presenter'), Lang::get('lang_tab_presenter'));
                        $data['text_presenter_bio']  = sprintf(Lang::get('lang_text_presenter_bio'), Lang::get('lang_tab_presenter'));
                    endif;
                endif;
            endif;
            
            if ($product_info['quantity'] <= 0) {
                $data['stock'] = $product_info['stock_status'];
            } elseif (Config::get('config_stock_display')) {
                $data['stock'] = $product_info['quantity'];
            } else {
                $data['stock'] = Lang::get('lang_text_instock');
            }
            
            Theme::model('tool/image');
            
            if ($product_info['image']) {
                $data['popup'] = ToolImage::resize($product_info['image'], Config::get('config_image_popup_width'), Config::get('config_image_popup_height'));
                Theme::setOgImage(ToolImage::resize($product_info['image'], 600, 600, 'h'));
            } else {
                $data['popup'] = 'placeholder.png';
            }
            
            if ($product_info['image']) {
                $data['thumb'] = ToolImage::resize($product_info['image'], Config::get('config_image_thumb_width'), Config::get('config_image_thumb_height'));
            } else {
                $data['thumb'] = 'placeholder.png';
            }
            
            $data['images'] = array();
            
            $results = CatalogProduct::getProductImages(Request::p()->get['product_id']);
            
            foreach ($results as $result) {
                $data['images'][] = array('popup' => ToolImage::resize($result['image'], Config::get('config_image_popup_width'), Config::get('config_image_popup_height')), 'thumb' => ToolImage::resize($result['image'], Config::get('config_image_additional_width'), Config::get('config_image_additional_height')));
            }
            
            if ((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) {
                $data['price'] = Currency::format(Tax::calculate($product_info['price'], $product_info['tax_class_id'], Config::get('config_tax')));
            } else {
                $data['price'] = false;
            }
            
            if ((float)$product_info['special']) {
                $data['special'] = Currency::format(Tax::calculate($product_info['special'], $product_info['tax_class_id'], Config::get('config_tax')));
            } else {
                $data['special'] = false;
            }
            
            if (Config::get('config_tax')) {
                $data['tax'] = Currency::format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
            } else {
                $data['tax'] = false;
            }
            
            $discounts = CatalogProduct::getProductDiscounts(Request::p()->get['product_id']);
            
            $data['discounts'] = array();
            
            foreach ($discounts as $discount) {
                $data['discounts'][] = array('quantity' => $discount['quantity'], 'price' => Currency::format(Tax::calculate($discount['price'], $product_info['tax_class_id'], Config::get('config_tax'))));
            }
            
            $data['options'] = array();
            
            foreach (CatalogProduct::getProductOptions(Request::p()->get['product_id']) as $option) {
                if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                    $option_value_data = array();
                    
                    foreach ($option['option_value'] as $option_value) {
                        if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                            if (((Config::get('config_customer_price') && Customer::isLogged()) || !Config::get('config_customer_price')) && (float)$option_value['price']) {
                                $price = Currency::format(Tax::calculate($option_value['price'], $product_info['tax_class_id'], Config::get('config_tax')));
                            } else {
                                $price = false;
                            }
                            
                            $option_value_data[] = array('product_option_value_id' => $option_value['product_option_value_id'], 'option_value_id' => $option_value['option_value_id'], 'name' => $option_value['name'], 'image' => ToolImage::resize($option_value['image'], 50, 50), 'price' => $price, 'price_prefix' => $option_value['price_prefix']);
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
            
            if (Config::get('config_review_status')):
                if (Customer::isLogged()):
                    $data['review_allowed'] = true;
                else:
                    if (Config::get('config_review_logged')):
                        $data['review_allowed'] = true;
                    endif;
                endif;
            endif;
            
            $data['review_status']    = Config::get('config_review_status');
            $data['reviews']          = sprintf(Lang::get('lang_text_reviews'), (int)$product_info['reviews']);
            $data['rating']           = (int)$product_info['rating'];
            $data['description']      = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
            $data['attribute_groups'] = CatalogProduct::getProductAttributes(Request::p()->get['product_id']);
            
            $data['products'] = array();
            
            $results = CatalogProduct::getProductRelated(Request::p()->get['product_id']);
            
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = ToolImage::resize($result['image'], Config::get('config_image_related_width'), Config::get('config_image_related_height'));
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
                
                if (Config::get('config_review_status')) {
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
                    'reviews'    => sprintf(Lang::get('lang_text_reviews'), (int)$result['reviews']), 
                    'href'       => Url::link('catalog/product', 'path=' . $result['paths'] . '&product_id=' . $result['product_id'])
                );
            }
            
            $data['tags'] = false;
            
            if (!empty($product_info['tag'])):
                $tags = explode(',', $product_info['tag']);
                
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => Url::link('search/search', 'search=' . trim($tag))
                    );
                endforeach;
            endif;
            
            $data['recurrings'] = CatalogProduct::getAllRecurring($product_info['product_id']);
            
            CatalogProduct::updateViewed(Request::p()->get['product_id']);
            
            Theme::loadjs('javascript/catalog/product', $data);
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');

            $data['share_bar'] = Theme::controller('common/share_bar', array('product', $data));
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('catalog/product', $data));
        } else {
            $url = '';
            
            if (isset(Request::p()->get['path'])) {
                $url.= '&path=' . Request::p()->get['path'];
            }
            
            if (isset(Request::p()->get['filter'])) {
                $url.= '&filter=' . Request::p()->get['filter'];
            }
            
            if (isset(Request::p()->get['manufacturer_id'])) {
                $url.= '&manufacturer_id=' . Request::p()->get['manufacturer_id'];
            }
            
            if (isset(Request::p()->get['search'])) {
                $url.= '&search=' . Request::p()->get['search'];
            }
            
            if (isset(Request::p()->get['tag'])) {
                $url.= '&tag=' . Request::p()->get['tag'];
            }
            
            if (isset(Request::p()->get['description'])) {
                $url.= '&description=' . Request::p()->get['description'];
            }
            
            if (isset(Request::p()->get['category_id'])) {
                $url.= '&category_id=' . Request::p()->get['category_id'];
            }
            
            if (isset(Request::p()->get['sub_category'])) {
                $url.= '&sub_category=' . Request::p()->get['sub_category'];
            }
            
            if (isset(Request::p()->get['sort'])) {
                $url.= '&sort=' . Request::p()->get['sort'];
            }
            
            if (isset(Request::p()->get['order'])) {
                $url.= '&order=' . Request::p()->get['order'];
            }
            
            if (isset(Request::p()->get['page'])) {
                $url.= '&page=' . Request::p()->get['page'];
            }
            
            if (isset(Request::p()->get['limit'])) {
                $url.= '&limit=' . Request::p()->get['limit'];
            }
            
            Breadcrumb::add('lang_text_error', 'catalog/product', 'product_id=' . $product_id . $url);
            
            Theme::setTitle(Lang::get('lang_text_error'));
            
            $data['heading_title'] = Lang::get('lang_text_error');
            
            $data['continue'] = Url::link('shop/home');
            
            Response::addHeader(Request::p()->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('error/not_found', $data));
        }
    }
    
    public function join_wait_list() {
        $json = array();
        
        Theme::language('catalog/product');
        Theme::model('catalog/product');
        
        $results = CatalogProduct::joinWaitList(Request::p()->post['event_id'], Customer::getId());
        
        if ($results) {
            $message = '<div class="alert alert-success">' . Lang::get('lang_text_join_success') . '</div>';
        } else {
            $message = '<div class="alert alert-success">' . Lang::get('lang_text_join_failed') . '</div>';
        }
        
        $json = array('success' => $results, 'message' => $message);
        
        Response::setOutput(json_encode($json));
    }
    
    public function review() {
        $data = Theme::language('catalog/product');
        
        Theme::model('catalog/review');
        
        if (isset(Request::p()->get['page'])) {
            $page = Request::p()->get['page'];
        } else {
            $page = 1;
        }
        
        $data['reviews'] = array();
        
        $review_total = CatalogReview::getTotalReviewsByProductId(Request::p()->get['product_id']);
        
        $results = CatalogReview::getReviewsByProductId(Request::p()->get['product_id'], ($page - 1) * 5, 5);
        
        foreach ($results as $result) {
            $data['reviews'][] = array('author' => $result['author'], 'text' => $result['text'], 'rating' => (int)$result['rating'], 'reviews' => sprintf(Lang::get('lang_text_reviews'), (int)$review_total), 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])));
        }
        
        $data['pagination'] = Theme::paginate($review_total, $page, 5, Lang::get('lang_text_pagination'), Url::link('catalog/product/review', 'product_id=' . Request::p()->get['product_id'] . '&page={page}'));
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        Response::setOutput(View::make('catalog/review', $data));
    }
    
    public function getRecurringDescription() {
        Theme::language('catalog/product');
        Theme::model('catalog/product');
        
        if (isset(Request::p()->post['product_id'])) {
            $product_id = Request::p()->post['product_id'];
        } else {
            $product_id = 0;
        }
        
        if (isset(Request::p()->post['recurring_id'])) {
            $recurring_id = Request::p()->post['recurring_id'];
        } else {
            $recurring_id = 0;
        }
        
        if (isset(Request::p()->post['quantity'])) {
            $quantity = Request::p()->post['quantity'];
        } else {
            $quantity = 1;
        }
        
        $product_info   = CatalogProduct::getProduct($product_id);
        $recurring_info = CatalogProduct::getRecurring($product_id, $recurring_id);
        
        $json = array();
        
        if ($product_info && $recurring_info) {
            
            if (!$json) {
                $frequencies = array('day' => Lang::get('lang_text_day'), 'week' => Lang::get('lang_text_week'), 'semi_month' => Lang::get('lang_text_semi_month'), 'month' => Lang::get('lang_text_month'), 'year' => Lang::get('lang_text_year'),);
                
                if ($recurring_info['trial_status'] == 1) {
                    $price = Currency::format(Tax::calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], Config::get('config_tax')));
                    $trial_text = sprintf(Lang::get('lang_text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }
                
                $price = Currency::format(Tax::calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], Config::get('config_tax')));
                
                if ($recurring_info['duration']) {
                    $text = $trial_text . sprintf(Lang::get('lang_text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                } else {
                    $text = $trial_text . sprintf(Lang::get('lang_text_payment_until_canceled_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                }
                
                $json['success'] = $text;
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function write() {
        Theme::language('catalog/product');
        Theme::model('catalog/review');
        
        $json = array();
        
        if (Request::p()->server['REQUEST_METHOD'] == 'POST') {
            if ((Encode::strlen(Request::p()->post['name']) < 3) || (Encode::strlen(Request::p()->post['name']) > 25)) {
                $json['error'] = Lang::get('lang_error_name');
            }
            
            if ((Encode::strlen(Request::p()->post['text']) < 25) || (Encode::strlen(Request::p()->post['text']) > 1000)) {
                $json['error'] = Lang::get('lang_error_text');
            }
            
            if (empty(Request::p()->post['rating'])) {
                $json['error'] = Lang::get('lang_error_rating');
            }
            
            if (empty(Session::p()->data['captcha']) || (Session::p()->data['captcha'] != Request::p()->post['captcha'])) {
                $json['error'] = Lang::get('lang_error_captcha');
            }
            
            if (!isset($json['error'])) {
                unset(Session::p()->data['captcha']);
                
                CatalogReview::addReview(Request::p()->get['product_id'], Request::post());
                
                $json['success'] = Lang::get('lang_text_success');
            }
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
    
    public function captcha() {
        $captcha = new Captcha();
        
        Session::p()->data['captcha'] = $captcha->getCode();
        
        Theme::listen(__CLASS__, __FUNCTION__);
        
        $captcha->showImage();
    }
    
    public function upload() {
        Theme::language('catalog/product');
        
        $json = array();
        
        if (!empty(Request::p()->files['file']['name'])) {
            $filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode(Request::p()->files['file']['name'], ENT_QUOTES, 'UTF-8')));
            
            if ((Encode::strlen($filename) < 3) || (Encode::strlen($filename) > 64)) {
                $json['error'] = Lang::get('lang_error_filename');
            }
            
            // Allowed file extension types
            $allowed = array();
            
            $filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", Config::get('config_file_extension_allowed')));
            
            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }
            
            if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
                $json['error'] = Lang::get('lang_error_filetype');
            }
            
            // Allowed file mime types
            $allowed = array();
            
            $filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", Config::get('config_file_mime_allowed')));
            
            foreach ($filetypes as $filetype) {
                $allowed[] = trim($filetype);
            }
            
            if (!in_array(Request::p()->files['file']['type'], $allowed)) {
                $json['error'] = Lang::get('lang_error_filetype');
            }
            
            // Check to see if any PHP files are trying to be uploaded
            $content = file_get_contents(Request::p()->files['file']['tmp_name']);
            
            if (preg_match('/\<\?php/i', $content)) {
                $json['error'] = Lang::get('lang_error_filetype');
            }
            
            if (Request::p()->files['file']['error'] != UPLOAD_ERR_OK) {
                $json['error'] = Lang::get('lang_error_upload_' . Request::p()->files['file']['error']);
            }
        } else {
            $json['error'] = Lang::get('lang_error_upload');
        }
        
        if (!$json && is_uploaded_file(Request::p()->files['file']['tmp_name']) && file_exists(Request::p()->files['file']['tmp_name'])) {
            $file = basename($filename) . '.' . md5(mt_rand());
            
            // Hide the uploaded file name so people can not link to it directly.
            $json['file'] = $this->encryption->encrypt($file);
            
            move_uploaded_file(Request::p()->files['file']['tmp_name'], Config::get('path.download') . $file);
            
            $json['success'] = Lang::get('lang_text_upload');
        }
        
        $json = Theme::listen(__CLASS__, __FUNCTION__, $json);
        
        Response::setOutput(json_encode($json));
    }
}
