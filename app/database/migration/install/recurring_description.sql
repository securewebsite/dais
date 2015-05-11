-- --------------------------------------------------------

--
-- Table structure for table `dais_recurring_description`
--

DROP TABLE IF EXISTS `dais_recurring_description`;
CREATE TABLE IF NOT EXISTS `dais_recurring_description` (
  `recurring_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`recurring_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
