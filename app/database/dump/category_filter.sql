-- --------------------------------------------------------

--
-- Table structure for table `dais_category_filter`
--

DROP TABLE IF EXISTS `dais_category_filter`;
CREATE TABLE IF NOT EXISTS `dais_category_filter` (
  `category_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
