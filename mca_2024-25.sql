-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 05:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mca_2024-25`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `content`, `created_at`, `updated_at`) VALUES
(1, '<h2><span style=\"background-color:hsl(0, 0%, 100%);color:hsl(0, 0%, 0%);\"><strong>Why Choose Us</strong></span></h2><p>Our cosmetic website offers premium, cruelty-free products at competitive prices, backed by expert advice and positive customer reviews. With a user-friendly interface, secure payments, fast shipping, and a rewarding loyalty program, we ensure a satisfying and ethical shopping experience.</p><h3 style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\"><img class=\"image_resized\" style=\"width:42px;\" src=\"http://localhost/beauty%20and%20cosmetics/guestuser/images/truck.svg\" alt=\"Image\"><span style=\"color:hsl(0, 0%, 0%);\">Fast &amp; Free Shipping</span></h3><p style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\">Enjoy fast and free shipping on all orders, ensuring your favorite cosmetics reach you quickly without any extra cost.</p><h3 style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\"><img class=\"image_resized\" style=\"width:42px;\" src=\"http://localhost/beauty%20and%20cosmetics/guestuser/images/bag.svg\" alt=\"Image\"><span style=\"color:hsl(0, 0%, 0%);\">Easy to Shop</span></h3><p style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\">Shopping with us is easy and intuitive, with a seamless interface that makes finding and purchasing your favorite products a breeze.</p><h3 style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\"><img class=\"image_resized\" style=\"width:43px;\" src=\"http://localhost/beauty%20and%20cosmetics/guestuser/images/support.svg\" alt=\"Image\"><span style=\"color:hsl(0, 0%, 0%);\">24/7 Support</span></h3><p style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\">We\'re here for you around the clock with 24/7 customer support, ready to assist whenever you need help.</p><h3 style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\"><img class=\"image_resized\" style=\"width:38px;\" src=\"http://localhost/beauty%20and%20cosmetics/guestuser/images/return.svg\" alt=\"Image\"><span style=\"color:hsl(0, 0%, 0%);\">Hassle Free Returns</span></h3><p style=\"margin-left:calc(-.5 * var(--bs-gutter-x));\">Enjoy peace of mind with our free returns policy, making it easy to shop confidently knowing you can return products hassle-free.</p>', '2024-10-21 23:27:24', '2024-10-21 23:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) UNSIGNED NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `delivery_address`, `email`, `created_at`) VALUES
(8, 'shruti vachhnai<br>rk university<br>kasturbadham<br>rajkot-360001<br>Gujarat<br>India<br>Mobile: 9874563210<br>Email: vachhanishruti2003@gmail.com', 'guest@example.com', '2024-11-28 11:42:39'),
(27, 'nirali nandaniya<br>rk university<br>kasturbadham<br>rajkot-360020<br>Gujarat<br>India<br>Mobile: 9887767321<br>Email::nirali1@gmail.com', 'vachhanishruti2003@gmail.com', '2024-11-28 12:52:44'),
(32, 'shruti vachhnai<br>rk university<br>kasturbadham<br>rajkot-360001<br>Gujarat<br>India<br>Mobile: 9874563210<br>Email:vachhanishruti2003@gmail.com', 'vachhanishruti2003@gmail.com', '2024-12-03 13:20:13'),
(33, 'user<br>rk university<br>kasturbadham<br>Rajkot-360001<br>Gujarat<br>India<br>Mobile: 9874563210<br>Email:user123@gmail.com', 'user123@gmail.com', '2024-12-15 16:31:49'),
(34, 'user2<br>rk university<br>near tramba<br>rajkot-360001<br>Gujarat<br>India<br>Mobile: 9887767321<br>Email:user123@gmail.com', 'user123@gmail.com', '2024-12-15 16:33:33');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `image`, `price`, `description`, `quantity`, `added_at`, `product_id`, `email`) VALUES
(78, 0, '', '', '', '', 1, '2024-12-15 16:06:56', 4, '0');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'shruti', 'frutivachhani123@gmail.com', 'order detail', 'where is my order reached', '2024-10-22 03:14:47'),
(2, 'nirali nandaniya', 'nandaniyanirali1@gmail.com', 'abc', 'xyz', '2024-10-22 03:20:01'),
(3, 'PK', 'fvachhani311@rku.ac.in', 'vilaa', 'SSS', '2024-10-22 05:03:58'),
(4, 'PK', 'fvachhani311@rku.ac.in', 'vilaa', 'SSS', '2024-10-22 05:04:59'),
(5, 'shruti vachhani', 'dc@gmail.com', 'SE', 'SF', '2024-10-22 05:05:16'),
(6, 'shruti vachhani', 'dc@gmail.com', 'SE', 'SF', '2024-10-22 05:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `hero_section`
--

CREATE TABLE `hero_section` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `payment_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(50) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `sub_order_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_status` enum('Ordered','Shipped','Delivered','Return','Replaced') NOT NULL DEFAULT 'Ordered',
  `payment_status` enum('Pending','Completed','Failed') NOT NULL DEFAULT 'Pending',
  `payment_mode` enum('cod','online') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `sub_order_id`, `product_id`, `quantity`, `rating`, `review`, `email`, `delivery_address`, `total_amount`, `delivery_status`, `payment_status`, `payment_mode`, `created_at`, `updated_at`) VALUES
