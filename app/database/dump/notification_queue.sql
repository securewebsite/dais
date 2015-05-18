-- --------------------------------------------------------

--
-- Table structure for table `dais_notification_queue`
--

DROP TABLE IF EXISTS `dais_notification_queue`;
CREATE TABLE IF NOT EXISTS `dais_notification_queue` (
  `queue_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(66) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`queue_id`,`email`,`sent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;
