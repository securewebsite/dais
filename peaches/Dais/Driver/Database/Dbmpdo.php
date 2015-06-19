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

namespace Dais\Driver\Database;
use PDO;
use PDOException;
use stdClass;

final class Dbmpdo {
    private $pdo = null;
    private $statement = null;
    private $prefix;
    
    public function __construct($hostname, $username, $password, $database, $prefix, $port = "3306") {
        $this->prefix = $prefix;
        
        try {
            $this->pdo = new PDO("mysql:host=" . $hostname . ";port=" . $port . ";dbname=" . $database, $username, $password, array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
        }
        catch(PDOException $e) {
            trigger_error('Error: Could not make a database link ( ' . $e->getMessage() . '). Error Code : ' . $e->getCode() . ' <br />');
        }
        
        $this->pdo->exec("SET NAMES 'utf8'");
        $this->pdo->exec("SET CHARACTER SET utf8");
        $this->pdo->exec("SET CHARACTER_SET_CONNECTION=utf8");
        $this->pdo->exec("SET SQL_MODE = ''");
    }
    
    public function prepare($sql) {
        $this->statement = $this->pdo->prepare($sql);
    }
    
    public function bindParam($parameter, $variable, $data_type = PDO::PARAM_STR, $length = 0) {
        if ($length):
            $this->statement->bindParam($parameter, $variable, $data_type, $length);
        else:
            $this->statement->bindParam($parameter, $variable, $data_type);
        endif;
    }
    
    public function execute() {
        try {
            if ($this->statement && $this->statement->execute()):
                $data = array();
                
                while ($row = $this->statement->fetch(PDO::FETCH_ASSOC)):
                    $data[] = $row;
                endwhile;
                
                $result = new stdClass();
                $result->row = (isset($data[0]) ? $data[0] : array());
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            endif;
        }
        catch(PDOException $e) {
            trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
        }
        
        if ($result):
            return $result;
        else:
            $result = new stdClass();
            $result->row = array();
            $result->rows = array();
            $result->num_rows = 0;
            return $result;
        endif;
    }
    
    public function query($sql, $params = array()) {
        $this->statement = $this->pdo->prepare($sql);
        $result = false;
        
        try {
            if ($this->statement && $this->statement->execute($params)):
                $data = array();
                
                while ($row = $this->statement->fetch(PDO::FETCH_ASSOC)):
                    $data[] = $row;
                endwhile;
                
                $result = new stdClass();
                $result->row = (isset($data[0]) ? $data[0] : array());
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            endif;
        }
        catch(PDOException $e) {
            trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
        }
        
        if ($result):
            return $result;
        else:
            $result = new stdClass();
            $result->row = array();
            $result->rows = array();
            $result->num_rows = 0;
            return $result;
        endif;
    }
    
    public function escape($value) {
        $search = array("\\", "\0", "\n", "\r", "\x1a", "'", '"');
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"');
        return str_replace($search, $replace, $value);
    }
    
    public function countAffected() {
        if ($this->statement):
            return $this->statement->rowCount();
        else:
            return 0;
        endif;
    }
    
    public function getLastId() {
        return $this->pdo->lastInsertId();
    }
    
    public function prefix() {
        return $this->prefix;
    }
    
    public function __destruct() {
        $this->pdo = null;
    }
}
