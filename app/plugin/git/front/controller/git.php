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

namespace Plugin\Git\Front\Controller;
use Dais\Base\Container;
use Dais\Base\Plugin;
use Exception;

ignore_user_abort(true);

class Git extends Plugin {
    private $branch;
    protected $directory;
    protected $data;
    
    public function __construct(Container $app) {
        parent::__construct($app);
        parent::setPlugin('git');
    }
    
    public function index() {
        $this->language('git');
        $this->model('setting/setting');
        
        $settings = $this->model_setting_setting->getSetting('git');
        
        // If not enabled, bail testing
        if (!$settings['git_status']):
            return;
        endif;
        
        $this->branch    = $settings['git_branch'];
        $this->directory = dirname(APP_PATH);
        
        if(isset($this->request->post['payload'])):    
            $HTTP_RAW_POST_DATA = $this->request->post['payload'];
        else:
            $HTTP_RAW_POST_DATA = file_get_contents('php://input');
        endif;

        try {
            if (isset($HTTP_RAW_POST_DATA)):
                if ($this->data = json_decode($HTTP_RAW_POST_DATA)):
                    $branch = explode('/', (string)$this->data->ref);
                    $branch = end($branch);
                    if ($branch == $this->branch):
                        
                        // fetch the repo
                        $result = $this->fetch();
                        
                        if ($result):
                            $message = '';
                            foreach ($result as $key => $value):
                                $message.= $value . "\n";
                            endforeach;
                            $message.= "\n\n";
                            
                            mail('vkronlein@icloud.com', 'Deployment', 'Fetch seems to have executed successfully.' . "\n\n" . $message);
                        else:
                            throw new Exception($this->language->get('lang_error_pull_failed'));
                        endif;
                    else:
                        
                        // No need to throw an exception for branches.
                        // Any push will trigger the hook and that's not an error.
                        // just exit.
                        return;
                    endif;
                else:
                    throw new Exception($this->language->get('lang_error_json_decode'));
                endif;
                return false;
            else:
                throw new Exception($this->language->get('lang_error_data_not_set'));
            endif;
        }
        catch(Exception $e) {
            error_log(sprintf("%s >> %s", date('m-d-Y H:i:s'), $e));
        }
    }
    
    private function fetch() {
        
        // Change directory to execute
        chdir($this->directory);
        
        // Fetch files for comparison
        exec("git fetch origin " . $this->branch . " 2>&1", $output);
         // if you experience errors echo $output
        
        // Get local untracked files to delete
        exec("git status --porcelain -u | awk '/^[??]/ {print $2}'", $files);
        
        if (!empty($files)):
            foreach ($files as $index => $file):
                unlink($this->directory . SEP . $file);
            endforeach;
        endif;
        unset($files);
        
        // Get local modified files to checkout
        exec("git diff --name-status | awk '/^[CDRMTUX]/ {print $2}'", $files);
        
        if (!empty($files)):
            foreach ($files as $index => $file):
                exec("git checkout " . $file . " 2>&1", $error);
                 // if you experience errors echo $error
                
            endforeach;
        endif;
        unset($files);
        
        // We should be good now to merge
        exec("git pull origin " . $this->branch . " 2>&1", $result);
        
        return $result;
    }
}
