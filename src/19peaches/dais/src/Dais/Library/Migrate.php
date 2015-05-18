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
use DirectoryIterator;

class Migrate extends LibraryService {

	private $directory;

	public function __construct(Container $app, $directory) {
        parent::__construct($app);

        $base = parent::$app['path.database'] . 'migration/';
        $this->directory = $base . $directory; 
    }

    public function find() {
		$files = new DirectoryIterator($this->directory);

		foreach ($files as $fileInfo):
			if ($fileInfo->isDot()) continue;
			if ($fileInfo == '.DS_Store') continue;
			echo $fileInfo . "<br>\n";
		endforeach;
    	
    }


}
