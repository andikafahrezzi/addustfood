-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2026 at 03:10 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_addustfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`, `date`) VALUES
(1, 'admin', '$2y$10$mI/hpZ59vGgjs/lPTQWLJu.I82O93AEJ3gwFycAjuibOjAGi9dcTm', 'admin123@gmail.com', '2021-02-26 16:24:50'),
(2, 'dika', '$2y$19$/6bQxltF3Xf8C0sgIzlFau38BLk83lTJNJPtycGOIi08YmZ8tbEh.', 'dika@gmail.com', '2024-10-03 11:17:44');

-- --------------------------------------------------------

--
-- Table structure for table `dishesh`
--

CREATE TABLE `dishesh` (
  `d_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `about` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dishesh`
--

INSERT INTO `dishesh` (`d_id`, `r_id`, `name`, `about`, `price`, `img`) VALUES
(1, 0, 'soescoklat', 'enak mantape', 50000, 'suscoklat.jpeg'),
(2, 0, 'Kue Soes', 'Kue Soes coklat yang enak dan bergizie', 50000, 'suscoklat.jpeg'),
(3, 3, 'Kue Nastar', 'enak', 50000, 'nastar.jpeg'),
(4, 0, 'Mie Ayam', 'Wenake', 25000, 'bolukukus.jpeg'),
(5, 2, 'Kue Lapis', 'Kue Lapis yang enak dan mantap', 5000, 'kuelapis.jpg'),
(6, 2, 'Kue Dadar Gulung', 'Kue Dadar Gulung yang enak dan mantap', 5000, 'kuedadargulung.jpg'),
(7, 2, 'Kue Cucur', 'Kue Cucur yang enak dan mantap', 5000, 'Kuecucur.jpeg'),
(8, 2, 'Martabak', 'Martabak yang enak dan mantap', 5000, 'Martabak.jpeg'),
(9, 4, 'Gudeg Jogja', 'Gudeg Jogja yang enak dan mantap', 15000, 'gudeg.jpg'),
(10, 4, 'Rendang Sapi', 'Rendang Sapi yang enak dan mantap', 15000, 'rendang.jpg'),
(11, 4, 'Ayam rica-rica', 'Ayam rica-rica Khas Manado yang enak dan mantap', 15000, 'Ayamricarica.jpeg'),
(12, 4, 'Rawon Jawa Timur', 'Rawon Khas Jawa Timur yang enak dan mantap', 15000, 'RawonJawaTimur.jpeg'),
(13, 4, 'Ayam Betutu', 'Ayam Betutu yang enak dan mantap', 15000, 'AyamBetutu.jpeg'),
(14, 4, 'Sate Ayam', 'Sate Ayam yang enak dan mantap', 15000, 'sateayam.jpg'),
(15, 8, 'Gurame Bakar', 'Gurame Bakar yang enak dan mantap', 15000, 'Guramebakar.jpeg'),
(16, 4, 'Nasi Goreng', 'Nasi Goreng yang enak dan mantap', 15000, 'nasigor.jpg'),
(17, 4, 'Steak', 'Steak daging sapi yang enak dan mantap', 15000, 'stkkk.jpg'),
(18, 3, 'Onde-Onde', 'Onde-Onde yang sangat enak dan mantap', 5000, 'Onde-Onde.jpeg'),
(19, 3, 'Lanting', 'Lanting yang sangat enak dan mantap', 5000, 'lanting.jpg'),
(20, 3, 'Keripik Pisang', 'Keripik Pisang yang sangat enak dan mantap', 5000, 'keripikpisang.jpeg'),
(21, 3, 'Keripik Tempe', 'Keripik Tempe yang gurih dan enak', 5000, 'keripiktempe.jpg'),
(22, 3, 'Kentang Goreng', 'Kentang Goreng yang gurih dan enak', 15000, 'ffries.jpg'),
(23, 3, 'Bakso', 'Bakso yang gurih dan enak', 15000, 'bakso.jpg'),
(24, 8, 'Putri Salju', 'stock habis', 50000, 'putrisalju.jpeg'),
(25, 1, 'Nastar', 'Nastar yang enak dan bergizi', 50000, 'Nastar.jpeg'),
(26, 1, 'Lidah Kucing', 'Lidah Kucing yang enak dan bergizi', 50000, 'lidahkucing.jpeg'),
(27, 1, 'Kastaangle', 'Kastaangle yang enak dan bergizi', 50000, 'kastangle.jpeg'),
(33, 1, 'a', 'a', 50, 'ffries1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `display`
--

CREATE TABLE `display` (
  `di_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `about` varchar(200) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `display`
