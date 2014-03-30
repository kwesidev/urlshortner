DROP TABLE IF EXISTS `url_short`;
CREATE TABLE `url_short` (
  `code` text NOT NULL,
  `longurl` longtext NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`code`(100))
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
