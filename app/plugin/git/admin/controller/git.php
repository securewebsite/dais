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

namespace Plugin\Git\Admin\Controller;
use Dais\Engine\Container;
use Dais\Engine\Plugin;

class Git extends Plugin {
    
    private $error = array();
    private $script_directory;
    
    public function __construct(Container $app) {
        parent::__construct($app);
        parent::setPlugin('git');
        
        $this->script_directory = dirname(dirname(__FILE__)) . '/js/';
    }
    
    public function index() {
        $data = $this->language('git');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        $this->model('setting/setting');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()):
            $this->model_setting_setting->editSetting('git', $this->request->post);
            $this->session->data['success'] = $this->language->get('lang_text_success');
            $this->response->redirect($this->url->link('module/plugin', 'token=' . $this->session->data['token'], 'SSL'));
        endif;
        
        // test to see if we can find a local git repo
        $this->seek();
        
        if (isset($this->error['warning'])):
            $data['error_warning'] = $this->error['warning'];
        else:
            $data['error_warning'] = '';
        endif;
        
        if (isset($this->error['git_provider'])):
            $data['error_git_provider'] = $this->error['git_provider'];
        else:
            $data['error_git_provider'] = '';
        endif;
        
        if (isset($this->error['git_url'])):
            $data['error_git_url'] = $this->error['git_url'];
        else:
            $data['error_git_url'] = '';
        endif;
        
        if (isset($this->error['git_branch'])):
            $data['error_git_branch'] = $this->error['git_branch'];
        else:
            $data['error_git_branch'] = '';
        endif;
        
        $this->breadcrumb->add('lang_text_plugin', 'module/plugin');
        $this->breadcrumb->add('lang_heading_title', 'plugin/git');
        
        $data['action'] = $this->url->link('plugin/git', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('module/plugin', 'token=' . $this->session->data['token'], 'SSL');
        
        $settings = $this->model_setting_setting->getSetting('git');
        
        if (isset($this->request->post['git_provider'])):
            $data['git_provider'] = $this->request->post['git_provider'];
        elseif (isset($settings['git_provider'])):
            $data['git_provider'] = $settings['git_provider'];
        else:
            $data['git_provider'] = 0;
        endif;
        
        $data['git_providers'] = array();
        
        $providers = array(
            1 => 'Code Solution',
            2 => 'GitHub',
            3 => 'BeanStalk',
            4 => 'BitBucket',
            5 => 'Gitorious',
            6 => 'Google Code',
        );
        
        foreach ($providers as $key => $value):
            $data['git_providers'][] = array(
                'id' => $key,
                'name' => $value
            );
        endforeach;
        
        if (isset($this->request->post['git_url'])):
            $data['git_url'] = $this->request->post['git_url'];
        elseif (isset($settings['git_url'])):
            $data['git_url'] = $settings['git_url'];
        else:
            $data['git_url'] = '';
        endif;
        
        if (isset($this->request->post['git_branch'])):
            $data['git_branch'] = $this->request->post['git_branch'];
        elseif (isset($settings['git_branch'])):
            $data['git_branch'] = $settings['git_branch'];
        else:
            $data['git_branch'] = '';
        endif;
        
        $data['git_branches'] = array();
        
        $branches = array(
            'master',
            'develop',
            'release',
            'feature',
            'hotfix'
        );
        
        foreach ($branches as $branch):
            $data['git_branches'][] = array(
                'name' => $branch
            );
        endforeach;
        
        if (isset($this->request->post['git_status'])):
            $data['git_status'] = $this->request->post['git_status'];
        elseif (isset($settings['git_status'])):
            $data['git_status'] = $settings['git_status'];
        else:
            $data['git_status'] = 0;
        endif;
        
        $this->model('design/layout');
        
        $data['layouts'] = $this->model_design_layout->getLayouts();
        
        $this->theme->loadjs('git', $data, $this->script_directory);
        
        $data['header']     = $this->theme->controller('common/header');
        $data['breadcrumb'] = $this->theme->controller('common/breadcrumb');
        $data['footer']     = $this->theme->controller('common/footer');
        
        $this->response->setOutput($this->view('git', $data));
    }
    
    protected function validate() {
        if (!$this->user->hasPermission('modify', 'plugin/git')):
            $this->error['warning'] = $this->language->get('lang_error_permission');
        endif;
        
        if (!$this->request->post['git_provider']):
            $this->error['git_provider'] = $this->language->get('lang_error_git_provider');
        endif;
        
        if (!$this->request->post['git_url']):
            $this->error['git_url'] = $this->language->get('lang_error_git_url');
        endif;
        
        if (!$this->request->post['git_branch']):
            $this->error['git_branch'] = $this->language->get('lang_error_git_branch');
        endif;
        
        return !$this->error;
    }
    
    private function seek() {
        /**
         * The git repo should be located in the user's home directory
         * that's the only repo we want top pull from.
         */

        $directory = dirname(APP_PATH);

        if (!in_array('.git', scandir($directory))):
            $this->error['warning'] = $this->language->get('lang_error_git_folder');
        endif;

        return !$this->error;
    }
}
