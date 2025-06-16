-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2025 at 10:02 AM
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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `like_quantity`, `child_comment_quantity`, `created_at`, `updated_at`, `path`, `parent_id`) VALUES
(27, 7, 6, 'Amazing AI!!!', 0, 0, '2025-06-16 05:02:36', '2025-06-16 05:02:36', NULL, NULL),
(28, 3, 18, 'Hoi An is amazing place!!!', 2, 0, '2025-06-16 01:38:29', '2025-06-16 01:38:29', NULL, NULL),
(29, 3, 8, 'This season is so exciting!', 0, 0, '2025-06-16 01:40:19', '2025-06-16 01:40:19', NULL, NULL),
(30, 5, 18, 'I love Vietnam!!!', 3, 0, '2025-06-16 02:19:47', '2025-06-16 02:19:47', NULL, NULL),
(31, 1, 42, 'delicious!!', 0, 0, '2025-06-16 03:54:33', '2025-06-16 03:54:33', NULL, NULL),
(32, 1, 41, 'amazing', 0, 0, '2025-06-16 04:21:06', '2025-06-16 04:21:06', NULL, NULL),
(33, 26, 42, 'top 1', 0, 0, '2025-06-16 04:31:55', '2025-06-16 04:31:55', NULL, NULL),
(34, 5, 14, 'Yooo', 0, 0, '2025-06-16 04:48:41', '2025-06-16 04:48:41', NULL, NULL),
(35, 5, 53, 'feelinggg', 2, 0, '2025-06-16 04:50:59', '2025-06-16 04:50:59', NULL, NULL),
(36, 5, 15, 'amazing', 0, 0, '2025-06-16 05:00:04', '2025-06-16 05:00:04', NULL, NULL),
(37, 7, 18, 'I will come soon!!', 3, 0, '2025-06-16 05:00:41', '2025-06-16 05:00:41', NULL, NULL),
(38, 10, 18, 'that right', 0, 0, '2025-06-15 19:17:22', '2025-06-15 19:17:22', NULL, NULL),
(39, 21, 18, 'maybe I will come Hoi An next month', 0, 0, '2025-06-15 19:20:19', '2025-06-15 19:20:19', NULL, NULL),
(40, 22, 18, 'could someone tell me more info about Hoi An trip ??', 1, 0, '2025-06-15 19:21:38', '2025-06-15 19:21:38', NULL, NULL),
(41, 23, 18, 'omg, why I dont know this place !!!', 1, 0, '2025-06-15 19:22:32', '2025-06-15 19:22:32', NULL, NULL),
(42, 24, 18, 'that is my hometown@@@', 1, 0, '2025-06-15 19:23:39', '2025-06-15 19:23:39', NULL, NULL),
(43, 25, 18, 'Come Hoi An experience call me zl: 1234243543', 0, 0, '2025-06-15 19:25:30', '2025-06-15 19:25:30', NULL, NULL),
(44, 26, 18, 'I have came it, what a beautiful city!!!', 0, 0, '2025-06-15 19:26:23', '2025-06-15 19:26:23', NULL, NULL),
(45, 26, 18, 'yo, welcome to Hoi An', 0, 0, '2025-06-15 19:26:48', '2025-06-15 19:26:48', NULL, NULL),
(46, 26, 43, 'helpful', 0, 0, '2025-06-15 19:30:55', '2025-06-15 19:30:55', NULL, NULL),
(47, 26, 53, 'tomorrowland :)))', 0, 0, '2025-06-15 19:46:10', '2025-06-15 19:46:10', NULL, NULL),
(48, 7, 7, 'have you ever watch Titanic??', 1, 0, '2025-06-15 20:26:03', '2025-06-15 20:26:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `entity_id` bigint UNSIGNED NOT NULL,
  `entity_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `entity_id`, `entity_type`, `created_at`, `updated_at`) VALUES
(16, 3, 6, 'post', '2025-06-14 18:17:42', '2025-06-14 18:17:42'),
(17, 3, 7, 'post', '2025-06-14 18:18:03', '2025-06-14 18:18:03'),
(18, 3, 8, 'post', '2025-06-14 18:18:12', '2025-06-14 18:18:12'),
(19, 3, 9, 'post', '2025-06-14 18:20:44', '2025-06-14 18:20:44'),
(20, 3, 11, 'post', '2025-06-14 18:20:53', '2025-06-14 18:20:53'),
(21, 3, 15, 'post', '2025-06-14 18:22:04', '2025-06-14 18:22:04'),
(22, 3, 13, 'post', '2025-06-14 18:22:28', '2025-06-14 18:22:28'),
(23, 3, 14, 'post', '2025-06-14 18:24:00', '2025-06-14 18:24:00'),
(24, 3, 12, 'post', '2025-06-14 18:24:45', '2025-06-14 18:24:45'),
(25, 1, 6, 'post', '2025-06-14 18:25:20', '2025-06-14 18:25:20'),
(26, 5, 6, 'post', '2025-06-14 18:36:01', '2025-06-14 18:36:01'),
(27, 5, 7, 'post', '2025-06-14 18:37:49', '2025-06-14 18:37:49'),
(28, 1, 8, 'post', '2025-06-14 18:40:19', '2025-06-14 18:40:19'),
(29, 1, 9, 'post', '2025-06-14 19:58:37', '2025-06-14 19:58:37'),
(30, 1, 11, 'post', '2025-06-14 20:11:51', '2025-06-14 20:11:51'),
(31, 1, 18, 'post', '2025-06-15 00:37:09', '2025-06-15 00:37:09'),
(32, 5, 18, 'post', '2025-06-15 00:38:17', '2025-06-15 00:38:17'),
(33, 3, 18, 'post', '2025-06-15 00:39:29', '2025-06-15 00:39:29'),
(34, 5, 15, 'post', '2025-06-15 00:57:44', '2025-06-15 00:57:44'),
(35, 5, 14, 'post', '2025-06-15 00:59:51', '2025-06-15 00:59:51'),
(36, 7, 18, 'post', '2025-06-15 01:17:43', '2025-06-15 01:17:43'),
(37, 7, 12, 'post', '2025-06-15 04:30:49', '2025-06-15 04:30:49'),
(38, 26, 18, 'post', '2025-06-16 03:48:48', '2025-06-16 03:48:48'),
(39, 1, 49, 'post', '2025-06-16 03:51:15', '2025-06-16 03:51:15'),
(40, 1, 42, 'post', '2025-06-16 03:54:09', '2025-06-16 03:54:09'),
(41, 1, 15, 'post', '2025-06-16 04:19:43', '2025-06-16 04:19:43'),
(42, 1, 14, 'post', '2025-06-16 04:19:51', '2025-06-16 04:19:51'),
(43, 1, 13, 'post', '2025-06-16 04:20:02', '2025-06-16 04:20:02'),
(44, 1, 52, 'post', '2025-06-16 04:20:50', '2025-06-16 04:20:50'),
(45, 26, 42, 'post', '2025-06-16 04:31:44', '2025-06-16 04:31:44'),
(46, 26, 49, 'post', '2025-06-16 04:37:09', '2025-06-16 04:37:09'),
(47, 5, 35, 'comment', '2025-06-16 04:53:58', '2025-06-16 04:53:58'),
(48, 5, 30, 'comment', '2025-06-16 04:57:22', '2025-06-16 04:57:22'),
(49, 5, 28, 'comment', '2025-06-16 04:57:53', '2025-06-16 04:57:53'),
(50, 7, 30, 'comment', '2025-06-16 05:00:44', '2025-06-16 05:00:44'),
(51, 5, 37, 'comment', '2025-06-15 18:29:42', '2025-06-15 18:29:42'),
(52, 21, 37, 'comment', '2025-06-15 18:49:19', '2025-06-15 18:49:19'),
(53, 21, 30, 'comment', '2025-06-15 19:14:01', '2025-06-15 19:14:01'),
(54, 21, 18, 'post', '2025-06-15 19:19:32', '2025-06-15 19:19:32'),
(55, 22, 18, 'post', '2025-06-15 19:20:46', '2025-06-15 19:20:46'),
(56, 24, 18, 'post', '2025-06-15 19:23:49', '2025-06-15 19:23:49'),
(57, 26, 43, 'post', '2025-06-15 19:30:57', '2025-06-15 19:30:57'),
(58, 26, 35, 'comment', '2025-06-15 19:46:14', '2025-06-15 19:46:14'),
(59, 26, 53, 'post', '2025-06-15 19:46:17', '2025-06-15 19:46:17'),
(60, 26, 37, 'comment', '2025-06-15 20:22:54', '2025-06-15 20:22:54'),
(61, 26, 28, 'comment', '2025-06-15 20:22:56', '2025-06-15 20:22:56'),
(62, 7, 7, 'post', '2025-06-15 20:38:18', '2025-06-15 20:38:18'),
(63, 7, 48, 'comment', '2025-06-15 20:38:55', '2025-06-15 20:38:55'),
(64, 7, 41, 'comment', '2025-06-15 21:32:22', '2025-06-15 21:32:22'),
(65, 7, 42, 'comment', '2025-06-15 21:43:55', '2025-06-15 21:43:55'),
(66, 7, 40, 'comment', '2025-06-15 21:44:26', '2025-06-15 21:44:26');

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
(6, 1, 1, 'The Rise of Artificial Intelligence', 'rise-of-artificial-intelligence', '<p>The past decade has seen <b>Artificial Intelligence (AI)</b> transition from the realm of science fiction to an integral part of our daily lives. From personalized recommendations on streaming platforms to sophisticated medical diagnostics, AI\'s influence is pervasive and ever-expanding.</p>\r\n\r\n<p>This rise is fueled by several factors: the exponential growth of data, advancements in computational power, and the development of more refined algorithms. <b>Machine learning</b>, a subset of AI, has been particularly transformative, enabling systems to learn from data and improve performance without explicit programming. <b>Deep learning</b>, inspired by the structure and function of the human brain, has further propelled AI\'s capabilities, leading to breakthroughs in areas like image recognition, natural language processing, and autonomous systems.</p>\r\n\r\n<p>As AI continues to evolve, it presents both immense opportunities and significant challenges. While it promises to revolutionize industries, enhance productivity, and solve complex global issues, concerns regarding job displacement, ethical implications, and algorithmic bias require careful consideration. The ongoing development of <b>explainable AI (XAI)</b> and <b>responsible AI</b> practices is crucial to ensure that these powerful technologies are developed and deployed for the benefit of all.</p>', 'A brief look at how AI is changing industries.', 'published', '1.jpg', 120, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-16 00:02:36', 3, 1),
(7, 3, 2, 'Top 10 Movies of 2025', 'top-10-movies-2025', '&lt;ol>\r\n&lt;li>\r\n&lt;h3>Mission: Impossible - The Final Reckoning&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> May 23, 2025 (US)&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> This epic conclusion to Ethan Hunt\'s saga has been met with overwhelmingly positive reviews. Critics praise its relentless action, innovative stunts, and Tom Cruise\'s undiminished dedication to the role. It\'s described as a fitting, if slightly overlong, celebratory lap for one of the greatest action franchises. It has also performed strongly at the box office, setting new franchise records for opening day and contributing to a historic Memorial Day weekend.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>Superman&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> July 11, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> As James Gunn\'s kickoff to the new DC Universe, expectations are sky-high. While it hasn\'t officially premiered for widespread critical reviews yet, early box office projections are very strong, suggesting a massive opening weekend. The film aims to explore Superman\'s journey to reconcile his Kryptonian heritage with his human upbringing, focusing on a younger, more established Clark Kent. The buzz is positive, with fans eager to see a fresh take on the iconic hero.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>Avatar: Fire and Ash&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> December 19, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> James Cameron\'s third Avatar installment is still under wraps in terms of full reviews, but predictions are that it will continue the trend of critical acclaim and massive box office success seen with its predecessors. Early details suggest new conflicts on Pandora with the introduction of a \"Fire Clan\" and a potentially even longer runtime than \"The Way of Water.\" Given Cameron\'s track record, it\'s widely expected to be a visual spectacle and a strong contender for awards season nominations.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>The Fantastic Four: First Steps&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> July 25, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> This film marks the highly anticipated introduction of Marvel\'s First Family into the MCU. While no official reviews are out yet, early box office projections are very promising, indicating a strong debut for the film. The casting has generated significant positive buzz, and fans are excited to see how this iconic team is finally brought to life in the Marvel Cinematic Universe, reportedly with a 1960s-inspired, retro-futuristic setting.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>Mickey 17&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> March 7, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> Directed by Bong Joon-Ho and starring Robert Pattinson, \"Mickey 17\" has received mixed to positive reviews. Critics praise Pattinson\'s engaging performance and the intriguing sci-fi premise of an \"expendable\" clone. However, some found the script and supporting characters to be somewhat lackluster, with political messages occasionally feeling \"on the nose.\" While visually serviceable, it hasn\'t achieved the widespread critical adoration of Bong Joon-Ho\'s previous works, becoming a \"fun but ultimately forgettable\" experience for some.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>Captain America: Brave New World&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> February 14, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> This film, featuring Anthony Mackie fully embracing the Captain America mantle, has garnered mixed reviews. While Mackie\'s performance and the action sequences have been praised, some critics found the film to be \"clunky, anticlimactic,\" lacking emotional depth, and playing it too safe. There are also comments about it trying to do too much world-building, potentially at the expense of its core narrative. Despite varied opinions, it aims to continue Sam Wilson\'s journey as the new Cap.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>28 Years Later&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> June 20, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> Danny Boyle\'s return to the acclaimed zombie franchise is highly anticipated. While official reviews are pending, early buzz from those who have seen footage suggests a \"wholly different approach\" that focuses on the survival of the virus itself, rather than just the human survivors. Director Boyle has hinted at \"ambitious storytelling\" that delves into intellectual and emotional ideas within the horror genre. Cillian Murphy is confirmed to not be in this first film of the new trilogy, though his involvement in future installments is possible.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>Jurassic World Rebirth&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> July 2, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> Plot details for this new \"Jurassic\" installment suggest a fresh direction, taking place five years after \"Dominion.\" It reportedly focuses on a small collection of surviving, monstrously-sized dinosaurs on an old InGen testing ground. With new cast members like Scarlett Johansson leading a mercenary group, the film is expected to feature intense dinosaur encounters and explore themes of human greed. Early plot leaks hint at a new mutant dinosaur and a massive final fight, creating anticipation among fans.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>Ballerina&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> June 6, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> This \"John Wick\" spin-off starring Ana de Armas has received positive, though somewhat mixed, reviews. Critics praise Ana de Armas\'s strong screen presence and the film\'s abundant, well-executed action sequences, which are very much in the \"John Wick\" style. However, the writing and the revenge narrative have been described as \"threadbare and stale\" by some, suggesting it might not fully satisfy those looking for a deep narrative beyond the action. Keanu Reeves\' cameo is well-received, and the film is performing decently at the box office, with strong audience scores.&lt;/p>\r\n&lt;/li>\r\n&lt;li>\r\n&lt;h3>How to Train Your Dragon (Live-Action)&lt;/h3>\r\n&lt;p>&lt;strong>Release Date:&lt;/strong> June 13, 2025&lt;/p>\r\n&lt;p>&lt;strong>Review & Assessment:&lt;/strong> The live-action adaptation of the beloved animated series has been a hit with audiences, earning an exceptionally high audience score on Rotten Tomatoes. While critics\' scores are slightly lower than the original animated film, audience reviews praise the faithful adaptation, the cast\'s performances, and the impressive visual effects. It\'s seen as a successful live-action remake that captures the spirit of the original while bringing Hiccup and Toothless to life in a new way, boding well for potential future installments.&lt;/p>\r\n&lt;/ol>', 'Must-watch movies this year!', 'published', '4.jpg', 340, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-16 15:38:18', 3, 1),
(8, 5, 3, 'Champions League Highlights', 'champions-league-highlights', '<p>What a journey it\'s been! The 2024/25 UEFA Champions League season has officially wrapped up, and what an unforgettable campaign it was. From nail-biting group stage encounters to dramatic knockout ties, this year truly delivered on all fronts.</p>\r\n<p>The biggest story, of course, is <strong>Paris Saint-Germain\'s historic triumph</strong>, lifting the coveted trophy for the very first time! In a stunning display of dominance in the final, PSG absolutely <em>demolished</em> Inter Milan with a resounding 5-0 victory at the Allianz Arena in Munich. This emphatic win was a testament to their exceptional season-long performance and a clear statement of intent for European football dominance.</p>\r\n\r\n<h3>Key moments from the final:</h3>\r\n<ul>\r\n    <li>PSG\'s attack was simply unplayable, with their star-studded forward line clicking into gear from the first whistle.</li>\r\n    <li>Inter Milan, who had a strong run to the final, seemed overwhelmed by the Parisian onslaught and struggled to find their rhythm.</li>\r\n    <li>The atmosphere in Munich was electric, with fans witnessing a truly historic moment for French football.</li>\r\n</ul>\r\n<p>Beyond the final, the knockout stages were a rollercoaster of emotions. We saw:</p>\r\n<ul>\r\n    <li><strong>Arsenal</strong> showcasing their resurgence, pushing deep into the competition and even managing to knock out Real Madrid in the quarter-finals – a monumental achievement!</li>\r\n    <li><strong>Liverpool</strong> and <strong>Barcelona</strong> also had strong showings, battling through tough opponents and providing some incredible football for the fans.</li>\r\n    <li>The new format of the Champions League, with its expanded league phase, certainly added a fresh dynamic, making every match feel even more significant.</li>\r\n</ul>\r\n<p>The 2024/25 Champions League will be remembered for its thrilling matches, surprising upsets, and ultimately, for crowning a new king of Europe. Congratulations to Paris Saint-Germain on their well-deserved victory!</p>\r\n<p>As we look ahead, the excitement for the 2025/26 season is already building. With the taste of victory still fresh for PSG and other European giants surely looking for revenge, we can only anticipate another season of unparalleled footballing drama.</p>\r\n<p>What were your favorite moments from this Champions League season? Let us know in the comments below!</p>', 'The best moments from the finals.', 'published', '5.jpg', 500, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-16 08:41:42', 2, 1),
(9, 1, 4, 'Exploring Vietnam’s Hidden Gems', 'exploring-vietnams-hidden-gems', '<p>Vietnam is a country brimming with incredible experiences, often extending far beyond the well-trodden paths of Hanoi, Ho Chi Minh City, and Ha Long Bay. While those iconic destinations are must-sees, venturing slightly off the beaten track reveals a tapestry of unique landscapes, vibrant cultures, and authentic local life.</p>\r\n\r\n<p>Consider heading to the **Ninh Binh** province, often dubbed \"Ha Long Bay on land.\" Here, limestone karsts rise majestically from emerald rice paddies, best explored by a serene sampan boat ride through Trang An or Tam Coc. You can also climb to the top of Hang Mua for panoramic views that will take your breath away, or visit the ancient capital of Hoa Lu.</p>\r\n\r\n<p>For a different kind of natural beauty, the **Phong Nha-Ke Bang National Park** in Quang Binh province is a spelunker\'s paradise. Home to some of the world\'s largest caves, including the colossal Son Doong Cave, it offers incredible subterranean adventures. Even if you\'re not an extreme explorer, smaller, accessible caves like Paradise Cave and Phong Nha Cave provide stunning geological formations and unique boat tours.</p>\r\n\r\n<p>If you\'re seeking a tranquil coastal escape without the crowds, the **Con Dao Islands** offer pristine beaches, crystal-clear waters perfect for snorkeling and diving, and a fascinating, albeit somber, history as a former prison island. It\'s an ideal spot for relaxation, wildlife spotting (including sea turtles), and exploring untouched natural beauty.</p>\r\n\r\n<p>Further south, the **Mekong Delta** offers a glimpse into a unique way of life centered around the mighty Mekong River. While many visit My Tho or Can Tho, delve deeper into smaller towns and floating markets like Cai Be or Sa Dec. Here, you\'ll find lush orchards, traditional workshops, and a slower pace of life, often best experienced by cycling through villages or staying in a homestay.</p>\r\n\r\n<p>And for those who love highland charm, **Da Lat** in the Central Highlands provides a refreshing change of scenery with its cool climate, pine forests, and French colonial architecture. Beyond the popular Xuan Huong Lake and Crazy House, explore hidden waterfalls like Pongour, enjoy the vibrant flower gardens, or go canyoning for an adrenaline rush.</p>\r\n\r\n<p>These destinations offer just a taste of Vietnam\'s lesser-known wonders, promising authentic encounters and unforgettable memories away from the usual tourist bustle.</p>', 'Uncover amazing travel spots!', 'published', '6.jpg', 210, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-15 19:26:05', 2, 0),
(10, 3, 5, 'The Future of Vegan Cuisine', 'future-of-vegan-cuisine', '<p>The culinary landscape is undergoing a revolutionary transformation, and at the forefront of this change is vegan cuisine. What was once considered a niche dietary choice is rapidly evolving into a mainstream movement, driven by growing awareness of health, environmental sustainability, and ethical considerations. The future of vegan cuisine promises not just alternatives, but genuinely innovative and delicious culinary experiences that will appeal to everyone.</p><h3>Beyond Imitation: A New Era of Plant-Based Innovation</h3><p>The early days of vegan food often focused on mimicking meat and dairy, but the future is about pushing boundaries and creating entirely new food categories. We\'re seeing advancements in:</p><ul><li><strong>Next-Generation Plant Proteins:</strong> While soy and pea remain staples, expect to see a wider array of protein sources like fungi (mycoprotein), algae, precision-fermented proteins (creating animal-identical dairy proteins without animals), and even underutilized legumes and aquatic plants. These innovations are leading to products with vastly improved taste, texture, and nutritional profiles.</li><li><strong>Whole-Food Focus:</strong> There\'s a growing trend towards minimally processed, whole-food plant-based options. Think hearty dishes centered around beans, lentils, whole grains, and a diverse range of vegetables, emphasizing natural flavors and health benefits.</li><li><strong>Sustainable Seafood Alternatives:</strong> As concerns about overfishing and ocean health grow, plant-based seafood is rapidly advancing. Expect realistic alternatives for tuna, salmon, shrimp, and even crab cakes, made from ingredients like seaweed, soy, and fungi.</li><li><strong>Elevated Dairy-Free:</strong> Beyond oat and almond milk, the dairy-free sector is exploding with sophisticated cheeses that truly melt and stretch, rich yogurts, and decadent ice creams made from innovative plant bases like cashews, coconuts, and fermented nuts. Precision fermentation is also set to revolutionize dairy alternatives, creating identical dairy proteins.</li></ul><h3>Technology Fueling the Revolution</h3><p>Breakthroughs in food technology are accelerating this future:</p><ul><li><strong>Precision Fermentation:</strong> This cutting-edge technology allows for the creation of specific proteins (like dairy whey or casein) or fats using microorganisms, offering a sustainable and efficient way to produce ingredients identical to their animal counterparts.</li><li><strong>Advanced Extrusion and Shear Cell Technology:</strong> These processes are being refined to create plant-based meats with incredibly realistic fibrous textures and mouthfeel, closely replicating traditional cuts of meat.</li><li><strong>3D Food Printing:</strong> Imagine customized plant-based steaks or intricate seafood designs. 3D printing offers unparalleled control over texture and structure, promising highly personalized and appealing vegan dishes.</li><li><strong>AI and Biotech:</strong> Artificial intelligence and biotechnology are being leveraged to discover novel plant-based ingredients and optimize formulations for flavor, nutrition, and sustainability.</li></ul><h3>Beyond the Plate: A Holistic Approach</h3><p>The future of vegan cuisine isn\'t just about what\'s on the plate; it\'s about a broader shift towards a more sustainable and ethical food system:</p><ul><li><strong>Eco-Conscious Packaging:</strong> Expect more brands to adopt zero-waste initiatives, biodegradable packaging, and transparent labeling about their environmental footprint.</li><li><strong>Local and Regenerative Sourcing:</strong> An increased focus on locally sourced, seasonal plant-based ingredients, supporting regional agriculture and reducing carbon footprints.</li><li><strong>Mainstream Integration:</strong> Vegan options are becoming ubiquitous, from fast-food chains to fine dining restaurants, making plant-based eating more accessible and convenient for everyone, including flexitarians who are simply looking to reduce their meat consumption.</li><li><strong>Health and Wellness Focus:</strong> Consumers are increasingly aware of the health benefits of plant-based diets, including reduced risks of chronic diseases and improved gut health. Future vegan products will continue to highlight these nutritional advantages.</li></ul><p>The future of vegan cuisine is vibrant, innovative, and delicious. It\'s a future where plant-based foods are not just alternatives, but the preferred choice for a healthier planet and healthier people.</p>', 'Discover new vegan trends.', 'published', '2.jpg', 180, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-15 19:48:27', 1, 0),
(11, 5, 6, '5 Tips for a Healthy Mind', '5-tips-for-a-healthy-mind', '<p>In our fast-paced world, prioritizing mental well-being is just as crucial as physical health. A healthy mind allows us to navigate challenges, foster creativity, and enjoy life more fully. Cultivating mental wellness doesn\'t require drastic changes; often, it\'s the small, consistent habits that make the biggest difference. Here are five practical tips to nurture a healthy mind.</p><h3>1. Prioritize Quality Sleep</h3><p>Sleep is not a luxury; it\'s a fundamental necessity for mental health. During sleep, your brain consolidates memories, processes emotions, and repairs itself. Chronic sleep deprivation can lead to irritability, poor concentration, increased stress, and even contribute to more serious mental health issues. Aim for 7-9 hours of quality sleep per night. Establish a consistent sleep schedule, create a relaxing bedtime routine, and optimize your sleep environment.</p><h3>2. Move Your Body Regularly</h3><p>The connection between physical activity and mental well-being is undeniable. Exercise releases endorphins, natural mood boosters, and can significantly reduce symptoms of stress, anxiety, and depression. It doesn\'t have to be intense; even a daily brisk walk, some gentle yoga, or dancing to your favorite music can make a difference. Find an', 'Healthy mind, healthy life.', 'published', '7.jpg', 275, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-15 19:51:58', 2, 0),
(12, 1, 7, 'How to Study More Effectively', 'how-to-study-more-effectively', 'Techniques backed by research...', 'Maximize your learning.', 'published', 'study.jpg', 300, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-15 23:30:49', 2, 0),
(13, 3, 8, 'Street Style Trends of 2025', 'street-style-trends-2025', '<p>As we navigate through 2025, street style continues to be a dynamic reflection of our evolving culture, blurring lines between comfort, sustainability, and personal expression. This year, we\'re seeing a fascinating blend of established trends maturing and exciting new aesthetics emerging from cities worldwide. It\'s less about strict rules and more about individual flair.</p><h3>Elevated Comfort & Utility</h3><p>The post-pandemic emphasis on comfort has solidified its place, but with a refined edge. Think oversized, structured blazers paired with sophisticated sweatpants, or tailored trousers with chunky, ergonomic sneakers. Utility wear, like multi-pocket cargo pants and vests, remains prominent, often elevated with luxurious fabrics or unexpected pairings, making practicality chic.</p><ul><li><strong>Key Pieces:</strong> Wide-leg utility pants, relaxed fit tailoring, performance-inspired outerwear, elevated tracksuits.</li><li><strong>Why it\'s trending:</strong> The desire for ease without sacrificing style; versatility for various activities.</li></ul><h3>Sustainable & Repurposed Statements</h3><p>Sustainability isn\'t just a buzzword; it\'s a driving force in 2025 street style. Thrifting, upcycling, and vintage finds are not only accepted but celebrated. Individuals are creatively repurposing old garments, hand-painting denim, or customizing jackets, making each piece truly unique and telling a story. This trend champions individuality over mass consumption.</p><ul><li><strong>Key Practices:</strong> Mixing vintage with new, visible mending, DIY customization, supporting ethical brands.</li><li><strong>Why it\'s trending:</strong> Environmental consciousness, desire for uniqueness,', 'Be on-trend this year.', 'published', 'street_style.jpg', 145, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-16 11:20:02', 2, 0),
(14, 5, 9, '5 Startup Ideas for Young Entrepreneurs', '5-startup-ideas-young-entrepreneurs', '<p>The entrepreneurial landscape is ever-evolving, offering exciting opportunities for young, innovative minds. To make your mark in 2025, identify emerging needs, leverage digital tools, and start small with passion. Here are five suitable startup ideas for young founders:</p><h3>1. Hyper-Local Sustainable Delivery Service</h3><p>Capitalize on growing e-commerce and eco-demand by serving local businesses (restaurants, shops) with electric bikes/scooters. Build community ties, offer competitive pricing, and market green credentials with low initial investment.</p><h3>2. AI-Powered Personalized Learning & Skill Enhancement</h3><p>Address the booming demand for continuous learning. Leverage AI to create platforms for personalized tutoring, bespoke skill paths (e.g., prompt engineering), or AI-driven mentor matching, making complex learning engaging and accessible.</p><h3>3. Curated \"Recommerce\" & Vintage Marketplaces (Niche)</h3><p>Tap into the thriving resale market by creating highly curated niche platforms for specific second-hand items (e.g., vintage Y2K fashion, retro tech). Success relies on excellent curation, authentic sourcing, and strong branding for enthusiasts.</p><h3>4. Experiential Pop-Up Events & Workshops</h3><p>Meet the craving for in-person experiences by organizing unique, themed pop-up events. These could be sustainable living workshops, immersive art, or specialized cooking classes. Benefit', 'Start building your dream.', 'published', 'startup.jpg', 410, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-16 11:48:41', 3, 1),
(15, 5, 10, 'Top Discoveries in Modern Science', 'top-discoveries-modern-science', '<p>The pace of scientific discovery in the 21st century is nothing short of astounding. From decoding life\'s building blocks to peering into the universe\'s oldest secrets, modern science pushes human knowledge. Here are some of the most impactful discoveries shaping our understanding.</p><h3>Revolutionizing Biology with CRISPR</h3><p>CRISPR-Cas9, \"molecular scissors,\" has transformed genetic engineering. Since its adoption in the early 2010s and refinement through 2025, CRISPR precisely edits DNA, paving the way for genetic disease cures (e.g., sickle cell anemia, beta-thalassemia), disease-resistant crops, and advanced gene therapies. Its versatility impacts research, medicine, and agriculture.</p><h3>The Quantum Computing Race Heats Up</h3><p>Quantum computing\'s theoretical power nears practical application. Recent years, especially leading to 2025, show milestones in stable, powerful quantum processors. Companies are boosting qubit count and error correction, approaching solutions for problems intractable for supercomputers. Specialized quantum processors already hint at future revolutions in drug discovery, materials science, and cryptography.</p><h3>AI as a Catalyst for Scientific Breakthroughs</h3><p>AI is now a powerful partner in discovery. From 2020-2025, AI\'s role expanded across nearly all disciplines. AI models accelerate drug discovery, rapidly analyze medical imaging for improved diagnoses (outperforming doctors in some tasks), and accurately predict protein structures (e.g., AlphaFold). This human-AI synergy leads to faster research and unimaginable insights.</p><h3>Pushing the Boundaries of Space Exploration and Exoplanet Discovery</h3><p>Our cosmic quest accelerates. Missions like the James Webb Space Telescope (JWST), fully operational recently, provide unprecedented views of the early universe, revealing exoplanet atmospheres and star/galaxy formation. Confirmed exoplanets surged past 5,500, with recent discoveries suggesting Earth-like \"super-Earths\" are common. Ambitious lunar missions and next-gen spacecraft (e.g., SpaceX\'s Starship) set the stage for human returns to the Moon and potential Mars voyages.</p><h3>Advancements in Personalized Medicine and Therapies</h3><p>Medicine shifts towards precise, personalized treatments. Beyond continued mRNA vaccine development, progress includes:<ul><li><strong>Precision Medicine:</strong> Tailoring treatments based on individual genetics, lifestyle, and environment for maximum efficacy and minimal side effects, especially in cancer.</li><li><strong>Regenerative Medicine:</strong> Advances in stem cell therapy and tissue engineering aim to repair/replace damaged tissues/organs, offering hope for Parkinson\'s, Alzheimer\'s, and heart failure.</li><li><strong>AI-Powered Diagnostics & Mental Health Tech:</strong> AI enhances early disease detection and treatment personalization. Mental health tech, including AI therapy apps and VR treatments, increases accessible personalized care.</li></ul><p>These discoveries are a snapshot of modern science\'s incredible progress. Each breakthrough deepens our understanding and holds immense potential to improve lives and address humanity\'s pressing challenges.</p>', 'Stay informed with science.', 'published', 'science.jpg', 380, '2025-06-10 13:29:30', '2025-06-10 13:29:30', '2025-06-16 12:00:04', 3, 1),
(18, 5, NULL, 'Hoi An: Stepping Back in Time in Vietnam\'s Lantern City', NULL, '<p>Vietnam is a country brimming with incredible experiences, often extending far beyond the well-trodden paths of Hanoi, Ho Chi Minh City, and Ha Long Bay. While those iconic destinations are must-sees, venturing slightly off the beaten track reveals a tapestry of unique landscapes, vibrant cultures, and authentic local life.</p>\r\n<p>Consider heading to the <strong>Ninh Binh</strong> province, often dubbed \"Ha Long Bay on land.\" Here, limestone karsts rise majestically from emerald rice paddies, best explored by a serene sampan boat ride through Trang An or Tam Coc. You can also climb to the top of Hang Mua for panoramic views that will take your breath away, or visit the ancient capital of Hoa Lu.</p>\r\n<p>For a different kind of natural beauty, the <strong>Phong Nha-Ke Bang National Park</strong> in Quang Binh province is a spelunker\'s paradise. Home to some of the world\'s largest caves, including the colossal Son Doong Cave, it offers incredible subterranean adventures. Even if you\'re not an extreme explorer, smaller, accessible caves like Paradise Cave and Phong Nha Cave provide stunning geological formations and unique boat tours.</p>\r\n<p>If you\'re seeking a tranquil coastal escape without the crowds, the <strong>Con Dao Islands</strong> offer pristine beaches, crystal-clear waters perfect for snorkeling and diving, and a fascinating, albeit somber, history as a former prison island. It\'s an ideal spot for relaxation, wildlife spotting (including sea turtles), and exploring untouched natural beauty.</p>\r\n<p>Further south, the <strong>Mekong Delta</strong> offers a glimpse into a unique way of life centered around the mighty Mekong River. While many visit My Tho or Can Tho, delve deeper into smaller towns and floating markets like Cai Be or Sa Dec. Here, you\'ll find lush orchards, traditional workshops, and a slower pace of life, often best experienced by cycling through villages or staying in a homestay.</p>\r\n<p>And for those who love highland charm, <strong>Da Lat</strong> in the Central Highlands provides a refreshing change of scenery with its cool climate, pine forests, and French colonial architecture. Beyond the popular Xuan Huong Lake and Crazy House, explore hidden waterfalls like Pongour, enjoy the vibrant flower gardens, or go canyoning for an adrenaline rush.</p>\r\n<p>These destinations offer just a taste of Vietnam\'s lesser-known wonders, promising authentic encounters and unforgettable memories away from the usual tourist bustle.</p>', 'Hoi An is a UNESCO World Heritage town in Vietnam.', 'draft', '/2025-06-15-174999057132504.jpeg', 0, NULL, '2025-06-15 07:29:31', '2025-06-16 14:26:48', 8, 11),
(38, 11, 9, 'Startup Success in the Digital Age', 'startup-success-digital-age', '<p>In today\'s digital-first world, startups thrive by expertly leveraging technology, agility, and online consumer behavior. **Digital strategy is the cornerstone of growth**.</p>\r\n---\r\n<h3>Key Pillars of Digital-Age Startup Success</h3>\r\n<p><strong>1. Digital-First Mindset:</strong> Startups are built with seamless online presence, intuitive UX, and mobile optimization as core elements. They understand customers live online.</p>\r\n<p><strong>2. Data-Driven Decisions:</strong> Successful startups master collecting, analyzing, and acting on data. They use analytics to understand customer journeys, optimize marketing, refine products, and identify opportunities, iterating based on real-time insights.</p>\r\n<p><strong>3. Agile & Iterative Development:</strong> Rapidly testing, learning, and adapting is paramount. Digital tools allow incremental product development, MVP releases, quick feedback, and necessary pivots, minimizing risk and maximizing responsiveness.</p>\r\n<p><strong>4. Hyper-Targeted Marketing & Community Building:</strong> Digital channels enable precise targeting for tailored messages. Beyond acquisition, they prioritize strong online communities, fostering loyalty and advocacy through engaging content and direct interaction.</p>\r\n<p><strong>5. Scalable Technology Infrastructure:</strong> Modern startups leverage scalable tech (cloud, automation) from day one. This handles rapid growth efficiently, allowing expansion and serving larger customer bases cost-effectively.</p>\r\n<p><strong>6. Global Reach from Day One:</strong> The internet erases geographical barriers. Startups design products with a global audience in mind, supporting diverse markets and languages, opening vast opportunities.</p>\r\n---\r\n<p>Ultimately, modern startup success is about a **culture of continuous innovation, customer-centricity, and adaptability**, all powered and amplified by digital tools.</p>', 'Startups in the modern world.', 'published', '21.jpg', 85, '2025-06-02 11:00:00', '2025-06-16 10:21:32', '2025-06-16 10:43:10', 0, 0),
(39, 12, 10, 'Exploring Quantum Computing', 'exploring-quantum-computing', '<p>Introduction to the future of computation.</p>', 'Quantum computing explained.', 'published', '22.jpg', 90, '2025-06-03 12:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(40, 13, 7, 'Educational Technology Trends', 'educational-technology-trends', '<p>How technology is transforming education.</p>', 'EdTech overview.', 'published', '23.jpg', 78, '2025-06-04 13:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(41, 14, 4, 'Top Travel Destinations for 2025', 'top-travel-destinations-2025', '<p>As we move through 2025, travel shifts towards comfort, novelty, and immersion. Travelers increasingly seek value, sustainability, and authenticity. Here are top destinations making waves, catering to cultural exploration and natural adventures.</p><h3>Asia\'s Enduring Allure and Emerging Gems</h3><p>Asia remains a favorite.<ul><li><strong>Japan:</strong> Popular with ancient traditions, futuristic innovation, and favorable exchange rates. Osaka\'s World Expo 2025 is a major draw.</li><li><strong>Thailand:</strong> Classic for food, hospitality, diverse landscapes, and new rail holidays.</li><li><strong>Vietnam:</strong> A rising star with stunning beauty, rich history, vibrant culture. Nha Trang is a top summer destination; Hanoi consistently ranks high.</li><li><strong>Malaysia:</strong> Kuala Lumpur is a popular urban hub, offering diverse experiences.</li><li><strong>Nepal:</strong> A dream for adventurers and spiritual seekers with Himalayas, ancient sites, and affordability, drawing young travelers.</li></ul></p><h3>European Favorites and Undiscovered Charms</h3><p>Europe captivates with classics and new spots.<ul><li><strong>Italy & Greece:</strong> Perennial favorites (Rome, Milan, Venice, Greek islands like Crete) offer culture, history, relaxation, and adventure. Quieter Greek islands are gaining traction.</li><li><strong>Portugal:</strong> A hot spot with diverse landscapes, stunning beaches, ancient landmarks, and vibrant cities, offering good year-round weather.</li><li><strong>France:</strong> Paris remains a favorite; interest grows in regions like Marseille.</li><li><strong>Spain (especially Andalusia):</strong> Alicante, Malaga, and Córdoba are trending for food, culture, and beaches.</li><li><strong>Greenland:</strong> Emerging Arctic adventure, with Nuuk more accessible via new airport, offering raw wilderness.</li><li><strong>Croatia:</strong> Hundreds of beautiful islands, national parks, and historic towns along the Dalmatian Coast make it picturesque.</li></ul></p><h3>Adventure and Nature in the Americas & Beyond</h3><p>For adventure and nature, destinations stand out.<ul><li><strong>South Africa:</strong> Unbeatable combination of Big 5 safaris, Cape Town, stunning coastlines, and favorable exchange rates.</li><li><strong>Costa Rica:</strong> Continues to capture imaginations with nature-rich landscapes, volcanoes, and outdoor adventures for immersive experiences.</li><li><strong>Alaska (USA):</strong> Top domestic destination for grand landscapes, glaciers, and wildlife, fitting outdoor adventure and \"coolcation\" trends.</li><li><strong>Maui (USA):</strong> Seeing increased arrivals as travelers return to familiar beach getaways.</li><li><strong>Egypt (especially Hurghada & Sharm El Sheikh):</strong> Red Sea destinations trending for warm climate, resorts, and world-class diving, appealing to families and couples.</li></ul></p><p>Overall, 2025 travel highlights meaningful, experience-driven trips. Whether it\'s \"JOMO\" nature getaways, live event trips, or cultural immersions, travelers prioritize growth and deeper connections. The rise of alternative and overlooked destinations, alongside classics, promises a diverse and exciting year for global exploration.</p>', 'Best travel spots.', 'published', '24.jpg', 65, '2025-06-05 09:30:00', '2025-06-16 10:21:32', '2025-06-16 11:21:06', 0, 1),
(42, 15, 5, 'The Future of Vietnamese Cuisine', 'future-of-vietnamese-cuisine', '<p>From Ho Chi Minh City\'s vibrant streets, the future of Vietnamese cuisine is a delicious blend of heritage, global influences, and modern techniques.</p><h3>1. Renewed Focus on Heritage & Regional Specialties</h3><p>Beyond pho and banh mi, Vietnam\'s vast regional cuisines are set for rediscovery. Expect deeper dives into Northern, Central, and Southern flavors like **Bun Cha Ca** and Hue royal cuisine, enriching experiences globally.</p><h3>2. Embracing Sustainable & Local Sourcing</h3><p>Sustainability increasingly shapes Vietnamese food culture. Expect more emphasis on fresh, **locally sourced**, seasonal ingredients, supporting farmers and enhancing dish quality. Farm-to-table initiatives will continue to grow.</p><h3>3. Innovation & Modern Techniques</h3><p>Vietnamese cuisine isn\'t static. Young, internationally-trained chefs are experimenting with **modern culinary techniques** and presentations, creating innovative interpretations of classics while preserving core flavors. This fusion attracts new diners and elevates our culinary standing.</p><h3>4. Rise of Plant-Based Vietnamese Cuisine</h3><p>With global plant-based trends, expect significant expansion in **vegan and vegetarian options**. Our abundant vegetables, tofu, and noodles provide a natural foundation for creative plant-based versions of traditional dishes and new creations, catering to growing health and ethical demands.</p><h3>5. Global Fusion & Cross-Cultural Influences</h3><p>Like historical influences, expect more subtle, thoughtful **cross-cultural infusions**. This might involve complementing Vietnamese flavors with global ingredients or techniques, leading to exciting new culinary expressions, like a pho broth with dashi notes.</p><h3>6. Power of Digital Platforms & Culinary Tourism</h3><p>The internet and social media will continue showcasing Vietnamese cuisine. Expect more **online cooking classes**, food blogs, and visual content. **Culinary tourism** will drive travelers seeking authentic food experiences, from Ho Chi Minh City street food tours to regional cooking classes.</p><p>---</p><p>In conclusion, Vietnamese cuisine\'s future is bright. It\'s a future honoring heritage while embracing innovation, sustainability, and global influences. From Ho Chi Minh City to global tables, Vietnamese food is set to continue its ascent as a beloved culinary tradition. I\'m thrilled to witness this delicious evolution!</p>', 'Vietnamese culinary evolution.', 'published', '25.jpg', 112, '2025-06-06 08:00:00', '2025-06-16 10:21:32', '2025-06-16 11:31:55', 2, 2),
(43, 16, 6, 'Healthy Living Tips for Busy People', 'healthy-living-tips-busy-people', '<p>In today\'s relentless pace, it often feels like there\'s simply no time for healthy habits. Between work deadlines, family commitments, and social obligations, prioritizing well-being can seem like an impossible task. However, neglecting your health catches up eventually. The good news is that healthy living doesn\'t demand huge chunks of time; it\'s about smart, consistent choices that fit seamlessly into a busy schedule. Here are five practical tips for busy individuals looking to cultivate a healthier lifestyle.</p><h3>1. Master Smart Meal Planning & Prep</h3><p>For busy people, chaotic eating leads to unhealthy choices. Dedicate just 1-2 hours on a less hectic day (like Sunday) to plan meals for the week.<ul><li><strong>Batch Cook Staples:</strong> Prepare large quantities of grains (quinoa, brown rice), roasted vegetables, and lean proteins (chicken breast, lentils).</li><li><strong>Build-Your-Own Formula:</strong> Use these staples to quickly assemble varied meals (e.g., grain bowls, wraps, quick stir-fries).</li><li><strong>Healthy Snacks on Hand:</strong> Keep pre-portioned nuts, fruit, yogurt, or chopped veggies readily available to avoid impulsive, unhealthy snacking.</li></ul></p><h3>2. Integrate Micro-Workouts & Movement Breaks</h3><p>You don\'t need an hour at the gym to stay active. Integrate short bursts of movement throughout your day.<ul><li><strong>Morning Energizer:</strong> 10-15 minutes of stretching or bodyweight exercises (planks, squats) before starting your day.</li><li><strong>Desk Breaks:</strong> Every hour, stand up, stretch, walk to get water, or do a quick set of lunges.</li><li><strong>Active Commute:</strong> If possible, walk or bike part of your commute.</li><li><strong>Stair Power:</strong> Always take the stairs instead of the elevator. These micro-efforts add up significantly.</li></ul></p><h3>3. Prioritize Quality Sleep (Non-Negotiable)</h3><p>Sleep is often the first thing sacrificed when busy, but it\'s arguably the most critical for mental and physical health.<ul><li><strong>Consistent Schedule:</strong> Try to go to bed and wake up around the same time each day, even on weekends.</li><li><strong>Wind-Down Routine:</strong> Create a relaxing ritual 30-60 minutes before bed (reading, gentle stretching, warm shower) to signal to your body it\'s time to rest.</li><li><strong>Optimize Your Space:</strong> Ensure your bedroom is dark, quiet, and cool. Avoid screens (phones, tablets, TVs) in bed.</li></ul></p><h3>4. Practice Mindful Moments & Digital Detox</h3><p>In a world of constant notifications, intentional breaks are vital for mental clarity and stress reduction.<ul><li><strong>5-Minute Mindfulness:</strong> Take a few minutes to simply focus on your breath. Use an app or just sit quietly.</li><li><strong>\"No-Screen\" Zones:</strong> Designate times or places (e.g., during meals, the first hour of waking up, before bed) where screens are off-limits.</li><li><strong>Nature Connection:</strong> Even a 10-minute walk outside can clear your head and reduce mental fatigue.</li></ul></p><h3>5. Stay Consistently Hydrated</h3><p>A simple yet profoundly impactful habit. Dehydration can lead to fatigue, headaches, poor concentration, and irritability.<ul><li><strong>Water Bottle Companion:</strong> Carry a reusable water bottle everywhere and refill it regularly.</li><li><strong>Hydration Reminders:</strong> Use apps or set alarms to remind you to drink water throughout the day.</li><li><strong>Start Strong:</strong> Begin your day with a large glass of water to kickstart your metabolism and hydration.</li></ul></p><p>Remember, healthy living isn\'t about perfection; it\'s about progress and consistency. By implementing these smart, manageable tips, even the busiest individuals can significantly improve their overall well-being and thrive amidst their demanding schedules.</p>', 'Stay healthy despite a hectic schedule.', 'published', '26.jpg', 79, '2025-06-07 07:00:00', '2025-06-16 10:21:32', '2025-06-16 14:30:57', 1, 1),
(44, 17, 2, 'Upcoming Movie Releases of 2025', 'upcoming-movie-releases-2025', '<p>Exciting films hitting theaters soon.</p>', 'Blockbuster movie previews.', 'published', '27.jpg', 95, '2025-06-08 14:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(45, 18, 8, 'Summer Fashion Trends', 'summer-fashion-trends', '<p>What to wear this summer season.</p>', 'Latest in summer fashion.', 'published', '28.jpg', 105, '2025-06-09 16:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(46, 20, 1, 'Programming with Rust Language', 'programming-with-rust-language', '<p>Why Rust is gaining popularity among developers.</p>', 'Intro to Rust programming.', 'published', '30.jpg', 88, '2025-06-11 10:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(47, 21, 9, 'Business Models That Work in 2025', 'business-models-2025', '<p>Adapting to new business challenges.</p>', 'Modern business models.', 'published', '31.jpg', 97, '2025-06-12 12:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(48, 22, 10, 'Scientific Breakthroughs of the Year', 'scientific-breakthroughs-2025', '<p>A look at major scientific discoveries.</p>', 'Important science news.', 'published', '32.jpg', 92, '2025-06-13 08:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(49, 23, 7, 'Revolutionizing Education with AI', 'revolutionizing-education-ai', '<p>Artificial Intelligence in the classroom.</p>', 'AI and education.', 'published', '33.jpg', 84, '2025-06-14 09:00:00', '2025-06-16 10:21:32', '2025-06-16 11:37:09', 2, 0),
(50, 24, 4, 'Hidden Gems in Southeast Asia', 'hidden-gems-southeast-asia', '<p>Beautiful places off the beaten path.</p>', 'Underrated travel destinations.', 'published', '34.jpg', 102, '2025-06-15 15:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(51, 25, 5, 'Street Food Adventures in Hanoi', 'street-food-adventures-hanoi', '<p>Hanoi, Vietnam\'s bustling capital, isn\'t just a city of ancient temples and colonial architecture; it\'s a paradise for food lovers, particularly those seeking authentic street food adventures. The true essence of Hanoi\'s culinary scene unfolds on its lively sidewalks, where tantalizing aromas waft from countless stalls and the clatter of chopsticks provides a constant rhythm. Forget fancy restaurants – the real magic of Vietnamese cuisine lies in these humble, open-air kitchens.</p><h3>Why Hanoi\'s Street Food is Unforgettable</h3><p>Eating street food in Hanoi is more than just a meal; it\'s a sensory immersion. It\'s the sight of vibrant fresh herbs, the sound of sizzling woks, the scent of simmering broths, and the taste of perfectly balanced flavors. It’s also incredibly affordable, allowing you to sample a wide array of dishes without breaking the bank. Each dish often specializes in one or two items, perfected over generations, making every bite an authentic experience.</p><h3>Must-Try Dishes on Your Hanoi Street Food Adventure:</h3><ul><li><strong>Phở (Noodle Soup):</strong> While famous nationwide, Hanoi\'s Phở holds a special place. Typically, it\'s simpler, focusing on the rich, clear beef or chicken broth, fresh rice noodles, and tender meat. Often enjoyed for breakfast, finding a bustling Phở stall early in the morning is a quintessential Hanoi experience.</li><li><strong>Bún Chả (Grilled Pork with Vermicelli):</strong> This iconic Hanoian dish features tender, grilled pork patties and slices of marinated pork belly served in a bowl of sweet and sour dipping sauce, accompanied by vermicelli noodles and a generous plate of fresh herbs. It’s a symphony of flavors and textures.</li><li><strong>Bánh Mì (Vietnamese Sandwich):</strong> Though found everywhere, Hanoi\'s Bánh Mì boasts its own character. Crisp baguettes are filled with a variety of ingredients, from pâté and cold cuts to grilled pork or eggs, always complemented by fresh herbs, pickled vegetables, and a hint of chili.</li><li><strong>Chả Cá Lã Vọng (Turmeric Fish with Dill):</strong> A unique Hanoi specialty! Freshwater fish marinated in turmeric and galangal is pan-fried at your table with dill and spring onions, then served with vermicelli noodles, roasted peanuts, and shrimp paste. It’s an interactive and flavorful dining experience.</li><li><strong>Cà Phê Trứng (Egg Coffee):</strong> A surprising, delightful Hanoi invention. This rich, creamy concoction features strong Vietnamese coffee topped with a frothy, sweet whisked egg yolk mixture. It\'s like a liquid tiramisu and a must-try for any visitor.</li><li><strong>Nem Rán (Fried Spring Rolls) / Gỏi Cuốn (Fresh Spring Rolls):</strong> You\'ll find these ubiquitous. Nem Rán are crispy, savory fried rolls filled with pork, mushrooms, and glass noodles. Gỏi Cuốn are refreshing fresh rolls packed with shrimp, pork, vermicelli, and herbs, served with a delicious peanut or fish sauce.</li></ul><h3>Embracing the Experience:</h3><p>Part of the charm is the informal setting. Don\'t be shy about pulling up a tiny plastic stool on the sidewalk, sharing a table with locals, and embracing the lively atmosphere. Look for stalls that are busy – that\'s often the best indicator of freshness and deliciousness. While hygiene concerns are common, most reputable street food vendors maintain high standards.</p><p>A street food adventure in Hanoi is an an essential part of understanding its culture, history, and vibrant everyday life. So, step out, be adventurous, and let your taste buds lead the way through the culinary wonders of Vietnam\'s capital!</p>', 'Foodie guide to Hanoi.', 'published', '35.jpg', 74, '2025-06-16 19:00:00', '2025-06-16 10:21:32', '2025-06-16 13:39:46', 0, 0),
(52, 26, 6, 'Mindfulness for Stress Reduction', 'mindfulness-stress-reduction', '<p>Reduce stress with simple mindfulness exercises.</p>', 'Mindfulness made easy.', 'published', '36.jpg', 89, '2025-06-17 18:00:00', '2025-06-16 10:21:32', '2025-06-16 11:20:50', 1, 0);
INSERT INTO `posts` (`id`, `user_id`, `category_id`, `title`, `slug`, `content`, `excerpt`, `status`, `image_url`, `view_count`, `published_at`, `created_at`, `updated_at`, `like_quantity`, `comment_quantity`) VALUES
(53, 27, 2, 'Music Festivals to Watch', 'music-festivals-to-watch-2025', '<p>Music festivals are more than just concerts; they are immersive experiences, cultural melting pots, and vibrant celebrations of sound, art, and community. From sprawling desert stages to historic European fields, these events offer unforgettable moments for every music enthusiast. As we look towards late 2025 and into 2026, here are some of the most anticipated music festivals that deserve a spot on your watch list.</p><h3>1. Tomorrowland (Boom, Belgium)</h3><p>Often hailed as the world\'s premier electronic dance music (EDM) festival, Tomorrowland is synonymous with breathtaking stage designs, fantastical themes, and a lineup of the biggest names in dance music. Held across two weekends in July, it\'s a global pilgrimage for ravers and an unparalleled spectacle of light, sound, and unity. Expect an even grander production and a diverse mix of EDM genres.</p><h3>2. Lollapalooza (Chicago, USA & Global Editions)</h3><p>A multi-genre powerhouse, Lollapalooza\'s flagship event takes over Chicago\'s Grant Park every August, showcasing rock, pop, hip-hop, indie, and electronic acts across multiple stages. Beyond Chicago, its global editions in South America and Europe (like Lollapalooza Berlin) bring its diverse appeal to an international audience. It\'s a prime spot to catch both established headliners and emerging artists.</p><h3>3. Fuji Rock Festival (Niigata Prefecture, Japan)</h3><p>Nestled amidst the stunning natural beauty of Naeba Ski Resort, Fuji Rock is Japan\'s largest outdoor music event and one of Asia\'s most respected festivals. Known for its eclectic lineups spanning rock, indie, electronic, and folk, its commitment to environmental sustainability, and a remarkably clean and respectful crowd, it offers a unique blend of nature and music typically in late July.</p><h3>4. Glastonbury Festival (Somerset, UK)</h3><p>A legendary institution, Glastonbury is arguably the most famous greenfield festival in the world. Held biennially (though it\'s set to return in 2026 after its 2024 edition), it transcends genres, featuring an unparalleled lineup across hundreds of stages, alongside theatre, circus, dance, and art. Securing tickets is a challenge, but the experience is often described as life-changing. It\'s a deep dive into counter-culture and mainstream music alike.</p><h3>5. Ultra Music Festival (Miami, USA & Global Editions)</h3><p>Another titan in the EDM world, Ultra Music Festival kicks off the festival season in Miami each March with a high-energy, immersive experience. Known for its state-of-the-art production, massive main stage, and a focus on the biggest names in electronic music, Ultra also boasts global editions in various cities, bringing the party to continents worldwide.</p><h3>6. Primavera Sound (Barcelona, Spain & Global Editions)</h3><p>Primavera Sound is celebrated for its meticulously curated lineups that often champion indie, alternative, electronic, and experimental artists. Held in Barcelona, typically in late May or early June, it\'s a favorite among music purists for its quality over commercialism. Its expansion to cities like Porto and Buenos Aires solidifies its reputation as a global tastemaker.</p><h3>The Evolving Festival Landscape</h3><p>Beyond these giants, the festival scene continues to evolve. We\'re seeing trends towards more immersive experiences, increased focus on sustainability, wellness zones, and genre-fluid lineups. Whether you\'re seeking a massive dance party, a multi-day camping adventure, or a more curated artistic journey, there\'s a music festival out there waiting to be discovered. Keep an eye on official announcements for lineups and ticket sales – these experiences often sell out fast!</p>', 'Don\'t miss these music events.', 'published', '37.jpg', 108, '2025-06-18 13:00:00', '2025-06-16 10:21:32', '2025-06-16 14:46:17', 1, 2),
(54, 28, 8, 'Vietnamese Designers Making Waves', 'vietnamese-designers-making-waves', '<p>Fashion designers from Vietnam gaining global recognition.</p>', 'Vietnam in fashion industry.', 'published', '38.jpg', 110, '2025-06-19 14:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0),
(55, 29, 3, 'The Future of Esports', 'future-of-esports', '<p>How esports is becoming mainstream entertainment.</p>', 'Esports industry growth.', 'published', '39.jpg', 115, '2025-06-20 10:00:00', '2025-06-16 10:21:32', '2025-06-16 10:21:32', 0, 0);

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
(10, 11, 25),
(11, 7, 61);

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
(60, 'Freelancing', 'freelancing'),
(61, 'Movie', 'movie');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
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

INSERT INTO `users` (`id`, `username`, `password`, `email`, `status`, `role`, `display_name`, `firstname`, `lastname`, `avatar_url`, `bio`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@gmail.com', '1', 'user', NULL, NULL, NULL, 'user.jpg', NULL, '2025-06-10 10:26:21', '2025-06-15 18:50:04', 1),
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', '1', 'admin', NULL, NULL, NULL, 'admin.jpg', NULL, '2025-06-10 10:28:35', '2025-06-16 08:29:38', 1),
(5, 'user2', '7e58d63b60197ceb55a1c487989a3720', 'user2@gmail.com', '1', 'user', NULL, NULL, NULL, 'user2.jpg', NULL, '2025-06-10 10:33:01', '2025-06-15 19:10:03', 1),
(6, 'hkhan2712', 'bd49aa2a4ad6a1f8eabe4883d9ceed7d', 'kitnguyn2712@gmail.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-11 05:07:50', '2025-06-11 05:07:50', 1),
(7, 'user3', '92877af70a45fd6a2ed7fe81e1236b78', 'user3@gmail.com', '1', 'user', NULL, NULL, NULL, 'user3.jpg', NULL, '2025-06-15 06:08:36', '2025-06-15 18:12:54', 1),
(10, 'nguyenvana', '25d55ad283aa400af464c76d713c07ad', 'nguyenvana@gmail.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:02:10', '2025-06-16 10:02:10', 1),
(11, 'avajohnson15409', '25d4ab2b5c4d09a55a4ea97d00c1ab2f', 'avajohnson15409@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(12, 'jamesdavis23683', '5f8494ef6db8b8156bc8f7c796637bcf', 'jamesdavis23683@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(13, 'jamessmith7291', '87c00db038564b1f63e49dec3d539be4', 'jamessmith7291@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(14, 'jamesmiller13883', '63cb0dc12e4815cb7cc1170c4a6cb41d', 'jamesmiller13883@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(15, 'avajones28391', '14f99544ef473212d37bd357f38fc7d7', 'avajones28391@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(16, 'emmabrown580', '0ee426d06e02747314ad477959196f94', 'emmabrown580@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(17, 'charlottewilliams19816', 'f3d265c6df5c12b7f7d9b92eedbf3030', 'charlottewilliams19816@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(18, 'noahgarcia15166', '41ce9917647b82e509903d057e829fff', 'noahgarcia15166@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(19, 'noahwilliams28439', '3b74f2d1cc04bbf383b1b0ae0440ea21', 'noahwilliams28439@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(20, 'charlottemiller29328', '25902559c9430edd85e26638ede12cdb', 'charlottemiller29328@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:05:24', '2025-06-16 10:05:24', 1),
(21, 'binhhoang', 'fe9e67ef78af3f092ef6e60f606ad34a', 'binhhoang@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(22, 'khanhdang', '6f0f7615ad0179b20563227e8db82c59', 'khanhdang@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(23, 'khanhpham', 'e2662e6f813ed3d4544b5ba13c73eb09', 'khanhpham@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(24, 'ducpham', '3a02700e8be1fa6e69c9c2af091dbedb', 'ducpham@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(25, 'ducngo', '76560637babc81679050b75b76a6cd9c', 'ducngo@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(26, 'huyvo', '13a1565161ed3c214e70b42992f9e882', 'huyvo@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(27, 'binhpham', '8ae766e4a524a4c522b763d8895e20be', 'binhpham@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(28, 'minhngo', 'c92c9c9cea20283f7ff3d542f9c963e0', 'minhngo@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(29, 'duchoang', 'cc605bb4539549fe58f28dde24900396', 'duchoang@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1),
(30, 'ngochoang', '80c3710473eccdb2ec92829ef06a5afc', 'ngochoang@example.com', '1', 'user', NULL, NULL, NULL, NULL, NULL, '2025-06-16 10:09:34', '2025-06-16 10:09:34', 1);

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_entity_unique` (`user_id`,`entity_id`,`entity_type`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
