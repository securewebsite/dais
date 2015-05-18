-- --------------------------------------------------------

--
-- Table structure for table `dais_product_filter`
--

DROP TABLE IF EXISTS `dais_product_filter`;
CREATE TABLE IF NOT EXISTS `dais_product_filter` (
  `product_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
