<?php

/*
|--------------------------------------------------------------------------
|    Egress
|--------------------------------------------------------------------------
|
|    This file is part of the Dais Framework package.
|    
|    Egress is a recoded version of Ruckusing Migrations for full
|    integration into the Dais Framework. For the original version and
|    details on Ruckusing Migrations see:
|    
|    https://github.com/ruckus/ruckusing-migrations
|    
|    All thanks to Cody Caughlan for the great work he did on this.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

namespace Egress\Library\Adapter;
use Egress\Library\Adapter\AdapterBase;
use Egress\Library\EgressException;

class ColumnDefinition {
    
    private $_adapter;
    public  $name;
    public  $type;
    public  $properties;
    private $_options = array();

    public function __construct($adapter, $name, $type, $options = array()) {
        if (!($adapter instanceof AdapterBase)):
            throw new EgressException("Invalid Adapter instance.", EgressException::INVALID_ADAPTER);
        endif;

        if (empty($name) || !is_string($name)):
            throw new EgressException("Invalid 'name' parameter", EgressException::INVALID_ARGUMENT);
        endif;
        
        if (empty($type) || !is_string($type)):
            throw new EgressException("Invalid 'type' parameter", EgressException::INVALID_ARGUMENT);
        endif;

        $this->_adapter = $adapter;
        $this->name     = $name;
        $this->type     = $type;
        $this->_options = $options;
    }

    public function to_sql() {
        $column_sql  = sprintf("%s %s", $this->_adapter->identifier($this->name), $this->sql_type());
        $column_sql .= $this->_adapter->add_column_options($this->type, $this->_options);

        return $column_sql;
    }

    public function __toString() {
        return $this->to_sql();
    }

    private function sql_type() {
        return $this->_adapter->type_to_sql($this->type, $this->_options);
    }
}
