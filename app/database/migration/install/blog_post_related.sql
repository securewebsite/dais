-- --------------------------------------------------------

--
-- Table structure for table `dais_blog_post_related`
--

DROP TABLE IF EXISTS `dais_blog_post_related`;
CREATE TABLE IF NOT EXISTS `dais_blog_post_related` (
  `post_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
