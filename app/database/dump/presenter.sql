-- --------------------------------------------------------

--
-- Table structure for table `dais_presenter`
--

DROP TABLE IF EXISTS `dais_presenter`;
CREATE TABLE IF NOT EXISTS `dais_presenter` (
  `presenter_id` int(11) NOT NULL AUTO_INCREMENT,
  `presenter_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facebook` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `twitter` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `bio` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`presenter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
