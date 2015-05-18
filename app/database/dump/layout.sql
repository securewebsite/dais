-- --------------------------------------------------------

--
-- Table structure for table `dais_layout`
--

DROP TABLE IF EXISTS `dais_layout`;
CREATE TABLE IF NOT EXISTS `dais_layout` (
  `layout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `dais_layout`
--

INSERT INTO `dais_layout` (`layout_id`, `name`) VALUES
(1, 'Default'),
(2, 'Shop Home'),
(3, 'Shop Product'),
(4, 'Shop Category'),
(5, 'Shop Manufacturer'),
(6, 'Account'),
(7, 'Checkout'),
(8, 'Contact'),
(9, 'Sitemap'),
(11, 'Content Page'),
(12, 'Shop Search'),
(13, 'Error 404'),
(14, 'Content Home'),
(15, 'Content Category'),
(16, 'Content Post'),
(17, 'Content Search'),
(18, 'Register'),
(19, 'Calendar');
