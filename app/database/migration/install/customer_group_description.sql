-- --------------------------------------------------------

--
-- Table structure for table `dais_customer_group_description`
--

DROP TABLE IF EXISTS `dais_customer_group_description`;
CREATE TABLE IF NOT EXISTS `dais_customer_group_description` (
  `customer_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`customer_group_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_customer_group_description`
--

INSERT INTO `dais_customer_group_description` (`customer_group_id`, `language_id`, `name`, `description`) VALUES
(1, 1, 'Guest', 'This is the default group for any site visitor that isn''t logged in.'),
(2, 1, 'Customer', 'This is the default free customer group for any customer that simply has an account.'),
(3, 1, 'Silver', 'This is an example 1st tier paid membership group. Always ensure that the customer_group_id''s of your memberships are in ascending order otherwise the visibility and content settings will not work correctly.  This can be safely deleted if not needed.'),
(4, 1, 'Gold', 'This is an example 2nd tier paid membership group. Always ensure that the customer_group_id''s of your memberships are in ascending order otherwise the visibility and content settings will not work correctly.  This can be safely deleted if not needed.');
