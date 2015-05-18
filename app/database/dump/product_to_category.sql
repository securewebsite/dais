-- --------------------------------------------------------

--
-- Table structure for table `dais_product_to_category`
--

DROP TABLE IF EXISTS `dais_product_to_category`;
CREATE TABLE IF NOT EXISTS `dais_product_to_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_product_to_category`
--

INSERT INTO `dais_product_to_category` (`product_id`, `category_id`) VALUES
(28, 24),
(29, 24),
(30, 33),
(31, 33),
(32, 34),
(32, 38),
(33, 25),
(33, 28),
(34, 34),
(34, 49),
(36, 34),
(36, 43),
(40, 24),
(41, 20),
(41, 27),
(42, 25),
(42, 28),
(43, 18),
(43, 46),
(44, 18),
(44, 46),
(45, 18),
(45, 46),
(46, 18),
(46, 45),
(47, 18),
(47, 45),
(48, 34),
(48, 52),
(48, 58),
(49, 57);
