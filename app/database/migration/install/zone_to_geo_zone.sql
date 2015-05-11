-- --------------------------------------------------------

--
-- Table structure for table `dais_zone_to_geo_zone`
--

DROP TABLE IF EXISTS `dais_zone_to_geo_zone`;
CREATE TABLE IF NOT EXISTS `dais_zone_to_geo_zone` (
  `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `geo_zone_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`zone_to_geo_zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=68 ;

--
-- Dumping data for table `dais_zone_to_geo_zone`
--

INSERT INTO `dais_zone_to_geo_zone` (`zone_to_geo_zone_id`, `country_id`, `zone_id`, `geo_zone_id`, `date_added`, `date_modified`) VALUES
(66, 223, 3616, 5, '2014-06-28 00:35:35', '0000-00-00 00:00:00'),
(67, 223, 3616, 6, '2014-06-28 00:36:10', '0000-00-00 00:00:00');
