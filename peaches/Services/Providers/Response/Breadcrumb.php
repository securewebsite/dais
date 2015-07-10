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

namespace Dais\Services\Providers\Response;

class Breadcrumb {
    
    protected $breadcrumbs = array();
    
    public function __construct() { 
        if (Config::get('active.facade') === ADMIN_FACADE):
            $query = (isset(Session::p()->data['token'])) ? 'token=' . Session::p()->data['token'] : false;
            
            $this->breadcrumbs[] = array(
                'text'      => Lang::get('lang_text_dashboard') ,
                'href'      => \Url::link('common/dashboard', $query, 'SSL') ,
                'separator' => false
            );
        else:
            $this->breadcrumbs[] = array(
                'text'      => Lang::get('lang_text_home') ,
                'href'      => '/',
                'separator' => false
            );
        endif;
    }
    
    public function add($text, $route, $query = '', $sep = true, $ssl = 'NONSSL') {
        if ($sep):
            $separator = Lang::get('lang_text_separator');
        else:
            $separator = false;
        endif;
        
        if (Config::get('active.facade') === ADMIN_FACADE):
            $query  = (isset(Session::p()->data['token'])) ? 'token=' . Session::p()->data['token'] . $query : $query;
            $url    = \Url::link($route, $query, 'SSL');
        else:
            if ($ssl == 'SSL'):
                $url = \Url::link($route, $query, 'SSL');
            else:
                $url = \Url::link($route, $query);
            endif;
        endif;
        
        $text = (Lang::get($text)) ? Lang::get($text) : $text;
        
        $this->breadcrumbs[] = array(
            'text'      => $text,
            'href'      => $url,
            'separator' => $separator
        );
    }
    
    public function last($text, $sep = false) {
        if ($sep):
            $separator = Lang::get('lang_text_separator');
        else:
            $separator = false;
        endif;
        
        $text = (Lang::get($text)) ? Lang::get($text) : $text;
        
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
