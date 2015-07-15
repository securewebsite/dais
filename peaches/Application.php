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

use Pimple\Container;
use Dais\Support\Start;
use Dais\Support\Alias;
use Dais\Support\Facade;
use Dais\Contracts\ApplicationContract;

class Application extends Container implements ApplicationContract {

    const VERSION = '1.0.1';

    const ROOT_NAMESPACE_GLOBAL = false;

    const ROOT_NAMESPACE_ANY    = true;

    protected static $instance;

    protected static $aliases = [];

    protected $basePath;

    protected $appPath;

    protected $publicPath;

    protected $serviceProviders = [];
    
    protected $loadedProviders  = [];

    protected $loadedAliases    = [];

    protected $isBooted = false;

    public function __construct($basePath = null) {
        static::setInstance($this);

        $this->setBasePath($basePath);

        $this->registerBaseServices();
        $this->registerBaseProviders();
    }

    /*
    |--------------------------------------------------------------------------
    |   Instantiation
    |--------------------------------------------------------------------------
    */
   
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

    /*
    |--------------------------------------------------------------------------
    |   Provider Registry
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    |   Provider Loading
    |--------------------------------------------------------------------------
    */

    protected function loadServiceProviders() { 
        foreach ($this->serviceProviders as $provider):
            $this->loadProvider($provider);
        endforeach;
    }

    protected function loadProvider($provider) {
        if (!in_array($provider, $this->loadedProviders)):
            if (class_exists($provider) && $this->register(new $provider)):
                $this->registerLoadedProvider($provider);
            endif;
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

    /*
    |--------------------------------------------------------------------------
    |   Start Up Methods
    |-------------------------------------------------------------------------- 
    */

    protected function registerBaseServices() {
        
        Start::detect(); // Include our start file that detects server goodness

        if (env('APP_DEBUG') == 'true'):
           //$this->register(new Services\Utility\WhoopsService); 
        endif;

        static::registerAliases();
        $loader = Alias::getInstance();
        
        foreach(static::$aliases as $class => $alias):
            $loader->alias($class, $alias);
            $this->loadedAliases[$class] = $alias;
            unset(static::$aliases[$class]);
        endforeach;

        $loader->register(static::ROOT_NAMESPACE_ANY);
        
        $this->registerApplicationService();
    }

    protected function registerApplicationService() {
        if (!in_array('Dais\Services\Boot\ApplicationService', $this->loadedProviders)):
            $this->register(new Services\Boot\ApplicationService);
            $this->loadedProviders[] = 'Dais\Services\Boot\ApplicationService';
        endif;
    }

    /*
    |--------------------------------------------------------------------------
    |   Paths and Config Generation
    |-------------------------------------------------------------------------- 
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

    /*
    |--------------------------------------------------------------------------
    |   Setter and Getter for the Container
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    |   Alias Methods
    |--------------------------------------------------------------------------   
    */
   
    public function loadAlias($class, $key) {
        // load aliases on the fly
    }

    protected static function registerAliases() {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication(static::$instance);

        $aliases = [
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
        ];

        foreach($aliases as $class => $alias):
            static::$aliases[$class] = $alias;
        endforeach;
    }

    /*
    |--------------------------------------------------------------------------
    |   Service Providers
    |--------------------------------------------------------------------------  
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
