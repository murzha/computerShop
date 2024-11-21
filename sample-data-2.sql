-- Sample data for computer shop database
USE `computer_shop`;

-- Insert categories
INSERT INTO `categories` (`name`, `alias`, `parent_id`) VALUES
('Computers', 'computers', NULL),
('Components', 'components', NULL),
('Peripherals', 'peripherals', NULL);

-- Insert subcategories
INSERT INTO `categories` (`name`, `alias`, `parent_id`) 
SELECT 'Desktop Computers', 'desktop-computers', id FROM categories WHERE alias = 'computers'
UNION ALL
SELECT 'Gaming Laptops', 'gaming-laptops', id FROM categories WHERE alias = 'computers'
UNION ALL
SELECT 'Business Laptops', 'business-laptops', id FROM categories WHERE alias = 'computers'
UNION ALL
SELECT 'Processors', 'processors', id FROM categories WHERE alias = 'components'
UNION ALL
SELECT 'Motherboards', 'motherboards', id FROM categories WHERE alias = 'components'
UNION ALL
SELECT 'Graphics Cards', 'graphics-cards', id FROM categories WHERE alias = 'components'
UNION ALL
SELECT 'RAM', 'ram', id FROM categories WHERE alias = 'components'
UNION ALL
SELECT 'Storage Devices', 'storage', id FROM categories WHERE alias = 'components'
UNION ALL
SELECT 'Power Supplies', 'power-supplies', id FROM categories WHERE alias = 'components'
UNION ALL
SELECT 'Computer Cases', 'cases', id FROM categories WHERE alias = 'components'
UNION ALL
SELECT 'Gaming Monitors', 'gaming-monitors', id FROM categories WHERE alias = 'peripherals'
UNION ALL
SELECT 'Office Monitors', 'office-monitors', id FROM categories WHERE alias = 'peripherals'
UNION ALL
SELECT 'Gaming Keyboards', 'gaming-keyboards', id FROM categories WHERE alias = 'peripherals'
UNION ALL
SELECT 'Gaming Mice', 'gaming-mice', id FROM categories WHERE alias = 'peripherals'
UNION ALL
SELECT 'Gaming Headsets', 'gaming-headsets', id FROM categories WHERE alias = 'peripherals';

-- Insert brands
INSERT INTO `brand` (`title`, `alias`) VALUES
('Intel', 'intel'),
('AMD', 'amd'),
('NVIDIA', 'nvidia'),
('ASUS', 'asus'),
('MSI', 'msi'),
('Gigabyte', 'gigabyte'),
('ASRock', 'asrock'),
('Corsair', 'corsair'),
('Dell', 'dell'),
('HP', 'hp'),
('Lenovo', 'lenovo'),
('Razer', 'razer'),
('SteelSeries', 'steelseries'),
('Samsung', 'samsung'),
('LG', 'lg');

-- Insert specifications
INSERT INTO `specification` (`name`, `alias`, `data_type`, `unit`, `possible_values`) VALUES
('Processor Model', 'processor', 'string', NULL, NULL),
('RAM Amount', 'ram_amount', 'integer', 'GB', NULL),
('RAM Type', 'ram_type', 'enum', NULL, 'DDR4,DDR5'),
('Storage Type', 'storage_type', 'enum', NULL, 'HDD,SSD,NVMe'),
('Storage Capacity', 'storage_capacity', 'integer', 'GB', NULL),
('Graphics Card', 'graphics_card', 'string', NULL, NULL),
('Power Supply', 'power_supply', 'integer', 'W', NULL),
('Form Factor', 'form_factor', 'enum', NULL, 'ATX,Micro-ATX,Mini-ITX'),
('Screen Size', 'screen_size', 'float', 'inch', NULL),
('Resolution', 'resolution', 'string', NULL, NULL),
('Refresh Rate', 'refresh_rate', 'integer', 'Hz', NULL),
('Switch Type', 'switch_type', 'enum', NULL, 'Mechanical,Membrane,Optical'),
('Wireless', 'wireless', 'enum', NULL, 'Yes,No'),
('RGB Lighting', 'rgb_lighting', 'enum', NULL, 'Yes,No'),
('Battery Life', 'battery_life', 'integer', 'hours', NULL);

-- Link specifications to categories
-- Desktop computers specifications
INSERT INTO `category_specification` (`category_id`, `specification_id`, `is_required`, `order_position`)
SELECT 
    c.id,
    s.id,
    1,
    (@row_num := @row_num + 1) AS position
