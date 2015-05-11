-- --------------------------------------------------------

--
-- Table structure for table `dais_tax_rule`
--

DROP TABLE IF EXISTS `dais_tax_rule`;
CREATE TABLE IF NOT EXISTS `dais_tax_rule` (
  `tax_rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_class_id` int(11) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  `based` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tax_rule_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=131 ;

--
-- Dumping data for table `dais_tax_rule`
--

INSERT INTO `dais_tax_rule` (`tax_rule_id`, `tax_class_id`, `tax_rate_id`, `based`, `priority`) VALUES
(130, 9, 88, 'shipping', 1);
