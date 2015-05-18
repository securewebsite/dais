-- --------------------------------------------------------

--
-- Table structure for table `dais_product`
--

DROP TABLE IF EXISTS `dais_product`;
CREATE TABLE IF NOT EXISTS `dais_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `model` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `sku` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `upc` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `ean` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `jan` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `isbn` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `mpn` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `visibility` int(3) NOT NULL DEFAULT '1',
  `quantity` int(4) NOT NULL,
  `stock_status_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `shipping` tinyint(1) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `points` int(8) NOT NULL,
  `tax_class_id` int(11) NOT NULL,
  `date_available` date NOT NULL,
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `weight` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `weight_class_id` int(11) NOT NULL,
  `length` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `width` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `height` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `length_class_id` int(11) NOT NULL,
  `subtract` tinyint(1) NOT NULL DEFAULT '1',
  `minimum` int(11) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `viewed` int(5) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

--
-- Dumping data for table `dais_product`
--

INSERT INTO `dais_product` (`product_id`, `event_id`, `model`, `sku`, `upc`, `ean`, `jan`, `isbn`, `mpn`, `location`, `visibility`, `quantity`, `stock_status_id`, `image`, `manufacturer_id`, `shipping`, `price`, `points`, `tax_class_id`, `date_available`, `end_date`, `weight`, `weight_class_id`, `length`, `width`, `height`, `length_class_id`, `subtract`, `minimum`, `sort_order`, `status`, `date_added`, `date_modified`, `viewed`, `customer_id`) VALUES
(28, 0, 'Product 1', '', '', '', '', '', '', '', 1, 939, 7, 'data/demo/htc_touch_hd_1.jpg', 5, 1, '100.0000', 200, 9, '2009-02-03', '0000-00-00 00:00:00', '146.40000000', 2, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 16:06:50', '2014-08-17 00:05:03', 0, 0),
(29, 0, 'Product 2', '', '', '', '', '', '', '', 1, 999, 6, 'data/demo/palm_treo_pro_1.jpg', 6, 1, '279.9900', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '133.00000000', 2, '0.00000000', '0.00000000', '0.00000000', 3, 1, 1, 0, 1, '2009-02-03 16:42:17', '2014-07-06 22:42:53', 0, 0),
(30, 0, 'Product 3', '', '', '', '', '', '', '', 1, 7, 6, 'data/demo/canon_eos_5d_1.jpg', 9, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 16:59:00', '2014-09-28 23:59:28', 0, 0),
(31, 0, 'Product 4', '', '', '', '', '', '', '', 1, 1000, 6, 'data/demo/nikon_d300_1.jpg', 0, 1, '80.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 3, 1, 1, 0, 1, '2009-02-03 17:00:10', '2014-07-06 22:42:45', 0, 0),
(32, 0, 'Product 5', '', '', '', '', '', '', '', 1, 999, 6, 'data/demo/ipod_touch_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 17:07:26', '2014-07-06 22:41:48', 0, 0),
(33, 0, 'Product 6', '', '', '', '', '', '', '', 1, 1000, 6, 'data/demo/samsung_syncmaster_941bw.jpg', 0, 1, '200.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 17:08:31', '2014-07-06 22:43:42', 1, 0),
(34, 0, 'Product 7', '', '', '', '', '', '', '', 1, 1000, 6, 'data/demo/ipod_shuffle_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 18:07:54', '2014-07-06 22:41:19', 0, 0),
(36, 0, 'Product 9', '', '', '', '', '', '', '', 1, 994, 6, 'data/demo/ipod_nano_1.jpg', 8, 0, '100.0000', 100, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 18:09:19', '2014-07-06 22:41:02', 0, 0),
(40, 0, 'product 11', '', '', '', '', '', '', '', 1, 970, 5, 'data/demo/iphone_1.jpg', 8, 1, '101.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '10.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 21:07:12', '2014-07-06 22:39:10', 15, 0),
(41, 0, 'Product 14', '', '', '', '', '', '', '', 1, 977, 5, 'data/demo/imac_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '5.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 0, 1, '2009-02-03 21:07:26', '2014-07-06 22:33:49', 3, 0),
(42, 0, 'Product 15', '', '', '', '', '', '', '', 1, 990, 5, 'data/demo/apple_cinema_30.jpg', 8, 1, '100.0000', 400, 9, '2009-02-04', '0000-00-00 00:00:00', '12.50000000', 1, '1.00000000', '2.00000000', '3.00000000', 1, 1, 2, 0, 1, '2009-02-03 21:07:37', '2014-09-29 00:02:18', 7, 0),
(43, 0, 'Product 16', '', '', '', '', '', '', '', 1, 929, 5, 'data/demo/macbook_1.jpg', 8, 0, '500.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:07:49', '2015-02-13 22:38:54', 0, 0),
(44, 0, 'Product 17', '', '', '', '', '', '', '', 1, 1000, 5, 'data/demo/macbook_air_1.jpg', 8, 1, '1000.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:08:00', '2015-02-13 22:39:07', 2, 0),
(45, 0, 'Product 18', '', '', '', '', '', '', '', 1, 998, 5, 'data/demo/macbook_pro_1.jpg', 8, 1, '2000.0000', 0, 0, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:08:17', '2015-02-13 22:38:17', 6, 0),
(46, 0, 'Product 19', '', '', '', '', '', '', '', 1, 1000, 5, 'data/demo/sony_vaio_1.jpg', 10, 1, '1000.0000', 0, 9, '2009-02-03', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-03 21:08:29', '2014-07-06 22:43:58', 0, 0),
(47, 0, 'Product 21', '', '', '', '', '', '', '', 1, 1000, 5, 'data/demo/hp_1.jpg', 7, 1, '100.0000', 400, 9, '2009-02-03', '0000-00-00 00:00:00', '1.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 0, 1, 0, 1, '2009-02-03 21:08:40', '2014-07-06 22:30:26', 7, 0),
(48, 0, 'product 20', 'test 1', '', '', '', '', '', 'test 2', 1, 995, 5, 'data/demo/ipod_classic_1.jpg', 8, 1, '100.0000', 0, 9, '2009-02-08', '0000-00-00 00:00:00', '1.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 2, 1, 1, 0, 1, '2009-02-08 17:21:51', '2014-07-06 22:40:44', 0, 0),
(49, 0, 'SAM1', '', '', '', '', '', '', '', 1, 0, 8, 'data/demo/samsung_tab_1.jpg', 0, 1, '199.9900', 0, 9, '2011-04-25', '0000-00-00 00:00:00', '0.00000000', 1, '0.00000000', '0.00000000', '0.00000000', 1, 1, 1, 1, 1, '2011-04-26 08:57:34', '2014-07-06 22:43:27', 0, 0);
