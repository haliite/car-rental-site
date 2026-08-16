CREATE DATABASE assignment2;
use assignment2;

-- ----------------------------
-- order table structure
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `user_email` varchar(60) DEFAULT NULL,
  `user_phone` int(10) unsigned DEFAULT NULL,
  `rent_start_date` DATE,
  `rent_end_date` DATE,
  `price` float(15) unsigned DEFAULT NULL,
  `status` BOOLEAN
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
