-- --------------------------------------------------------

--
-- Table structure for table `dais_product_related`
--

DROP TABLE IF EXISTS `dais_product_related`;
CREATE TABLE IF NOT EXISTS `dais_product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_product_related`
--

INSERT INTO `dais_product_related` (`product_id`, `related_id`) VALUES
(40, 42),
(41, 42),
(42, 40),
(42, 41);
