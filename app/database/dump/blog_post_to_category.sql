-- --------------------------------------------------------

--
-- Table structure for table `dais_blog_post_to_category`
--

DROP TABLE IF EXISTS `dais_blog_post_to_category`;
CREATE TABLE IF NOT EXISTS `dais_blog_post_to_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_blog_post_to_category`
--

INSERT INTO `dais_blog_post_to_category` (`post_id`, `category_id`) VALUES
(1, 1),
(1, 2);
