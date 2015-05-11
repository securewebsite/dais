-- --------------------------------------------------------

--
-- Table structure for table `dais_banner`
--

DROP TABLE IF EXISTS `dais_banner`;
CREATE TABLE IF NOT EXISTS `dais_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `dais_banner`
--

INSERT INTO `dais_banner` (`banner_id`, `name`, `status`) VALUES
(6, 'HP Products', 1),
(7, 'Samsung Tab', 1),
(8, 'Manufacturers', 1),
(9, 'Homepage', 1);
