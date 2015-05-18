-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_history`
--

DROP TABLE IF EXISTS `dais_customer_history`;
CREATE TABLE IF NOT EXISTS `dais_customer_history` (
  `customer_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`customer_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
