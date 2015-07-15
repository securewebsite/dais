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

namespace App\Plugin\Git;

use Dais\Contracts\PluginRegistryContract;

class Register extends Plugin implements PluginRegistryContract {

    public function __construct() {
        Plugin::setPlugin('git');
    }

    public function add() {}

    public function remove() {}
}
