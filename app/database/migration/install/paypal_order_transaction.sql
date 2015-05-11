-- --------------------------------------------------------

--
-- Table structure for table `dais_paypal_order_transaction`
--

DROP TABLE IF EXISTS `dais_paypal_order_transaction`;
CREATE TABLE IF NOT EXISTS `dais_paypal_order_transaction` (
  `paypal_order_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `paypal_order_id` int(11) NOT NULL,
  `transaction_id` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `parent_transaction_id` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `msgsubid` char(38) COLLATE utf8_unicode_ci NOT NULL,
  `receipt_id` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `payment_type` enum('none','echeck','instant','refund','void') COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `pending_reason` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_entity` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `debug_data` text COLLATE utf8_unicode_ci NOT NULL,
  `call_data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`paypal_order_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
