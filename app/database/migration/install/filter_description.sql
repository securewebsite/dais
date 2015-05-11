-- --------------------------------------------------------

--
-- Table structure for table `dais_filter_description`
--

DROP TABLE IF EXISTS `dais_filter_description`;
CREATE TABLE IF NOT EXISTS `dais_filter_description` (
  `filter_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `filter_group_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`filter_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
