-- --------------------------------------------------------

--
-- Table structure for table `dais_blog_post_to_store`
--

DROP TABLE IF EXISTS `dais_blog_post_to_store`;
CREATE TABLE IF NOT EXISTS `dais_blog_post_to_store` (
  `post_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_blog_post_to_store`
--

INSERT INTO `dais_blog_post_to_store` (`post_id`, `store_id`) VALUES
(1, 0);