(18, 'order_PXWEwBTAQJxDQy', 'order_PXWEwBTAQJxDQy-5', 5, 1, NULL, NULL, 'user123@gmail.com', 'user<br>rk university<br>kasturbadham<br>Rajkot-360001<br>Gujarat<br>India<br>Mobile: 9874563210<br>Email:user123@gmail.com', 195.02, 'Ordered', 'Pending', 'cod', '2024-12-15 22:02:32', '2024-12-15 22:02:32'),
(19, 'order_675f04e558315', 'order_675f04e558315-2', 2, 1, NULL, NULL, 'user123@gmail.com', 'user2<br>rk university<br>near tramba<br>rajkot-360001<br>Gujarat<br>India<br>Mobile: 9887767321<br>Email:user123@gmail.com', 1000.00, 'Ordered', 'Pending', '', '2024-12-15 22:03:41', '2024-12-15 22:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `password_token`
--

CREATE TABLE `password_token` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_token`
--

INSERT INTO `password_token` (`id`, `email`, `otp`, `created_at`, `expires_at`) VALUES
(1, 'fvachhani311@rku.ac.in', 465342, '2024-10-21 18:53:48', '2024-10-21 19:03:48'),
(5, 'janki.kansagra@rku.ac.in', 403625, '2024-10-22 10:40:19', '2024-10-22 10:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `discount` int(20) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `quantity` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`, `discount`, `updated_at`, `status`, `quantity`) VALUES
(1, 'Lipstick', 'Waterproof Aric Lipstick', 500.00, 'images/product1.png', '2024-10-21 17:12:32', 5, NULL, 'Active', 0),
(2, 'Foundation', 'Skin Tone based foundation', 1000.00, 'images/product2.png', '2024-10-21 17:13:53', 20, NULL, 'Active', 7),
(3, 'Nail paint', 'Hot Pink Nail Paint ', 100.00, 'images/product4.png', '2024-10-21 17:14:35', 2, NULL, 'Inactive', 3),
(4, 'Perfume', 'Chanel Perfume with long lasting smell', 2000.00, 'images/product5.png', '2024-10-21 17:15:07', 15, NULL, 'Active', 4),
(5, 'Mascara', 'Waterproof mascara', 199.00, 'images/product7.png', '2024-10-21 17:15:36', 2, NULL, 'Active', 0),
(8, 'Skin Cream', 'Makes skin softer and shinner and protect from sun', 699.00, 'images/product9.png', '2024-10-21 17:18:26', 5, NULL, 'Active', 0),
(14, 'Renee Face gloss', 'RENEE’s Face Gloss coats your skin in a natural radiance like the reflection of light on the surface of clear water.', 2569.00, 'images/product11.png', '2024-10-22 12:27:14', 17, NULL, 'Active', 5),
(15, 'MARS EYELINER', 'Waterproof Eyeliner that stays for 24 hours', 200.00, 'images/product12.png', '2024-11-29 04:23:25', 10, NULL, 'Inactive', 0);

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gender` char(10) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` char(10) DEFAULT 'Normal',
  `status` char(10) DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `fullname`, `email`, `password`, `address`, `gender`, `mobile_number`, `profile_picture`, `role`, `status`) VALUES
(6, 'admin', 'admin@gmail.com', 'admin123', 'unknown', 'Female', '9807654321', '6717236e27418resume.jpg', 'Normal', 'Inactive'),
(16, 'jk', 'janki.kansagra@rku.ac.in', 'jk1212', 'rjt', 'Female', '9988776655', '67175e0adcce3person-1.png', 'Normal', 'Active'),
(19, 'nirali', 'nnandaniya206@rku.ac.in', 'nn12', 'ksd', 'Female', '9898989898', '671794c91dd518b9326b4c5fa25daa0b539a5a9328852.jpg', 'Normal', 'Inactive'),
(20, 'nirali', 'nandaniyanirali1@gmail.com', 'nirali12', 'ksd', 'Female', '9898989898', '6717950cd328bwallpaper.jpg', 'Normal', 'Active'),
(21, 'shruti v', 'vachhanishruti2003@gmail.com', 'vs123', 'Rajkot', 'Female', '9874563210', 'untitled (6).png', 'Normal', 'Active'),
(22, 'user', 'user123@gmail.com', 'user123', 'RK University, Rajkot', 'Female', '9874561230', 'image.png', 'Normal', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Fast & Free Shipping', 'Enjoy fast and free shipping on all orders, ensuring your favorite cosmetics reach you quickly without any extra cost.', 'https://www.flaticon.com/free-icon/fast-delivery_4212257', '2024-10-21 18:21:17', '2024-10-21 18:21:17'),
(2, 'Easy to Shop', 'Shopping with us is easy and intuitive, with a seamless interface that makes finding and purchasing your favorite products a breeze.', 'https://www.flaticon.com/free-icon/shopping-bag_10252905?term=shop+bag&page=1&position=9&origin=search&related_id=10252905', '2024-10-21 18:31:47', '2024-10-21 18:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(48, 22, 5, '2024-12-15 16:30:57'),
(49, 22, 2, '2024-12-15 16:32:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_section`
--
ALTER TABLE `hero_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_token`
--
ALTER TABLE `password_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hero_section`
--
ALTER TABLE `hero_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `password_token`
--
ALTER TABLE `password_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
