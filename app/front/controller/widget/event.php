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

namespace Front\Controller\Widget;
use Dais\Engine\Controller;

class Event extends Controller {
    
    public function index() {
        $data = $this->theme->language('widget/event');
        $this->theme->model('widget/event');
        
        if ($this->customer->isLogged()):
            $data['text_no_upcoming'] = $this->language->get('lang_text_no_upcoming');
        else:
            $data['text_no_upcoming'] = $this->language->get('lang_text_login_registered');
        endif;
        
        $data['events'] = array();
        
        if ($this->customer->isLogged()):
            $results = $this->model_widget_event->getEvents($this->customer->getId());
            
            if ($results):
                foreach ($results as $result):
                    $event_days = '';
                    
                    foreach ($result['event_days'] as $day):
                        $event_days.= $day . ', ';
                    endforeach;
                    
                    $event_days = rtrim($event_days, ', ');
                    
                    $data['events'][] = array(
                        'event_id'   => $result['event_id'], 
                        'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'), 
                        'start_date' => date($this->language->get('lang_date_format_short'), strtotime($result['date_time'])), 
                        'start_time' => date($this->language->get('lang_time_format'), strtotime($result['date_time'])), 
                        'event_days' => $event_days, 
                        'online'     => $result['online'], 
                        'link'       => $this->url->link('content/hangout', '&event_id=' . $result['event_id'], 'SSL'), 
                        'location'   => nl2br($result['location']), 
                        'telephone'  => $result['telephone'] ? $result['telephone'] : 'N/A'
                    );
                endforeach;
            endif;
        endif;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/event', $data);
    }
}
