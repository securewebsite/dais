-- --------------------------------------------------------

--
-- Table structure for table `dais_category_to_layout`
--

DROP TABLE IF EXISTS `dais_category_to_layout`;
CREATE TABLE IF NOT EXISTS `dais_category_to_layout` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
