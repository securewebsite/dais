-- --------------------------------------------------------

--
-- Table structure for table `dais_product_recurring`
--

DROP TABLE IF EXISTS `dais_product_recurring`;
CREATE TABLE IF NOT EXISTS `dais_product_recurring` (
  `product_id` int(11) NOT NULL,
  `recurring_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`recurring_id`,`customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
