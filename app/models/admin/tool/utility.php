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
		$query = DB::query("
			SELECT query 
			FROM " . DB::prefix() . "affiliate_route 
			WHERE slug = '" . DB::escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM " . DB::prefix() . "route 
			WHERE slug = '" . DB::escape($slug) . "' 
			UNION ALL 
			SELECT query 
			FROM " . DB::prefix() . "vanity_route 
			WHERE slug = '" . DB::escape($slug) . "'
		");

		return ($query->num_rows) ? $query->row['query'] : false;
    }
}
