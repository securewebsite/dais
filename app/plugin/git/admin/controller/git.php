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

namespace App\Plugin\Git\Admin\Controller;

use App\Controllers\Controller;

class Git extends Controller {
    
    private $error = array();
    private $script_directory;
    
    public function __construct() {
        Plugin::setPlugin('git');
        $this->script_directory = dirname(dirname(__FILE__)) . '/js/';
    }
    
    public function index() {
        $data = Plugin::language('git');
        
        Theme::setTitle(Lang::get('lang_heading_title'));
        
        Plugin::model('setting/setting');
        
        if ((Request::server('REQUEST_METHOD') == 'POST') && $this->validate()):
            SettingSetting::editSetting('git', Request::post());
            Session::set('success', Lang::get('lang_text_success'));
            Response::redirect(Url::link('module/plugin', '', 'SSL'));
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
        
        Breadcrumb::add('lang_text_plugin', 'module/plugin');
        Breadcrumb::add('lang_heading_title', 'plugin/git');
        
        $data['action'] = Url::link('plugin/git', '', 'SSL');
        $data['cancel'] = Url::link('module/plugin', '', 'SSL');
        
        $settings = SettingSetting::getSetting('git');
        
        if (!is_null(Request::post('git_provider'))):
            $data['git_provider'] = Request::post('git_provider');
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
        
        if (!is_null(Request::post('git_url'))):
            $data['git_url'] = Request::post('git_url');
        elseif (isset($settings['git_url'])):
            $data['git_url'] = $settings['git_url'];
        else:
            $data['git_url'] = '';
        endif;
        
        if (!is_null(Request::post('git_branch'))):
            $data['git_branch'] = Request::post('git_branch');
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
        
        if (!is_null(Request::post('git_status'))):
            $data['git_status'] = Request::post('git_status');
        elseif (isset($settings['git_status'])):
            $data['git_status'] = $settings['git_status'];
        else:
            $data['git_status'] = 0;
        endif;
        
        Plugin::model('design/layout');
        
        $data['layouts'] = DesignLayout::getLayouts();
        
        Theme::loadjs('git', $data, $this->script_directory);
        
        $data['header']     = Theme::controller('common/header');
        $data['breadcrumb'] = Theme::controller('common/bread_crumb');
        $data['footer']     = Theme::controller('common/footer');
        
        Response::setOutput(Plugin::view('git', $data));
    }
    
    protected function validate() {
        if (!User::hasPermission('modify', 'plugin/git')):
            $this->error['warning'] = Lang::get('lang_error_permission');
        endif;
        
        if (!Request::post('git_provider')):
            $this->error['git_provider'] = Lang::get('lang_error_git_provider');
        endif;
        
        if (!Request::post('git_url')):
            $this->error['git_url'] = Lang::get('lang_error_git_url');
        endif;
        
        if (!Request::post('git_branch')):
            $this->error['git_branch'] = Lang::get('lang_error_git_branch');
        endif;
        
        return !$this->error;
    }
    
    private function seek() {
        /**
         * The git repo should be located in the user's home directory
         * that's the only repo we want top pull from.
         */

        $directory = dirname(App::appPath());

        if (!in_array('.git', scandir($directory))):
            $this->error['warning'] = Lang::get('lang_error_git_folder');
        endif;

        return !$this->error;
    }
}
