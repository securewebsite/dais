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
*/

namespace Admin\Controller\Common;
use Dais\Engine\Controller;
use Dais\Engine\Action;
use Dais\Service\ActionService;

class Dashboard extends Controller {
    private $error;
    private $errors = array(
        'install',
        'image',
        'image_cache',
        'cache',
        'download',
        'logs'
    );
    
    public function index() {
        $data = $this->theme->language('common/dashboard');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->javascript->register('flot.min', 'summernote.min')
            ->register('flot.resize.min', 'flot.min');
        
        if (strtotime('-24 hours', time()) > $this->user->getLastAccess()):
            $this->checkFolders();
        endif;
        
        foreach ($this->errors as $error):
            if (isset($this->error[$error])):
                $data["error_{$error}"] = $this->error[$error];
            else:
                $data["error_{$error}"] = '';
            endif;
        endforeach;
        
        $data['token'] = $this->session->data['token'];
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        if (isset($this->session->data['warning'])):
            $data['error_warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        else:
            $data['error_warning'] = '';
        endif;
        
        $this->theme->model('sale/order');
        
        $data['total_sale']      = $this->currency->format($this->model_sale_order->getTotalSales() , $this->config->get('config_currency'));
        $data['total_sale_year'] = $this->currency->format($this->model_sale_order->getTotalSalesByYear(date('Y')) , $this->config->get('config_currency'));
        $data['total_order']     = $this->model_sale_order->getTotalOrders();
        
        $this->theme->model('people/customer');
        
        $data['total_customer']          = $this->model_people_customer->getTotalCustomers();
        $data['total_customer_approval'] = $this->model_people_customer->getTotalCustomersAwaitingApproval();
        
        $this->theme->model('catalog/review');
        
        $data['total_review']          = $this->model_catalog_review->getTotalReviews();
        $data['total_review_approval'] = $this->model_catalog_review->getTotalReviewsAwaitingApproval();
        
        $data['orders'] = array();
        
        $filter = array(
            'sort'  => 'o.date_added',
            'order' => 'DESC',
            'start' => 0,
            'limit' => 10
        );
        
        $results = $this->model_sale_order->getOrders($filter);
        
        foreach ($results as $result) {
            $action = array();
            
            $action[] = array(
                'text' => $this->language->get('lang_text_view') ,
                'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
            );
            
            $data['orders'][] = array(
                'order_id'   => $result['order_id'],
                'customer'   => $result['customer'],
                'status'     => $result['status'],
                'date_added' => date($this->language->get('lang_date_format_short') , strtotime($result['date_added'])) ,
                'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']) ,
                'action'     => $action
            );
        }
        
        if ($this->config->get('config_currency_auto')) {
            $this->theme->model('localization/currency');
            
            $this->model_localization_currency->updateCurrencies();
        }
        
