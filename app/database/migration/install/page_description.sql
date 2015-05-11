-- --------------------------------------------------------

--
-- Table structure for table `dais_page_description`
--

DROP TABLE IF EXISTS `dais_page_description`;
CREATE TABLE IF NOT EXISTS `dais_page_description` (
  `page_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`page_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_page_description`
--

INSERT INTO `dais_page_description` (`page_id`, `language_id`, `title`, `description`, `meta_description`, `meta_keywords`) VALUES
(3, 1, 'Privacy Policy', '&lt;p&gt;Privacy Policy&lt;/p&gt;\r\n', '', ''),
(4, 1, 'About Us', '&lt;p&gt;\r\n  \r\n    About Us\r\n  \r\n&lt;/p&gt;', '', ''),
(5, 1, 'Terms &amp; Conditions', '&lt;p&gt;Terms &amp;amp; Conditions&lt;/p&gt;\r\n', '', ''),
(6, 1, 'Delivery Information', '&lt;p&gt;Delivery Information&lt;/p&gt;\r\n', '', ''),
(7, 1, 'Return Policy', '&lt;p&gt;Your return policy here.&lt;/p&gt;\r\n', '', ''),
(8, 1, 'Affiliate Terms', '&lt;p&gt;Affiliate terms go here.&lt;/p&gt;\r\n', '', '');
