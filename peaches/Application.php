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

        // We need to load our model facades
        switch($this['config']->get('active.facade')):
            case FRONT_FACADE:
                $models = $this->registerModels('front');
                break;
            case ADMIN_FACADE:
                $models = $this->registerModels('admin');
                break;
        endswitch;

        $aliases = Alias::getInstance()->getAliases();

        $aliases = array_merge($aliases, $models);

        Alias::getInstance($aliases)->register(static::ROOT_NAMESPACE_ANY);

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
           $this->register(new Services\Utility\WhoopsService); 
        endif;

        $this->registerAliases();
        $this->registerApplicationService();

        Alias::getInstance(static::$aliases)->register(static::ROOT_NAMESPACE_ANY);
        
        foreach(static::$aliases as $class => $alias):
            $this->registerAlias($class, $alias);
            unset(static::$aliases[$class]);
        endforeach;
        
        $this->registerBaseProviders();
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
        $loader = Alias::getInstance();
        $loader->alias($class, $key);
        $loader->register();
    }

    protected function registerAlias($class, $alias) {
        $this->loadedAliases[$class] = $alias;
    }

    public function registerClassAliases(array $aliases) {
        foreach ($aliases as $class => $alias):
            static::$aliases[$class] = $alias;
        endforeach;
    }

    protected function registerAliases() {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($this);

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
            'View'        => 'Dais\Facades\View',
            'Event'       => 'Dais\Facades\Event',
            'Hook'        => 'Dais\Facades\Hook',
            'Plugin'      => 'Dais\Facades\Plugin',
            'Router'      => 'Dais\Facades\Router',
            'Front'       => 'Dais\Facades\Front',
            'Naming'      => 'Dais\Support\Naming',
            'Action'      => 'Dais\Base\Action',
        ];

        foreach($aliases as $class => $alias):
            static::$aliases[$class] = $alias;
        endforeach;
    }

    protected function registerModels($module) {
        
        $models = [
            'admin' => [
                'CalendarEvent'          => 'App\Models\Admin\Facades\CalendarEvent',
                'CatalogAttribute'       => 'App\Models\Admin\Facades\CatalogAttribute',
                'CatalogAttributeGroup'  => 'App\Models\Admin\Facades\CatalogAttributeGroup',
                'CatalogCategory'        => 'App\Models\Admin\Facades\CatalogCategory',
                'CatalogDownload'        => 'App\Models\Admin\Facades\CatalogDownload',
                'CatalogFilter'          => 'App\Models\Admin\Facades\CatalogFilter',
                'CatalogManufacturer'    => 'App\Models\Admin\Facades\CatalogManufacturer',
                'CatalogOption'          => 'App\Models\Admin\Facades\CatalogOption',
                'CatalogProduct'         => 'App\Models\Admin\Facades\CatalogProduct',
                'CatalogRecurring'       => 'App\Models\Admin\Facades\CatalogRecurring',
                'CatalogReview'          => 'App\Models\Admin\Facades\CatalogReview',
                'ContentCategory'        => 'App\Models\Admin\Facades\ContentCategory',
                'ContentComment'         => 'App\Models\Admin\Facades\ContentComment',
                'ContentPage'            => 'App\Models\Admin\Facades\ContentPage',
                'ContentPost'            => 'App\Models\Admin\Facades\ContentPost',
                'DesignBanner'           => 'App\Models\Admin\Facades\DesignBanner',
                'DesignLayout'           => 'App\Models\Admin\Facades\DesignLayout',
                'DesignRoute'            => 'App\Models\Admin\Facades\DesignRoute',
                'LocaleCountry'          => 'App\Models\Admin\Facades\LocaleCountry',
                'LocaleCurrency'         => 'App\Models\Admin\Facades\LocaleCurrency',
                'LocaleGeoZone'          => 'App\Models\Admin\Facades\LocaleGeoZone',
                'LocaleLanguage'         => 'App\Models\Admin\Facades\LocaleLanguage',
                'LocaleLengthClass'      => 'App\Models\Admin\Facades\LocaleLengthClass',
                'LocaleOrderStatus'      => 'App\Models\Admin\Facades\LocaleOrderStatus',
                'LocaleReturnAction'     => 'App\Models\Admin\Facades\LocaleReturnAction',
                'LocaleReturnReason'     => 'App\Models\Admin\Facades\LocaleReturnReason',
                'LocaleReturnStatus'     => 'App\Models\Admin\Facades\LocaleReturnStatus',
                'LocaleStockStatus'      => 'App\Models\Admin\Facades\LocaleStockStatus',
                'LocaleTaxClass'         => 'App\Models\Admin\Facades\LocaleTaxClass',
                'LocaleTaxRate'          => 'App\Models\Admin\Facades\LocaleTaxRate',
                'LocaleWeightClass'      => 'App\Models\Admin\Facades\LocaleWeightClass',
                'LocaleZone'             => 'App\Models\Admin\Facades\LocaleZone',
                'ModuleMenu'             => 'App\Models\Admin\Facades\ModuleMenu',
                'ModuleNotification'     => 'App\Models\Admin\Facades\ModuleNotification',
                'PaymentPayflowIframe'   => 'App\Models\Admin\Facades\PaymentPayflowIframe',
                'PaymentPaypalExpress'   => 'App\Models\Admin\Facades\PaymentPaypalExpress',
                'PaymentPaypalProIframe' => 'App\Models\Admin\Facades\PaymentPaypalProIframe',
                'PeopleCustomer'         => 'App\Models\Admin\Facades\PeopleCustomer',
                'PeopleCustomerBanIp'    => 'App\Models\Admin\Facades\PeopleCustomerBanIp',
                'PeopleCustomerGroup'    => 'App\Models\Admin\Facades\PeopleCustomerGroup',
                'PeopleUser'             => 'App\Models\Admin\Facades\PeopleUser',
                'PeopleUserGroup'        => 'App\Models\Admin\Facades\PeopleUserGroup',
                'ReportAffiliate'        => 'App\Models\Admin\Facades\ReportAffiliate',
                'ReportCoupon'           => 'App\Models\Admin\Facades\ReportCoupon',
                'ReportCustomer'         => 'App\Models\Admin\Facades\ReportCustomer',
                'ReportDashboard'        => 'App\Models\Admin\Facades\ReportDashboard',
                'ReportOnline'           => 'App\Models\Admin\Facades\ReportOnline',
                'ReportProduct'          => 'App\Models\Admin\Facades\ReportProduct',
                'ReportReturns'          => 'App\Models\Admin\Facades\ReportReturns',
                'ReportSale'             => 'App\Models\Admin\Facades\ReportSale',
                'SaleCoupon'             => 'App\Models\Admin\Facades\SaleCoupon',
                'SaleFraud'              => 'App\Models\Admin\Facades\SaleFraud',
                'SaleGiftCard'           => 'App\Models\Admin\Facades\SaleGiftCard',
                'SaleGiftCardTheme'      => 'App\Models\Admin\Facades\SaleGiftCardTheme',
                'SaleOrder'              => 'App\Models\Admin\Facades\SaleOrder',
                'SaleRecurring'          => 'App\Models\Admin\Facades\SaleRecurring',
                'SaleReturns'            => 'App\Models\Admin\Facades\SaleReturns',
                'SettingModule'          => 'App\Models\Admin\Facades\SettingModule',
                'SettingSetting'         => 'App\Models\Admin\Facades\SettingSetting',
                'SettingStore'           => 'App\Models\Admin\Facades\SettingStore',
                'ToolBackup'             => 'App\Models\Admin\Facades\ToolBackup',
                'ToolImage'              => 'App\Models\Admin\Facades\ToolImage',
                'ToolUtility'            => 'App\Models\Admin\Facades\ToolUtility',
            ],
            'front' => [
                'AccountAddress'         => 'App\Models\Front\Facades\AccountAddress',
                'AccountAffiliate'       => 'App\Models\Front\Facades\AccountAffiliate',
                'AccountCredit'          => 'App\Models\Front\Facades\AccountCredit',
                'AccountCustomer'        => 'App\Models\Front\Facades\AccountCustomer',
                'AccountCustomerGroup'   => 'App\Models\Front\Facades\AccountCustomerGroup',
                'AccountDownload'        => 'App\Models\Front\Facades\AccountDownload',
                'AccountNotification'    => 'App\Models\Front\Facades\AccountNotification',
                'AccountOrder'           => 'App\Models\Front\Facades\AccountOrder',
                'AccountProduct'         => 'App\Models\Front\Facades\AccountProduct',
                'AccountRecurring'       => 'App\Models\Front\Facades\AccountRecurring',
                'AccountReturns'         => 'App\Models\Front\Facades\AccountReturns',
                'AccountReward'          => 'App\Models\Front\Facades\AccountReward',
                'AccountWaitlist'        => 'App\Models\Front\Facades\AccountWaitlist',
                'CatalogCategory'        => 'App\Models\Front\Facades\CatalogCategory',
                'CatalogManufacturer'    => 'App\Models\Front\Facades\CatalogManufacturer',
                'CatalogProduct'         => 'App\Models\Front\Facades\CatalogProduct',
                'CatalogReview'          => 'App\Models\Front\Facades\CatalogReview',
                'CheckoutCoupon'         => 'App\Models\Front\Facades\CheckoutCoupon',
                'CheckoutFraud'          => 'App\Models\Front\Facades\CheckoutFraud',
                'CheckoutGiftCard'       => 'App\Models\Front\Facades\CheckoutGiftCard',
                'CheckoutGiftCardTheme'  => 'App\Models\Front\Facades\CheckoutGiftCardTheme',
                'CheckoutOrder'          => 'App\Models\Front\Facades\CheckoutOrder',
                'CheckoutRecurring'      => 'App\Models\Front\Facades\CheckoutRecurring',
                'ContentAuthor'          => 'App\Models\Front\Facades\ContentAuthor',
                'ContentCategory'        => 'App\Models\Front\Facades\ContentCategory',
                'ContentComment'         => 'App\Models\Front\Facades\ContentComment',
                'ContentPage'            => 'App\Models\Front\Facades\ContentPage',
                'ContentPost'            => 'App\Models\Front\Facades\ContentPost',
                'DesignBanner'           => 'App\Models\Front\Facades\DesignBanner',
                'DesignLayout'           => 'App\Models\Front\Facades\DesignLayout',
                'LocaleCountry'          => 'App\Models\Front\Facades\LocaleCountry',
                'LocaleCurrency'         => 'App\Models\Front\Facades\LocaleCurrency',
                'LocaleLanguage'         => 'App\Models\Front\Facades\LocaleLanguage',
                'LocaleReturnReason'     => 'App\Models\Front\Facades\LocaleReturnReason',
                'LocaleZone'             => 'App\Models\Front\Facades\LocaleZone',
                'PaymentExpressIpn'      => 'App\Models\Front\Facades\PaymentExpressIpn',
                'PaymentPayflowIframe'   => 'App\Models\Front\Facades\PaymentPayflowIframe',
                'PaymentPaypalExpress'   => 'App\Models\Front\Facades\PaymentPaypalExpress',
                'PaymentPaypalProIframe' => 'App\Models\Front\Facades\PaymentPaypalProIframe',
                'SettingMenu'            => 'App\Models\Front\Facades\SettingMenu',
                'SettingModule'          => 'App\Models\Front\Facades\SettingModule',
                'SettingSetting'         => 'App\Models\Front\Facades\SettingSetting',
                'SettingStore'           => 'App\Models\Front\Facades\SettingStore',
                'ToolImage'              => 'App\Models\Front\Facades\ToolImage',
                'ToolOnline'             => 'App\Models\Front\Facades\ToolOnline',
                'ToolUtility'            => 'App\Models\Front\Facades\ToolUtility',
                'WidgetEvent'            => 'App\Models\Front\Facades\WidgetEvent',
            ],
        ];

        return $models[$module];
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
            Services\Base\ViewService::class,
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
