<?php

use Illuminate\Database\Seeder;

class HookTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('hook')->delete();
        
		\DB::table('hook')->insert(array (
			0 => 
			array (
				'hook_id' => 6,
				'store_id' => 0,
				'hook' => 'admin_controller',
				'handlers' => 'a:2:{i:0;a:7:{s:5:"class";s:9:"tool/test";s:6:"method";s:5:"index";s:4:"type";s:4:"post";s:6:"plugin";s:7:"example";s:4:"file";s:28:"admin/hooks/controller_hooks";s:8:"callback";s:11:"exampleHook";s:4:"args";a:2:{s:13:"heading_title";s:17:"Example Test Page";s:10:"item_title";s:10:"Item title";}}i:1;a:6:{s:5:"class";s:9:"tool/test";s:6:"method";s:5:"index";s:4:"type";s:3:"pre";s:6:"plugin";s:7:"example";s:4:"file";s:28:"admin/hooks/controller_hooks";s:8:"callback";s:7:"preHook";}}',
			),
		));
	}

}
