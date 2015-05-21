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

namespace Front\Controller\Common;
use Dais\Engine\Controller;

class PreFooter extends Controller {
    public function index() {
        $this->theme->model('design/layout');
        $this->theme->model('catalog/category');
        $this->theme->model('catalog/product');
        $this->theme->model('content/page');
        
        if (isset($this->request->get['route'])) {
            $route = (string)$this->request->get['route'];
        } else {
            $route = $this->theme->style . '/home';
        }
        
        $layout_id = 0;
        
        if ($route == 'catalog/category' && isset($this->request->get['path'])) {
            $path = explode('_', (string)$this->request->get['path']);
            
            $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
        }
        
        if ($route == 'catalog/product' && isset($this->request->get['product_id'])) {
            $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
        }
        
        if ($route == 'content/page' && isset($this->request->get['page_id'])) {
            $layout_id = $this->model_content_page->getPageLayoutId($this->request->get['page_id']);
        }
        
        if (!$layout_id) {
            $layout_id = $this->model_design_layout->getLayout($route);
        }
        
        if (!$layout_id) {
            $layout_id = $this->config->get('config_layout_id');
        }
        
        $widget_data = array();
        
        $this->theme->model('setting/module');
        
        $modules = $this->model_setting_module->getModules('widget');
        
        foreach ($modules as $module) {
            $widgets = $this->config->get($module['code'] . '_widget');
            
            if ($widgets) {
                foreach ($widgets as $widget) {
                    if ($widget['layout_id'] == $layout_id && $widget['position'] == 'pre_footer' && $widget['status']) {
                        $widget_data[] = array('code' => $module['code'], 'setting' => $widget, 'sort_order' => $widget['sort_order']);
                    }
                }
            }
        }
        
        $sort_order = array();
        
        $widget_count = 0;
        
        foreach ($widget_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
            $widget_count++;
        }
        
        array_multisort($sort_order, SORT_ASC, $widget_data);
        
        $data['widgets'] = array();
        
        foreach ($widget_data as $widget) {
            $widget = $this->theme->controller('widget/' . $widget['code'], $widget['setting']);
            
            if ($widget) {
                $data['widgets'][] = $widget;
            }
        }
        
        // Max count for blocks should be 4, anything more would be badly formatted
        $data['class'] = 0;
        
        switch ($widget_count):
        case 1:
            $count = 12;
            break;

        case 2:
            $count = 6;
            break;

        case 3:
            $count = 4;
            break;

        case 4:
            $count = 3;
            break;

        case $widget_count > 4:
            $count = 3;
            break;
        endswitch;
        
        $data['class'] = $count;
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('common/pre_footer', $data);
    }
}
