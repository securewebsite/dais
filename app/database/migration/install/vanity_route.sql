-- --------------------------------------------------------

--
-- Table structure for table `dais_vanity_route`
--

DROP TABLE IF EXISTS `dais_vanity_route`;
CREATE TABLE IF NOT EXISTS `dais_vanity_route` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`route_id`,`route`,`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
