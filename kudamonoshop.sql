-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2023 年 10 月 19 日 12:26
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
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `products`
--

INSERT INTO `products` (`id`, `product_name`, `stock`, `price`, `image`) VALUES
(2, '津軽産りんご', 28, '135.00', 'ringo.jpg'),
(3, '山形県産ラフランス', 27, '400.00', 'rahurannsu.jpg'),
(4, '茨城県産なし', 42, '120.00', 'nashi.jpg');

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
(1, 2, 2, 3, '405.00', '437.40', '2023-10-17 13:49:59'),
(2, 2, 3, 2, '800.00', '864.00', '2023-10-17 13:49:59'),
(3, 2, 2, 2, '270.00', '291.60', '2023-10-17 13:58:48'),
(4, 2, 3, 3, '1200.00', '1296.00', '2023-10-17 13:58:48'),
(5, 2, 4, 5, '600.00', '648.00', '2023-10-17 13:58:48'),
(6, 2, 2, 3, '405.00', '437.40', '2023-10-18 16:02:57'),
(7, 2, 3, 2, '800.00', '864.00', '2023-10-18 16:02:57'),
(8, 2, 4, 5, '600.00', '648.00', '2023-10-18 16:02:57'),
(9, 2, 2, 2, '270.00', '291.60', '2023-10-18 16:12:26'),
(10, 2, 3, 3, '1200.00', '1296.00', '2023-10-18 16:12:26'),
(11, 2, 4, 5, '600.00', '648.00', '2023-10-18 16:12:26'),
(12, 2, 2, 2, '270.00', '291.60', '2023-10-18 16:41:28'),
(13, 2, 3, 3, '1200.00', '1296.00', '2023-10-18 16:41:28'),
(14, 2, 4, 3, '360.00', '388.80', '2023-10-18 16:41:28');

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
(2, 'さるまた', '$2y$10$41CDWn/4L7ujoVfs8qOq1.0o0UodyIjSE.zzL8fOPXzvTaElYWa0y', 'さる', '0112314111', '060', '8588', '北海道', '札幌市中央区', '北三条西', 'yoshie456789@gmail.com', NULL, 'チラシ');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- テーブルの AUTO_INCREMENT `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
