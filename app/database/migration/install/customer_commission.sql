-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_commission`
--

DROP TABLE IF EXISTS `dais_customer_commission`;
CREATE TABLE IF NOT EXISTS `dais_customer_commission` (
  `customer_commission_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`customer_commission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;
