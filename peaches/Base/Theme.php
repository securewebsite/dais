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

namespace Dais\Base;

use Dais\Base\View;
use Dais\Base\Action;
use Dais\Support\Naming;

abstract class Theme {
    
    protected $title;
    protected $description;
    protected $keywords;
    protected $ogimage;
    protected $ogtitle;
    protected $ogsite;
    protected $ogdescription;
    protected $ogtype;
    protected $ogurl;
    protected $canonical;
    
    protected $links       = [];
    protected $controllers = [];
    
    protected $style;
    protected $path;
    protected $assetPath;
    
    /*
    |--------------------------------------------------------------------------
    |   Paths
    |--------------------------------------------------------------------------
    |
    |   Set up paths for use throughout the entire application, and set the
    |   style for your home page.
    |
    */

    public function setPath($path = null) {
        if (is_null($path)):
            $path = Config::get('path.theme') . Config::get('theme.name') . SEP;
        endif;

        $this->path = $path;

        Config::set('theme.path', $this->path);
    }

    public function getPath() {
        return $this->path;
    }

    public function setStyle($style = null) {
        if (is_null($style)):
            $style = Config::get('config_site_style');
        endif;

        $this->style = $style;

        Config::set('theme.style', $this->style);
    }

    public function getStyle() {
        return $this->style;
    }

    public function setAssetPath($path = null) {
        $this->assetPath = $path;

        Config::set('theme.asset.path', $this->assetPath);
    }


    /*
    |--------------------------------------------------------------------------
    |	Controllers Section
    |--------------------------------------------------------------------------
    |
    |	This section manipulates and sets up all our controllers for the app
    |	to run. Use the {set/unset}_controller methods in your controller to add or
    |	remove controllers from the render.
    |
    */
   
    public function setController($key, $file) {
        $this->controllers[$key] = $file;
    }
    
    public function unsetController($key) {
        unset($this->controllers[$key]);
    }
    
    public function controller($route) {
        $args = func_get_args();
        array_shift($args);
        
        return (new Action($route, $args))->execute();
    }
    
    public function renderControllers($data) {
        foreach ($this->controllers as $key => $route):
            $data[$key] = $this->controller($route);
        endforeach;
        
        return $data;
    }
    
    public function buildControllers() {
        if (Config::has('pre.controllers')):
            $controllers = Config::get('pre.controllers');
            foreach ($controllers as $key => $file):
                $this->controllers[$key] = $file;
            endforeach;
            
            Config::drop('pre.controllers');
        endif;
    }

    /*
    |--------------------------------------------------------------------------
    |   Model Builder
    |--------------------------------------------------------------------------
    |
    |   Build and add any models to the service container and alias loader.
    |
    */
    
    public function model($model) {
        $key = Naming::model_key($model);

        if (!App::offsetExists($key)):
            $class = Naming::class_for_model($model);
            App::load($key, $class);
        endif;
    }

    /*
    |--------------------------------------------------------------------------
    |   Language
    |--------------------------------------------------------------------------
    |
    |   Load and return language vars.
    |
    */

    public function language($language, $data = array()) {
        $lang = Lang::load($language);
        
        if (!empty($data)):
            $lang = array_merge($data, $lang);
        endif;
        
        return $lang;
    }

    /*
    |--------------------------------------------------------------------------
    |   Views and Javascript
    |--------------------------------------------------------------------------
    |
    |   Set and render views and javascript for the theme.
    |
    */
    
    public function view($template, $data = []) {
        //$view = new View();
        return \View::render($template, $data); 
    }
    
    public function loadjs($file, $data, $path = '') {
        JS::load($file, $data, $path);
    }

    /*
    |--------------------------------------------------------------------------
    |   Pagination
    |--------------------------------------------------------------------------
    |
    |   Render pagination for theme views.
    |
    */
   
    public function paginate($total, $page, $limit, $text, $url) { 
        Paginate::set('total', $total);
        Paginate::set('page', $page);
        Paginate::set('limit', $limit);
        Paginate::set('text', $text);
        Paginate::set('url', $url);
        
        return Paginate::render();
    }
    
    /*
    |--------------------------------------------------------------------------
    |   File Finder
    |--------------------------------------------------------------------------
    |
    |   Builds an array of files from both the theme and application 
    |   directories based on the passed in directory and current theme.
    |   
    */
    
