-- --------------------------------------------------------

--
-- Table structure for table `dais_download`
--

DROP TABLE IF EXISTS `dais_download`;
CREATE TABLE IF NOT EXISTS `dais_download` (
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `mask` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `remaining` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
