-- --------------------------------------------------------

--
-- Table structure for table `dais_product_to_download`
--

DROP TABLE IF EXISTS `dais_product_to_download`;
CREATE TABLE IF NOT EXISTS `dais_product_to_download` (
  `product_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
