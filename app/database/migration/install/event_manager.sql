-- --------------------------------------------------------

--
-- Table structure for table `dais_event_manager`
--

DROP TABLE IF EXISTS `dais_event_manager`;
CREATE TABLE IF NOT EXISTS `dais_event_manager` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sku` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `visibility` int(3) NOT NULL DEFAULT '1',
  `event_length` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `event_days` text COLLATE utf8_unicode_ci NOT NULL,
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `link` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `seats` int(11) NOT NULL DEFAULT '0',
  `filled` int(11) NOT NULL DEFAULT '0',
  `presenter_tab` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roster` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `presenter_id` int(11) NOT NULL DEFAULT '0',
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `refundable` tinyint(1) NOT NULL DEFAULT '0',
  `date_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `product_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 
