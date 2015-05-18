-- --------------------------------------------------------

--
-- Table structure for table `dais_order_download`
--

DROP TABLE IF EXISTS `dais_order_download`;
CREATE TABLE IF NOT EXISTS `dais_order_download` (
  `order_download_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `mask` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `remaining` int(3) NOT NULL,
  PRIMARY KEY (`order_download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
