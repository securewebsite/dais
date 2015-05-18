-- --------------------------------------------------------

--
-- Table structure for table `dais_giftcard_history`
--

DROP TABLE IF EXISTS `dais_giftcard_history`;
CREATE TABLE IF NOT EXISTS `dais_giftcard_history` (
  `giftcard_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `giftcard_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`giftcard_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