    public function getFiles($directory = '*') {
        $filenames = array();
        $files     = array();
        
        $core_files  = glob(Config::get('path.application') . $directory . SEP . '*.php');
        $theme_files = glob(Config::get('path.theme') . Config::get('theme.name') . SEP . 'controllers' . SEP . $directory . SEP . '*.php');
        
        if (!empty($theme_files)):
            foreach ($theme_files as $file):
                $file_data   = explode(SEP, dirname($file));
                $filename    = end($file_data) . SEP . basename($file, '.php');
                $filenames[] = $filename;
                $files[]     = $file;
            endforeach;
        endif;
        
        if (!empty($core_files)):
            foreach ($core_files as $file):
                $file_data = explode(SEP, dirname($file));
                $filename  = end($file_data) . SEP . basename($file, '.php');
                if (!in_array($filename, $filenames)):
                    $files[] = $file;
                endif;
            endforeach;
        endif;
        
        return $files;
    }

    /*
    |--------------------------------------------------------------------------
    |   Document Properties
    |--------------------------------------------------------------------------
    |
    |   The below methods set up your document properties.
    |
    */
    
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setDescription($description) {
        $this->description = Encode::riptags($description);
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }
    
    public function getKeywords() {
        return $this->keywords;
    }
    
    public function setOgImage($image) {
        $this->ogimage = $image;
    }
    
    public function getOgImage() {
        return $this->ogimage;
    }
    
    public function setOgType($type) {
        $this->ogtype = $type;
    }
    
    public function getOgType() {
        return $this->ogtype;
    }
    
    public function setOgSite($site) {
        $this->ogsite = $site;
    }
    
    public function getOgSite() {
        return $this->ogsite;
    }
    
    public function setOgTitle($title) {
        $this->ogtitle = $title;
    }
    
    public function getOgTitle() {
        return $this->ogtitle;
    }
    
    public function setOgUrl($url) {
        $this->ogurl = $url;
    }
    
    public function getOgUrl() {
        return $this->ogurl;
    }
    
    public function setOgDescription($description) {
        $this->ogdescription = Encode::riptags($description);
    }
    
    public function getOgDescription() {
        return $this->ogdescription;
    }
    
    public function setCanonical($url) {
        $this->canonical = $url;
    }
    
    public function getCanonical() {
        return $this->canonical;
    }
    
    public function addLink($href, $rel) {
        $this->links[$href] = array('href' => $href, 'rel' => $rel);
    }
    
    public function getLinks() {
        return $this->links;
    }
    
    /*
    |--------------------------------------------------------------------------
    |   Hooks and Events
    |--------------------------------------------------------------------------
    |   
    |   All methods relating to your hooks and events are processed here.
    |
    */
   
    public function trigger($event, $data = array()) {
        // First let's fire any plugin events so that
        // our theme isn't changing any data that the plugin
        // might need to remain unchanged.
        if (App::offsetExists('plugin')):
            $data = \Plugin::trigger($event, $data);
        endif;
        
        // Now let's push our revised data to theme events.
        return $this->fire_theme_events($event, $data);
    }
    
    public function listen($class, $method, $data = array()) {
        // First let's fire any plugin hooks so that
        // our theme isn't changing any data that the plugin
        // might need to remain unchanged.
        if (App::offsetExists('plugin')):
            $data = \Plugin::listen($class, $method, $data);
        endif;
        
        // Now let's push revised data to theme hooks.
        return $this->fire_theme_hooks($class, $method, $data);
    }
    
    /**
     * This method allows devs to call hooks directly in
     * theme controllers or models.
     * @param  $route  route to controller file
     * @param  $method method to execute
     * @param  $data   controller data passed in
     * @return $data   data array passed back from hook
     */
    public function hook($route, $method, $data = array()) {
        $class = Naming::class_for_hook($route);
        
        if (is_callable(array($class, $method))):
            return call_user_func_array(array($class, $method), array($data));
        endif;
        
        return $data;
    }

    protected function fire_theme_hooks($class, $method, $data = array()) {
        // Todo:
        // when building theme hooks ensure that your hook
        // passes back either the original or altered $data variable
        // otherwise the data from your controller will be lost.
        
        return $data;
    }
    
