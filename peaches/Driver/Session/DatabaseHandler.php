<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

namespace Dais\Driver\Session;

use SessionHandlerInterface;

class DatabaseHandler implements SessionHandlerInterface  {

    private $logger;

    public function open($savePath, $sessionName)  {
        register_shutdown_function('session_write_close');

        return true;
    }

    public function close()    {
        return $this->gc(ini_get('session.gc_maxlifetime'));
    }

    public function read($id) {
        $query = DB::query("
            SELECT data 
            FROM " . DB::prefix() . "sessions 
            WHERE id = '" . DB::escape($id) . "'
        ");

        if ($query->num_rows):
            return $query->row['data'];
        else:
            return '';
        endif;
    }

    public function write($id, $data) {
        $session_id   = DB::escape($id);
        $session_data = DB::escape($data);
        
        DB::query("
            REPLACE INTO " . DB::prefix() . "sessions (id, data) 
            VALUES('" . $session_id . "', '" . $session_data . "')
        ");

        return DB::countAffected();
    }
    
    public function destroy($id) {
        DB::query("
            DELETE FROM " . DB::prefix() . "sessions 
            WHERE id = '" . DB::escape($id) . "'
        ");

        return DB::countAffected();
    }

    public function gc($maxlifetime) {
        $lifetime = DB::escape($maxlifetime);

        DB::query("
            DELETE FROM " . DB::prefix() . "sessions 
            WHERE DATE_ADD(last_accessed, INTERVAL {$lifetime} SECOND) < NOW()
        ");

        return DB::countAffected();
    }

    private function write_log($data) {
        $this->logger->write($data);
    }    
}
