-- --------------------------------------------------------

--
-- Table structure for table `dais_length_class_description`
--

DROP TABLE IF EXISTS `dais_length_class_description`;
CREATE TABLE IF NOT EXISTS `dais_length_class_description` (
  `length_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`length_class_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dais_length_class_description`
--

INSERT INTO `dais_length_class_description` (`length_class_id`, `language_id`, `title`, `unit`) VALUES
(1, 1, 'Centimeter', 'cm'),
(2, 1, 'Millimeter', 'mm'),
(3, 1, 'Inch', 'in');
