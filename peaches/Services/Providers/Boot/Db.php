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

namespace Dais\Services\Providers\Boot;

use PDO;
use Dais\Contracts\DBContract;

class Db {
    
    private $db;
    public  $prefix;
    
    public function __construct(DBContract $db) {
        $this->db = $db;
        $this->setPrefix();
    }
    
    public function prepare($sql) {
        return $this->db->prepare($sql);
    }
    
    public function bindParam($parameter, $variable, $data_type = PDO::PARAM_STR, $length = 0) {
        if ($length):
            return $this->db->bindParam($parameter, $variable, $data_type, $length);
        else:
            return $this->db->bindParam($parameter, $variable, $data_type);
        endif;
    }
    
    public function execute() {
        return $this->db->execute();
    }
    
    public function query($sql, array $params = array()) {
        return $this->db->query($sql, $params);
    }
    
    public function escape($value) {
        return $this->db->escape($value);
    }
    
    public function countAffected() {
        return $this->db->countAffected();
    }
    
    public function getLastId() {
        return $this->db->getLastId();
    }
    
    public function prefix() {
        return $this->prefix;
    }

    private function setPrefix() {
        $this->prefix = $this->db->prefix();
    }
}
