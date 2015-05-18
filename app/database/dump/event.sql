-- --------------------------------------------------------

--
-- Table structure for table `dais_event`
--

DROP TABLE IF EXISTS `dais_event`;
CREATE TABLE IF NOT EXISTS `dais_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `event` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `handlers` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`event_id`,`event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;
