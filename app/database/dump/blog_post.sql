-- --------------------------------------------------------

--
-- Table structure for table `dais_blog_post`
--

DROP TABLE IF EXISTS `dais_blog_post`;
CREATE TABLE IF NOT EXISTS `dais_blog_post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `visibility` tinyint(3) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `viewed` int(5) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dais_blog_post`
--

INSERT INTO `dais_blog_post` (`post_id`, `image`, `author_id`, `date_available`, `sort_order`, `status`, `visibility`, `date_added`, `date_modified`, `viewed`) VALUES
(1, 'data/blog/post/landscape-b.jpg', 1, '2014-08-19', 1, 1, 1, '2014-08-20 06:34:50', '2014-12-28 04:51:04', 228);
