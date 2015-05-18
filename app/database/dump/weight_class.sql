-- --------------------------------------------------------

--
-- Table structure for table `dais_weight_class`
--

DROP TABLE IF EXISTS `dais_weight_class`;
CREATE TABLE IF NOT EXISTS `dais_weight_class` (
  `weight_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  PRIMARY KEY (`weight_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `dais_weight_class`
--

INSERT INTO `dais_weight_class` (`weight_class_id`, `value`) VALUES
(1, '1.00000000'),
(2, '1000.00000000'),
(5, '2.20460000'),
(6, '35.27400000');
