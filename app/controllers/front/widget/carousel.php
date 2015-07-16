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

class Carousel extends Controller {
    
    public function index($setting) {
        static $widget = 0;
        
        Theme::model('design/banner');
        Theme::model('tool/image');
        
        JS::register('carousel.min', 'bootstrap.min');
        
        $data['limit'] = $setting['limit'];
        $data['scroll'] = $setting['scroll'];
        
        $data['banners'] = array();
        
        $results = DesignBanner::getBanner($setting['banner_id']);
        
        foreach ($results as $result) {
            if (file_exists(Config::get('path.image') . $result['image'])) {
                $result['link'] = (Config::get('config_ucfirst')) ? Url::cap_slug($result['link']) : $result['link'];
                
                $data['banners'][] = array('title' => $result['title'], 'link' => $result['link'], 'image' => ToolImage::resize($result['image'], $setting['width'], $setting['height']));
            }
        }
        
        $data['widget'] = $widget++;
        
        Theme::loadjs('javascript/widget/carousel', $data);
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        return View::render('widget/carousel', $data);
    }
}
