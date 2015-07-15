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

namespace Dais\Services\Providers\Boot;

use Pimple\Container;

class Config {
    
    private $data = array();

    public function __construct(Container $app, array $env) {
        $this->assemble($app, $env);
    }
    
    public function get($key) {
        return (isset($this->data[$key]) ? $this->data[$key] : null);
    }
    
    public function set($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function has($key) {
        return isset($this->data[$key]);
    }

    public function drop($key) {
        if ($this->has($key)):
            unset($this->data[$key]);
        endif;
    }

    public function assemble(Container $app, array $env) {
        $configuration = [];

        $configuration['base'] = [
            'cache.prefix'   => md5($env['app.env'] . str_replace('.', '', $app->version())),
            'cache.hostname' => $env['cache.hostname'],
            'cache.port'     => $env['cache.port'],
            'cache.time'     => $env['cache.time'],
            'path.app'       => $app->appPath()  . SEP,
            'path.database'  => $app->basePath() . SEP . 'database' . SEP,
            'path.download'  => $app->basePath() . SEP . 'download' . SEP,
            'path.plugin'    => $app->appPath()  . SEP . 'plugin'   . SEP,
            'path.storage'   => $app->basePath() . SEP . 'storage'  . SEP,
            'path.cache'     => $app->basePath() . SEP . 'storage'  . SEP . 'framework' . SEP . 'cache' . SEP,
            'path.logs'      => $app->basePath() . SEP . 'storage'  . SEP . 'logs' . SEP,
            'path.views'     => $app->basePath() . SEP . 'storage'  . SEP . 'framework' . SEP . 'views' . SEP,
            'prefix.plugin'  => 'plugin'
        ];

        if ($env['use.secure'] == 'true'):
            $front_secure = 'https://' . $env['app.env'] . '/';
            $admin_secure = 'https://' . $env['app.env'] . '/' . ADMIN_FACADE . '/';
        else:
            $front_secure = 'http://' . $env['app.env'] . '/';
            $admin_secure = 'http://' . $env['app.env'] . '/' . ADMIN_FACADE . '/';
        endif;

        $configuration[FRONT_FACADE] = [
            'http.server'      => 'http://' . $env['app.env'] . '/',
            'https.server'     => $front_secure,
            'http.public'      => 'http://' . $env['app.env'] . '/',
            'path.application' => $app->appPath()    . SEP . 'controllers' . SEP . 'front' . SEP,
            'path.language'    => $app->appPath()    . SEP . 'language' . SEP . 'front' . SEP,
            'path.theme'       => $app->appPath()    . SEP . 'theme' . SEP . 'front' . SEP,
            'path.public'      => $app->publicPath() . SEP,
            'path.image'       => $app->publicPath() . SEP . 'image' . SEP,
            'path.sessions'    => $app->basePath()   . SEP . 'storage' . SEP . 'framework' . SEP . 'sessions' . SEP . 'front' . SEP,
            'path.asset'       => $app->publicPath() . SEP . 'asset' . SEP,
            'prefix.facade'    => 'front' . SEP
        ];

        $configuration[ADMIN_FACADE] = [
            'http.server'      => 'http://' . $env['app.env'] . '/' . ADMIN_FACADE . '/',
            'http.public'      => 'http://' . $env['app.env'] . '/',
            'https.server'     => $admin_secure,
            'https.public'     => $front_secure,
            'path.application' => $app->appPath()    . SEP . 'controllers' . SEP . 'admin' . SEP,
            'path.language'    => $app->appPath()    . SEP . 'language'    . SEP . 'admin' . SEP,
            'path.theme'       => $app->appPath()    . SEP . 'theme'       . SEP . 'admin' . SEP,
            'path.image'       => $app->publicPath() . SEP . 'image'       . SEP,
            'path.sessions'    => $app->basePath()   . SEP . 'storage'     . SEP . 'framework' . SEP . 'sessions' . SEP . 'admin' . SEP,
            'path.asset'       => $app->publicPath() . SEP . 'asset'       . SEP,
            'prefix.facade'    => 'admin' . SEP
        ];

        $configuration[FRONT_FACADE]['pre_render'] = [
            'header'         => 'content/header',
            'post_header'    => 'common/post_header',
            'column_left'    => 'common/column_left',
            'breadcrumb'     => 'common/bread_crumb',
            'content_top'    => 'common/content_top',
            'content_bottom' => 'common/content_bottom',
            'column_right'   => 'common/column_right',
            'pre_footer'     => 'common/pre_footer',
            'footer'         => 'content/footer',
        ];

        $configuration[ADMIN_FACADE]['pre_render'] = [
            'header'     => 'common/header',
            'breadcrumb' => 'common/bread_crumb',
            'footer'     => 'common/footer',
        ];

        $configuration[FRONT_FACADE]['pre_actions'] = [
            'common/maintenance',
        ];

        $configuration[ADMIN_FACADE]['pre_actions'] = [
            'common/dashboard/login',
            'common/dashboard/permission',
        ];

        foreach ($configuration['base'] as $key => $value):
            $this->data[$key] = $value;
        endforeach;
        
        unset($configuration['base']);

        // Add facade to config
        $face = $app['request']->facade();
        
        $this->data['active.facade'] = $face;

        /**
         * Let's find and remove our pre-render controllers for this facade.
         * Instead of settings those via the loop below, we'll remove them
         * and give them a specific parameter name so we can accurately
         * access them in our Theme class.
         */
        
        if (is_array($configuration[$face]['pre_render'])):
            $this->data['pre.controllers'] = $configuration[$face]['pre_render'];
            unset($configuration[$face]['pre_render']);
        endif;
        
        /**
         * Let's find and remove our pre-actions for this facade.
         * Instead of settings those via the loop below, we'll remove them
         * and give them a specific parameter name so we can accurately
         * access them in our Front class.
         */
        
        if (is_array($configuration[$face]['pre_actions'])):
            $this->data['pre.actions'] = $configuration[$face]['pre_actions'];
            unset($configuration[$face]['pre_actions']);
        endif;
        
        /**
         * Add remaining configuration to config array
         */
        
        foreach ($configuration[$face] as $key => $value):
            $this->data[$key] = $value;
        endforeach;

        unset($configuration);

        $db = $app['db'];

        if ($this->data['active.facade'] === FRONT_FACADE):
            if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))):
                $store_query = $db->query("
                    SELECT * 
                    FROM {$db->prefix}store 
                    WHERE 
                        REPLACE(`ssl`, 'www.', '') = '" . $db->escape('https://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']) , '/.\\') . '/') . "'
                ");
                
                if ($store_query->num_rows):
                    $this->data['config_store_id'] = $store_query->row['store_id'];
                    $this->data['config_url']      = $store_query->row['url'];
                    $this->data['config_ssl']      = $store_query->row['ssl'];
                else:
                    $this->data['config_store_id'] = 0;
                    $this->data['config_url']      = $this->data['http.server'];
                    $this->data['config_ssl']      = $this->data['https.server'];
                endif;
                
                $image_url = $this->data['https.server'] . 'image/';
            else:
                $store_query = $db->query("
                    SELECT * 
                    FROM {$db->prefix}store 
                    WHERE 
                        REPLACE(`url`, 'www.', '') = '" . $db->escape('http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']) , '/.\\') . '/') . "'
                ");
                
                if ($store_query->num_rows):
                    $this->data['config_store_id'] = $store_query->row['store_id'];
                    $this->data['config_url']      = $store_query->row['url'];
                    $this->data['config_ssl']      = $store_query->row['ssl'];
                else:
                    $this->data['config_store_id'] = 0;
                    $this->data['config_url']      = $this->data['http.server'];
                    $this->data['config_ssl']      = $this->data['https.server'];
                endif;
                
                $image_url = $this->data['http.server'] . 'image/';
            endif;
            
            define('IMAGE_URL', $image_url);
        else:
            $this->data['config_store_id'] = 0;
            $this->data['config_url']      = $this->data['http.server'];
            $this->data['config_ssl']      = $this->data['https.server'];
            
            define('IMAGE_URL', $this->data['config_url'] . 'image/');
        endif;
        
        $query = $db->query("
            SELECT * 
            FROM {$db->prefix}setting 
            WHERE store_id = '0' 
            OR store_id = '" . (int)$this->data['config_store_id'] . "' 
            ORDER BY store_id ASC
        ");
        
        $settings = $query->rows;
        
        foreach ($settings as $setting):
            if (!$setting['serialized']):
                $this->data[$setting['item']] = $setting['data'];
            else:
                $this->data[$setting['item']] = unserialize($setting['data']);
            endif;
        endforeach;

        // theme name via facade
        switch($this->data['active.facade']):
            case ADMIN_FACADE:
                $theme_name = $this->data['config_admin_theme'];
                break;
            case FRONT_FACADE:
                $theme_name = $this->data['config_theme'];
                break;
        endswitch;

        $this->data['theme.name'] = $theme_name;

        $this->data['path.filecache'] = $this->data['path.asset'];

        // Image Upload Url for Summernote Editor
        if ($this->data['config_secure']):
            $img_url = $this->data['https.server'] . 'image/';
        else:
            $img_url = $this->data['http.server'] . 'image/';
        endif;
        
        define('PUBLIC_IMAGE', $img_url);
    }
}
