-- --------------------------------------------------------

--
-- Table structure for table `dais_hook`
--

DROP TABLE IF EXISTS `dais_hook`;
CREATE TABLE IF NOT EXISTS `dais_hook` (
  `hook_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `hook` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `handlers` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`hook_id`,`hook`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;
