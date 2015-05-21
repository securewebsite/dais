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

class Validation extends LibraryService {
	/**
	 * Route to check permissions for.
	 * Admin only.
	 * @var string
	 */
	private $permission;

	/**
	 * Form fields that need to be validated.
	 * @var array
	 */
	private $validations;

	/**
	 * Form fields that are required.
	 * @var array
	 */
	private $required;

	/**
	 * Error array to hold local validation errors
	 * to pass back to controller.
	 * @var array
	 */
	private $error;
	
	public function __construct(Container $app) {
		parent::__construct($app);
	}

	public function set($validations, $required, $permission = false) {
		$this->validations = $validations;
		$this->required    = $required;

		if ($permission)
			$this->permission = $permission;
	}

	public function validate($post) {
		/**
		 * Permissions only need to be set if we're working in the admin fascade
		 * @var string
		 */
		if (parent::$app['config']->get('active.fascade') == ADMIN_FASCADE):
			
		endif;

		//parent::$app['theme']->test(parent::$app['config']);
		
	}
}
