-- --------------------------------------------------------

--
-- Table structure for table `dais_length_class`
--

DROP TABLE IF EXISTS `dais_length_class`;
CREATE TABLE IF NOT EXISTS `dais_length_class` (
  `length_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL,
  PRIMARY KEY (`length_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dais_length_class`
--

INSERT INTO `dais_length_class` (`length_class_id`, `value`) VALUES
(1, '1.00000000'),
(2, '10.00000000'),
(3, '0.39370000');
