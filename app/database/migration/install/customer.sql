-- --------------------------------------------------------

--
-- Table structure for table `dais_customer`
--

DROP TABLE IF EXISTS `dais_customer`;
CREATE TABLE IF NOT EXISTS `dais_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(96) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `reset` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cart` text COLLATE utf8_unicode_ci,
  `wishlist` text COLLATE utf8_unicode_ci,
  `newsletter` tinyint(1) NOT NULL,
  `address_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `referral_id` int(11) NOT NULL DEFAULT '0',
  `is_affiliate` tinyint(4) NOT NULL DEFAULT '0',
  `affiliate_status` tinyint(1) NOT NULL,
  `company` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `commission` decimal(4,2) NOT NULL DEFAULT '0.00',
  `tax_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `cheque` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `paypal` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bank_branch_number` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bank_swift_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account_number` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customer_id`,`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
