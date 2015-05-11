-- --------------------------------------------------------

--
-- Table structure for table `dais_event_wait_list`
--

DROP TABLE IF EXISTS `dais_event_wait_list`;
CREATE TABLE IF NOT EXISTS `dais_event_wait_list` (
  `event_wait_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`event_wait_list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
