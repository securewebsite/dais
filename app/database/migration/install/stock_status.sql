-- --------------------------------------------------------

--
-- Table structure for table `dais_stock_status`
--

DROP TABLE IF EXISTS `dais_stock_status`;
CREATE TABLE IF NOT EXISTS `dais_stock_status` (
  `stock_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`stock_status_id`,`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `dais_stock_status`
--

INSERT INTO `dais_stock_status` (`stock_status_id`, `language_id`, `name`) VALUES
(5, 1, 'Out Of Stock'),
(6, 1, '2 - 3 Days'),
(7, 1, 'In Stock'),
(8, 1, 'Pre-Order');
