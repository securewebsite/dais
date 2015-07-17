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

class Waitlist extends Controller {
    
    public function index() {
        $data = Theme::language('account/waitlist');
        Theme::setTitle(Lang::get('lang_heading_title'));
        Theme::model('account/waitlist');
        
        if (isset(Request::p()->get['event_id']) && Customer::isLogged()) {
            AccountWaitlist::remove(Request::p()->get['event_id'], Customer::getId());
            Response::redirect(Url::link('account/waitlist', '', 'SSL'));
        }
        
        Breadcrumb::add('lang_text_dashboard', 'account/dashboard', '', true, 'SSL');
        Breadcrumb::add('lang_text_waitlists', 'account/waitlist', '', true, 'SSL');
        
        $data['waitlists'] = array();
        
        $results = AccountWaitlist::getWaitLists(Customer::getId());
        
        if ($results) {
            foreach ($results as $result) {
                $event_info = AccountWaitlist::getEventInfo($result['event_id']);
                
                $data['waitlists'][] = array('event_id' => $event_info['event_id'], 'name' => html_entity_decode($event_info['name'], ENT_QUOTES, 'UTF-8'), 'start_date' => date(Lang::get('lang_date_format_short'), strtotime($event_info['date_time'])), 'location' => nl2br($event_info['location']), 'telephone' => $event_info['telephone'] ? $event_info['telephone'] : 'N/A', 'remove' => Url::link('account/waitlist', 'event_id=' . $result['event_id'], 'SSL'));
            }
        }
        
        $data['continue'] = Url::link('account/dashboard', '', 'SSL');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::renderControllers($data);
        
        Response::setOutput(View::render('account/waitlist', $data));
    }
}
