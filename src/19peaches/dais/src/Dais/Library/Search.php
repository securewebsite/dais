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
 * At present there are 5 types of searches.
 * 1. Products
 * 2. Posts
 * 3. Pages
 * 4. Customers
 * 5. Events
 */

class Search extends LibraryService {

	private $results;

	public function __construct(Container $app) {
		parent::__construct($app);
	}

	public function execute($query, $start = 0, $limit = 10) {
		$db = parent::$app['db'];

		$query = $db->query("
			SELECT *, 
			SUM(MATCH(text) AGAINST('" . $db->escape($query) . "' IN BOOLEAN MODE)) as score 
			FROM {$db->prefix}search_index 
			WHERE MATCH(text) AGAINST('" . $db->escape($query) . "' IN BOOLEAN MODE) 
			GROUP BY language_id, type, object_id 
			ORDER BY score DESC 
			LIMIT " . (int)$start . ", " . (int)$limit . "
		");

		$results = array();

		foreach($query->rows as $row):
			$results[$row['type']][] = (int)$row['object_id'];
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

		$verified = array();

		foreach($results as $type => $ids):

		endforeach;

		var_dump($results);exit;
	}

	public function add($language, $type, $id, $text = false) {
		$db = parent::$app['db'];

		if (!$text):
			return;
		else:
			$text = trim(strip_tags(htmlspecialchars_decode($text)));
			$text = str_replace(array("\r\n", "\r", "\n", "\t"), "", $text);
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

	private function category($ids) {
		// status only
	}

	private function manufacturer($ids) {
		// no status no visibility
	}

	private function product($ids) {
		// visibility status
	}

	private function page($ids) {
		// visibility status
	}

	private function blog_category($ids) {
		// status only
	}

	private function post($ids) {
		// visibility status
	}
	
}
