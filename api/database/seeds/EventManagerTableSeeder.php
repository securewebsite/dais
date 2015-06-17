<?php

use Illuminate\Database\Seeder;

class EventManagerTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('event_manager')->delete();
        
		\DB::table('event_manager')->insert(array (
			0 => 
			array (
				'event_id' => 2,
				'event_name' => 'Online Webinar',
				'model' => '',
				'sku' => '',
				'visibility' => 1,
				'event_length' => '2',
				'event_days' => 'a:1:{i:0;s:6:"Friday";}',
				'event_class' => 'event-warning',
				'date_time' => '2015-05-29 09:00:00',
				'online' => 1,
				'link' => 'http://www.google.com',
				'location' => '',
				'telephone' => '480-333-3344',
				'cost' => '0.0000',
				'seats' => 200,
				'filled' => 0,
				'presenter_tab' => 'Host',
				'roster' => '',
				'presenter_id' => 1,
				'description' => 'Once the event is created, you cannot switch from a product to a page or vice-versa. If you want to switch, you must delete the entire event and start over. &lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;Keep in mind that this will delete all data for the event including anyone who is already registered.&lt;/div&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;And here\'s another line of text.&lt;/div&gt;&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;More text.&lt;/div&gt;',
				'refundable' => 0,
				'date_end' => '2015-05-29 11:00:00',
				'product_id' => 0,
				'page_id' => 11,
			),
			1 => 
			array (
				'event_id' => 3,
				'event_name' => 'Dais.io Live Conference 2015',
				'model' => 'DAISLIVE2015',
				'sku' => '123456999',
				'visibility' => 1,
				'event_length' => '8',
				'event_days' => 'a:5:{i:0;s:6:"Monday";i:1;s:7:"Tuesday";i:2;s:9:"Wednesday";i:3;s:8:"Thursday";i:4;s:6:"Friday";}',
				'event_class' => 'event-success',
				'date_time' => '2015-05-04 09:00:00',
				'online' => 0,
				'link' => '',
				'location' => 'Tempe Events Center
1234 Main St.
Tempe, AZ 85281',
				'telephone' => '480-333-3434',
				'cost' => '249.9900',
				'seats' => 1200,
				'filled' => 0,
				'presenter_tab' => 'Host',
				'roster' => 'a:0:{}',
				'presenter_id' => 1,
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. &lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.&lt;/div&gt;',
				'refundable' => 1,
				'date_end' => '2015-05-04 17:00:00',
				'product_id' => 50,
				'page_id' => 0,
			),
		));
	}

}
