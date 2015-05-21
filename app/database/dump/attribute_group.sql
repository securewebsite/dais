-- --------------------------------------------------------

--
-- Table structure for table `dais_attribute_group`
--

DROP TABLE IF EXISTS `dais_attribute_group`;
CREATE TABLE IF NOT EXISTS `dais_attribute_group` (
  `attribute_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`attribute_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `dais_attribute_group`
--

INSERT INTO `dais_attribute_group` (`attribute_group_id`, `sort_order`) VALUES
(3, 2),
(4, 1),
(5, 3),
(6, 4);
