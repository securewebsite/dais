-- --------------------------------------------------------

--
-- Table structure for table `dais_filter`
--

DROP TABLE IF EXISTS `dais_filter`;
CREATE TABLE IF NOT EXISTS `dais_filter` (
  `filter_id` int(11) NOT NULL AUTO_INCREMENT,
  `filter_group_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
