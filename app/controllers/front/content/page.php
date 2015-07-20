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

namespace App\Controllers\Front\Content;

use App\Controllers\Controller;

class Page extends Controller {
    
    public function index() {
        $data = Theme::language('content/page');
        
        Theme::model('content/page');
        
        if (isset(Request::p()->get['page_id'])) {
            $page_id = (int)Request::p()->get['page_id'];
        } else {
            $page_id = 0;
        }
        
        $page_info = ContentPage::getPage($page_id);
        
        if ($page_info) {
            Theme::setTitle($page_info['title']);
            Theme::setDescription($page_info['meta_description']);
            Theme::setKeywords($page_info['meta_keywords']);
            
            Theme::setOgType('article');
            Theme::setOgDescription(html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8'));
            
            Breadcrumb::add($page_info['title'], 'content/page', 'page_id=' . $page_id);
            
            $data['page_id']       = $page_id;
            $data['heading_title'] = $page_info['title'];
            $data['description']   = html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8');
            $data['tags']          = false;
            
            if (!empty($page_info['tag'])):
                $tags = explode(',', $page_info['tag']);
                
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => Url::link('search/search', 'search=' . trim($tag))
                    );
                endforeach;
            endif;
            
            $data['continue'] = Url::link('content/home');
            
            $data             = Theme::listen(__CLASS__, __FUNCTION__, $data);
            $data['share_bar'] = Theme::controller('common/share_bar', array('page', $data));
            $data             = Theme::renderControllers($data);
            
            Response::setOutput(View::make('content/page', $data));
        } else {
            Breadcrumb::add('lang_text_error', 'content/page', 'page_id=' . $page_id);
            
            Theme::setTitle(Lang::get('lang_text_error'));
            
            $data['heading_title'] = Lang::get('lang_text_error');
            
            $data['continue'] = Url::link('content/home');
            
            Response::addHeader(Request::p()->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::make('error/not_found', $data));
        }
    }
    
    public function info() {
        Theme::model('content/page');
        
        if (isset(Request::p()->get['page_id'])) {
            $page_id = (int)Request::p()->get['page_id'];
        } else {
            $page_id = 0;
        }
        
        $page_info = ContentPage::getPage($page_id);
        
        if ($page_info) {
            $output = '<html dir="ltr" lang="en">' . "\n";
            $output.= '<head>' . "\n";
            $output.= '  <title>' . $page_info['title'] . '</title>' . "\n";
            $output.= '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
            $output.= '  <meta name="robots" content="noindex">' . "\n";
            $output.= '</head>' . "\n";
            $output.= '<body>' . "\n";
            $output.= html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
            $output.= '  </body>' . "\n";
            $output.= '</html>' . "\n";
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            Response::setOutput($output);
        }
    }
}
