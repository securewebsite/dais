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
        $data = Theme::language('event/page');
        
        Theme::model('content/page');
        
        if (isset($this->request->get['event_page_id'])):
            $page_id = (int)$this->request->get['event_page_id'];
        else:
            $page_id = 0;
        endif;
        
        $page_info = ContentPage::getEventPage($page_id);
        
        if ($page_info):
            
            if (Customer::isLogged()):
            	if ($page_info['visibility'] > Customer::customer_group_id):
            		Response::redirect(Url::link('error/permission', '', 'SSL'));
            	endif;
            elseif ($page_info['visibility'] > Config::get('config_default_visibility')):
            	Response::redirect(Url::link('error/permission', '', 'SSL'));
            endif;

            Theme::setTitle($page_info['title']);
            Theme::setDescription($page_info['meta_description']);
            Theme::setKeywords($page_info['meta_keywords']);
            Theme::setOgType('article');
            Theme::setOgDescription(html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8'));
            
            Breadcrumb::add($page_info['title'], 'event/page', 'event_page_id=' . $page_id);
            
            $data['event_page_id'] = $page_id;
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

            $data['event_id']    = $page_info['event_id'];
            $data['unavailable'] = 0;
            $data['registered']  = 0;

            Theme::model('catalog/product');
            
            if (Customer::isLogged()):
                $registered = CatalogProduct::getRoster($page_info['event_id'], Customer::getId());
                if ($registered):
                    $data['registered'] = 1;
                endif;
            else:
                $data['unavailable'] = 1;
            endif;
            
            $data['event_name']   = html_entity_decode($page_info['event_name'], ENT_QUOTES, 'UTF-8');
            $data['event_date']   = date(Lang::get('lang_date_format_short'), strtotime($page_info['date_time']));
            $data['event_time']   = date(Lang::get('lang_time_format'), strtotime($page_info['date_time']));
            $data['event_days']   = unserialize($page_info['event_days']);
            $data['event_length'] = $page_info['event_length'];
            $data['seats']        = $page_info['seats'];
            $data['available']    = $page_info['seats'] - $page_info['filled'];

            if ($page_info['event_length'] == 1):
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
                $customer_waitlist = CatalogProduct::checkWaitList($page_info['event_id'], Customer::getId());
                
                if (!$customer_waitlist):
                    $data['text_unavailable_info'] = sprintf(Lang::get('lang_text_unavailable_info'), $data['event_name']);
                    $data['button_waitlist'] = Lang::get('lang_button_waitlist');
                else:
                    $data['text_already_on'] = Lang::get('lang_text_already_on');
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
                Theme::model('tool/image');
                $data['presenter_image'] = ToolImage::resize($host['image'], 200, 200, 'f');
            endif;

            if ($host['facebook']):
                $data['presenter_facebook'] = $host['facebook'];
            endif;

            if ($host['twitter']):
                $data['presenter_twitter']  = $host['twitter'];
            endif;
            
            if ($page_info['presenter_tab']):
                $data['text_presenter_info'] = sprintf(Lang::get('lang_text_presenter_info'), $page_info['presenter_tab']);
                $data['text_presenter_bio']  = sprintf(Lang::get('lang_text_presenter_bio'), $page_info['presenter_tab']);
            else:
                $data['text_presenter_info'] = sprintf(Lang::get('lang_text_presenter_info'), Lang::get('lang_tab_presenter'));
                $data['text_presenter_bio']  = sprintf(Lang::get('lang_text_presenter_bio'), Lang::get('lang_tab_presenter'));
            endif;
            
            $data['continue'] = Url::link('content/home');
            
            $data             = Theme::listen(__CLASS__, __FUNCTION__, $data);
            $data['share_bar'] = Theme::controller('common/share_bar', array('event', $data));
            $data             = Theme::renderControllers($data);
            
            Response::setOutput(View::render('event/page', $data));
        else:
            Breadcrumb::add('lang_text_error', 'event/page', 'event_page_id=' . $page_id);
            Theme::setTitle(Lang::get('lang_text_error'));
            
			$data['heading_title'] = Lang::get('lang_text_error');
			$data['continue']      = Url::link('content/home');
            
            Response::addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
            
            $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
            $data = Theme::renderControllers($data);
            
            Response::setOutput(View::render('error/not_found', $data));
        endif;
    }
}
