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

namespace App\Models\Front\Widget;
use App\Models\Model;

class Event extends Model {
    public function getEvents($customer_id) {
        $events_data = array();
        
        $events = DB::query("
			SELECT * 
			FROM " . DB::prefix() . "event_manager 
			WHERE date_end > NOW()");
        
        if ($events):
            foreach ($events->rows as $event):
                if (!empty($event['roster'])):
                    foreach (unserialize($event['roster']) as $roster):
                        if ($roster['attendee_id'] == $customer_id):
                            $events_data[] = array(
                                'event_id'   => $event['event_id'], 
                                'date_time'  => $event['date_time'], 
                                'name'       => $event['event_name'], 
                                'online'     => $event['online'], 
                                'link'       => $event['link'], 
                                'location'   => $event['location'], 
                                'event_days' => unserialize($event['event_days']), 
                                'telephone'  => $event['telephone']
                            );
                            break;
                        endif;
                    endforeach;
                endif;
            endforeach;
        endif;
        
        return $events_data;
    }
}
