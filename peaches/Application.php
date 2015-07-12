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

namespace Dais;

use Dais\Support\Start;
use Dais\Facades\Facade;
use Pimple\Container;
use Dais\Contracts\ApplicationContract;

class Application extends Container implements ApplicationContract {

    const VERSION = '1.0.1';

    const ROOT_NAMESPACE_GLOBAL = false;

    const ROOT_NAMESPACE_ANY = true;

    protected static $instance;

    protected $basePath;

    protected $appPath;

    protected $publicPath;

    protected $serviceProviders = [];
    
    protected $loadedProviders  = [];
    
    protected $serviceAliases   = [];

    protected $isBooted = false;

    public function __construct($basePath = null) {
        static::setInstance($this);

        $this->setBasePath($basePath);

        $this->registerBasePaths();
        $this->registerBaseServices();
        $this->registerBaseProviders();
        
        
    }

    public function version() {
        return static::VERSION;
    }

    public function boot() {
        $this->registerFinalProviders();
        $this->loadServiceProviders();
        $this->isBooted = true;
    }

    public static function setInstance(ApplicationContract $container) {
        static::$instance = $container;
    }

    public static function instance() {
        return static::$instance;
    }

    /**
     * Service Provider Methods
     */
    public function registerServiceProviders(array $providers) {
        foreach ($providers as $provider):
            $this->registerProvider($provider);
        endforeach;
    }

    protected function registerBaseProviders() {
        foreach ($this->baseProviders() as $provider):
            $this->registerProvider($provider);
        endforeach;
    }

    protected function loadServiceProviders() { 
        foreach ($this->serviceProviders as $provider):
            $this->loadProvider($provider);
        endforeach;
    }

    protected function registerFinalProviders() { 
        foreach ($this->finalProviders() as $provider):
            $this->registerProvider($provider);
        endforeach;
    }

    public function registerProvider($provider) {
        if (!in_array($provider, $this->serviceProviders)):
            if (class_exists($provider)):
                $this->serviceProviders[] = $provider;
            endif;
        endif;
    }

    protected function loadProvider($provider) {
        if (!in_array($provider, $this->loadedProviders)):
            if (class_exists($provider) && $this->register(new $provider)):
                $this->registerLoadedProvider($provider);
            endif;
        endif;
    }

    protected function registerLoadedProvider($provider) {
        foreach($this->serviceProviders as $key => $class):
            if ($class === $provider):
                $this->loadedProviders[] = $provider;
                unset($this->serviceProviders[$key]);
            endif;
        endforeach;

        if (count($this->serviceProviders) === 0):
            unset($this->serviceProviders);
        endif;
    }

    protected function registerBaseServices() {
        $this->registerProxyService();
        $this->registerApplicationService();
    }

    protected function registerProxyService() {

        if (env('APP_DEBUG') == 'true'):
           $this->register(new Services\Utility\WhoopsService); 
        endif;

        $this->registerFacades();

        if (!in_array('Dais\Services\Boot\AliasService', $this->loadedProviders)):
            $this->register(new Services\Boot\AliasService);
            $this->loadedProviders[] = 'Dais\Services\Boot\AliasService';
        endif;

        foreach($this->serviceAliases as $key => $class):
            $this->addProxy($key, $class);
        endforeach;

        $this->enable();

        unset($this->serviceAliases);
    }

    protected function registerApplicationService() {
        if (!in_array('Dais\Services\Boot\ApplicationService', $this->loadedProviders)):
            $this->register(new Services\Boot\ApplicationService);
            $this->loadedProviders[] = 'Dais\Services\Boot\ApplicationService';
        endif;
    }

    public function listLoadedServices() {
        $loaded = array();

        foreach ($this->loadedProviders as $provider):
            $name = str_replace('\\', '/', $provider);
            $loaded[basename($name)] = $provider;
        endforeach;

        return $loaded;
    }

    /**
     * Proxy Methods
     */