--

INSERT INTO `display` (`di_id`, `name`, `price`, `about`, `image`) VALUES
(1, 'soescoklata', 50000, 'enak mantap', 'suscoklat.jpeg'),
(2, 'Kentang Goreng', 25000, 'Wenak', 'ffries.jpg'),
(3, 'Nasi Goreng', 25000, 'Wenak', 'nasigor.jpg'),
(4, 'Mie Ayam', 25000, 'Wenak', 'Mieayam.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_status` varchar(30) DEFAULT 'pending',
  `gross_amount` decimal(12,2) DEFAULT 0.00,
  `snap_token` text DEFAULT NULL,
  `snap_redirect_url` text DEFAULT NULL,
  `midtrans_order_id` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `fraud_status` varchar(30) DEFAULT NULL,
  `transaction_time` datetime DEFAULT NULL,
  `settlement_time` datetime DEFAULT NULL,
  `expiry_time` datetime DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_number`, `payment_method`, `transaction_status`, `gross_amount`, `snap_token`, `snap_redirect_url`, `midtrans_order_id`, `transaction_id`, `payment_type`, `fraud_status`, `transaction_time`, `settlement_time`, `expiry_time`, `paid_at`, `created_at`, `updated_at`) VALUES
(4, 'ORD-20260727-A22B49', 'Credit Card', 'pending', '215000.00', 'bced6f5a-fc22-4448-a667-ba4bce9caa45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-27 11:35:38', '2026-07-27 13:02:37'),
(5, 'ORD-20260727-3F327F', 'Cash', 'pending', '20000.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-27 13:03:00', '2026-07-27 13:03:00'),
(6, 'ORD-20260727-5EA9E5', 'Cash', 'pending', '5000.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-27 13:04:37', '2026-07-27 13:04:37'),
(7, 'ORD-20260727-8EC239', 'Cash', 'pending', '30000.00', '0f524d82-d762-4b2a-ab0c-eb959e4c2537', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-27 13:04:56', '2026-07-27 13:07:38');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `r_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `o_hr` varchar(255) NOT NULL,
  `c_hr` varchar(255) NOT NULL,
  `o_days` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`r_id`, `c_id`, `name`, `email`, `phone`, `url`, `o_hr`, `c_hr`, `o_days`, `address`, `img`) VALUES
