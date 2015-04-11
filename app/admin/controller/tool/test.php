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
use Dais\Engine\Controller;
use Dais\Library\Template;
use Dais\Library\Text;

class Test extends Controller {
    public function index() {
        $data = $this->theme->language('tool/test');
        
        $this->theme->setTitle($this->language->get('lang_heading_title'));
        
        if (isset($this->session->data['success'])):
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        else:
            $data['success'] = '';
        endif;
        
        $this->breadcrumb->add('lang_heading_title', 'tool/test');
        
        $data = $this->theme->listen(__CLASS__, __FUNCTION__, $data);
        
        $data = $this->theme->render_controllers($data);
        
        $this->response->setOutput($this->theme->view('tool/test', $data));
    }

    public function email_test($data, $message) {
        //$this->theme->test($data);
        $search = array(
            '!return_id!',
            '!status!',
            '!link!',
            '!comment!'
        );

        $replace = array(
            $data['return_id'],
            $data['status'],
            $data['link'],
            $data['comment']
        );

        $html_replace = array(
            $data['return_id'],
            $data['status'],
            $data['link'],
            nl2br($data['comment'])
        );

        foreach ($message as $key => $value):
            if ($key == 'html'):
                $message['html'] = str_replace($search, $html_replace, $value);
            else:
                $message[$key] = str_replace($search, $replace, $value);
            endif;
        endforeach;
        //$this->theme->test($message);
        return $message;
    }
}
