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

class Calendar extends Controller {
    
    public function index() {
        $data = Theme::language('content/calendar');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        Breadcrumb::add('lang_heading_title', 'content/calendar', null, true, 'SSL');
        
        //$data['template_path'] = 'asset/' . Config::get('theme.name') . '/template/';
        $data['template_path'] = 'asset/calendar/';
        $data['today']         = date('Y-m-d', time());
        $data['continue']      = Url::link('content/home');
        
        Theme::loadjs('javascript/content/calendar', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('content/calendar', $data));
    }
    
    public function fetch() {
        Theme::language('content/calendar');
        Theme::model('catalog/product');
        Theme::model('tool/image');
        $events = CatalogProduct::getEvents();
        
        $json = array();
        
        if ($events):
            foreach ($events as $event):
                $location  = $event['location'] ? html_entity_decode($event['location'], ENT_QUOTES, 'UTF-8') : false;
                $telephone = $event['telephone'] ? $event['telephone'] : false;
                
                $url   = false;
                $image = false;

                if ($event['product_id']):
                    $url   = Url::link('catalog/product', 'product_id=' . $event['product_id']);
                    $image = CatalogProduct::getEventImage($event['product_id']);
                    $image = ToolImage::resize($image, 100, 100, 'h');
                endif;

                if ($event['page_id']):
                    $url = Url::link('event/page', 'event_page_id=' . $event['page_id']);
                endif;

                $event_class = $event['event_class'];
                $finished    = (strtotime($event['date_end']) < time()) ? Lang::get('lang_text_finished') : false;
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
        
        Response::setOutput(json_encode(array('success' => 1, 'result' => $json)));
    }
}
