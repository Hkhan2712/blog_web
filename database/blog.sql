-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 11:06 AM
-- Server version: 8.0.42-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `path`) VALUES
(1, 'Technology', 'technology', 'Sharing about technology and programming.', '/technology'),
(2, 'Entertainment', 'entertainment', 'News about movies, music, and celebrities.', '/entertainment'),
(3, 'Sports', 'sports', 'Latest updates on sports events.', '/sports'),
(4, 'Travel', 'travel', 'Guides and travel experiences.', '/travel'),
(5, 'Food', 'food', 'Vietnamese and international cuisine.', '/food'),
(6, 'Health', 'health', 'Information about health and wellness.', '/health'),
(7, 'Education', 'education', 'Knowledge and educational news.', '/education'),
(8, 'Fashion', 'fashion', 'Latest fashion trends and styles.', '/fashion'),
(9, 'Business', 'business', 'Business news and startup ideas.', '/business'),
(10, 'Science', 'science', 'Discover scientific breakthroughs.', '/science');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `like_quantity` bigint UNSIGNED NOT NULL DEFAULT '0',
  `child_comment_quantity` bigint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint UNSIGNED primary key AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `entity_id` bigint UNSIGNED NOT NULL,
  `entity_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `content` text NOT NULL,
  `excerpt` varchar(500) DEFAULT NULL,
  `status` enum('draft','published','pending','archived') DEFAULT 'draft',
  `image_url` varchar(255) DEFAULT NULL,
  `view_count` int DEFAULT '0',
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `like_quantity` bigint UNSIGNED NOT NULL DEFAULT '0',
  `comment_quantity` bigint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `category_id`, `title`, `slug`, `content`, `excerpt`, `status`, `image_url`, `view_count`, `published_at`, `created_at`, `updated_at`, `like_quantity`, `comment_quantity`) VALUES
(6, 1, 1, 'The Rise of Artificial Intelligence', 'rise-of-artificial-intelligence', '<p>The past decade has seen <b>Artificial Intelligence (AI)</b> transition from the realm of science fiction to an integral part of our daily lives. From personalized recommendations on streaming platforms to sophisticated medical diagnostics, AI\'s influence is pervasive and ever-expanding.</p>\r\n\r\n<p>This rise is fueled by several factors: the exponential growth of data, advancements in computational power, and the development of more refined algorithms. <b>Machine learning</b>, a subset of AI, has been particularly transformative, enabling systems to learn from data and improve performance without explicit programming. <b>Deep learning</b>, inspired by the structure and function of the human brain, has further propelled AI\'s capabilities, leading to breakthroughs in areas like image recognition, natural language processing, and autonomous systems.</p>\r\n\r\n<p>As AI continues to evolve, it presents both immense opportunities and significant challenges. While it promises to revolutionize industries, enhance productivity, and solve complex global issues, concerns regarding job displacement, ethical implications, and algorithmic bias require careful consideration. The ongoing development of <b>explainable AI (XAI)</b> and <b>responsible AI</b> practices is crucial to ensure that these powerful technologies are developed and deployed for the benefit of all.</p>', 'A brief look at how AI is changing industries.', 'published', '1.jpg', 120, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(7, 3, 2, 'Top 10 Movies of 2025', 'top-10-movies-2025', 'Detailed reviews and analysis...', 'Must-watch movies this year!', 'published', '4.jpg', 340, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(8, 5, 3, 'Champions League Highlights', 'champions-league-highlights', 'Recap of last night’s epic match...', 'The best moments from the finals.', 'published', '5.jpg', 500, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(9, 1, 4, 'Exploring Vietnam’s Hidden Gems', 'exploring-vietnams-hidden-gems', 'Travel guide to less-known destinations in Vietnam...', 'Uncover amazing travel spots!', 'published', '6.jpg', 210, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(10, 3, 5, 'The Future of Vegan Cuisine', 'future-of-vegan-cuisine', 'Interview with leading vegan chefs...', 'Discover new vegan trends.', 'published', '2.jpg', 180, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(11, 5, 6, '5 Tips for a Healthy Mind', '5-tips-for-a-healthy-mind', 'Simple practices to improve mental wellness...', 'Healthy mind, healthy life.', 'published', '7.jpg', 275, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(12, 1, 7, 'How to Study More Effectively', 'how-to-study-more-effectively', 'Techniques backed by research...', 'Maximize your learning.', 'published', 'https://example.com/images/education.jpg', 300, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(13, 3, 8, 'Street Style Trends of 2025', 'street-style-trends-2025', 'Fashion icons share their favorite looks...', 'Be on-trend this year.', 'published', 'https://example.com/images/fashion.jpg', 145, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(14, 5, 9, '5 Startup Ideas for Young Entrepreneurs', '5-startup-ideas-young-entrepreneurs', 'Opportunities for new businesses in 2025...', 'Start building your dream.', 'published', 'https://example.com/images/business.jpg', 410, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0),
(15, 5, 10, 'Top Discoveries in Modern Science', 'top-discoveries-modern-science', 'Exciting scientific breakthroughs explained...', 'Stay informed with science.', 'published', 'https://example.com/images/science.jpg', 380, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-11 18:22:01', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `id` bigint NOT NULL,
  `post_id` bigint NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint NOT NULL,
  `post_id` bigint NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`id`, `post_id`, `tag_id`) VALUES
(1, 15, 17),
(2, 14, 17),
(3, 12, 8),
(4, 15, 18),
(5, 14, 6),
(6, 9, 12),
(7, 13, 11),
(8, 6, 2),
(9, 6, 17),
(10, 11, 25);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `reporter_id` bigint NOT NULL,
  `target_type` enum('post','comment','user') NOT NULL,
  `target_id` int NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator of Blog Website', '2025-06-04 09:33:08', '2025-06-04 09:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`) VALUES