(1, 5, 'Kue Kering', 'kelompok6@gmail.com', '0876876876876', 'www.addustcorp.site', '8am', '7pm', 'mon-sat', 'Menyediakan Kue Kering untuk kita semua', 'kering.jpeg'),
(2, 8, 'Kue Basah', 'kelompok6@gmail.com', '0876876876876', 'www.tkfajarnusantara.site', '8am', '8pm', 'mon-sat', 'Menyediakan Kue Basah untuk kita semua', 'basah.jpg'),
(3, 9, 'Makanan Ringan', 'kelompok6@gmail.com', '0876876876876', 'www.tkfajarnusantara.site', '8am', '8pm', 'mon-sat', 'Menyediakan Makanan Ringan untuk kita semua', 'displayringan.jpg'),
(4, 9, 'Makanan Berat', 'Kelompok6@gmail.com', '0876876876876', 'www.tkfajarnusantara.site', '8am', '8pm', 'mon-sat', 'Menyediakan Makanan Berat untuk kita semua', 'berat.png'),
(8, 11, 'Stock Tidak Tersedia', 'habis@gmail.com', '080000000', 'habis.com', '11am', '8pm', '24hr-x7', 'Makanan Sedang Tidak Tersedia / Telah habis. Silahkan Cek kembali nanti', 'habis.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `res_category`
--

CREATE TABLE `res_category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `res_category`
--

INSERT INTO `res_category` (`c_id`, `c_name`) VALUES
(5, 'kering'),
(8, 'Basah'),
(9, 'Ringan'),
(10, 'Berat'),
(11, 'Habis');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `username`, `f_name`, `l_name`, `email`, `phone`, `password`, `address`) VALUES
(37, 'tgegs', 'qwrw', 'wew', 'a@gmail.com', '0822449879', '$2y$10$N4N5nGJAzpysqePbDC3K4OWYAyklXqWMtcgQJPer3DcTOqXXcjBVa', 'eewffw'),
(39, 'axxxx', 'aaaa', 'aaaa', 'b@gmail.com', '0211100324', '$2y$10$48yvQ2vJgWcICXoWNuQawOYAsH0EVd8tQf.gfPZMydmCCRuhUdBIC', 'dqdwdqq'),
(40, 'aaaaa', 'asep', 'wantep', 'asix@gmail.com', '0819153241', '$2y$10$2YR9mSU9TAu2IeW6ehWHYeL8eLvWyB/f6gpROFoC11s4ikwjZ830S', 'Jalan jalan'),
(41, 'user1', 'user', 'user', 'user@gmail.com', '0825145623', '$2y$10$oK00F.otbrKt9y0xzXTMHefj/v7pQoAYXzIl3laMVWiG4.j.ZQILC', 'aaaaaaa'),
(42, 'user2', 'Basir', 'Jenggo', 'basirjenggo@gmail.com', '8135684252', '$2y$10$Tw5bBfbXnHY.4dmmSX5Y6.n5G.H92xc/iPPLugqQqv88oKGCechjW', 'Jalan Utama untuk mendapatkan nilai A. No 012'),
(45, 'dika1', 'a', 'c', 'pahrulmaji@gmail.com', '0815615151', '$2y$10$64emCzuEFgVFp2ElQ4Nr7.nvcRTVMyoXpk/i76PbagKTAnxDWn.sG', 'vdvvdvsv');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `o_id` int(11) NOT NULL,
  `order_number` varchar(30) NOT NULL,
  `u_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL,
  `d_name` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `price` float NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `success-date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `r_id` int(11) NOT NULL,
  `payment_mode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`o_id`, `order_number`, `u_id`, `d_id`, `d_name`, `quantity`, `price`, `status`, `date`, `success-date`, `r_id`, `payment_mode`) VALUES
(154, 'ORD-20260727-A22B49', 41, 19, 'Lanting', 3, 15000, 'closed', '2026-07-27 13:35:38', '2026-07-27 11:38:24', 3, 'Credit Card'),
(155, 'ORD-20260727-A22B49', 41, 27, 'Kastaangle', 4, 200000, 'closed', '2026-07-27 13:35:38', '2026-07-27 11:38:20', 1, 'Credit Card'),
(156, 'ORD-20260727-3F327F', 41, 7, 'Kue Cucur', 1, 5000, 'closed', '2026-07-27 15:02:59', '2026-07-27 13:03:19', 2, 'Cash'),
(157, 'ORD-20260727-3F327F', 41, 13, 'Ayam Betutu', 1, 15000, 'closed', '2026-07-27 15:02:59', '2026-07-27 13:03:15', 4, 'Cash'),
(158, 'ORD-20260727-5EA9E5', 41, 19, 'Lanting', 1, 5000, 'closed', '2026-07-27 15:04:37', '2026-07-27 13:05:10', 3, 'Cash'),
(159, 'ORD-20260727-8EC239', 41, 11, 'Ayam rica-rica', 1, 15000, 'closed', '2026-07-27 15:04:56', '2026-07-27 13:05:14', 4, 'Cash'),
(160, 'ORD-20260727-8EC239', 41, 9, 'Gudeg Jogja', 1, 15000, 'closed', '2026-07-27 15:04:56', '2026-07-27 13:05:17', 4, 'Cash');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `dishesh`
--
ALTER TABLE `dishesh`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `display`
--
ALTER TABLE `display`
  ADD PRIMARY KEY (`di_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `uk_order_number` (`order_number`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `res_category`
--
ALTER TABLE `res_category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `uq_users_username` (`username`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `idx_order_number` (`order_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dishesh`
--
ALTER TABLE `dishesh`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `res_category`
--
ALTER TABLE `res_category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`order_number`) REFERENCES `user_orders` (`order_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
