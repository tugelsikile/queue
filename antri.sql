/*
 Navicat Premium Data Transfer

 Source Server         : mySQL Localhost
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : queue

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 31/08/2022 22:43:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tb_calling
-- ----------------------------
DROP TABLE IF EXISTS `tb_calling`;
CREATE TABLE `tb_calling`  (
  `call_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `que_id` bigint UNSIGNED NULL DEFAULT NULL,
  `call_date` datetime NULL DEFAULT current_timestamp,
  `call_status` tinyint(1) NULL DEFAULT 0,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `call_at` datetime NULL DEFAULT NULL,
  `qpol_id` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`call_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `que_id`(`que_id`) USING BTREE,
  INDEX `qpol_id`(`qpol_id`) USING BTREE,
  CONSTRAINT `tb_calling_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_calling_ibfk_2` FOREIGN KEY (`que_id`) REFERENCES `tb_queue` (`que_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_calling_ibfk_3` FOREIGN KEY (`qpol_id`) REFERENCES `tb_queue_poli` (`qpol_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 231 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_calling
-- ----------------------------
INSERT INTO `tb_calling` VALUES (205, 242, '2018-05-02 10:29:27', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (206, NULL, '2018-05-02 10:29:36', 1, 1, NULL, 6);
INSERT INTO `tb_calling` VALUES (207, NULL, '2018-05-02 10:36:27', 1, 1, NULL, 6);
INSERT INTO `tb_calling` VALUES (208, 243, '2018-05-02 10:38:30', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (209, 243, '2018-05-02 10:47:48', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (210, 261, '2022-08-31 16:16:47', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (211, NULL, '2022-08-31 16:17:18', 1, 1, NULL, 25);
INSERT INTO `tb_calling` VALUES (212, NULL, '2022-08-31 16:18:47', 1, 1, NULL, 30);
INSERT INTO `tb_calling` VALUES (213, NULL, '2022-08-31 16:19:05', 1, 1, NULL, 30);
INSERT INTO `tb_calling` VALUES (214, NULL, '2022-08-31 16:19:25', 1, 1, NULL, 30);
INSERT INTO `tb_calling` VALUES (215, NULL, '2022-08-31 16:19:39', 1, 1, NULL, 31);
INSERT INTO `tb_calling` VALUES (216, 266, '2022-08-31 16:19:52', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (217, 260, '2022-08-31 16:19:57', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (218, 262, '2022-08-31 16:20:18', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (219, 263, '2022-08-31 16:20:35', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (220, 264, '2022-08-31 16:20:54', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (221, NULL, '2022-08-31 16:21:01', 1, 1, NULL, 32);
INSERT INTO `tb_calling` VALUES (222, NULL, '2022-08-31 16:21:19', 1, 1, NULL, 33);
INSERT INTO `tb_calling` VALUES (223, NULL, '2022-08-31 16:22:33', 1, 1, NULL, 34);
INSERT INTO `tb_calling` VALUES (224, NULL, '2022-08-31 16:22:57', 1, 1, NULL, 24);
INSERT INTO `tb_calling` VALUES (225, NULL, '2022-08-31 16:30:16', 1, 1, NULL, 26);
INSERT INTO `tb_calling` VALUES (226, NULL, '2022-08-31 16:30:28', 1, 1, NULL, 35);
INSERT INTO `tb_calling` VALUES (227, NULL, '2022-08-31 16:31:12', 1, 1, NULL, 36);
INSERT INTO `tb_calling` VALUES (228, NULL, '2022-08-31 16:31:33', 1, 1, NULL, 37);
INSERT INTO `tb_calling` VALUES (229, 267, '2022-08-31 16:32:01', 1, 1, NULL, NULL);
INSERT INTO `tb_calling` VALUES (230, 265, '2022-08-31 16:32:17', 1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for tb_dokter
-- ----------------------------
DROP TABLE IF EXISTS `tb_dokter`;
CREATE TABLE `tb_dokter`  (
  `dr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `spc_id` bigint UNSIGNED NULL DEFAULT NULL,
  `dr_status` tinyint(1) NULL DEFAULT 1,
  `dr_date` datetime NULL DEFAULT current_timestamp,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `dr_quota` int NULL DEFAULT 100,
  `poli_id` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`dr_id`) USING BTREE,
  INDEX `spc_id`(`spc_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `poli_id`(`poli_id`) USING BTREE,
  CONSTRAINT `tb_dokter_ibfk_1` FOREIGN KEY (`spc_id`) REFERENCES `tb_spesialis` (`spc_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_dokter_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_dokter_ibfk_3` FOREIGN KEY (`poli_id`) REFERENCES `tb_poli` (`poli_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_dokter
-- ----------------------------
INSERT INTO `tb_dokter` VALUES (1, 1, 1, '2018-04-29 11:43:46', 5, 30, 1);
INSERT INTO `tb_dokter` VALUES (2, 3, 1, '2018-04-29 13:11:01', 6, 5, 9);
INSERT INTO `tb_dokter` VALUES (3, 2, 1, '2018-04-29 16:14:06', 7, 10, 10);
INSERT INTO `tb_dokter` VALUES (4, 1, 1, '2018-04-29 16:14:40', 8, 100, 4);
INSERT INTO `tb_dokter` VALUES (5, 3, 1, '2018-04-29 20:19:03', 9, 35, 9);
INSERT INTO `tb_dokter` VALUES (6, 2, 1, '2018-04-29 20:20:03', 10, 150, 10);
INSERT INTO `tb_dokter` VALUES (7, 1, 0, '2018-04-30 10:19:34', 11, 100, 9);

-- ----------------------------
-- Table structure for tb_dokter_jadwal
-- ----------------------------
DROP TABLE IF EXISTS `tb_dokter_jadwal`;
CREATE TABLE `tb_dokter_jadwal`  (
  `djad_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `dr_id` bigint UNSIGNED NULL DEFAULT NULL,
  `djad_status` tinyint(1) NULL DEFAULT 1,
  `djad_day` int NULL DEFAULT NULL,
  `djad_time_antri` time NULL DEFAULT NULL,
  `djad_time_start` time NULL DEFAULT NULL,
  `djad_time_end` time NULL DEFAULT NULL,
  `djad_quota` int NULL DEFAULT NULL,
  PRIMARY KEY (`djad_id`) USING BTREE,
  INDEX `dr_id`(`dr_id`) USING BTREE,
  CONSTRAINT `tb_dokter_jadwal_ibfk_1` FOREIGN KEY (`dr_id`) REFERENCES `tb_dokter` (`dr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_dokter_jadwal
-- ----------------------------
INSERT INTO `tb_dokter_jadwal` VALUES (27, 1, 1, 3, '06:00:00', '07:00:00', '12:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (28, 1, 1, 3, '12:00:00', '13:00:00', '21:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (29, 4, 1, 3, '08:00:00', '09:00:00', '12:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (30, 4, 1, 3, '00:00:00', '01:00:00', '06:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (31, 4, 1, 3, '12:00:00', '13:00:00', '15:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (32, 2, 0, 4, '06:00:00', '07:00:00', '12:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (33, 1, 1, 4, '06:00:00', '07:00:00', '12:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (34, 1, 1, 4, '12:00:00', '13:00:00', '14:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (35, 1, 1, 4, '17:00:00', '18:00:00', '20:00:00', NULL);
INSERT INTO `tb_dokter_jadwal` VALUES (36, 6, 1, 3, '16:00:00', '17:00:00', '23:00:00', NULL);

-- ----------------------------
-- Table structure for tb_loket
-- ----------------------------
DROP TABLE IF EXISTS `tb_loket`;
CREATE TABLE `tb_loket`  (
  `loket_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `loket_kode` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `loket_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `loket_description` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `loket_status` tinyint(1) NULL DEFAULT 1,
  `loket_date` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`loket_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_loket
-- ----------------------------
INSERT INTO `tb_loket` VALUES (1, 'A', 'Loket 1', NULL, 0, '2018-04-28 10:04:08');
INSERT INTO `tb_loket` VALUES (2, 'B', 'Loket 2', NULL, 0, '2018-04-28 10:04:08');
INSERT INTO `tb_loket` VALUES (3, 'C', 'Loket 3', NULL, 0, '2018-04-28 10:04:08');
INSERT INTO `tb_loket` VALUES (6, 'D', 'Loket 4', NULL, 0, '2018-04-28 10:09:31');
INSERT INTO `tb_loket` VALUES (7, 'E', 'Loket 5', NULL, 0, '2018-04-28 10:09:56');
INSERT INTO `tb_loket` VALUES (8, 'FF', 'Loket 6', NULL, 0, '2018-04-28 10:20:37');
INSERT INTO `tb_loket` VALUES (9, 'GGG', 'Loket 7', NULL, 0, '2018-04-28 10:23:04');
INSERT INTO `tb_loket` VALUES (10, 'F', 'Loket 6', NULL, 0, '2018-04-28 11:12:18');
INSERT INTO `tb_loket` VALUES (11, 'G', 'Loket 7', NULL, 0, '2018-04-28 11:12:28');
INSERT INTO `tb_loket` VALUES (12, 'H', 'Loket 8', NULL, 0, '2018-04-28 11:12:38');
INSERT INTO `tb_loket` VALUES (13, 'A', 'Pendaftaran 1', NULL, 1, '2018-04-28 11:12:51');
INSERT INTO `tb_loket` VALUES (14, 'B', 'Pendaftaran 2', NULL, 1, '2018-04-29 20:15:03');

-- ----------------------------
-- Table structure for tb_marquee
-- ----------------------------
DROP TABLE IF EXISTS `tb_marquee`;
CREATE TABLE `tb_marquee`  (
  `rt_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `rt_content` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `rt_date` datetime NULL DEFAULT current_timestamp,
  `rt_status` tinyint NULL DEFAULT 1,
  PRIMARY KEY (`rt_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_marquee
-- ----------------------------
INSERT INTO `tb_marquee` VALUES (1, 'Informasi untuk seluruh dokter diharapkan menuju ke ruang rapat....', '2018-05-02 07:40:48', 1);
INSERT INTO `tb_marquee` VALUES (2, 'Lorem Ipsum dolor sit amet .', '2018-05-02 07:47:17', 1);

-- ----------------------------
-- Table structure for tb_media
-- ----------------------------
DROP TABLE IF EXISTS `tb_media`;
CREATE TABLE `tb_media`  (
  `media_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `media_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `media_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `media_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `media_date` datetime NULL DEFAULT current_timestamp,
  `media_status` tinyint(1) NULL DEFAULT 1,
  `media_duration` int NULL DEFAULT NULL,
  PRIMARY KEY (`media_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_media
-- ----------------------------
INSERT INTO `tb_media` VALUES (1, 'Video 1', 'video01.mp4', NULL, '2018-04-30 14:25:58', 1, NULL);
INSERT INTO `tb_media` VALUES (2, 'Video 2', 'video02.mp4', NULL, '2018-04-30 14:26:09', 0, NULL);
INSERT INTO `tb_media` VALUES (3, 'alone-2017.mp4 - streamango.MP4', 'ffa0190384992315fff7fc417e807a77.MP4', NULL, '2018-05-02 10:01:38', 0, NULL);
INSERT INTO `tb_media` VALUES (4, 'Nonton Aliens Ate My Homework (2018) Film Streaming Download Movie Cinema 21 Bioskop Subtitle Indonesia _raquo; Layarkaca21 HD Dunia21 [1].mp4', '1a4a125e1e9580d6fc07370ca630102c.mp4', NULL, '2018-05-02 10:39:58', 0, NULL);
INSERT INTO `tb_media` VALUES (5, 'Nonton 47 Meters Down (2017) Film Streaming Download Movie Cinema 21 Bioskop Subtitle Indonesia _raquo; Layarkaca21 HD IndoXXI Layarkacaxxi [1].MP4', '534afcb32288ad1e31138dd7b8abc158.MP4', NULL, '2018-05-02 10:41:59', 0, NULL);

-- ----------------------------
-- Table structure for tb_poli
-- ----------------------------
DROP TABLE IF EXISTS `tb_poli`;
CREATE TABLE `tb_poli`  (
  `poli_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `poli_kode` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `poli_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `poli_logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `poli_status` tinyint(1) NULL DEFAULT 1,
  `poli_max` int NULL DEFAULT 100,
  `loket_id` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`poli_id`) USING BTREE,
  INDEX `loket_id`(`loket_id`) USING BTREE,
  CONSTRAINT `tb_poli_ibfk_1` FOREIGN KEY (`loket_id`) REFERENCES `tb_loket` (`loket_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_poli
-- ----------------------------
INSERT INTO `tb_poli` VALUES (1, 'Y', 'Poli Umum', 'cardiogram.png', 1, 100, 14);
INSERT INTO `tb_poli` VALUES (2, 'V', 'Poli Gigi', 'cardiogram.png', 0, 100, 1);
INSERT INTO `tb_poli` VALUES (3, 'W', 'Poli Dalam', 'x-rays.png', 0, 100, 3);
INSERT INTO `tb_poli` VALUES (4, 'Z', 'Poli THT', 'cardiogram.png', 1, 100, 13);
INSERT INTO `tb_poli` VALUES (5, 'Z', 'Poli Fisioterapi', 'x-rays.png', 0, 100, 7);
INSERT INTO `tb_poli` VALUES (6, 'U', 'Poli Kandungan ', 'cardiogram.png', 0, 100, 6);
INSERT INTO `tb_poli` VALUES (7, 'T', 'Astrologi', 'cardiogram.png', 0, 100, 1);
INSERT INTO `tb_poli` VALUES (8, 'R', 'Coba Saja', 'cardiogram.png', 0, 100, 1);
INSERT INTO `tb_poli` VALUES (9, 'W', 'Poli Kandungan', '67b5920917bbae642f3d42af19e57248.PNG', 1, 100, 13);
INSERT INTO `tb_poli` VALUES (10, 'X', 'Poli Anak', 'x-rays.png', 1, 100, 13);
INSERT INTO `tb_poli` VALUES (11, 'U', 'POLI X', 'fa9e3e29bfd354e5f965343571ceb87c.PNG', 0, 100, 13);

-- ----------------------------
-- Table structure for tb_poli_dokter
-- ----------------------------
DROP TABLE IF EXISTS `tb_poli_dokter`;
CREATE TABLE `tb_poli_dokter`  (
  `pdr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `poli_id` bigint UNSIGNED NULL DEFAULT NULL,
  `dr_id` bigint UNSIGNED NULL DEFAULT NULL,
  `pdr_date` datetime NULL DEFAULT current_timestamp,
  `pdr_status` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`pdr_id`) USING BTREE,
  INDEX `poli_id`(`poli_id`) USING BTREE,
  INDEX `dr_id`(`dr_id`) USING BTREE,
  CONSTRAINT `tb_poli_dokter_ibfk_1` FOREIGN KEY (`poli_id`) REFERENCES `tb_poli` (`poli_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_poli_dokter_ibfk_2` FOREIGN KEY (`dr_id`) REFERENCES `tb_dokter` (`dr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_poli_dokter
-- ----------------------------

-- ----------------------------
-- Table structure for tb_printer
-- ----------------------------
DROP TABLE IF EXISTS `tb_printer`;
CREATE TABLE `tb_printer`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `share_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tb_printer
-- ----------------------------

-- ----------------------------
-- Table structure for tb_queue
-- ----------------------------
DROP TABLE IF EXISTS `tb_queue`;
CREATE TABLE `tb_queue`  (
  `que_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `loket_id` bigint UNSIGNED NULL DEFAULT NULL,
  `que_date` datetime NULL DEFAULT current_timestamp,
  `que_status` tinyint(1) NULL DEFAULT 1,
  `poli_id` bigint UNSIGNED NULL DEFAULT NULL,
  `que_call` tinyint NULL DEFAULT 0,
  `dr_id` bigint UNSIGNED NULL DEFAULT NULL,
  `que_kode` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `que_kode2` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`que_id`) USING BTREE,
  INDEX `loket_id`(`loket_id`) USING BTREE,
  INDEX `poli_id`(`poli_id`) USING BTREE,
  INDEX `dr_id`(`dr_id`) USING BTREE,
  CONSTRAINT `tb_queue_ibfk_1` FOREIGN KEY (`loket_id`) REFERENCES `tb_loket` (`loket_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_queue_ibfk_2` FOREIGN KEY (`poli_id`) REFERENCES `tb_poli` (`poli_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_queue_ibfk_3` FOREIGN KEY (`dr_id`) REFERENCES `tb_dokter` (`dr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 274 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_queue
-- ----------------------------
INSERT INTO `tb_queue` VALUES (237, 14, '2018-04-30 13:41:38', 1, 4, 1, 4, 'B', '001');
INSERT INTO `tb_queue` VALUES (238, 14, '2018-04-30 13:42:02', 1, 4, 1, 4, 'B', '002');
INSERT INTO `tb_queue` VALUES (239, 14, '2018-04-30 13:43:42', 1, 4, 1, 4, 'B', '003');
INSERT INTO `tb_queue` VALUES (240, 14, '2018-04-30 13:45:37', 1, 4, 1, 4, 'B', '004');
INSERT INTO `tb_queue` VALUES (241, 14, '2018-04-30 13:45:54', 1, 4, 1, 4, 'B', '005');
INSERT INTO `tb_queue` VALUES (242, 13, '2018-05-02 10:27:58', 1, 9, 1, 2, 'A', '001');
INSERT INTO `tb_queue` VALUES (243, 13, '2018-05-02 10:28:02', 1, 9, 1, 5, 'A', '002');
INSERT INTO `tb_queue` VALUES (244, 13, '2018-05-02 11:14:54', 1, 9, 0, 2, 'A', '003');
INSERT INTO `tb_queue` VALUES (245, 13, '2018-05-02 11:15:00', 1, 9, 0, 2, 'A', '004');
INSERT INTO `tb_queue` VALUES (246, 13, '2018-05-02 11:15:01', 1, 9, 0, 2, 'A', '005');
INSERT INTO `tb_queue` VALUES (247, 13, '2018-05-02 11:15:03', 1, 9, 0, 2, 'A', '006');
INSERT INTO `tb_queue` VALUES (248, 13, '2018-05-02 11:15:13', 1, 10, 0, 6, 'A', '001');
INSERT INTO `tb_queue` VALUES (249, 14, '2018-05-02 14:27:01', 1, 1, 0, 1, 'B', '001');
INSERT INTO `tb_queue` VALUES (250, 14, '2018-05-02 14:34:39', 1, 1, 0, 1, 'B', '002');
INSERT INTO `tb_queue` VALUES (251, 14, '2018-05-02 15:15:21', 1, 1, 0, 1, 'B', '003');
INSERT INTO `tb_queue` VALUES (252, 13, '2018-05-03 08:09:08', 1, 9, 0, 2, 'A', '001');
INSERT INTO `tb_queue` VALUES (253, 13, '2018-05-03 08:10:46', 1, 9, 0, 2, 'A', '002');
INSERT INTO `tb_queue` VALUES (254, 14, '2018-05-03 08:28:57', 1, 1, 0, 1, 'B', '001');
INSERT INTO `tb_queue` VALUES (255, 14, '2018-05-03 08:29:17', 1, 1, 0, 1, 'B', '001');
INSERT INTO `tb_queue` VALUES (256, 13, '2018-05-03 08:42:51', 1, 9, 0, 2, 'A', '001');
INSERT INTO `tb_queue` VALUES (257, 13, '2018-05-03 08:43:05', 1, 9, 0, 2, 'A', '001');
INSERT INTO `tb_queue` VALUES (258, 13, '2018-05-03 08:54:47', 1, 9, 0, 2, 'A', '005');
INSERT INTO `tb_queue` VALUES (259, 14, '2018-05-03 08:59:24', 1, 1, 0, 1, 'B', '003');
INSERT INTO `tb_queue` VALUES (260, 14, '2022-08-31 19:28:01', 1, 1, 1, 1, 'B', '001');
INSERT INTO `tb_queue` VALUES (261, 13, '2022-08-31 19:28:06', 1, 10, 1, 6, 'A', '001');
INSERT INTO `tb_queue` VALUES (262, 14, '2022-08-31 20:48:42', 1, 1, 1, 1, 'B', '002');
INSERT INTO `tb_queue` VALUES (263, 14, '2022-08-31 20:51:20', 1, 1, 1, 1, 'B', '003');
INSERT INTO `tb_queue` VALUES (264, 14, '2022-08-31 20:54:52', 1, 1, 1, 1, 'B', '004');
INSERT INTO `tb_queue` VALUES (265, 14, '2022-08-31 20:57:13', 1, 1, 1, 1, 'B', '005');
INSERT INTO `tb_queue` VALUES (266, 13, '2022-08-31 21:02:30', 1, 10, 1, 6, 'A', '002');
INSERT INTO `tb_queue` VALUES (267, 13, '2022-08-31 21:04:29', 1, 10, 1, 6, 'A', '003');
INSERT INTO `tb_queue` VALUES (268, 13, '2022-08-31 21:11:14', 1, 10, 0, 6, 'A', '004');
INSERT INTO `tb_queue` VALUES (269, 13, '2022-08-31 21:11:37', 1, 10, 0, 6, 'A', '005');
INSERT INTO `tb_queue` VALUES (270, 13, '2022-08-31 21:11:57', 1, 10, 0, 6, 'A', '006');
INSERT INTO `tb_queue` VALUES (271, 13, '2022-08-31 21:23:03', 1, 10, 0, 6, 'A', '007');
INSERT INTO `tb_queue` VALUES (272, 13, '2022-08-31 21:30:41', 1, 10, 0, 6, 'A', '008');
INSERT INTO `tb_queue` VALUES (273, 13, '2022-08-31 21:30:58', 1, 10, 0, 6, 'A', '009');

-- ----------------------------
-- Table structure for tb_queue_poli
-- ----------------------------
DROP TABLE IF EXISTS `tb_queue_poli`;
CREATE TABLE `tb_queue_poli`  (
  `qpol_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `poli_id` bigint UNSIGNED NULL DEFAULT NULL,
  `qpol_date` datetime NULL DEFAULT current_timestamp,
  `qpol_status` tinyint NULL DEFAULT 1,
  `qpol_kode1` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `qpol_kode2` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `dr_id` bigint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`qpol_id`) USING BTREE,
  INDEX `poli_id`(`poli_id`) USING BTREE,
  INDEX `dr_id`(`dr_id`) USING BTREE,
  CONSTRAINT `tb_queue_poli_ibfk_1` FOREIGN KEY (`poli_id`) REFERENCES `tb_poli` (`poli_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tb_queue_poli_ibfk_2` FOREIGN KEY (`dr_id`) REFERENCES `tb_dokter` (`dr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_queue_poli
-- ----------------------------
INSERT INTO `tb_queue_poli` VALUES (1, 4, '2018-04-30 13:41:38', 1, 'Z', '001', 4);
INSERT INTO `tb_queue_poli` VALUES (2, 4, '2018-04-30 13:42:02', 1, 'Z', '002', 4);
INSERT INTO `tb_queue_poli` VALUES (3, 4, '2018-04-30 13:43:42', 1, 'Z', '003', 4);
INSERT INTO `tb_queue_poli` VALUES (4, 4, '2018-04-30 13:45:37', 1, 'Z', '004', 4);
INSERT INTO `tb_queue_poli` VALUES (5, 4, '2018-04-30 13:45:54', 1, 'Z', '005', 4);
INSERT INTO `tb_queue_poli` VALUES (6, 9, '2018-05-02 10:27:58', 1, 'W', '001', 2);
INSERT INTO `tb_queue_poli` VALUES (7, 9, '2018-05-02 10:28:02', 1, 'W', '002', 5);
INSERT INTO `tb_queue_poli` VALUES (8, 9, '2018-05-02 11:14:54', 1, 'W', '003', 2);
INSERT INTO `tb_queue_poli` VALUES (9, 9, '2018-05-02 11:15:00', 1, 'W', '004', 2);
INSERT INTO `tb_queue_poli` VALUES (10, 9, '2018-05-02 11:15:02', 1, 'W', '005', 2);
INSERT INTO `tb_queue_poli` VALUES (11, 9, '2018-05-02 11:15:03', 1, 'W', '006', 2);
INSERT INTO `tb_queue_poli` VALUES (12, 10, '2018-05-02 11:15:13', 1, 'X', '001', 6);
INSERT INTO `tb_queue_poli` VALUES (13, 1, '2018-05-02 14:27:02', 1, 'Y', '001', 1);
INSERT INTO `tb_queue_poli` VALUES (14, 1, '2018-05-02 14:34:39', 1, 'Y', '002', 1);
INSERT INTO `tb_queue_poli` VALUES (15, 1, '2018-05-02 15:15:21', 1, 'Y', '003', 1);
INSERT INTO `tb_queue_poli` VALUES (16, 9, '2018-05-03 08:09:08', 1, 'W', '001', 2);
INSERT INTO `tb_queue_poli` VALUES (17, 9, '2018-05-03 08:10:46', 1, 'W', '002', 2);
INSERT INTO `tb_queue_poli` VALUES (18, 1, '2018-05-03 08:28:58', 1, 'Y', '001', 1);
INSERT INTO `tb_queue_poli` VALUES (19, 1, '2018-05-03 08:29:17', 1, 'Y', '001', 1);
INSERT INTO `tb_queue_poli` VALUES (20, 9, '2018-05-03 08:42:51', 1, 'W', '001', 2);
INSERT INTO `tb_queue_poli` VALUES (21, 9, '2018-05-03 08:43:05', 1, 'W', '001', 2);
INSERT INTO `tb_queue_poli` VALUES (22, 9, '2018-05-03 08:54:47', 1, 'W', '005', 2);
INSERT INTO `tb_queue_poli` VALUES (23, 1, '2018-05-03 08:59:24', 1, 'Y', '003', 1);
INSERT INTO `tb_queue_poli` VALUES (24, 1, '2022-08-31 19:28:01', 1, 'Y', '001', 1);
INSERT INTO `tb_queue_poli` VALUES (25, 10, '2022-08-31 19:28:06', 1, 'X', '001', 6);
INSERT INTO `tb_queue_poli` VALUES (26, 1, '2022-08-31 20:48:42', 1, 'Y', '002', 1);
INSERT INTO `tb_queue_poli` VALUES (27, 1, '2022-08-31 20:51:20', 1, 'Y', '003', 1);
INSERT INTO `tb_queue_poli` VALUES (28, 1, '2022-08-31 20:54:52', 1, 'Y', '004', 1);
INSERT INTO `tb_queue_poli` VALUES (29, 1, '2022-08-31 20:57:13', 1, 'Y', '005', 1);
INSERT INTO `tb_queue_poli` VALUES (30, 10, '2022-08-31 21:02:30', 1, 'X', '002', 6);
INSERT INTO `tb_queue_poli` VALUES (31, 10, '2022-08-31 21:04:29', 1, 'X', '003', 6);
INSERT INTO `tb_queue_poli` VALUES (32, 10, '2022-08-31 21:11:14', 1, 'X', '004', 6);
INSERT INTO `tb_queue_poli` VALUES (33, 10, '2022-08-31 21:11:37', 1, 'X', '005', 6);
INSERT INTO `tb_queue_poli` VALUES (34, 10, '2022-08-31 21:11:57', 1, 'X', '006', 6);
INSERT INTO `tb_queue_poli` VALUES (35, 10, '2022-08-31 21:23:03', 1, 'X', '007', 6);
INSERT INTO `tb_queue_poli` VALUES (36, 10, '2022-08-31 21:30:41', 1, 'X', '008', 6);
INSERT INTO `tb_queue_poli` VALUES (37, 10, '2022-08-31 21:30:58', 1, 'X', '009', 6);

-- ----------------------------
-- Table structure for tb_rumkit
-- ----------------------------
DROP TABLE IF EXISTS `tb_rumkit`;
CREATE TABLE `tb_rumkit`  (
  `rs_id` int NOT NULL,
  `rs_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `rs_alamat` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rs_slogan` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rs_logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rs_printer_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`rs_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_rumkit
-- ----------------------------
INSERT INTO `tb_rumkit` VALUES (1, 'Rumah Sakit Salaman', 'Jl. Perjalanan ini terasa sangat menyedihkan', NULL, NULL, 'receipt_printer');

-- ----------------------------
-- Table structure for tb_spesialis
-- ----------------------------
DROP TABLE IF EXISTS `tb_spesialis`;
CREATE TABLE `tb_spesialis`  (
  `spc_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `spc_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `spc_status` tinyint(1) NULL DEFAULT 1,
  `spc_date` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`spc_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_spesialis
-- ----------------------------
INSERT INTO `tb_spesialis` VALUES (1, 'Dokter Umum', 1, '2018-04-29 09:31:46');
INSERT INTO `tb_spesialis` VALUES (2, 'Spesialis Anak', 1, '2018-04-29 09:31:51');
INSERT INTO `tb_spesialis` VALUES (3, 'Spesialis Kandungan', 1, '2018-04-29 09:31:55');
INSERT INTO `tb_spesialis` VALUES (4, 'Spesialis Contoh', 0, '2018-04-30 10:11:04');
INSERT INTO `tb_spesialis` VALUES (5, 'Spesialis Contoh', 0, '2018-04-30 10:27:45');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user`  (
  `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `user_level` int NULL DEFAULT NULL,
  `user_status` tinyint(1) NULL DEFAULT 1,
  `user_date` datetime NULL DEFAULT current_timestamp,
  `user_last_login` datetime NULL DEFAULT NULL,
  `user_fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `user_pic` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES (1, 'admin', '$2y$10$VUon.AX5D4UMxnoE7Gp/ruh6z2jbpzU5ltN3Y6BT8EwmdWcW4UfEW', 99, 1, '2018-04-17 12:26:47', '2022-08-31 17:41:12', 'Admin', NULL);
INSERT INTO `tb_user` VALUES (2, 'dadang', '$2y$10$yjo4Fda8ACI3OHkWWmahVuQN44OiU5lqJjwOlRqdEqqG4/9VedhdK', 1, 1, '2018-04-28 13:41:00', '2018-04-28 08:44:33', 'Dadang Sudrajat', NULL);
INSERT INTO `tb_user` VALUES (3, 'riyan', '$2y$10$BSfc6EDCCcr5NEO251m1juGAp98NhXaPmPbdXSO9MZNezAQiZFi3O', 1, 1, '2018-04-28 13:47:24', NULL, 'Abil Rifandi', NULL);
INSERT INTO `tb_user` VALUES (4, 'broto', '$2y$10$z5G0yS6rbkvbVCicve9gbOXjmzCe4hjijSEVOFJ4BoIS1krMKNIr2', 99, 1, '2018-04-28 13:48:58', NULL, 'Bratasena', NULL);
INSERT INTO `tb_user` VALUES (5, 'mashudi', '$2y$10$FrigG7q8EjSEBWGefPvYIONitjoQHSWQEQ.EAAt6b3M26p2OcmRlm', 50, 1, '2018-04-29 11:43:46', NULL, 'Dr. Mashudi', NULL);
INSERT INTO `tb_user` VALUES (6, 'yaja', '$2y$10$KJ/9ov2gu3tIcp5abgnyx.vpfIb8JuIKN2myuiO6KcfYHvqI7SsVG', 50, 1, '2018-04-29 13:11:01', NULL, 'Dr. Jaya, Sp.Og', NULL);
INSERT INTO `tb_user` VALUES (7, 'yasmin', '$2y$10$MWcbUphh8ykP5LBkaf98Auax32aLwDxyAJ4S3AWdsKkZ53zcyNltS', 50, 1, '2018-04-29 16:14:06', NULL, 'dr. Yasmin Darmawan, SP.OG', NULL);
INSERT INTO `tb_user` VALUES (8, 'irawan', '$2y$10$QA.H7YAANiJNFFRxPZ9mhutXdniQW9rh9fAOjXsLfztVOqEcnUtQ2', 50, 1, '2018-04-29 16:14:40', NULL, 'dr. Irawan', NULL);
INSERT INTO `tb_user` VALUES (9, 'richard', '$2y$10$T0LhC2p2lY7zak7ORU6AEuvgpaibNEJSNbXhfBe112kYhnMKhVHdW', 50, 1, '2018-04-29 20:19:03', NULL, 'dr. H. Richard Alibasyah, MHA, Sp.OG', NULL);
INSERT INTO `tb_user` VALUES (10, 'novi', '$2y$10$7eslg2YYWCgY3BsUwVSdquUHSd388.JCx.XkiHOjVcHtIJ55PU1AG', 50, 1, '2018-04-29 20:20:03', NULL, 'dr. Noviani Rianda Tari, Sp. OG, M.Kes', NULL);
INSERT INTO `tb_user` VALUES (11, 'oksaja', '$2y$10$8I8vISlnd9xFdDf2qixYfOJfoa1PWyENEHcIQZqVq6OzoWL3HX48m', 50, 0, '2018-04-30 10:19:34', NULL, 'Contoh Dokter', NULL);

SET FOREIGN_KEY_CHECKS = 1;
