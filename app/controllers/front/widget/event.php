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

namespace App\Controllers\Front\Widget;

use App\Controllers\Controller;

class Event extends Controller {
    
    public function index() {
        $data = Theme::language('widget/event');
        Theme::model('widget/event');
        
        if (Customer::isLogged()):
            $data['text_no_upcoming'] = Lang::get('lang_text_no_upcoming');
        else:
            $data['text_no_upcoming'] = Lang::get('lang_text_login_registered');
        endif;
        
        $data['events'] = array();
        
        if (Customer::isLogged()):
            $results = WidgetEvent::getEvents(Customer::getId());
            
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
                        'start_date' => date(Lang::get('lang_date_format_short'), strtotime($result['date_time'])), 
                        'start_time' => date(Lang::get('lang_time_format'), strtotime($result['date_time'])), 
                        'event_days' => $event_days, 
                        'online'     => $result['online'], 
                        'link'       => Url::link('content/hangout', '&event_id=' . $result['event_id'], 'SSL'), 
                        'location'   => nl2br($result['location']), 
                        'telephone'  => $result['telephone'] ? $result['telephone'] : 'N/A'
                    );
                endforeach;
            endif;
        endif;
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/event', $data);
    }
}
