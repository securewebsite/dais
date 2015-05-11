-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_group`
--

DROP TABLE IF EXISTS `dais_customer_group`;
CREATE TABLE IF NOT EXISTS `dais_customer_group` (
  `customer_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `approval` int(1) NOT NULL,
  `company_id_display` int(1) NOT NULL,
  `company_id_required` int(1) NOT NULL,
  `tax_id_display` int(1) NOT NULL,
  `tax_id_required` int(1) NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`customer_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `dais_customer_group`
--

INSERT INTO `dais_customer_group` (`customer_group_id`, `approval`, `company_id_display`, `company_id_required`, `tax_id_display`, `tax_id_required`, `sort_order`) VALUES
(1, 0, 0, 0, 0, 0, 1),
(2, 0, 0, 0, 0, 0, 2),
(3, 0, 0, 0, 0, 0, 3),
(4, 0, 0, 0, 0, 0, 4);
