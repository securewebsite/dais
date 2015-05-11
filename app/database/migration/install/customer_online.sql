-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_online`
--

DROP TABLE IF EXISTS `dais_customer_online`;
CREATE TABLE IF NOT EXISTS `dais_customer_online` (
  `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `referer` text COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
