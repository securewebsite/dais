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

namespace Dais\Services\Communication;

use Dais\Services\Providers\Communication\Language;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LanguageService implements ServiceProviderInterface {

    public function register(Container $app) {
        $key       = 'default.store.language';
        $languages = Cache::get($key);
        
        if (!$languages):
            $languages = array();
            
            $query = DB::query("
                SELECT * 
                FROM `" . DB::prefix() . "language` 
                WHERE status = '1'
            ");
            
            foreach ($query->rows as $result):
                $languages[$result['code']] = $result;
            endforeach;
            
            Cache::set($key, $languages);

            $languages = $languages;

        endif;

        unset($key);

        foreach ($languages as $key => $value):
            $languages[$key]['directory'] = ucfirst($value['directory']);
            $languages[$key]['filename']  = ucfirst($value['filename']);
        endforeach;

        $app['language'] = function($app) use($languages) {
            $this->build($languages);

            $code     = Session::get('language');
            $language = new Language($languages[$code]['directory']);
            $language->load($languages[$code]['filename']);

            return $language;
        };
    }

	public function build($languages) {
        $detect = '';
        
        if (!is_null(Request::server('HTTP_ACCEPT_LANGUAGE')) && Request::server('HTTP_ACCEPT_LANGUAGE')):
            $browser_languages = explode(',', Request::server('HTTP_ACCEPT_LANGUAGE'));
            
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
        
        if (!is_null(Session::get('language')) && array_key_exists(Session::get('language'), $languages) && $languages[Session::get('language')]['status']):
            $code = Session::get('language');
        elseif (!is_null(Request::cookie('language')) && array_key_exists(Request::cookie('language'), $languages) && $languages[Request::cookie('language')]['status']):
            $code = Request::cookie('language');
        elseif ($detect):
            $code = $detect;
        else:
            $code = Config::get('config_language');
        endif;
        
        if (!is_null(Session::get('language')) || Session::get('language') != $code):
            Session::set('language', $code);
        endif;
        
        if (!is_null(Request::cookie('language')) || Request::cookie('language') != $code):
            setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', Request::server('HTTP_HOST'));
        endif;
        
        Config::set('config_language_id', $languages[$code]['language_id']);
	}
}
