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

namespace Dais\Services\Communication;

use Dais\Services\Providers\Communication\Mail;
use Dais\Base\Container;
use Dais\Contracts\ServiceContract;

class MailService implements ServiceContract {

	public function register(Container $app) {
		$app['mailer'] = function ($app) {
            return new Mail;
        };
	}
}