    public function loadProxy($key, $class) {
        $loaded = $this['alias']->getAliases();

        if (!in_array($class, $loaded)):
            $this->addProxy($key, $class)->enable();
        endif;
    }

    /**
     * Handle our configuration array within the container
     */

    protected function registerBasePaths() {
        // Include our start file that detects server goodness
        Start::detect();

        // convert our global $_ENV to a more elegant array for paths
        $env = array();

        foreach($_ENV as $key => $value):
            $env[strtolower(str_replace('_', '.', $key))] = $value;
        endforeach;

        $config = [];

        $base   = array(
            'cache.prefix'   => md5($env['app.env'] . str_replace('.', '', static::VERSION)),
            'cache.hostname' => $env['cache.hostname'],
            'cache.port'     => $env['cache.port'],
            'cache.time'     => $env['cache.time'],
            'path.app'       => $this->appPath() . SEP,
            'path.database'  => $this->appPath() . SEP . 'database' . SEP,
            'path.download'  => $this->basePath() . SEP . 'download' . SEP,
            'path.plugin'    => $this->appPath() . SEP . 'plugin' . SEP,
            'path.storage'   => $this->basePath() . SEP . 'storage' . SEP,
            'path.cache'     => $this->basePath() . SEP . 'storage' . SEP . 'framework' . SEP . 'cache' . SEP,
            'path.logs'      => $this->basePath() . SEP . 'storage' . SEP . 'logs' . SEP,
            'path.views'     => $this->basePath() . SEP . 'storage' . SEP . 'framework' . SEP . 'views' . SEP,
            'prefix.plugin'  => 'plugin'
        );

        // DO NOT CHANGE THE NAME OF THIS KEY

        $config['base'] = $base;

        if ($env['use.secure'] == 'true'):
            $front_secure = 'https://' . $env['app.env'] . '/';
            $admin_secure = 'https://' . $env['app.env'] . '/' . ADMIN_FACADE . '/';
        else:
            $front_secure = 'http://' . $env['app.env'] . '/';
            $admin_secure = 'http://' . $env['app.env'] . '/' . ADMIN_FACADE . '/';
        endif;

        $front = array(
            'http.server'      => 'http://' . $env['app.env'] . '/',
            'https.server'     => $front_secure,
            'http.public'      => 'http://' . $env['app.env'] . '/',
            'path.application' => $this->appPath() . SEP . 'front' . SEP,
            'path.language'    => $this->appPath() . SEP . 'front' . SEP . 'language' . SEP,
            'path.theme'       => $this->appPath() . SEP . 'theme' . SEP . 'front' . SEP,
            'path.public'      => $this->publicPath() . SEP,
            'path.image'       => $this->publicPath() . SEP . 'image' . SEP,
            'path.sessions'    => $this->basePath() . SEP . 'storage' . SEP . 'framework' . SEP . 'sessions' . SEP . 'front' . SEP,
            'path.asset'       => $this->publicPath() . SEP . 'asset' . SEP,
            'prefix.facade'    => 'front' . SEP
        );

        $config[FRONT_FACADE] = $front;

        $admin = array(
            'http.server'      => 'http://' . $env['app.env'] . '/' . ADMIN_FACADE . '/',
            'http.public'      => 'http://' . $env['app.env'] . '/',
            'https.server'     => $admin_secure,
            'https.public'     => $front_secure,
            'path.application' => $this->appPath() . SEP . 'admin' . SEP,
            'path.language'    => $this->appPath() . SEP . 'admin' . SEP . 'language' . SEP,
            'path.theme'       => $this->appPath() . SEP . 'theme' . SEP . 'admin' . SEP,
            'path.image'       => $this->publicPath() . SEP . 'image' . SEP,
            'path.sessions'    => $this->basePath() . SEP . 'storage' . SEP . 'framework' . SEP . 'sessions' . SEP . 'admin' . SEP,
            'path.asset'       => $this->publicPath() . SEP . 'asset' . SEP,
            'prefix.facade'    => 'admin' . SEP
        );

        $config[ADMIN_FACADE] = $admin;

        $front_controllers = array(
            'header'         => 'content/header',
            'post_header'    => 'common/post_header',
            'column_left'    => 'common/column_left',
            'breadcrumb'     => 'common/bread_crumb',
            'content_top'    => 'common/content_top',
            'content_bottom' => 'common/content_bottom',
            'column_right'   => 'common/column_right',
            'pre_footer'     => 'common/pre_footer',
            'footer'         => 'content/footer',
        );

        $config[FRONT_FACADE]['pre_render'] = $front_controllers;

        $admin_controllers = array(
            'header'     => 'common/header',
            'breadcrumb' => 'common/bread_crumb',
            'footer'     => 'common/footer',
        );

        $config[ADMIN_FACADE]['pre_render'] = $admin_controllers;

        $front_actions = array(
            'common/maintenance',
            'common/javascript/runner',
        );

        $config[FRONT_FACADE]['pre_actions'] = $front_actions;

        $admin_actions = array(
            'common/javascript/runner',
            'common/dashboard/login',
            'common/dashboard/permission',
        );

        $config[ADMIN_FACADE]['pre_actions'] = $admin_actions;

        // temporarily store boot.config to container
        // so that it can be accessed by ConfigService
        $this['boot.config'] = (!empty($config)) ? $config : null;
    }

