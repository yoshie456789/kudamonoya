-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2023 年 10 月 26 日 07:23
-- サーバのバージョン： 5.7.39
-- PHP のバージョン: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `kudamonoshop`
--
create database kudamonoya;
use kudamonoya;
-- --------------------------------------------------------

--
-- テーブルの構造 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `products`
--

INSERT INTO `products` (`id`, `product_name`, `stock`, `price`, `image`, `is_deleted`) VALUES
(2, '津軽産りんご', 43, '135.00', 'ringo.jpg', 0),
(3, '山形県産ラフランス', 40, '400.00', 'rahurannsu.jpg', 0),
(4, '茨城県産なし', 41, '120.00', 'nashi.jpg', 0),
(5, 'ナルト', 47, '90.00', 'ringo.jpg', 1),
(6, 'ソード', 27, '82.00', 'nashi.jpg', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `subtotal_taxed` decimal(10,2) NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `product_id`, `quantity`, `subtotal`, `subtotal_taxed`, `purchase_date`) VALUES
(15, 3, 2, 3, '405.00', '437.40', '2023-10-22 13:54:02'),
(16, 3, 3, 2, '800.00', '864.00', '2023-10-22 13:54:02'),
(17, 3, 4, 2, '240.00', '259.20', '2023-10-22 13:54:02'),
(18, 4, 2, 5, '675.00', '729.00', '2023-10-22 14:03:16'),
(19, 4, 3, 2, '800.00', '864.00', '2023-10-22 14:03:16'),
(20, 4, 4, 3, '360.00', '388.80', '2023-10-22 14:03:16'),
(21, 7, 2, 2, '270.00', '291.60', '2023-10-22 14:15:40'),
(22, 7, 3, 3, '1200.00', '1296.00', '2023-10-22 14:15:40'),
(23, 7, 4, 4, '480.00', '518.40', '2023-10-22 14:15:40'),
(24, 7, 5, 3, '270.00', '291.60', '2023-10-26 06:24:51'),
(25, 3, 6, 3, '246.00', '265.68', '2023-10-26 06:38:46');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `zip21` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `zip22` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `pref21` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `addr21` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `strt21` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `input_pass` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `option_choice` enum('チラシ','HP','新聞・雑誌','お友達からの紹介','街で見かけた','SNSで知った') CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `phone`, `zip21`, `zip22`, `pref21`, `addr21`, `strt21`, `email`, `input_pass`, `option_choice`) VALUES
(3, 'シンタニ', '$2y$10$x1wFpWf2sDUWNh4w2HwkHOnAL0ffW5Ez.XipCnZ4LTu85kDSh0Ab.', '神谷完一', '0184615144', '030', '8570', '青森県', '青森市', '長島9-4-3', 'sintani-kaniti@anet.ne.jp', NULL, 'お友達からの紹介'),
(4, 'キムラ', '$2y$10$535a5dwq9.usCHbHK6MPH.3j34yHl5LILMUCddT/M5vn1BsW9Gs7m', '木村望', '09070238656', '330', '9301', '埼玉県', 'さいたま市浦和区', '高砂ノースコート三根106', 'kmr9108106@anet.ne.jp', NULL, '街で見かけた'),
(6, 'suga', '$2y$10$GhDo9xIzKmDoLre7xsT9U.Xgn1VwCszyf7yfzhTkLNt2xmRhUM.KW', '菅健生', '09034248656', '160', '0007', '東京都', '新宿区', '荒木町1-15-9', 'takeo.suga@users.gr.jp', NULL, '新聞・雑誌'),
(7, 'まえたに', '$2y$10$HpJCfJUwJRhJFQNw.B2L4uH0W/DzqaLA.6xXXu4FRoKXs//1dBO0u', '前谷由佳利', '0980730029', '060', '8588', '北海道', '札幌市中央区', '北三条西マルシオ105', 'maetani_117@example.ne.jp', NULL, 'HP');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- テーブルの AUTO_INCREMENT `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
