-- --------------------------------------------------------

--
-- Table structure for table `dais_banner_image_description`
--

DROP TABLE IF EXISTS `dais_banner_image_description`;
CREATE TABLE IF NOT EXISTS `dais_banner_image_description` (
  `banner_image_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`banner_image_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_banner_image_description`
--

INSERT INTO `dais_banner_image_description` (`banner_image_id`, `language_id`, `banner_id`, `title`) VALUES
(84, 1, 6, 'HP Banner'),
(85, 1, 8, 'Sony'),
(86, 1, 8, 'Palm'),
(87, 1, 8, 'Apple'),
(88, 1, 8, 'Canon'),
(89, 1, 8, 'HTC'),
(90, 1, 8, 'Hewlett-Packard'),
(91, 1, 7, 'Samsung Tab 10.1'),
(92, 1, 9, 'Hatch Premium Fly Reels'),
(93, 1, 9, 'Yeti Containers'),
(94, 1, 9, 'Louisiana Salt Water Series');
