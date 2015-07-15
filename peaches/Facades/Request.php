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

namespace Dais\Facades;

use Dais\Support\Facade;

class Request extends Facade {
    
    protected static function getFacadeAccessor() {
        return 'request';
    }

    /*
    |--------------------------------------------------------------------------
    |   Magic p() Method
    |-------------------------------------------------------------------------- 
    |
    |	This method allows us to access properties in our facaded service
    |	via: Facade::p()->property 
    */
   
    public static function p() {
    	return static::getFacadeRoot();
    }
}
