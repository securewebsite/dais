-- --------------------------------------------------------

--
-- Table structure for table `dais_page`
--

DROP TABLE IF EXISTS `dais_page`;
CREATE TABLE IF NOT EXISTS `dais_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `bottom` int(1) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `visibility` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `dais_page`
--

INSERT INTO `dais_page` (`page_id`, `bottom`, `sort_order`, `status`, `visibility`) VALUES
(3, 1, 3, 1, 1),
(4, 1, 1, 1, 1),
(5, 1, 4, 1, 1),
(6, 1, 2, 1, 1),
(7, 0, 0, 1, 1),
(8, 0, 0, 1, 1);
