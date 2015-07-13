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
        $data = $this->theme->language('account/waitlist');
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        $this->theme->model('account/waitlist');
        
        if (isset($this->request->get['event_id']) && $this->customer->isLogged()) {
            $this->model_account_waitlist->remove($this->request->get['event_id'], $this->customer->getId());
            $this->response->redirect($this->url->link('account/waitlist', '', 'SSL'));
        }
        
        $this->breadcrumb->add('lang_text_dashboard', 'account/dashboard', '', true, 'SSL');
        $this->breadcrumb->add('lang_text_waitlists', 'account/waitlist', '', true, 'SSL');
        
        $data['waitlists'] = array();
        
        $results = $this->model_account_waitlist->getWaitLists($this->customer->getId());
        
        if ($results) {
            foreach ($results as $result) {
                $event_info = $this->model_account_waitlist->getEventInfo($result['event_id']);
                
                $data['waitlists'][] = array('event_id' => $event_info['event_id'], 'name' => html_entity_decode($event_info['name'], ENT_QUOTES, 'UTF-8'), 'start_date' => date($this->language->get('lang_date_format_short'), strtotime($event_info['date_time'])), 'location' => nl2br($event_info['location']), 'telephone' => $event_info['telephone'] ? $event_info['telephone'] : 'N/A', 'remove' => $this->url->link('account/waitlist', 'event_id=' . $result['event_id'], 'SSL'));
            }
        }
        
        $data['continue'] = $this->url->link('account/dashboard', '', 'SSL');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('account/waitlist', $data));
    }
}
