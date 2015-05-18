-- --------------------------------------------------------

--
-- Table structure for table `dais_email`
--

DROP TABLE IF EXISTS `dais_email`;
CREATE TABLE IF NOT EXISTS `dais_email` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_slug` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `configurable` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) NOT NULL DEFAULT '2',
  `config_description` text COLLATE utf8_unicode_ci NOT NULL,
  `recipient` tinyint(1) NOT NULL DEFAULT '1',
  `is_system` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `dais_email`
--

INSERT INTO `dais_email` (`email_id`, `email_slug`, `configurable`, `priority`, `config_description`, `recipient`, `is_system`) VALUES
(1, 'admin_forgotten_email', 0, 1, '', 2, 1),
(2, 'admin_people_contact', 1, 2, 'Customer Newsletter', 1, 1),
(3, 'admin_event_add', 1, 2, 'Administrator Adds You to an Event', 1, 1),
(4, 'admin_event_waitlist', 1, 2, 'Administrator Adds You to an Event Waitlist ', 1, 1),
(5, 'admin_affiliate_add_commission', 1, 2, 'Administrator Adds a Commission to Your Affiliate Account', 1, 1),
(7, 'admin_customer_approve', 0, 2, '', 1, 1),
(8, 'admin_customer_add_credit', 1, 2, 'Administrator Adds a Store Credit to Your Customer Account', 1, 1),
(9, 'admin_customer_add_reward', 1, 2, 'Administrator Adds Reward Points to Your Customer Account', 1, 1),
(10, 'admin_order_add_history', 1, 2, 'Administrator Updates Your Active Orders', 1, 1),
(11, 'admin_return_add_history', 1, 2, 'Administrator Updates Your Active Returns', 1, 1),
(12, 'admin_giftcard_send', 0, 1, '', 1, 1),
(14, 'public_waitlist_join', 1, 2, 'You Join an Event Waitlist', 1, 1),
(15, 'public_customer_order_confirm', 1, 2, 'You Place an Order', 1, 1),
(16, 'public_admin_order_confirm', 0, 2, '', 2, 1),
(18, 'public_customer_forgotten', 0, 1, '', 1, 1),
(20, 'public_contact_admin', 0, 2, '', 2, 1),
(21, 'public_contact_customer', 0, 1, '', 1, 1),
(22, 'public_register_customer', 0, 2, '', 1, 1),
(23, 'public_register_admin', 0, 2, '', 2, 1),
(26, 'public_giftcard_confirm', 0, 1, '', 1, 1),
(27, 'email_wrapper', 0, 2, '', 1, 1),
(28, 'email_wrapper', 0, 1, '', 1, 1);
