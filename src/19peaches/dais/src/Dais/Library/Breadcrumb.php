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

namespace Dais\Library;
use Dais\Service\LibraryService;

class Breadcrumb extends LibraryService {
    
    protected $breadcrumbs = array();
    
    public function __construct($app) {
        parent::__construct($app);
        
        if ($app['active.fascade'] === ADMIN_FASCADE):
            $query = (isset($app['session']->data['token'])) ? 'token=' . $app['session']->data['token'] : false;
            
            $this->breadcrumbs[] = array(
                'text'      => $app['language']->get('lang_text_dashboard') ,
                'href'      => $app['url']->link('common/dashboard', $query, 'SSL') ,
                'separator' => false
            );
        else:
            $this->breadcrumbs[] = array(
                'text'      => $app['language']->get('lang_text_home') ,
                'href'      => '/',
                'separator' => false
            );
        endif;
    }
    
    public function add($text, $route, $query = '', $sep = true, $ssl = 'NONSSL') {
        if ($sep):
            $separator = parent::$app['language']->get('lang_text_separator');
        else:
            $separator = false;
        endif;
        
        if (parent::$app['active.fascade'] === ADMIN_FASCADE):
            $query  = (isset(parent::$app['session']->data['token'])) ? 'token=' . parent::$app['session']->data['token'] . $query : $query;
            $url    = parent::$app['url']->link($route, $query, 'SSL');
        else:
            if ($ssl == 'SSL'):
                $url = parent::$app['url']->link($route, $query, 'SSL');
            else:
                $url = parent::$app['url']->link($route, $query);
            endif;
        endif;
        
        $text = (parent::$app['language']->get($text)) ? parent::$app['language']->get($text) : $text;
        
        $this->breadcrumbs[] = array(
            'text'      => $text,
            'href'      => $url,
            'separator' => $separator
        );
    }
    
    public function last($text, $sep = false) {
        if ($sep):
            $separator = parent::$app['language']->get('lang_text_separator');
        else:
            $separator = false;
        endif;
        
        $text = (parent::$app['language']->get($text)) ? parent::$app['language']->get($text) : $text;
        
        $this->breadcrumbs[] = array(
            'link'      => $text,
            'separator' => $separator
        );
    }
    
    public function fetch($pop = false) {
        if ($pop):
            array_shift($this->breadcrumbs);
        endif;
        
        return $this->breadcrumbs;
    }
}
