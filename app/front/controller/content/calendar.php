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

namespace Front\Controller\Content;
use Dais\Engine\Controller;

class Calendar extends Controller {
    public function index() {
        $data = $this->theme->language('content/calendar');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->breadcrumb->add('lang_heading_title', 'content/calendar', null, true, 'SSL');
        
        $data['template_path'] = 'asset/' . $this->app['theme.name'] . '/template/';
        $data['today']         = date('Y-m-d', time());
        $data['continue']      = $this->url->link('content/home');
        
        $this->theme->loadjs('javascript/content/calendar', $data);
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('content/calendar', $data));
    }
    
    public function fetch() {
        $this->theme->language('content/calendar');
        $this->theme->model('catalog/product');
        $this->theme->model('tool/image');
        $events = $this->model_catalog_product->getEvents();
        
        $json = array();
        
        if ($events):
            foreach ($events as $event):
                $location  = $event['location'] ? html_entity_decode($event['location'], ENT_QUOTES, 'UTF-8') : false;
                $telephone = $event['telephone'] ? $event['telephone'] : false;
                
                $url   = false;
                $image = false;

                if ($event['product_id']):
                    $url   = $this->url->link('catalog/product', 'product_id=' . $event['product_id']);
                    $image = $this->model_catalog_product->getEventImage($event['product_id']);
                    $image = $this->model_tool_image->resize($image, 100, 100, 'h');
                endif;

                if ($event['page_id']):
                    $url = $this->url->link('event/page', 'event_page_id=' . $event['page_id']);
                endif;

                $event_class = $event['event_class'];
                $finished    = (strtotime($event['date_end']) < time()) ? $this->language->get('lang_text_finished') : false;
                $days        = unserialize($event['event_days']);
                $event_times = array();
                
                if (count($days) > 1):
                    $event_times[] = array(
                        'start' => $event['date_time'], 
                        'end'   => $event['date_end']
                    );
                    
                    $count_days = count($days);
                    
                    for ($i = 1; $i < $count_days; $i++):
                        $start = strtotime($event['date_time']);
                        $end   = strtotime($event['date_end']);
                        $event_times[] = array(
                            'start' => date('Y-m-d H:i:s', strtotime("+" . $i . " day", $start)), 
                            'end'   => date('Y-m-d H:i:s', strtotime("+" . $i . " day", $end))
                        );
                    endfor;
                endif;

                $image = (isset($image)) ? $image : false;
                
                if (!empty($event_times)):
                    foreach ($event_times as $i => $time):
                        $iterator = mt_rand(100000, 999999);
                        $json[] = array(
                            'id'          => $event['event_id'] . $iterator . $i, 
                            'title'       => $event['event_name'], 
                            'image'       => $image, 
                            'url'         => $url, 
                            'class'       => $event_class, 
                            'description' => html_entity_decode($event['description'], ENT_QUOTES, 'UTF-8'), 
                            'location'    => $location, 
                            'telephone'   => $telephone, 
                            'finished'    => $finished, 
                            'start'       => strtotime($time['start']) . '000', 
                            'end'         => strtotime($time['end']) . '000'
                        );
                    endforeach;
                else:
                    $json[] = array(
                        'id'          => $event['event_id'], 
                        'title'       => $event['event_name'], 
                        'image'       => $image, 
                        'url'         => $url, 
                        'class'       => $event_class, 
                        'description' => html_entity_decode($event['description'], ENT_QUOTES, 'UTF-8'), 
                        'location'    => $location, 
                        'telephone'   => $telephone, 
                        'finished'    => $finished, 
                        'start'       => strtotime($event['date_time']) . '000', 
                        'end'         => strtotime($event['date_end']) . '000'
                    );
                endif;
            endforeach;
        endif;
        
        $this->response->setOutput(json_encode(array('success' => 1, 'result' => $json)));
    }
}