    public function removeBootConfig() {
        unset($this['boot.config']);
    }

    /**
     * Handle paths and methods
     */
    
    public function setBasePath($basePath) {
        $this->basePath = rtrim($basePath, '\/');
        $this->setAppPath();
    }

    public function basePath() {
        return $this->basePath;
    }

    public function setAppPath() {
        $this->appPath = $this->basePath() . SEP . 'app';
        $this->setPublicPath();
    }

    public function appPath() {
        return $this->appPath;
    }

    public function setPublicPath() {
        $this->publicPath = $this->basePath() . SEP . 'public';
    }

    public function publicPath() {
        return $this->publicPath;
    }

    /**
     * Setters and Getters for the container.
     */

    public function get($key) {
        return $this[$key];
    }

    public function set($key, $value) {
        $this[$key] = $value;
    }

    public function load($key, $class) {
        $this[$key] = function($this) use($class) {
            return new $class;
        };
    }

    public function has($key) {
        return isset($this[$key]);
    }

    protected function registerFacades() {
        Facade::setContainer($this);

        $facades = array(
            'App'         => 'Dais\Facades\App',
            'DB'          => 'Dais\Facades\Db',
            'Request'     => 'Dais\Facades\Request',
            'Config'      => 'Dais\Facades\Config',
            'Cache'       => 'Dais\Facades\Cache',
            'Encode'      => 'Dais\Facades\Encode',
            'Log'         => 'Dais\Facades\Log',
            'Response'    => 'Dais\Facades\Response',
            'Session'     => 'Dais\Facades\Session',
            'Lang'        => 'Dais\Facades\Language',
            'Currency'    => 'Dais\Facades\Currency',
            'Weight'      => 'Dais\Facades\Weight',
            'Length'      => 'Dais\Facades\Length',
            'Filecache'   => 'Dais\Facades\Filecache',
            'Mailer'      => 'Dais\Facades\Mailer',
            'Decorator'   => 'Dais\Facades\Decorator',
            'Email'       => 'Dais\Facades\Email',
            'Notify'      => 'Dais\Facades\Notify',
            'Filter'      => 'Dais\Facades\Filter',
            'Validator'   => 'Dais\Facades\Validator',
            'Keyword'     => 'Dais\Facades\Keyword',
            'Routes'      => 'Dais\Facades\Routes',
            'Url'         => 'Dais\Facades\Url',
            'Breadcrumb'  => 'Dais\Facades\Breadcrumb',
            'Encryption'  => 'Dais\Facades\Encryption',
            'User'        => 'Dais\Facades\User',
            'Customer'    => 'Dais\Facades\Customer',
            'Tax'         => 'Dais\Facades\Tax',
            'Cart'        => 'Dais\Facades\Cart',
            'Search'      => 'Dais\Facades\Search',
            'JS'          => 'Dais\Facades\Javascript',
            'CSS'         => 'Dais\Facades\Css',
            'Paginate'    => 'Dais\Facades\Paginate',
            'PluginModel' => 'Dais\Facades\PluginModel',
            'Theme'       => 'Dais\Facades\Theme',
            'Event'       => 'Dais\Facades\Event',
            'Hook'        => 'Dais\Facades\Hook',
            'Plugin'      => 'Dais\Facades\Plugin',
            'Router'      => 'Dais\Facades\Router',
            'Front'       => 'Dais\Facades\Front',
        );

        foreach($facades as $key => $value):
            $this->serviceAliases[$key] = $value;
        endforeach;
    }

