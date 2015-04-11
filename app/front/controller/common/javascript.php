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

class Javascript extends Controller {
    
    public function index() {
        $scripts = $this->javascript->fetch();
        $data    = $scripts['data'];
        
        $data['scripts'] = $scripts['files'];
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        return $this->theme->view('common/javascript', $data);
    }
    
    public function runner() {
        $this->javascript->register('jquery.min')
            ->register('migrate.min', 'jquery.min')
            ->register('underscore.min', 'migrate.min')
            ->register('cookie.min', 'underscore.min')
            ->register('touchswipe.min', 'cookie.min')
            ->register('bootstrap.min', 'cookie.min')
            ->register('typeahead.min', 'bootstrap.min')
            ->register('jstz.min', 'bootstrap.min')
            ->register('plugin.min', 'jstz.min')
            ->register('video.min', 'plugin.min')
            ->register('youtube', 'video.min')
            ->register('calendar', 'plugin.min')
            ->register('common.min', null, true);
        
        $this->theme->listen(__CLASS__, __FUNCTION__);
    }
    
    public function render() {
        $key  = $this->request->get['js'];
        $file = $this->filecache->get($key);
        
        header('Content-Type: application/javascript');
        echo $file;
    }
}
