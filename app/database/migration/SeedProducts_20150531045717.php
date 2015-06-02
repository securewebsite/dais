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

class SeedProducts_20150531045717 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        // attribute
        $sql = "INSERT INTO `{$this->prefix}attribute` VALUES
        (1, 6, 1),
        (2, 6, 5),
        (3, 6, 3),
        (4, 3, 1),
        (5, 3, 2),
        (6, 3, 3),
        (7, 3, 4),
        (8, 3, 5),
        (9, 3, 6),
        (10, 3, 7),
        (11, 3, 8)";

        $this->execute($sql);

        // attribute_description
        $sql = "INSERT INTO `{$this->prefix}attribute_description` VALUES
        (1, 1, 'Description'),
        (2, 1, 'No. of Cores'),
        (3, 1, 'Clockspeed'),
        (4, 1, 'test 1'),
        (5, 1, 'test 2'),
        (6, 1, 'test 3'),
        (7, 1, 'test 4'),
        (8, 1, 'test 5'),
        (9, 1, 'test 6'),
        (10, 1, 'test 7'),
        (11, 1, 'test 8')";

        $this->execute($sql);

        // attribute_group
        $sql = "INSERT INTO `{$this->prefix}attribute_group` VALUES
        (3, 2),
        (4, 1),
        (5, 3),
        (6, 4)";

        $this->execute($sql);

        // attribute_group_description
        $sql = "INSERT INTO `{$this->prefix}attribute_group_description` VALUES
        (3, 1, 'Memory'),
        (4, 1, 'Technical'),
        (5, 1, 'Motherboard'),
        (6, 1, 'Processor')";

        $this->execute($sql);

        // banner
        $sql = "INSERT INTO `{$this->prefix}banner` VALUES
        (6, 'HP Products', 1),
        (7, 'Samsung Tab', 1),
        (8, 'Manufacturers', 1),
        (9, 'Homepage', 1)";

        $this->execute($sql);

        // banner_image
        $sql = "INSERT INTO `{$this->prefix}banner_image` VALUES
        (84, 6, 'hewlett-packard', 'data/demo/hp_banner.jpg'),
        (85, 8, 'sony', 'data/demo/sony_logo.jpg'),
        (86, 8, 'palm', 'data/demo/palm_logo.jpg'),
        (87, 8, 'apple', 'data/demo/apple_logo.jpg'),
        (88, 8, 'canon', 'data/demo/canon_logo.jpg'),
        (89, 8, 'htc', 'data/demo/htc_logo.jpg'),
        (90, 8, 'hewlett-packard', 'data/demo/hp_logo.jpg'),
        (91, 7, 'tablets', 'data/demo/samsung_banner.jpg'),
        (92, 9, 'apple', 'data/banner/1.jpg'),
        (93, 9, 'samsung', 'data/banner/2.jpg'),
        (94, 9, 'hewlett-packard', 'data/banner/3.jpg')";

        $this->execute($sql);

        // banner_image_description
        $sql = "INSERT INTO `{$this->prefix}banner_image_description` VALUES
        (84, 1, 6, 'HP Banner'),
        (85, 1, 8, 'Sony'),
        (86, 1, 8, 'Palm'),
        (87, 1, 8, 'Apple'),
        (88, 1, 8, 'Canon'),
        (89, 1, 8, 'HTC'),
        (90, 1, 8, 'Hewlett-Packard'),
        (91, 1, 7, 'Samsung Tab 10.1'),
        (92, 1, 9, 'Hatch Premium Fly Reels'),
        (93, 1, 9, 'Yeti Containers'),
        (94, 1, 9, 'Louisiana Salt Water Series')";

        $this->execute($sql);

        // blog_category
        $sql = "INSERT INTO `{$this->prefix}blog_category` VALUES
        (1, '', 0, 0, 0, 0, 1, '2014-08-20 04:58:59', '2015-04-18 16:35:25'),
        (2, 'data/blog/category/landscape-a.jpg', 1, 0, 0, 0, 1, '2014-08-22 17:04:52', '2015-04-18 16:44:41')";

        $this->execute($sql);

        // blog_category_description
        $sql = "INSERT INTO `{$this->prefix}blog_category_description` VALUES
        (1, 1, 'General', '&lt;p&gt;This is the general category for all things general.&lt;/p&gt;', 'This is the general category for all things general.', 'general'),
        (2, 1, 'Latest Product News', '&lt;p&gt;\r\n    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n&lt;/p&gt;', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an.', 'industry, dummy, ipsum, lorem, dummy text, lorem ipsum')";

        $this->execute($sql);

        // blog_category_to_store
        $sql = "INSERT INTO `{$this->prefix}blog_category_to_store` VALUES
        (1, 0),
        (2, 0)";

        $this->execute($sql);

        // blog_post
        $sql = "INSERT INTO `{$this->prefix}blog_post` VALUES
        (1, 'data/blog/post/landscape-b.jpg', 1, '2014-08-19', 1, 1, 1, '2014-08-20 06:34:50', '2015-04-15 12:31:28', 251)";

        $this->execute($sql);

        // blog_post_description
        $sql = "INSERT INTO `{$this->prefix}blog_post_description` VALUES
        (1, 1, 'Lorem Ipsum Test Post', '&lt;p&gt;&lt;span style=&quot;font-weight: bold;&quot;&gt;Lorem ipsum dolor sit amet,&lt;/span&gt; consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.&lt;/p&gt;\r\n&lt;p&gt;Quisque vel augue semper, euismod turpis sed, suscipit odio. Morbi venenatis neque a tristique sodales. Suspendisse sed tempor mauris, eu blandit nulla. Vivamus quis enim et nibh ultrices pellentesque. In nec dapibus orci. Nam vel augue at nunc convallis adipiscing eget quis libero. Cras semper odio congue, varius diam a, rutrum dolor.&lt;/p&gt;\r\n&lt;p&gt;Pellentesque sed tincidunt velit, pellentesque luctus tellus. Duis vulputate lacus eu metus consectetur pretium. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce pulvinar quam non magna aliquet, a tincidunt diam lobortis. Vestibulum quam quam, commodo commodo ornare at, sodales ac elit. Pellentesque convallis pellentesque ante at facilisis. Duis ut porta mauris. Vestibulum suscipit elit vitae urna hendrerit, fermentum placerat justo tristique. Quisque eget odio nunc. Morbi interdum sed mi sit amet suscipit. Nullam nec lacinia dolor, vel dapibus nulla. Aenean sed congue nisi, id dictum diam. Phasellus ac metus non ligula interdum hendrerit eget vitae nisi.&lt;/p&gt;\r\n&lt;p&gt;In posuere molestie imperdiet. Nunc auctor sagittis risus, ullamcorper elementum dui ullamcorper eget. Donec quis diam porttitor, fringilla purus nec, viverra tellus. In sit amet pulvinar risus, sed porttitor lectus. Proin nunc metus, porta id viverra nec, aliquet in lorem. Quisque faucibus lorem vitae nulla adipiscing, in aliquet lorem cursus. Pellentesque id suscipit justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sagittis non ante quis vehicula.&lt;/p&gt;\r\n&lt;p&gt;Sed at metus ipsum. Integer odio leo, volutpat eu sagittis sed, sodales vel dui. Vestibulum nec tellus orci. Etiam hendrerit at arcu vel interdum. Praesent quis nulla adipiscing, convallis est in, pulvinar quam. Curabitur at massa pulvinar eros rhoncus molestie vitae eget purus. Curabitur ullamcorper dictum tortor, in blandit urna gravida et. Nulla a nisl ligula. Vestibulum lobortis rutrum luctus. Phasellus mattis, turpis at dignissim fringilla, quam quam egestas nisl, vel viverra sem diam gravida purus. In eget erat rutrum, pulvinar lectus porta, aliquam lorem. Sed lorem purus, sodales id pellentesque id, volutpat a tellus. Nam aliquam ullamcorper odio sed egestas. Donec vel dictum odio.&lt;/p&gt;', 'Test Meta Description', 'lorem, ipsum', '')";

        $this->execute($sql);

        // blog_post_to_category
        $sql = "INSERT INTO `{$this->prefix}blog_post_to_category` VALUES
        (1, 1),
        (1, 2)";

        $this->execute($sql);

        // blog_post_to_store
        $sql = "INSERT INTO `{$this->prefix}blog_post_to_store` VALUES
        (1, 0)";

        $this->execute($sql);

        // category
        $sql = "INSERT INTO `{$this->prefix}category` VALUES
        (17, '', 0, 1, 1, 0, 1, '2009-01-03 21:08:57', '2014-06-28 01:02:28'),
        (18, 'data/demo/hp_2.jpg', 0, 1, 0, 0, 1, '2009-01-05 21:49:15', '2015-04-18 18:06:12'),
        (20, 'data/demo/compaq_presario.jpg', 0, 1, 1, 0, 1, '2009-01-05 21:49:43', '2014-09-16 06:49:47'),
        (24, '', 0, 1, 1, 0, 1, '2009-01-20 02:36:26', '2014-06-28 01:02:39'),
        (25, '', 0, 1, 1, 0, 1, '2009-01-31 01:04:25', '2014-06-28 01:00:35'),
        (26, '', 20, 0, 0, 0, 1, '2009-01-31 01:55:14', '2014-06-28 01:07:06'),
        (27, '', 20, 0, 0, 0, 1, '2009-01-31 01:55:34', '2014-06-28 01:07:17'),
        (28, '', 25, 0, 0, 0, 1, '2009-02-02 13:11:12', '2014-06-28 01:01:09'),
        (29, '', 25, 0, 0, 0, 1, '2009-02-02 13:11:37', '2014-06-28 01:00:57'),
        (30, '', 25, 0, 0, 0, 1, '2009-02-02 13:11:59', '2014-06-28 01:08:08'),
        (31, '', 25, 0, 0, 0, 1, '2009-02-03 14:17:24', '2014-06-28 01:07:52'),
        (32, '', 25, 0, 0, 0, 1, '2009-02-03 14:17:34', '2014-06-28 01:07:41'),
        (33, '', 0, 1, 1, 0, 1, '2009-02-03 14:17:55', '2014-12-31 19:37:25'),
        (34, 'data/demo/ipod_touch_4.jpg', 0, 1, 3, 0, 1, '2009-02-03 14:18:11', '2015-04-22 21:27:18'),
        (35, '', 28, 0, 0, 0, 1, '2010-09-17 10:06:48', '2014-06-28 01:01:31'),
        (36, '', 28, 0, 0, 0, 1, '2010-09-17 10:07:13', '2014-06-28 01:01:44'),
        (37, '', 34, 0, 0, 0, 1, '2010-09-18 14:03:39', '2014-06-28 01:03:32'),
        (38, '', 34, 0, 0, 0, 1, '2010-09-18 14:03:51', '2014-06-28 01:03:41'),
        (39, '', 34, 0, 0, 0, 1, '2010-09-18 14:04:17', '2014-06-28 01:03:20'),
        (40, '', 34, 0, 0, 0, 1, '2010-09-18 14:05:36', '2014-06-28 01:03:12'),
        (41, '', 34, 0, 0, 0, 1, '2010-09-18 14:05:49', '2014-06-28 01:03:03'),
        (42, '', 34, 0, 0, 0, 1, '2010-09-18 14:06:34', '2014-06-28 01:02:49'),
        (43, '', 34, 0, 0, 0, 1, '2010-09-18 14:06:49', '2014-06-28 01:05:54'),
        (44, '', 34, 0, 0, 0, 1, '2010-09-21 15:39:21', '2014-06-28 01:05:44'),
        (45, '', 18, 0, 0, 0, 1, '2010-09-24 18:29:16', '2014-06-28 01:06:20'),
        (46, '', 18, 0, 0, 0, 1, '2010-09-24 18:29:31', '2015-04-18 17:41:15'),
        (47, '', 34, 0, 0, 0, 1, '2010-11-07 11:13:16', '2014-06-28 01:05:36'),
        (48, '', 34, 0, 0, 0, 1, '2010-11-07 11:13:33', '2014-06-28 01:05:29'),
        (49, '', 34, 0, 0, 0, 1, '2010-11-07 11:14:04', '2014-06-28 01:05:14'),
        (50, '', 34, 0, 0, 0, 1, '2010-11-07 11:14:23', '2014-06-28 01:05:05'),
        (51, '', 34, 0, 0, 0, 1, '2010-11-07 11:14:38', '2014-06-28 01:04:59'),
        (52, '', 34, 0, 0, 0, 1, '2010-11-07 11:16:09', '2014-06-28 01:04:51'),
        (53, '', 34, 0, 0, 0, 1, '2010-11-07 11:28:53', '2014-06-28 01:04:30'),
        (54, '', 34, 0, 0, 0, 1, '2010-11-07 11:29:16', '2014-06-28 01:04:12'),
        (55, '', 34, 0, 0, 0, 1, '2010-11-08 10:31:32', '2014-06-28 01:03:56'),
        (56, '', 34, 0, 0, 0, 1, '2010-11-08 10:31:50', '2014-06-28 01:03:48'),
        (57, '', 0, 1, 1, 0, 1, '2011-04-26 08:53:16', '2014-06-28 01:02:19'),
        (58, '', 52, 0, 0, 0, 1, '2011-05-08 13:44:16', '2014-06-28 01:04:38'),
        (59, '', 0, 0, 1, 0, 1, '2015-04-22 13:21:30', '2015-04-22 13:21:30')";

        $this->execute($sql);

        // category_description
        $sql = "INSERT INTO `{$this->prefix}category_description` VALUES
        (17, 1, 'Software', '', '', ''),
        (18, 1, 'Laptops &amp; Notebooks', '&lt;p&gt;Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse, Shop Laptop has the most comprehensive selection of laptops on the internet. At Shop Laptop, we pride ourselves on offering customers the very best laptop deals. From refurbished laptops to netbooks, Shop Laptop ensures that every laptop - in every colour, style, size and technical spec - is featured on the site at the lowest possible price.&lt;/p&gt;\r\n', 'Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse,.', 'laptop, deals, laptop deals'),
        (20, 1, 'Desktops', '&lt;p&gt;Example of category description text&lt;/p&gt;\r\n', 'Example of category description', ''),
        (24, 1, 'Phones &amp; PDAs', '', '', ''),
        (25, 1, 'Components', '', '', ''),
        (26, 1, 'PC', '', '', ''),
        (27, 1, 'Mac', '', '', ''),
        (28, 1, 'Monitors', '', '', ''),
        (29, 1, 'Mice and Trackballs', '', '', ''),
        (30, 1, 'Printers', '', '', ''),
        (31, 1, 'Scanners', '', '', ''),
        (32, 1, 'Web Cameras', '', '', ''),
        (33, 1, 'Cameras', '&lt;p&gt;&lt;br&gt;&lt;/p&gt;', '', ''),
        (34, 1, 'MP3 Players', '&lt;p&gt;Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse, Shop Laptop has the most comprehensive selection of laptops on the internet. At Shop Laptop, we pride ourselves on offering customers the very best laptop deals. From refurbished laptops to netbooks, Shop Laptop ensures that every laptop - in every colour, style, size and technical spec - is featured on the site at the lowest possible price.&lt;/p&gt;\r\n', '', ''),
        (35, 1, 'test 1', '', '', ''),
        (36, 1, 'test 2', '', '', ''),
        (37, 1, 'test 5', '', '', ''),
        (38, 1, 'test 4', '', '', ''),
        (39, 1, 'test 6', '', '', ''),
        (40, 1, 'test 7', '', '', ''),
        (41, 1, 'test 8', '', '', ''),
        (42, 1, 'test 9', '', '', ''),
        (43, 1, 'test 11', '', '', ''),
        (44, 1, 'test 12', '', '', ''),
        (45, 1, 'Windows', '', '', ''),
        (46, 1, 'Macs', '&lt;p&gt;&lt;span style=&quot;color: rgb(33, 36, 37);&quot;&gt;Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. &lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(33, 36, 37);&quot;&gt;It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an.', 'industry, dummy, ipsum, lorem, dummy text, lorem ipsum'),
        (47, 1, 'test 15', '', '', ''),
        (48, 1, 'test 16', '', '', ''),
        (49, 1, 'test 17', '', '', ''),
        (50, 1, 'test 18', '', '', ''),
        (51, 1, 'test 19', '', '', ''),
        (52, 1, 'test 20', '', '', ''),
        (53, 1, 'test 21', '', '', ''),
        (54, 1, 'test 22', '', '', ''),
        (55, 1, 'test 23', '', '', ''),
        (56, 1, 'test 24', '', '', ''),
        (57, 1, 'Tablets', '', '', ''),
        (58, 1, 'test 25', '', '', ''),
        (59, 1, 'Live Events', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. &lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;Duis et elit augue. Nulla auctor nunc et ultrices lobortis. Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.&lt;/div&gt;', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu,.', 'ligula')";

        $this->execute($sql);

        // category_path
        $sql = "INSERT INTO `{$this->prefix}category_path` VALUES
        (17, 17, 0),
        (18, 18, 0),
        (20, 20, 0),
        (24, 24, 0),
        (25, 25, 0),
        (26, 20, 0),
        (26, 26, 1),
        (27, 20, 0),
        (27, 27, 1),
        (28, 25, 0),
        (28, 28, 1),
        (29, 25, 0),
        (29, 29, 1),
        (30, 25, 0),
        (30, 30, 1),
        (31, 25, 0),
        (31, 31, 1),
        (32, 25, 0),
        (32, 32, 1),
        (33, 33, 0),
        (34, 34, 0),
        (35, 25, 0),
        (35, 28, 1),
        (35, 35, 2),
        (36, 25, 0),
        (36, 28, 1),
        (36, 36, 2),
        (37, 34, 0),
        (37, 37, 1),
        (38, 34, 0),
        (38, 38, 1),
        (39, 34, 0),
        (39, 39, 1),
        (40, 34, 0),
        (40, 40, 1),
        (41, 34, 0),
        (41, 41, 1),
        (42, 34, 0),
        (42, 42, 1),
        (43, 34, 0),
        (43, 43, 1),
        (44, 34, 0),
        (44, 44, 1),
        (45, 18, 0),
        (45, 45, 1),
        (46, 18, 0),
        (46, 46, 1),
        (47, 34, 0),
        (47, 47, 1),
        (48, 34, 0),
        (48, 48, 1),
        (49, 34, 0),
        (49, 49, 1),
        (50, 34, 0),
        (50, 50, 1),
        (51, 34, 0),
        (51, 51, 1),
        (52, 34, 0),
        (52, 52, 1),
        (53, 34, 0),
        (53, 53, 1),
        (54, 34, 0),
        (54, 54, 1),
        (55, 34, 0),
        (55, 55, 1),
        (56, 34, 0),
        (56, 56, 1),
        (57, 57, 0),
        (58, 34, 0),
        (58, 52, 1),
        (58, 58, 2),
        (59, 59, 0)";

        $this->execute($sql);

        // category_to_store
        $sql = "INSERT INTO `{$this->prefix}category_to_store` VALUES
        (17, 0),
        (18, 0),
        (20, 0),
        (24, 0),
        (25, 0),
        (26, 0),
        (27, 0),
        (28, 0),
        (29, 0),
        (30, 0),
        (31, 0),
        (32, 0),
        (33, 0),
        (34, 0),
        (35, 0),
        (36, 0),
        (37, 0),
        (38, 0),
        (39, 0),
        (40, 0),
        (41, 0),
        (42, 0),
        (43, 0),
        (44, 0),
        (45, 0),
        (46, 0),
        (47, 0),
        (48, 0),
        (49, 0),
        (50, 0),
        (51, 0),
        (52, 0),
        (53, 0),
        (54, 0),
        (55, 0),
        (56, 0),
        (57, 0),
        (58, 0),
        (59, 0)";

        $this->execute($sql);

        // coupon
        $sql = "INSERT INTO `{$this->prefix}coupon` VALUES
        (4, '-10% Discount', '2222', 'P', '10.0000', 0, 0, '0.0000', '2011-01-01', '2012-01-01', 10, '10', 1, '2009-01-27 13:55:03'),
        (5, 'Free Shipping', '3333', 'P', '0.0000', 0, 1, '100.0000', '2009-03-01', '2009-08-31', 10, '10', 1, '2009-03-14 21:13:53'),
        (6, '-10.00 Discount', '1111', 'F', '10.0000', 0, 0, '10.0000', '1970-11-01', '2020-11-01', 100000, '10000', 1, '2009-03-14 21:15:18')";

        $this->execute($sql);

        // manufacturer
        $sql = "INSERT INTO `{$this->prefix}manufacturer` VALUES
        (5, 'HTC', 'data/demo/htc_logo.jpg', 0),
        (6, 'Palm', 'data/demo/palm_logo.jpg', 0),
        (7, 'Hewlett-Packard', 'data/demo/hp_logo.jpg', 0),
        (8, 'Apple', 'data/demo/apple_logo.jpg', 0),
        (9, 'Canon', 'data/demo/canon_logo.jpg', 0),
        (10, 'Sony', 'data/demo/sony_logo.jpg', 0),
        (11, 'Solution Labs', 'data/manufacturers/solution-labs.png', 0)";

        $this->execute($sql);

        // manufacturer_to_store
        $sql = "INSERT INTO `{$this->prefix}manufacturer_to_store` VALUES
        (5, 0),
        (6, 0),
        (7, 0),
        (8, 0),
        (9, 0),
        (10, 0),
        (11, 0)";

        $this->execute($sql);

        // menu
        $sql = "INSERT INTO `{$this->prefix}menu` VALUES
        (3, 'Blog Header Menu', 'content_category', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 1),
        (10, 'Posts', 'post', 'a:1:{i:0;s:1:\"1\";}', 1),
        (14, 'Blog Categories', 'content_category', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', 1),
        (15, 'Product Categories', 'product_category', 'a:37:{i:0;s:2:\"33\";i:1;s:2:\"25\";i:2;s:2:\"29\";i:3;s:2:\"28\";i:4;s:2:\"35\";i:5;s:2:\"36\";i:6;s:2:\"30\";i:7;s:2:\"31\";i:8;s:2:\"32\";i:9;s:2:\"20\";i:10;s:2:\"27\";i:11;s:2:\"26\";i:12;s:2:\"18\";i:13;s:2:\"46\";i:14;s:2:\"45\";i:15;s:2:\"34\";i:16;s:2:\"43\";i:17;s:2:\"44\";i:18;s:2:\"47\";i:19;s:2:\"48\";i:20;s:2:\"49\";i:21;s:2:\"50\";i:22;s:2:\"51\";i:23;s:2:\"52\";i:24;s:2:\"58\";i:25;s:2:\"53\";i:26;s:2:\"54\";i:27;s:2:\"55\";i:28;s:2:\"56\";i:29;s:2:\"38\";i:30;s:2:\"37\";i:31;s:2:\"39\";i:32;s:2:\"40\";i:33;s:2:\"41\";i:34;s:2:\"42\";i:35;s:2:\"24\";i:36;s:2:\"57\";}', 1),
        (17, 'Shop Header', 'product_category', 'a:37:{i:0;s:2:\"33\";i:1;s:2:\"25\";i:2;s:2:\"29\";i:3;s:2:\"28\";i:4;s:2:\"35\";i:5;s:2:\"36\";i:6;s:2:\"30\";i:7;s:2:\"31\";i:8;s:2:\"32\";i:9;s:2:\"20\";i:10;s:2:\"27\";i:11;s:2:\"26\";i:12;s:2:\"18\";i:13;s:2:\"46\";i:14;s:2:\"45\";i:15;s:2:\"34\";i:16;s:2:\"43\";i:17;s:2:\"44\";i:18;s:2:\"47\";i:19;s:2:\"48\";i:20;s:2:\"49\";i:21;s:2:\"50\";i:22;s:2:\"51\";i:23;s:2:\"52\";i:24;s:2:\"58\";i:25;s:2:\"53\";i:26;s:2:\"54\";i:27;s:2:\"55\";i:28;s:2:\"56\";i:29;s:2:\"38\";i:30;s:2:\"37\";i:31;s:2:\"39\";i:32;s:2:\"40\";i:33;s:2:\"41\";i:34;s:2:\"42\";i:35;s:2:\"24\";i:36;s:2:\"57\";}', 1)";

        $this->execute($sql);

        // option
        $sql = "INSERT INTO `{$this->prefix}option` VALUES
        (1, 'radio', 2),
        (2, 'checkbox', 3),
        (4, 'text', 4),
        (5, 'select', 1),
        (6, 'textarea', 5),
        (7, 'file', 6),
        (8, 'date', 7),
        (9, 'time', 8),
        (10, 'datetime', 9),
        (11, 'select', 1),
        (12, 'date', 1)";

        $this->execute($sql);

        // option_description
        $sql = "INSERT INTO `{$this->prefix}option_description` VALUES
        (1, 1, 'Radio'),
        (2, 1, 'Checkbox'),
        (4, 1, 'Text'),
        (5, 1, 'Select'),
        (6, 1, 'Textarea'),
        (7, 1, 'File'),
        (8, 1, 'Date'),
        (9, 1, 'Time'),
        (10, 1, 'Date &amp; Time'),
        (11, 1, 'Size'),
        (12, 1, 'Delivery Date')";

        $this->execute($sql);

        // option_value
        $sql = "INSERT INTO `{$this->prefix}option_value` VALUES
        (23, 2, '', 1),
        (24, 2, '', 2),
        (31, 1, '', 2),
        (32, 1, '', 1),
        (39, 5, '', 1),
        (40, 5, '', 2),
        (41, 5, '', 3),
        (42, 5, '', 4),
        (43, 1, '', 3),
        (44, 2, '', 3),
        (45, 2, '', 4),
        (46, 11, '', 1),
        (47, 11, '', 2),
        (48, 11, '', 3)";

        $this->execute($sql);

        // option_value_description
        $sql = "INSERT INTO `{$this->prefix}option_value_description` VALUES
        (23, 1, 2, 'Checkbox 1'),
        (24, 1, 2, 'Checkbox 2'),
        (31, 1, 1, 'Medium'),
        (32, 1, 1, 'Small'),
        (39, 1, 5, 'Red'),
        (40, 1, 5, 'Blue'),
        (41, 1, 5, 'Green'),
        (42, 1, 5, 'Yellow'),
        (43, 1, 1, 'Large'),
        (44, 1, 2, 'Checkbox 3'),
        (45, 1, 2, 'Checkbox 4'),
        (46, 1, 11, 'Small'),
        (47, 1, 11, 'Medium'),
        (48, 1, 11, 'Large')";

        $this->execute($sql);

        // product
        $sql = "INSERT INTO `{$this->prefix}product` VALUES
        (28, 0, 'Product 1', '', '', '', '', '', '', '', 1, 939, 7, 'data/demo/htc_touch_hd_1.jpg', 5, 1, '100.0000', 200, 9, '2009-02-03', '0000-00-00 00:00:00', '146.40000000', 2, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 16:06:50', '2014-08-17 00:05:03', 5, 0),
        (29, 0, 'Product 2', '', '', '', '', '', '', '', 1, 999, 6, 'data/demo/palm_treo_pro_1.jpg', 6, 1, '279.9900', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '133.00000000', 2, '0.00000000', '0.00000000', '0.00000000', 3, 1, 1, 0, 1, '2009-02-03 16:42:17', '2014-07-06 22:42:53', 1, 0),
        (30, 0, 'Product 3', '', '', '', '', '', '', '', 1, 7, 6, 'data/demo/canon_eos_5d_1.jpg', 9, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 16:59:00', '2014-09-28 23:59:28', 1, 0),
        (31, 0, 'Product 4', '', '', '', '', '', '', '', 1, 1000, 6, 'data/demo/nikon_d300_1.jpg', 0, 1, '80.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 3, 1, 1, 0, 1, '2009-02-03 17:00:10', '2014-07-06 22:42:45', 0, 0),
        (32, 0, 'Product 5', '', '', '', '', '', '', '', 1, 999, 6, 'data/demo/ipod_touch_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 17:07:26', '2014-07-06 22:41:48', 0, 0),
        (33, 0, 'Product 6', '', '', '', '', '', '', '', 1, 1000, 6, 'data/demo/samsung_syncmaster_941bw.jpg', 0, 1, '200.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 17:08:31', '2014-07-06 22:43:42', 0, 0),
        (34, 0, 'Product 7', '', '', '', '', '', '', '', 1, 1000, 6, 'data/demo/ipod_shuffle_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 18:07:54', '2014-07-06 22:41:19', 0, 0),
        (36, 0, 'Product 9', '', '', '', '', '', '', '', 1, 994, 6, 'data/demo/ipod_nano_1.jpg', 8, 0, '100.0000', 100, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 18:09:19', '2014-07-06 22:41:02', 0, 0),
        (40, 0, 'product 11', '', '', '', '', '', '', '', 1, 970, 5, 'data/demo/iphone_1.jpg', 8, 1, '101.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '10.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 21:07:12', '2014-07-06 22:39:10', 0, 0),
        (41, 0, 'Product 14', '', '', '', '', '', '', '', 1, 977, 5, 'data/demo/imac_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 21:07:26', '2015-04-11 01:06:30', 4, 0),
        (42, 0, 'Product 15', '', '', '', '', '', '', '', 1, 990, 5, 'data/demo/apple_cinema_30.jpg', 8, 1, '100.0000', 400, 9, '2009-02-04', '0000-00-00 00:00:00', '12.50000000', 1, '1.00000000', '2.00000000', '3.00000000', 1, 1, 2, 0, 1, '2009-02-03 21:07:37', '2015-05-05 04:34:41', 2, 0),
        (43, 0, 'Product 16', '', '', '', '', '', '', '', 1, 929, 5, 'data/demo/macbook_1.jpg', 8, 0, '500.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:07:49', '2015-02-13 22:38:54', 5, 0),
        (44, 0, 'Product 17', '', '', '', '', '', '', '', 1, 1000, 5, 'data/demo/macbook_air_1.jpg', 8, 1, '1000.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:08:00', '2015-02-13 22:39:07', 26, 0),
        (45, 0, 'Product 18', '', '', '', '', '', '', '', 1, 998, 5, 'data/demo/macbook_pro_1.jpg', 8, 1, '2000.0000', 0, 0, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:08:17', '2015-04-18 17:50:06', 38, 0),
        (46, 0, 'Product 19', '', '', '', '', '', '', '', 1, 1000, 5, 'data/demo/sony_vaio_1.jpg', 10, 1, '1000.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:08:29', '2014-07-06 22:43:58', 1, 0),
        (47, 0, 'Product 21', '', '', '', '', '', '', '', 1, 1000, 5, 'data/demo/hp_1.jpg', 7, 1, '100.0000', 400, 9, '2009-02-03', '0000-00-00 00:00:00', '1.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 0, 1, 0, 1, '2009-02-03 21:08:40', '2014-07-06 22:30:26', 22, 0),
        (48, 0, 'product 20', 'test 1', '', '', '', '', '', 'test 2', 1, 995, 5, 'data/demo/ipod_classic_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-08', '0000-00-00 00:00:00', '1.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-08 17:21:51', '2014-07-06 22:40:44', 2, 0),
        (49, 0, 'SAM1', '', '', '', '', '', '', '', 1, 0, 8, 'data/demo/samsung_tab_1.jpg', 0, 1, '199.9900', 0, 9, '2011-04-25', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 1, 1, '2011-04-26 08:57:34', '2014-07-06 22:43:27', 1, 0)";

        $this->execute($sql);

        // product_attribute
        $sql = "INSERT INTO `{$this->prefix}product_attribute` VALUES
        (42, 3, 1, '100mhz'),
        (43, 2, 1, '1'),
        (43, 4, 1, '8gb'),
        (47, 2, 1, '4'),
        (47, 4, 1, '16GB')";

        $this->execute($sql);

        // product_description
        $sql = "INSERT INTO `{$this->prefix}product_description` VALUES
        (28, 1, 'HTC Touch HD', '&lt;p&gt;HTC Touch - in High Definition. Watch music videos and streaming content in awe-inspiring high definition clarity for a mobile experience you never thought possible. Seductively sleek, the HTC Touch HD provides the next generation of mobile functionality, all at a simple touch. Fully integrated with Windows Mobile Professional 6.1, ultrafast 3.5G, GPS, 5MP camera, plus lots more - all delivered on a breathtakingly crisp 3.8&quot; WVGA touchscreen - you can take control of your mobile world with the HTC Touch HD.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Features&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n &lt;li&gt;Processor Qualcomm® MSM 7201A™ 528 MHz&lt;/li&gt;\r\n &lt;li&gt;Windows Mobile® 6.1 Professional Operating System&lt;/li&gt;\r\n  &lt;li&gt;Memory: 512 MB ROM, 288 MB RAM&lt;/li&gt;\r\n &lt;li&gt;Dimensions: 115 mm x 62.8 mm x 12 mm / 146.4 grams&lt;/li&gt;\r\n &lt;li&gt;3.8-inch TFT-LCD flat touch-sensitive screen with 480 x 800 WVGA resolution&lt;/li&gt;\r\n    &lt;li&gt;HSDPA/WCDMA: Europe/Asia: 900/2100 MHz; Up to 2 Mbps up-link and 7.2 Mbps down-link speeds&lt;/li&gt;\r\n &lt;li&gt;Quad-band GSM/GPRS/EDGE: Europe/Asia: 850/900/1800/1900 MHz (Band frequency, HSUPA availability, and data speed are operator dependent.)&lt;/li&gt;\r\n   &lt;li&gt;Device Control via HTC TouchFLO™ 3D &amp; Touch-sensitive front panel buttons&lt;/li&gt;\r\n  &lt;li&gt;GPS and A-GPS ready&lt;/li&gt;\r\n    &lt;li&gt;Bluetooth® 2.0 with Enhanced Data Rate and A2DP for wireless stereo headsets&lt;/li&gt;\r\n   &lt;li&gt;Wi-Fi®: IEEE 802.11 b/g&lt;/li&gt;\r\n    &lt;li&gt;HTC ExtUSB™ (11-pin mini-USB 2.0)&lt;/li&gt;\r\n  &lt;li&gt;5 megapixel color camera with auto focus&lt;/li&gt;\r\n   &lt;li&gt;VGA CMOS color camera&lt;/li&gt;\r\n  &lt;li&gt;Built-in 3.5 mm audio jack, microphone, speaker, and FM radio&lt;/li&gt;\r\n  &lt;li&gt;Ring tone formats: AAC, AAC+, eAAC+, AMR-NB, AMR-WB, QCP, MP3, WMA, WAV&lt;/li&gt;\r\n    &lt;li&gt;40 polyphonic and standard MIDI format 0 and 1 (SMF)/SP MIDI&lt;/li&gt;\r\n   &lt;li&gt;Rechargeable Lithium-ion or Lithium-ion polymer 1350 mAh battery&lt;/li&gt;\r\n   &lt;li&gt;Expansion Slot: microSD™ memory card (SD 2.0 compatible)&lt;/li&gt;\r\n   &lt;li&gt;AC Adapter Voltage range/frequency: 100 ~ 240V AC, 50/60 Hz DC output: 5V and 1A&lt;/li&gt;\r\n   &lt;li&gt;Special Features: FM Radio, G-Sensor&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '', ''),
        (29, 1, 'Palm Treo Pro', '&lt;p&gt;Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can respond to business and personal email, stay on top of appointments and contacts, and use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with news and sports on the web, or listen to a few songs. Balance your work and play the way you like it, with the Palm Treo Pro.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Features&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n    &lt;li&gt;Windows Mobile® 6.1 Professional Edition&lt;/li&gt;\r\n   &lt;li&gt;Qualcomm® MSM7201 400MHz Processor&lt;/li&gt;\r\n &lt;li&gt;320x320 transflective colour TFT touchscreen&lt;/li&gt;\r\n   &lt;li&gt;HSDPA/UMTS/EDGE/GPRS/GSM radio&lt;/li&gt;\r\n &lt;li&gt;Tri-band UMTS — 850MHz, 1900MHz, 2100MHz&lt;/li&gt;\r\n   &lt;li&gt;Quad-band GSM — 850/900/1800/1900&lt;/li&gt;\r\n  &lt;li&gt;802.11b/g with WPA, WPA2, and 801.1x authentication&lt;/li&gt;\r\n    &lt;li&gt;Built-in GPS&lt;/li&gt;\r\n   &lt;li&gt;Bluetooth Version: 2.0 + Enhanced Data Rate&lt;/li&gt;\r\n    &lt;li&gt;256MB storage (100MB user available), 128MB RAM&lt;/li&gt;\r\n    &lt;li&gt;2.0 megapixel camera, up to 8x digital zoom and video capture&lt;/li&gt;\r\n  &lt;li&gt;Removable, rechargeable 1500mAh lithium-ion battery&lt;/li&gt;\r\n    &lt;li&gt;Up to 5.0 hours talk time and up to 250 hours standby&lt;/li&gt;\r\n  &lt;li&gt;MicroSDHC card expansion (up to 32GB supported)&lt;/li&gt;\r\n    &lt;li&gt;MicroUSB 2.0 for synchronization and charging&lt;/li&gt;\r\n  &lt;li&gt;3.5mm stereo headset jack&lt;/li&gt;\r\n  &lt;li&gt;60mm (W) x 114mm (L) x 13.5mm (D) / 133g&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '', ''),
        (30, 1, 'Canon EOS 5D', '&lt;p&gt;Canon''s press material for the EOS 5D states that it ''defines (a) new D-SLR category'', while we''re not typically too concerned with marketing talk this particular statement is clearly pretty accurate. The EOS 5D is unlike any previous digital SLR in that it combines a full-frame (35 mm sized) high resolution sensor (12.8 megapixels) with a relatively compact body (slightly larger than the EOS 20D, although in your hand it feels noticeably ''chunkier''). The EOS 5D is aimed to slot in between the EOS 20D and the EOS-1D professional digital SLR''s, an important difference when compared to the latter is that the EOS 5D doesn''t have any environmental seals. While Canon don''t specifically refer to the EOS 5D as a ''professional'' digital SLR it will have obvious appeal to professionals who want a high quality digital SLR in a body lighter than the EOS-1D. It will also no doubt appeal to current EOS 20D owners (although lets hope they''ve not bought too many EF-S lenses...) äë&lt;/p&gt;\r\n', '', ''),
        (31, 1, 'Nikon D300', '&lt;p&gt;Engineered with pro-level features and performance, the 12.3-effective-megapixel D300 combines brand new technologies with advanced features inherited from Nikon''s newly announced D3 professional digital SLR camera to offer serious photographers remarkable performance combined with agility.&lt;br /&gt;\r\n&lt;br /&gt;\r\nSimilar to the D3, the D300 features Nikon''s exclusive EXPEED Image Processing System that is central to driving the speed and processing power needed for many of the camera''s new features. The D300 features a new 51-point autofocus system with Nikon''s 3D Focus Tracking feature and two new LiveView shooting modes that allow users to frame a photograph using the camera''s high-resolution LCD monitor. The D300 shares a similar Scene Recognition System as is found in the D3; it promises to greatly enhance the accuracy of autofocus, autoexposure, and auto white balance by recognizing the subject or scene being photographed and applying this information to the calculations for the three functions.&lt;br /&gt;\r\n&lt;br /&gt;\r\nThe D300 reacts with lightning speed, powering up in a mere 0.13 seconds and shooting with an imperceptible 45-millisecond shutter release lag time. The D300 is capable of shooting at a rapid six frames per second and can go as fast as eight frames per second when using the optional MB-D10 multi-power battery pack. In continuous bursts, the D300 can shoot up to 100 shots at full 12.3-megapixel resolution. (NORMAL-LARGE image setting, using a SanDisk Extreme IV 1GB CompactFlash card.)&lt;br /&gt;\r\n&lt;br /&gt;\r\nThe D300 incorporates a range of innovative technologies and features that will significantly improve the accuracy, control, and performance photographers can get from their equipment. Its new Scene Recognition System advances the use of Nikon''s acclaimed 1,005-segment sensor to recognize colors and light patterns that help the camera determine the subject and the type of scene being photographed before a picture is taken. This information is used to improve the accuracy of autofocus, autoexposure, and auto white balance functions in the D300. For example, the camera can track moving subjects better and by identifying them, it can also automatically select focus points faster and with greater accuracy. It can also analyze highlights and more accurately determine exposure, as well as infer light sources to deliver more accurate white balance detection.&lt;/p&gt;\r\n&lt;!-- cpt_container_end --&gt;', '', ''),
        (32, 1, 'iPod Touch', '&lt;p&gt;&lt;strong&gt;Revolutionary multi-touch interface.&lt;/strong&gt;&lt;br /&gt;\r\niPod touch features the same multi-touch screen technology as iPhone. Pinch to zoom in on a photo. Scroll through your songs and videos with a flick. Flip through your library by album artwork with Cover Flow.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Gorgeous 3.5-inch widescreen display.&lt;/strong&gt;&lt;br /&gt;\r\nWatch your movies, TV shows, and photos come alive with bright, vivid color on the 320-by-480-pixel display.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Music downloads straight from iTunes.&lt;/strong&gt;&lt;br /&gt;\r\nShop the iTunes Wi-Fi Music Store from anywhere with Wi-Fi.1 Browse or search to find the music youre looking for, preview it, and buy it with just a tap.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Surf the web with Wi-Fi.&lt;/strong&gt;&lt;br /&gt;\r\nBrowse the web using Safari and watch YouTube videos on the first iPod with Wi-Fi built in&lt;br /&gt;\r\n &lt;/p&gt;\r\n', '', ''),
        (33, 1, 'Samsung SyncMaster 941BW', '&lt;p&gt;Imagine the advantages of going big without slowing down. The big 19&quot; 941BW monitor combines wide aspect ratio with fast pixel response time, for bigger images, more room to work and crisp motion. In addition, the exclusive MagicBright 2, MagicColor and MagicTune technologies help deliver the ideal image in every situation, while sleek, narrow bezels and adjustable stands deliver style just the way you want it. With the Samsung 941BW widescreen analog/digital LCD monitor, it''s not hard to imagine.&lt;/p&gt;\r\n', '', ''),
        (34, 1, 'iPod Shuffle', '&lt;p&gt;&lt;strong&gt;Born to be worn.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Clip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including four new hues to make your musical fashion statement.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Random meets rhythm.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;With iTunes autofill, iPod shuffle can deliver a new musical experience every time you sync. For more randomness, you can shuffle songs during playback with the slide of a switch.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Everything is easy.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Charge and sync with the included USB dock. Operate the iPod shuffle controls with one hand. Enjoy up to 12 hours straight of skip-free music playback.&lt;/p&gt;\r\n', '', ''),
        (36, 1, 'iPod Nano', '&lt;p&gt;&lt;strong&gt;Video in your pocket.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Its the small iPod with one very big idea: video. The worlds most popular music player now lets you enjoy movies, TV shows, and more on a two-inch display thats 65% brighter than before.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Cover Flow.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Browse through your music collection by flipping through album art. Select an album to turn it over and see the track list.&lt;strong&gt;&amp;nbsp;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Enhanced interface.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Experience a whole new way to browse and view your music and video.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Sleek and colorful.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;With an anodized aluminum and polished stainless steel enclosure and a choice of five colors, iPod nano is dressed to impress.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;iTunes.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Available as a free download, iTunes makes it easy to browse and buy millions of songs, movies, TV shows, audiobooks, and games and download free podcasts all at the iTunes Store. And you can import your own music, manage your whole media library, and sync your iPod or iPhone with ease.&lt;/p&gt;\r\n', '', ''),
        (40, 1, 'iPhone', '&lt;p&gt;iPhone is a revolutionary new mobile phone that allows you to make a call by simply tapping a name or number in your address book, a favorites list, or a call log. It also automatically syncs all your contacts from a PC, Mac, or Internet service. And it lets you select and listen to voicemail messages in whatever order you want just like email.&lt;/p&gt;\r\n', '', ''),
        (41, 1, 'iMac', '&lt;p&gt;Just when you thought iMac had everything, now there´s even more. More powerful Intel Core 2 Duo processors. And more memory standard. Combine this with Mac OS X Leopard and iLife ´08, and it´s more all-in-one than ever. iMac packs amazing performance into a stunningly slim space.&lt;/p&gt;\r\n', '', ''),
        (42, 1, 'Apple Cinema 30&quot;', '&lt;p&gt;The 30-inch Apple Cinema HD Display delivers an amazing 2560 x 1600 pixel resolution. Designed specifically for the creative professional, this display provides more space for easier access to all the tools and palettes needed to edit, format and composite your work. Combine this display with a Mac Pro, MacBook Pro, or PowerMac G5 and there''s no limit to what you can achieve.&lt;br&gt;\r\n&lt;br&gt;\r\nThe Cinema HD features an active-matrix liquid crystal display that produces flicker-free images that deliver twice the brightness, twice the sharpness and twice the contrast ratio of a typical CRT display. Unlike other flat panels, it''s designed with a pure digital interface to deliver distortion-free images that never need adjusting. With over 4 million digital pixels, the display is uniquely suited for scientific and technical applications such as visualizing molecular structures or analyzing geological data.&lt;br&gt;\r\n&lt;br&gt;\r\nOffering accurate, brilliant color performance, the Cinema HD delivers up to 16.7 million colors across a wide gamut allowing you to see subtle nuances between colors from soft pastels to rich jewel tones. A wide viewing angle ensures uniform color from edge to edge. Apple''s ColorSync technology allows you to create custom profiles to maintain consistent color onscreen and in print. The result: You can confidently use this display in all your color-critical applications.&lt;br&gt;\r\n&lt;br&gt;\r\nHoused in a new aluminum design, the display has a very thin bezel that enhances visual accuracy. Each display features two FireWire 400 ports and two USB 2.0 ports, making attachment of desktop peripherals, such as iSight, iPod, digital and still cameras, hard drives, printers and scanners, even more accessible and convenient. Taking advantage of the much thinner and lighter footprint of an LCD, the new displays support the VESA (Video Electronics Standards Association) mounting interface standard. Customers with the optional Cinema Display VESA Mount Adapter kit gain the flexibility to mount their display in locations most appropriate for their work environment.&lt;br&gt;\r\n&lt;br&gt;\r\nThe Cinema HD features a single cable design with elegant breakout for the USB 2.0, FireWire 400 and a pure digital connection using the industry standard Digital Video Interface (DVI) interface. The DVI connection allows for a direct pure-digital connection.&lt;/p&gt;\r\n\r\n&lt;h3&gt;Features:&lt;/h3&gt;\r\n\r\n&lt;p&gt;Unrivaled display performance&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n   &lt;li&gt;30-inch (viewable) active-matrix liquid crystal display provides breathtaking image quality and vivid, richly saturated color.&lt;/li&gt;\r\n &lt;li&gt;Support for 2560-by-1600 pixel resolution for display of high definition still and video imagery.&lt;/li&gt;\r\n  &lt;li&gt;Wide-format design for simultaneous display of two full pages of text and graphics.&lt;/li&gt;\r\n    &lt;li&gt;Industry standard DVI connector for direct attachment to Mac- and Windows-based desktops and notebooks&lt;/li&gt;\r\n &lt;li&gt;Incredibly wide (170 degree) horizontal and vertical viewing angle for maximum visibility and color performance.&lt;/li&gt;\r\n   &lt;li&gt;Lightning-fast pixel response for full-motion digital video playback.&lt;/li&gt;\r\n  &lt;li&gt;Support for 16.7 million saturated colors, for use in all graphics-intensive applications.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;Simple setup and operation&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n   &lt;li&gt;Single cable with elegant breakout for connection to DVI, USB and FireWire ports&lt;/li&gt;\r\n   &lt;li&gt;Built-in two-port USB 2.0 hub for easy connection of desktop peripheral devices.&lt;/li&gt;\r\n   &lt;li&gt;Two FireWire 400 ports to support iSight and other desktop peripherals&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;Sleek, elegant design&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n    &lt;li&gt;Huge virtual workspace, very small footprint.&lt;/li&gt;\r\n  &lt;li&gt;Narrow Bezel design to minimize visual impact of using dual displays&lt;/li&gt;\r\n   &lt;li&gt;Unique hinge design for effortless adjustment&lt;/li&gt;\r\n  &lt;li&gt;Support for VESA mounting solutions (Apple Cinema Display VESA Mount Adapter sold separately)&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;h3&gt;Technical specifications&lt;/h3&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Screen size (diagonal viewable image size)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;Apple Cinema HD Display: 30 inches (29.7-inch viewable)&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Screen type&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n    &lt;li&gt;Thin film transistor (TFT) active-matrix liquid crystal display (AMLCD)&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Resolutions&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n    &lt;li&gt;2560 x 1600 pixels (optimum resolution)&lt;/li&gt;\r\n    &lt;li&gt;2048 x 1280&lt;/li&gt;\r\n    &lt;li&gt;1920 x 1200&lt;/li&gt;\r\n    &lt;li&gt;1280 x 800&lt;/li&gt;\r\n &lt;li&gt;1024 x 640&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Display colors (maximum)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n    &lt;li&gt;16.7 million&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Viewing angle (typical)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n   &lt;li&gt;170° horizontal; 170° vertical&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Brightness (typical)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n    &lt;li&gt;30-inch Cinema HD Display: 400 cd/m2&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Contrast ratio (typical)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;700:1&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Response time (typical)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;16 ms&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Pixel pitch&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;30-inch Cinema HD Display: 0.250 mm&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Screen treatment&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n   &lt;li&gt;Antiglare hardcoat&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;User controls (hardware and software)&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n   &lt;li&gt;Display Power,&lt;/li&gt;\r\n &lt;li&gt;System sleep, wake&lt;/li&gt;\r\n &lt;li&gt;Brightness&lt;/li&gt;\r\n &lt;li&gt;Monitor tilt&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Connectors and cables&lt;/strong&gt;&lt;br&gt;\r\nCable&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;DVI (Digital Visual Interface)&lt;/li&gt;\r\n &lt;li&gt;FireWire 400&lt;/li&gt;\r\n   &lt;li&gt;USB 2.0&lt;/li&gt;\r\n    &lt;li&gt;DC power (24 V)&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;Connectors&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;Two-port, self-powered USB 2.0 hub&lt;/li&gt;\r\n &lt;li&gt;Two FireWire 400 ports&lt;/li&gt;\r\n &lt;li&gt;Kensington security port&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;VESA mount adapter&lt;/strong&gt;&lt;br&gt;\r\nRequires optional Cinema Display VESA Mount Adapter (M9649G/A)&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n    &lt;li&gt;Compatible with VESA FDMI (MIS-D, 100, C) compliant mounting solutions&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Electrical requirements&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n &lt;li&gt;Input voltage: 100-240 VAC 50-60Hz&lt;/li&gt;\r\n &lt;li&gt;Maximum power when operating: 150W&lt;/li&gt;\r\n &lt;li&gt;Energy saver mode: 3W or less&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Environmental requirements&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n   &lt;li&gt;Operating temperature: 50° to 95° F (10° to 35° C)&lt;/li&gt;\r\n &lt;li&gt;Storage temperature: -40° to 116° F (-40° to 47° C)&lt;/li&gt;\r\n    &lt;li&gt;Operating humidity: 20% to 80% noncondensing&lt;/li&gt;\r\n   &lt;li&gt;Maximum operating altitude: 10,000 feet&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Agency approvals&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n   &lt;li&gt;FCC Part 15 Class B&lt;/li&gt;\r\n    &lt;li&gt;EN55022 Class B&lt;/li&gt;\r\n    &lt;li&gt;EN55024&lt;/li&gt;\r\n    &lt;li&gt;VCCI Class B&lt;/li&gt;\r\n   &lt;li&gt;AS/NZS 3548 Class B&lt;/li&gt;\r\n    &lt;li&gt;CNS 13438 Class B&lt;/li&gt;\r\n  &lt;li&gt;ICES-003 Class B&lt;/li&gt;\r\n   &lt;li&gt;ISO 13406 part 2&lt;/li&gt;\r\n   &lt;li&gt;MPR II&lt;/li&gt;\r\n &lt;li&gt;IEC 60950&lt;/li&gt;\r\n  &lt;li&gt;UL 60950&lt;/li&gt;\r\n   &lt;li&gt;CSA 60950&lt;/li&gt;\r\n  &lt;li&gt;EN60950&lt;/li&gt;\r\n    &lt;li&gt;ENERGY STAR&lt;/li&gt;\r\n    &lt;li&gt;TCO ''03&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Size and weight&lt;/strong&gt;&lt;br&gt;\r\n30-inch Apple Cinema HD Display&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;Height: 21.3 inches (54.3 cm)&lt;/li&gt;\r\n  &lt;li&gt;Width: 27.2 inches (68.8 cm)&lt;/li&gt;\r\n   &lt;li&gt;Depth: 8.46 inches (21.5 cm)&lt;/li&gt;\r\n   &lt;li&gt;Weight: 27.5 pounds (12.5 kg)&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;System Requirements&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n  &lt;li&gt;Mac Pro, all graphic options&lt;/li&gt;\r\n   &lt;li&gt;MacBook Pro&lt;/li&gt;\r\n    &lt;li&gt;Power Mac G5 (PCI-X) with ATI Radeon 9650 or better or NVIDIA GeForce 6800 GT DDL or better&lt;/li&gt;\r\n    &lt;li&gt;Power Mac G5 (PCI Express), all graphics options&lt;/li&gt;\r\n   &lt;li&gt;PowerBook G4 with dual-link DVI support&lt;/li&gt;\r\n    &lt;li&gt;Windows PC and graphics card that supports DVI ports with dual-link digital bandwidth and VESA DDC standard for plug-and-play setup&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', '', ''),
        (43, 1, 'MacBook', '&lt;p&gt;&lt;strong&gt;Intel Core 2 Duo processor&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Powered by an Intel Core 2 Duo processor at speeds up to 2.16GHz, the new MacBook is the fastest ever.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;1GB memory, larger hard drives&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;The new MacBook now comes with 1GB of memory standard and larger hard drives for the entire line perfect for running more of your favorite applications and storing growing media collections.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Sleek, 1.08-inch-thin design&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;MacBook makes it easy to hit the road thanks to its tough polycarbonate case, built-in wireless technologies, and innovative MagSafe Power Adapter that releases automatically if someone accidentally trips on the cord.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Built-in iSight camera&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Right out of the box, you can have a video chat with friends or family,2 record a video at your desk, or take fun pictures with Photo Booth&lt;/p&gt;\r\n', '', ''),
        (44, 1, 'MacBook Air', '&lt;p&gt;MacBook Air is ultrathin, ultraportable, and ultra unlike anything else. But you don’t lose inches and pounds overnight. It’s the result of rethinking conventions. Of multiple wireless innovations. And of breakthrough design. With MacBook Air, mobile computing suddenly has a new standard.&lt;/p&gt;\r\n', '', ''),
        (45, 1, 'MacBook Pro', '&lt;p&gt;&lt;strong&gt;Latest Intel mobile architecture&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Powered by the most advanced mobile processors from Intel, the new Core 2 Duo MacBook Pro is over 50% faster than the original Core Duo MacBook Pro and now supports up to 4GB of RAM.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Leading-edge graphics&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;The NVIDIA GeForce 8600M GT delivers exceptional graphics processing power. For the ultimate creative canvas, you can even configure the 17-inch model with a 1920-by-1200 resolution display.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Designed for life on the road&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Innovations such as a magnetic power connection and an illuminated keyboard with ambient light sensor put the MacBook Pro in a class by itself.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Connect. Create. Communicate.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Quickly set up a video conference with the built-in iSight camera. Control presentations and media from up to 30 feet away with the included Apple Remote. Connect to high-bandwidth peripherals with FireWire 800 and DVI.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Next-generation wireless&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Featuring 802.11n wireless technology, the MacBook Pro delivers up to five times the performance and up to twice the range of previous-generation technologies.&lt;/p&gt;\r\n&lt;!-- cpt_container_end --&gt;', 'Latest Intel mobile architecture Powered by the most advanced mobile processors from Intel, the new Core 2 Duo MacBook Pro is over 50% faster than the original Core.', 'mobile, intel, macbook, macbook pro'),
        (46, 1, 'Sony VAIO', '&lt;p&gt;Unprecedented power. The next generation of processing technology has arrived. Built into the newest VAIO notebooks lies Intel''s latest, most powerful innovation yet: Intel® Centrino® 2 processor technology. Boasting incredible speed, expanded wireless connectivity, enhanced multimedia support and greater energy efficiency, all the high-performance essentials are seamlessly combined into a single chip.&lt;/p&gt;\r\n', '', ''),
        (47, 1, 'HP LP3065', '&lt;p&gt;Stop your co-workers in their tracks with the stunning new 30-inch diagonal HP LP3065 Flat Panel Monitor. This flagship monitor features best-in-class performance and presentation features on a huge wide-aspect screen while letting you work as comfortably as possible - you might even forget you''re at the office&lt;/p&gt;\r\n', '', ''),
        (48, 1, 'iPod Classic', '&lt;p&gt;&lt;strong&gt;More room to move.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;With 80GB or 160GB of storage and up to 40 hours of battery life, the new iPod classic lets you enjoy up to 40,000 songs or up to 200 hours of video or any combination wherever you go.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Cover Flow.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Browse through your music collection by flipping through album art. Select an album to turn it over and see the track list.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Enhanced interface.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Experience a whole new way to browse and view your music and video.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Sleeker design.&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;Beautiful, durable, and sleeker than ever, iPod classic now features an anodized aluminum and polished stainless steel enclosure with rounded edges.&lt;/p&gt;\r\n&lt;!-- cpt_container_end --&gt;', '', ''),
        (49, 1, 'Samsung Galaxy Tab 10.1', '&lt;p&gt;Samsung Galaxy Tab 10.1, is the world’s thinnest tablet, measuring 8.6 mm thickness, running with Android 3.0 Honeycomb OS on a 1GHz dual-core Tegra 2 processor, similar to its younger brother Samsung Galaxy Tab 8.9.&lt;/p&gt;\r\n\r\n&lt;p&gt;Samsung Galaxy Tab 10.1 gives pure Android 3.0 experience, adding its new TouchWiz UX or TouchWiz 4.0 – includes a live panel, which lets you to customize with different content, such as your pictures, bookmarks, and social feeds, sporting a 10.1 inches WXGA capacitive touch screen with 1280 x 800 pixels of resolution, equipped with 3 megapixel rear camera with LED flash and a 2 megapixel front camera, HSPA+ connectivity up to 21Mbps, 720p HD video recording capability, 1080p HD playback, DLNA support, Bluetooth 2.1, USB 2.0, gyroscope, Wi-Fi 802.11 a/b/g/n, micro-SD slot, 3.5mm headphone jack, and SIM slot, including the Samsung Stick – a Bluetooth microphone that can be carried in a pocket like a pen and sound dock with powered subwoofer.&lt;/p&gt;\r\n\r\n&lt;p&gt;Samsung Galaxy Tab 10.1 will come in 16GB / 32GB / 64GB verities and pre-loaded with Social Hub, Reader’s Hub, Music Hub and Samsung Mini Apps Tray – which gives you access to more commonly used apps to help ease multitasking and it is capable of Adobe Flash Player 10.2, powered by 6860mAh battery that gives you 10hours of video-playback time.&amp;nbsp;äö&lt;/p&gt;\r\n', '', '')";

        $this->execute($sql);

        // product_discount
        $sql = "INSERT INTO `{$this->prefix}product_discount` VALUES
        (561, 42, 1, 10, 1, '88.0000', '0000-00-00', '0000-00-00'),
        (562, 42, 1, 20, 1, '77.0000', '0000-00-00', '0000-00-00'),
        (563, 42, 1, 30, 1, '66.0000', '0000-00-00', '0000-00-00')";

        $this->execute($sql);

        // product_image
        $sql = "INSERT INTO `{$this->prefix}product_image` VALUES
        (2428, 47, 'data/demo/hp_2.jpg', 0),
        (2429, 47, 'data/demo/hp_3.jpg', 0),
        (2434, 40, 'data/demo/iphone_2.jpg', 0),
        (2435, 40, 'data/demo/iphone_3.jpg', 0),
        (2436, 40, 'data/demo/iphone_4.jpg', 0),
        (2437, 40, 'data/demo/iphone_5.jpg', 0),
        (2438, 40, 'data/demo/iphone_6.jpg', 0),
        (2439, 48, 'data/demo/ipod_classic_2.jpg', 0),
        (2440, 48, 'data/demo/ipod_classic_3.jpg', 0),
        (2441, 48, 'data/demo/ipod_classic_4.jpg', 0),
        (2442, 36, 'data/demo/ipod_nano_2.jpg', 0),
        (2443, 36, 'data/demo/ipod_nano_3.jpg', 0),
        (2444, 36, 'data/demo/ipod_nano_4.jpg', 0),
        (2445, 36, 'data/demo/ipod_nano_5.jpg', 0),
        (2446, 34, 'data/demo/ipod_shuffle_2.jpg', 0),
        (2447, 34, 'data/demo/ipod_shuffle_3.jpg', 0),
        (2448, 34, 'data/demo/ipod_shuffle_4.jpg', 0),
        (2449, 34, 'data/demo/ipod_shuffle_5.jpg', 0),
        (2450, 32, 'data/demo/ipod_touch_2.jpg', 0),
        (2451, 32, 'data/demo/ipod_touch_3.jpg', 0),
        (2452, 32, 'data/demo/ipod_touch_4.jpg', 0),
        (2453, 32, 'data/demo/ipod_touch_5.jpg', 0),
        (2454, 32, 'data/demo/ipod_touch_6.jpg', 0),
        (2455, 32, 'data/demo/ipod_touch_7.jpg', 0),
        (2463, 31, 'data/demo/nikon_d300_2.jpg', 0),
        (2464, 31, 'data/demo/nikon_d300_3.jpg', 0),
        (2465, 31, 'data/demo/nikon_d300_4.jpg', 0),
        (2466, 31, 'data/demo/nikon_d300_5.jpg', 0),
        (2467, 29, 'data/demo/palm_treo_pro_2.jpg', 0),
        (2468, 29, 'data/demo/palm_treo_pro_3.jpg', 0),
        (2469, 49, 'data/demo/samsung_tab_2.jpg', 0),
        (2470, 49, 'data/demo/samsung_tab_3.jpg', 0),
        (2471, 49, 'data/demo/samsung_tab_4.jpg', 0),
        (2472, 49, 'data/demo/samsung_tab_5.jpg', 0),
        (2473, 49, 'data/demo/samsung_tab_6.jpg', 0),
        (2474, 49, 'data/demo/samsung_tab_7.jpg', 0),
        (2475, 46, 'data/demo/sony_vaio_2.jpg', 0),
        (2476, 46, 'data/demo/sony_vaio_3.jpg', 0),
        (2477, 46, 'data/demo/sony_vaio_4.jpg', 0),
        (2478, 46, 'data/demo/sony_vaio_5.jpg', 0),
        (2584, 28, 'data/demo/htc_touch_hd_2.jpg', 0),
        (2585, 28, 'data/demo/htc_touch_hd_3.jpg', 0),
        (2661, 30, 'data/demo/canon_eos_5d_2.jpg', 0),
        (2662, 30, 'data/demo/canon_eos_5d_3.jpg', 0),
        (2675, 43, 'data/demo/macbook_2.jpg', 0),
        (2676, 43, 'data/demo/macbook_3.jpg', 0),
        (2677, 43, 'data/demo/macbook_4.jpg', 0),
        (2678, 43, 'data/demo/macbook_5.jpg', 0),
        (2679, 44, 'data/demo/macbook_air_2.jpg', 0),
        (2680, 44, 'data/demo/macbook_air_3.jpg', 0),
        (2681, 44, 'data/demo/macbook_air_4.jpg', 0),
        (2684, 41, 'data/demo/imac_2.jpg', 0),
        (2685, 41, 'data/demo/imac_3.jpg', 0),
        (2686, 45, 'data/demo/macbook_pro_2.jpg', 0),
        (2687, 45, 'data/demo/macbook_pro_3.jpg', 0),
        (2688, 45, 'data/demo/macbook_pro_4.jpg', 0),
        (2689, 42, 'data/demo/canon_eos_5d_1.jpg', 0),
        (2690, 42, 'data/demo/canon_eos_5d_2.jpg', 0),
        (2691, 42, 'data/demo/canon_logo.jpg', 0),
        (2692, 42, 'data/demo/compaq_presario.jpg', 0),
        (2693, 42, 'data/demo/hp_1.jpg', 0)";

        $this->execute($sql);

        // product_option
        $sql = "INSERT INTO `{$this->prefix}product_option` VALUES
        (208, 42, 4, 'test', 1),
        (209, 42, 6, '', 1),
        (217, 42, 5, '', 1),
        (218, 42, 1, '', 1),
        (219, 42, 8, '2011-02-20', 1),
        (220, 42, 10, '2011-02-20 22:25', 1),
        (221, 42, 9, '22:25', 1),
        (222, 42, 7, '', 1),
        (223, 42, 2, '', 1),
        (225, 47, 12, '2011-04-22', 1),
        (226, 30, 5, '', 1)";

        $this->execute($sql);

        // product_option_value
        $sql = "INSERT INTO `{$this->prefix}product_option_value` VALUES
        (1, 217, 42, 5, 41, 100, 0, '1.0000', '+', 0, '+', '1.00000000', '+'),
        (2, 217, 42, 5, 42, 200, 1, '2.0000', '+', 0, '+', '2.00000000', '+'),
        (3, 217, 42, 5, 40, 300, 0, '3.0000', '+', 0, '+', '3.00000000', '+'),
        (4, 217, 42, 5, 39, 92, 1, '4.0000', '+', 0, '+', '4.00000000', '+'),
        (5, 218, 42, 1, 32, 96, 1, '10.0000', '+', 1, '+', '10.00000000', '+'),
        (6, 218, 42, 1, 31, 146, 1, '20.0000', '+', 2, '-', '20.00000000', '+'),
        (7, 218, 42, 1, 43, 300, 1, '30.0000', '+', 3, '+', '30.00000000', '+'),
        (8, 223, 42, 2, 23, 48, 1, '10.0000', '+', 0, '+', '10.00000000', '+'),
        (9, 223, 42, 2, 24, 194, 1, '20.0000', '+', 0, '+', '20.00000000', '+'),
        (10, 223, 42, 2, 44, 2696, 1, '30.0000', '+', 0, '+', '30.00000000', '+'),
        (11, 223, 42, 2, 45, 3998, 1, '40.0000', '+', 0, '+', '40.00000000', '+'),
        (15, 226, 30, 5, 39, 2, 1, '0.0000', '+', 0, '+', '0.00000000', '+'),
        (16, 226, 30, 5, 40, 5, 1, '0.0000', '+', 0, '+', '0.00000000', '+')";

        $this->execute($sql);

        // product_recurring
        $sql = "INSERT INTO `{$this->prefix}product_recurring` VALUES
        (41, 1, 1),
        (41, 1, 2),
        (41, 1, 3),
        (41, 1, 4)";

        $this->execute($sql);

        // product_related
        $sql = "INSERT INTO `{$this->prefix}product_related` VALUES
        (40, 42),
        (41, 42),
        (42, 40),
        (42, 41)";

        $this->execute($sql);

        // product_reward
        $sql = "INSERT INTO `{$this->prefix}product_reward` VALUES
        (568, 47, 1, 300),
        (571, 40, 1, 0),
        (572, 48, 1, 0),
        (573, 36, 1, 0),
        (574, 34, 1, 0),
        (575, 32, 1, 0),
        (578, 31, 1, 0),
        (579, 29, 1, 0),
        (580, 49, 1, 1000),
        (581, 33, 1, 0),
        (582, 46, 1, 0),
        (604, 28, 1, 400),
        (620, 30, 1, 200),
        (630, 43, 1, 600),
        (631, 43, 2, 0),
        (632, 43, 3, 0),
        (633, 43, 4, 0),
        (634, 44, 1, 700),
        (635, 44, 2, 0),
        (636, 44, 3, 0),
        (637, 44, 4, 0),
        (642, 41, 1, 0),
        (643, 41, 2, 0),
        (644, 41, 3, 0),
        (645, 41, 4, 0),
        (646, 45, 1, 800),
        (647, 45, 2, 0),
        (648, 45, 3, 0),
        (649, 45, 4, 0),
        (658, 50, 1, 0),
        (659, 50, 2, 0),
        (660, 50, 3, 0),
        (661, 50, 4, 0),
        (662, 42, 1, 100),
        (663, 42, 2, 0),
        (664, 42, 3, 0),
        (665, 42, 4, 0)";

        $this->execute($sql);

        // product_special
        $sql = "INSERT INTO `{$this->prefix}product_special` VALUES
        (483, 30, 1, 1, '80.0000', '0000-00-00', '0000-00-00'),
        (484, 30, 1, 2, '90.0000', '0000-00-00', '0000-00-00'),
        (486, 42, 1, 1, '90.0000', '0000-00-00', '0000-00-00')";

        $this->execute($sql);

        // product_to_category
        $sql = "INSERT INTO `{$this->prefix}product_to_category` VALUES
        (28, 24),
        (29, 24),
        (30, 33),
        (31, 33),
        (32, 34),
        (32, 38),
        (33, 25),
        (33, 28),
        (34, 34),
        (34, 49),
        (36, 34),
        (36, 43),
        (40, 24),
        (41, 20),
        (41, 27),
        (42, 25),
        (42, 28),
        (43, 18),
        (43, 46),
        (44, 18),
        (44, 46),
        (45, 18),
        (45, 46),
        (46, 18),
        (46, 45),
        (47, 18),
        (47, 45),
        (48, 34),
        (48, 52),
        (48, 58),
        (49, 57)";

        $this->execute($sql);

        // product_to_store
        $sql = "INSERT INTO `{$this->prefix}product_to_store` VALUES
        (28, 0),
        (29, 0),
        (30, 0),
        (31, 0),
        (32, 0),
        (33, 0),
        (34, 0),
        (36, 0),
        (40, 0),
        (41, 0),
        (42, 0),
        (43, 0),
        (44, 0),
        (45, 0),
        (46, 0),
        (47, 0),
        (48, 0),
        (49, 0)";

        $this->execute($sql);

        // route
        $sql = "INSERT INTO `{$this->prefix}route` VALUES
        (789, 'catalog/manufacturer/info', 'manufacturer_id:8', 'apple'),
        (790, 'catalog/manufacturer/info', 'manufacturer_id:9', 'canon'),
        (791, 'catalog/manufacturer/info', 'manufacturer_id:7', 'hewlett-packard'),
        (792, 'catalog/manufacturer/info', 'manufacturer_id:5', 'htc'),
        (793, 'catalog/manufacturer/info', 'manufacturer_id:6', 'palm'),
        (794, 'catalog/manufacturer/info', 'manufacturer_id:10', 'sony'),
        (819, 'catalog/category', 'category_id:25', 'components'),
        (820, 'catalog/category', 'category_id:29', 'mice-and-trackballs'),
        (821, 'catalog/category', 'category_id:28', 'monitors'),
        (822, 'catalog/category', 'category_id:35', 'test-1'),
        (823, 'catalog/category', 'category_id:36', 'test-2'),
        (825, 'catalog/category', 'category_id:57', 'tablets'),
        (826, 'catalog/category', 'category_id:17', 'software'),
        (827, 'catalog/category', 'category_id:24', 'phones-and-pdas'),
        (828, 'catalog/category', 'category_id:42', 'test-9'),
        (829, 'catalog/category', 'category_id:41', 'test-8'),
        (830, 'catalog/category', 'category_id:40', 'test-7'),
        (831, 'catalog/category', 'category_id:39', 'test-6'),
        (832, 'catalog/category', 'category_id:37', 'test-5'),
        (833, 'catalog/category', 'category_id:38', 'test-4'),
        (834, 'catalog/category', 'category_id:56', 'test-24'),
        (835, 'catalog/category', 'category_id:55', 'test-23'),
        (836, 'catalog/category', 'category_id:54', 'test-22'),
        (837, 'catalog/category', 'category_id:53', 'test-21'),
        (838, 'catalog/category', 'category_id:58', 'test-25'),
        (840, 'catalog/category', 'category_id:52', 'test-20'),
        (841, 'catalog/category', 'category_id:51', 'test-19'),
        (842, 'catalog/category', 'category_id:50', 'test-18'),
        (843, 'catalog/category', 'category_id:49', 'test-17'),
        (844, 'catalog/category', 'category_id:48', 'test-16'),
        (845, 'catalog/category', 'category_id:47', 'test-15'),
        (846, 'catalog/category', 'category_id:44', 'test-12'),
        (847, 'catalog/category', 'category_id:43', 'test-11'),
        (849, 'catalog/category', 'category_id:45', 'windows'),
        (852, 'catalog/category', 'category_id:26', 'pc'),
        (853, 'catalog/category', 'category_id:27', 'mac'),
        (855, 'catalog/category', 'category_id:32', 'web-cameras'),
        (856, 'catalog/category', 'category_id:31', 'scanners'),
        (857, 'catalog/category', 'category_id:30', 'printers'),
        (885, 'catalog/product', 'product_id:47', 'hp-lp3065'),
        (888, 'catalog/product', 'product_id:40', 'iphone'),
        (889, 'catalog/product', 'product_id:48', 'ipod-classic'),
        (890, 'catalog/product', 'product_id:36', 'ipod-nano'),
        (891, 'catalog/product', 'product_id:34', 'ipod-shuffle'),
        (892, 'catalog/product', 'product_id:32', 'ipod-touch'),
        (895, 'catalog/product', 'product_id:31', 'nikon-d300'),
        (896, 'catalog/product', 'product_id:29', 'palm-treo-pro'),
        (897, 'catalog/product', 'product_id:49', 'samsung-galaxy-tab-10-1'),
        (898, 'catalog/product', 'product_id:33', 'samsung-syncmaster-941bw'),
        (899, 'catalog/product', 'product_id:46', 'sony-vaio'),
        (924, 'catalog/product', 'product_id:28', 'htc-touch-hd'),
        (949, 'catalog/category', 'category_id:20', 'desktops'),
        (963, 'catalog/product', 'product_id:30', 'canon-eos-5d'),
        (968, 'catalog/category', 'category_id:33', 'cameras'),
        (971, 'catalog/product', 'product_id:43', 'macbook'),
        (972, 'catalog/product', 'product_id:44', 'macbook-air'),
        (974, 'catalog/product', 'product_id:41', 'imac'),
        (977, 'content/post', 'post_id:1', 'lorem-ipsum-test-post'),
        (982, 'content/category', 'blog_category_id:1', 'general'),
        (983, 'content/category', 'blog_category_id:2', 'latest-product-news'),
        (985, 'catalog/category', 'category_id:46', 'macs'),
        (986, 'catalog/product', 'product_id:45', 'macbook-pro'),
        (988, 'catalog/category', 'category_id:18', 'laptops-and-notebooks'),
        (998, 'catalog/category', 'category_id:59', 'live-events'),
        (1001, 'catalog/manufacturer/info', 'manufacturer_id:11', 'solution-labs'),
        (1010, 'catalog/category', 'category_id:34', 'mp3-players'),
        (1017, 'catalog/product', 'product_id:42', 'apple-cinema-30-inch')";

        $this->execute($sql);

        // tag
        $sql = "INSERT INTO `{$this->prefix}tag` VALUES
        (1, 'product', 43, 1, 'mac'),
        (2, 'product', 43, 1, 'macbook'),
        (3, 'product', 44, 1, 'mac'),
        (4, 'product', 44, 1, 'macbook'),
        (5, 'product', 44, 1, 'macbook air'),
        (17, 'post', 1, 1, 'lorem'),
        (18, 'post', 1, 1, 'ipsum'),
        (28, 'blog_category', 1, 1, 'general'),
        (29, 'blog_category', 2, 1, 'lorem'),
        (30, 'blog_category', 2, 1, 'ipsum'),
        (31, 'blog_category', 2, 1, 'latest product news'),
        (32, 'product_category', 46, 1, 'mac'),
        (33, 'product_category', 46, 1, 'imac'),
        (34, 'product_category', 46, 1, 'macbook'),
        (35, 'product_category', 46, 1, 'macbook pro'),
        (36, 'product_category', 46, 1, 'macbook air'),
        (37, 'product', 45, 1, 'mac'),
        (38, 'product', 45, 1, 'macbook'),
        (39, 'product', 45, 1, 'macbook pro'),
        (44, 'product_category', 18, 1, 'laptops'),
        (45, 'product_category', 18, 1, 'notebooks'),
        (46, 'product_category', 18, 1, 'windows'),
        (47, 'product_category', 18, 1, 'mac'),
        (48, 'product_category', 18, 1, 'apple'),
        (52, 'product_category', 0, 1, 'lorem'),
        (53, 'product_category', 0, 1, 'ipsum'),
        (54, 'product_category', 0, 1, 'lorem'),
        (55, 'product_category', 0, 1, 'ipsum'),
        (56, 'product_category', 59, 1, 'lorem'),
        (57, 'product_category', 59, 1, 'ipsum'),
        (75, 'product_category', 34, 1, ''),
        (78, 'product', 42, 1, '')";

        $this->execute($sql);
    }

    public function down() {
       $this->execute("TRUNCATE `{$this->prefix}attribute`");
       $this->execute("TRUNCATE `{$this->prefix}attribute_description`");
       $this->execute("TRUNCATE `{$this->prefix}attribute_group`");
       $this->execute("TRUNCATE `{$this->prefix}attribute_group_description`");
       $this->execute("TRUNCATE `{$this->prefix}banner`");
       $this->execute("TRUNCATE `{$this->prefix}banner_image`");
       $this->execute("TRUNCATE `{$this->prefix}banner_image_description`");
       $this->execute("TRUNCATE `{$this->prefix}blog_category`");
       $this->execute("TRUNCATE `{$this->prefix}blog_category_description`");
       $this->execute("TRUNCATE `{$this->prefix}blog_category_to_store`");
       $this->execute("TRUNCATE `{$this->prefix}blog_post`");
       $this->execute("TRUNCATE `{$this->prefix}blog_post_description`");
       $this->execute("TRUNCATE `{$this->prefix}blog_post_to_category`");
       $this->execute("TRUNCATE `{$this->prefix}blog_post_to_store`");
       $this->execute("TRUNCATE `{$this->prefix}category`");
       $this->execute("TRUNCATE `{$this->prefix}category_description`");
       $this->execute("TRUNCATE `{$this->prefix}category_path`");
       $this->execute("TRUNCATE `{$this->prefix}category_to_store`");
       $this->execute("TRUNCATE `{$this->prefix}coupon`");
       $this->execute("TRUNCATE `{$this->prefix}manufacturer`");
       $this->execute("TRUNCATE `{$this->prefix}manufacturer_to_store`");
       $this->execute("TRUNCATE `{$this->prefix}menu`");
       $this->execute("TRUNCATE `{$this->prefix}option`");
       $this->execute("TRUNCATE `{$this->prefix}option_description`");
       $this->execute("TRUNCATE `{$this->prefix}option_value`");
       $this->execute("TRUNCATE `{$this->prefix}option_value_description`");
       $this->execute("TRUNCATE `{$this->prefix}product`");
       $this->execute("TRUNCATE `{$this->prefix}product_attribute`");
       $this->execute("TRUNCATE `{$this->prefix}product_description`");
       $this->execute("TRUNCATE `{$this->prefix}product_discount`");
       $this->execute("TRUNCATE `{$this->prefix}product_image`");
       $this->execute("TRUNCATE `{$this->prefix}product_option`");
       $this->execute("TRUNCATE `{$this->prefix}product_option_value`");
       $this->execute("TRUNCATE `{$this->prefix}product_recurring`");
       $this->execute("TRUNCATE `{$this->prefix}product_related`");
       $this->execute("TRUNCATE `{$this->prefix}product_reward`");
       $this->execute("TRUNCATE `{$this->prefix}product_special`");
       $this->execute("TRUNCATE `{$this->prefix}product_to_category`");
       $this->execute("TRUNCATE `{$this->prefix}product_to_store`");
       $this->execute("TRUNCATE `{$this->prefix}route`");
       $this->execute("TRUNCATE `{$this->prefix}tag`");
    }
}
