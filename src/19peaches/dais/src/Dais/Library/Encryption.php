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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Encryption extends LibraryService {
    private $key;
    
    public function __construct($key, Container $app) {
        parent::__construct($app);
        
        $this->key = hash('sha256', $key, true);
    }
    
    public function encrypt($value) {
        return strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $this->key, true) , $value, MCRYPT_MODE_ECB)) , '+/=', '-_,');
    }
    
    public function decrypt($value) {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, hash('sha256', $this->key, true) , base64_decode(strtr($value, '-_,', '+/=')) , MCRYPT_MODE_ECB));
    }
}
