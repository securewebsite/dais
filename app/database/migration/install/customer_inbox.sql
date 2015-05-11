-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_inbox`
--

DROP TABLE IF EXISTS `dais_customer_inbox`;
CREATE TABLE IF NOT EXISTS `dais_customer_inbox` (
  `notification_id` int(13) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `subject` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`notification_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
