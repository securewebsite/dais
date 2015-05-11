-- --------------------------------------------------------

--
-- Table structure for table `dais_giftcard_theme`
--

DROP TABLE IF EXISTS `dais_giftcard_theme`;
CREATE TABLE IF NOT EXISTS `dais_giftcard_theme` (
  `giftcard_theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`giftcard_theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `dais_giftcard_theme`
--

INSERT INTO `dais_giftcard_theme` (`giftcard_theme_id`, `image`) VALUES
(7, 'data/giftcard/gift-card-birthday.jpg'),
(8, 'data/giftcard/gift-card-general.jpg');
