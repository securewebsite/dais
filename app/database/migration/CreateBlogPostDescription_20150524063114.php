<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|   (c) Vince Kronlein <vince@dais.io>
|    
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
|   Your table prefix has been included so that you can easily write your 
|   migrations to include the proper prefix.
|   
|   $users = $this->create_table("{$this->prefix}users");
|
|   Obviously if you have no table prefix, this variable will be empty.
|   
*/

namespace Database\Migration;
use Egress\Library\Migration\MigrationBase;

class CreateBlogPostDescription_20150524063114 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}blog_post_description", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('post_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('language_id', 'integer', array('unsigned' => true, 'primary_key' => true));
        $table->column('name', 'string');
        $table->column('description', 'text');
        $table->column('meta_description', 'string');
        $table->column('meta_keyword', 'string');
        $table->column('tag', 'text');
        
        $table->finish();

        $this->add_index("{$this->prefix}blog_post_description", "name", array('name' => 'name'));
        $this->add_index("{$this->prefix}blog_post_description", "description", array('name' => 'description', 'fulltext' => true));
        $this->add_index("{$this->prefix}blog_post_description", "tag", array('name' => 'tag', 'fulltext' => true));

        $sql = "INSERT INTO `{$this->prefix}blog_post_description` (`post_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`, `tag`) VALUES
                (1, 1, 'Lorem Ipsum Test Post', '&lt;p&gt;&lt;span style=&quot;font-weight: bold;&quot;&gt;Lorem ipsum dolor sit amet,&lt;/span&gt; consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.&lt;/p&gt;\r\n&lt;p&gt;Quisque vel augue semper, euismod turpis sed, suscipit odio. Morbi venenatis neque a tristique sodales. Suspendisse sed tempor mauris, eu blandit nulla. Vivamus quis enim et nibh ultrices pellentesque. In nec dapibus orci. Nam vel augue at nunc convallis adipiscing eget quis libero. Cras semper odio congue, varius diam a, rutrum dolor.&lt;/p&gt;\r\n&lt;p&gt;Pellentesque sed tincidunt velit, pellentesque luctus tellus. Duis vulputate lacus eu metus consectetur pretium. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce pulvinar quam non magna aliquet, a tincidunt diam lobortis. Vestibulum quam quam, commodo commodo ornare at, sodales ac elit. Pellentesque convallis pellentesque ante at facilisis. Duis ut porta mauris. Vestibulum suscipit elit vitae urna hendrerit, fermentum placerat justo tristique. Quisque eget odio nunc. Morbi interdum sed mi sit amet suscipit. Nullam nec lacinia dolor, vel dapibus nulla. Aenean sed congue nisi, id dictum diam. Phasellus ac metus non ligula interdum hendrerit eget vitae nisi.&lt;/p&gt;\r\n&lt;p&gt;In posuere molestie imperdiet. Nunc auctor sagittis risus, ullamcorper elementum dui ullamcorper eget. Donec quis diam porttitor, fringilla purus nec, viverra tellus. In sit amet pulvinar risus, sed porttitor lectus. Proin nunc metus, porta id viverra nec, aliquet in lorem. Quisque faucibus lorem vitae nulla adipiscing, in aliquet lorem cursus. Pellentesque id suscipit justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sagittis non ante quis vehicula.&lt;/p&gt;\r\n&lt;p&gt;Sed at metus ipsum. Integer odio leo, volutpat eu sagittis sed, sodales vel dui. Vestibulum nec tellus orci. Etiam hendrerit at arcu vel interdum. Praesent quis nulla adipiscing, convallis est in, pulvinar quam. Curabitur at massa pulvinar eros rhoncus molestie vitae eget purus. Curabitur ullamcorper dictum tortor, in blandit urna gravida et. Nulla a nisl ligula. Vestibulum lobortis rutrum luctus. Phasellus mattis, turpis at dignissim fringilla, quam quam egestas nisl, vel viverra sem diam gravida purus. In eget erat rutrum, pulvinar lectus porta, aliquam lorem. Sed lorem purus, sodales id pellentesque id, volutpat a tellus. Nam aliquam ullamcorper odio sed egestas. Donec vel dictum odio.&lt;/p&gt;', 'Test Meta Description', 'lorem, ipsum', 'lorem, ipsum')";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}blog_post_description");
    }
}