FROM categories c, specification s, (SELECT @row_num := 0) r
WHERE c.alias = 'desktop-computers' 
AND s.alias IN ('processor', 'ram_amount', 'ram_type', 'storage_type', 'storage_capacity', 'graphics_card', 'power_supply', 'form_factor');

-- Gaming and business laptops specifications
SET @row_num := 0;
INSERT INTO `category_specification` (`category_id`, `specification_id`, `is_required`, `order_position`)
SELECT 
    c.id,
    s.id,
    1,
    (@row_num := @row_num + 1) AS position
FROM categories c, specification s
WHERE c.alias IN ('gaming-laptops', 'business-laptops')
AND s.alias IN ('processor', 'ram_amount', 'ram_type', 'storage_type', 'storage_capacity', 'graphics_card', 'screen_size', 'resolution', 'battery_life');

-- Gaming monitors specifications
SET @row_num := 0;
INSERT INTO `category_specification` (`category_id`, `specification_id`, `is_required`, `order_position`)
SELECT 
    c.id,
    s.id,
    1,
    (@row_num := @row_num + 1) AS position
FROM categories c, specification s
WHERE c.alias = 'gaming-monitors'
AND s.alias IN ('screen_size', 'resolution', 'refresh_rate');

-- Gaming keyboards specifications
SET @row_num := 0;
INSERT INTO `category_specification` (`category_id`, `specification_id`, `is_required`, `order_position`)
SELECT 
    c.id,
    s.id,
    1,
    (@row_num := @row_num + 1) AS position
FROM categories c, specification s
WHERE c.alias = 'gaming-keyboards'
AND s.alias IN ('switch_type', 'wireless', 'rgb_lighting');

-- Insert gaming desktop products
INSERT INTO `product` (`brand_id`, `category_id`, `title`, `alias`, `content`, `price`, `old_price`, `status`, `keywords`, `description`, `img`, `hit`, `advertise`, `product_type`, `ad_description`) VALUES
-- Gaming Desktops
((SELECT id FROM brand WHERE alias = 'asus'), 
 (SELECT id FROM categories WHERE alias = 'desktop-computers'),
 'ASUS ROG Strix G35',
 'asus-rog-strix-g35',
 'Premium gaming desktop featuring the latest generation processors and graphics for maximum gaming performance',
 2499.99,
 2799.99,
 '1',
 'gaming pc, asus rog, gaming desktop',
 'High-end gaming desktop with RTX 4080',
 'rog_strix_g35.jpg',
 '1',
 '1',
 'desktop',
 'Experience next-gen gaming with the ROG Strix G35'),

((SELECT id FROM brand WHERE alias = 'msi'),
 (SELECT id FROM categories WHERE alias = 'desktop-computers'),
 'MSI MEG Aegis Ti5',
 'msi-meg-aegis-ti5',
 'Flagship gaming desktop with unique design and powerful components',
 3299.99,
 3499.99,
 '1',
 'gaming pc, msi, high performance',
 'Premium gaming desktop with RTX 4090',
 'msi_aegis_ti5.jpg',
 '1',
 '1',
 'desktop',
 'Unleash ultimate gaming power'),

-- Gaming Laptops
((SELECT id FROM brand WHERE alias = 'asus'),
 (SELECT id FROM categories WHERE alias = 'gaming-laptops'),
 'ASUS ROG Zephyrus G14',
 'asus-rog-zephyrus-g14',
 'Compact yet powerful gaming laptop with amazing battery life',
 1699.99,
 1899.99,
 '1',
 'gaming laptop, portable gaming',
 '14-inch gaming laptop with RTX 4060',
 'zephyrus_g14.jpg',
 '1',
 '1',
 'laptop',
 'Power meets portability'),

((SELECT id FROM brand WHERE alias = 'lenovo'),
 (SELECT id FROM categories WHERE alias = 'gaming-laptops'),
 'Lenovo Legion Pro 7i',
 'lenovo-legion-pro-7i',
 'Professional grade gaming laptop with advanced cooling system',
 2199.99,
 2399.99,
 '1',
 'gaming laptop, lenovo legion',
 '16-inch gaming laptop with RTX 4070',
 'legion_pro_7i.jpg',
 '1',
 '0',
 'laptop',
 NULL),

-- Business Laptops
((SELECT id FROM brand WHERE alias = 'dell'),
 (SELECT id FROM categories WHERE alias = 'business-laptops'),
 'Dell XPS 15',
 'dell-xps-15',
 'Premium business laptop with stunning display and powerful performance',
 1999.99,
 2199.99,
 '1',
 'business laptop, dell xps',
 '15-inch business laptop with OLED display',
 'xps_15.jpg',
 '1',
 '1',
 'laptop',
 'The ultimate business companion'),

