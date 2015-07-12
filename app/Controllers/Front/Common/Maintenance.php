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
use Dais\Base\Action;
use Dais\Services\Providers\User;

class Maintenance extends Controller {
    public function index() {
        if (Config::get('config_maintenance')) {
            $route = '';
            
            if (isset($this->request->get['route'])) {
                $part = explode('/', $this->request->get['route']);
                
                if (isset($part[0])) {
                    $route.= $part[0];
                }
            }
            
            // Show site if logged in as admin
            $this->user = new User;
            
            Theme::listen(__CLASS__, __FUNCTION__);
            
            if (($route != 'payment') && !$this->user->isLogged()) {
                return new Action('common/maintenance/info');
            }
        }
    }
    
    public function info() {
        $data = Theme::language('common/maintenance');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Breadcrumb::add('lang_text_maintenance', 'common/maintenance');
        
        $data['message'] = Lang::get('lang_text_message');
        
        $data = Theme::listen(__CLASS__, __FUNCTION__, $data);
        
        $data = Theme::render_controllers($data);
        
        $this->response->setOutput(Theme::view('common/maintenance', $data));
    }
}
