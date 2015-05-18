-- --------------------------------------------------------

--
-- Table structure for table `dais_product_option`
--

DROP TABLE IF EXISTS `dais_product_option`;
CREATE TABLE IF NOT EXISTS `dais_product_option` (
  `product_option_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value` text COLLATE utf8_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=227 ;

--
-- Dumping data for table `dais_product_option`
--

INSERT INTO `dais_product_option` (`product_option_id`, `product_id`, `option_id`, `option_value`, `required`) VALUES
(208, 42, 4, 'test', 1),
(209, 42, 6, '', 1),
(217, 42, 5, '', 1),
(218, 42, 1, '', 1),
(219, 42, 8, '2011-02-20', 1),
(220, 42, 10, '2011-02-20 22:25', 1),
(221, 42, 9, '22:25', 1),
(222, 42, 7, '', 1),
(223, 42, 2, '', 1),
(225, 47, 12, '2011-04-22', 1),
(226, 30, 5, '', 1);
