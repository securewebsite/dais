-- --------------------------------------------------------

--
-- Table structure for table `dais_category_description`
--

DROP TABLE IF EXISTS `dais_category_description`;
CREATE TABLE IF NOT EXISTS `dais_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_category_description`
--

INSERT INTO `dais_category_description` (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword`) VALUES
(17, 1, 'Software', '', '', ''),
(18, 1, 'Laptops &amp; Notebooks', '&lt;p&gt;Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse, Shop Laptop has the most comprehensive selection of laptops on the internet. At Shop Laptop, we pride ourselves on offering customers the very best laptop deals. From refurbished laptops to netbooks, Shop Laptop ensures that every laptop - in every colour, style, size and technical spec - is featured on the site at the lowest possible price.&lt;/p&gt;\r\n', '', ''),
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
(46, 1, 'Macs', '', '', ''),
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
(58, 1, 'test 25', '', '', '');
