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

namespace Admin\Controller\Tool;
use Dais\Base\Controller;

class Test extends Controller {
    public function index() {
        $data = Theme::language('tool/test');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        Breadcrumb::add('lang_heading_title', 'tool/test');

        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        $data = Theme::render_controllers($data);
        
        Response::setOutput(Theme::view('tool/test', $data));
    }
}
