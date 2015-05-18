-- --------------------------------------------------------

--
-- Table structure for table `dais_menu`
--

DROP TABLE IF EXISTS `dais_menu`;
CREATE TABLE IF NOT EXISTS `dais_menu` (
  `menu_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`menu_id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `dais_menu`
--

INSERT INTO `dais_menu` (`menu_id`, `name`, `type`, `items`, `status`) VALUES
(3, 'Blog Header Menu', 'content_category', 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}', 1),
(4, 'Blog Header Pages', 'page', 'a:6:{i:0;s:1:"4";i:1;s:1:"8";i:2;s:1:"6";i:3;s:1:"3";i:4;s:1:"7";i:5;s:1:"5";}', 1),
(5, 'Info', 'page', 'a:4:{i:0;s:1:"4";i:1;s:1:"6";i:2;s:1:"3";i:3;s:1:"5";}', 1),
(7, 'Customer Service', 'custom', 'a:3:{i:0;a:2:{s:4:"href";s:15:"content/contact";s:4:"name";s:10:"Contact Us";}i:1;a:2:{s:4:"href";s:22:"account/returns/insert";s:4:"name";s:7:"Returns";}i:2;a:2:{s:4:"href";s:15:"content/sitemap";s:4:"name";s:7:"Sitemap";}}', 1),
(8, 'Extras', 'custom', 'a:3:{i:0;a:2:{s:4:"href";s:20:"catalog/manufacturer";s:4:"name";s:6:"Brands";}i:1;a:2:{s:4:"href";s:16:"account/giftcard";s:4:"name";s:10:"Gift Cards";}i:3;a:2:{s:4:"href";s:15:"catalog/special";s:4:"name";s:8:"Specials";}}', 1),
(10, 'Posts', 'post', 'a:1:{i:0;s:1:"1";}', 1),
(13, 'Account', 'custom', 'a:4:{i:0;a:2:{s:4:"href";s:17:"account/dashboard";s:4:"name";s:9:"Dashboard";}i:1;a:2:{s:4:"href";s:13:"account/order";s:4:"name";s:13:"Order History";}i:2;a:2:{s:4:"href";s:16:"account/wishlist";s:4:"name";s:8:"Wishlist";}i:3;a:2:{s:4:"href";s:18:"account/newsletter";s:4:"name";s:10:"Newsletter";}}', 1),
(14, 'Blog Categories', 'content_category', 'a:2:{i:0;s:1:"1";i:1;s:1:"2";}', 1),
(15, 'Product Categories', 'product_category', 'a:37:{i:0;s:2:"33";i:1;s:2:"25";i:2;s:2:"29";i:3;s:2:"28";i:4;s:2:"35";i:5;s:2:"36";i:6;s:2:"30";i:7;s:2:"31";i:8;s:2:"32";i:9;s:2:"20";i:10;s:2:"27";i:11;s:2:"26";i:12;s:2:"18";i:13;s:2:"46";i:14;s:2:"45";i:15;s:2:"34";i:16;s:2:"43";i:17;s:2:"44";i:18;s:2:"47";i:19;s:2:"48";i:20;s:2:"49";i:21;s:2:"50";i:22;s:2:"51";i:23;s:2:"52";i:24;s:2:"58";i:25;s:2:"53";i:26;s:2:"54";i:27;s:2:"55";i:28;s:2:"56";i:29;s:2:"38";i:30;s:2:"37";i:31;s:2:"39";i:32;s:2:"40";i:33;s:2:"41";i:34;s:2:"42";i:35;s:2:"24";i:36;s:2:"57";}', 1),
(16, 'Our Friends', 'custom', 'a:4:{i:0;a:2:{s:4:"href";s:21:"http://www.google.com";s:4:"name";s:6:"Google";}i:1;a:2:{s:4:"href";s:23:"http://www.facebook.com";s:4:"name";s:8:"Facebook";}i:2;a:2:{s:4:"href";s:18:"http://twitter.com";s:4:"name";s:7:"Twitter";}i:3;a:2:{s:4:"href";s:20:"http://instagram.com";s:4:"name";s:9:"Instagram";}}', 1),
(17, 'Shop Header', 'product_category', 'a:37:{i:0;s:2:"33";i:1;s:2:"25";i:2;s:2:"29";i:3;s:2:"28";i:4;s:2:"35";i:5;s:2:"36";i:6;s:2:"30";i:7;s:2:"31";i:8;s:2:"32";i:9;s:2:"20";i:10;s:2:"27";i:11;s:2:"26";i:12;s:2:"18";i:13;s:2:"46";i:14;s:2:"45";i:15;s:2:"34";i:16;s:2:"43";i:17;s:2:"44";i:18;s:2:"47";i:19;s:2:"48";i:20;s:2:"49";i:21;s:2:"50";i:22;s:2:"51";i:23;s:2:"52";i:24;s:2:"58";i:25;s:2:"53";i:26;s:2:"54";i:27;s:2:"55";i:28;s:2:"56";i:29;s:2:"38";i:30;s:2:"37";i:31;s:2:"39";i:32;s:2:"40";i:33;s:2:"41";i:34;s:2:"42";i:35;s:2:"24";i:36;s:2:"57";}', 1);
