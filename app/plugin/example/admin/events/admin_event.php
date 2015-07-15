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

namespace App\Plugin\Example\Admin\Events;

use Exception;
use App\Controllers\Controller;

class AdminEvent extends Controller {

    public function __construct() {
        Plugin::setPlugin('example');
    }
    
    // Add call back methods for events below
    public function editProduct($data) {
        return Response::redirect(Url::link('tool/error_log', 'token=' . Session::get('token'), 'SSL'));
    }
}