-- Gaming Monitors
((SELECT id FROM brand WHERE alias = 'lg'),
 (SELECT id FROM categories WHERE alias = 'gaming-monitors'),
 'LG UltraGear 27GP950',
 'lg-ultragear-27gp950',
 '4K gaming monitor with 144Hz refresh rate and G-Sync compatibility',
 899.99,
 999.99,
 '1',
 'gaming monitor, 4k, high refresh rate',
 '27-inch 4K gaming monitor',
 'lg_27gp950.jpg',
 '1',
 '1',
 'peripheral',
 'Ultimate gaming visual experience'),

-- Gaming Peripherals
((SELECT id FROM brand WHERE alias = 'razer'),
 (SELECT id FROM categories WHERE alias = 'gaming-keyboards'),
 'Razer BlackWidow V4 Pro',
 'razer-blackwidow-v4-pro',
 'Premium mechanical gaming keyboard with optical switches',
 229.99,
 249.99,
 '1',
 'gaming keyboard, mechanical, rgb',
 'Mechanical gaming keyboard with macro keys',
 'blackwidow_v4.jpg',
 '1',
 '0',
 'peripheral',
 NULL);

-- Insert product specifications
INSERT INTO `product_specification_value` (`product_id`, `specification_id`, `value`) VALUES
-- ASUS ROG Strix G35 specs
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'),
 (SELECT id FROM specification WHERE alias = 'processor'),
 'Intel Core i9-13900K'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'),
 (SELECT id FROM specification WHERE alias = 'ram_amount'),
 '64'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'),
 (SELECT id FROM specification WHERE alias = 'ram_type'),
 'DDR5'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'),
 (SELECT id FROM specification WHERE alias = 'storage_type'),
 'NVMe'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'),
 (SELECT id FROM specification WHERE alias = 'storage_capacity'),
 '2000'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'),
 (SELECT id FROM specification WHERE alias = 'graphics_card'),
 'NVIDIA GeForce RTX 4080 16GB'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'),
 (SELECT id FROM specification WHERE alias = 'power_supply'),
 '1000'),

-- ASUS ROG Zephyrus G14 specs
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'processor'),
 'AMD Ryzen 9 7940HS'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'ram_amount'),
 '32'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'storage_type'),
 'NVMe'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'storage_capacity'),
 '1000'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'graphics_card'),
 'NVIDIA GeForce RTX 4060 8GB'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'screen_size'),
 '14'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'resolution'),
 '2560x1600'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'),
 (SELECT id FROM specification WHERE alias = 'battery_life'),
 '10');

-- Insert gallery images
INSERT INTO `gallery` (`product_id`, `img`) VALUES
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'), 'rog_strix_g35_1.jpg'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'), 'rog_strix_g35_2.jpg'),
((SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'), 'rog_strix_g35_3.jpg'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'), 'zephyrus_g14_1.jpg'),
((SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'), 'zephyrus_g14_2.jpg'),
((SELECT id FROM product WHERE alias = 'lg-ultragear-27gp950'), 'lg_27gp950_1.jpg'),
((SELECT id FROM product WHERE alias = 'lg-ultragear-27gp950'), 'lg_27gp950_2.jpg');

-- Insert sample orders
INSERT INTO `order` (`name`, `user_email`, `address`, `status`, `date`, `note`) VALUES
('John Smith', 'john.smith@email.com', '123 Main St, New York, NY 10001', 'processing', NOW(), 'Please deliver during business hours'),
('Mary Johnson', 'mary.j@email.com', '456 Oak Ave, Los Angeles, CA 90001', 'new', NOW(), NULL),
('Robert Wilson', 'robert.w@email.com', '789 Pine Rd, Chicago, IL 60601', 'shipped', NOW(), 'Leave with doorman');

-- Insert order products
INSERT INTO `order_product` (`order_id`, `product_id`, `quantity`, `title`, `price`) VALUES
(1, (SELECT id FROM product WHERE alias = 'asus-rog-strix-g35'), 1, 'ASUS ROG Strix G35', 2499.99),
(1, (SELECT id FROM product WHERE alias = 'lg-ultragear-27gp950'), 1, 'LG UltraGear 27GP950', 899.99),
(2, (SELECT id FROM product WHERE alias = 'asus-rog-zephyrus-g14'), 1, 'ASUS ROG Zephyrus G14', 1699.99),
(3, (SELECT id FROM product WHERE alias = 'razer-blackwidow-v4-pro'), 2, 'Razer BlackWidow V4 Pro', 229.99);

COMMIT;