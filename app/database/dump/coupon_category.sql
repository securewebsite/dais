-- --------------------------------------------------------

--
-- Table structure for table `dais_coupon_category`
--

DROP TABLE IF EXISTS `dais_coupon_category`;
CREATE TABLE IF NOT EXISTS `dais_coupon_category` (
  `coupon_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`coupon_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
