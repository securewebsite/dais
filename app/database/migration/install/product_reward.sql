-- --------------------------------------------------------

--
-- Table structure for table `dais_product_reward`
--

DROP TABLE IF EXISTS `dais_product_reward`;
CREATE TABLE IF NOT EXISTS `dais_product_reward` (
  `product_reward_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `points` int(8) NOT NULL,
  PRIMARY KEY (`product_reward_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=638 ;

--
-- Dumping data for table `dais_product_reward`
--

INSERT INTO `dais_product_reward` (`product_reward_id`, `product_id`, `customer_group_id`, `points`) VALUES
(568, 47, 1, 300),
(570, 41, 1, 0),
(571, 40, 1, 0),
(572, 48, 1, 0),
(573, 36, 1, 0),
(574, 34, 1, 0),
(575, 32, 1, 0),
(578, 31, 1, 0),
(579, 29, 1, 0),
(580, 49, 1, 1000),
(581, 33, 1, 0),
(582, 46, 1, 0),
(604, 28, 1, 400),
(620, 30, 1, 200),
(621, 42, 1, 100),
(622, 45, 1, 800),
(623, 45, 2, 0),
(624, 45, 3, 0),
(625, 45, 4, 0),
(630, 43, 1, 600),
(631, 43, 2, 0),
(632, 43, 3, 0),
(633, 43, 4, 0),
(634, 44, 1, 700),
(635, 44, 2, 0),
(636, 44, 3, 0),
(637, 44, 4, 0);
