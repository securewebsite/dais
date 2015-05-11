-- --------------------------------------------------------

--
-- Table structure for table `dais_product_to_layout`
--

DROP TABLE IF EXISTS `dais_product_to_layout`;
CREATE TABLE IF NOT EXISTS `dais_product_to_layout` (
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