        $this->theme->loadjs('javascript/common/dashboard', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('common/dashboard', $data));
    }
    
    public function sale() {
        $this->theme->language('common/dashboard');
        
        $json = array();
        
        $this->theme->model('report/dashboard');
        
        $json['orders']            = array();
        $json['customers']         = array();
        $json['xaxis']             = array();
        
        $json['order']['label']    = $this->language->get('lang_text_order');
        $json['customer']['label'] = $this->language->get('lang_text_customer');
        
        if (isset($this->request->get['range'])) {
            $range = $this->request->get['range'];
        } else {
            $range = 'day';
        }
        
        switch ($range) {
            default:
            case 'day':
                $results = $this->model_report_dashboard->getTotalOrdersByDay();
                
                foreach ($results as $key => $value) {
                    $json['order']['data'][] = array($key, $value['total']);
                }
                
                $results = $this->model_report_dashboard->getTotalCustomersByDay();
                
                foreach ($results as $key => $value) {
                    $json['customer']['data'][] = array($key,$value['total']);
                }
                
                for ($i = 0; $i < 24; $i++) {
                    $json['xaxis'][] = array($i, $i);
                }
                break;

            case 'week':
                $results = $this->model_report_dashboard->getTotalOrdersByWeek();
                
                foreach ($results as $key => $value) {
                    $json['order']['data'][] = array($key, $value['total']);
                }
                
                $results = $this->model_report_dashboard->getTotalCustomersByWeek();
                
                foreach ($results as $key => $value) {
                    $json['customer']['data'][] = array($key, $value['total']);
                }
                
                $date_start = strtotime('-' . date('w') . ' days');
                
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', $date_start + ($i * 86400));
                    
                    $json['xaxis'][] = array(date('w', strtotime($date)), date('D', strtotime($date)));
                }
                break;

            case 'month':
                $results = $this->model_report_dashboard->getTotalOrdersByMonth();
                
                foreach ($results as $key => $value) {
                    $json['order']['data'][] = array($key, $value['total']);
                }
                
                $results = $this->model_report_dashboard->getTotalCustomersByMonth();
                
                foreach ($results as $key => $value) {
                    $json['customer']['data'][] = array($key, $value['total']);
                }
                
                $date_t = date('t');
                for ($i = 1; $i <= $date_t; $i++) {
                    $date = date('Y') . '-' . date('m') . '-' . $i;
                    
                    $json['xaxis'][] = array(date('j', strtotime($date)), date('d', strtotime($date)));
                }
                break;

            case 'year':
                $results = $this->model_report_dashboard->getTotalOrdersByYear();
                
                foreach ($results as $key => $value) {
                    $json['order']['data'][] = array($key, $value['total']);
                }
                
                $results = $this->model_report_dashboard->getTotalCustomersByYear();
                
                foreach ($results as $key => $value) {
                    $json['customer']['data'][] = array($key, $value['total']);
                }
                
                for ($i = 1; $i <= 12; $i++) {
                    $json['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i)));
                }
                break;
        }
        
        $json = $this->theme->listen(__CLASS__, __FUNCTION__, $json);
        
        $this->response->setOutput(json_encode($json));
    }
    
    public function login() {
        $route = '';
        
        if (isset($this->request->get['route'])) {
            $part = explode('/', $this->request->get['route']);
            
            if (isset($part[0])) {
                $route.= $part[0];
            }
            
            if (isset($part[1])) {
                $route.= '/' . $part[1];
            }
        }
        
        $ignore = array(
            'common/login',
            'common/forgotten',
            'common/reset',
            'common/javascript',
            'common/css'
        );
        
        if (!$this->user->isLogged() && !in_array($route, $ignore)) {
            return new Action(new ActionService($this->app, 'common/login'));
        }
        
        if (isset($this->request->get['route'])) {
            $ignore = array(
                'common/login',
                'common/logout',
                'common/forgotten',
                'common/reset',
                'error/not_found',
                'error/permission',
                'common/breadcrumb',
                'common/menu',
                'common/javascript',
                'common/css'
            );
            
            $config_ignore = array();
            
            $ignore = array_merge($ignore, $config_ignore);
            
            if (!in_array($route, $ignore) && (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token']))) {
                return new Action(new ActionService($this->app, 'common/login'));
            }
        } else {
            if (!isset($this->request->get['token']) || !isset($this->session->data['token']) || ($this->request->get['token'] != $this->session->data['token'])) {
                return new Action(new ActionService($this->app, 'common/login'));
            }
        }
    }
    
    public function permission() {
        if (isset($this->request->get['route'])) {
            $route = '';
            
            $part = explode('/', $this->request->get['route']);
            
            if (isset($part[0])) {
                $route.= $part[0];
            }
            
            if (isset($part[1])) {
                $route.= '/' . $part[1];
            }
            
            $ignore = array(
                'common/dashboard',
                'common/login',
                'common/logout',
                'common/forgotten',
                'common/reset',
                'common/breadcrumb',
                'common/menu',
                'error/not_found',
                'error/permission',
                'common/javascript',
                'common/css'
            );
            
            if (!in_array($route, $ignore) && !$this->user->hasPermission('access', $route)) {
                return new Action(new ActionService($this->app, 'error/permission'));
            }
        }
    }
    
    public function checkFolders() {
        $this->theme->language('common/dashboard');
        
        // Check image directory is writable
        $file = $this->app['path.image'] . 'test';
        $handle = fopen($file, 'a+');
        
        fwrite($handle, '');
        fclose($handle);
        
        if (!is_readable($file)):
            $this->error['image'] = sprintf($this->language->get('lang_error_image') , $this->app['path.image']);
        else:
            $this->error['image'] = '';
            unlink($file);
        endif;
        
        // Check image cache directory is writable
        $file = $this->app['path.image'] . 'cache/test';
        $handle = fopen($file, 'a+');
        
        fwrite($handle, '');
        fclose($handle);
        
        if (!is_readable($file)):
            $this->error['image_cache'] = sprintf($this->language->get('lang_error_image_cache') , $this->app['path.image'] . 'cache/');
        else:
            $this->error['image_cache'] = '';
            unlink($file);
        endif;
        
        // Check cache directory is writable
        $file = $this->app['path.cache'] . 'test';
        $handle = fopen($file, 'a+');
        
        fwrite($handle, '');
        fclose($handle);
        
        if (!is_readable($file)):
            $this->error['cache'] = sprintf($this->language->get('lang_error_image_cache') , $this->app['path.cache']);
        else:
            $this->error['cache'] = '';
            unlink($file);
        endif;
        
        // Check download directory is writable
        $file = $this->app['path.download'] . 'test';
        $handle = fopen($file, 'a+');
        
        fwrite($handle, '');
        fclose($handle);
        
        if (!is_readable($file)):
            $this->error['download'] = sprintf($this->language->get('lang_error_download') , $this->app['path.download']);
        else:
            $this->error['download'] = '';
            unlink($file);
        endif;
        
        // Check logs directory is writable
        $file = $this->app['path.logs'] . 'test';
        $handle = fopen($file, 'a+');
        
        fwrite($handle, '');
        fclose($handle);
        
        if (!is_readable($file)):
            $this->error['logs'] = sprintf($this->language->get('lang_error_logs') , $this->app['path.logs']);
        else:
            $this->error['logs'] = '';
            unlink($file);
        endif;
        
        if (!$this->error):
            $this->theme->model('report/dashboard');
            $this->model_report_dashboard->setLastAccess($this->user->getId());
            $this->session->data['user_last_access'] = time();
        endif;
        
        return !$this->error;
    }
}
