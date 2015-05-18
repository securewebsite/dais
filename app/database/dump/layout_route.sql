-- --------------------------------------------------------

--
-- Table structure for table `dais_layout_route`
--

DROP TABLE IF EXISTS `dais_layout_route`;
CREATE TABLE IF NOT EXISTS `dais_layout_route` (
  `layout_route_id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `route` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `dais_layout_route`
--

INSERT INTO `dais_layout_route` (`layout_route_id`, `layout_id`, `store_id`, `route`) VALUES
(1, 2, 0, 'shop/home'),
(2, 13, 0, 'error/notfound'),
(3, 6, 0, 'account/'),
(5, 7, 0, 'checkout/'),
(6, 8, 0, 'content/contact'),
(7, 15, 0, 'content/category'),
(8, 14, 0, 'content/home'),
(9, 11, 0, 'content/page'),
(10, 16, 0, 'content/post'),
(11, 17, 0, 'content/search'),
(12, 4, 0, 'catalog/category'),
(13, 5, 0, 'catalog/manufacturer'),
(14, 3, 0, 'catalog/product'),
(15, 12, 0, 'catalog/search'),
(16, 9, 0, 'content/sitemap'),
(17, 18, 0, 'account/register'),
(18, 19, 0, 'content/calendar');
