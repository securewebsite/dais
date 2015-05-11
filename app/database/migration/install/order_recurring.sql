-- --------------------------------------------------------

--
-- Table structure for table `dais_order_recurring`
--

DROP TABLE IF EXISTS `dais_order_recurring`;
CREATE TABLE IF NOT EXISTS `dais_order_recurring` (
  `order_recurring_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `recurring_id` int(11) NOT NULL,
  `recurring_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recurring_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recurring_frequency` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `recurring_cycle` smallint(6) NOT NULL,
  `recurring_duration` smallint(6) NOT NULL,
  `recurring_price` decimal(10,4) NOT NULL,
  `trial` tinyint(1) NOT NULL,
  `trial_frequency` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `trial_cycle` smallint(6) NOT NULL,
  `trial_duration` smallint(6) NOT NULL,
  `trial_price` decimal(10,4) NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`order_recurring_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