    protected function fire_theme_events($event, $data = array()) {
        // Todo:
        // when building theme events ensure that your event
        // passes back either the original or altered $data variable
        // otherwise the data from your controller will be lost.
        
        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    |   Nofitications
    |--------------------------------------------------------------------------
    |
    |   Create email then pass to notification class for wrapping and sending.
    */

    /**
     * @param  text $name name of email_slug from database
     * @param  array $data notification specific variables to decorate in notification
     * @param  array $additional added emails to use for CC
     * @return none
     */
    public function notify($name, $data, $add = array()) {
        /**
         * Set order_id and order if in $data, this should work
         * for both orders and returns for the notification.
         */
        
        if (isset($data['order_id'])):
            $order_id = $data['order_id'];
        elseif (isset($data['return_id'])):
            $order_id = $data['return_id'];
        else:
            $order_id = 0;
        endif;

        if (isset($data['order'])):
            $order = $data['order'];
        elseif (isset($data['return'])):
            $order = $data['return'];
        else:
            $order = false;
        endif;

        Notify::setOrderId($order_id);

        /**
         * ALL notifications require either a customer_id 
         * or user_id (admin) in order to create all the 
         * parts required to send an email notification.
         */
        
        $type = Notify::getNotificationType($name);

        // Process receiver and get variables such as notification preferences.
        switch ($type['recipient']):
            case 1: // customer
                if (array_key_exists('customer_id', $data)):
                    Notify::setCustomer($type['email_id'], $data['customer_id'], $order);
                    unset($data['customer_id']);
                else:
                    return;
                endif;
                break;
            case 2: // admin user
                if (array_key_exists('user_id', $data)):
                    Notify::setUser($data['user_id']);
                    unset($data['user_id']);
                else: 
                    return;
                endif;
                break;
            default:
                break;
        endswitch;
        
        // fetch our text/html email message
        $message = Notify::fetch($name);

        // Let's grab our priority before we re-write the message
        $priority = $message['priority'];

        // Fetch the proper wrapper for this email priority
        Notify::fetchWrapper($priority);

        /**
         * There's no need to pass in a callback unless you have
         * variables in your message that need to be replaced 
         * outside of the default Decorator tags. It's always 
         * required to pass in an array that includes either
         * customer_id or user_id based on who the notification 
         * goes to.
         *
         * Pass in a callback method as an array so we know 
         * where to build the notification. If you wanted the 
         * callback in the same class that's calling it, and 
         * you've created a method named: 'myEmailCallback', 
         * you can use something like the below to build your 
         * notification.
         *
         * Keep in mind that the callback array MUST be
         * named 'callback' or it will not be found.
         *     
         *     $callback = array(
         *         'class'  => __CLASS__,
         *         'method' => 'myEmailCallback'
         *     );
         *     
         *     $notify = array(
         *         'customer_id' => 123,
         *         'order_id'    => 345,
         *         'callback'    => $callback //include your $callback array from above
         *     );
         *
         * Or simply inline it like so:
         *     
         *     $notify = array(
         *         'customer_id' => 123,
         *         'order_id'    => 345,
         *         'callback'    => array(
         *             'class'  => __CLASS__,
         *             'method' => 'myEmailCallback'
         *         )
         *     );
         *     
         * Then pass it to this method with the notification name:
         *     
         *     $this->theme->notify('my_email_name', $notify);
         * 
         */
        
        if (array_key_exists('callback', $data)):
            // set up our class and method
            $class  = $data['callback']['class'];
            $method = $data['callback']['method'];
            // unset the callback from our data array
            unset($data['callback']);

            // create a new object
            $class = new $class(self::$app);

            if (is_callable(array($class, $method))):
                /**
                 * We're not using call_user_func_array to call
                 * the method because we want to retain key names
                 * inside our $data array.
                 */
                $message = $class->{$method}($data, $message); 
            endif;
        endif;

        $preference = Notify::getPreference();

        /**
         * Our next actions depend entirely on the $preference array.
         * If the user has requested an internal notification, we'll process
         * that first as it has no wrapper, then move on to email formatting.
         */
        
        if ($preference['internal']):
            switch ($type['recipient']):
                case 1:
                    Notify::customerInternal($message);
                    break;
                case 2:
                    break;
            endswitch;
        endif;

        /**
         * Now that we've handled internal messaging, let's handle
         * the email portion.
         */
        
        if ($preference['email']):
            // Let's wrap and format the email message. 
            $message = Notify::formatEmail($message, $type['recipient']);

            if ($priority == 1):
                Notify::send($message, $add);
            else:
                Notify::addToEmailQueue($message);
            endif;
        endif;
    }
}
