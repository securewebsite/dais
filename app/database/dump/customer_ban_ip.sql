-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_ban_ip`
--

DROP TABLE IF EXISTS `dais_customer_ban_ip`;
CREATE TABLE IF NOT EXISTS `dais_customer_ban_ip` (
  `customer_ban_ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_ban_ip_id`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
