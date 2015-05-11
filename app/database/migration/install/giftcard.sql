-- --------------------------------------------------------

--
-- Table structure for table `dais_giftcard`
--

DROP TABLE IF EXISTS `dais_giftcard`;
CREATE TABLE IF NOT EXISTS `dais_giftcard` (
  `giftcard_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `from_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `from_email` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `to_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `to_email` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `giftcard_theme_id` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`giftcard_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;
