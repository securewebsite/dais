-- --------------------------------------------------------

--
-- Table structure for table `dais_blog_category`
--

DROP TABLE IF EXISTS `dais_blog_category`;
CREATE TABLE IF NOT EXISTS `dais_blog_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `top` tinyint(1) NOT NULL,
  `column` int(3) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `dais_blog_category`
--

INSERT INTO `dais_blog_category` (`category_id`, `image`, `parent_id`, `top`, `column`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, '', 0, 0, 0, 0, 1, '2014-08-20 04:58:59', '2014-08-24 15:59:01'),
(2, 'data/blog/category/landscape-a.jpg', 1, 0, 0, 0, 1, '2014-08-22 17:04:52', '2014-12-28 04:50:34');
