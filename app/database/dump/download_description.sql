-- --------------------------------------------------------

--
-- Table structure for table `dais_download_description`
--

DROP TABLE IF EXISTS `dais_download_description`;
CREATE TABLE IF NOT EXISTS `dais_download_description` (
  `download_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`download_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
