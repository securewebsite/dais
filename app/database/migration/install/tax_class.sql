-- --------------------------------------------------------

--
-- Table structure for table `dais_tax_class`
--

DROP TABLE IF EXISTS `dais_tax_class`;
CREATE TABLE IF NOT EXISTS `dais_tax_class` (
  `tax_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tax_class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `dais_tax_class`
--

INSERT INTO `dais_tax_class` (`tax_class_id`, `title`, `description`, `date_added`, `date_modified`) VALUES
(9, 'Taxable Goods', 'products requiring sales tax', '2009-01-06 23:21:53', '2015-03-25 17:54:51'),
(10, 'Downloadable Products', 'Downloadable', '2011-09-21 22:19:39', '2014-06-28 00:33:19');
