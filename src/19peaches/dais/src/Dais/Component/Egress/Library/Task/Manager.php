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
use Egress\Library\Adapter\AdapterBase;
use Egress\Library\Task\TaskInterface;
use Egress\Library\Utility\Naming;
use Egress\Library\EgressException;

define('EGRESS_TASK_DIR', EGRESS_BASE . 'Task');

class Manager {

    private $_adapter;
    private $_tasks = array();

    public function __construct($adapter, $config = null) {
        $this->setAdapter($adapter);
        $this->_config = $config;
        $this->load_all_tasks(EGRESS_TASK_DIR);
        
        if (is_array($config) && array_key_exists('tasks_dir', $config)):
          $this->load_all_tasks($config['tasks_dir']);
        endif;
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

    public function get_task($key) {
        if (!$this->has_task($key)):
            throw new EgressException("Task '$key' is not registered.", EgressException::INVALID_ARGUMENT);
        endif;

        return $this->_tasks[$key];
    }

    public function has_task($key) {
        return array_key_exists($key, $this->_tasks);
    }

    public function register_task($key, $obj) {
        if (array_key_exists($key, $this->_tasks)):
            throw new EgressException(sprintf("Task key '%s' is already defined!", $key), EgressException::INVALID_ARGUMENT);
        endif;

        if (!($obj instanceof TaskInterface)):
            throw new EgressException(sprintf('Task (' . $key . ') does not implement TaskInterface', $key), EgressException::INVALID_ARGUMENT);
        endif;

        $this->_tasks[$key] = $obj;

        return true;
    }

    private function load_all_tasks($task_dir) {
        if (!is_dir($task_dir)):
            throw new EgressException(sprintf("Task dir: %s does not exist", $task_dir), EgressException::INVALID_ARGUMENT);
        endif;

        $namespaces = scandir($task_dir);
        
        foreach ($namespaces as $namespace):
            if ($namespace == '.' || $namespace == '..' || ! is_dir($task_dir . SEP . $namespace)):
                continue;
            endif;

            $files = scandir($task_dir . SEP . $namespace);
            $regex = '/^(\w+)\.php$/';
            
            foreach ($files as $file):
                //skip over invalid files
                if ($file == '.' || $file == ".." || !preg_match($regex, $file, $matches)):
                    continue;
                endif;
                
                $klass     = Naming::class_from_file_name($task_dir . SEP . $namespace . SEP . $file);
                $task_name = Naming::task_from_class_name($klass);

                $this->register_task($task_name, new $klass($this->get_adapter()));
            endforeach;
        endforeach;
    }

    public function execute($framework, $task_name, $options) {
        $task = $this->get_task($task_name);
        $task->set_framework($framework);

        return $task->execute($options);
    }

    public function help($task_name) {
        $task = $this->get_task($task_name);

        return $task->help();
    }
}
