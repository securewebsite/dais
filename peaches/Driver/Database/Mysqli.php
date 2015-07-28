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

use stdClass;
use mysqli as Msq;
use mysqli_result;
use Dais\Contracts\DBContract;

class Mysqli implements DBContract {
	
	private $link;
	private $prefix;

	public function __construct() {
		$this->prefix = $_ENV['DB_PREFIX'];

		$this->link = new Msq($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);

		if ($this->link->connect_error):
			trigger_error('Error: Could not make a database link (' . $this->link->connect_errno . ') ' . $this->link->connect_error);
		endif;

		$this->link->set_charset("utf8");
		$this->link->query("SET SQL_MODE = ''");
	}

	public function query($sql, array $params = null) {
		$query = $this->link->query($sql);

		if (!$this->link->errno):
			if ($query instanceof mysqli_result):
				$data = array();

				while ($row = $query->fetch_assoc()):
					$data[] = $row;
				endwhile;

				$result           = new stdClass();
				$result->num_rows = $query->num_rows;
				$result->row      = isset($data[0]) ? $data[0] : array();
				$result->rows     = $data;

				$query->close();

				return $result;
			else:
				return true;
			endif;
		else:
			trigger_error('Error: ' . $this->link->error  . '<br />Error No: ' . $this->link->errno . '<br />' . $sql);
		endif;
	}

	public function escape($value) {
		return $this->link->real_escape_string($value);
	}

	public function countAffected() {
		return $this->link->affected_rows;
	}

	public function getLastId() {
		return $this->link->insert_id;
	}

	public function prefix() {
        return $this->prefix;
    }

	public function __destruct() {
		$this->link->close();
	}
}
