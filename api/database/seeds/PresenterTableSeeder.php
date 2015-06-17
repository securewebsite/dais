<?php

use Illuminate\Database\Seeder;

class PresenterTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('presenter')->delete();
        
		\DB::table('presenter')->insert(array (
			0 => 
			array (
				'presenter_id' => 1,
				'presenter_name' => 'Vince Kronlein',
				'image' => 'data/presenter/vince-kronlein.jpg',
				'facebook' => 'vince.kronlein',
				'twitter' => 'VinceKronlein',
				'bio' => '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. &lt;/p&gt;&lt;p&gt;Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.&lt;br&gt;&lt;/p&gt;',
			),
		));
	}

}
