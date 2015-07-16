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

namespace App\Models\Front\Tool;
use App\Models\Model;

class Online extends Model {
    public function whosonline($ip, $customer_id, $url, $referer) {
        DB::query("DELETE FROM `" . DB::prefix() . "customer_online` WHERE (UNIX_TIMESTAMP(`date_added`) + 3600) < UNIX_TIMESTAMP(NOW())");
        
        DB::query("REPLACE INTO `" . DB::prefix() . "customer_online` SET `ip` = '" . DB::escape($ip) . "', `customer_id` = '" . (int)$customer_id . "', `url` = '" . DB::escape($url) . "', `referer` = '" . DB::escape($referer) . "', `date_added` = NOW()");
    }
}
