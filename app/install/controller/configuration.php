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

namespace Install\Controller;
use Dais\Engine\Controller;
use mysqli;
use PDO;
use PDOException;

class Configuration extends Controller {
    private $error = array();
    
    public function index() {
        $this->theme->setTitle('Dais Install || Step 3 - Configuration');
        
        if (!is_readable($this->get('path.application') . 'dais.sql')):
            $this->response->redirect($this->url->link('welcome'));
        endif;
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $this->theme->model('install');
            
            $this->model_install->database($this->request->post);
            
            $output = '<?php' . "\n\n";
            $output.= '// DB' . "\n";
            $output.= 'define(\'DB_DRIVER\', \'' . addslashes('Db' . $this->request->post['db_driver']) . '\');' . "\n";
            $output.= 'define(\'DB_HOSTNAME\', \'' . addslashes($this->request->post['db_host']) . '\');' . "\n";
            $output.= 'define(\'DB_USERNAME\', \'' . addslashes($this->request->post['db_user']) . '\');' . "\n";
            $output.= 'define(\'DB_PASSWORD\', \'' . addslashes($this->request->post['db_password']) . '\');' . "\n";
            $output.= 'define(\'DB_DATABASE\', \'' . addslashes($this->request->post['db_name']) . '\');' . "\n";
            $output.= 'define(\'DB_PREFIX\', \'' . addslashes($this->request->post['db_prefix']) . '\');' . "\n";
            
            $file = fopen(APP_PATH . 'database/config/db.php', 'w');
            
            fwrite($file, $output);
            
            fclose($file);
            
            $this->response->redirect($this->url->link('finished'));
        endif;
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset($this->error['db_driver'])):
            $data['error_db_driver'] = $this->error['db_driver'];
        else:
            $data['error_db_driver'] = '';
        endif;
        
        if (isset($this->error['db_host'])):
            $data['error_db_host'] = $this->error['db_host'];
        else:
            $data['error_db_host'] = '';
        endif;
        
        if (isset($this->error['db_user'])):
            $data['error_db_user'] = $this->error['db_user'];
        else:
            $data['error_db_user'] = '';
        endif;
        
        if (isset($this->error['db_name'])):
            $data['error_db_name'] = $this->error['db_name'];
        else:
            $data['error_db_name'] = '';
        endif;
        
        if (isset($this->error['db_prefix'])):
            $data['error_db_prefix'] = $this->error['db_prefix'];
        else:
            $data['error_db_prefix'] = '';
        endif;
        
        if (isset($this->error['user_name'])):
            $data['error_user_name'] = $this->error['user_name'];
        else:
            $data['error_user_name'] = '';
        endif;
        
        if (isset($this->error['password'])):
            $data['error_password'] = $this->error['password'];
        else:
            $data['error_password'] = '';
        endif;
        
        if (isset($this->error['email'])):
            $data['error_email'] = $this->error['email'];
        else:
            $data['error_email'] = '';
        endif;
        
        $data['action'] = $this->url->link('configuration');
        
        if (isset($this->request->post['db_driver'])):
            $data['db_driver'] = $this->request->post['db_driver'];
        else:
            $data['db_driver'] = 'mysqli';
        endif;
        
        if (isset($this->request->post['db_host'])):
            $data['db_host'] = $this->request->post['db_host'];
        else:
            $data['db_host'] = 'localhost';
        endif;
        
        if (isset($this->request->post['db_user'])):
            $data['db_user'] = html_entity_decode($this->request->post['db_user']);
        else:
            $data['db_user'] = '';
        endif;
        
        if (isset($this->request->post['db_password'])):
            $data['db_password'] = html_entity_decode($this->request->post['db_password']);
        else:
            $data['db_password'] = '';
        endif;
        
        if (isset($this->request->post['db_name'])):
            $data['db_name'] = html_entity_decode($this->request->post['db_name']);
        else:
            $data['db_name'] = '';
        endif;
        
        if (isset($this->request->post['db_prefix'])):
            $data['db_prefix'] = html_entity_decode($this->request->post['db_prefix']);
        else:
            $data['db_prefix'] = 'dais_';
        endif;
        
        if (isset($this->request->post['user_name'])):
            $data['user_name'] = $this->request->post['user_name'];
        else:
            $data['user_name'] = 'admin';
        endif;
        
        if (isset($this->request->post['password'])):
            $data['password'] = $this->request->post['password'];
        else:
            $data['password'] = '';
        endif;
        
        if (isset($this->request->post['email'])):
            $data['email'] = $this->request->post['email'];
        else:
            $data['email'] = '';
        endif;
        
        $data['back'] = $this->url->link('preinstallation');
        
        $data['header'] = $this->theme->controller('header');
        $data['footer'] = $this->theme->controller('footer');
        
        $this->response->setOutput($this->theme->view('configuration', $data));
    }
    
    private function validate() {
        if (!$this->request->post['db_host']):
            $this->error['db_host'] = 'Host required!';
        endif;
        
        if (!$this->request->post['db_user']):
            $this->error['db_user'] = 'User required!';
        endif;
        
        if (!$this->request->post['db_name']):
            $this->error['db_name'] = 'Database Name required!';
        endif;
        
        if ($this->request->post['db_prefix'] && preg_match('/[^a-z0-9_]/', $this->request->post['db_prefix'])):
            $this->error['db_prefix'] = 'DB Prefix can only contain lowercase characters in the a-z range, 0-9 and "_"!';
        endif;
        
        if ($this->request->post['db_driver'] == 'mysqli'):
            if (function_exists('mysqli_connect')):
                $connection = new mysqli($this->request->post['db_host'], $this->request->post['db_user'], $this->request->post['db_password'], $this->request->post['db_name']);
                
                if (mysqli_connect_error()):
                    $this->error['warning'] = 'Error: Could not connect to the database please make sure the database server, username and password is correct!';
                else:
                    $connection->close();
                endif;
            else:
                $this->error['db_driver'] = 'MySQLi is not supported on your server! Try using PDO MySQL';
            endif;
        endif;
        
        if ($this->request->post['db_driver'] == 'mpdo'):
            try {
                $this->pdo = new PDO("mysql:
					host=" . $this->request->post['db_host'] . ";
					port=3306;
					dbname=" . $this->request->post['db_name'], $this->request->post['db_user'], $this->request->post['db_password'], array(PDO::ATTR_PERSISTENT => true));
            }
            catch(\PDOException $e) {
                $this->error['db_driver'] = 'PDO MySQL is not supported on your server! Try using MySQLi';
            }
        endif;
        
        if (!$this->request->post['user_name']):
            $this->error['user_name'] = 'Username required!';
        endif;
        
        if (!$this->request->post['password']):
            $this->error['password'] = 'Password required!';
        endif;
        
        if (($this->encode->strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])):
            $this->error['email'] = 'Invalid E-Mail!';
        endif;
        
        if (!is_writable(APP_PATH . 'database/config')):
            $this->error['warning'] = 'Error: Could not write to config directory please check you have set the correct permissions on: ' . APP_PATH . 'database/config/!';
        endif;
        
        if (file_exists(APP_PATH . 'database/config/db.php') && filesize(APP_PATH . 'database/config/db.php') > 0):
            $this->error['warning'] = 'Error: Could not write db.php please remove or empty ' . APP_PATH . 'database/config/db.php';
        endif;
        
        return !$this->error;
    }
}
