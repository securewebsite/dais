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

namespace Dais\Services\Providers\Response;

/**
 * At present there are 6 types of searches.
 * 1. Products
 * 2. Categories
 * 3. Pages
 * 4. Blog Posts
 * 5. Blog Categories
 * 6. Manufacturers
 */

final class Search {

	private $results;
	private $customer;
	public  $count;

	public function execute($string, array $data = array()) {
		// Properly escape our query then use heredoc syntax in our query
		$search = DB::escape($string);

		$query = DB::query("
			SELECT 
			SQL_CALC_FOUND_ROWS 
			*, 
			SUM(MATCH(text) AGAINST('{$search}' IN BOOLEAN MODE)) as score 
			FROM " . DB::prefix() . "search_index 
			WHERE MATCH(text) AGAINST('{$search}' IN BOOLEAN MODE)  
			OR text LIKE '%{$search}%' 
			GROUP BY language_id, type, object_id 
			ORDER BY score DESC 
			LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'] . "
		");

		$count = DB::query("SELECT FOUND_ROWS() AS total");
		$this->count = (int)$count->row['total'];

		/**
		 * Our search_index table stores raw text info
		 * to complete very fast searching. But we must now
		 * verify that the search data found is ok to present
		 * to our end user.
		 *
		 * Mainly we're checking for status, and visibility.
		 * We don't want to show our users content they're not
		 * authorized to see, or that's otherwise disabled.
		 *
		 * Pass each result type to the corresponding callback
		 * to ensure we have visibility and status.
		 */
		if ($this->count):
			foreach($query->rows as $row):
				$method = $row['type'];
				$id     = $row['object_id'];

				$this->{$method}($id);
			endforeach;
		endif;
		
		return $this->results;
	}

	public function add($language, $type, $id, $text = false) {
		if (!$text):
			return;
		else:
			$text = $this->format($text);
		endif;

		DB::query("
			INSERT INTO " . DB::prefix() . "search_index 
			SET 
				language_id = '" . (int)$language . "', 
				type        = '" . DB::escape($type) . "', 
				object_id   = '" . (int)$id . "', 
				text        = '" . DB::escape($text) . "'
		");
	}

	public function delete($type, $id) {
		DB::query("
			DELETE FROM " . DB::prefix() . "search_index 
			WHERE type    = '" . DB::escape($type) . "' 
			AND object_id = '" . (int)$id . "'
		");
	}

	public function total() {
		return $this->count;
	}

	private function category($id) {
		$query = DB::query("
			SELECT c.category_id, c.parent_id, cd.name, cd.description 
			FROM " . DB::prefix() . "category c 
			LEFT JOIN " . DB::prefix() . "category_description cd 
			ON (c.category_id = cd.category_id) 
			WHERE c.category_id = '" . (int)$id . "' 
			AND c.status        = '1' 
			AND cd.language_id  = '" . (int)Config::get('config_language_id') . "'
		");

		if (!empty($query->row)):
			$query->row['description']     = $this->format($query->row['description']);
			$this->results['categories'][] = $query->row;
		endif;
	}

	private function manufacturer($id) {

		$query = DB::query("
			SELECT manufacturer_id, name 
			FROM " . DB::prefix() . "manufacturer 
			WHERE manufacturer_id = '" . (int)$id . "'
		");

		if (!empty($query->row)):
			$this->results['manufacturers'][] = $query->row;
		endif;
	}

	private function product($id) {
		$visibility = $this->visibility();

		$query = DB::query("
			SELECT p.product_id, pd.name, pd.description 
			FROM " . DB::prefix() . "product p 
			LEFT JOIN " . DB::prefix() . "product_description pd 
			ON (p.product_id = pd.product_id) 
			WHERE p.product_id = '" . (int)$id . "' 
			AND p.status       = '1' 
			AND p.visibility   >= '" . (int)$visibility . "' 
			AND pd.language_id = '" . (int)Config::get('config_language_id') . "'
		");

		if (!empty($query->row)):
			$query->row['description']   = $this->format($query->row['description']);
			$this->results['products'][] = $query->row;
		endif;
	}

	private function page($id) {
		$visibility = $this->visibility();

		$query = DB::query("
			SELECT p.page_id, p.event_id, pd.title, pd.description 
			FROM " . DB::prefix() . "page p 
			LEFT JOIN " . DB::prefix() . "page_description pd 
			ON (p.page_id = pd.page_id) 
			WHERE p.page_id      = '" . (int)$id . "' 
			AND p.status         = '1' 
			AND p.visibility     >= '" . (int)$visibility . "' 
			AND pd.language_id = '" . (int)Config::get('config_language_id') . "'
		");

		if (!empty($query->row)):
			$query->row['description'] = $this->format($query->row['description']);
			$this->results['pages'][]  = $query->row;
		endif;
	}

	private function blog_category($id) {
		$query = DB::query("
			SELECT c.category_id, c.parent_id, cd.name, cd.description  
			FROM " . DB::prefix() . "blog_category c 
			LEFT JOIN " . DB::prefix() . "blog_category_description cd 
			ON (c.category_id = cd.category_id) 
			WHERE c.category_id = '" . (int)$id . "' 
			AND c.status        = '1' 
			AND cd.language_id  = '" . (int)Config::get('config_language_id') . "'
		");

		if (!empty($query->row)):
			$query->row['description']          = $this->format($query->row['description']);
			$this->results['blog_categories'][] = $query->row;
		endif;
	}

	private function post($id) {
		$visibility = $this->visibility();

		$query = DB::query("
			SELECT p.post_id, pd.name, pd.description 
			FROM " . DB::prefix() . "blog_post p 
			LEFT JOIN " . DB::prefix() . "blog_post_description pd 
			ON (p.post_id = pd.post_id) 
			WHERE p.post_id    = '" . (int)$id . "' 
			AND p.status       = '1' 
			AND p.visibility  >= '" . (int)$visibility . "' 
			AND pd.language_id = '" . (int)Config::get('config_language_id') . "'
		");

		if (!empty($query->row)):
			$query->row['description'] = $this->format($query->row['description']);
			$this->results['posts'][]  = $query->row;
		endif;
		
	}

	private function format($text) {
		$text = str_replace(array("\r\n", "\r", "\n", "\t"), "", trim(strip_tags(htmlspecialchars_decode($text))));

		return $this->truncate($text);
	}

	private function truncate($text) {
		return Encode::substr($text, 0, 280) . ' ...';
	}

	private function visibility() {
		switch(Config::get('active.facade')):
			case FRONT_FACADE:
				$visible = Customer::p()->customer_group_id;
				break;
			case ADMIN_FACADE:
				$query = DB::query("
					SELECT MAX(customer_group_id) AS total 
					FROM " . DB::prefix() . "customer_group
				");

				$visible = $query->row['total'];
				break;
		endswitch;

		return $visible;
	}
}
