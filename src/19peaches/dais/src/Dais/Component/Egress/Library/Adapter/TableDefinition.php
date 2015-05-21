<?php

/*
|--------------------------------------------------------------------------
|   Egress
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
use Egress\Library\Adapter\ColumnDefinition;
use Egress\Library\EgressException;

class TableDefinition {
    
    private $_columns = array();
    private $_adapter;

    public function __construct($adapter) {
        if (!($adapter instanceof AdapterBase)):
            throw new EgressException('Invalid Adapter instance.', EgressException::INVALID_ADAPTER);
        endif;

        $this->_adapter = $adapter;
    }

    public function __call($name, $args) {
        throw new EgressException('Method unknown (' . $name . ')', EgressException::INVALID_MIGRATION_METHOD);
    }

    public function included($column) {
        $k = count($this->_columns);

        for ($i = 0; $i < $k; $i++):
            $col = $this->_columns[$i];
            if (is_string($column) && $col->name == $column):
                return true;
            endif;

            if (($column instanceof ColumnDefinition) && $col->name == $column->name):
                return true;
            endif;
        endfor;

        return false;
    }

    public function to_sql() {
        return join(",", $this->_columns);
    }
}
