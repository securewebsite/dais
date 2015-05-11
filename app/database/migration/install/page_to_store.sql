-- --------------------------------------------------------

--
-- Table structure for table `dais_page_to_store`
--

DROP TABLE IF EXISTS `dais_page_to_store`;
CREATE TABLE IF NOT EXISTS `dais_page_to_store` (
  `page_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dais_page_to_store`
--

INSERT INTO `dais_page_to_store` (`page_id`, `store_id`) VALUES
(3, 0),
(4, 0),
(5, 0),
(6, 0),
(7, 0),
(8, 0);
