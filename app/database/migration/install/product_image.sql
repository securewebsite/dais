-- --------------------------------------------------------

--
-- Table structure for table `dais_product_image`
--

DROP TABLE IF EXISTS `dais_product_image`;
CREATE TABLE IF NOT EXISTS `dais_product_image` (
  `product_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`product_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2682 ;

--
-- Dumping data for table `dais_product_image`
--

INSERT INTO `dais_product_image` (`product_image_id`, `product_id`, `image`, `sort_order`) VALUES
(2428, 47, 'data/demo/hp_2.jpg', 0),
(2429, 47, 'data/demo/hp_3.jpg', 0),
(2432, 41, 'data/demo/imac_2.jpg', 0),
(2433, 41, 'data/demo/imac_3.jpg', 0),
(2434, 40, 'data/demo/iphone_2.jpg', 0),
(2435, 40, 'data/demo/iphone_3.jpg', 0),
(2436, 40, 'data/demo/iphone_4.jpg', 0),
(2437, 40, 'data/demo/iphone_5.jpg', 0),
(2438, 40, 'data/demo/iphone_6.jpg', 0),
(2439, 48, 'data/demo/ipod_classic_2.jpg', 0),
(2440, 48, 'data/demo/ipod_classic_3.jpg', 0),
(2441, 48, 'data/demo/ipod_classic_4.jpg', 0),
(2442, 36, 'data/demo/ipod_nano_2.jpg', 0),
(2443, 36, 'data/demo/ipod_nano_3.jpg', 0),
(2444, 36, 'data/demo/ipod_nano_4.jpg', 0),
(2445, 36, 'data/demo/ipod_nano_5.jpg', 0),
(2446, 34, 'data/demo/ipod_shuffle_2.jpg', 0),
(2447, 34, 'data/demo/ipod_shuffle_3.jpg', 0),
(2448, 34, 'data/demo/ipod_shuffle_4.jpg', 0),
(2449, 34, 'data/demo/ipod_shuffle_5.jpg', 0),
(2450, 32, 'data/demo/ipod_touch_2.jpg', 0),
(2451, 32, 'data/demo/ipod_touch_3.jpg', 0),
(2452, 32, 'data/demo/ipod_touch_4.jpg', 0),
(2453, 32, 'data/demo/ipod_touch_5.jpg', 0),
(2454, 32, 'data/demo/ipod_touch_6.jpg', 0),
(2455, 32, 'data/demo/ipod_touch_7.jpg', 0),
(2463, 31, 'data/demo/nikon_d300_2.jpg', 0),
(2464, 31, 'data/demo/nikon_d300_3.jpg', 0),
(2465, 31, 'data/demo/nikon_d300_4.jpg', 0),
(2466, 31, 'data/demo/nikon_d300_5.jpg', 0),
(2467, 29, 'data/demo/palm_treo_pro_2.jpg', 0),
(2468, 29, 'data/demo/palm_treo_pro_3.jpg', 0),
(2469, 49, 'data/demo/samsung_tab_2.jpg', 0),
(2470, 49, 'data/demo/samsung_tab_3.jpg', 0),
(2471, 49, 'data/demo/samsung_tab_4.jpg', 0),
(2472, 49, 'data/demo/samsung_tab_5.jpg', 0),
(2473, 49, 'data/demo/samsung_tab_6.jpg', 0),
(2474, 49, 'data/demo/samsung_tab_7.jpg', 0),
(2475, 46, 'data/demo/sony_vaio_2.jpg', 0),
(2476, 46, 'data/demo/sony_vaio_3.jpg', 0),
(2477, 46, 'data/demo/sony_vaio_4.jpg', 0),
(2478, 46, 'data/demo/sony_vaio_5.jpg', 0),
(2584, 28, 'data/demo/htc_touch_hd_2.jpg', 0),
(2585, 28, 'data/demo/htc_touch_hd_3.jpg', 0),
(2661, 30, 'data/demo/canon_eos_5d_2.jpg', 0),
(2662, 30, 'data/demo/canon_eos_5d_3.jpg', 0),
(2663, 42, 'data/demo/canon_eos_5d_1.jpg', 0),
(2664, 42, 'data/demo/canon_eos_5d_2.jpg', 0),
(2665, 42, 'data/demo/canon_logo.jpg', 0),
(2666, 42, 'data/demo/compaq_presario.jpg', 0),
(2667, 42, 'data/demo/hp_1.jpg', 0),
(2668, 45, 'data/demo/macbook_pro_2.jpg', 0),
(2669, 45, 'data/demo/macbook_pro_3.jpg', 0),
(2670, 45, 'data/demo/macbook_pro_4.jpg', 0),
(2675, 43, 'data/demo/macbook_2.jpg', 0),
(2676, 43, 'data/demo/macbook_3.jpg', 0),
(2677, 43, 'data/demo/macbook_4.jpg', 0),
(2678, 43, 'data/demo/macbook_5.jpg', 0),
(2679, 44, 'data/demo/macbook_air_2.jpg', 0),
(2680, 44, 'data/demo/macbook_air_3.jpg', 0),
(2681, 44, 'data/demo/macbook_air_4.jpg', 0);
