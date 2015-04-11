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

class Upgrade extends Controller {
    private $error = array();
    
    public function index() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $this->theme->model('upgrade');
            $this->model_upgrade->mysql();
            $this->response->redirect($this->url->link('upgrade/success'));
        endif;
        
        $this->theme->setTitle('Dais Upgrade || Step 1 - Upgrade');
        
        if (!is_readable($this->get('path.application') . 'dais.sql')):
            $this->error['warning'] = 'Your SQL file, dais.sql cannot be found.  Please upload a new version of dais.sql to your <br>app/install directory and reload this page.';
        endif;
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        $data['action'] = $this->url->link('upgrade');
        
        $data['header'] = $this->theme->controller('header');
        $data['footer'] = $this->theme->controller('footer');
        
        $this->response->setOutput($this->theme->view('upgrade', $data));
    }
    
    public function success() {
        $this->theme->setTitle('Dais Upgrade || Step 2 - Finished');
        
        $name = date('m-d-Y-h.i.s', time()) . '.sql';
        
        if (is_readable($this->get('path.application') . 'dais.sql')):
            copy($this->get('path.application') . 'dais.sql', $this->get('path.application') . $name);
            unlink($this->get('path.application') . 'dais.sql');
        endif;
        
        $data['removed'] = true;
        
        if (is_readable($this->get('path.application') . 'dais.sql')):
            $data['removed'] = false;
        endif;
        
        $data['manager'] = 'http://' . $this->request->server['SERVER_NAME'] . '/manage/';
        $data['home']    = 'http://' . $this->request->server['SERVER_NAME'] . '/';
        
        $data['header'] = $this->theme->controller('header');
        $data['footer'] = $this->theme->controller('footer');
        
        $this->response->setOutput($this->theme->view('success', $data));
    }
    
    private function validate() {
        if (DB_DRIVER == 'mysql'):
            if (!$connection = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD)):
                $this->error['warning'] = 'Error: Could not connect to the database please make sure the database server, username and password is correct in the config_php file!';
            else:
                if (!mysql_select_db(DB_DATABASE, $connection)):
                    $this->error['warning'] = 'Error: Database "' . DB_DATABASE . '" does not exist!';
                endif;
                mysql_close($connection);
            endif;
        endif;
        
        if (!is_readable($this->get('path.application') . 'dais.sql')):
            $this->error['warning'] = 'Your SQL file, dais.sql cannot be found.  Please upload a new version of dais.sql to your <br>app/install directory and then click Continue.';
        endif;
        
        return !$this->error;
    }
}
