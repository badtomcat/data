CREATE DATABASE /*!32312 IF NOT EXISTS*/`tpv3` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `tpv3`;

/*Table structure for table `game` */

DROP TABLE IF EXISTS `game`;

CREATE TABLE `game` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_name` varchar(250) DEFAULT NULL COMMENT '游戏名称',
  `introduce` varchar(800) DEFAULT NULL COMMENT '描述',
  `order_index` int(11) DEFAULT NULL COMMENT '展示的顺序',
  `cover` varchar(250) DEFAULT NULL COMMENT '封面图片',
  `creator` int(11) DEFAULT NULL COMMENT '创建的人',
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT '1' COMMENT '1，正常；0，删除',
  PRIMARY KEY (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `game` */

insert  into `game`(`game_id`,`game_name`,`introduce`,`order_index`,`cover`,`creator`,`create_time`,`status`) values
(1,'wow','we ax dd',8,NULL,3,'2017-11-18 23:47:40',1),
(2,'balabala','balabal game ',8,NULL,3,'2017-11-22 09:59:29',1);
