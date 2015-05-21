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

namespace Egress\Library\Task;
use Egress\Library\FrameworkRunner;
use Egress\Library\Adapter\AdapterBase;
use Egress\Library\EgressException;

class TaskBase {
    
    private   $_framework;
    private   $_adapter;
    protected $_migrationDir;

    public function __construct($adapter) {
        $this->setAdapter($adapter);
    }

    public function get_framework() {
        return $this->_framework;
    }

    public function set_framework($fw) {
        if (!($fw instanceof FrameworkRunner)):
            throw new EgressException('Framework must be instance of FrameworkRunner!', EgressException::INVALID_FRAMEWORK);
        endif;

        $this->_framework = $fw;
    }

    public function setAdapter($adapter) {
        if (!($adapter instanceof AdapterBase)):
            throw new EgressException('Adapter must implement AdapterBase!', EgressException::INVALID_ADAPTER);
        endif;

        $this->_adapter = $adapter;

        return $this;
    }

    public function get_adapter() {
        return $this->_adapter;
    }

    public function setMigrationsDirectory($migrationDir) {
        $this->_migrationDir = $migrationDir;

        return $this;
    }
}
