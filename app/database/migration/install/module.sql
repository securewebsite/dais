-- --------------------------------------------------------

--
-- Table structure for table `dais_module`
--

DROP TABLE IF EXISTS `dais_module`;
CREATE TABLE IF NOT EXISTS `dais_module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=535 ;

--
-- Dumping data for table `dais_module`
--

INSERT INTO `dais_module` (`module_id`, `type`, `code`) VALUES
(22, 'total', 'shipping'),
(58, 'total', 'tax'),
(59, 'total', 'total'),
(387, 'shipping', 'flat'),
(390, 'total', 'credit'),
(393, 'total', 'reward'),
(398, 'total', 'giftcard'),
(408, 'widget', 'account'),
(410, 'widget', 'banner'),
(413, 'widget', 'category'),
(419, 'widget', 'slideshow'),
(426, 'widget', 'carousel'),
(427, 'widget', 'featured'),
(429, 'widget', 'masonry'),
(430, 'widget', 'page'),
(436, 'total', 'subtotal'),
(438, 'total', 'coupon'),
(522, 'widget', 'postwall'),
(523, 'widget', 'blogsearch'),
(524, 'widget', 'blogcategory'),
(525, 'widget', 'blogfeatured'),
(526, 'widget', 'bloghottopics'),
(527, 'widget', 'bloglatest'),
(528, 'widget', 'sidebarmenu'),
(529, 'widget', 'headermenu'),
(530, 'widget', 'footerblocks'),
(531, 'plugin', 'git'),
(532, 'payment', 'paypalexpress'),
(533, 'total', 'handling'),
(534, 'total', 'loworderfee');
