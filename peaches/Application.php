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

use Dais\Start;
use Dais\Facades\Facade;
use Dais\Engine\Container;
use Dais\Contracts\ApplicationContract;

class Application extends Container implements ApplicationContract {

    const VERSION = '1.0.1';

    const ROOT_NAMESPACE_GLOBAL = false;

    const ROOT_NAMESPACE_ANY = true;

    protected static $instance;

    protected $basePath;

    protected $serviceProviders = [];
    
    protected $loadedProviders  = [];
    
    protected $serviceAliases   = [];

    protected $isBooted = false;

    public function __construct($basePath = null) {
        $this->setBasePath($basePath);
        $this->instance();
    }

    public function version() {
        return static::VERSION;
    }

    protected function instance() {
        $this->registerBasePaths();
        $this->registerBaseServices();
        $this->registerBaseProviders();
    }

    public function boot() {
        $this->registerFinalProviders();
        $this->loadServiceProviders();
        $this->isBooted = true;
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
        $start = new Start();

        if (is_readable($file = $this->basePath . '/bootstrap/paths.php')):
            require $file;
        endif;

        // temporarily store boot.config to container
        // so that it can be accessed by RequestConfigService
        $this['boot.config'] = (!empty($config)) ? $config : null;
    }

    public function removeBootConfig() {
        unset($this['boot.config']);
    }

    public function setSettingConfig($config) {
        $this['setting.config'] = $config;
    }

    public function removeSettingConfig() {
        unset($this['setting.config']);
    }

    /**
     * Handle paths and methods
     */
    
    public function setBasePath($basePath) {
        $this->basePath = rtrim($basePath, '\/');
    }

    public function basePath() {
        return $this->basePath;
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
            'Front'       => 'Dais\Facades\Front'
        );

        foreach($facades as $key => $value):
            $this->serviceAliases[$key] = $value;
        endforeach;
    }

    // From ProxyManager
    protected function enable($rootNamespace = self::ROOT_NAMESPACE_ANY) {

        if ($this['alias']->isRegistered()):
            return true;
        endif;

        // Register the loader to handle aliases and link the proxies to the container
        $this['alias']->register($rootNamespace);
        
        return $this['alias']->isRegistered();
    }

    protected function addProxy($alias, $proxyFqcn) {
        if (class_exists($proxyFqcn)):
            $this['alias']->addAlias($alias, $proxyFqcn);
        endif;

        return $this;
    }

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
