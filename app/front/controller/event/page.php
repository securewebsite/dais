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

namespace Front\Controller\Event;
use Dais\Engine\Controller;

class Page extends Controller {
    public function index() {
        $data = $this->theme->language('event/page');
        
        $this->theme->model('content/page');
        
        if (isset($this->request->get['event_page_id'])):
            $page_id = (int)$this->request->get['event_page_id'];
        else:
            $page_id = 0;
        endif;
        
        $page_info = $this->model_content_page->getEventPage($page_id);
        
        if ($page_info):
            
            if ($this->customer->isLogged()):
            	if ($page_info['visibility'] > $this->customer->customer_group_id):
            		$this->response->redirect($this->url->link('error/permission', '', 'SSL'));
            	endif;
            elseif ($page_info['visibility'] > $this->config->get('config_default_visibility')):
            	$this->response->redirect($this->url->link('error/permission', '', 'SSL'));
            endif;

            $this->theme->setTitle($page_info['title']);
            $this->theme->setDescription($page_info['meta_description']);
            $this->theme->setKeywords($page_info['meta_keywords']);
            $this->theme->setOgType('article');
            $this->theme->setOgDescription(html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8'));
            
            $this->breadcrumb->add($page_info['title'], 'event/page', 'event_page_id=' . $page_id);
            
			$data['heading_title'] = $page_info['title'];
			$data['description']   = html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8');
			$data['tags']          = false;
            
            if (!empty($page_info['tag'])):
                $tags = explode(',', $page_info['tag']);
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => $this->url->link('search/tag', 'tag=' . trim($tag))
                    );
                endforeach;
            endif;
/**
 *  [visibility] => 1
 *  [event_id] => 2
 *  [event_length] => 2
 *  [event_days] => a:1:{i:0;s:6:"Friday";}
 *  [date_time] => 2015-04-24 09:00:00
 *  [online] => 1
 *  [link] => http://www.google.com
 *  [location] => 1234 Main St. Tempe, AZ 85281
 *  [telephone] => 480-333-3344
 *  [seats] => 200
 *  [presenter_tab] => Host
 *  [presenter_id] => 1
 *  [date_end] => 2015-04-24 11:00:00
 */
            
            $data['continue'] = $this->url->link('content/home');
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('event/page', $data));
        else:
            $this->breadcrumb->add('lang_text_error', 'event/page', 'event_page_id=' . $page_id);
            $this->theme->setTitle($this->language->get('lang_text_error'));
            
			$data['heading_title'] = $this->language->get('lang_text_error');
			$data['continue']      = $this->url->link('content/home');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            $data = $this->theme->render_controllers($data);
            
            $this->response->setOutput($this->theme->view('error/notfound', $data));
        endif;
    }
}
