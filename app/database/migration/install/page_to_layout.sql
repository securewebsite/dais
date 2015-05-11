-- --------------------------------------------------------

--
-- Table structure for table `dais_page_to_layout`
--

DROP TABLE IF EXISTS `dais_page_to_layout`;
CREATE TABLE IF NOT EXISTS `dais_page_to_layout` (
  `page_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  PRIMARY KEY (`page_id`,`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
