-- --------------------------------------------------------

--
-- Table structure for table `dais_currency`
--

DROP TABLE IF EXISTS `dais_currency`;
CREATE TABLE IF NOT EXISTS `dais_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_left` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `symbol_right` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `decimal_place` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `value` float(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dais_currency`
--

INSERT INTO `dais_currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_place`, `value`, `status`, `date_modified`) VALUES
(1, 'Pound Sterling', 'GBP', '£', '', '2', 0.67979997, 1, '2015-04-09 20:10:25'),
(2, 'US Dollar', 'USD', '$', '', '2', 1.00000000, 1, '2015-04-09 20:33:29'),
(3, 'Euro', 'EUR', '', '€', '2', 0.93730003, 1, '2015-04-09 20:10:25');
