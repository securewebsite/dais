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

namespace Plugin\Example;
use Dais\Base\Container;
use Dais\Base\Plugin;
use Dais\Service\PluginServiceModel;

class Register extends Plugin {
    
    public function __construct(Container $app) {
        parent::__construct($app);
        parent::setPlugin('example');
    }
    
    public function add() {
        $model = new PluginServiceModel($this->app);
        
        // set all event handlers
        $model->setEventHandler('admin_edit_product', array(
            'plugin' => 'example',
            'file'   => 'admin/events/admin_event',
            'method' => 'editProduct'
        ));
        
        // set all hooks handlers
        $model->setHookHandler('admin_controller', array(
            'class'    => 'tool/test',
            'method'   => 'index',
            'type'     => 'post',
            'plugin'   => 'example',
            'file'     => 'admin/hooks/controller_hooks',
            'callback' => 'exampleHook',
            'args'     => array(
                'heading_title' => 'Example Test Page',
                'item_title'    => 'Item title'
            )
        ));
        
        $model->setHookHandler('admin_controller', array(
            'class'    => 'tool/test',
            'method'   => 'index',
            'type'     => 'pre',
            'plugin'   => 'example',
            'file'     => 'admin/hooks/controller_hooks',
            'callback' => 'preHook'
        ));
    }
    
    public function remove() {
        $model = new PluginServiceModel($this->app);
        
        // remove all event handlers
        $model->removeEventHandler('admin_edit_product', array(
            'plugin' => 'example',
            'file'   => 'admin/events/admin_event',
            'method' => 'editProduct'
        ));
        
        // remove all hook handlers
        $model->removeHookHandler('admin_controller', array(
            'class'    => 'tool/test',
            'method'   => 'index',
            'type'     => 'post',
            'plugin'   => 'example',
            'file'     => 'admin/hooks/controller_hooks',
            'callback' => 'exampleHook',
            'args'     => array(
                'heading_title' => 'Example Test Page',
                'item_title'    => 'Item title'
            )
        ));
        
        $model->removeHookHandler('admin_controller', array(
            'class'    => 'tool/test',
            'method'   => 'index',
            'type'     => 'pre',
            'plugin'   => 'example',
            'file'     => 'admin/hooks/controller_hooks',
            'callback' => 'preHook'
        ));
    }
}
