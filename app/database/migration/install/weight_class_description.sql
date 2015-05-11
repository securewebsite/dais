-- --------------------------------------------------------

--
-- Table structure for table `dais_weight_class_description`
--

DROP TABLE IF EXISTS `dais_weight_class_description`;
CREATE TABLE IF NOT EXISTS `dais_weight_class_description` (
  `weight_class_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `unit` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`weight_class_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_weight_class_description`
--

INSERT INTO `dais_weight_class_description` (`weight_class_id`, `language_id`, `title`, `unit`) VALUES
(1, 1, 'Kilogram', 'kg'),
(2, 1, 'Gram', 'g'),
(5, 1, 'Pound ', 'lb'),
(6, 1, 'Ounce', 'oz');
