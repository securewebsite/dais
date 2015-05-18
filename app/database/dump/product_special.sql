-- --------------------------------------------------------

--
-- Table structure for table `dais_product_special`
--

DROP TABLE IF EXISTS `dais_product_special`;
CREATE TABLE IF NOT EXISTS `dais_product_special` (
  `product_special_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_special_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=486 ;

--
-- Dumping data for table `dais_product_special`
--

INSERT INTO `dais_product_special` (`product_special_id`, `product_id`, `customer_group_id`, `priority`, `price`, `date_start`, `date_end`) VALUES
(483, 30, 1, 1, '80.0000', '0000-00-00', '0000-00-00'),
(484, 30, 1, 2, '90.0000', '0000-00-00', '0000-00-00'),
(485, 42, 1, 1, '90.0000', '0000-00-00', '0000-00-00');
