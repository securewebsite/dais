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

namespace Dais\Services\Providers;

use Dais\Contracts\EncodeContract; 

class Encode {

	private $encode;

	public function __construct(EncodeContract $encoder) {
		$this->encode = $encoder;
	}

	public function strlen($string) {
        return $this->encode->utf8Strlen($string);
    }
    
    public function strpos($string, $needle, $offset = 0) {
        return $this->encode->utf8Strpos($string, $needle, $offset);
    }
    
    public function strrpos($string, $needle, $offset = 0) {
        return $this->encode->utf8Strrpos($string, $needle, $offset);
    }
    
    public function substr($string, $offset, $length = null) {
        if ($length === null):
            return $this->encode->utf8Substr($string, $offset, $this->strlen($string));
        else:
            return $this->encode->utf8Substr($string, $offset, $length);
        endif;
    }
    
    public function strtoupper($string) {
        return $this->encode->utf8Strtoupper($string);
    }
    
    public function strtolower($string) {
        return $this->encode->utf8Strtolower($string);
    }

    public function riptags($string) {
        // html tags
        $string = preg_replace('/<[^>]*>/', ' ', $string);
        
        // control characters
        // replace with space 
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", ' ', $string);
        $string = str_replace("\t", ' ', $string);
        
        // remove multiple spaces
        $string = trim(preg_replace('/ {2,}/', ' ', $string));
        
        return $string;
    }
}