    protected function enable($rootNamespace = self::ROOT_NAMESPACE_ANY) {

        if ($this['alias']->isRegistered()):
            return true;
        endif;

        // Register the loader to handle aliases and link to the container
        $this['alias']->register($rootNamespace);
        
        return $this['alias']->isRegistered();
    }

    protected function addProxy($alias, $proxyFqcn) {
        if (class_exists($proxyFqcn)):
            $this['alias']->addAlias($alias, $proxyFqcn);
        endif;

        return $this;
    }

    // public static function getInstance() {

    //     if (!(static::$instance instanceof Container)):
    //         throw new \RuntimeException('The Proxy Subject cannot be retrieved because the Container is not set.');
    //     endif;

    //     return static::$instance->get(static::getInstanceIdentifier());
    // }

    // public static function getInstanceIdentifier() {

    //     //throw new \BadMethodCallException('The' . __METHOD__ . ' method must be implemented by a subclass.');
    // }

    // public static function __callStatic($method, $args) {
        
    //     return call_user_func_array(array(static::getInstance(), $method), $args);
    // }

    /**
     * Service Providers
     */

    protected function baseProviders() {
        return [
            Services\Boot\DatabaseService::class,
            Services\Boot\RequestService::class,
            Services\Boot\ConfigService::class,
            Services\Storage\CacheService::class,
            Services\Storage\EncodeService::class,
            Services\Storage\LogService::class,
            Services\Response\ResponseService::class,
            Services\Storage\SessionService::class,
            Services\Communication\LanguageService::class,
            Services\Utility\CurrencyService::class,
            Services\Utility\WeightService::class,
            Services\Utility\LengthService::class,
            Services\Storage\FilecacheService::class,
            Services\Communication\MailService::class,
            Services\Utility\DecoratorService::class,
            Services\Communication\EmailService::class,
            Services\Communication\NotificationService::class,
            Services\Communication\FilterService::class,
            Services\Utility\ValidateService::class,
            Services\Communication\KeywordService::class,
            Services\Response\RoutesService::class,
            Services\Response\UrlService::class,
            Services\Response\BreadcrumbService::class,
            Services\Utility\EncryptionService::class,
            Services\People\MemberService::class,
            Services\Response\SearchService::class,
            Services\Response\ErrorService::class,
            Services\Response\JavascriptService::class,
            Services\Response\CssService::class,
            Services\Response\PaginateService::class,
        ];
    }

    protected function finalProviders() {
        return[
            Services\Base\PluginModelService::class,
            Services\Base\ThemeService::class,
            Services\Base\EventService::class,
            Services\Base\HookService::class,
            Services\Base\PluginService::class,
            Services\Base\RouterService::class,
            Services\Base\FrontService::class,
        ];
    }
    
    public function fire() {
        if (!$this->isBooted):
            $this->boot();
        endif;
        
        $this['front']->output();
    }
}
