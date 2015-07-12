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

namespace Plugin\Git;

use Dais\Base\Container;
use Dais\Base\Plugin;

class Register extends Plugin {
    
    public function __construct(Container $app) {
        parent::__construct($app);
        parent::setPlugin('git');
    }
}
