/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80021
 Source Host           : localhost:3306
 Source Schema         : unit_test

 Target Server Type    : MySQL
 Target Server Version : 80021
 File Encoding         : 65001

 Date: 21/05/2023 17:36:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for __prefix__component
-- ----------------------------
DROP TABLE IF EXISTS `__prefix__component`;
CREATE TABLE `__prefix__component`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '标题',
  `component_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '组件代码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '组件' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for __prefix__component_config
-- ----------------------------
DROP TABLE IF EXISTS `__prefix__component_config`;
CREATE TABLE `__prefix__component_config`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `is_disabled` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否禁用',
  `component_id` bigint UNSIGNED NOT NULL COMMENT '组件ID',
  `provider_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '供应商代码',
  `provider_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '供应商名称',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '标题',
  `config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL COMMENT '配置数据',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '组件配置' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for __prefix__component_setting
-- ----------------------------
DROP TABLE IF EXISTS `__prefix__component_setting`;
CREATE TABLE `__prefix__component_setting`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_time` datetime(0) NULL DEFAULT NULL,
  `update_time` datetime(0) NULL DEFAULT NULL,
  `component_id` bigint UNSIGNED NOT NULL COMMENT '组件ID',
  `component_config_id` bigint UNSIGNED NOT NULL COMMENT '组件配置ID',
  `app_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '应用名',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '组件设置' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
