-- --------------------------------------------------------

--
-- Table structure for table `dais_giftcard_theme_description`
--

DROP TABLE IF EXISTS `dais_giftcard_theme_description`;
CREATE TABLE IF NOT EXISTS `dais_giftcard_theme_description` (
  `giftcard_theme_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`giftcard_theme_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_giftcard_theme_description`
--

INSERT INTO `dais_giftcard_theme_description` (`giftcard_theme_id`, `language_id`, `name`) VALUES
(7, 1, 'Happy Birthday'),
(8, 1, 'Gift Card');
