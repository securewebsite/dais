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

namespace Egress\Library\Task\Hello;
use Egress\Library\Task\TaskBase;
use Egress\Library\Task\TaskInterface;

class World extends TaskBase implements TaskInterface {
    
    public function __construct($adapter) {
        parent::__construct($adapter);
    }

    public function execute($args) {
        return "\nHello, World\n";
    }
    
    public function help() {
        $output =<<<USAGE

\tTask: hello:world

\tHello World.

\tThis task does not take arguments.

USAGE;

        return $output;
    }
}
