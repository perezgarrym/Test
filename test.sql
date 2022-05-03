/*
 Navicat Premium Data Transfer

 Source Server         : local mysql
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 03/05/2022 12:43:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `unit_price` float NULL DEFAULT NULL,
  `bulk_count` int(11) NULL DEFAULT NULL,
  `bulk_price` float NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  FULLTEXT INDEX `code_idx`(`code`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'A', 1.25, 3, 3, '2022-05-03 09:45:20', '2022-05-03 09:45:20');
INSERT INTO `products` VALUES (2, 'B', 4.25, NULL, NULL, '2022-05-03 09:45:34', '2022-05-03 09:45:34');
INSERT INTO `products` VALUES (3, 'C', 1, 6, 5, '2022-05-03 09:45:54', '2022-05-03 09:45:54');
INSERT INTO `products` VALUES (4, 'D', 0.75, NULL, NULL, '2022-05-03 09:46:15', '2022-05-03 09:46:15');

SET FOREIGN_KEY_CHECKS = 1;
