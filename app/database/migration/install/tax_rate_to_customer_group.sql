-- --------------------------------------------------------

--
-- Table structure for table `dais_tax_rate_to_customer_group`
--

DROP TABLE IF EXISTS `dais_tax_rate_to_customer_group`;
CREATE TABLE IF NOT EXISTS `dais_tax_rate_to_customer_group` (
  `tax_rate_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  PRIMARY KEY (`tax_rate_id`,`customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_tax_rate_to_customer_group`
--

INSERT INTO `dais_tax_rate_to_customer_group` (`tax_rate_id`, `customer_group_id`) VALUES
(88, 1),
(88, 2),
(88, 3),
(88, 4);
