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

namespace Dais\Library;
use Dais\Engine\Container;
use Dais\Service\LibraryService;

/**
 * At present there are 6 types of searches.
 * 1. Products
 * 2. Categories
 * 3. Pages
 * 4. Blog Posts
 * 5. Blog Categories
 * 6. Manufacturers
 */

class Search extends LibraryService {

	private static $results;
	private static $language_id;
	public  static $count;

	public function __construct(Container $app) {
		parent::__construct($app);
		self::$language_id = $app['config_language_id'];
	}

	public static function execute($string, $data = array()) {
		$db = parent::$app['db'];

		// Properly escape our query then use heredoc syntax in our query
		$search = $db->escape($string);

		// Sadly we'll need two queries because we need a total count
		// for pagination. This will set our $count property.
		
		self::fulltext($search);

		// If we have a $count property process fulltext search.
		if (self::$count):
			$sql = "
				SELECT *, 
				SUM(MATCH(text) AGAINST('{$search}' IN BOOLEAN MODE)) as score 
				FROM {$db->prefix}search_index 
				WHERE MATCH(text) AGAINST('{$search}' IN BOOLEAN MODE) 
				GROUP BY language_id, type, object_id 
				ORDER BY score DESC
			";

			if (!empty($data['start']) || !empty($data['limit'])):
				$sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
			endif;
			
			$query = $db->query($sql);

		else:
			// No $count property was set by our ::fulltext method
			// so let's move on to a keyword search.
			self::keyword($search);

			if (self::$count):
				$sql = "
					SELECT * 
					FROM {$db->prefix}search_index 
					WHERE text LIKE '%{$search}%' 
					GROUP BY language_id, type, object_id 
					ORDER BY id DESC
				";

				if (!empty($data['start']) || !empty($data['limit'])):
					$sql .= " LIMIT " . (int)$data['start'] . ", " . (int)$data['limit'];
				endif;

				$query = $db->query($sql);
			endif;

		endif;

		$terms = array();
		
		if ($query->num_rows):
			foreach($query->rows as $row):
				$terms[$row['type']][] = (int)$row['object_id'];
			endforeach;

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
			
			foreach($terms as $type => $ids):
				self::$type($ids);
			endforeach;
		endif;
		
		return self::$results;
	}

