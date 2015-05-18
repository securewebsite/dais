-- --------------------------------------------------------

--
-- Table structure for table `dais_paypal_order`
--

DROP TABLE IF EXISTS `dais_paypal_order`;
CREATE TABLE IF NOT EXISTS `dais_paypal_order` (
  `paypal_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `capture_status` enum('Complete','NotComplete') COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_code` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `authorization_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`paypal_order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
