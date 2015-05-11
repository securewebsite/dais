-- --------------------------------------------------------

--
-- Table structure for table `dais_blog_post_image`
--

DROP TABLE IF EXISTS `dais_blog_post_image`;
CREATE TABLE IF NOT EXISTS `dais_blog_post_image` (
  `post_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`post_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
