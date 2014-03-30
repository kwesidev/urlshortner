DROP TABLE IF EXISTS `url_short`;
CREATE TABLE `url_short` (
  `code` varchar(50)  NOT NULL ,
  `longurl` longtext CHARACTER SET utf8 NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`code`),
  UNIQUE KEY (`code`) USING HASH
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
