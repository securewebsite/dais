-- --------------------------------------------------------

--
-- Table structure for table `dais_filter_group`
--

DROP TABLE IF EXISTS `dais_filter_group`;
CREATE TABLE IF NOT EXISTS `dais_filter_group` (
  `filter_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`filter_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
