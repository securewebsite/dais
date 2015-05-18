-- --------------------------------------------------------

--
-- Table structure for table `dais_store`
--

DROP TABLE IF EXISTS `dais_store`;
CREATE TABLE IF NOT EXISTS `dais_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ssl` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
