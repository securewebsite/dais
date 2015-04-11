<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|   
|   (c) Vince Kronlein <vince@dais.io>
|   
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
*/

namespace Install\Controller;
use Dais\Engine\Controller;

class Preinstallation extends Controller {
    private $error = array();
    
    public function index() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $this->response->redirect($this->url->link('configuration'));
        endif;
        
        $this->theme->setTitle('Dais Install || Step 2 - Pre-Installation');
        
        if (!is_readable($this->get('path.application') . 'dais.sql')):
            $this->response->redirect($this->url->link('welcome'));
        endif;
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $data['action']      = $this->url->link('preinstallation');
        
        $data['config']      = APP_PATH . 'database/config';
        $data['cache']       = STORAGE . 'cache';
        $data['logs']        = STORAGE . 'logs';
        $data['image']       = $this->get('path.dais') . PUBLIC_DIR . 'image';
        $data['image_cache'] = $this->get('path.dais') . PUBLIC_DIR . 'image/cache';
        $data['image_data']  = $this->get('path.dais') . PUBLIC_DIR . 'image/data';
        $data['download']    = APP_PATH . 'download';
        
        $data['back']        = $this->url->link('license');
        
        $data['header']      = $this->theme->controller('header');
        $data['footer']      = $this->theme->controller('footer');
        
        $this->response->setOutput($this->theme->view('preinstallation', $data));
    }
    
    private function validate() {
        if (phpversion() < '5.4'):
            $this->error['warning'] = 'Warning: You need to use PHP 5.4 or above for Dais to work!';
        endif;
        
        if (!ini_get('file_uploads')):
            $this->error['warning'] = 'Warning: file_uploads needs to be enabled!';
        endif;
        
        if (ini_get('session.auto_start')):
            $this->error['warning'] = 'Warning: Dais will not work with session.auto_start enabled!';
        endif;
        
        if (!extension_loaded('mysqli')):
            if (!extension_loaded('pdo_mysql')):
                $this->error['warning'] = 'Warning: Either MySQLi or PDO MySQL extension needs to be loaded for Dais to work!';
            endif;
        endif;
        
        if (!extension_loaded('gd')):
            $this->error['warning'] = 'Warning: GD extension needs to be loaded for Dais to work!';
        endif;
        
        if (!extension_loaded('curl')):
            $this->error['warning'] = 'Warning: CURL extension needs to be loaded for Dais to work!';
        endif;
        
        if (!function_exists('mcrypt_encrypt')):
            $this->error['warning'] = 'Warning: mCrypt extension needs to be loaded for Dais to work!';
        endif;
        
        if (!extension_loaded('zlib')):
            $this->error['warning'] = 'Warning: ZLIB extension needs to be loaded for Dais to work!';
        endif;
        
        if (!extension_loaded('mbstring')):
            $this->error['warning'] = 'Warning: MB String extension needs to be loaded for Dais to work!';
        endif;
        
        if (!is_writable(APP_PATH . 'database/config')):
            $this->error['warning'] = 'Warning: Config directory needs to be writable for Dais to work!';
        endif;
        
        if (!is_writable(STORAGE . 'cache')):
            $this->error['warning'] = 'Warning: Cache directory needs to be writable for Dais to work!';
        endif;
        
        if (!is_writable(STORAGE . 'logs')):
            $this->error['warning'] = 'Warning: Logs directory needs to be writable for Dais to work!';
        endif;
        
        if (!is_writable($this->get('path.dais') . PUBLIC_DIR . 'image')):
            $this->error['warning'] = 'Warning: Image directory needs to be writable for Dais to work!';
        endif;
        
        if (!is_writable($this->get('path.dais') . PUBLIC_DIR . 'image/cache')):
            $this->error['warning'] = 'Warning: Image cache directory needs to be writable for Dais to work!';
        endif;
        
        if (!is_writable($this->get('path.dais') . PUBLIC_DIR . 'image/data')):
            $this->error['warning'] = 'Warning: Image data directory needs to be writable for Dais to work!';
        endif;
        
        if (!is_writable(APP_PATH . 'download')):
            $this->error['warning'] = 'Warning: Download directory needs to be writable for Dais to work!';
        endif;
        
        return !$this->error;
    }
}
