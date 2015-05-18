-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_notification`
--

DROP TABLE IF EXISTS `dais_customer_notification`;
CREATE TABLE IF NOT EXISTS `dais_customer_notification` (
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `settings` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
