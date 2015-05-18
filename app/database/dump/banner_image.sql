-- --------------------------------------------------------

--
-- Table structure for table `dais_banner_image`
--

DROP TABLE IF EXISTS `dais_banner_image`;
CREATE TABLE IF NOT EXISTS `dais_banner_image` (
  `banner_image_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`banner_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=95 ;

--
-- Dumping data for table `dais_banner_image`
--

INSERT INTO `dais_banner_image` (`banner_image_id`, `banner_id`, `link`, `image`) VALUES
(84, 6, 'hewlett-packard', 'data/demo/hp_banner.jpg'),
(85, 8, 'sony', 'data/demo/sony_logo.jpg'),
(86, 8, 'palm', 'data/demo/palm_logo.jpg'),
(87, 8, 'apple', 'data/demo/apple_logo.jpg'),
(88, 8, 'canon', 'data/demo/canon_logo.jpg'),
(89, 8, 'htc', 'data/demo/htc_logo.jpg'),
(90, 8, 'hewlett-packard', 'data/demo/hp_logo.jpg'),
(91, 7, 'tablets', 'data/demo/samsung_banner.jpg'),
(92, 9, 'apple', 'data/banner/1.jpg'),
(93, 9, 'samsung', 'data/banner/2.jpg'),
(94, 9, 'hewlett-packard', 'data/banner/3.jpg');
