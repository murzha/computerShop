-- phpMyAdmin SQL Dump
-- Database structure for computer shop

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `computer_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `computer_shop`;

-- Categories table - Stores product categories with hierarchical structure
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Category name',
  `alias` varchar(100) NOT NULL COMMENT 'URL-friendly category name',
  `parent_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Parent category ID for hierarchical structure',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Product categories hierarchy';

-- Brand table - Stores product manufacturers
CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT 'Brand name',
  `alias` varchar(255) NOT NULL COMMENT 'URL-friendly brand name',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Product manufacturers';

-- Specification dictionary - Stores possible product specifications
CREATE TABLE IF NOT EXISTS `specification` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Specification name',
  `alias` varchar(100) NOT NULL COMMENT 'URL-friendly specification name',
  `data_type` enum('string','integer','float','enum') NOT NULL COMMENT 'Data type for validation',
  `unit` varchar(20) DEFAULT NULL COMMENT 'Measurement unit (GB, MHz, etc)',
  `possible_values` text DEFAULT NULL COMMENT 'Comma-separated list of possible values for enum type',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Product specifications dictionary';

-- Category specifications - Links specifications to categories
CREATE TABLE IF NOT EXISTS `category_specification` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(10) UNSIGNED NOT NULL,
  `specification_id` int(10) UNSIGNED NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Whether specification is mandatory',
  `order_position` int NOT NULL DEFAULT 0 COMMENT 'Display order in category',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_spec` (`category_id`, `specification_id`),
  KEY `specification_id` (`specification_id`),
  CONSTRAINT `category_specification_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_specification_ibfk_2` FOREIGN KEY (`specification_id`) REFERENCES `specification` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Links between categories and their specifications';

-- Product table - Main product information
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL COMMENT 'Product name',
  `alias` varchar(255) NOT NULL COMMENT 'URL-friendly product name',
  `content` text DEFAULT NULL COMMENT 'Detailed product description',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `old_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Price before discount',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Product visibility status',
  `keywords` varchar(255) DEFAULT NULL COMMENT 'SEO keywords',
  `description` varchar(255) DEFAULT NULL COMMENT 'SEO description',
  `img` varchar(255) NOT NULL DEFAULT 'default_product_image.jpg',
  `hit` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Popular product marker',
  `advertise` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Show in advertisements',
  `ad_description` text DEFAULT NULL COMMENT 'Advertisement description',
  `ad_img` varchar(255) DEFAULT NULL COMMENT 'Advertisement image',
  `product_type` enum('desktop','laptop','component','peripheral') NOT NULL DEFAULT 'component',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `hit` (`hit`),
  KEY `brand_id` (`brand_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_brand_fk` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Main product information';

-- Product specification values - Stores actual specification values for products
CREATE TABLE IF NOT EXISTS `product_specification_value` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `specification_id` int(10) UNSIGNED NOT NULL,
  `value` text NOT NULL COMMENT 'Specification value',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `specification_id` (`specification_id`),
  CONSTRAINT `product_specification_value_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_specification_value_ibfk_2` FOREIGN KEY (`specification_id`) REFERENCES `specification` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Product specification values';

-- Gallery table - Product images
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `img` varchar(255) NOT NULL COMMENT 'Image filename',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Product image gallery';

-- Order table - Customer orders
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Customer name',
  `user_email` varchar(255) NOT NULL COMMENT 'Customer email',
  `address` varchar(255) NOT NULL COMMENT 'Delivery address',
  `status` enum('new','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'new' COMMENT 'Order status',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Order creation date',
  `update_at` timestamp NULL DEFAULT NULL COMMENT 'Last status update',
  `note` text DEFAULT NULL COMMENT 'Additional order notes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Customer orders';

-- Order product table - Products in orders
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL COMMENT 'Number of items ordered',
  `title` varchar(255) NOT NULL COMMENT 'Product name at time of order',
  `price` decimal(10,2) NOT NULL COMMENT 'Price at time of order',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Products in customer orders';

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Add indexes for faster search and filtering
ALTER TABLE `product`
  ADD INDEX `status_hit` (`status`, `hit`),
  ADD INDEX `price` (`price`),
  ADD INDEX `product_type` (`product_type`);

ALTER TABLE `product_specification_value`
  ADD INDEX `value` (`value`(100)),
  ADD UNIQUE INDEX `product_spec` (`product_id`, `specification_id`);

ALTER TABLE `order`
  ADD INDEX `status_date` (`status`, `date`),
  ADD INDEX `user_email` (`user_email`);

ALTER TABLE `specification`
  ADD INDEX `data_type` (`data_type`);
