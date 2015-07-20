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

class Download extends Controller {
    
    public function index() {
        if (!Customer::isLogged()) {
            Session::p()->data['redirect'] = Url::link('account/download', '', 'SSL');
            
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        $data = Theme::language('account/download');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_account', 'account/dashboard', null, true, 'SSL');
        Breadcrumb::add('lang_text_downloads', 'account/download', null, true, 'SSL');
        
        Theme::model('account/download');
        
        $download_total = AccountDownload::getTotalDownloads();
        
        if ($download_total) {
            
            if (isset(Request::p()->get['page'])) {
                $page = Request::p()->get['page'];
            } else {
                $page = 1;
            }
            
            $data['downloads'] = array();
            
            $results = AccountDownload::getDownloads(($page - 1) * Config::get('config_catalog_limit'), Config::get('config_catalog_limit'));
            
            foreach ($results as $result) {
                if (file_exists(Config::get('path.download') . $result['filename'])) {
                    $size = filesize(Config::get('path.download') . $result['filename']);
                    
                    $i = 0;
                    
                    $suffix = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                    
                    while (($size / 1024) > 1) {
                        $size = $size / 1024;
                        $i++;
                    }
                    
                    $data['downloads'][] = array('order_id' => $result['order_id'], 'date_added' => date(Lang::get('lang_date_format_short'), strtotime($result['date_added'])), 'name' => $result['name'], 'remaining' => $result['remaining'], 'size' => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i], 'href' => Url::link('account/download/download', 'order_download_id=' . $result['order_download_id'], 'SSL'));
                }
            }
            
            $data['pagination'] = Theme::paginate($download_total, $page, Config::get('config_catalog_limit'), Lang::get('lang_text_pagination'), Url::link('account/download', 'page={page}', 'SSL'));
            
            $data['continue'] = Url::link('account/dashboard', '', 'SSL');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('account/download', $data));
        } else {
            Theme::setTitle(Lang::get('lang_heading_title'));
            
			$data['heading_title'] = Lang::get('lang_heading_title');
			
			$data['text_error'] = Lang::get('lang_text_empty');
            
            $data['continue'] = Url::link('account/dashboard', '', 'SSL');
            
            Response::addHeader(Request::p()->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            Theme::setController('header', 'shop/header');
            Theme::setController('footer', 'shop/footer');
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('error/not_found', $data));
        }
    }
    
    public function download() {
        if (!Customer::isLogged()) {
            Session::p()->data['redirect'] = Url::link('account/download', '', 'SSL');
            
            Response::redirect(Url::link('account/login', '', 'SSL'));
        }
        
        Theme::model('account/download');
        
        if (isset(Request::p()->get['order_download_id'])) {
            $order_download_id = Request::p()->get['order_download_id'];
        } else {
            $order_download_id = 0;
        }
        
        $download_info = AccountDownload::getDownload($order_download_id);
        
        if ($download_info) {
            $file = Config::get('path.download') . $download_info['filename'];
            $mask = basename($download_info['mask']);
            
            if (!headers_sent()) {
                if (file_exists($file)) {
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    
                    if (ob_get_level()) ob_end_clean();
                    
                    Theme::listen(__CLASS__, __FUNCTION__);
                    
                    readfile($file, 'rb');
                    
                    AccountDownload::updateRemaining(Request::p()->get['order_download_id']);
                } else {
                    trigger_error('Error: Could not find file ' . $file . '!');
                }
            } else {
                trigger_error('Error: Headers already sent out!');
            }
        } else {
            Response::redirect(Url::link('account/download', '', 'SSL'));
        }
    }
}
