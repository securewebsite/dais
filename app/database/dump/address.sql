-- --------------------------------------------------------

--
-- Table structure for table `dais_address`
--

DROP TABLE IF EXISTS `dais_address`;
CREATE TABLE IF NOT EXISTS `dais_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `tax_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `address_2` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `postcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
