-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 05, 2024 lúc 12:04 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `exercise18.1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL,
  `country` varchar(191) NOT NULL,
  `zip` varchar(191) NOT NULL,
  `telephone` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Vợt cầu lông', '2024-06-18 21:03:39', '2024-09-04 22:30:48'),
(2, 'Áo cầu lông', '2024-06-18 21:03:39', '2024-09-04 23:03:11'),
(3, 'Quần cầu lông', '2024-06-18 21:03:39', '2024-09-04 23:03:20'),
(4, 'giày cầu lông', '2024-06-18 21:03:39', '2024-09-04 23:03:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_06_04_010123_create_addresses_table', 1),
(5, '2024_06_04_011558_create_categories_table', 1),
(6, '2024_06_04_012233_create_products_table', 1),
(7, '2024_06_04_013720_create_orders_table', 1),
(8, '2024_06_04_015729_create_reviews_table', 1),
(9, '2024_06_04_020134_create_shopping_carts_table', 1),
(10, '2024_06_04_020541_create_stocks_table', 1),
(11, '2024_06_04_023438_create_wishlists_table', 1),
(12, '2024_06_04_030132_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `note` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `stock_id`, `quantity`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, 'completed', '2024-06-18 21:03:39', NULL),
(2, 21, 1, 2, NULL, 'completed', '2024-06-18 21:03:39', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `deal_id` int(10) UNSIGNED DEFAULT NULL,
  `photo` varchar(191) NOT NULL,
  `brand` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `details` varchar(191) NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `user_id`, `category_id`, `deal_id`, `photo`, `brand`, `name`, `description`, `details`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, '[\"100zz.jpg\",\"100zz.jpg\",\"100zz.jpg\",\"100zz.jpg\"]', 'Victor', 'Vợt Yonex Astrox 100ZZ', 'Sản phẩm cam kết chính hãng', 'These are the product details!', 18000000, '2024-06-18 21:03:39', '2024-09-04 22:51:22'),
(3, 1, 4, NULL, '[\"kumpoo-2s.jpg\",\r\n\"kumpoo-2s.jpg\",\r\n\"kumpoo-2s.jpg\",\r\n\"kumpoo-2s.jpg\"]', 'Kumpoo', 'Giày Kumpoo KH-E72S', 'Giúp người chơi cầu lông linh hoạt trên sân đấu, hạn chế tối đa chấn thương.', '', 1550000, NULL, '2024-09-04 22:45:10'),
(4, 1, 4, NULL, '[\"Kumpoo KH-D83.jpg\",\"Kumpoo KH-D83.jpg\",\"Kumpoo KH-D83.jpg\",\"Kumpoo KH-D83.jpg\"]', 'Kumpoo', 'Giày Kumpoo KH-D83', 'Màu sắc bắt mắt mà độ êm ái đôi giày đem đến cho người sử dụng cũng rất cao.', '', 1350000, NULL, '2024-07-05 06:02:58'),
(5, 1, 3, NULL, '[\"quan4.jpg\",\r\n\"quan4.jpg\",\r\n\"quan4.jpg\",\r\n\"quan4.jpg\"]', 'Yonex', 'Quần Yonex 9225 - Vàng', 'Vải thoáng mát, phù hợp với mọi lứa tuổi.', '', 110000, NULL, NULL),
(6, 1, 3, NULL, '[\"quan5.jpg\",\r\n\"quan5.jpg\",\r\n\"quan5.jpg\",\r\n\"quan5.jpg\"]', 'Yonex\r\n', 'Quần Yonex 959 - Đỏ', 'Vải thoáng mát, phù hợp với mọi lứa tuổi.', '', 130000, NULL, NULL),
(7, 1, 2, NULL, '[\"ao2.jpg\",\r\n\"ao2.jpg\",\r\n\"ao2.jpg\",\r\n\"ao2.jpg\"]', 'Yonex', 'Áo Yonex VM1056 nam', 'sản phẩm quần áo thể thao nhờ có độ bền, khả năng thoáng khí và thân thiện với làn da.', '', 140000, NULL, NULL),
(8, 1, 2, NULL, '[\"ao3.jpg\",\r\n\"ao3.jpg\",\r\n\"ao3.jpg\",\r\n\"ao3.jpg\"]', 'Yonex', 'Áo Yonex AHV02 VM1055 nam', 'Các họa tiết hình khối mạnh mẽ, có phần gai góc trên áo giúp người chơi tăng cao sức mạnh đáng kể, thu hút mọi ánh nhìn của các lông thủ.', '', 0, NULL, NULL),
(9, 1, 1, NULL, '[\"1000z.jpg\",\r\n\"1000z.jpg\",\r\n\"1000z.jpg\",\"1000z.jpg\"]', 'Yonex', 'Vợt Yonex Nanoflare 1000Z', 'Với thiết kế head-light, Yonex Nanoflare 1000Z mang lại sự nhẹ nhàng và linh hoạt trong mỗi cú đánh. Trọng lượng nhẹ giúp bạn xoay chuyển vợt một cách nhanh chóng và dễ dàng.', '', 4300000, NULL, NULL),
(10, 1, 4, NULL, '[\"KH-E87.jpg\",\r\n\"KH-E87.jpg\",\r\n\"KH-E87.jpg\",\r\n\"KH-E87.jpg\"]', 'Kumpoo', 'Giày Kumpoo KH-E87 Xanh', 'Giày có màu sắc năng động, thiết kế có độ bền cao, form giày chuẩn', '', 1300000, NULL, NULL),
(11, 1, 4, NULL, '[\"KH-D43.jpg\",\r\n\"KH-D43.jpg\",\r\n\"KH-D43.jpg\",\"KH-D43.jpg\"]', 'Kumpoo\r\n', 'Giày Kumpoo KH-D43 Đen', 'Mẫu giày mới được ra mắt, thuộc phân khúc giày giá rẻ nhưng vẫn được hãng Kumpoo trang bị công nghệ êm ái đảm bảo trải nghiệm tốt nhất cho khách hàng.', '', 890000, NULL, NULL),
(12, 1, 2, NULL, '[\"áo1.jpg\",\r\n\"áo1.jpg\",\r\n\"áo1.jpg\",\"áo1.jpg\"]', 'Lining', 'Áo Lining Nam - Đen Cam', 'Mẫu áo chuyển nhiệt tức là in nhiệt hẳn hoàn toàn màu sắc và thiết kế lên trên chiếc áo trơn.', '', 160000, NULL, NULL),
(13, 1, 2, NULL, '[\"áo2.jpg\",\r\n\"áo2.jpg\",\r\n\"áo2.jpg\",\"áo2.jpg\"]', 'Lining', 'Áo Lining Nam - Xanh Hồng', 'Dùng vải tổng hợp cao cấp có cấu tạo chủ yếu từ polyester cho độ thông thoáng, thấm hút tốt.', '', 0, NULL, NULL),
(14, 1, 3, NULL, '[\"quan1.jpg\",\r\n\"quan1.jpg\",\r\n\"quan1.jpg\",\"quan1.jpg\"]', 'Lining', 'Quần Lining - Đen Vàng', 'sản phẩm thích hợp cho các bạn yêu mến bộ môn cầu lông có thể sử dụng để chơi cầu lông, đi chơi và đi du lịch.', '', 130000, NULL, NULL),
(15, 1, 3, NULL, '[\"quan6.jpg\",\r\n\"quan6.jpg\",\r\n\"quan6.jpg\",\"quan6.jpg\"]', 'Lining', 'Quần Lining Q21 nam - Trắng', 'sản phẩm thích hợp cho các bạn yêu mến bộ môn cầu lông có thể sử dụng để chơi cầu lông, đi chơi và đi du lịch.', '', 130000, NULL, NULL),
(16, 1, 3, NULL, '[\"quan3.jpg\",\r\n\"quan3.jpg\",\r\n\"quan3.jpg\",\"quan3.jpg\"]', 'Lining', 'Quần Lining Nam Đen', 'Giúp người chơi thoải mái trong lúc thi đấu mà còn tăng sự đẳng cấp nổi bật lên cá tính riêng biệt của mỗi người.', '', 124000, NULL, '2024-07-05 22:07:47'),
(17, 1, 4, NULL, '[\"KH-E75.jpg\",\n\"KH-E75.jpg\",\n\"KH-E75.jpg\",\"KH-E75.jpg\"]', 'Kumpoo', 'Giày Kumpoo KH-E75 Hồng', 'Đế cao su được thiết kế tỉ mỉ kết hợp cùng công nghệ Hiện Đại cho độ bám sân siêu tốt.', '', 1150000, NULL, '2024-07-05 22:07:33'),
(18, 1, 4, NULL, '[\"KH-G76.jpg\",\"KH-G76.jpg\",\"KH-G76.jpg\",\"KH-G76.jpg\"]', 'Kumpoo', 'Giày Kumpoo KH-G76 Xám', 'Phần trên của giày được trang bị lớp vải MESH thoáng khí, êm chân đan xen lớp TPU chống thấm, bền bỉ và cứng cáp để giữ form giày.', '', 1480000, NULL, NULL),
(36, 1, 1, NULL, '[\"enma.jpg\",\"enma.jpg\",\"enma.jpg\",\"enma.jpg\"]', 'Victor', 'Vợt Victor - Enma', 'Cam kết chính hãng', '', 3900000, '2024-06-18 21:03:39', '2024-09-04 22:50:18'),
(37, 1, 1, NULL, '[\"Kitetsu.jpg\",\"Kitetsu.jpg\",\"Kitetsu.jpg\",\"Kitetsu.jpg\"]', 'Victor', 'Vợt Sandai Kitetsu', 'Cam kết chính hãng', '', 3900000, '2024-06-18 21:03:39', '2024-09-04 22:50:18'),
(38, 1, 1, NULL, '[\"Wado-Ichimonji.jpg\",\"Wado-Ichimonji.jpg\",\"Wado-Ichimonji.jpg\",\"Wado-Ichimonji.jpg\"]', 'Victor', 'Vợt Wado Ichimonji', 'Cam kết chính hãng', 'These are the product details', 3900000, '2024-06-18 21:03:39', '2024-09-04 22:50:18'),
(39, 1, 2, NULL, '[\"ao4.jpg\",\r\n\"ao4.jpg\",\r\n\"ao4.jpg\",\"ao4.jpg\"]', 'Kumpoo', 'Áo Kumpoo A449 - Trắng', 'Dùng vải tổng hợp cao cấp có cấu tạo chủ yếu từ polyester cho độ thông thoáng, thấm hút tốt.', '', 130000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `review` varchar(191) NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('HUJahv9vmrDQsSS6pQJYkdVIe6mxy7eggDZUw2CC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmZRM2VEQVNKcWF0Ym9xTUJZVGJ2dFpWb1VMQzdObDRIUW81RzdneCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1719679149),
('Q9sUz56OSs79FcrDEcGgkglOZuzMTvIQOVCnmWYN', NULL, '127.0.0.1', 'PostmanRuntime/7.39.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV29NMUcyaEprbENCTHBNeGlFSjBqZ2ZpSHFlZkY4VHBhRHdUVWpKTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1719849465);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shopping_carts`
--

