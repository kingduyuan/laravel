/*
Navicat MySQL Data Transfer

Source Server         : 我的数据库
Source Server Version : 50636
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50636
File Encoding         : 65001

Date: 2017-11-12 20:55:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一ID',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员名称',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员邮箱',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员头像',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '管理员密码',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '记住登陆密码',
  `status` tinyint(2) NOT NULL DEFAULT '10' COMMENT '管理员状态【10 启用 0 停用 -1 删除】',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', 'admin@qq.com', '', '$2y$13$Nuf1mzDRoCMxrWI.rIjENu20QshJG41smdEeHFHxq0qdmS99YytHy', '6O6Ea6vCFPOsJu5hn0kWQGGNr7JLx5vfZQUz12eNvdns23MkGFQugMnQZeDy', '10', '2017-11-12 20:07:25', '2017-11-12 20:07:25');
INSERT INTO `admins` VALUES ('3', 'liujinxing', 'liujinxing@qq.com', '', '$2y$10$YZwd5EHbgVPtBMx52NFgoebMQ.bmfeRlECKkd.6iAvFCAUNJyZ4fe', 'aAJWX8ulJ1Z9YLjoYnlgdhJILuwRIauHYPkSO9MBfIDpNFUYy658JzQ6LRUn', '10', '2017-11-12 20:18:26', '2017-11-12 20:18:26');

-- ----------------------------
-- Table structure for calendars
-- ----------------------------
DROP TABLE IF EXISTS `calendars`;
CREATE TABLE `calendars` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '事件标题',
  `desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '事件描述',
  `status` smallint(2) NOT NULL DEFAULT '0' COMMENT '状态[0 - 待处理 1 - 已委派 2 - 完成 3 延期]',
  `time_status` smallint(2) NOT NULL DEFAULT '0' COMMENT '事件状态[0 - 延缓 1 - 正常 2 - 紧急]',
  `start` timestamp NULL DEFAULT NULL COMMENT '开始时间',
  `end` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '结束时间',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '委派管理员',
  `style` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '使用样式',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `created_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建用户',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
  `updated_id` int(11) NOT NULL DEFAULT '0' COMMENT '修改用户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='日程记录信息表';

-- ----------------------------
-- Records of calendars
-- ----------------------------
INSERT INTO `calendars` VALUES ('1', '测试数据01', '测试数据01', '3', '1', '2017-10-31 00:00:00', '2017-11-01 00:00:00', '1', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 09:13:47', '1', '2017-11-05 09:16:13', '1');
INSERT INTO `calendars` VALUES ('2', '广告列表900', '广告列表900', '1', '1', '2017-11-02 00:00:00', '2017-11-03 00:00:00', '1', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 09:17:21', '1', '2017-11-05 09:18:02', '1');
INSERT INTO `calendars` VALUES ('3', 'Sebastian Schowalter', '55400NLYCVXJAKRQMDZEGISFHOTBUWP', '2', '1', '2017-11-05 06:57:10', '2017-11-30 06:57:10', '9699', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 12:57:10', '1', '2017-11-05 12:57:10', '1');
INSERT INTO `calendars` VALUES ('4', 'Mrs. Roslyn Ondricka', '54084MUKHWCNTRQVFXBGAILZEYJSPDO', '1', '4', '2017-11-06 11:57:10', '2017-11-25 11:57:10', '1675', '{\"backgroundColor\":\"rgb(119, 119, 119)\",\"borderColor\":\"rgb(119, 119, 119)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('5', 'Etha Fay', '29370HWQPRKULIBZFNOMVAXDSTCYGJE', '2', '1', '2017-11-04 20:57:10', '2017-11-05 20:57:10', '2549', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('6', 'Lilla O\'Hara', '43921YLBHNXTSRWCMQEZDOKVAIGPFJU', '5', '3', '2017-11-05 17:57:10', '2017-12-03 17:57:10', '253', '{\"backgroundColor\":\"rgb(96, 92, 168)\",\"borderColor\":\"rgb(96, 92, 168)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('7', 'Mr. Monserrat Ullrich IV', '55801WMTONARSYBLGQHKVCZUJEPFIDX', '5', '2', '2017-11-05 17:57:10', '2017-11-21 17:57:10', '7307', '{\"backgroundColor\":\"rgb(119, 119, 119)\",\"borderColor\":\"rgb(119, 119, 119)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('8', 'Abelardo Cole', '24858OBEXGYPIAHQVTLUCFKZDWJSRNM', '3', '5', '2017-11-06 11:57:10', '2017-11-12 11:57:10', '6859', '{\"backgroundColor\":\"rgb(57, 204, 204)\",\"borderColor\":\"rgb(57, 204, 204)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('9', 'Paul Jacobs', '69482MWJPTXFQSVDHZREKICOBGYLUAN', '3', '4', '2017-11-06 01:57:10', '2017-11-26 01:57:10', '855', '{\"backgroundColor\":\"rgb(72, 176, 247)\",\"borderColor\":\"rgb(72, 176, 247)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('10', 'Kali Johns', '73146AZHTICOLWDSMUNKGFJEXYQVBRP', '5', '4', '2017-11-05 18:57:10', '2017-11-12 18:57:10', '1336', '{\"backgroundColor\":\"rgb(96, 92, 168)\",\"borderColor\":\"rgb(96, 92, 168)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('11', 'Prof. Dante Littel', '66061VQKCHDPYBIOFLEZSRNJTAMUGXW', '2', '3', '2017-11-05 17:57:10', '2017-11-11 17:57:10', '6171', '{\"backgroundColor\":\"rgb(57, 204, 204)\",\"borderColor\":\"rgb(57, 204, 204)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('12', 'Walton Little', '14322BOIUALFSWCVZYMKHGNJPRETXDQ', '3', '2', '2017-11-04 15:57:10', '2017-11-30 15:57:10', '9563', '{\"backgroundColor\":\"rgb(72, 176, 247)\",\"borderColor\":\"rgb(72, 176, 247)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('13', 'Hyman Huel Sr.', '67026HJBVNGMQRLFZWOKPAYTDXIEUSC', '5', '4', '2017-11-05 14:57:10', '2017-11-23 14:57:10', '9568', '{\"backgroundColor\":\"rgb(57, 204, 204)\",\"borderColor\":\"rgb(57, 204, 204)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('14', 'Mrs. Rita Hudson DVM', '59164NOHZCIRADVQSTLWUXKPEFYMGBJ', '4', '4', '2017-11-05 02:57:10', '2017-12-05 02:57:10', '6780', '{\"backgroundColor\":\"rgb(0, 31, 63)\",\"borderColor\":\"rgb(0, 31, 63)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('15', 'Dr. Oran Koelpin', '34745MPVRYBZIXNEWAGCKFLDTQHOJSU', '4', '5', '2017-11-05 05:57:10', '2017-12-05 05:57:10', '6992', '{\"backgroundColor\":\"rgb(119, 119, 119)\",\"borderColor\":\"rgb(119, 119, 119)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('16', 'Clifford Kautzer DVM', '57651WDYLUQMPGFNOCJAKXSHZEIBVTR', '4', '2', '2017-11-05 21:57:10', '2017-12-06 21:57:10', '1085', '{\"backgroundColor\":\"rgb(16, 207, 189)\",\"borderColor\":\"rgb(16, 207, 189)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('17', 'Brennan Shields', '81118ATNQLROSPBHUDIXJKMZYGFWVEC', '3', '2', '2017-11-06 03:57:10', '2017-11-12 03:57:10', '1443', '{\"backgroundColor\":\"rgb(16, 207, 189)\",\"borderColor\":\"rgb(16, 207, 189)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('18', 'Torrey Nader', '82776GSWJUCQHRYIMXODNPLTEKZVFBA', '3', '4', '2017-11-05 20:57:10', '2017-11-13 20:57:10', '3702', '{\"backgroundColor\":\"rgb(16, 207, 189)\",\"borderColor\":\"rgb(16, 207, 189)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('19', 'Prof. Garry Luettgen', '94410XRIYDMHFJKSLAEWGUPQZTNBVOC', '2', '5', '2017-11-05 16:57:10', '2017-11-19 16:57:10', '1297', '{\"backgroundColor\":\"rgb(72, 176, 247)\",\"borderColor\":\"rgb(72, 176, 247)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('20', 'Maybelle Hettinger', '12761DHJTRZIYMPXOUAVSWFGLEKQCNB', '3', '5', '2017-11-05 16:57:10', '2017-12-06 16:57:10', '5519', '{\"backgroundColor\":\"rgb(245, 87, 83)\",\"borderColor\":\"rgb(245, 87, 83)\"}', '2017-11-05 12:57:11', '1', '2017-11-05 12:57:11', '1');
INSERT INTO `calendars` VALUES ('21', 'Dr. Herminia Kling Jr.', '78802JSNARUXWCIKFVMLBQYOHEGZDTP', '2', '1', '2017-11-05 08:57:10', '2017-11-27 08:57:10', '3074', '{\"backgroundColor\":\"rgb(243, 156, 18)\",\"borderColor\":\"rgb(243, 156, 18)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('22', 'Mr. Burley Mante', '72275EUDLBAJTIVGOCSMYRHPKWQNZXF', '0', '3', '2017-11-06 09:57:10', '2017-11-17 09:57:10', '2655', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('23', 'Noemie Pollich', '90138YVUKRLPHMDOBCSENWQTXZGJAIF', '4', '4', '2017-11-06 00:57:10', '2017-11-16 00:57:10', '8714', '{\"backgroundColor\":\"rgb(243, 156, 18)\",\"borderColor\":\"rgb(243, 156, 18)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('24', 'Kurtis Luettgen', '19176FCXJBERUVHGAMDOQTSKZIWLNYP', '2', '1', '2017-11-04 17:57:10', '2017-11-24 17:57:10', '6042', '{\"backgroundColor\":\"rgb(0, 31, 63)\",\"borderColor\":\"rgb(0, 31, 63)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('25', 'Cortney Reichel', '43133TUXIQCBEGVFMHSJKRLZYADWOPN', '2', '3', '2017-11-05 20:57:10', '2017-12-06 20:57:10', '8775', '{\"backgroundColor\":\"rgb(1, 255, 112)\",\"borderColor\":\"rgb(1, 255, 112)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('26', 'Hank Treutel', '71679BGFVWYAOTEUKLZPSRIDHJMQXNC', '2', '1', '2017-11-04 19:57:10', '2017-11-26 19:57:10', '9660', '{\"backgroundColor\":\"rgb(72, 176, 247)\",\"borderColor\":\"rgb(72, 176, 247)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('27', 'Ms. Adrianna Aufderhar Jr.', '75371ACRZDPFUMNJQTGSHKXYOVILEWB', '1', '1', '2017-11-04 23:57:10', '2017-11-27 23:57:10', '9578', '{\"backgroundColor\":\"rgb(0, 31, 63)\",\"borderColor\":\"rgb(0, 31, 63)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('28', 'Andres Trantow', '63792XBMNSTVCREGUJKFZOIYHPWQLDA', '4', '3', '2017-11-05 00:57:10', '2017-11-29 00:57:10', '5894', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('29', 'Corene Mosciski', '43886HOATDVXBCIUFNGWPRSEKLYJMZQ', '0', '2', '2017-11-04 19:57:10', '2017-11-16 19:57:10', '5254', '{\"backgroundColor\":\"rgb(72, 176, 247)\",\"borderColor\":\"rgb(72, 176, 247)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('30', 'Terrence Cummerata', '84532WXURSIDZKLTYJPVEOHFMCABNGQ', '1', '3', '2017-11-04 22:57:10', '2017-11-27 22:57:10', '6303', '{\"backgroundColor\":\"rgb(1, 255, 112)\",\"borderColor\":\"rgb(1, 255, 112)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('31', 'Florian Mayer', '61793MICRQXBGHYVJNKOEAWFUPTZDSL', '4', '1', '2017-11-04 23:57:10', '2017-11-15 23:57:10', '882', '{\"backgroundColor\":\"rgb(245, 87, 83)\",\"borderColor\":\"rgb(245, 87, 83)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('32', 'Ezekiel Brekke', '24554GRXLQJVIMOWHDETZUANKFSYCBP', '1', '1', '2017-11-06 00:57:10', '2017-12-03 00:57:10', '2552', '{\"backgroundColor\":\"rgb(243, 156, 18)\",\"borderColor\":\"rgb(243, 156, 18)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('33', 'Jeffry Lehner', '69551EUZWPORKDLMTGSYFQABNXCIHJV', '0', '1', '2017-11-06 12:57:10', '2017-11-30 12:57:10', '9184', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('34', 'Hertha Sporer', '23218DRBYVGHMTPAFCWEQKZLSJNUIXO', '1', '2', '2017-11-06 00:57:10', '2017-12-04 00:57:10', '3142', '{\"backgroundColor\":\"rgb(96, 92, 168)\",\"borderColor\":\"rgb(96, 92, 168)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('35', 'Shaylee Schmeler', '98767EADQSCUFPIVNYRJOMLXKWBTHZG', '5', '1', '2017-11-05 10:57:10', '2017-12-05 10:57:10', '8563', '{\"backgroundColor\":\"rgb(119, 119, 119)\",\"borderColor\":\"rgb(119, 119, 119)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('36', 'Skye Sauer DVM', '81366PMVHREBYKOSFNXJZIDQLCAGUTW', '2', '1', '2017-11-04 15:57:10', '2017-11-29 15:57:10', '8861', '{\"backgroundColor\":\"rgb(57, 204, 204)\",\"borderColor\":\"rgb(57, 204, 204)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('37', 'Wilfred Ratke', '44865SEKYFBWXNDHAIRMUZPCJOVTGLQ', '3', '4', '2017-11-05 07:57:10', '2017-11-11 07:57:10', '1621', '{\"backgroundColor\":\"rgb(0, 31, 63)\",\"borderColor\":\"rgb(0, 31, 63)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('38', 'Dr. Jaleel Kemmer Jr.', '39869GCKNZSPWVIRQHDAMTLXYUEJBFO', '3', '1', '2017-11-05 08:57:10', '2017-12-04 08:57:10', '864', '{\"backgroundColor\":\"rgb(0, 31, 63)\",\"borderColor\":\"rgb(0, 31, 63)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('39', 'Drew Williamson II', '10850IXYKAGFELDHRQNWUBSVJTCZOMP', '0', '5', '2017-11-04 19:57:10', '2017-12-05 19:57:10', '1821', '{\"backgroundColor\":\"rgb(119, 119, 119)\",\"borderColor\":\"rgb(119, 119, 119)\"}', '2017-11-05 12:57:12', '1', '2017-11-05 12:57:12', '1');
INSERT INTO `calendars` VALUES ('40', 'Prof. Evie Halvorson', '34653KNIQBVSUMRJGZEYTLAPWHXOFCD', '5', '4', '2017-11-05 16:57:10', '2017-11-25 16:57:10', '6597', '{\"backgroundColor\":\"rgb(240, 18, 190)\",\"borderColor\":\"rgb(240, 18, 190)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('41', 'Brenna Trantow', '52103NYKWJBXTOAMSQVCEZIFLPUHDRG', '4', '1', '2017-11-06 02:57:10', '2017-11-14 02:57:10', '1394', '{\"backgroundColor\":\"rgb(255, 133, 27)\",\"borderColor\":\"rgb(255, 133, 27)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('42', 'Edythe Predovic PhD', '25572AUTNZLDCYIKMQRWEHGVSBXOPFJ', '0', '2', '2017-11-05 09:57:10', '2017-11-19 09:57:10', '2684', '{\"backgroundColor\":\"rgb(119, 119, 119)\",\"borderColor\":\"rgb(119, 119, 119)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('43', 'Dr. Grant Nikolaus IV', '71899CYIKAFUOBSQVEMDNWHRJPGZLXT', '1', '5', '2017-11-05 08:57:10', '2017-11-06 08:57:10', '9187', '{\"backgroundColor\":\"rgb(57, 204, 204)\",\"borderColor\":\"rgb(57, 204, 204)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('44', 'Dallin Buckridge', '21701RUDXBQHGWVKNJTZOIFYAMPECSL', '3', '4', '2017-11-04 22:57:10', '2017-12-02 22:57:10', '9515', '{\"backgroundColor\":\"rgb(243, 156, 18)\",\"borderColor\":\"rgb(243, 156, 18)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('45', 'Joesph Mann III', '89490VEURXFZLDIAOBHGSJMCYQNKTPW', '5', '5', '2017-11-05 20:57:10', '2017-12-01 20:57:10', '1763', '{\"backgroundColor\":\"rgb(96, 92, 168)\",\"borderColor\":\"rgb(96, 92, 168)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('46', 'Sid Gulgowski', '75115SFZQLIBXYHEGNRUJCDPKOAVTWM', '0', '3', '2017-11-05 12:57:10', '2017-11-22 12:57:10', '765', '{\"backgroundColor\":\"rgb(72, 176, 247)\",\"borderColor\":\"rgb(72, 176, 247)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('47', 'Mr. Reggie Thompson PhD', '10022IXEGUOVBMRTFYDCJLAHQKPSNZW', '2', '1', '2017-11-05 16:57:10', '2017-11-12 16:57:10', '3266', '{\"backgroundColor\":\"rgb(255, 133, 27)\",\"borderColor\":\"rgb(255, 133, 27)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('48', 'Dr. Makayla Little IV', '23003KVFSYXEOMDGZLBQJPATRNCIWHU', '1', '3', '2017-11-06 08:57:10', '2017-12-07 08:57:10', '4089', '{\"backgroundColor\":\"rgb(16, 207, 189)\",\"borderColor\":\"rgb(16, 207, 189)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('49', 'Shyann Bergstrom', '78975NQGLHXMEZFDUPBWORTAIKCYJSV', '4', '4', '2017-11-05 22:57:10', '2017-11-17 22:57:10', '6469', '{\"backgroundColor\":\"rgb(16, 207, 189)\",\"borderColor\":\"rgb(16, 207, 189)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('50', 'Dr. Coby Jenkins', '51771YONTQUKMEBIGRJHSZAXPLVWCFD', '3', '3', '2017-11-06 12:57:10', '2017-12-01 12:57:10', '7924', '{\"backgroundColor\":\"rgb(243, 156, 18)\",\"borderColor\":\"rgb(243, 156, 18)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('51', 'Garret Spencer', '33826DLUYINWVBMQOFHSTAGRJEPKCZX', '2', '5', '2017-11-05 01:57:10', '2017-11-26 01:57:10', '4085', '{\"backgroundColor\":\"rgb(96, 92, 168)\",\"borderColor\":\"rgb(96, 92, 168)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');
INSERT INTO `calendars` VALUES ('52', 'Vito Hane', '17334IXESCMUVWPJNYGQLORZTKDFABH', '5', '4', '2017-11-04 20:57:10', '2017-11-19 20:57:10', '7848', '{\"backgroundColor\":\"rgb(255, 133, 27)\",\"borderColor\":\"rgb(255, 133, 27)\"}', '2017-11-05 12:57:13', '1', '2017-11-05 12:57:13', '1');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '导航栏目ID',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '导航栏目名称',
  `url` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '导航的地址',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-cube' COMMENT '使用的图标',
  `permission_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'module' COMMENT '权限名称',
  `parent` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `sort` smallint(4) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '10' COMMENT '状态 10 启用 0 停用 -1 删除',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', '导航栏目', '/admin/menus/index', 'fa-bars', 'module', '3', '3', '10', '2017-11-11 11:31:50', '2017-11-12 19:59:32');
INSERT INTO `menus` VALUES ('2', '日程管理', '/admin/calendars/index', 'fa-calendar', 'module', '0', '100', '10', '2017-11-11 11:33:07', '2017-11-11 16:33:37');
INSERT INTO `menus` VALUES ('3', '后台管理', '#', 'fa-cogs', 'module', '0', '100', '10', '2017-11-11 15:17:42', '2017-11-11 15:17:42');
INSERT INTO `menus` VALUES ('4', '角色管理', '/admin/roles/index', 'fa-magic', 'module', '3', '1', '10', '2017-11-12 14:31:47', '2017-11-12 14:33:59');
INSERT INTO `menus` VALUES ('5', '权限管理', '/admin/permissions/index', 'fa-leaf', 'module', '3', '2', '10', '2017-11-12 14:35:58', '2017-11-12 14:35:58');
INSERT INTO `menus` VALUES ('6', '上传文件', '/admin/uploads/index', 'fa-upload', 'module', '0', '2', '10', '2017-11-12 16:01:34', '2017-11-12 16:13:19');
INSERT INTO `menus` VALUES ('7', '管理员', '/admin/admins/index', 'fa-user', 'module', '3', '3', '10', '2017-11-12 19:44:34', '2017-11-12 19:59:57');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_11_02_070726_create_uploads_table', '1');
INSERT INTO `migrations` VALUES ('4', '2017_11_05_112551_create_calendars_table', '0');
INSERT INTO `migrations` VALUES ('5', '2017_11_10_181614_create_menus_table', '2');
INSERT INTO `migrations` VALUES ('6', '2017_11_12_132146_create_auth_table', '3');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'admin.menus.index', '/admin/menus/index', '导航栏目-显示信息', '2017-11-12 14:50:50', '2017-11-12 14:51:44');
INSERT INTO `permissions` VALUES ('2', 'admin.menus.search', '/admin/menus/search', '导航栏目-搜索信息', '2017-11-12 14:51:25', '2017-11-12 14:51:25');

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'admin', '超级管理员', '超级管理员', '2017-11-12 14:11:54', '2017-11-12 14:26:20');
INSERT INTO `roles` VALUES ('2', 'user', '管理员', '管理员', '2017-11-12 14:13:42', '2017-11-12 14:13:42');

-- ----------------------------
-- Table structure for uploads
-- ----------------------------
DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文件访问地址',
  `path` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '路径',
  `extension` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文件类型',
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of uploads
-- ----------------------------
INSERT INTO `uploads` VALUES ('16', '我的测试', 'timg (1).jpg', '/storage/20171104/AnhhlxnLLJ0288D4z65aTMhaXoNDM95fTegvY35C.jpeg', '20171104/AnhhlxnLLJ0288D4z65aTMhaXoNDM95fTegvY35C.jpeg', 'jpg', '1', '2017-11-04 04:12:00', '2017-11-04 04:12:08');
INSERT INTO `uploads` VALUES ('17', 'love-me', 'timg (1).jpg', '/storage/20171104/pZxz40VlaTUdAaYNyUpOt1YDjcFWgM11KhPBw1SQ.jpeg', '20171104/pZxz40VlaTUdAaYNyUpOt1YDjcFWgM11KhPBw1SQ.jpeg', 'jpg', '1', '2017-11-04 04:14:21', '2017-11-05 11:33:26');
INSERT INTO `uploads` VALUES ('19', '测试数据呢', 'timg (1).jpg', '/storage/20171104/05OwC5pduZHA2JKYesajaBPJXwYPa8tj1FDeNtqg.jpeg', '20171104/05OwC5pduZHA2JKYesajaBPJXwYPa8tj1FDeNtqg.jpeg', 'jpg', '1', '2017-11-04 04:23:00', '2017-11-04 04:23:08');
INSERT INTO `uploads` VALUES ('20', '我的测试01', 'timg.jpg', '/storage/20171104/2AzUKSiNPu6t1mCPx4Bw3gRHR4lAZpo4Y0MmB6GP.jpeg', '20171104/2AzUKSiNPu6t1mCPx4Bw3gRHR4lAZpo4Y0MmB6GP.jpeg', 'jpg', '1', '2017-11-04 04:52:37', '2017-11-04 04:52:43');
INSERT INTO `uploads` VALUES ('22', '我的测试123', 'timg (1).jpg', '/storage/20171105/pq5uWhQoIAEngctNJi6aRcJ11C8Ddcf3lk7VrjtU.jpeg', '20171105/pq5uWhQoIAEngctNJi6aRcJ11C8Ddcf3lk7VrjtU.jpeg', 'jpg', '1', '2017-11-05 11:33:01', '2017-11-05 11:33:11');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'username', 'username@qq.com', '$2y$10$c5IzIlngYAODFzCf6R3nlunXeXdgEN.aMKAHB1Q7MkPPBSYbFGKC6', 'a33zU6kgAGDUVUGkSQMuRv4weKG0TRAPizRfAUYvRgGBYbH5te2sbJJbR9R2', '2017-11-11 23:00:26', '2017-11-11 23:00:26');