	public function add($language, $type, $id, $text = false) {
		$db = parent::$app['db'];

		if (!$text):
			return;
		else:
			$text = self::format($text);
		endif;

		$db->query("
			INSERT INTO {$db->prefix}search_index 
			SET 
				language_id = '" . (int)$language . "', 
				type        = '" . $db->escape($type) . "', 
				object_id   = '" . (int)$id . "', 
				text        = '" . $db->escape($text) . "'
		");
	}

	public function delete($type, $id) {
		$db = parent::$app['db'];

		$db->query("
			DELETE FROM {$db->prefix}search_index 
			WHERE type    = '" . $db->escape($type) . "' 
			AND object_id = '" . (int)$id . "'
		");
	}

	public function total() {
		return self::$count;
	}

	private static function category($ids) {
		$db = parent::$app['db'];

		foreach($ids as $id):
			$query = $db->query("
				SELECT c.category_id, c.parent_id, cd.name, cd.description 
				FROM {$db->prefix}category c 
				LEFT JOIN {$db->prefix}category_description cd 
				ON (c.category_id = cd.category_id) 
				WHERE c.category_id = '" . (int)$id . "' 
				AND c.status        = '1' 
				AND cd.language_id  = '" . (int)self::$language_id . "'
			");

			if ($query->num_rows):
				$query->row['description']     = self::format($query->row['description']);
				self::$results['categories'][] = $query->row;
			endif;
		endforeach;
	}

	private static function manufacturer($ids) {
		$db = parent::$app['db'];

		foreach($ids as $id):
			$query = $db->query("
				SELECT manufacturer_id, name 
				FROM {$db->prefix}manufacturer 
				WHERE manufacturer_id = '" . (int)$id . "'
			");

			if ($query->num_rows):
				self::$results['manufacturers'][] = $query->row;
			endif;
		endforeach;
	}

	private static function product($ids) {
		$db         = parent::$app['db'];
		$visibility = parent::$app['customer']->customer_group_id;

		foreach($ids as $id):
			$query = $db->query("
				SELECT p.product_id, pd.name, pd.description 
				FROM {$db->prefix}product p 
				LEFT JOIN {$db->prefix}product_description pd 
				ON (p.product_id = pd.product_id) 
				WHERE p.product_id = '" . (int)$id . "' 
				AND p.status       = '1' 
				AND p.visibility   = '" . (int)$visibility . "' 
				AND pd.language_id = '" . (int)self::$language_id . "'
			");

			if ($query->num_rows):
				$query->row['description']   = self::format($query->row['description']);
				self::$results['products'][] = $query->row;
			endif;
		endforeach;
	}

	private static function page($ids) {
		$db         = parent::$app['db'];
		$visibility = parent::$app['customer']->customer_group_id;

		foreach($ids as $id):
			$query = $db->query("
				SELECT p.page_id, p.event_id, pd.title, pd.description 
				FROM {$db->prefix}page p 
				LEFT JOIN {$db->prefix}page_description pd 
				ON (p.page_id = pd.page_id) 
				WHERE p.page_id      = '" . (int)$id . "' 
				AND p.status         = '1' 
				AND p.visibility     = '" . (int)$visibility . "' 
				AND pd.language_id = '" . (int)self::$language_id . "'
			");

			if ($query->num_rows):
				$query->row['description'] = self::format($query->row['description']);
				self::$results['pages'][]  = $query->row;
			endif;
		endforeach;
	}

	private static function blog_category($ids) {
		$db = parent::$app['db'];

		foreach($ids as $id):
			$query = $db->query("
				SELECT c.category_id, c.parent_id, cd.name, cd.description  
				FROM {$db->prefix}blog_category c 
				LEFT JOIN {$db->prefix}blog_category_description cd 
				ON (c.category_id = cd.category_id) 
				WHERE c.category_id = '" . (int)$id . "' 
				AND c.status        = '1' 
				AND cd.language_id  = '" . (int)self::$language_id . "'
			");

			if ($query->num_rows):
				$query->row['description']          = self::format($query->row['description']);
				self::$results['blog_categories'][] = $query->row;
			endif;
		endforeach;
	}

	private static function post($ids) {
		$db         = parent::$app['db'];
		$visibility = parent::$app['customer']->customer_group_id;

		foreach($ids as $id):
			$query = $db->query("
				SELECT p.post_id, pd.name, pd.description 
				FROM {$db->prefix}blog_post p 
				LEFT JOIN {$db->prefix}blog_post_description pd 
				ON (p.post_id = pd.post_id) 
				WHERE p.post_id    = '" . (int)$id . "' 
				AND p.status       = '1' 
				AND p.visibility  >= '" . (int)$visibility . "' 
				AND pd.language_id = '" . (int)self::$language_id . "'
			");

			if ($query->num_rows):
				$query->row['description'] = self::format($query->row['description']);
				self::$results['posts'][]  = $query->row;
			endif;
		endforeach;
	}

	private static function fulltext($search) {
		$db = parent::$app['db'];

		$query = $db->query("
			SELECT COUNT(id) 
			FROM {$db->prefix}search_index 
			WHERE MATCH(text) AGAINST('{$search}' IN BOOLEAN MODE) 
			GROUP BY language_id, type, object_id
		");

		if ($query->num_rows):
			self::$count = $query->num_rows;
		endif;
	}

	private static function keyword($search) {
		$db = parent::$app['db'];

		$query = $db->query("
			SELECT id 
			FROM {$db->prefix}search_index 
			WHERE text LIKE '%{$search}%' 
			GROUP BY language_id, type, object_id
		");

		if ($query->num_rows):
			self::$count = $query->num_rows;
		endif;
	}

	private static function format($text) {
		$text = str_replace(array("\r\n", "\r", "\n", "\t"), "", trim(strip_tags(htmlspecialchars_decode($text))));

		return self::truncate($text);
	}

	private static function truncate($text) {
		$encode = parent::$app['encode'];

		return $encode->substr($text, 0, 280) . ' ...';
	}
}
