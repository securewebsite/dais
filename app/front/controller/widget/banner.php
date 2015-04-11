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

class Banner extends Controller {
    public function index($setting) {
        static $widget = 0;
        
        $this->theme->model('design/banner');
        $this->theme->model('tool/image');
        
        $data['banners'] = array();
        
        $results = $this->model_design_banner->getBanner($setting['banner_id']);
        
        foreach ($results as $result) {
            if (file_exists($this->app['path.image'] . $result['image'])) {
                $result['link'] = ($this->config->get('config_ucfirst')) ? $this->url->cap_slug($result['link']) : $result['link'];
                
                $data['banners'][] = array('title' => $result['title'], 'link' => $result['link'], 'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']));
            }
        }
        
        $data['widget'] = $widget++;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('widget/banner', $data);
    }
}
