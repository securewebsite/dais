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

namespace App\Controllers\Front\Event;
use App\Controllers\Controller;

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
            
            $data['event_page_id'] = $page_id;
			$data['heading_title'] = $page_info['title'];
			$data['description']   = html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8');
			$data['tags']          = false;
            
            if (!empty($page_info['tag'])):
                $tags = explode(',', $page_info['tag']);
                foreach ($tags as $tag):
                    $data['tags'][] = array(
                        'name' => trim($tag), 
                        'href' => $this->url->link('search/search', 'search=' . trim($tag))
                    );
                endforeach;
            endif;

            $data['event_id']    = $page_info['event_id'];
            $data['unavailable'] = 0;
            $data['registered']  = 0;

            $this->theme->model('catalog/product');
            
            if ($this->customer->isLogged()):
                $registered = $this->model_catalog_product->getRoster($page_info['event_id'], $this->customer->getId());
                if ($registered):
                    $data['registered'] = 1;
                endif;
            else:
                $data['unavailable'] = 1;
            endif;
            
            $data['event_name']   = html_entity_decode($page_info['event_name'], ENT_QUOTES, 'UTF-8');
            $data['event_date']   = date($this->language->get('lang_date_format_short'), strtotime($page_info['date_time']));
            $data['event_time']   = date($this->language->get('lang_time_format'), strtotime($page_info['date_time']));
            $data['event_days']   = unserialize($page_info['event_days']);
            $data['event_length'] = $page_info['event_length'];
            $data['seats']        = $page_info['seats'];
            $data['available']    = $page_info['seats'] - $page_info['filled'];

            if ($page_info['event_length'] == 1):
                $plural = $this->language->get('lang_text_event_hour');
            else:
                $plural = $this->language->get('lang_text_event_hours');
            endif;

            if (count($data['event_days']) > 1):
                $data['event_length_text'] = sprintf($this->language->get('lang_text_event_each'), $plural);
            else:
                $data['event_length_text'] = $plural;
            endif;
            
            $data['text_unavailable_info'] = '';
            $data['button_waitlist']       = '';
            $data['text_already_on']       = '';
            
            if ($data['available'] < 1):
                $customer_waitlist = $this->model_catalog_product->checkWaitList($page_info['event_id'], $this->customer->getId());
                
                if (!$customer_waitlist):
                    $data['text_unavailable_info'] = sprintf($this->language->get('lang_text_unavailable_info'), $data['event_name']);
                    $data['button_waitlist'] = $this->language->get('lang_button_waitlist');
                else:
                    $data['text_already_on'] = $this->language->get('lang_text_already_on');
                endif;
            endif;
            
            $data['telephone'] = $page_info['telephone'];
            
            /**
             * If this is an online event, we should have an empty location,
             * and a link should exist to the web event.
             * We'll override any existing location with the link for the
             * online event here.
             */
            
            $data['online'] = false;
            
            if ($page_info['online']):
                $data['online'] = true;
                $data['location'] = $page_info['link'];
            else:
                $data['location'] = ($page_info['location']) ? nl2br($page_info['location']) : false;
            endif;

            // Presenter info
            $host = $page_info['presenter'];

            $data['presenter']     = html_entity_decode($host['presenter_name'], ENT_QUOTES, 'UTF-8');
            $data['presenter_bio'] = html_entity_decode($host['bio'], ENT_QUOTES, 'UTF-8');

            $data['presenter_image']    = false;
            $data['presenter_facebook'] = false;
            $data['presenter_twitter']  = false;
            
            if ($host['image']):
                $this->theme->model('tool/image');
                $data['presenter_image'] = $this->model_tool_image->resize($host['image'], 200, 200, 'f');
            endif;

            if ($host['facebook']):
                $data['presenter_facebook'] = $host['facebook'];
            endif;

            if ($host['twitter']):
                $data['presenter_twitter']  = $host['twitter'];
            endif;
            
            if ($page_info['presenter_tab']):
                $data['text_presenter_info'] = sprintf($this->language->get('lang_text_presenter_info'), $page_info['presenter_tab']);
                $data['text_presenter_bio']  = sprintf($this->language->get('lang_text_presenter_bio'), $page_info['presenter_tab']);
            else:
                $data['text_presenter_info'] = sprintf($this->language->get('lang_text_presenter_info'), $this->language->get('lang_tab_presenter'));
                $data['text_presenter_bio']  = sprintf($this->language->get('lang_text_presenter_bio'), $this->language->get('lang_tab_presenter'));
            endif;
            
            $data['continue'] = $this->url->link('content/home');
            
            $data             = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            $data['share_bar'] = $this->theme->controller('common/share_bar', array('event', $data));
            $data             = $this->theme->renderControllers($data);
            
            $this->response->setOutput($this->theme->view('event/page', $data));
        else:
            $this->breadcrumb->add('lang_text_error', 'event/page', 'event_page_id=' . $page_id);
            $this->theme->setTitle($this->language->get('lang_text_error'));
            
			$data['heading_title'] = $this->language->get('lang_text_error');
			$data['continue']      = $this->url->link('content/home');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
            $data = $this->theme->renderControllers($data);
            
            $this->response->setOutput($this->theme->view('error/not_found', $data));
        endif;
    }
}