CREATE TABLE `shopping_carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `stock_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `shopping_carts`
--

INSERT INTO `shopping_carts` (`id`, `user_id`, `stock_id`, `quantity`, `created_at`, `updated_at`) VALUES
(21, 2, 2, 1, '2024-07-01 08:02:38', '2024-07-01 08:02:38'),
(24, 1, 2, 4, '2024-07-04 20:05:10', '2024-07-04 23:31:16'),
(25, 1, 18, 1, '2024-07-05 22:06:50', '2024-07-05 22:06:50'),
(26, 1, 14, 1, '2024-07-05 22:08:08', '2024-07-05 22:08:08'),
(28, 3, 6, 1, '2024-09-04 06:39:36', '2024-09-04 06:39:36'),
(29, 3, 11, 1, '2024-09-04 06:39:44', '2024-09-04 06:39:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stocks`
--

CREATE TABLE `stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `size` varchar(191) NOT NULL,
  `color` varchar(191) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `size`, `color`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, '15.6\"', 'Black', 12, '2024-06-18 21:03:39', '2024-07-05 05:19:48'),
(3, 3, '15\"', 'Black', 10, NULL, NULL),
(4, 4, '18\"', 'Red', 15, NULL, NULL),
(5, 5, 'L', 'Black', 12, NULL, NULL),
(6, 6, '16\"', 'Pink', 20, NULL, NULL),
(7, 7, '20\"', 'Xám', 5, NULL, NULL),
(8, 8, '22\"', 'Black', 16, NULL, NULL),
(9, 9, '6\"', 'Hồng', 105, NULL, '2024-07-05 05:53:06'),
(11, 10, '6\"', 'Xanh', 20, NULL, NULL),
(12, 11, '8\"', 'Xanh', 15, NULL, NULL),
(13, 12, '5\"\r\n', 'Tím', 22, NULL, NULL),
(14, 13, '6\"', 'Vàng', 14, NULL, NULL),
(15, 14, '10.5\"', 'Xám', 25, NULL, NULL),
(16, 15, '11.0\"', 'Trắng', 5, NULL, NULL),
(17, 16, '12\"', 'Black', 9, NULL, NULL),
(18, 17, '11.5\"', 'Xám', 23, NULL, NULL),
(19, 18, 'L', 'Pink', 11, '2024-07-05 04:36:21', '2024-07-05 04:36:21'),
(20, 18, 'M', 'Black', 4, '2024-07-05 04:37:21', '2024-07-05 04:37:21'),
(26, 1, 'M', 'Pinkhh', 12, '2024-07-05 05:17:37', '2024-07-05 06:08:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'tune', 'tune2k4@gmail.com', '$2y$12$QF9k4Bl8J3k9xpHzAKXbA.sgdYwqFPSuT8Kv4/1.ufsZbqGtmt7FW', NULL, '2024-06-20 03:44:22', '2024-06-20 03:44:22'),
(2, NULL, 'tune2k', 'tune4@gmail.com', '$2y$12$eN2dNhYcyarPmDVg.X7ijOEpCBc0l7lmzscwYVVydU7wjsXbcWwWe', NULL, '2024-06-20 05:10:17', '2024-06-20 05:10:17'),
(3, NULL, 'Tune2', 'tune2@gmail.com', '$2y$12$LIyCKCdpTzcjIP69WiC3qOnQDdAHNWPrHXbU09cpa4BQFmtCF8lYG', NULL, '2024-09-04 06:31:35', '2024-09-04 06:31:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(96, 1, 2, '2024-07-05 03:36:05', '2024-07-05 03:36:05'),
(97, 1, 13, '2024-07-05 03:37:26', '2024-07-05 03:37:26'),
(98, 1, 24, '2024-07-05 22:11:26', '2024-07-05 22:11:26'),
(99, 1, 1, '2024-07-05 23:29:55', '2024-07-05 23:29:55'),
(101, 3, 6, '2024-09-04 07:24:33', '2024-09-04 07:24:33'),
(102, 3, 7, '2024-09-04 07:24:37', '2024-09-04 07:24:37'),
(103, 3, 8, '2024-09-04 07:25:29', '2024-09-04 07:25:29');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_stock_id_index` (`stock_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_user_id_index` (`user_id`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_deal_id_index` (`deal_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_index` (`product_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `shopping_carts`
--
ALTER TABLE `shopping_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shopping_carts_user_id_index` (`user_id`),
  ADD KEY `shopping_carts_stock_id_index` (`stock_id`);

--
-- Chỉ mục cho bảng `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stocks_product_id_index` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_index` (`role_id`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_index` (`user_id`),
  ADD KEY `wishlists_product_id_index` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shopping_carts`
--
ALTER TABLE `shopping_carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
