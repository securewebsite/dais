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

namespace Dais\Services;

use Dais\Services\Providers\Language;
use Dais\Engine\Container;
use Dais\Contracts\ServiceContract;

class LanguageService implements ServiceContract {

    public function register(Container $app) {
        $key       = 'default.store.language';
        $languages = Cache::get($key);
        
        if (!$languages):
            $languages = array();
            
            $query = DB::query("
                SELECT * 
                FROM `" . DB::p()->prefix . "language` 
                WHERE status = '1'
            ");
            
            foreach ($query->rows as $result):
                $languages[$result['code']] = $result;
            endforeach;
            
            Cache::set($key, $languages);
        endif;

        $languages = $languages;

        unset($key);

        $app['language'] = function($app) use($languages) {
            $this->build($languages);

            $code     = Session::p()->data['language'];
            $language = new Language($languages[$code]['directory']);
            $language->load($languages[$code]['filename']);

            return $language;
        };
    }

	public function build($languages) {
        $detect = '';
        
        if (isset(Request::p()->server['HTTP_ACCEPT_LANGUAGE']) && Request::p()->server['HTTP_ACCEPT_LANGUAGE']):
            $browser_languages = explode(',', Request::p()->server['HTTP_ACCEPT_LANGUAGE']);
            
            foreach ($browser_languages as $browser_language):
                foreach ($languages as $key => $value):
                    if ($value['status']):
                        $locale = explode(',', $value['locale']);
                        if (in_array($browser_language, $locale)):
                            $detect = $key;
                        endif;
                    endif;
                endforeach;
            endforeach;
        endif;
        
        if (isset(Session::p()->data['language']) && array_key_exists(Session::p()->data['language'], $languages) && $languages[Session::p()->data['language']]['status']):
            $code = Session::p()->data['language'];
        elseif (isset(Request::p()->cookie['language']) && array_key_exists(Request::p()->cookie['language'], $languages) && $languages[Request::p()->cookie['language']]['status']):
            $code = Request::p()->cookie['language'];
        elseif ($detect):
            $code = $detect;
        else:
            $code = Config::get('config_language');
        endif;
        
        if (!isset(Session::p()->data['language']) || Session::p()->data['language'] != $code):
            Session::p()->data['language'] = $code;
        endif;
        
        if (!isset(Request::p()->cookie['language']) || Request::p()->cookie['language'] != $code):
            setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', Request::p()->server['HTTP_HOST']);
        endif;
        
        Config::set('config_language_id', $languages[$code]['language_id']);
	}
}