(1, 'Lifestyle', 'lifestyle'),
(2, 'Self Improvement', 'self-improvement'),
(3, 'Productivity', 'productivity'),
(4, 'Mindfulness', 'mindfulness'),
(5, 'Mental Health', 'mental-health'),
(6, 'Work-Life Balance', 'work-life-balance'),
(7, 'Personal Finance', 'personal-finance'),
(8, 'Relationships', 'relationships'),
(9, 'Parenting', 'parenting'),
(10, 'Travel Tips', 'travel-tips'),
(11, 'Adventure', 'adventure'),
(12, 'Photography', 'photography'),
(13, 'Nature', 'nature'),
(14, 'Wildlife', 'wildlife'),
(15, 'Environment', 'environment'),
(16, 'Climate Change', 'climate-change'),
(17, 'Sustainability', 'sustainability'),
(18, 'Eco-Friendly', 'eco-friendly'),
(19, 'Forests', 'forests'),
(20, 'Oceans', 'oceans'),
(21, 'Mountains', 'mountains'),
(22, 'Rivers', 'rivers'),
(23, 'Wildlife Conservation', 'wildlife-conservation'),
(24, 'Green Energy', 'green-energy'),
(25, 'Organic Farming', 'organic-farming'),
(26, 'Gardening', 'gardening'),
(27, 'Hiking', 'hiking'),
(28, 'Camping', 'camping'),
(29, 'Astronomy', 'astronomy'),
(30, 'Natural Wonders', 'natural-wonders'),
(31, 'Startup', 'startup'),
(32, 'Big Data', 'big-data'),
(33, 'Internet of Things', 'internet-of-things'),
(34, 'Augmented Reality', 'augmented-reality'),
(35, 'Virtual Reality', 'virtual-reality'),
(36, '5G Technology', '5g-technology'),
(37, 'E-Commerce', 'e-commerce'),
(38, 'Digital Marketing', 'digital-marketing'),
(39, 'SEO', 'seo'),
(40, 'FinTech', 'fintech'),
(41, 'DevOps', 'devops'),
(42, 'Agile', 'agile'),
(43, 'Software Testing', 'software-testing'),
(44, 'Game Development', 'game-development'),
(45, 'Python', 'python'),
(46, 'JavaScript', 'javascript'),
(47, 'TypeScript', 'typescript'),
(48, 'React', 'react'),
(49, 'Vue.js', 'vue-js'),
(50, 'Node.js', 'node-js'),
(51, 'Django', 'django'),
(52, 'Flask', 'flask'),
(53, 'GitHub', 'github'),
(54, 'APIs', 'apis'),
(55, 'Open Source', 'open-source'),
(56, 'Artificial General Intelligence', 'artificial-general-intelligence'),
(57, 'Natural Language Processing', 'natural-language-processing'),
(58, 'Quantum Computing', 'quantum-computing'),
(59, 'Remote Work', 'remote-work'),
(60, 'Freelancing', 'freelancing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` varchar(255) NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'user',
  `display_name` varchar(100) DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `bio` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email`, `status`, `role`, `display_name`, `firstname`, `lastname`, `avatar_url`, `bio`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@gmail.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-10 10:26:21', '2025-06-10 10:26:21', 1),
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-10 10:28:35', '2025-06-10 10:28:35', 1),
(5, 'user2', '7e58d63b60197ceb55a1c487989a3720', 'user2@gmail.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-10 10:33:01', '2025-06-10 10:33:01', 1),
(6, 'hkhan2712', 'bd49aa2a4ad6a1f8eabe4883d9ceed7d', 'kitnguyn2712@gmail.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-11 05:07:50', '2025-06-11 05:07:50', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `path` (`path`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`user_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reporter_id` (`reporter_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
