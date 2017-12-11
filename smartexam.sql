/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50636
 Source Host           : localhost
 Source Database       : smartexam

 Target Server Type    : MySQL
 Target Server Version : 50636
 File Encoding         : utf-8

 Date: 12/12/2017 00:25:00 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `announce`
-- ----------------------------
DROP TABLE IF EXISTS `announce`;
CREATE TABLE `announce` (
  `announce_id` int(6) NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) DEFAULT NULL,
  `detail` text CHARACTER SET utf8,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`announce_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `answer`
-- ----------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `answer_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `choice_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `answer_fill`
-- ----------------------------
DROP TABLE IF EXISTS `answer_fill`;
CREATE TABLE `answer_fill` (
  `answer_fill_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `detail` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `number_exam` int(2) DEFAULT NULL,
  PRIMARY KEY (`answer_fill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `answer_group`
-- ----------------------------
DROP TABLE IF EXISTS `answer_group`;
CREATE TABLE `answer_group` (
  `answer_group_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `choice_group_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`answer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `choice`
-- ----------------------------
DROP TABLE IF EXISTS `choice`;
CREATE TABLE `choice` (
  `choice_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `choice_detail` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`choice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `choice_group`
-- ----------------------------
DROP TABLE IF EXISTS `choice_group`;
CREATE TABLE `choice_group` (
  `choice_group_id` int(10) NOT NULL AUTO_INCREMENT,
  `group_id` int(6) DEFAULT NULL,
  `choice_detail` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`choice_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `examination`
-- ----------------------------
DROP TABLE IF EXISTS `examination`;
CREATE TABLE `examination` (
  `examination_id` int(10) NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) DEFAULT NULL,
  `examination_name` text,
  `examination_type_id` int(3) DEFAULT NULL,
  `examination_score` int(3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`examination_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `examination_group`
-- ----------------------------
DROP TABLE IF EXISTS `examination_group`;
CREATE TABLE `examination_group` (
  `examination_group_id` int(6) NOT NULL AUTO_INCREMENT,
  `group_id` int(6) DEFAULT NULL,
  `examination_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`examination_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `examination_type`
-- ----------------------------
DROP TABLE IF EXISTS `examination_type`;
CREATE TABLE `examination_type` (
  `examination_type_id` int(3) NOT NULL AUTO_INCREMENT,
  `examination_type_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`examination_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `exams`
-- ----------------------------
DROP TABLE IF EXISTS `exams`;
CREATE TABLE `exams` (
  `exam_id` int(6) NOT NULL AUTO_INCREMENT,
  `subject` varchar(200) DEFAULT NULL,
  `short_detail` varchar(100) DEFAULT NULL,
  `detail` text,
  `user_id` int(7) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `exams`
-- ----------------------------
BEGIN;
INSERT INTO `exams` VALUES ('1', 'คณิตศาสตร์', 'บวกเลข', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', '1', null, null), ('2', 'ภาษาไทย', 'การอ่านและการเขียน', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '1', '1', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `faculty`
-- ----------------------------
DROP TABLE IF EXISTS `faculty`;
CREATE TABLE `faculty` (
  `faculty_id` int(2) NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`faculty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `group`
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `group_id` int(6) NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `page` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `major`
-- ----------------------------
DROP TABLE IF EXISTS `major`;
CREATE TABLE `major` (
  `major_id` int(2) NOT NULL,
  `major_name` varchar(255) DEFAULT NULL,
  `faculty_id` int(2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`major_id`),
  KEY `faculty_id` (`faculty_id`),
  CONSTRAINT `major_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `register_exam`
-- ----------------------------
DROP TABLE IF EXISTS `register_exam`;
CREATE TABLE `register_exam` (
  `register_exam_id` int(10) NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) DEFAULT NULL,
  `sec_id` int(11) DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `time_stamp` int(16) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`register_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `register_exam`
-- ----------------------------
BEGIN;
INSERT INTO `register_exam` VALUES ('1', '1', '1', '2017-12-08', '16:10:25', '18:10:25', '1512770225', null, null), ('2', '2', '1', '2017-12-09', '16:10:25', '18:10:25', '1512856625', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `register_sec`
-- ----------------------------
DROP TABLE IF EXISTS `register_sec`;
CREATE TABLE `register_sec` (
  `register_sec_id` int(10) NOT NULL AUTO_INCREMENT,
  `sec_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_id` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`register_sec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `register_sec`
-- ----------------------------
BEGIN;
INSERT INTO `register_sec` VALUES ('1', '1', '2', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `result`
-- ----------------------------
DROP TABLE IF EXISTS `result`;
CREATE TABLE `result` (
  `result_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `choice_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`result_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `result_fill`
-- ----------------------------
DROP TABLE IF EXISTS `result_fill`;
CREATE TABLE `result_fill` (
  `result_fill_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `keyword` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `number_exam` int(2) DEFAULT NULL,
  PRIMARY KEY (`result_fill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `result_group`
-- ----------------------------
DROP TABLE IF EXISTS `result_group`;
CREATE TABLE `result_group` (
  `result_group_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `choice_group_id` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`result_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `school_year`
-- ----------------------------
DROP TABLE IF EXISTS `school_year`;
CREATE TABLE `school_year` (
  `sc_year_id` int(6) NOT NULL AUTO_INCREMENT,
  `sc_year_name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sc_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `section`
-- ----------------------------
DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `sec_id` int(10) NOT NULL AUTO_INCREMENT,
  `sec_name` varchar(100) DEFAULT NULL,
  `created_id` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `section`
-- ----------------------------
BEGIN;
INSERT INTO `section` VALUES ('1', 'test', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `story`
-- ----------------------------
DROP TABLE IF EXISTS `story`;
CREATE TABLE `story` (
  `story_id` int(10) NOT NULL AUTO_INCREMENT,
  `examination_id` int(10) DEFAULT NULL,
  `story_detail` text CHARACTER SET utf8,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`story_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `subject`
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `sub_id` int(3) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `sub_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sub_detail` text CHARACTER SET utf8,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`sub_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `term`
-- ----------------------------
DROP TABLE IF EXISTS `term`;
CREATE TABLE `term` (
  `term_id` int(6) NOT NULL AUTO_INCREMENT,
  `term_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `student_code` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_type_id` int(2) DEFAULT NULL,
  `major_id` int(2) DEFAULT NULL,
  `enable` enum('0','1') CHARACTER SET utf8 DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_type_id` (`user_type_id`),
  KEY `major_id` (`major_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `user`
-- ----------------------------
BEGIN;
INSERT INTO `user` VALUES ('2', 'a', 'a', 'a', '1', '1', '1', '0', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `user_type`
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `user_type_id` int(2) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
