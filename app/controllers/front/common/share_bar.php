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

namespace App\Controllers\Front\Common;

use App\Controllers\Controller;

class ShareBar extends Controller {

	public function index($data) {
		$type = array_shift($data);
		$data = Theme::language('common/share_bar', $data[0]);

		Theme::model('setting/setting');

		$settings = SettingSetting::getSetting('share_bar');

		foreach($settings as $key => $setting):
			$data[$key] = $setting;
		endforeach;
		
		/**
		 * We'll use this type variable to change the pull.
		 */
		
		$data['type'] = $type;

		switch ($type):
			case 'product':
				$href        = Url::link('catalog/product', 'product_id=' . $data['product_id']);
				$description = $data['description'];
				break;
			case 'page':
				$href        = Url::link('content/page', 'page_id=' . $data['page_id']);
				$description = $data['description'];
				$data['pinterest_enabled'] = false;
				break;
			case 'post':
				$href        = Url::link('content/post', 'post_id=' . $data['post_id']);
				$description = $data['description'];
				$data['pinterest_enabled'] = false;
				break;
			case 'event':
				$href        = Url::link('event/page', 'event_page_id=' . $data['event_page_id']);
				$description = $data['description'];
				$data['pinterest_enabled'] = false;
				break;
		endswitch;

		$data['social_href'] = $href;
		$data['social_desc'] = urlencode($data['heading_title'] . "\n" . substr(strip_tags($description), 0, 500) . "...");
		
		$data['social_site'] = Config::get('config_name');

		$data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::make('common/share_bar', $data);
	}
}
