<?php

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

class Mbstring extends LibraryService {

	public function __construct(Container $app) {
		parent::__construct($app);
	}

	public function utf8Strlen($string) {
        return mb_strlen($string);
    }
    
    public function utf8Strpos($string, $needle, $offset = 0) {
        return mb_strpos($string, $needle, $offset);
    }
    
    public function utf8Strrpos($string, $needle, $offset = 0) {
        return mb_strrpos($string, $needle, $offset);
    }
    
    public function utf8Substr($string, $offset, $length = null) {
        if ($length === null):
            return mb_substr($string, $offset, utf8_strlen($string));
        else:
            return mb_substr($string, $offset, $length);
        endif;
    }
    
    public function utf8Strtoupper($string) {
        return mb_strtoupper($string);
    }
    
    public function utf8Strtolower($string) {
        return mb_strtolower($string);
    }
}
