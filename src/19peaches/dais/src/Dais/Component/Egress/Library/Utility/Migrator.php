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

namespace Egress\Library\Utility;
use Egress\Library\Adapter\AdapterBase;
use Egress\Library\EgressException;

class Migrator {
    
    private $_adapter = null;
    private $_migrations = array();

    public function __construct($adapter) {
        $this->setAdapter($adapter);
    }

    public function setAdapter($adapter) {
        if (!($adapter instanceof AdapterBase)):
            throw new EgressException('Adapter must be implement AdapterBase!', EgressException::INVALID_ADAPTER);
        endif;

        $this->_adapter = $adapter;

        return $this;
    }

    public function get_max_version() {
        // We only want one row but we cannot assume that we are using MySQL and use a LIMIT statement
        // as it is not part of the SQL standard. Thus we have to select all rows and use PHP to return
        // the record we need
        $versions_nested = $this->_adapter->select_all(sprintf("SELECT version FROM %s", EGRESS_TS_SCHEMA_TBL_NAME));
        $versions        = array();

        foreach ($versions_nested as $v):
            $versions[] = $v['version'];
        endforeach;

        $num_versions = count($versions);
        
        if ($num_versions):
            sort($versions); //sorts lowest-to-highest (ascending)

            return (string) $versions[$num_versions-1];
        else:
            return null;
        endif;
    }

    public function get_runnable_migrations($directories, $direction, $destination = null, $use_cache = true) {
        // cache migration lookups and early return if we've seen this requested set
        if ($use_cache === true):
            $key = $direction . '-' . $destination;
            if (array_key_exists($key, $this->_migrations)):
                return($this->_migrations[$key]);
            endif;
        endif;

        $runnable   = array();
        $migrations = array();
        $migrations = $this->get_migration_files($directories, $direction);
        $current    = $this->find_version($migrations, $this->get_max_version());
        $target     = $this->find_version($migrations, $destination);
        
        if (is_null($target) && !is_null($destination) && $destination > 0):
            throw new EgressException("Could not find target version {$destination} in set of migrations.", EgressException::INVALID_TARGET_MIGRATION);
        endif;

        $start       = $direction == 'up' ? 0 : array_search($current, $migrations);
        $start       = $start !== false ? $start : 0;
        $finish      = array_search($target, $migrations);
        $finish      = $finish !== false ? $finish : (count($migrations) - 1);
        $item_length = ($finish - $start) + 1;

        $runnable    = array_slice($migrations, $start, $item_length);

        //dont include first item if going down but not if going all the way to the bottom
        if ($direction == 'down' && count($runnable) > 0 && $target !== null):
            array_pop($runnable);
        endif;

        $executed   = $this->get_executed_migrations();
        $to_execute = array();

        foreach ($runnable as $migration):
            //Skip ones that we have already executed
            if ($direction == 'up' && in_array($migration['version'], $executed)):
                continue;
            endif;

            //Skip ones that we never executed
            if ($direction == 'down' && !in_array($migration['version'], $executed)):
                continue;
            endif;

            $to_execute[] = $migration;
        endforeach;

        if ($use_cache === true):
            $this->_migrations[$key] = $to_execute;
        endif;

        return($to_execute);
    }

    public static function generate_timestamp() {
        return gmdate('YmdHis', time());
    }

    public function resolve_current_version($version, $direction) {
        if ($direction === 'up'):
            $this->_adapter->set_current_version($version);
        endif;

        if ($direction === 'down'):
            $this->_adapter->remove_version($version);
        endif;

        return $version;
    }

    public function get_executed_migrations() {
        return $this->executed_migrations();
    }

    public static function get_migration_files($directories, $direction) {
        $valid_files = array();
        
        foreach ($directories as $name => $path):
            $files    = scandir($path);
            $file_cnt = count($files);

            if ($file_cnt > 0):
                for ($i = 0; $i < $file_cnt; $i++):
                    if (preg_match('/^(.*)_(\d+)\.php$/', $files[$i], $matches)):
                        if (count($matches) == 3):
                            $valid_files[] = array(
                                'name'   =>  $files[$i],
                                'module' =>  $name
                            );
                        endif;
                    endif;
                endfor;
            endif;
        endforeach;
        
        //user wants a nested structure
        $files = array();
        $cnt   = count($valid_files);
        
        for ($i = 0; $i < $cnt; $i++):
            $migration = $valid_files[$i];

            if (preg_match('/^(.*)_(\d+)\.php$/', $migration['name'], $matches)):
                $files[] = array(
                    'version' => $matches[2],
                    'class'   => $matches[1],
                    'file'    => $matches[0],
                    'module'  => $migration['module']
                );
            endif;
        endfor;

        usort($files, array("\Egress\Library\Utility\Migrator", "migration_compare")); //sorts in place
        
        if ($direction == 'down'):
            $files = array_reverse($files);
        endif;
        
        return $files;
    }

    public function find_version($migrations, $version, $only_index = false) {
        $len = count($migrations);

        for ($i = 0; $i < $len; $i++):
            if ($migrations[$i]['version'] == $version):
                return $only_index ? $i : $migrations[$i];
            endif;
        endfor;

        return null;
    }

    private static function migration_compare($a, $b) {
        return strcmp($a["version"], $b["version"]);
    }

    private function executed_migrations() {
        $query_sql = sprintf('SELECT version FROM %s', EGRESS_TS_SCHEMA_TBL_NAME);
        $versions  = $this->_adapter->select_all($query_sql);
        $executed  = array();

        foreach ($versions as $v):
            $executed[] = $v['version'];
        endforeach;

        sort($executed);

        return $executed;
    }
}
