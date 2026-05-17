-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2026 at 03:24 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `business`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `nomination_fee` decimal(8,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `description`, `image_path`, `slug`, `status`, `nomination_fee`, `created_at`, `updated_at`) VALUES
(162, NULL, 'SEASON 3 CATEGORIES', 'Season 3', NULL, 'season-3-categories', 'active', '0.00', '2026-02-15 00:18:02', '2026-02-15 00:23:55'),
(163, 162, 'BEST SALON OT THE YEAR', 'ded', NULL, 'best-salon-ot-the-year', 'active', '0.00', '2026-02-15 00:20:06', '2026-02-15 00:22:49'),
(164, 162, 'BEST TRANSPORTATION SERVICES', NULL, 'categories/5zXtqRdGfK5khlDYBZSpbgQRKJUvIYECfpD7GrRv.png', 'best-transportation-services', 'active', '0.00', '2026-02-15 00:24:59', '2026-02-18 19:53:11'),
(165, 162, 'BEST AUTOMOTIVE (MOTORS)', NULL, 'categories/MVnaI3tszBuOs50azBGr0MUzJdD0ASSv1PbXBRWz.png', 'best-automotive-motors', 'active', '1000.00', '2026-02-15 00:26:43', '2026-02-18 17:36:15'),
(166, 162, 'BEST PRINTING & BRANDING', NULL, NULL, 'best-printing-branding', 'active', '0.00', '2026-02-15 00:27:08', '2026-02-15 00:27:08'),
(167, 162, 'BEST NON CHARITY ORGANIZATION', NULL, 'categories/SpfM4j2DJaIHuOszAXYCIhvsEwIR1WfK8S3oz1m6.png', 'best-non-charity-organization', 'active', '0.00', '2026-02-15 00:27:37', '2026-02-18 19:46:02'),
(168, 162, 'BEST DECORATION STORE', NULL, NULL, 'best-decoration-store', 'active', '0.00', '2026-02-15 00:28:18', '2026-02-15 00:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(2, '3123bf88-2fd1-4cc1-a4f9-3b975e0db300', 'database', 'default', '{\"uuid\":\"3123bf88-2fd1-4cc1-a4f9-3b975e0db300\",\"displayName\":\"App\\\\Notifications\\\\NewMarathonRegistration\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\NewMarathonRegistration\\\":2:{s:15:\\\"\\u0000*\\u0000registration\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:31:\\\"App\\\\Models\\\\MarathonRegistration\\\";s:2:\\\"id\\\";i:6;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"d32e2549-ae0d-4e8e-8526-ddfb77b140a7\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1758155071,\"delay\":null}', 'Symfony\\Component\\Mailer\\Exception\\UnexpectedResponseException: Expected response code \"250/251/252\" but got code \"550\", with message \"550 No Such User Here\". in C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php:342\nStack trace:\n#0 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(198): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->assertResponseCode(\'550 No Such Use...\', Array)\n#1 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(150): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#2 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(268): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#3 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(217): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doRcptToCommand(\'support@tapheaw...\')\n#4 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#5 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#6 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#8 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\Channels\\MailChannel.php(66): Illuminate\\Mail\\Mailer->send(Object(Closure), Array, Object(Closure))\n#9 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(159): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(App\\Models\\User), Object(App\\Notifications\\NewMarathonRegistration))\n#10 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(116): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(App\\Models\\User), \'19e321b8-8846-4...\', Object(App\\Notifications\\NewMarathonRegistration), \'mail\')\n#11 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#12 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(111): Illuminate\\Notifications\\NotificationSender->withLocale(NULL, Object(Closure))\n#13 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewMarathonRegistration), Array)\n#14 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\SendQueuedNotifications.php(118): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewMarathonRegistration), Array)\n#15 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#16 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#18 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#19 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#20 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Container\\Container->call(Array)\n#21 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#22 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#23 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#24 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(125): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#25 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#26 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#27 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#29 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#30 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(444): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(394): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#32 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(180): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#35 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#38 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#39 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#40 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(209): Illuminate\\Container\\Container->call(Array)\n#41 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(178): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(1092): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(341): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(192): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1234): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\tapheawards\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#49 {main}', '2025-09-18 00:24:41'),
(3, 'b7690b17-bf57-48d3-8e12-03b009ac533a', 'database', 'default', '{\"uuid\":\"b7690b17-bf57-48d3-8e12-03b009ac533a\",\"displayName\":\"App\\\\Notifications\\\\NewNomineeApplication\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewNomineeApplication\\\":2:{s:14:\\\"\\u0000*\\u0000application\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\NomineeApplication\\\";s:2:\\\"id\\\";i:68;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"transaction\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"402d302e-f312-4067-988f-d3ada2dce13f\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1758249306,\"delay\":null}', 'Symfony\\Component\\Mailer\\Exception\\UnexpectedResponseException: Expected response code \"250/251/252\" but got code \"550\", with message \"550 No Such User Here\". in C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php:342\nStack trace:\n#0 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(198): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->assertResponseCode(\'550 No Such Use...\', Array)\n#1 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(150): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#2 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(268): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#3 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(217): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doRcptToCommand(\'support@tapheaw...\')\n#4 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#5 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#6 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#8 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\Channels\\MailChannel.php(66): Illuminate\\Mail\\Mailer->send(Object(Closure), Array, Object(Closure))\n#9 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(159): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(App\\Models\\User), Object(App\\Notifications\\NewNomineeApplication))\n#10 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(116): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(App\\Models\\User), \'47742a32-1f59-4...\', Object(App\\Notifications\\NewNomineeApplication), \'mail\')\n#11 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#12 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(111): Illuminate\\Notifications\\NotificationSender->withLocale(NULL, Object(Closure))\n#13 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewNomineeApplication), Array)\n#14 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\SendQueuedNotifications.php(118): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewNomineeApplication), Array)\n#15 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#16 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#18 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#19 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#20 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Container\\Container->call(Array)\n#21 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#22 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#23 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#24 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(125): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#25 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#26 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#27 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#29 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#30 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(444): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(394): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#32 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(180): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#35 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#38 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#39 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#40 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(209): Illuminate\\Container\\Container->call(Array)\n#41 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(178): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(1092): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(341): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(192): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1234): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\tapheawards\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#49 {main}', '2025-09-19 02:35:18'),
(4, '72d6e68c-0141-4b28-a02c-2d98f65806b5', 'database', 'default', '{\"uuid\":\"72d6e68c-0141-4b28-a02c-2d98f65806b5\",\"displayName\":\"App\\\\Notifications\\\\NewNomineeApplication\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewNomineeApplication\\\":2:{s:14:\\\"\\u0000*\\u0000application\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\NomineeApplication\\\";s:2:\\\"id\\\";i:69;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"transaction\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"627304be-43c7-4a9f-b95d-31b10803204c\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1758250599,\"delay\":null}', 'Symfony\\Component\\Mailer\\Exception\\UnexpectedResponseException: Expected response code \"250/251/252\" but got code \"550\", with message \"550 No Such User Here\". in C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php:342\nStack trace:\n#0 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(198): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->assertResponseCode(\'550 No Such Use...\', Array)\n#1 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(150): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#2 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(268): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#3 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(217): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doRcptToCommand(\'support@tapheaw...\')\n#4 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#5 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#6 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#8 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\Channels\\MailChannel.php(66): Illuminate\\Mail\\Mailer->send(Object(Closure), Array, Object(Closure))\n#9 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(159): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(App\\Models\\User), Object(App\\Notifications\\NewNomineeApplication))\n#10 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(116): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(App\\Models\\User), \'95d1f40c-32aa-4...\', Object(App\\Notifications\\NewNomineeApplication), \'mail\')\n#11 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#12 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(111): Illuminate\\Notifications\\NotificationSender->withLocale(NULL, Object(Closure))\n#13 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewNomineeApplication), Array)\n#14 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\SendQueuedNotifications.php(118): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewNomineeApplication), Array)\n#15 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#16 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#18 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#19 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#20 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Container\\Container->call(Array)\n#21 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#22 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#23 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#24 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(125): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#25 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#26 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#27 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#29 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#30 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(444): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(394): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#32 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(180): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#35 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#38 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#39 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#40 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(209): Illuminate\\Container\\Container->call(Array)\n#41 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(178): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(1092): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(341): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(192): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1234): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\tapheawards\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#49 {main}', '2025-09-19 02:56:52');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(5, '9610cea0-ee6a-452d-9c26-2f2a02d8efbf', 'database', 'default', '{\"uuid\":\"9610cea0-ee6a-452d-9c26-2f2a02d8efbf\",\"displayName\":\"App\\\\Notifications\\\\NewNomineeApplication\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:39:\\\"App\\\\Notifications\\\\NewNomineeApplication\\\":2:{s:14:\\\"\\u0000*\\u0000application\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\NomineeApplication\\\";s:2:\\\"id\\\";i:70;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"transaction\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"c6d0727d-dcb0-46ea-a751-6dd6743bfc10\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1758303118,\"delay\":null}', 'Symfony\\Component\\Mailer\\Exception\\UnexpectedResponseException: Expected response code \"250/251/252\" but got code \"550\", with message \"550 No Such User Here\". in C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php:342\nStack trace:\n#0 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(198): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->assertResponseCode(\'550 No Such Use...\', Array)\n#1 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(150): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#2 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(268): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand(\'RCPT TO:<suppor...\', Array)\n#3 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(217): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doRcptToCommand(\'support@tapheaw...\')\n#4 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#5 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#6 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#8 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\Channels\\MailChannel.php(66): Illuminate\\Mail\\Mailer->send(Object(Closure), Array, Object(Closure))\n#9 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(159): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(App\\Models\\User), Object(App\\Notifications\\NewNomineeApplication))\n#10 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(116): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(App\\Models\\User), \'741672be-c358-4...\', Object(App\\Notifications\\NewNomineeApplication), \'mail\')\n#11 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#12 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(111): Illuminate\\Notifications\\NotificationSender->withLocale(NULL, Object(Closure))\n#13 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewNomineeApplication), Array)\n#14 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\SendQueuedNotifications.php(118): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\NewNomineeApplication), Array)\n#15 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#16 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#17 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#18 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#19 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#20 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Container\\Container->call(Array)\n#21 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#22 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#23 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#24 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(125): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#25 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(169): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#26 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(126): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#27 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#28 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#29 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#30 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(444): Illuminate\\Queue\\Jobs\\Job->fire()\n#31 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(394): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#32 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(180): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#35 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#36 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#37 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#38 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#39 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#40 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(209): Illuminate\\Container\\Container->call(Array)\n#41 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#42 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(178): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(1092): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#44 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(341): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp\\htdocs\\tapheawards\\vendor\\symfony\\console\\Application.php(192): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp\\htdocs\\tapheawards\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1234): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp\\htdocs\\tapheawards\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#49 {main}', '2025-09-19 17:32:07'),
(6, '2423d8b3-80c7-436b-a322-e4701f6f7b3d', 'database', 'default', '{\"uuid\":\"2423d8b3-80c7-436b-a322-e4701f6f7b3d\",\"displayName\":\"App\\\\Notifications\\\\ApplicationSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:1;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:38:\\\"App\\\\Notifications\\\\ApplicationSubmitted\\\":2:{s:14:\\\"\\u0000*\\u0000application\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\NomineeApplication\\\";s:2:\\\"id\\\";i:2;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"transaction\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"5051ed11-bc77-4bcb-8492-108c911665f3\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1771522248,\"delay\":null}', 'Symfony\\Component\\Mailer\\Exception\\TransportException: Failed to authenticate on SMTP server with username \"info@businessawards.co.tz\" using the following authenticators: \"LOGIN\", \"PLAIN\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535 Incorrect authentication data\".\". in C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php:269\nStack trace:\n#0 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(199): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->handleAuth(Array)\n#1 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(150): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->doEhloCommand()\n#2 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(255): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand(\'HELO businessaw...\', Array)\n#3 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(281): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doHeloCommand()\n#4 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(211): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#5 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend(Object(Symfony\\Component\\Mailer\\SentMessage))\n#6 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#7 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send(Object(Symfony\\Component\\Mime\\Email), Object(Symfony\\Component\\Mailer\\DelayedEnvelope))\n#8 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage(Object(Symfony\\Component\\Mime\\Email))\n#9 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\Channels\\MailChannel.php(66): Illuminate\\Mail\\Mailer->send(Object(Closure), Array, Object(Closure))\n#10 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(163): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(App\\Models\\User), Object(App\\Notifications\\ApplicationSubmitted))\n#11 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(118): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(App\\Models\\User), \'a399bcef-1f91-4...\', Object(App\\Notifications\\ApplicationSubmitted), \'mail\')\n#12 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#13 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(113): Illuminate\\Notifications\\NotificationSender->withLocale(NULL, Object(Closure))\n#14 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\ApplicationSubmitted), Array)\n#15 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\SendQueuedNotifications.php(118): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Database\\Eloquent\\Collection), Object(App\\Notifications\\ApplicationSubmitted), Array)\n#16 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#17 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#18 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#19 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#20 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#21 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Container\\Container->call(Array)\n#22 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#23 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#24 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(136): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#25 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#26 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#27 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#28 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#30 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#31 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(451): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(401): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#33 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(187): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#34 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#35 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#36 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#38 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#39 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#40 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(836): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#41 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#42 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\console\\Command\\Command.php(318): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#43 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#44 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\console\\Application.php(1110): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#45 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\console\\Application.php(359): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#46 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\symfony\\console\\Application.php(194): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#47 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#48 C:\\xampp222\\htdocs\\Businessawardv2\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#49 C:\\xampp222\\htdocs\\Businessawardv2\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#50 {main}', '2026-02-20 18:28:21');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

CREATE TABLE `gallery_albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_albums`
--

INSERT INTO `gallery_albums` (`id`, `name`, `slug`, `description`, `cover_image`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'Business Awards Season II  2025', 'business-awards-season-ii-2025', 'The Night of Business Awards Season II July 2025', 'album_covers/b7bgreyPEXhmWzztjtEffmV2kiUhF4qX1yFn9cQ8.png', 1, '2025-09-15 15:54:25', '2026-02-19 16:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `guest_invitations`
--

CREATE TABLE `guest_invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_title` varchar(255) DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` varchar(255) DEFAULT NULL,
  `event_time` varchar(255) DEFAULT NULL,
  `event_venue` varchar(255) DEFAULT NULL,
  `dress_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rsvp_status` varchar(255) NOT NULL DEFAULT 'pending',
  `rsvp_at` timestamp NULL DEFAULT NULL,
  `viewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_of_honors`
--

CREATE TABLE `guest_of_honors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_of_honors`
--

INSERT INTO `guest_of_honors` (`id`, `name`, `title`, `bio`, `image_path`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mr. Vincent Bruno Minja', 'TNCC President / Board Chairman', 'Mr. Vincent Bruno Minja ni kiongozi mashuhuri katika sekta ya biashara nchini Tanzania, akihudumu kama Rais wa TNCC na Mwenyekiti wa Bodi. Ana uzoefu mpana katika uongozi wa kimkakati, maendeleo ya sekta binafsi, na kuimarisha ushirikiano kati ya wafanyabiashara na taasisi za kitaifa na kimataifa.\r\n\r\nKatika nafasi yake ya uongozi, ameongoza juhudi za kuimarisha mazingira ya biashara, kukuza uwekezaji, na kusimamia mageuzi yanayolenga kuongeza ushindani wa kampuni za Kitanzania ndani na nje ya nchi.\r\n\r\nKupitia maono yake, TNCC imeendelea kuwa jukwaa muhimu la kuunganisha wadau wa sekta binafsi na kuhamasisha ukuaji endelevu wa uchumi.\r\n\r\nKama Mgeni Rasmi wa Business Awards, uwepo wake unaakisi dhamira ya tukio hili katika kutambua ubunifu, uongozi bora, na mchango mkubwa wa biashara katika maendeleo ya taifa.', 'guest_images/7uuhVsuAlck1GgDmFMF2vog10DPpe3KDCA3zXnHZ.png', 1, '2026-02-21 19:02:17', '2026-02-21 19:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(65, 'default', '{\"uuid\":\"b0f20e83-93cc-49d1-845c-64873195faff\",\"displayName\":\"App\\\\Jobs\\\\InitiateZenoPayPayment\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\InitiateZenoPayPayment\",\"command\":\"O:31:\\\"App\\\\Jobs\\\\InitiateZenoPayPayment\\\":1:{s:11:\\\"transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\Transaction\\\";s:2:\\\"id\\\";i:5;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}\"},\"createdAt\":1771695717,\"delay\":null}', 0, NULL, 1771695717, 1771695717),
(66, 'default', '{\"uuid\":\"778171e6-9239-4a36-be5c-d684ad601ed5\",\"displayName\":\"App\\\\Notifications\\\\ApplicationSubmitted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:31;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:38:\\\"App\\\\Notifications\\\\ApplicationSubmitted\\\":2:{s:14:\\\"\\u0000*\\u0000application\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:29:\\\"App\\\\Models\\\\NomineeApplication\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:11:\\\"transaction\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"261850d8-e7a2-4038-8322-b26f0c2e7f0d\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"},\"createdAt\":1771695718,\"delay\":null}', 0, NULL, 1771695718, 1771695718);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
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
-- Table structure for table `map_sections`
--

CREATE TABLE `map_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Join Us at the Gala',
  `description` text DEFAULT NULL,
  `event_date` varchar(255) DEFAULT NULL,
  `event_time` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `google_maps_embed_url` text DEFAULT NULL,
  `dress_code` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `map_sections`
--

INSERT INTO `map_sections` (`id`, `title`, `description`, `event_date`, `event_time`, `location_name`, `google_maps_embed_url`, `dress_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Join Us at the Gala', 'Masaki - Dar es salaam, Tanzania', '24/4/2026', 'From 07:00 PM', 'The Super Dome', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d253540.34108312818!2d39.2462336!3d-6.8222976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x185c4d100db7ffaf%3A0x2adc05d8e795cfbb!2sThe%20SuperDome%20TZ%20Masaki%2C%2067PG%2BHC9%2C%20Dar%20es%20Salaam!3m2!1d-6.7635625!2d39.276062499999995!5e0!3m2!1sen!2stz!4v1771452553605!5m2!1sen!2stz\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', NULL, 1, '2026-02-18 22:09:40', '2026-02-19 16:58:25');

-- --------------------------------------------------------

--
-- Table structure for table `marathon_registrations`
--

CREATE TABLE `marathon_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_code` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `race_type` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) NOT NULL,
  `emergency_contact_phone` varchar(255) NOT NULL,
  `emergency_contact_relationship` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending_payment',
  `payment_gateway_reference` varchar(255) DEFAULT NULL,
  `payment_notes` text DEFAULT NULL,
  `tshirt_size` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_24_192740_create_categories_table', 1),
(5, '2025_06_24_192740_create_nominees_table', 1),
(6, '2025_06_24_192741_create_votes_table', 1),
(7, '2025_07_07_140600_add_votes_count_to_nominees_table', 1),
(8, '2025_07_09_161546_add_is_admin_to_users_table', 1),
(9, '2025_07_10_124833_add_description_and_image_to_categories_table', 1),
(10, '2025_07_10_202045_rename_photo_url_to_image_path_in_nominees_table', 1),
(11, '2025_07_10_212128_add_image_path_to_categories_table', 1),
(13, '2025_07_15_195643_create_winners_table', 2),
(14, '2025_07_26_202350_add_unique_constraint_to_winners_table', 3),
(15, '2025_08_11_170415_add_fingerprint_to_votes_table', 4),
(16, '2025_08_11_182955_remove_unique_ip_from_votes_table', 5),
(17, '2025_08_11_210318_add_multifactor_fingerprint_to_votes_table', 5),
(18, '2025_08_11_210321_add_multifactor_fingerprint_to_votes_table', 6),
(19, '2025_08_11_214511_modify_votes_table_for_composite_unique_hash', 6),
(20, '2025_08_13_003432_create_personal_access_tokens_table', 7),
(21, '2025_08_14_122402_create_transactions_table', 8),
(22, '2025_08_14_122545_create_nominee_applications_table', 8),
(23, '2025_08_16_011832_add_status_to_categories_table', 9),
(24, '2025_08_25_060208_add_parent_id_to_categories_table', 10),
(25, '2025_08_26_164230_update_vote_uniqueness_for_fingerprintjs', 11),
(26, '2025_08_26_165942_add_social_links_to_nominees_table', 12),
(27, '2025_08_31_041910_create_suggestions_table', 13),
(28, '2025_09_04_235239_add_fingerprint_js_to_suggestions_table', 14),
(29, '2025_09_08_134239_create_season_awards_table', 15),
(30, '2025_09_09_035519_add_nomination_fee_to_categories_table', 16),
(31, '2025_09_10_014243_add_social_links_to_nominee_applications_table', 17),
(32, '2025_09_10_180117_add_review_fields_to_nominee_applications_table', 18),
(33, '2025_09_10_211419_create_guest_invitations_table', 19),
(34, '2025_09_10_212519_add_rsvp_to_guest_invitations_table', 19),
(35, '2025_09_11_031416_add_event_details_to_guest_invitations_table', 20),
(36, '2025_09_11_032410_add_event_description_to_guest_invitations_table', 21),
(37, '2025_09_13_235134_create_posts_table', 22),
(38, '2025_09_14_215826_create_marathon_registrations_table', 23),
(39, '2025_09_15_140044_create_gallery_albums_table', 24),
(40, '2025_09_15_140046_create_gallery_photos_table', 24),
(41, '2025_09_15_165828_create_gallery_albums_table', 25),
(42, '2025_09_15_165851_add_gallery_album_id_to_posts_table', 25),
(43, '2025_09_15_223858_create_reels_table', 26),
(44, '2025_09_16_161039_update_marathon_registration_table', 27),
(45, '2025_09_17_034918_update_marathon_registrations_table', 27),
(46, '2025_09_17_041823_add_emergency_contact_relationip_to_marathon_registrations_table', 28),
(47, '2025_09_17_050520_modify__marathon_registrations_table', 29),
(48, '2025_09_19_104204_add_is_active_to_reels_table', 30),
(49, '2025_09_22_015337_create_ticket_types_table', 31),
(50, '2025_09_22_015601_create_ticket_purchase_table', 31),
(51, '2025_09_22_015722_create_tickets_table', 31),
(52, '2025_09_22_173320_add_features_to_ticket_types_table', 31),
(53, '2025_09_26_013821_add_transaction_id_to_ticket_purchases_table', 31),
(54, '2025_09_28_035555_create_sponsorship_inquiries_table', 31),
(55, '2025_10_01_000000_add_tiktok_url_to_nominees_table', 32),
(58, '2025_10_01_000000_add_sponsors_table', 33),
(59, '2025_10_01_000000_add_mapsection_table', 34),
(60, '2025_10_01_000000_add_dress_code_to_mapsection_table', 35),
(61, '2026_10_01_000000_add_tiktok_url_to_nominees_table', 36),
(62, '2025_02_21_000000_create_guest_of_honors_table', 37);

-- --------------------------------------------------------

--
-- Table structure for table `nominees`
--

CREATE TABLE `nominees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `tiktok_url` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `votes_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nominee_applications`
--

CREATE TABLE `nominee_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `applicant_phone` varchar(255) NOT NULL,
  `applicant_email` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `tiktok_url` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending_payment',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('onesmo@example.com', '$2y$12$DZJ/aLlPY0cMpmWl.V0TAu9ZjFAuGc8n9z8GmsOkbUCjJ5N6bza5O', '2025-08-14 08:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'api-token', '6f366e689ef612e2c06c4e8fc72d70cf889db9b31dbb9930cbdd2c18daadd498', '[\"*\"]', NULL, NULL, '2025-08-13 08:24:49', '2025-08-13 08:24:49'),
(2, 'App\\Models\\User', 3, 'api-token', '3c2ad258b7a531ee79eacad3dd912d87b310d249e0b4aeea9abe8f581ead21d1', '[\"*\"]', NULL, NULL, '2025-08-13 12:08:12', '2025-08-13 12:08:12'),
(3, 'App\\Models\\User', 3, 'api-token', 'b75747cec07113f0aaeb6e91d40068eb7cf91aca2d2ff9ead654c6bd6b6eeafd', '[\"*\"]', NULL, NULL, '2025-08-13 12:14:48', '2025-08-13 12:14:48'),
(4, 'App\\Models\\User', 1, 'api-token', 'bbeca66cfb1cfdcf356c6affa0756dff9e676a9b52725fbbce77b93be6542d52', '[\"*\"]', NULL, NULL, '2025-08-13 13:59:25', '2025-08-13 13:59:25'),
(5, 'App\\Models\\User', 3, 'api-token', '80c5fc91ae237c6bf57faf83b8f5825e62061e69ebabd74eabfebf570773793e', '[\"*\"]', NULL, NULL, '2025-08-13 14:02:32', '2025-08-13 14:02:32'),
(6, 'App\\Models\\User', 3, 'api-token', 'a18506a837fcb97a2288479bae3229c4c6cf980bef925a57881b5db708929584', '[\"*\"]', NULL, NULL, '2025-08-13 14:36:51', '2025-08-13 14:36:51'),
(7, 'App\\Models\\User', 3, 'api-token', '951a0eef69f8174ff3fae51be02e7f61ec90db84e2c1696a1f7d7e9d10c7919e', '[\"*\"]', NULL, NULL, '2025-08-13 15:00:12', '2025-08-13 15:00:12'),
(8, 'App\\Models\\User', 3, 'api-token', '7fd13524e5d2f1ca3f2fceaeade7ba3e1a9aa3777c98e84601439a715ff5f716', '[\"*\"]', NULL, NULL, '2025-08-13 15:30:21', '2025-08-13 15:30:21'),
(9, 'App\\Models\\User', 3, 'api-token', '8ee9c50b639bafbbf27bb147f2bf01faedc3cfa7994b02bd6b5beaab557006c6', '[\"*\"]', NULL, NULL, '2025-08-13 16:28:48', '2025-08-13 16:28:48'),
(10, 'App\\Models\\User', 3, 'api-token', 'c866e2c7dd9454a87a6e0c2cb70e4265cc2ca6da013e04ce1303c5557dae4802', '[\"*\"]', NULL, NULL, '2025-08-13 16:32:43', '2025-08-13 16:32:43'),
(11, 'App\\Models\\User', 31, 'api-token', 'e1e7bc43f784fcf3d2a8476c9fcf9e4b27f895c27a5b3bc705451f934ec8d772', '[\"*\"]', NULL, NULL, '2026-02-20 21:22:00', '2026-02-20 21:22:00'),
(12, 'App\\Models\\User', 32, 'api-token', 'cc5259022c42dc14dc29f9fb127bb29dce86f01c169cb64e22e75921da042089', '[\"*\"]', NULL, NULL, '2026-02-20 21:28:30', '2026-02-20 21:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'update',
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `featured_image` varchar(255) DEFAULT NULL,
  `media_gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`media_gallery`)),
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gallery_album_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `content`, `type`, `status`, `featured_image`, `media_gallery`, `published_at`, `created_at`, `updated_at`, `gallery_album_id`) VALUES
(3, 'USIKU WA UZINDUZI WA TUZO', 'usiku-wa-uzinduzi-wa-tuzo', 'Tarehe 13 Septemba 2025, TAPHE Awards zimezinduliwa rasmi kwa sherehe ya kuvutia iliyofanyika katika ukumbi wa King Jada Hotel, Morocco Square Building, jijini Dar es Salaam.', 'Katika hafla hiyo, mgeni rasmi alikuwa Mkuu wa Wilaya ya Kinondoni, Mheshimiwa Saad Mtambule, ambaye aliwapongeza waandaaji wa tuzo hizi kwa mchango wao mkubwa katika kuibua na kutambua  Watoa huduma bora kwenye sekta ya afya waliokonga mioyo ya wagonjwa katika utoaji huduma bora kwa uweledi mkubwa.', 'update', 'draft', NULL, NULL, '2025-09-12 06:00:00', '2025-09-13 23:20:26', '2026-02-14 23:58:38', NULL),
(4, 'photo11', 'photo11', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-13 06:00:00', '2025-09-14 00:59:56', '2026-02-14 23:58:31', 1),
(6, 'photo77', 'photo77', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-13 12:00:00', '2025-09-14 01:02:07', '2026-02-14 23:58:22', 1),
(7, 'photo55', 'photo55', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-13 12:00:00', '2025-09-14 01:06:58', '2026-02-14 23:57:58', 1),
(10, 'Photo7', 'photo7', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-13 12:00:00', '2025-09-14 01:17:08', '2026-02-14 23:57:43', 1),
(11, 'Photo6', 'photo6', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-13 12:00:00', '2025-09-14 01:26:45', '2026-02-14 23:57:32', 1),
(12, 'Photo4', 'photo4', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-13 09:00:00', '2025-09-14 01:33:05', '2026-02-14 23:56:53', 1),
(14, 'Photo8', 'photo8', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-13 06:00:00', '2025-09-14 01:37:03', '2026-02-14 23:57:18', 1),
(15, 'Photo3', 'photo3', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-12 15:00:00', '2025-09-14 01:42:11', '2026-02-14 23:57:08', 1),
(16, 'Gallery 2', 'gallery-2', NULL, NULL, 'gallery', 'published', 'post_images/n6zR5RQp8OQUYHz9qGQyWFgrF3GDmBoin3McfeDp.png', NULL, '2025-09-12 09:00:00', '2025-09-14 01:53:23', '2026-02-19 16:53:14', 1),
(17, 'Business', 'business', NULL, NULL, 'update', 'published', 'post_images/ByNcXNZF7sR9siaLY24dmGEMAunBOR7QNydZoigW.png', NULL, '2025-09-11 21:00:00', '2025-09-14 02:15:06', '2026-02-19 09:10:38', NULL),
(18, 'The Award Night Gala', 'the-award-night-gala', NULL, NULL, 'update', 'published', 'post_images/XNokvNUMM4GdHgc0Q9zZMct3CvXsyfsEGLp796X8.png', NULL, '2025-09-12 09:00:00', '2025-09-14 02:15:56', '2026-02-19 09:48:18', 1),
(20, 'TAPHE Awards', 'taphe-awards', 'Mheshimiwa Saad Mtambule, ambaye alipongeza ubunifu huu na kusisitiza kuwa tuzo hizi zitatoa hamasa kubwa kwa watoa huduma za afya kuendelea kufanya kazi kwa weledi na kujituma.', 'Mgeni rasmi katika hafla hiyo alikuwa Mkuu wa Wilaya ya Kinondoni, Mheshimiwa Saad Mtambule, ambaye alipongeza ubunifu huu na kusisitiza kuwa tuzo hizi zitatoa hamasa kubwa kwa watoa huduma za afya kuendelea kufanya kazi kwa weledi na kujituma.', 'update', 'published', 'post_images/b2qSN4Hc3GPefauUbWnPIDkkBE9jSn7JwRGCcBoI.png', NULL, '2025-09-11 14:50:00', '2025-09-19 08:51:41', '2026-02-19 09:05:04', 1),
(21, 'Photo10', 'photo10', NULL, NULL, 'gallery', 'draft', NULL, NULL, '2025-09-12 00:34:00', '2025-09-19 09:34:43', '2026-02-19 16:52:43', 1),
(22, 'Gala Night', 'gala-night', NULL, NULL, 'update', 'published', 'post_images/h4i943xnIMNKuXUx1H2P7g9DX4JOQoxLJcNNrbEy.png', NULL, '2026-02-18 11:13:00', '2026-02-18 20:05:55', '2026-02-19 09:34:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reels`
--

CREATE TABLE `reels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reels`
--

INSERT INTO `reels` (`id`, `type`, `content`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'instagram', 'https://www.instagram.com/p/DOoo32CjYVx/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA%3D%3D', 0, '2025-09-15 21:26:25', '2025-12-06 10:58:32'),
(2, 'instagram', 'https://www.instagram.com/p/DUxUSY_CFaP/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 1, '2025-09-15 21:29:55', '2026-02-21 18:23:31'),
(3, 'instagram', 'https://www.instagram.com/reel/DTuiby1CE7M/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 1, '2025-09-15 21:37:05', '2026-02-21 18:22:05'),
(4, 'instagram', 'https://www.instagram.com/p/DUDMMtlCGrC/?utm_source=ig_web_button_share_sheet&igsh=MzRlODBiNWFlZA==', 1, '2025-09-19 08:22:43', '2026-02-21 18:19:49'),
(5, 'instagram', 'https://www.instagram.com/p/DU0hYCPDBD3/?utm_source=ig_web_button_share_sheet&igsh=MzRlODBiNWFlZA==', 1, '2025-12-06 10:57:49', '2026-02-21 18:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `season_awards`
--

CREATE TABLE `season_awards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `theme` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NGT8ADXicd2ePqoLpPfn5ad5WRSV9tUxeNOxaMhu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQnF6M29qOWhNUms2aHRtUWV6dXhYUjJBUmc1dlFiNVQxeDBwSXZlZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hd2FyZHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1771695581),
('oxF3hY5y44SkxwCFuq66wmfG18EXLZ8ECcOB8umD', 31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieWpCZ0U3alMxTHZuTDdXazJJV1FSQ3R6WHVvaEcxZHBvRmx3VW5FOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9maWxlL3N0b3JhZ2UvZ3Vlc3RfaW1hZ2VzLzd1dWhWc3VBbGNrMUdnRG1GTUYydm9nMTBEUHBlM0tEQ0EzelhuSFoucG5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MzE7fQ==', 1771701671),
('xg2J2u6x6ObD35Wwhs85kePa3FDRdm4nWGOZOS4C', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRUVldGFaZUVwS1NCZ3k2Y1lRdXRMR2htS0pFdURlam1jNUl0eWo1WCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo5MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2ZpbGUvc3RvcmFnZS9ndWVzdF9pbWFnZXMvN3V1aFZzdUFsY2sxR2dEbUZNRjJ2b2cxMERQcGUzS0RDQTN6WG5IWi5wbmciO319', 1771701396);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'voting_active', '0', '2025-07-26 07:58:58', '2026-02-21 18:06:41'),
(2, 'voting_deadline', '2026-07-10T14:59', '2025-07-26 07:58:58', '2026-02-18 17:34:42'),
(3, 'show_winners', '0', '2025-07-26 17:45:45', '2026-02-21 18:06:41'),
(4, 'marathon_fee', '35000', '2025-09-16 23:57:15', '2025-09-19 09:16:41'),
(5, 'nomination_open_title', 'Business Awards Season 3', '2025-09-19 09:16:41', '2026-02-14 17:07:06'),
(6, 'nomination_open_dates', 'Nomination Application is Open', '2025-09-19 09:16:41', '2026-02-18 17:34:42'),
(7, 'timeline_step1_title', 'Night Gala Dinner', '2025-09-27 23:48:33', '2026-02-15 00:11:57'),
(8, 'timeline_step1_date', '15 Feb', '2025-09-27 23:48:33', '2026-02-14 17:05:08'),
(9, 'timeline_step2_title', 'Nominee Applications', '2025-09-27 23:48:33', '2025-09-27 23:48:33'),
(10, 'timeline_step2_date', '15 Feb - 30 March', '2025-09-27 23:48:33', '2026-02-14 17:05:08'),
(11, 'timeline_step3_title', 'Awards Gala Night', '2025-09-27 23:48:33', '2026-02-20 20:39:27'),
(12, 'timeline_step3_date', '27 th April', '2025-09-27 23:48:33', '2026-02-20 20:39:27'),
(13, 'timeline_step4_title', 'Online Vote Casting', '2025-09-27 23:48:33', '2026-02-20 20:39:27'),
(14, 'timeline_step4_date', '1st April - 25 April', '2025-09-27 23:48:33', '2026-02-20 20:39:27'),
(15, 'timeline_step5_title', 'Awards Gala Night', '2025-09-27 23:48:33', '2026-02-20 20:39:27'),
(16, 'timeline_step5_date', '27 th April', '2025-09-27 23:48:33', '2026-02-20 20:39:27'),
(17, 'allow_online_applications', '0', '2026-02-21 18:06:41', '2026-02-21 18:06:41'),
(18, 'application_support_phone', '+255 652 724 557', '2026-02-21 18:06:41', '2026-02-21 18:06:41');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `tier` enum('main','platinum','gold','silver','bronze','partner') NOT NULL DEFAULT 'partner',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `name`, `logo_path`, `website_url`, `tier`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'Natkern', 'sponsors/de5ePJEWb7MaTwQtyfZYQS0hfV1194xhpxggDJ4I.png', NULL, 'partner', 1, 0, '2026-02-18 21:13:31', '2026-02-21 16:55:48'),
(2, 'Juy Entreprises', 'sponsors/LmUEWL67Y3tifMnkr5BjM44fge3rO1JcDgkKfcOC.jpg', NULL, 'partner', 1, 2, '2026-02-18 21:14:52', '2026-02-18 21:15:37'),
(3, 'Africars', 'sponsors/UQ1Q1aaa5woP8ypzQwMEmZ3i5yTur6ZIFZVSIA1I.jpg', NULL, 'platinum', 1, 3, '2026-02-18 21:15:24', '2026-02-18 21:15:24'),
(4, 'uongoztalks', 'sponsors/PG3Rgsa3PAji95dmGvoZ3I1yxG1KxidTXFXH0x1R.png', NULL, 'main', 1, 0, '2026-02-21 16:56:26', '2026-02-21 16:56:26'),
(5, 'jabal', 'sponsors/zfxzyCuousKlGAVhp0UThJciPomOHfGkEn7fJqMA.png', NULL, 'partner', 1, 0, '2026-02-21 16:56:52', '2026-02-21 16:56:52'),
(6, 'pax', 'sponsors/UMI4PwOwHt9IjRC9fnbcAPv2d4qYqatVSPHF3e96.png', NULL, 'platinum', 1, 0, '2026-02-21 16:57:14', '2026-02-21 16:57:14'),
(7, 'whitesign', 'sponsors/vGOb4ISFM54H8rN8PKZuGS2aoGcnGtBQVoBydrFZ.png', NULL, 'partner', 1, 0, '2026-02-21 18:14:06', '2026-02-21 18:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `sponsorship_inquiries`
--

CREATE TABLE `sponsorship_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tier` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

CREATE TABLE `suggestions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `suggested_nominee_name` varchar(255) NOT NULL,
  `suggested_nominee_phone` varchar(255) DEFAULT NULL,
  `suggested_nominee_workplace` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text NOT NULL,
  `suggester_name` varchar(255) DEFAULT NULL,
  `suggester_email` varchar(255) DEFAULT NULL,
  `fingerprint_js` varchar(255) DEFAULT NULL,
  `status` enum('pending','reviewed','rejected','accepted') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_code` varchar(255) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `checked_in_at` timestamp NULL DEFAULT NULL,
  `checked_in_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_purchases`
--

CREATE TABLE `ticket_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_type_id` bigint(20) UNSIGNED NOT NULL,
  `purchaser_name` varchar(255) NOT NULL,
  `purchaser_email` varchar(255) NOT NULL,
  `purchaser_phone` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending_payment',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE `ticket_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `price` decimal(10,2) NOT NULL,
  `quantity_available` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` char(36) NOT NULL,
  `payable_type` varchar(255) NOT NULL,
  `payable_id` bigint(20) UNSIGNED NOT NULL,
  `gateway_reference` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'TZS',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_id`, `payable_type`, `payable_id`, `gateway_reference`, `amount`, `currency`, `status`, `payment_method`, `phone_number`, `notes`, `created_at`, `updated_at`) VALUES
(3, 17, 'e8a498c7-5e7d-4b0f-8000-eaa5b3285245', 'App\\Models\\NomineeApplication', 1, '1378045375', '100000.00', 'TZS', 'completed', NULL, '255718355824', 'Webhook: Payment completed successfully.', '2025-09-25 06:35:53', '2025-09-25 17:12:29'),
(4, 1, '95624155-59d7-4ce8-9c83-8a8de7b8d68a', 'App\\Models\\NomineeApplication', 2, NULL, '1000.00', 'TZS', 'initiation_failed', NULL, '255743331626', 'API call failed: {\"status\":\"error\",\"step\":\"order_creation\",\"message\":\"Validation failed\",\"errors\":{\"order_id\":[\"selcom order with this order id already exists.\"]}}', '2026-02-19 17:30:47', '2026-02-20 18:28:22'),
(5, 31, '7992c792-cb48-4a3e-aba7-fc125abf1cdb', 'App\\Models\\NomineeApplication', 3, NULL, '1000.00', 'TZS', 'pending', NULL, '255743331626', NULL, '2026-02-21 17:41:56', '2026-02-21 17:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'info@tapheawards.co.tz', 1, '2025-07-10 13:24:31', '$2y$12$d/.4Jy.stLx6vEvNMMWXjuCrfwW0aEWRqH9sA3zj27vF6c7DeJZsi', 'XJ4FtpkWjBAzn01nHWO1UVgYg5sG31suS0RyD3L5gpboOrNnT9lmW9BWF8Jk', '2025-07-10 13:24:31', '2025-09-09 14:39:22'),
(12, 'Onesmo', 'onesmoalexander@gmail.com', 0, NULL, '$2y$12$eL1NnS67Aa.McGCmnQkFiufMNEdFUwhAoTln.QeyHDHG4zByGDv4S', NULL, '2025-09-10 18:13:10', '2025-09-10 18:13:10'),
(13, 'Mercy Julian', 'mrcyjulian@yahoo.co.uk', 0, NULL, '$2y$12$sUnT5GyePk4pAQkQA.zVaec6U96Jf/wuUxAPkjgB1wl3Hz6aa8Vj2', NULL, '2025-09-12 09:52:58', '2025-09-12 09:52:58'),
(14, 'Helfrid Romano MPOLO', 'helfridrm@gmail.com', 0, NULL, '$2y$12$h6ZYJkmglP.w/Xocw7mydej2u7Q8fjuhzk34/vXJ3SfwXDSUDTFVe', NULL, '2025-09-12 11:34:13', '2025-09-12 11:34:13'),
(15, 'Secilia', 'lightnessrobert12@gmail.com', 0, NULL, '$2y$12$WGehhgm.t65YX86bnyScd.CnF7eIHU/YUDu6zf7GrO81Zco7gRUD.', NULL, '2025-09-13 02:00:34', '2025-09-13 02:00:34'),
(16, 'Dr William clinic', 'drwilliamusa@gmail.com', 0, NULL, '$2y$12$oSb3ysNH6EvkS1bFkG0FCuCndOjnpEd6ZBPnvfks83bWC7BcY1wfy', NULL, '2025-09-13 06:13:10', '2025-09-13 06:13:10'),
(17, 'SOFIA SANGA', 'sofiasanga86@gmail.com', 0, NULL, '$2y$12$BpPXbA7Ehp0CdvOmh04z8O9fwjEpPLyN6L0slbQkXPC5z.9zW0amK', NULL, '2025-09-14 23:59:46', '2025-09-14 23:59:46'),
(18, 'Allen Eliakim Panga', 'pangaallen89@gmail.com', 0, NULL, '$2y$12$CxMkow.mtKoVi7GAWsA0LeYgrgYOp.7w8l1V7ndrBVepdWSckOYKG', NULL, '2025-09-15 20:49:46', '2025-09-15 20:49:46'),
(20, 'Christopher', 'mhagamachristopher15@gmail.com', 0, NULL, '$2y$12$eoQNu46v9QoIYiNtcMG5eurEeYWh2MVYF4Euc2uPAdU2VLPQJSTo6', NULL, '2025-09-19 12:57:11', '2025-09-19 12:57:11'),
(21, 'Mercy Julian', 'mercymwamunyi@yahoo.com', 0, NULL, '$2y$12$LAR1BIkCuOQHeHVepy2dRe36M6lSJOZ83MJwKTrWnHe.EHqWiuwrO', NULL, '2025-09-24 14:45:54', '2025-09-24 14:45:54'),
(22, 'Aaron George Loy', 'aaronloy0610@gmail.com', 0, NULL, '$2y$12$wzypyetANFdpuEXpjFCkJey9lAvx6bXJZHqMvHNIFMc0gZ/bV0SaC', NULL, '2025-10-09 04:03:32', '2025-10-09 04:03:32'),
(23, 'Dezidel Kataryeba Peter', 'desderypeter095@gmail.com', 0, NULL, '$2y$12$4WN4tm6if9Ey6i9MqUf4B.ZV1fPnuEjKPfvwuytC1RFsc7n.1CTkC', NULL, '2025-10-09 06:42:16', '2025-10-09 06:42:16'),
(24, 'Christian Mwatowine', 'mwatowine.christian@gmail.com', 0, NULL, '$2y$12$1b4/zH3PyW5l/Tc2i/fvO.2aPxlcGtGw2Zf.QlbPldmWT7MhgzfE2', NULL, '2025-10-10 06:00:04', '2025-10-10 06:00:04'),
(25, 'Coletha kimario', 'kimariocoletha@gmail.com', 0, NULL, '$2y$12$8a48suDLSsenm2KiXQnj0.2PDHbC5hWWJ2ap1LjY8WdySI.cdnbaW', NULL, '2025-10-10 12:22:06', '2025-10-10 12:22:06'),
(26, 'Jackson', 'jacksonnyamle5@gmail.com', 0, NULL, '$2y$12$pwbV9MUY9sDeT6NfKpHYmuAjot1j5DXbv.Qkti9oUGtHSEX6wVr3u', NULL, '2025-10-19 14:45:40', '2025-10-19 14:45:40'),
(27, 'Testing User', 'mzeetibakya@gmail.com', 0, NULL, '$2y$12$zIGEXaLAHwJIoGxBLVt1HO2QMcNe39ZuhCNNlFQu0/NWufUfM4ofG', NULL, '2026-02-20 20:41:29', '2026-02-20 20:41:29'),
(28, 'Test3', 'test3@gmail.com', 0, NULL, '$2y$12$sRskxgxzoz59GneVOpJ6IeT9ovDzjfTADHWGbUJz0AT6krkSbOEGC', NULL, '2026-02-20 20:51:33', '2026-02-20 20:51:33'),
(29, 'Test4', 'test4@gmail.com', 0, NULL, '$2y$12$9XtTRWp73afaRn2d0g9mmeIQ08j49v1YBdF1vJKI2O.6xfsW5sAu.', NULL, '2026-02-20 21:05:05', '2026-02-20 21:05:05'),
(30, 'test5', 'test5@gmail.com', 0, NULL, '$2y$12$uYgUh7z6K78.n8P4ImAgQuBSKE0sEOkwA.FQP2npuq/iz3R4mouAa', NULL, '2026-02-20 21:06:30', '2026-02-20 21:06:30'),
(31, 'test1', 'test1@gmail.com', 0, NULL, '$2y$12$tModItlcTAY4pJ9pgWwj.OgRwyw04SiDsMDeyctbANGHB3.iK/Dba', NULL, '2026-02-20 21:22:00', '2026-02-20 21:22:00'),
(32, 'test6', 'test6@gmail.com', 0, NULL, '$2y$12$9xnpTu3j2G9zm4/BB7HUN.OJt7FF/K1tCePzL9mZVfPtr03n/y6mm', NULL, '2026-02-20 21:28:30', '2026-02-20 21:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nominee_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `fingerprint` varchar(255) DEFAULT NULL,
  `fingerprint_js` varchar(255) DEFAULT NULL,
  `screen_resolution` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `multi_factor_hash` varchar(255) DEFAULT NULL,
  `voted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `nominee_id`, `category_id`, `ip_address`, `user_agent`, `fingerprint`, `fingerprint_js`, `screen_resolution`, `timezone`, `language`, `multi_factor_hash`, `voted_at`, `created_at`, `updated_at`) VALUES
(1, 200, 165, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '0bbec1a42ae92f9e45393afa9b3639c4197ea01eeccffaa11406ce2d9c0ba9a4', '3e0686fe16f82cbf2373993c94811f12', '1280x720', 'Africa/Dar_es_Salaam', 'en-US', '23d664398e92b5117f2e71f156c9fe38dc96d134ebbdd302c23a073be6ea8dda', '2026-02-18 20:16:17', '2026-02-18 20:16:17', '2026-02-18 20:16:17'),
(2, 200, 165, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '0bbec1a42ae92f9e45393afa9b3639c4197ea01eeccffaa11406ce2d9c0ba9a4', '9c275e1974f6e80a0a8aa80c7926b959', '1280x720', 'Africa/Dar_es_Salaam', 'en-US', '7f7ac6ecceb1bea9f90247242b98f6fd9625170b2764da0d70b29ab271cd0b65', '2026-02-19 17:34:01', '2026-02-19 17:34:01', '2026-02-19 17:34:01'),
(3, 199, 165, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '5cc0105f88848b2b82e7a945b51d10287624cc0f4c906bf8e4077653cdc110e8', '3fb8846ffbe9158143a68c4b9f12eebf', '375x667', 'Africa/Dar_es_Salaam', 'en-US', '122521aa321496ef1f5d123fc99ae2bdac36b4e125a1c98112df5c2adebee199', '2026-02-19 17:37:09', '2026-02-19 17:37:09', '2026-02-19 17:37:09'),
(4, 200, 165, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', '5cc0105f88848b2b82e7a945b51d10287624cc0f4c906bf8e4077653cdc110e8', 'b9ec200e74fdb5045dd0db2f73d38cf6', '390x844', 'Africa/Dar_es_Salaam', 'en-US', '6c63368d88730df22f520096a5d5febb4cac13a47a549a599fa7d642ca1701c1', '2026-02-19 17:37:36', '2026-02-19 17:37:36', '2026-02-19 17:37:36'),
(5, 201, 168, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '0bbec1a42ae92f9e45393afa9b3639c4197ea01eeccffaa11406ce2d9c0ba9a4', '4d1506994ea33a94d3413bdb7d0c47c9', '1280x720', 'Africa/Dar_es_Salaam', 'en-US', '32886d1a15d1729887fe075a6941f30210eae61574b5192df5bf71f2a8650e4b', '2026-02-20 14:12:23', '2026-02-20 14:12:23', '2026-02-20 14:12:23'),
(6, 202, 168, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '07ce0a43600db89d13ee181ce84f20a49cd84684371670dd4323c13edb423d4f', '2c70fb3714945d56e5a3fb97caa98ddb', '412x915', 'Africa/Dar_es_Salaam', 'en-US', '521cee45e57d7fa85ea4c9bb4082cbbd8c38044a82efea8bd7e6d763fd19658c', '2026-02-20 14:15:24', '2026-02-20 14:15:24', '2026-02-20 14:15:24'),
(7, 201, 168, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G955U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Mobile Safari/537.36', '0ce47a51ecad356a876ff8fc9fc7e4901f25b7684839ae2a9253376ccd8e276f', '6c726e3fd13d796fc455d01d2e6fe1bc', '360x740', 'Africa/Dar_es_Salaam', 'en-US', 'ad534dd6c29fb2682dfd5dd882a981d2cd50dd21f91a1ec92beb0346fa7fdffb', '2026-02-20 14:15:47', '2026-02-20 14:15:47', '2026-02-20 14:15:47');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE `winners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nominee_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `award_ceremony_date` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gallery_albums_slug_unique` (`slug`);

--
-- Indexes for table `guest_invitations`
--
ALTER TABLE `guest_invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guest_invitations_uuid_unique` (`uuid`);

--
-- Indexes for table `guest_of_honors`
--
ALTER TABLE `guest_of_honors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `map_sections`
--
ALTER TABLE `map_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marathon_registrations`
--
ALTER TABLE `marathon_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marathon_registrations_unique_code_unique` (`unique_code`),
  ADD UNIQUE KEY `marathon_registrations_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nominees`
--
ALTER TABLE `nominees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nominees_category_id_foreign` (`category_id`);

--
-- Indexes for table `nominee_applications`
--
ALTER TABLE `nominee_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nominee_applications_user_id_foreign` (`user_id`),
  ADD KEY `nominee_applications_category_id_foreign` (`category_id`),
  ADD KEY `nominee_applications_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_gallery_album_id_foreign` (`gallery_album_id`);

--
-- Indexes for table `reels`
--
ALTER TABLE `reels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `season_awards`
--
ALTER TABLE `season_awards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `season_awards_year_unique` (`year`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsorship_inquiries`
--
ALTER TABLE `sponsorship_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suggestions_category_id_foreign` (`category_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tickets_ticket_code_unique` (`ticket_code`),
  ADD KEY `tickets_ticket_purchase_id_foreign` (`ticket_purchase_id`),
  ADD KEY `tickets_checked_in_by_foreign` (`checked_in_by`);

--
-- Indexes for table `ticket_purchases`
--
ALTER TABLE `ticket_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_purchases_user_id_foreign` (`user_id`),
  ADD KEY `ticket_purchases_ticket_type_id_foreign` (`ticket_type_id`),
  ADD KEY `ticket_purchases_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_order_id_unique` (`order_id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_payable_type_payable_id_index` (`payable_type`,`payable_id`),
  ADD KEY `transactions_gateway_reference_index` (`gateway_reference`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vote_category_hash_unique` (`category_id`,`multi_factor_hash`),
  ADD UNIQUE KEY `votes_category_id_fingerprint_js_unique` (`category_id`,`fingerprint_js`),
  ADD KEY `votes_fingerprint_index` (`fingerprint`),
  ADD KEY `votes_nominee_id_foreign` (`nominee_id`);

--
-- Indexes for table `winners`
--
ALTER TABLE `winners`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `winners_category_id_year_unique` (`category_id`,`year`),
  ADD KEY `winners_nominee_id_foreign` (`nominee_id`),
  ADD KEY `winners_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guest_invitations`
--
ALTER TABLE `guest_invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_of_honors`
--
ALTER TABLE `guest_of_honors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `map_sections`
--
ALTER TABLE `map_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marathon_registrations`
--
ALTER TABLE `marathon_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `nominees`
--
ALTER TABLE `nominees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `nominee_applications`
--
ALTER TABLE `nominee_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `reels`
--
ALTER TABLE `reels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `season_awards`
--
ALTER TABLE `season_awards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sponsorship_inquiries`
--
ALTER TABLE `sponsorship_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suggestions`
--
ALTER TABLE `suggestions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_purchases`
--
ALTER TABLE `ticket_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `winners`
--
ALTER TABLE `winners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nominees`
--
ALTER TABLE `nominees`
  ADD CONSTRAINT `nominees_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nominee_applications`
--
ALTER TABLE `nominee_applications`
  ADD CONSTRAINT `nominee_applications_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nominee_applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `nominee_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_gallery_album_id_foreign` FOREIGN KEY (`gallery_album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD CONSTRAINT `suggestions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_checked_in_by_foreign` FOREIGN KEY (`checked_in_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tickets_ticket_purchase_id_foreign` FOREIGN KEY (`ticket_purchase_id`) REFERENCES `ticket_purchases` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_purchases`
--
ALTER TABLE `ticket_purchases`
  ADD CONSTRAINT `ticket_purchases_ticket_type_id_foreign` FOREIGN KEY (`ticket_type_id`) REFERENCES `ticket_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_purchases_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `winners`
--
ALTER TABLE `winners`
  ADD CONSTRAINT `winners_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `winners_nominee_id_foreign` FOREIGN KEY (`nominee_id`) REFERENCES `nominees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
