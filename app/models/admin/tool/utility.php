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

namespace App\Models\Admin\Tool;

use App\Models\Model;

class Utility extends Model {
    
    public function findSlugByName($slug) {
		$query = $this->db->query("
			SELECT query 
			FROM {$this->db->prefix}affiliate_route 
			WHERE slug = '" . $this->db->escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM {$this->db->prefix}route 
			WHERE slug = '" . $this->db->escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM {$this->db->prefix}vanity_route 
			WHERE slug = '" . $this->db->escape($slug) . "'
		");

		return ($query->num_rows) ? $query->row['query'] : false;
    }
}
