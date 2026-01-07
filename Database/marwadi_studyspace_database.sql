-- Marwadi StudySpace Database Schema
-- Complete database creation script

-- Create database
CREATE DATABASE IF NOT EXISTS `marwadi_studyspace` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `marwadi_studyspace`;

-- ============================================
-- Table: admin
-- Stores admin login credentials
-- ============================================
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default admin (username: admin, password: admin123)
INSERT INTO `admin` (`admin_id`, `password`) VALUES
('admin', 'admin123');

-- ============================================
-- Table: user
-- Stores all user information
-- ============================================
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `en_num` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Table: doubts
-- Stores all questions posted by users
-- ============================================
CREATE TABLE IF NOT EXISTS `doubts` (
  `doubt_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` varchar(10000) NOT NULL,
  PRIMARY KEY (`doubt_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Table: answer
-- Stores all answers to questions
-- ============================================
CREATE TABLE IF NOT EXISTS `answer` (
  `ans_id` int(10) NOT NULL AUTO_INCREMENT,
  `doubt_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `answer` varchar(10000) NOT NULL,
  PRIMARY KEY (`ans_id`),
  KEY `doubt_id` (`doubt_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Table: comments
-- Stores comments on answers
-- ============================================
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `ans_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `comment` varchar(10000) NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `ans_id` (`ans_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Table: bookmarks
-- Stores user bookmarked questions
-- ============================================
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `bookmark_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `doubt_id` int(10) NOT NULL,
  PRIMARY KEY (`bookmark_id`),
  KEY `user_id` (`user_id`),
  KEY `doubt_id` (`doubt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Complete! Database created successfully
-- ============================================
