-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Ago-2024 às 21:14
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `crm`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_assinantes`
--

CREATE TABLE `wp_assinantes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cpf_cnpj` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile_phone` varchar(20) DEFAULT NULL,
  `postal_code` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address_number` varchar(10) NOT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `user_type` varchar(50) NOT NULL,
  `subscription_status` varchar(50) NOT NULL,
  `subscription_start_date` date NOT NULL,
  `asaas_customer_id` varchar(255) NOT NULL,
  `asaas_subscription_id` varchar(255) NOT NULL,
  `subscription_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vendor_id` int(11) DEFAULT NULL,
  `related_to` int(11) DEFAULT NULL,
  `split_removed` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_type` enum('TITULAR','DEPENDENTE') NOT NULL DEFAULT 'TITULAR'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_assinantes`
--

INSERT INTO `wp_assinantes` (`id`, `name`, `email`, `cpf_cnpj`, `phone`, `mobile_phone`, `postal_code`, `address`, `address_number`, `complement`, `province`, `city`, `uf`, `user_type`, `subscription_status`, `subscription_start_date`, `asaas_customer_id`, `asaas_subscription_id`, `subscription_value`, `vendor_id`, `related_to`, `split_removed`, `created_at`, `updated_at`, `role_type`) VALUES
(553, 'Biffe', NULL, '12636975004', NULL, NULL, '', '', '', NULL, '', NULL, NULL, '', 'ACTIVE', '0000-00-00', '', '', 0.00, NULL, 545, 0, '2024-08-10 21:05:37', '2024-08-12 19:28:45', 'DEPENDENTE'),
(554, 'Mário', NULL, '72913498000', NULL, NULL, '', '', '', NULL, '', NULL, NULL, '', 'ACTIVE', '0000-00-00', '', '', 0.00, NULL, 545, 0, '2024-08-10 21:15:49', '2024-08-12 19:28:45', 'DEPENDENTE'),
(555, 'Adalberto', 'aaQHd@demo.com', '37120255800', '6140047327', '6140047327', '91310000', 'Avenida Protásio Alves', '4482', 'TbZHc', 'Três Figueiras', 'Porto Alegre', 'RS', '', 'ACTIVE', '2024-08-12', 'cus_000006155835', 'sub_okfyy159okr7i7lq', 73.82, NULL, NULL, 0, '2024-08-12 18:54:19', '2024-08-12 18:54:49', 'TITULAR'),
(556, 'Fredo', NULL, '53235727019', NULL, NULL, '', '', '', NULL, '', NULL, NULL, '', 'ACTIVE', '0000-00-00', '', '', 0.00, NULL, 555, 0, '2024-08-12 18:54:48', '2024-08-12 18:54:48', 'DEPENDENTE'),
(557, 'Adalbertano', 'xLTYx@example.com', '31235575020', '9725288863', '9725288863', '91310000', 'ardzJOdSUskWFok', '782', 'uXsVa', 'iwDAPqbNho', '', '', '', 'ACTIVE', '2024-08-12', 'cus_000006155837', 'sub_lj3ck9e87zlaxcu3', 73.82, NULL, NULL, 0, '2024-08-12 18:57:00', '2024-08-12 18:59:54', 'TITULAR'),
(558, 'Marujo', '', '38311306044', '', '', '91310000', 'ardzJOdSUskWFok', '782', 'uXsVa', 'iwDAPqbNho', '', '', '', 'ACTIVE', '2024-08-12', 'cus_000006155837', 'sub_lj3ck9e87zlaxcu3', 0.00, NULL, 557, 0, '2024-08-12 18:57:00', '2024-08-13 16:06:09', 'DEPENDENTE'),
(562, 'asdasdasd', '', '09315800052', '', '', '91310000', 'Avenida Protásio Alves', '12', '', 'Três Figueiras', 'Porto Alegre', 'RS', '', 'ACTIVE', '2024-08-13', 'cus_000006157192', 'sub_g86efgmhcah8k9sy', 0.00, 1, 561, 0, '2024-08-13 15:38:47', '2024-08-13 15:43:25', 'DEPENDENTE');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_assinantes_archived`
--

CREATE TABLE `wp_assinantes_archived` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cpf_cnpj` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile_phone` varchar(20) DEFAULT NULL,
  `postal_code` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address_number` varchar(10) NOT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `user_type` varchar(50) NOT NULL,
  `subscription_status` varchar(50) NOT NULL,
  `subscription_start_date` date NOT NULL,
  `asaas_customer_id` varchar(255) NOT NULL,
  `asaas_subscription_id` varchar(255) NOT NULL,
  `subscription_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vendor_id` int(11) DEFAULT NULL,
  `related_to` int(11) DEFAULT NULL,
  `role_type` enum('TITULAR','DEPENDENTE') NOT NULL DEFAULT 'TITULAR',
  `split_removed` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `archived_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_assinantes_archived`
--

INSERT INTO `wp_assinantes_archived` (`id`, `name`, `email`, `cpf_cnpj`, `phone`, `mobile_phone`, `postal_code`, `address`, `address_number`, `complement`, `province`, `city`, `uf`, `user_type`, `subscription_status`, `subscription_start_date`, `asaas_customer_id`, `asaas_subscription_id`, `subscription_value`, `vendor_id`, `related_to`, `role_type`, `split_removed`, `created_at`, `updated_at`, `archived_at`) VALUES
(562, 'hoje ou amanhã ou terça', 'lead1@example.com', '29870096077', '1234567891', '1234567891', '91310000', 'Avenida Protásio Alves', '12', '', 'Três Figueiras', 'Porto Alegre', 'RS', '', 'ACTIVE', '2024-08-13', 'cus_000006157192', 'sub_g86efgmhcah8k9sy', 73.82, 1, NULL, 'TITULAR', 0, '2024-08-13 15:38:47', '2024-08-13 15:43:25', '2024-08-13 15:47:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_checkout_links`
--

CREATE TABLE `wp_checkout_links` (
  `id` int(11) NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `lead_id` bigint(20) NOT NULL,
  `plan_id` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_checkout_links`
--

INSERT INTO `wp_checkout_links` (`id`, `uuid`, `lead_id`, `plan_id`, `created_at`, `expires_at`) VALUES
(43, 'fb29bba9-edcf-4c17-a9cd-d205361125ff', 598, 0, '2024-08-01 15:22:14', '2024-08-02 15:22:14'),
(44, 'ac56b17e-3ebe-4811-8d88-c1616bc5c746', 598, 0, '2024-08-06 18:07:46', '2024-08-07 18:07:46'),
(45, '50adf990-5edc-4270-867c-a3cead5bc513', 598, 0, '2024-08-06 18:40:23', '2024-08-07 18:40:23'),
(46, '7653d5cc-8fba-44e9-b227-9e08ca2111b1', 598, 0, '2024-08-07 13:43:57', '2024-08-08 13:43:57'),
(47, 'cf25dbfc-99bc-44e6-b548-de2b529f02fb', 598, 0, '2024-08-09 19:07:46', '2024-08-10 19:07:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_commentmeta`
--

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_comments`
--

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'Um comentarista do WordPress', 'wapuu@wordpress.example', 'https://br.wordpress.org/', '', '2024-07-03 16:02:51', '2024-07-03 19:02:51', 'Oi, isto é um comentário.\nPara iniciar a moderar, editar e excluir comentários, visite a tela Comentários no painel.\nOs avatares dos comentaristas vêm do <a href=\"https://br.gravatar.com/\">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_leads_archived`
--

CREATE TABLE `wp_leads_archived` (
  `id` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `lead_name` varchar(255) NOT NULL,
  `lead_email` varchar(255) NOT NULL,
  `lead_phone` varchar(50) NOT NULL,
  `lead_cpf_cnpj` varchar(20) NOT NULL,
  `lead_company` varchar(255) NOT NULL,
  `lead_position` varchar(255) NOT NULL,
  `lead_source` varchar(50) NOT NULL DEFAULT 'other',
  `lead_status` varchar(50) NOT NULL,
  `deal_value` decimal(10,2) NOT NULL,
  `deal_stage` varchar(50) NOT NULL,
  `expected_close_date` date NOT NULL,
  `last_contacted_date` date NOT NULL,
  `contact_method` varchar(50) NOT NULL,
  `next_action_date` date NOT NULL,
  `next_action_description` text NOT NULL,
  `activity_log` longtext NOT NULL,
  `lead_notes` text NOT NULL,
  `lead_priority` varchar(50) NOT NULL DEFAULT 'low',
  `lead_assigned_to` varchar(255) NOT NULL,
  `lead_tags` longtext NOT NULL,
  `lead_type` varchar(50) NOT NULL DEFAULT 'pf',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_leads_archived`
--

INSERT INTO `wp_leads_archived` (`id`, `original_id`, `lead_name`, `lead_email`, `lead_phone`, `lead_cpf_cnpj`, `lead_company`, `lead_position`, `lead_source`, `lead_status`, `deal_value`, `deal_stage`, `expected_close_date`, `last_contacted_date`, `contact_method`, `next_action_date`, `next_action_description`, `activity_log`, `lead_notes`, `lead_priority`, `lead_assigned_to`, `lead_tags`, `lead_type`, `created_at`, `updated_at`, `archived_at`) VALUES
(1, 602, 'mais um hoje aqui', 'lead1@example.com', '(12) 3456-7891', '687.241.950-49', 'Company D', 'CEO', 'facebook', 'offer_accepted', 35.00, 'Stage 4', '2024-07-29', '2024-06-30', 'Email', '2024-08-03', 'Follow-up action 1', '', 'Notes for lead 1', 'low', '', 'asdaasdasd,dasdasdasd', 'pf', '2024-07-17 09:34:40', '2024-07-22 21:12:44', '2024-07-23 00:13:15'),
(2, 443, 'Lead teste', 'lead2@example.com', '(12) 3456-7892', '', 'Company C', 'Director', 'facebook', 'offer_accepted', 35.00, 'Stage 4', '2024-07-06', '2024-06-27', 'Email', '2024-07-06', 'Follow-up action 2', '', 'Notes for lead 2', 'low', '1', '', 'pj', '2024-07-04 21:24:22', '2024-07-24 19:35:51', '2024-07-24 22:36:45'),
(3, 594, 'Messi', 'test@example.us', '(60) 1952-1325', '23.437.503/0001-24', 'Google', '', 'other', 'offer_accepted', 0.00, '', '0000-00-00', '0000-00-00', '', '0000-00-00', '', '', '', 'low', '1', '', 'pj', '2024-07-15 17:14:36', '2024-07-24 19:39:38', '2024-07-24 22:40:38'),
(4, 597, 'AAA abduler', 'lead1@example.com', '(12) 3456-7891', '77.777.777/7777-7777', 'Company C', 'CEO', 'facebook', 'offer_accepted', 30.00, 'Stage 4', '2024-07-29', '2024-06-30', 'Email', '2024-08-03', 'Follow-up action 1', '', 'Notes for lead 1', 'low', '1', 'asdaasdasd,dasdasdasd,teste,teste', 'pj', '2024-07-16 19:32:03', '2024-08-01 15:09:06', '2024-08-01 18:11:21'),
(5, 603, 'hoje ou amanhã ou terça', 'lead1@example.com', '(12) 3456-7891', '', 'Company D', 'CEO', 'facebook', 'offer_accepted', 35.00, 'Stage 4', '2024-07-29', '2024-06-30', 'Email', '2024-08-03', 'Follow-up action 1', '', 'Notes for lead 1', 'low', '1', 'asdaasdasd,dasdasdasd', 'pj', '2024-07-17 09:35:41', '2024-08-13 15:36:19', '2024-08-13 18:38:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_links`
--

CREATE TABLE `wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_notifications`
--

CREATE TABLE `wp_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `origin_type` varchar(50) DEFAULT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'unread',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_notifications`
--

INSERT INTO `wp_notifications` (`id`, `user_id`, `name`, `message`, `type`, `origin_type`, `origin_id`, `status`, `created_at`, `updated_at`) VALUES
(28, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 594, 'read', '2024-07-15 17:49:21', '2024-07-16 21:51:29'),
(29, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 451, 'unread', '2024-07-16 22:00:05', '2024-07-16 22:00:05'),
(30, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 431, 'unread', '2024-07-16 22:09:58', '2024-07-16 22:09:58'),
(31, 2, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 602, 'unread', '2024-07-18 16:13:41', '2024-07-18 16:13:41'),
(32, 2, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 602, 'unread', '2024-07-18 16:17:11', '2024-07-18 16:17:11'),
(33, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 431, 'unread', '2024-07-22 20:52:18', '2024-07-22 20:52:18'),
(34, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 431, 'unread', '2024-07-22 20:53:35', '2024-07-22 20:53:35'),
(35, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 451, 'unread', '2024-07-22 20:59:18', '2024-07-22 20:59:18'),
(36, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 600, 'unread', '2024-07-22 21:05:10', '2024-07-22 21:05:10'),
(37, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 602, 'unread', '2024-07-22 21:12:44', '2024-07-22 21:12:44'),
(38, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 443, 'unread', '2024-07-24 19:35:51', '2024-07-24 19:35:51'),
(39, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 594, 'unread', '2024-07-24 19:39:10', '2024-07-24 19:39:10'),
(43, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 601, 'unread', '2024-08-13 15:33:48', '2024-08-13 15:33:48'),
(44, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 603, 'unread', '2024-08-13 15:36:19', '2024-08-13 15:36:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_notifications_archived`
--

CREATE TABLE `wp_notifications_archived` (
  `id` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `origin_type` varchar(50) DEFAULT NULL,
  `origin_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'unread',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_notifications_archived`
--

INSERT INTO `wp_notifications_archived` (`id`, `original_id`, `user_id`, `name`, `message`, `type`, `origin_type`, `origin_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:41:17', '2024-07-10 22:42:30'),
(2, 2, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:41:16', '2024-07-10 22:42:29'),
(3, 4, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:41:18', '2024-07-10 22:42:44'),
(4, 1, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:41:10', '2024-07-10 22:42:43'),
(5, 5, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:42:24', '2024-07-10 22:42:50'),
(6, 7, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:43:04', '2024-07-11 18:19:31'),
(7, 6, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:42:57', '2024-07-11 18:19:28'),
(8, 20, 1, 'Lumpa lumpa', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:47:01', '2024-07-11 18:19:39'),
(9, 14, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:43:10', '2024-07-12 19:21:43'),
(10, 13, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:43:09', '2024-07-12 19:21:44'),
(11, 11, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:43:08', '2024-07-12 19:21:45'),
(12, 12, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:43:08', '2024-07-12 19:21:46'),
(13, 8, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:43:05', '2024-07-10 22:48:40'),
(14, 9, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'unread', '2024-07-10 22:43:06', '2024-07-10 22:43:06'),
(15, 10, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'read', '2024-07-10 22:43:07', '2024-07-11 18:19:20'),
(16, 15, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'unread', '2024-07-10 22:43:11', '2024-07-10 22:43:11'),
(17, 16, 1, 'Teste de Notificação com cron', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'unread', '2024-07-10 22:43:12', '2024-07-10 22:43:12'),
(18, 17, 1, 'Abaduba', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'unread', '2024-07-10 22:46:37', '2024-07-10 22:46:37'),
(19, 18, 1, 'Zetanona', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'unread', '2024-07-10 22:46:45', '2024-07-10 22:46:45'),
(20, 19, 1, 'Vargamuta', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'unread', '2024-07-10 22:46:53', '2024-07-10 22:46:53'),
(21, 21, 1, 'Lumpa lumpa', 'Esta é uma mensagem de teste.', 'test', 'post', 123, 'unread', '2024-07-10 22:47:04', '2024-07-10 22:47:04'),
(22, 22, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 448, 'unread', '2024-07-11 19:06:41', '2024-07-11 19:06:41'),
(23, 23, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 434, 'unread', '2024-07-11 19:06:48', '2024-07-11 19:06:48'),
(24, 24, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 451, 'read', '2024-07-12 19:05:49', '2024-07-16 21:51:38'),
(25, 25, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 451, 'unread', '2024-07-12 19:06:12', '2024-07-12 19:06:12'),
(26, 26, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 451, 'read', '2024-07-12 19:06:54', '2024-07-12 19:22:03'),
(27, 27, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 451, 'read', '2024-07-12 19:07:16', '2024-07-12 19:22:12'),
(28, 42, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 599, 'read', '2024-08-02 18:48:36', '2024-08-13 15:30:37'),
(29, 41, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 597, 'read', '2024-08-01 15:09:06', '2024-08-13 15:30:37'),
(30, 40, 1, 'Parabéns! Seu lead aceitou sua oferta', '', 'offer_accepted', 'post', 594, 'read', '2024-07-24 19:39:38', '2024-08-13 15:30:37');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_options`
--

CREATE TABLE `wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://localhost/crm', 'yes'),
(2, 'home', 'http://localhost/crm', 'yes'),
(3, 'blogname', 'crm', 'yes'),
(4, 'blogdescription', '', 'yes'),
(5, 'users_can_register', '0', 'yes'),
(6, 'admin_email', 'douglassalvagni@gmail.com', 'yes'),
(7, 'start_of_week', '0', 'yes'),
(8, 'use_balanceTags', '0', 'yes'),
(9, 'use_smilies', '1', 'yes'),
(10, 'require_name_email', '1', 'yes'),
(11, 'comments_notify', '1', 'yes'),
(12, 'posts_per_rss', '10', 'yes'),
(13, 'rss_use_excerpt', '0', 'yes'),
(14, 'mailserver_url', 'mail.example.com', 'yes'),
(15, 'mailserver_login', 'login@example.com', 'yes'),
(16, 'mailserver_pass', 'password', 'yes'),
(17, 'mailserver_port', '110', 'yes'),
(18, 'default_category', '1', 'yes'),
(19, 'default_comment_status', 'open', 'yes'),
(20, 'default_ping_status', 'open', 'yes'),
(21, 'default_pingback_flag', '0', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'j \\d\\e F \\d\\e Y', 'yes'),
(24, 'time_format', 'H:i', 'yes'),
(25, 'links_updated_date_format', 'j \\d\\e F \\d\\e Y, H:i', 'yes'),
(26, 'comment_moderation', '0', 'yes'),
(27, 'moderation_notify', '1', 'yes'),
(28, 'permalink_structure', '/%postname%/', 'yes'),
(29, 'rewrite_rules', 'a:110:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:19:\"^checkout/([^/]+)/?\";s:53:\"index.php?pagename=checkout&checkout_uuid=$matches[1]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:33:\"leads/[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:43:\"leads/[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:63:\"leads/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:58:\"leads/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:58:\"leads/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:39:\"leads/[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:22:\"leads/([^/]+)/embed/?$\";s:38:\"index.php?leads=$matches[1]&embed=true\";s:26:\"leads/([^/]+)/trackback/?$\";s:32:\"index.php?leads=$matches[1]&tb=1\";s:34:\"leads/([^/]+)/page/?([0-9]{1,})/?$\";s:45:\"index.php?leads=$matches[1]&paged=$matches[2]\";s:41:\"leads/([^/]+)/comment-page-([0-9]{1,})/?$\";s:45:\"index.php?leads=$matches[1]&cpage=$matches[2]\";s:30:\"leads/([^/]+)(?:/([0-9]+))?/?$\";s:44:\"index.php?leads=$matches[1]&page=$matches[2]\";s:22:\"leads/[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:32:\"leads/[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:52:\"leads/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:47:\"leads/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:47:\"leads/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:28:\"leads/[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:27:\"comment-page-([0-9]{1,})/?$\";s:38:\"index.php?&page_id=6&cpage=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:24:\"([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:22:\"[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}', 'yes'),
(30, 'hack_file', '0', 'yes'),
(31, 'blog_charset', 'UTF-8', 'yes'),
(32, 'moderation_keys', '', 'no'),
(33, 'active_plugins', 'a:2:{i:0;s:32:\"duplicate-page/duplicatepage.php\";i:1;s:27:\"wp-crontrol/wp-crontrol.php\";}', 'yes'),
(34, 'category_base', '', 'yes'),
(35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'),
(36, 'comment_max_links', '2', 'yes'),
(37, 'gmt_offset', '0', 'yes'),
(38, 'default_email_category', '1', 'yes'),
(39, 'recently_edited', '', 'no'),
(40, 'template', 'CRM', 'yes'),
(41, 'stylesheet', 'CRM', 'yes'),
(42, 'comment_registration', '0', 'yes'),
(43, 'html_type', 'text/html', 'yes'),
(44, 'use_trackback', '0', 'yes'),
(45, 'default_role', 'subscriber', 'yes'),
(46, 'db_version', '57155', 'yes'),
(47, 'uploads_use_yearmonth_folders', '1', 'yes'),
(48, 'upload_path', '', 'yes'),
(49, 'blog_public', '0', 'yes'),
(50, 'default_link_category', '2', 'yes'),
(51, 'show_on_front', 'page', 'yes'),
(52, 'tag_base', '', 'yes'),
(53, 'show_avatars', '1', 'yes'),
(54, 'avatar_rating', 'G', 'yes'),
(55, 'upload_url_path', '', 'yes'),
(56, 'thumbnail_size_w', '150', 'yes'),
(57, 'thumbnail_size_h', '150', 'yes'),
(58, 'thumbnail_crop', '1', 'yes'),
(59, 'medium_size_w', '300', 'yes'),
(60, 'medium_size_h', '300', 'yes'),
(61, 'avatar_default', 'mystery', 'yes'),
(62, 'large_size_w', '1024', 'yes'),
(63, 'large_size_h', '1024', 'yes'),
(64, 'image_default_link_type', 'none', 'yes'),
(65, 'image_default_size', '', 'yes'),
(66, 'image_default_align', '', 'yes'),
(67, 'close_comments_for_old_posts', '0', 'yes'),
(68, 'close_comments_days_old', '14', 'yes'),
(69, 'thread_comments', '1', 'yes'),
(70, 'thread_comments_depth', '5', 'yes'),
(71, 'page_comments', '0', 'yes'),
(72, 'comments_per_page', '50', 'yes'),
(73, 'default_comments_page', 'newest', 'yes'),
(74, 'comment_order', 'asc', 'yes'),
(75, 'sticky_posts', 'a:0:{}', 'yes'),
(76, 'widget_categories', 'a:0:{}', 'yes'),
(77, 'widget_text', 'a:0:{}', 'yes'),
(78, 'widget_rss', 'a:0:{}', 'yes'),
(79, 'uninstall_plugins', 'a:1:{s:39:\"copy-delete-posts/copy-delete-posts.php\";a:2:{i:0;s:15:\"Account\\Account\";i:1;s:25:\"onUninstallPluginListener\";}}', 'no'),
(80, 'timezone_string', 'America/Sao_Paulo', 'yes'),
(81, 'page_for_posts', '0', 'yes'),
(82, 'page_on_front', '6', 'yes'),
(83, 'default_post_format', '0', 'yes'),
(84, 'link_manager_enabled', '0', 'yes'),
(85, 'finished_splitting_shared_terms', '1', 'yes'),
(86, 'site_icon', '0', 'yes'),
(87, 'medium_large_size_w', '768', 'yes'),
(88, 'medium_large_size_h', '0', 'yes'),
(89, 'wp_page_for_privacy_policy', '3', 'yes'),
(90, 'show_comments_cookies_opt_in', '1', 'yes'),
(91, 'admin_email_lifespan', '1735585370', 'yes'),
(92, 'disallowed_keys', '', 'no'),
(93, 'comment_previously_approved', '1', 'yes'),
(94, 'auto_plugin_theme_update_emails', 'a:0:{}', 'no'),
(95, 'auto_update_core_dev', 'enabled', 'yes'),
(96, 'auto_update_core_minor', 'enabled', 'yes'),
(97, 'auto_update_core_major', 'enabled', 'yes'),
(98, 'wp_force_deactivated_plugins', 'a:0:{}', 'yes'),
(99, 'wp_attachment_pages_enabled', '0', 'yes'),
(100, 'initial_db_version', '57155', 'yes'),
(101, 'wp_user_roles', 'a:3:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:18:\"manage_woocommerce\";b:1;}}s:9:\"comercial\";a:2:{s:4:\"name\";s:9:\"Comercial\";s:12:\"capabilities\";a:4:{s:4:\"read\";b:1;s:10:\"edit_posts\";b:0;s:12:\"delete_posts\";b:0;s:12:\"upload_files\";b:0;}}s:17:\"gerente_comercial\";a:2:{s:4:\"name\";s:17:\"Gerente comercial\";s:12:\"capabilities\";a:4:{s:4:\"read\";b:1;s:10:\"edit_posts\";b:0;s:12:\"delete_posts\";b:0;s:12:\"upload_files\";b:0;}}}', 'yes'),
(102, 'fresh_site', '0', 'yes'),
(103, 'WPLANG', 'pt_BR', 'yes'),
(104, 'user_count', '2', 'no'),
(105, 'widget_block', 'a:6:{i:2;a:1:{s:7:\"content\";s:19:\"<!-- wp:search /-->\";}i:3;a:1:{s:7:\"content\";s:156:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Posts recentes</h2><!-- /wp:heading --><!-- wp:latest-posts /--></div><!-- /wp:group -->\";}i:4;a:1:{s:7:\"content\";s:224:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Comentários</h2><!-- /wp:heading --><!-- wp:latest-comments {\"displayAvatar\":false,\"displayDate\":false,\"displayExcerpt\":false} /--></div><!-- /wp:group -->\";}i:5;a:1:{s:7:\"content\";s:146:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Arquivos</h2><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:group -->\";}i:6;a:1:{s:7:\"content\";s:150:\"<!-- wp:group --><div class=\"wp-block-group\"><!-- wp:heading --><h2>Categorias</h2><!-- /wp:heading --><!-- wp:categories /--></div><!-- /wp:group -->\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(106, 'sidebars_widgets', 'a:2:{s:19:\"wp_inactive_widgets\";a:5:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";i:3;s:7:\"block-5\";i:4;s:7:\"block-6\";}s:13:\"array_version\";i:3;}', 'yes'),
(107, 'cron', 'a:10:{i:1723579371;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1723593561;a:1:{s:25:\"archive_old_notifications\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1723618971;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1723618985;a:1:{s:21:\"wp_update_user_counts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1723662171;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1723662173;a:1:{s:30:\"wp_delete_temp_updater_backups\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1723662185;a:2:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1723662186;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1723748571;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'yes'),
(108, 'widget_pages', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(109, 'widget_calendar', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(110, 'widget_archives', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(111, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(112, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(113, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(114, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(115, 'widget_meta', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(116, 'widget_search', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(117, 'widget_recent-posts', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(118, 'widget_recent-comments', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(119, 'widget_tag_cloud', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(120, 'widget_nav_menu', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(121, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(123, 'recovery_keys', 'a:0:{}', 'yes'),
(130, 'nonce_key', 'RQ[Md/FZHB}Q,glTD^A69n>M EUIK&ZxJk~{-bUpFiT3v?mkPm%%6?>nLJ//bL8W', 'no'),
(131, 'nonce_salt', 'i_w;4UYijt?4IIPV0+rc+j][])kzp_S<-[l%s9VM.~ccQ4P9UQj`uqhz[cYT$t`8', 'no'),
(138, 'auth_key', '7J&hNn5;BanZ+myg`H.I9V1WPw_E&du?K<;EQF~Jco)[y#LoL.Ql;L XZ[?px91=', 'no'),
(139, 'auth_salt', 'x`[Sd;9PXdD>VG0JUx?n~jlC[;-!{xdm[0GA]XXi}k{q=W!PXw- .u<qh?(!|?vX', 'no'),
(140, 'logged_in_key', '&f2g9-Lbc/L1FPC.;ByNcdonRQ=84GcW7}jT,l^!C{GZJ*>dm]4~672$gVWnBle}', 'no'),
(141, 'logged_in_salt', 'U8V2EW7mzj-zr-a@5 ?30.|gSpB!+s/{~q-:>TL+qPj$D+S4L]jpGFc!t$TFCTg&', 'no'),
(149, 'can_compress_scripts', '1', 'yes'),
(160, 'theme_mods_twentytwentyfour', 'a:1:{s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1720033394;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:3:{i:0;s:7:\"block-2\";i:1;s:7:\"block-3\";i:2;s:7:\"block-4\";}s:9:\"sidebar-2\";a:2:{i:0;s:7:\"block-5\";i:1;s:7:\"block-6\";}}}}', 'no'),
(161, 'current_theme', '', 'yes'),
(162, 'theme_mods_CRM', 'a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;}', 'yes'),
(163, 'theme_switched', '', 'yes'),
(164, 'recovery_mode_email_last_sent', '1722904492', 'yes'),
(167, 'finished_updating_comment_type', '1', 'yes'),
(173, '_site_transient_wp_plugin_dependencies_plugin_data', 'a:0:{}', 'no'),
(174, 'recently_activated', 'a:0:{}', 'yes'),
(183, 'wp_crontrol_paused', 'a:0:{}', 'yes'),
(280, 'https_detection_errors', 'a:1:{s:23:\"ssl_verification_failed\";a:1:{i:0;s:25:\"Verificação SSL falhou.\";}}', 'yes'),
(281, '_transient_health-check-site-status-result', '{\"good\":14,\"recommended\":5,\"critical\":4}', 'yes'),
(348, 'asaas_api_key', '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNjU5OTQ6OiRhYWNoXzJiZmUzODg1LWFmZTQtNGFkNy1iNGRhLTljNmRmYjM2NzIxOA==', 'yes'),
(349, 'asaas_subscription_price', '39.9', 'yes'),
(1306, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:25:\"douglassalvagni@gmail.com\";s:7:\"version\";s:5:\"6.6.1\";s:9:\"timestamp\";i:1721776701;}', 'off'),
(1342, 'analyst_cache', 's:6:\"a:0:{}\";', 'auto'),
(1344, '_cdp_review', 'a:2:{s:9:\"installed\";i:1721168118;s:5:\"users\";a:0:{}}', 'auto'),
(1345, '_cdp_globals', 'a:1:{s:6:\"others\";a:14:{s:17:\"cdp-content-pages\";s:4:\"true\";s:17:\"cdp-content-posts\";s:4:\"true\";s:18:\"cdp-content-custom\";s:4:\"true\";s:17:\"cdp-display-posts\";s:4:\"true\";s:16:\"cdp-display-edit\";s:4:\"true\";s:17:\"cdp-display-admin\";s:4:\"true\";s:16:\"cdp-display-bulk\";s:4:\"true\";s:21:\"cdp-display-gutenberg\";s:4:\"true\";s:19:\"cdp-references-post\";s:5:\"false\";s:19:\"cdp-references-edit\";s:5:\"false\";s:18:\"cdp-premium-import\";s:5:\"false\";s:24:\"cdp-premium-hide-tooltip\";s:5:\"false\";s:26:\"cdp-premium-replace-domain\";s:5:\"false\";s:20:\"cdp-menu-in-settings\";s:5:\"false\";}}', 'auto'),
(1346, '_cdp_profiles', 'a:1:{s:7:\"default\";a:25:{s:5:\"title\";s:4:\"true\";s:4:\"date\";s:5:\"false\";s:6:\"status\";s:5:\"false\";s:4:\"slug\";s:4:\"true\";s:7:\"excerpt\";s:4:\"true\";s:7:\"content\";s:4:\"true\";s:7:\"f_image\";s:4:\"true\";s:8:\"template\";s:4:\"true\";s:6:\"format\";s:4:\"true\";s:6:\"author\";s:4:\"true\";s:8:\"password\";s:4:\"true\";s:11:\"attachments\";s:5:\"false\";s:8:\"children\";s:5:\"false\";s:8:\"comments\";s:5:\"false\";s:10:\"menu_order\";s:4:\"true\";s:8:\"category\";s:4:\"true\";s:8:\"post_tag\";s:4:\"true\";s:8:\"taxonomy\";s:4:\"true\";s:8:\"nav_menu\";s:4:\"true\";s:13:\"link_category\";s:4:\"true\";s:12:\"all_metadata\";s:5:\"false\";s:5:\"names\";a:5:{s:6:\"prefix\";s:0:\"\";s:6:\"suffix\";s:10:\"#[Counter]\";s:6:\"format\";s:1:\"1\";s:6:\"custom\";s:5:\"m/d/Y\";s:7:\"display\";s:7:\"Default\";}s:9:\"usmplugin\";s:5:\"false\";s:5:\"yoast\";s:5:\"false\";s:3:\"woo\";s:5:\"false\";}}', 'auto'),
(1347, '_cdp_default_setup', '1', 'auto'),
(1348, '_irb_h_bn_review', 'a:2:{s:5:\"users\";a:0:{}s:17:\"copy-delete-posts\";i:1721168118;}', 'auto'),
(1349, '_tifm_force_disable_feature_update', '1', 'auto'),
(1350, '_cdp_preselections', 'a:1:{i:1;s:7:\"default\";}', 'auto'),
(1352, 'cdp_copy_logs_times', 'a:1:{i:0;a:6:{s:6:\"amount\";s:1:\"1\";s:4:\"time\";d:0.040313005447387695;s:6:\"perOne\";d:0.040313005447387695;s:4:\"data\";i:1721168134;s:6:\"memory\";i:39838992;s:4:\"peak\";i:41943040;}}', 'auto'),
(1353, 'analyst_accounts_data', 's:401:\"O:26:\"Account\\AccountDataFactory\":1:{s:11:\"\0*\0accounts\";a:1:{i:0;O:19:\"Account\\AccountData\":7:{s:5:\"\0*\0id\";s:16:\"ovgxe3xq075ladbp\";s:9:\"\0*\0secret\";s:40:\"b4de5ed2ba7be687e233d152ec1e8fd116052ab0\";s:7:\"\0*\0path\";s:78:\"C:\\xampp\\htdocs\\crm\\wp-content\\plugins\\copy-delete-posts\\copy-delete-posts.php\";s:14:\"\0*\0isInstalled\";b:0;s:12:\"\0*\0isOptedIn\";b:0;s:11:\"\0*\0isSigned\";b:0;s:20:\"\0*\0isInstallResolved\";N;}}}\";', 'auto'),
(1360, 'duplicate_page_options', 'a:4:{s:21:\"duplicate_post_status\";s:5:\"draft\";s:23:\"duplicate_post_redirect\";s:7:\"to_list\";s:21:\"duplicate_post_suffix\";s:0:\"\";s:21:\"duplicate_post_editor\";s:7:\"classic\";}', 'auto'),
(2396, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1723575836;s:7:\"checked\";a:1:{s:3:\"CRM\";s:0:\"\";}s:8:\"response\";a:0:{}s:9:\"no_update\";a:0:{}s:12:\"translations\";a:0:{}}', 'off'),
(2561, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/pt_BR/wordpress-6.6.1.zip\";s:6:\"locale\";s:5:\"pt_BR\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/pt_BR/wordpress-6.6.1.zip\";s:10:\"no_content\";s:0:\"\";s:11:\"new_bundled\";s:0:\"\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"6.6.1\";s:7:\"version\";s:5:\"6.6.1\";s:11:\"php_version\";s:5:\"7.0.0\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"6.4\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1723575835;s:15:\"version_checked\";s:5:\"6.6.1\";s:12:\"translations\";a:0:{}}', 'off'),
(3651, 'asaas_subscription_dependent_porcent_discount', '15', 'auto'),
(3652, 'asaas_commission_type', 'fixedValue', 'auto'),
(3653, 'asaas_commission_value', '', 'auto'),
(3837, '_site_transient_timeout_php_check_4e65496a675acbae70f7731b62fe9fd1', '1723842201', 'off'),
(3838, '_site_transient_php_check_4e65496a675acbae70f7731b62fe9fd1', 'a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"7.2.24\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'off'),
(3874, '_site_transient_timeout_browser_362d7fe3d8b2581bffa359f0eeda7106', '1723847302', 'off'),
(3875, '_site_transient_browser_362d7fe3d8b2581bffa359f0eeda7106', 'a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:9:\"127.0.0.0\";s:8:\"platform\";s:7:\"Windows\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}', 'off'),
(4446, '_transient_timeout_feed_d117b5738fbd35bd8c0391cda1f2b5d9', '1723544523', 'off'),
(4511, '_transient_timeout_cumulative_commission_1', '1723577779', 'off'),
(4512, '_transient_cumulative_commission_1', '6335.35', 'off'),
(4513, '_transient_timeout_monthly_paid_commission_1', '1723577779', 'off'),
(4514, '_transient_monthly_paid_commission_1', '0', 'off'),
(4531, '_transient_timeout_global_leads_count', '1723578919', 'off'),
(4532, '_transient_global_leads_count', '4', 'off'),
(4533, '_transient_timeout_global_potential_sales', '1723578919', 'off'),
(4534, '_transient_global_potential_sales', '140', 'off'),
(4535, '_transient_timeout_global_campaigns_sent', '1723578919', 'off'),
(4536, '_transient_global_campaigns_sent', '0', 'off'),
(4537, '_transient_timeout_global_daily_average_income', '1723578919', 'off'),
(4538, '_transient_global_daily_average_income', '140', 'off'),
(4539, '_transient_timeout_global_annual_deals_count', '1723578919', 'off'),
(4540, '_transient_global_annual_deals_count', '0', 'off'),
(4541, '_transient_timeout_global_cumulative_commission', '1723578919', 'off'),
(4542, '_transient_global_cumulative_commission', '6335.35', 'off'),
(4543, '_transient_timeout_global_monthly_sales_count', '1723578919', 'off'),
(4544, '_transient_global_monthly_sales_count', '7', 'off'),
(4545, '_transient_timeout_global_daily_sales_data', '1723578919', 'off'),
(4546, '_transient_global_daily_sales_data', 'a:10:{s:10:\"2024-08-04\";i:0;s:10:\"2024-08-05\";i:0;s:10:\"2024-08-06\";i:0;s:10:\"2024-08-07\";i:0;s:10:\"2024-08-08\";i:0;s:10:\"2024-08-09\";i:2;s:10:\"2024-08-10\";i:0;s:10:\"2024-08-11\";i:0;s:10:\"2024-08-12\";i:3;s:10:\"2024-08-13\";i:1;}', 'off'),
(4547, '_transient_timeout_global_daily_leads_data', '1723578919', 'off'),
(4548, '_transient_global_daily_leads_data', 'a:10:{s:10:\"2024-08-04\";i:0;s:10:\"2024-08-05\";i:0;s:10:\"2024-08-06\";i:0;s:10:\"2024-08-07\";i:0;s:10:\"2024-08-08\";i:0;s:10:\"2024-08-09\";i:0;s:10:\"2024-08-10\";i:0;s:10:\"2024-08-11\";i:0;s:10:\"2024-08-12\";i:0;s:10:\"2024-08-13\";i:0;}', 'off'),
(4549, '_transient_timeout_global_priority_leads', '1723578919', 'off'),
(4550, '_transient_global_priority_leads', 'a:4:{i:0;O:7:\"WP_Post\":24:{s:2:\"ID\";i:598;s:11:\"post_author\";s:1:\"1\";s:9:\"post_date\";s:19:\"2024-07-16 19:32:03\";s:13:\"post_date_gmt\";s:19:\"2024-07-16 22:32:03\";s:12:\"post_content\";s:0:\"\";s:10:\"post_title\";s:15:\"Lead  duplicado\";s:12:\"post_excerpt\";s:0:\"\";s:11:\"post_status\";s:7:\"publish\";s:14:\"comment_status\";s:6:\"closed\";s:11:\"ping_status\";s:6:\"closed\";s:13:\"post_password\";s:0:\"\";s:9:\"post_name\";s:16:\"lead-duplicado-3\";s:7:\"to_ping\";s:0:\"\";s:6:\"pinged\";s:0:\"\";s:13:\"post_modified\";s:19:\"2024-07-29 11:08:04\";s:17:\"post_modified_gmt\";s:19:\"2024-07-29 14:08:04\";s:21:\"post_content_filtered\";s:0:\"\";s:11:\"post_parent\";i:0;s:4:\"guid\";s:48:\"http://localhost/crm/?post_type=leads&#038;p=598\";s:10:\"menu_order\";i:0;s:9:\"post_type\";s:5:\"leads\";s:14:\"post_mime_type\";s:0:\"\";s:13:\"comment_count\";s:1:\"0\";s:6:\"filter\";s:3:\"raw\";}i:1;O:7:\"WP_Post\":24:{s:2:\"ID\";i:596;s:11:\"post_author\";s:1:\"1\";s:9:\"post_date\";s:19:\"2024-07-16 19:16:55\";s:13:\"post_date_gmt\";s:19:\"2024-07-16 22:16:55\";s:12:\"post_content\";s:0:\"\";s:10:\"post_title\";s:14:\"Lead duplicado\";s:12:\"post_excerpt\";s:0:\"\";s:11:\"post_status\";s:7:\"publish\";s:14:\"comment_status\";s:6:\"closed\";s:11:\"ping_status\";s:6:\"closed\";s:13:\"post_password\";s:0:\"\";s:9:\"post_name\";s:8:\"lead-1-2\";s:7:\"to_ping\";s:0:\"\";s:6:\"pinged\";s:0:\"\";s:13:\"post_modified\";s:19:\"2024-08-01 21:38:39\";s:17:\"post_modified_gmt\";s:19:\"2024-08-02 00:38:39\";s:21:\"post_content_filtered\";s:0:\"\";s:11:\"post_parent\";i:0;s:4:\"guid\";s:48:\"http://localhost/crm/?post_type=leads&#038;p=596\";s:10:\"menu_order\";i:0;s:9:\"post_type\";s:5:\"leads\";s:14:\"post_mime_type\";s:0:\"\";s:13:\"comment_count\";s:1:\"0\";s:6:\"filter\";s:3:\"raw\";}i:2;O:7:\"WP_Post\":24:{s:2:\"ID\";i:599;s:11:\"post_author\";s:1:\"1\";s:9:\"post_date\";s:19:\"2024-07-16 19:32:03\";s:13:\"post_date_gmt\";s:19:\"2024-07-16 22:32:03\";s:12:\"post_content\";s:0:\"\";s:10:\"post_title\";s:4:\"Novo\";s:12:\"post_excerpt\";s:0:\"\";s:11:\"post_status\";s:7:\"publish\";s:14:\"comment_status\";s:6:\"closed\";s:11:\"ping_status\";s:6:\"closed\";s:13:\"post_password\";s:0:\"\";s:9:\"post_name\";s:16:\"lead-duplicado-2\";s:7:\"to_ping\";s:0:\"\";s:6:\"pinged\";s:0:\"\";s:13:\"post_modified\";s:19:\"2024-08-02 18:48:36\";s:17:\"post_modified_gmt\";s:19:\"2024-08-02 21:48:36\";s:21:\"post_content_filtered\";s:0:\"\";s:11:\"post_parent\";i:0;s:4:\"guid\";s:48:\"http://localhost/crm/?post_type=leads&#038;p=599\";s:10:\"menu_order\";i:0;s:9:\"post_type\";s:5:\"leads\";s:14:\"post_mime_type\";s:0:\"\";s:13:\"comment_count\";s:1:\"0\";s:6:\"filter\";s:3:\"raw\";}i:3;O:7:\"WP_Post\":24:{s:2:\"ID\";i:601;s:11:\"post_author\";s:1:\"1\";s:9:\"post_date\";s:19:\"2024-07-16 19:47:30\";s:13:\"post_date_gmt\";s:19:\"2024-07-16 22:47:30\";s:12:\"post_content\";s:0:\"\";s:10:\"post_title\";s:6:\"mais e\";s:12:\"post_excerpt\";s:0:\"\";s:11:\"post_status\";s:7:\"publish\";s:14:\"comment_status\";s:6:\"closed\";s:11:\"ping_status\";s:6:\"closed\";s:13:\"post_password\";s:0:\"\";s:9:\"post_name\";s:12:\"mais-um-hoje\";s:7:\"to_ping\";s:0:\"\";s:6:\"pinged\";s:0:\"\";s:13:\"post_modified\";s:19:\"2024-08-13 15:33:53\";s:17:\"post_modified_gmt\";s:19:\"2024-08-13 18:33:53\";s:21:\"post_content_filtered\";s:0:\"\";s:11:\"post_parent\";i:0;s:4:\"guid\";s:48:\"http://localhost/crm/?post_type=leads&#038;p=601\";s:10:\"menu_order\";i:0;s:9:\"post_type\";s:5:\"leads\";s:14:\"post_mime_type\";s:0:\"\";s:13:\"comment_count\";s:1:\"0\";s:6:\"filter\";s:3:\"raw\";}}', 'off'),
(4551, '_transient_timeout_global_conversion_rate', '1723578919', 'off'),
(4552, '_transient_global_conversion_rate', '0', 'off'),
(4553, '_site_transient_timeout_wp_theme_files_patterns-9dfc19981e963768d25ef527bb308b6b', '1723577286', 'off'),
(4554, '_site_transient_wp_theme_files_patterns-9dfc19981e963768d25ef527bb308b6b', 'a:2:{s:7:\"version\";s:0:\"\";s:8:\"patterns\";a:0:{}}', 'off'),
(4557, '_site_transient_timeout_theme_roots', '1723577636', 'off'),
(4558, '_site_transient_theme_roots', 'a:1:{s:3:\"CRM\";s:7:\"/themes\";}', 'off'),
(4559, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1723575837;s:8:\"response\";a:2:{s:32:\"duplicate-page/duplicatepage.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:28:\"w.org/plugins/duplicate-page\";s:4:\"slug\";s:14:\"duplicate-page\";s:6:\"plugin\";s:32:\"duplicate-page/duplicatepage.php\";s:11:\"new_version\";s:5:\"4.5.4\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/duplicate-page/\";s:7:\"package\";s:57:\"https://downloads.wordpress.org/plugin/duplicate-page.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:67:\"https://ps.w.org/duplicate-page/assets/icon-128x128.jpg?rev=1412874\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:69:\"https://ps.w.org/duplicate-page/assets/banner-772x250.jpg?rev=1410328\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.4\";s:6:\"tested\";s:5:\"6.6.1\";s:12:\"requires_php\";b:0;s:16:\"requires_plugins\";a:0:{}}s:27:\"wp-crontrol/wp-crontrol.php\";O:8:\"stdClass\":13:{s:2:\"id\";s:25:\"w.org/plugins/wp-crontrol\";s:4:\"slug\";s:11:\"wp-crontrol\";s:6:\"plugin\";s:27:\"wp-crontrol/wp-crontrol.php\";s:11:\"new_version\";s:6:\"1.17.0\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/wp-crontrol/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/wp-crontrol.1.17.0.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:56:\"https://ps.w.org/wp-crontrol/assets/icon.svg?rev=2997335\";s:3:\"svg\";s:56:\"https://ps.w.org/wp-crontrol/assets/icon.svg?rev=2997335\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/wp-crontrol/assets/banner-1544x500.jpg?rev=2997335\";s:2:\"1x\";s:66:\"https://ps.w.org/wp-crontrol/assets/banner-772x250.jpg?rev=2997335\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.8\";s:6:\"tested\";s:5:\"6.6.1\";s:12:\"requires_php\";s:3:\"7.4\";s:16:\"requires_plugins\";a:0:{}}}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:0:{}s:7:\"checked\";a:2:{s:32:\"duplicate-page/duplicatepage.php\";s:5:\"4.5.3\";s:27:\"wp-crontrol/wp-crontrol.php\";s:6:\"1.16.3\";}}', 'off'),
(4560, '_transient_timeout_total_lives_count', '1723579605', 'off'),
(4561, '_transient_total_lives_count', '7', 'off'),
(4562, '_transient_timeout_total_titulares_count', '1723579605', 'off'),
(4563, '_transient_total_titulares_count', '2', 'off'),
(4564, '_transient_timeout_total_dependentes_count', '1723579605', 'off'),
(4565, '_transient_total_dependentes_count', '5', 'off'),
(4566, '_transient_timeout_total_subscription_value', '1723579605', 'off'),
(4567, '_transient_total_subscription_value', '147.64', 'off');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_postmeta`
--

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(2, 3, '_wp_page_template', 'default'),
(6, 6, '_edit_last', '1'),
(7, 6, '_edit_lock', '1720206782:1'),
(8, 6, '_wp_page_template', 'template-index.php'),
(9, 8, '_edit_last', '1'),
(10, 8, '_edit_lock', '1721249602:1'),
(11, 8, '_wp_page_template', 'template-user-leads-pj.php'),
(10025, 566, '_edit_last', '1'),
(10026, 566, '_edit_lock', '1720644899:1'),
(10027, 566, '_wp_page_template', 'template-user-profile-edit.php'),
(10031, 569, '_edit_last', '1'),
(10032, 569, '_edit_lock', '1723048820:1'),
(10033, 569, '_wp_page_template', 'template-checkout.php'),
(10037, 572, '_sale_user_id', NULL),
(10038, 572, '_sale_date', '2024-07-08'),
(10039, 572, '_sale_amount', '35'),
(10040, 572, '_sale_status', 'ativa'),
(10041, 572, '_sale_vendor_id', '0'),
(10042, 572, '_sale_dependents', '[]'),
(10043, 573, '_sale_user_id', NULL),
(10044, 573, '_sale_date', '2024-07-08'),
(10045, 573, '_sale_amount', '85'),
(10046, 573, '_sale_status', 'ativa'),
(10047, 573, '_sale_vendor_id', '0'),
(10048, 573, '_sale_dependents', '[]'),
(10049, 574, '_sale_user_id', NULL),
(10050, 574, '_sale_date', '2024-07-08'),
(10051, 574, '_sale_amount', '85'),
(10052, 574, '_sale_status', 'ativa'),
(10053, 574, '_sale_vendor_id', '0'),
(10054, 574, '_sale_dependents', '[]'),
(10055, 575, '_sale_user_id', NULL),
(10056, 575, '_sale_date', '2024-07-08'),
(10057, 575, '_sale_amount', '85'),
(10058, 575, '_sale_status', 'ativa'),
(10059, 575, '_sale_vendor_id', '0'),
(10060, 575, '_sale_dependents', '[]'),
(10061, 576, '_sale_user_id', NULL),
(10062, 576, '_sale_date', '2024-07-08'),
(10063, 576, '_sale_amount', '35'),
(10064, 576, '_sale_status', 'ativa'),
(10065, 576, '_sale_vendor_id', '0'),
(10066, 576, '_sale_dependents', '[]'),
(10067, 577, '_sale_user_id', NULL),
(10068, 577, '_sale_date', '2024-07-08'),
(10069, 577, '_sale_amount', '35'),
(10070, 577, '_sale_status', 'ativa'),
(10071, 577, '_sale_vendor_id', '0'),
(10072, 577, '_sale_dependents', '[]'),
(10073, 578, '_sale_user_id', NULL),
(10074, 578, '_sale_date', '2024-07-08'),
(10075, 578, '_sale_amount', '35'),
(10076, 578, '_sale_status', 'ativa'),
(10077, 578, '_sale_vendor_id', '0'),
(10078, 578, '_sale_dependents', '[]'),
(10079, 579, '_sale_user_id', NULL),
(10080, 579, '_sale_date', '2024-07-08'),
(10081, 579, '_sale_amount', '35'),
(10082, 579, '_sale_status', 'ativa'),
(10083, 579, '_sale_vendor_id', '0'),
(10084, 579, '_sale_dependents', '[]'),
(10087, 581, '_edit_last', '1'),
(10088, 581, '_wp_page_template', 'template-login.php'),
(10089, 581, '_edit_lock', '1720546111:1'),
(10093, 586, '_edit_last', '1'),
(10094, 586, '_edit_lock', '1720645538:1'),
(10095, 586, '_wp_page_template', 'template-logout.php'),
(10189, 595, '_cdp_origin', '594'),
(10190, 595, '_cdp_origin_site', '-1'),
(10191, 595, '_cdp_origin_title', ' Novo #[Counter]'),
(10192, 595, '_cdp_counter', '2'),
(10193, 595, '_edit_lock', '1721167995:1'),
(10194, 595, '_wp_trash_meta_status', 'draft'),
(10195, 595, '_wp_trash_meta_time', '1721168142'),
(10196, 595, '_wp_desired_post_slug', 'novo'),
(10197, 596, 'lead_email', 'lead1@example.com'),
(10198, 596, 'lead_phone', '(12) 3456-7891'),
(10199, 596, 'lead_company', 'Company D'),
(10200, 596, 'lead_position', 'CEO'),
(10201, 596, 'lead_source', 'facebook'),
(10202, 596, 'lead_status', 'lead_discovered'),
(10203, 596, 'deal_value', '35'),
(10204, 596, 'deal_stage', 'Stage 4'),
(10205, 596, 'expected_close_date', '2024-07-29'),
(10206, 596, 'last_contacted_date', '2024-06-30'),
(10207, 596, 'contact_method', 'Email'),
(10208, 596, 'next_action_date', '2024-08-03'),
(10209, 596, 'next_action_description', 'Follow-up action 1'),
(10210, 596, 'lead_notes', 'Notes for lead 1'),
(10211, 596, 'lead_priority', 'medium'),
(10212, 596, 'lead_assigned_to', '1'),
(10213, 596, 'lead_tags', 'asdaasdasd,dasdasdasd'),
(10214, 596, 'lead_cpf', '123.456.789-1'),
(10215, 596, '_edit_lock', '1722261500:1'),
(10216, 596, '_edit_last', '1'),
(10217, 596, 'originURL', ''),
(10218, 596, 'lead_name', ''),
(10242, 598, 'lead_email', 'lead1@example.com'),
(10243, 598, 'lead_phone', '(12) 3456-7891'),
(10244, 598, 'lead_company', 'Company D'),
(10245, 598, 'lead_position', 'CEO'),
(10246, 598, 'lead_source', 'facebook'),
(10247, 598, 'lead_status', 'needs_identified'),
(10248, 598, 'deal_value', '35'),
(10249, 598, 'deal_stage', 'Stage 4'),
(10250, 598, 'expected_close_date', '2024-07-29'),
(10251, 598, 'last_contacted_date', '2024-06-30'),
(10252, 598, 'contact_method', 'Email'),
(10253, 598, 'next_action_date', '2024-08-03'),
(10254, 598, 'next_action_description', 'Follow-up action 1'),
(10255, 598, 'lead_notes', 'Notes for lead 1'),
(10256, 598, 'lead_priority', 'low'),
(10257, 598, 'lead_assigned_to', '1'),
(10258, 598, 'lead_tags', 'asdaasdasd,dasdasdasd'),
(10259, 598, 'lead_cpf', '123.456.789-1'),
(10260, 598, '_edit_lock', '1722261499:1'),
(10261, 598, '_edit_last', '1'),
(10262, 598, 'originURL', ''),
(10263, 598, 'lead_name', ''),
(10264, 599, 'lead_email', 'lead1@example.com'),
(10265, 599, 'lead_phone', '(12) 3456-7891'),
(10266, 599, 'lead_company', 'Company D'),
(10267, 599, 'lead_position', 'CEO'),
(10268, 599, 'lead_source', 'facebook'),
(10269, 599, 'lead_status', 'offer_accepted'),
(10270, 599, 'deal_value', '35'),
(10271, 599, 'deal_stage', 'Stage 4'),
(10272, 599, 'expected_close_date', '2024-07-29'),
(10273, 599, 'last_contacted_date', '2024-06-30'),
(10274, 599, 'contact_method', 'Email'),
(10275, 599, 'next_action_date', '2024-08-03'),
(10276, 599, 'next_action_description', 'Follow-up action 1'),
(10277, 599, 'lead_notes', 'Notes for lead 1'),
(10278, 599, 'lead_priority', 'medium'),
(10279, 599, 'lead_assigned_to', ''),
(10280, 599, 'lead_tags', 'asdaasdasd,dasdasdasd'),
(10281, 599, 'lead_cpf', '123.456.789-1'),
(10282, 599, '_edit_lock', '1722279734:1'),
(10283, 599, '_edit_last', '1'),
(10284, 599, 'originURL', ''),
(10285, 599, 'lead_name', ''),
(10308, 601, 'lead_email', 'lead1@example.com'),
(10309, 601, 'lead_phone', '(12) 3456-7891'),
(10310, 601, 'lead_company', 'Company D'),
(10311, 601, 'lead_position', 'CEO'),
(10312, 601, 'lead_source', 'facebook'),
(10313, 601, 'lead_status', 'needs_identified'),
(10314, 601, 'deal_value', '35'),
(10315, 601, 'deal_stage', 'Stage 4'),
(10316, 601, 'expected_close_date', '2024-07-29'),
(10317, 601, 'last_contacted_date', '2024-06-30'),
(10318, 601, 'contact_method', 'Email'),
(10319, 601, 'next_action_date', '2024-08-03'),
(10320, 601, 'next_action_description', 'Follow-up action 1'),
(10321, 601, 'lead_notes', 'Notes for lead 1'),
(10322, 601, 'lead_priority', 'low'),
(10323, 601, 'lead_assigned_to', '1'),
(10324, 601, 'lead_tags', 'asdaasdasd,dasdasdasd,teste,legal'),
(10325, 601, 'lead_cpf', '123.456.789-1'),
(10326, 601, '_edit_lock', '1722261498:1'),
(10327, 601, '_edit_last', '1'),
(10328, 601, 'originURL', ''),
(10329, 601, 'lead_name', ''),
(10374, 605, '_edit_last', '1'),
(10375, 605, '_wp_page_template', 'template-user-leads.php'),
(10376, 605, '_edit_lock', '1722281181:1'),
(10379, 599, 'lead_type', 'pj'),
(10382, 601, 'lead_type', 'pj'),
(10384, 598, 'lead_type', 'pf'),
(10385, 596, 'lead_type', 'pf'),
(10389, 607, '_edit_lock', '1721251323:1'),
(10390, 607, '_edit_last', '1'),
(10391, 607, '_wp_page_template', 'template-gerente-leads.php'),
(10392, 599, 'lead_cpf_cnpj', '555.555.555-55'),
(10397, 601, 'lead_cpf_cnpj', '70.760.456/0001-35'),
(10398, 611, '_edit_lock', '1721784939:1'),
(10399, 611, '_edit_last', '1'),
(10400, 611, '_wp_page_template', 'template-assinantes.php'),
(10404, 596, 'lead_cpf_cnpj', ''),
(10405, 598, 'lead_cpf_cnpj', ''),
(10406, 613, '_edit_lock', '1722279900:1'),
(10407, 613, '_edit_last', '1'),
(10408, 614, '_edit_last', '1'),
(10409, 614, '_wp_page_template', 'template-leads-chat.php'),
(10410, 614, '_edit_lock', '1722280723:1'),
(10411, 8, '_wp_trash_meta_status', 'publish'),
(10412, 8, '_wp_trash_meta_time', '1722280979'),
(10413, 8, '_wp_desired_post_slug', 'meus-leads-pj'),
(10416, 618, '_edit_lock', '1722558938:1'),
(10417, 618, '_edit_last', '1'),
(10418, 618, '_wp_page_template', 'template-assinantes-edit.php'),
(10419, 621, '_wp_attached_file', '2024/08/Frame-228-3-min.jpg'),
(10420, 621, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:244;s:6:\"height\";i:340;s:4:\"file\";s:27:\"2024/08/Frame-228-3-min.jpg\";s:8:\"filesize\";i:19379;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:27:\"Frame-228-3-min-215x300.jpg\";s:5:\"width\";i:215;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:12933;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:27:\"Frame-228-3-min-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";s:8:\"filesize\";i:6059;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_posts`
--

CREATE TABLE `wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(255) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2024-07-03 16:02:51', '2024-07-03 19:02:51', '<!-- wp:paragraph -->\n<p>Boas-vindas ao WordPress. Esse é o seu primeiro post. Edite-o ou exclua-o, e então comece a escrever!</p>\n<!-- /wp:paragraph -->', 'Olá, mundo!', '', 'publish', 'open', 'open', '', 'ola-mundo', '', '', '2024-07-03 16:02:51', '2024-07-03 19:02:51', '', 0, 'http://localhost/crm/?p=1', 0, 'post', '', 1),
(3, 1, '2024-07-03 16:02:51', '2024-07-03 19:02:51', '<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Quem somos</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>O endereço do nosso site é: http://localhost/crm.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Comentários</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Quando os visitantes deixam comentários no site, coletamos os dados mostrados no formulário de comentários, além do endereço de IP e de dados do navegador do visitante, para auxiliar na detecção de spam.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Uma sequência anonimizada de caracteres criada a partir do seu e-mail (também chamada de hash) poderá ser enviada para o Gravatar para verificar se você usa o serviço. A política de privacidade do Gravatar está disponível aqui: https://automattic.com/privacy/. Depois da aprovação do seu comentário, a foto do seu perfil fica visível publicamente junto de seu comentário.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Mídia</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Se você envia imagens para o site, evite enviar as que contenham dados de localização incorporados (EXIF GPS). Visitantes podem baixar estas imagens do site e extrair delas seus dados de localização.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Cookies</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Ao deixar um comentário no site, você poderá optar por salvar seu nome, e-mail e site nos cookies. Isso visa seu conforto, assim você não precisará preencher seus  dados novamente quando fizer outro comentário. Estes cookies duram um ano.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Se você tem uma conta e acessa este site, um cookie temporário será criado para determinar se seu navegador aceita cookies. Ele não contém nenhum dado pessoal e será descartado quando você fechar seu navegador.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Quando você acessa sua conta no site, também criamos vários cookies para salvar os dados da sua conta e suas escolhas de exibição de tela. Cookies de login são mantidos por dois dias e cookies de opções de tela por um ano. Se você selecionar &quot;Lembrar-me&quot;, seu acesso será mantido por duas semanas. Se você se desconectar da sua conta, os cookies de login serão removidos.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Se você editar ou publicar um artigo, um cookie adicional será salvo no seu navegador. Este cookie não inclui nenhum dado pessoal e simplesmente indica o ID do post referente ao artigo que você acabou de editar. Ele expira depois de 1 dia.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Mídia incorporada de outros sites</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Artigos neste site podem incluir conteúdo incorporado como, por exemplo, vídeos, imagens, artigos, etc. Conteúdos incorporados de outros sites se comportam exatamente da mesma forma como se o visitante estivesse visitando o outro site.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Estes sites podem coletar dados sobre você, usar cookies, incorporar rastreamento adicional de terceiros e monitorar sua interação com este conteúdo incorporado, incluindo sua interação com o conteúdo incorporado se você tem uma conta e está conectado com o site.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Com quem compartilhamos seus dados</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Se você solicitar uma redefinição de senha, seu endereço de IP será incluído no e-mail de redefinição de senha.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Por quanto tempo mantemos os seus dados</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Se você deixar um comentário, o comentário e os seus metadados são conservados indefinidamente. Fazemos isso para que seja possível reconhecer e aprovar automaticamente qualquer comentário posterior ao invés de retê-lo para moderação.</p>\n<!-- /wp:paragraph -->\n<!-- wp:paragraph -->\n<p>Para usuários que se registram no nosso site (se houver), também guardamos as informações pessoais que fornecem no seu perfil de usuário. Todos os usuários podem ver, editar ou excluir suas informações pessoais a qualquer momento (só não é possível alterar o seu username). Os administradores de sites também podem ver e editar estas informações.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Quais os seus direitos sobre seus dados</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Se você tiver uma conta neste site ou se tiver deixado comentários, pode solicitar um arquivo exportado dos dados pessoais que mantemos sobre você, inclusive quaisquer dados que nos tenha fornecido. Também pode solicitar que removamos qualquer dado pessoal que mantemos sobre você. Isto não inclui nenhuns dados que somos obrigados a manter para propósitos administrativos, legais ou de segurança.</p>\n<!-- /wp:paragraph -->\n<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Para onde seus dados são enviados</h2>\n<!-- /wp:heading -->\n<!-- wp:paragraph -->\n<p><strong class=\"privacy-policy-tutorial\">Texto sugerido: </strong>Comentários de visitantes podem ser marcados por um serviço automático de detecção de spam.</p>\n<!-- /wp:paragraph -->\n', 'Política de privacidade', '', 'draft', 'closed', 'open', '', 'politica-de-privacidade', '', '', '2024-07-03 16:02:51', '2024-07-03 19:02:51', '', 0, 'http://localhost/crm/?page_id=3', 0, 'page', '', 0),
(6, 1, '2024-07-03 16:07:02', '2024-07-03 19:07:02', '', 'Index', '', 'publish', 'closed', 'closed', '', 'index', '', '', '2024-07-03 16:07:02', '2024-07-03 19:07:02', '', 0, 'http://localhost/crm/?page_id=6', 0, 'page', '', 0),
(7, 1, '2024-07-03 16:07:02', '2024-07-03 19:07:02', '', 'Index', '', 'inherit', 'closed', 'closed', '', '6-revision-v1', '', '', '2024-07-03 16:07:02', '2024-07-03 19:07:02', '', 6, 'http://localhost/crm/?p=7', 0, 'revision', '', 0),
(8, 1, '2024-07-03 22:13:33', '2024-07-04 01:13:33', '', 'Meus leads PJ', '', 'trash', 'closed', 'closed', '', 'meus-leads-pj__trashed', '', '', '2024-07-29 16:22:59', '2024-07-29 19:22:59', '', 0, 'http://localhost/crm/?page_id=8', 0, 'page', '', 0),
(9, 1, '2024-07-03 22:13:33', '2024-07-04 01:13:33', '', 'Minhas leads', '', 'inherit', 'closed', 'closed', '', '8-revision-v1', '', '', '2024-07-03 22:13:33', '2024-07-04 01:13:33', '', 8, 'http://localhost/crm/?p=9', 0, 'revision', '', 0),
(566, 1, '2024-07-05 16:17:52', '2024-07-05 19:17:52', '', 'Perfil', '', 'publish', 'closed', 'closed', '', 'perfil', '', '', '2024-07-05 16:17:52', '2024-07-05 19:17:52', '', 0, 'http://localhost/crm/?page_id=566', 0, 'page', '', 0),
(567, 1, '2024-07-05 16:17:52', '2024-07-05 19:17:52', '', 'Perfil', '', 'inherit', 'closed', 'closed', '', '566-revision-v1', '', '', '2024-07-05 16:17:52', '2024-07-05 19:17:52', '', 566, 'http://localhost/crm/?p=567', 0, 'revision', '', 0),
(569, 1, '2024-07-07 19:12:50', '2024-07-07 22:12:50', '', 'Checkout', '', 'publish', 'closed', 'closed', '', 'checkout', '', '', '2024-07-07 19:12:50', '2024-07-07 22:12:50', '', 0, 'http://localhost/crm/?page_id=569', 0, 'page', '', 0),
(570, 1, '2024-07-07 19:12:50', '2024-07-07 22:12:50', '', 'Checkout', '', 'inherit', 'closed', 'closed', '', '569-revision-v1', '', '', '2024-07-07 19:12:50', '2024-07-07 22:12:50', '', 569, 'http://localhost/crm/?p=570', 0, 'revision', '', 0),
(572, 1, '2024-07-08 17:55:03', '2024-07-08 20:55:03', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id', '', '', '2024-07-08 17:55:03', '2024-07-08 20:55:03', '', 0, 'http://localhost/crm/?p=572', 0, 'sale', '', 0),
(573, 1, '2024-07-08 18:56:08', '2024-07-08 21:56:08', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id-2', '', '', '2024-07-08 18:56:08', '2024-07-08 21:56:08', '', 0, 'http://localhost/crm/?p=573', 0, 'sale', '', 0),
(574, 1, '2024-07-08 18:56:47', '2024-07-08 21:56:47', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id-3', '', '', '2024-07-08 18:56:47', '2024-07-08 21:56:47', '', 0, 'http://localhost/crm/?p=574', 0, 'sale', '', 0),
(575, 1, '2024-07-08 18:59:08', '2024-07-08 21:59:08', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id-4', '', '', '2024-07-08 18:59:08', '2024-07-08 21:59:08', '', 0, 'http://localhost/crm/?p=575', 0, 'sale', '', 0),
(576, 1, '2024-07-08 19:18:16', '2024-07-08 22:18:16', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id-5', '', '', '2024-07-08 19:18:16', '2024-07-08 22:18:16', '', 0, 'http://localhost/crm/?p=576', 0, 'sale', '', 0),
(577, 1, '2024-07-08 19:38:07', '2024-07-08 22:38:07', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id-6', '', '', '2024-07-08 19:38:07', '2024-07-08 22:38:07', '', 0, 'http://localhost/crm/?p=577', 0, 'sale', '', 0),
(578, 1, '2024-07-08 20:19:56', '2024-07-08 23:19:56', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id-7', '', '', '2024-07-08 20:19:56', '2024-07-08 23:19:56', '', 0, 'http://localhost/crm/?p=578', 0, 'sale', '', 0),
(579, 1, '2024-07-08 20:49:24', '2024-07-08 23:49:24', '', 'Venda para Usuário ID:', '', 'publish', 'closed', 'closed', '', 'venda-para-usuario-id-8', '', '', '2024-07-08 20:49:24', '2024-07-08 23:49:24', '', 0, 'http://localhost/crm/?p=579', 0, 'sale', '', 0),
(581, 1, '2024-07-09 14:30:51', '2024-07-09 17:30:51', '', 'Login', '', 'publish', 'closed', 'closed', '', 'login', '', '', '2024-07-09 14:30:51', '2024-07-09 17:30:51', '', 0, 'http://localhost/crm/?page_id=581', 0, 'page', '', 0),
(582, 1, '2024-07-09 14:30:51', '2024-07-09 17:30:51', '', 'Login', '', 'inherit', 'closed', 'closed', '', '581-revision-v1', '', '', '2024-07-09 14:30:51', '2024-07-09 17:30:51', '', 581, 'http://localhost/crm/?p=582', 0, 'revision', '', 0),
(584, 1, '2024-07-10 09:26:25', '2024-07-10 12:26:25', '', 'Meus leads', '', 'inherit', 'closed', 'closed', '', '8-revision-v1', '', '', '2024-07-10 09:26:25', '2024-07-10 12:26:25', '', 8, 'http://localhost/crm/?p=584', 0, 'revision', '', 0),
(586, 1, '2024-07-10 17:59:03', '2024-07-10 20:59:03', '', 'Logout', '', 'publish', 'closed', 'closed', '', 'logout', '', '', '2024-07-10 17:59:03', '2024-07-10 20:59:03', '', 0, 'http://localhost/crm/?page_id=586', 0, 'page', '', 0),
(587, 1, '2024-07-10 17:59:03', '2024-07-10 20:59:03', '', 'Logout', '', 'inherit', 'closed', 'closed', '', '586-revision-v1', '', '', '2024-07-10 17:59:03', '2024-07-10 20:59:03', '', 586, 'http://localhost/crm/?p=587', 0, 'revision', '', 0),
(595, 1, '2024-07-16 19:15:42', '2024-07-16 22:15:42', '', 'Novo #2', '', 'trash', 'closed', 'closed', '', 'novo__trashed', '', '', '2024-07-16 19:15:42', '2024-07-16 22:15:42', '', 0, 'http://localhost/crm/?post_type=leads&#038;p=595', 0, 'leads', '', 0),
(596, 1, '2024-07-16 19:16:55', '2024-07-16 22:16:55', '', 'Lead duplicado', '', 'publish', 'closed', 'closed', '', 'lead-1-2', '', '', '2024-08-01 21:38:39', '2024-08-02 00:38:39', '', 0, 'http://localhost/crm/?post_type=leads&#038;p=596', 0, 'leads', '', 0),
(598, 1, '2024-07-16 19:32:03', '2024-07-16 22:32:03', '', 'Lead  duplicado', '', 'publish', 'closed', 'closed', '', 'lead-duplicado-3', '', '', '2024-07-29 11:08:04', '2024-07-29 14:08:04', '', 0, 'http://localhost/crm/?post_type=leads&#038;p=598', 0, 'leads', '', 0),
(599, 1, '2024-07-16 19:32:03', '2024-07-16 22:32:03', '', 'Novo', '', 'publish', 'closed', 'closed', '', 'lead-duplicado-2', '', '', '2024-08-02 18:48:36', '2024-08-02 21:48:36', '', 0, 'http://localhost/crm/?post_type=leads&#038;p=599', 0, 'leads', '', 0),
(601, 1, '2024-07-16 19:47:30', '2024-07-16 22:47:30', '', 'mais e', '', 'publish', 'closed', 'closed', '', 'mais-um-hoje', '', '', '2024-08-13 15:33:53', '2024-08-13 18:33:53', '', 0, 'http://localhost/crm/?post_type=leads&#038;p=601', 0, 'leads', '', 0),
(604, 1, '2024-07-17 17:30:20', '2024-07-17 20:30:20', '', 'Meus leads PJ', '', 'inherit', 'closed', 'closed', '', '8-revision-v1', '', '', '2024-07-17 17:30:20', '2024-07-17 20:30:20', '', 8, 'http://localhost/crm/?p=604', 0, 'revision', '', 0),
(605, 1, '2024-07-17 17:30:42', '2024-07-17 20:30:42', '', 'Leads', '', 'publish', 'closed', 'closed', '', 'leads', '', '', '2024-07-29 16:24:40', '2024-07-29 19:24:40', '', 0, 'http://localhost/crm/?page_id=605', 0, 'page', '', 0),
(606, 1, '2024-07-17 17:30:42', '2024-07-17 20:30:42', '', 'Meus leads PF', '', 'inherit', 'closed', 'closed', '', '605-revision-v1', '', '', '2024-07-17 17:30:42', '2024-07-17 20:30:42', '', 605, 'http://localhost/crm/?p=606', 0, 'revision', '', 0),
(607, 1, '2024-07-17 18:03:31', '2024-07-17 21:03:31', '', 'Gerente leads', '', 'publish', 'closed', 'closed', '', 'gerente-leads', '', '', '2024-07-17 18:04:30', '2024-07-17 21:04:30', '', 0, 'http://localhost/crm/?page_id=607', 0, 'page', '', 0),
(608, 1, '2024-07-17 18:03:31', '2024-07-17 21:03:31', '', 'Leads', '', 'inherit', 'closed', 'closed', '', '607-revision-v1', '', '', '2024-07-17 18:03:31', '2024-07-17 21:03:31', '', 607, 'http://localhost/crm/?p=608', 0, 'revision', '', 0),
(609, 1, '2024-07-17 18:04:30', '2024-07-17 21:04:30', '', 'Gerente leads', '', 'inherit', 'closed', 'closed', '', '607-revision-v1', '', '', '2024-07-17 18:04:30', '2024-07-17 21:04:30', '', 607, 'http://localhost/crm/?p=609', 0, 'revision', '', 0),
(611, 1, '2024-07-23 21:06:03', '2024-07-24 00:06:03', '', 'Assinantes', '', 'publish', 'closed', 'closed', '', 'assinantes', '', '', '2024-07-23 21:06:56', '2024-07-24 00:06:56', '', 0, 'http://localhost/crm/?page_id=611', 0, 'page', '', 0),
(612, 1, '2024-07-23 21:06:03', '2024-07-24 00:06:03', '', 'Assinantes', '', 'inherit', 'closed', 'closed', '', '611-revision-v1', '', '', '2024-07-23 21:06:03', '2024-07-24 00:06:03', '', 611, 'http://localhost/crm/?p=612', 0, 'revision', '', 0),
(613, 1, '2024-07-29 16:04:45', '0000-00-00 00:00:00', '', 'Chat', '', 'draft', 'closed', 'closed', '', '', '', '', '2024-07-29 16:04:45', '2024-07-29 19:04:45', '', 0, 'http://localhost/crm/?page_id=613', 0, 'page', '', 0),
(614, 1, '2024-07-29 16:05:13', '2024-07-29 19:05:13', '', 'Chat', '', 'publish', 'closed', 'closed', '', 'chat', '', '', '2024-07-29 16:05:13', '2024-07-29 19:05:13', '', 0, 'http://localhost/crm/?page_id=614', 0, 'page', '', 0),
(615, 1, '2024-07-29 16:05:13', '2024-07-29 19:05:13', '', 'Chat', '', 'inherit', 'closed', 'closed', '', '614-revision-v1', '', '', '2024-07-29 16:05:13', '2024-07-29 19:05:13', '', 614, 'http://localhost/crm/?p=615', 0, 'revision', '', 0),
(616, 1, '2024-07-29 16:23:54', '2024-07-29 19:23:54', '', 'Leads', '', 'inherit', 'closed', 'closed', '', '605-revision-v1', '', '', '2024-07-29 16:23:54', '2024-07-29 19:23:54', '', 605, 'http://localhost/crm/?p=616', 0, 'revision', '', 0),
(618, 1, '2024-08-01 20:29:26', '2024-08-01 23:29:26', '', 'Editar', '', 'publish', 'closed', 'closed', '', 'editar', '', '', '2024-08-01 20:29:26', '2024-08-01 23:29:26', '', 611, 'http://localhost/crm/?page_id=618', 0, 'page', '', 0),
(619, 1, '2024-08-01 20:29:26', '2024-08-01 23:29:26', '', 'Editar', '', 'inherit', 'closed', 'closed', '', '618-revision-v1', '', '', '2024-08-01 20:29:26', '2024-08-01 23:29:26', '', 618, 'http://localhost/crm/?p=619', 0, 'revision', '', 0),
(620, 1, '2024-08-09 19:28:23', '0000-00-00 00:00:00', '', 'Rascunho automático', '', 'auto-draft', 'open', 'open', '', '', '', '', '2024-08-09 19:28:23', '0000-00-00 00:00:00', '', 0, 'http://localhost/crm/?p=620', 0, 'post', '', 0),
(621, 1, '2024-08-13 15:31:53', '2024-08-13 18:31:53', '', 'Cxampphtdocscrmwp-contentuploads202408Frame-228-3-min.jpg', '', 'inherit', 'open', 'closed', '', 'cxampphtdocscrmwp-contentuploads202408frame-228-3-min-jpg', '', '', '2024-08-13 15:31:53', '2024-08-13 18:31:53', '', 0, 'http://localhost/crm/wp-content/uploads/2024/08/Frame-228-3-min.jpg', 0, 'attachment', 'image/jpeg', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_sales`
--

CREATE TABLE `wp_sales` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sale_date` varchar(255) NOT NULL,
  `sale_amount` varchar(255) NOT NULL,
  `sale_confirmed` varchar(255) NOT NULL,
  `sale_received` varchar(255) NOT NULL,
  `sale_status` varchar(255) NOT NULL,
  `sale_vendor_id` varchar(255) DEFAULT NULL,
  `sale_asaas_subscription_id` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_sales`
--

INSERT INTO `wp_sales` (`id`, `name`, `sale_date`, `sale_amount`, `sale_confirmed`, `sale_received`, `sale_status`, `sale_vendor_id`, `sale_asaas_subscription_id`, `created_at`, `updated_at`) VALUES
(5, '', '2024-07-11 01:13:07', '35', '2024-05-28 23:11:31', '2024-05-29 00:11:31', 'PAYMENT_CONFIRMED', '1', 'sub_gd16lxtd52aik7qj', '2024-07-11 19:58:00', '2024-07-12 17:27:02'),
(6, 'Maria de Lourdes da Silva Dourado ', '2024-07-10 11:26:15', '35', '2024-07-02 10:54:31', '2024-07-02 11:54:31', 'PAYMENT_RECEIVED', '1', 'sub_5ffx2ww9sbo6stmb', '2024-07-11 19:59:21', '2024-07-12 17:27:02'),
(7, 'Jose Antônio Olivencia Rodrigues', '2024-07-07 13:10:08', '35', '2024-05-23 16:06:31', '2024-05-23 17:06:31', 'PAYMENT_CONFIRMED', '1', 'sub_2o0n1x224vph287a', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(8, 'Valdinelia Mota Dos Santos ', '2024-07-08 14:29:06', '35', '2024-04-26 02:22:31', '2024-04-26 03:22:31', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(9, 'Nairan Sena', '2024-07-10 07:00:12', '35', '2024-05-10 06:46:31', '2024-05-10 07:46:31', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(10, 'ISMAEL EVANDRO FLORA AGOISTINHO ', '2024-07-07 22:24:17', '35', '2024-06-09 01:10:31', '2024-06-09 02:10:31', 'PAYMENT_RECEIVED', '1', 'sub_mb5b4fnb6oxmz4n6', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(11, 'Alcides Oliveira', '2024-07-10 02:01:55', '35', '2024-06-07 04:54:31', '2024-06-07 05:54:31', 'PAYMENT_CONFIRMED', '1', 'sub_5zaguxsmwgxe1mh3', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(12, 'Lucila Ulian', '2024-07-10 01:10:51', '35', '2024-04-14 00:45:31', '2024-04-14 01:45:31', 'PAYMENT_RECEIVED', '1', 'sub_0t4xho6k9aubucb3', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(13, 'Marcelino Gierts ', '2024-07-09 11:45:07', '35', '2024-07-07 23:00:31', '2024-07-08 00:00:31', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(14, 'Solange Santiago Mendes', '2024-07-06 10:07:48', '35', '2024-07-09 19:15:31', '2024-07-09 20:15:31', 'PAYMENT_RECEIVED', '1', 'sub_dtg3h98zhql0mn13', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(15, 'JOAO ROBERTO CAVALLARO', '2024-07-10 20:00:18', '35', '2024-05-17 05:22:31', '2024-05-17 06:22:31', 'PAYMENT_CONFIRMED', '1', 'sub_p4hn53im1qmabur8', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(16, 'Veronica Juliana da Silva Oliveira', '2024-07-09 21:47:28', '35', '2024-06-17 02:20:31', '2024-06-17 03:20:31', 'PAYMENT_RECEIVED', '1', 'sub_vl5i3c1qfi1282xn', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(17, 'Maria Judete Lopes da Silva', '2024-07-06 11:24:59', '35', '2024-05-14 08:11:31', '2024-05-14 09:11:31', 'PAYMENT_CONFIRMED', '1', 'sub_s78cfhtffxbck2c0', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(18, 'Genisa Jacinto de Oliveira bernardo', '2024-07-09 10:37:21', '35', '2024-04-19 18:15:31', '2024-04-19 19:15:31', 'PAYMENT_RECEIVED', '1', 'sub_g9lwqc1s011y8wos', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(19, 'Rubens Gregatti ', '2024-07-09 02:01:16', '35', '2024-07-07 21:33:31', '2024-07-07 22:33:31', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(20, 'Mario Sergio Daineze', '2024-07-12 00:32:10', '35', '2024-07-08 08:10:31', '2024-07-08 09:10:31', 'PAYMENT_RECEIVED', '1', 'sub_eeecsehrtnor3932', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(21, 'JOSE FERREIRA DE SOUZA', '2024-07-11 00:28:59', '35', '2024-05-25 02:56:31', '2024-05-25 03:56:31', 'PAYMENT_CONFIRMED', '1', 'sub_x96ltp7ygm8vu764', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(22, 'Maria José de Oliveira Lunardi', '2024-07-10 09:20:11', '35', '2024-06-23 22:54:31', '2024-06-23 23:54:31', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(23, 'Dorival Fatimo Dourado', '2024-07-07 13:47:08', '35', '2024-05-15 19:53:31', '2024-05-15 20:53:31', 'PAYMENT_CONFIRMED', '1', 'sub_5ffx2ww9sbo6stmb', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(24, 'LUIZ SERGIO DE OLIVEIRA', '2024-07-06 16:58:48', '35', '2024-07-01 09:38:31', '2024-07-01 10:38:31', 'PAYMENT_RECEIVED', '1', 'sub_iqpj9rpai1ud1e7f', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(25, 'ALICE MENDES DE CARVAHO ', '2024-07-07 23:40:31', '35', '2024-06-29 17:50:31', '2024-06-29 18:50:31', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(26, 'MARCELO BIZARRO', '2024-07-07 10:39:05', '35', '2024-04-22 11:09:31', '2024-04-22 12:09:31', 'PAYMENT_RECEIVED', '1', 'sub_8rxc4wngfe4msf45', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(27, 'ELIZABETE RITA VASCONCELOS RIBEIRO ', '2024-07-09 08:08:08', '35', '2024-07-08 07:38:31', '2024-07-08 08:38:31', 'PAYMENT_CONFIRMED', '1', 'sub_59srh0574gdbemxx', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(28, 'ELIZABETE RITA VASCONCELOS RIBEIRO ', '2024-07-09 02:52:04', '35', '2024-06-25 03:03:31', '2024-06-25 04:03:31', 'PAYMENT_RECEIVED', '1', 'sub_59srh0574gdbemxx', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(29, 'Marcio Rodrigues ', '2024-07-07 13:09:15', '35', '2024-06-25 08:12:31', '2024-06-25 09:12:31', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(30, 'MARIA MARTINHA DOS SANTOS AGOSTINO', '2024-07-11 04:34:55', '35', '2024-07-03 15:36:31', '2024-07-03 16:36:31', 'PAYMENT_RECEIVED', '1', 'sub_mb5b4fnb6oxmz4n6', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(31, 'Ariadna Isabel Micheletti Ribeiro ', '2024-07-10 07:08:46', '35', '2024-04-20 14:52:31', '2024-04-20 15:52:31', 'PAYMENT_CONFIRMED', '1', 'sub_onx4wdi8hl3ctro0', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(32, 'Almir de Araujo Zabisky ', '2024-07-10 15:49:40', '35', '2024-04-14 18:17:31', '2024-04-14 19:17:31', 'PAYMENT_RECEIVED', '1', 'sub_n66fxq07ojw3vg1b', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(33, 'Maria de Lourdes Ramos Russi', '2024-07-07 04:34:09', '35', '2024-05-12 22:10:31', '2024-05-12 23:10:31', 'PAYMENT_CONFIRMED', '1', 'sub_lpxdt6sd74c0yrh8', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(34, 'JOAO BOSCO MARTINS ', '2024-07-05 23:30:45', '35', '2024-06-28 01:26:31', '2024-06-28 02:26:31', 'PAYMENT_RECEIVED', '1', 'sub_mfgsnai4cvprqz5c', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(35, 'Aparecida Zabisky', '2024-07-11 16:58:42', '35', '2024-06-17 14:14:31', '2024-06-17 15:14:31', 'PAYMENT_CONFIRMED', '1', 'sub_n66fxq07ojw3vg1b', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(36, 'CINIRA BOVE MARTINS', '2024-07-11 17:37:17', '35', '2024-07-11 06:03:31', '2024-07-11 07:03:31', 'PAYMENT_RECEIVED', '1', 'sub_mfgsnai4cvprqz5c', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(37, 'JOSE CARLOS DE MORAES', '2024-07-07 10:18:53', '35', '2024-05-09 16:51:31', '2024-05-09 17:51:31', 'PAYMENT_CONFIRMED', '1', 'sub_uc0thxik33fqf576', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(38, 'Paulo Sérgio Teixeira', '2024-07-11 08:06:07', '35', '2024-05-04 17:01:31', '2024-05-04 18:01:31', 'PAYMENT_RECEIVED', '1', 'sub_zp1b6jwl7wlyaily', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(39, 'Esdras Silva Almeida ', '2024-07-08 15:51:40', '35', '2024-06-08 03:40:31', '2024-06-08 04:40:31', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(40, 'IVONEIDE NOGUEIRA DOS SANTOS OLIVEIRA ', '2024-07-07 03:59:09', '35', '2024-04-24 23:36:31', '2024-04-25 00:36:31', 'PAYMENT_RECEIVED', '1', 'sub_iqpj9rpai1ud1e7f', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(41, 'Rosa Caparrotto de mello', '2024-07-10 21:47:24', '35', '2024-06-17 20:58:31', '2024-06-17 21:58:31', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(42, 'Pedro pina', '2024-07-10 20:01:25', '35', '2024-05-01 15:07:31', '2024-05-01 16:07:31', 'PAYMENT_RECEIVED', '1', 'sub_khj7qn5qa7jwcwkv', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(43, 'LUIZ CARLOS VELASQUE', '2024-07-11 13:59:24', '35', '2024-06-17 18:58:31', '2024-06-17 19:58:31', 'PAYMENT_CONFIRMED', '1', 'sub_uv1dn2i53ho0a5hq', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(44, 'Eliana Almeida', '2024-07-08 19:48:39', '35', '2024-05-15 05:58:31', '2024-05-15 06:58:31', 'PAYMENT_RECEIVED', '1', 'sub_fln417qgf1u8qsuo', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(45, 'Eduardo Araujo Fonseca ', '2024-07-11 00:32:45', '35', '2024-07-07 00:20:31', '2024-07-07 01:20:31', 'PAYMENT_CONFIRMED', '1', 'sub_q8d5iq7yhw0tslu3', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(46, 'Edson Charcou ', '2024-07-11 21:04:25', '35', '2024-05-07 02:23:31', '2024-05-07 03:23:31', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(47, 'MIRIAM AQUINO RIBEIRO DE FREITAS ', '2024-07-12 11:24:00', '35', '2024-06-13 06:51:32', '2024-06-13 07:51:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(48, 'Ademilson Gomes Rodrigues ', '2024-07-07 21:42:19', '35', '2024-04-30 13:11:32', '2024-04-30 14:11:32', 'PAYMENT_RECEIVED', '1', 'sub_prbd508aa3onb4zr', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(49, 'Dolores Corrêa', '2024-07-08 01:06:05', '35', '2024-05-22 07:17:32', '2024-05-22 08:17:32', 'PAYMENT_CONFIRMED', '1', 'sub_oc48118k00cag2l8', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(50, 'Gilmar Costa dos Santos ', '2024-07-09 16:53:22', '35', '2024-06-08 07:50:32', '2024-06-08 08:50:32', 'PAYMENT_RECEIVED', '1', 'sub_lwi57fznkb6bb933', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(51, 'JOSE EVARISTO DOS SANTOS', '2024-07-08 08:27:42', '35', '2024-04-26 08:39:32', '2024-04-26 09:39:32', 'PAYMENT_CONFIRMED', '1', 'sub_5tdnczojtpk5bza4', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(52, 'LUIZ CLAUDIO DREER ', '2024-07-10 06:40:14', '35', '2024-05-24 12:11:32', '2024-05-24 13:11:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(53, 'JURANDIR BOTARO ', '2024-07-07 21:05:46', '35', '2024-04-26 13:34:32', '2024-04-26 14:34:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(54, 'Assinoe Castilho Brito', '2024-07-06 21:10:48', '35', '2024-07-07 03:06:32', '2024-07-07 04:06:32', 'PAYMENT_RECEIVED', '1', 'sub_spk4ozbg9qttxxhv', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(55, 'Marli De Lima ribeiro todaro', '2024-07-07 06:13:02', '35', '2024-06-09 18:15:32', '2024-06-09 19:15:32', 'PAYMENT_CONFIRMED', '1', 'sub_4bscpr0j63se1pxh', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(56, 'FABIO MIGUEL PIRES ', '2024-07-07 18:44:55', '35', '2024-04-16 21:20:32', '2024-04-16 22:20:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(57, 'Rita De Cássia mattos', '2024-07-11 22:23:03', '35', '2024-06-13 19:14:32', '2024-06-13 20:14:32', 'PAYMENT_CONFIRMED', '1', 'sub_jsnjj2eizywqwrz9', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(58, 'Sergio Mmartins pereira', '2024-07-09 20:36:10', '35', '2024-05-10 17:53:32', '2024-05-10 18:53:32', 'PAYMENT_RECEIVED', '1', 'sub_r8ir9s73gmwfjr6a', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(59, 'JOSE MIGUEL DA SILVA ', '2024-07-11 08:11:10', '35', '2024-05-05 14:49:32', '2024-05-05 15:49:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(60, 'Célia Regina', '2024-07-09 06:01:15', '35', '2024-07-08 19:49:32', '2024-07-08 20:49:32', 'PAYMENT_RECEIVED', '1', 'sub_jrwhutiyd9qlda13', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(61, 'lourdes aparecida moreira de oliveira', '2024-07-12 07:47:16', '35', '2024-06-24 03:51:32', '2024-06-24 04:51:32', 'PAYMENT_CONFIRMED', '1', 'sub_nrtigtqbo1p7j7bu', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(62, 'Maria Mônica Freitas', '2024-07-08 19:29:50', '35', '2024-04-19 16:48:32', '2024-04-19 17:48:32', 'PAYMENT_RECEIVED', '1', 'sub_iozqhpkh0yqy49tj', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(63, 'Cláudio Ulian ', '2024-07-09 20:29:23', '35', '2024-05-16 17:09:32', '2024-05-16 18:09:32', 'PAYMENT_CONFIRMED', '1', 'sub_0t4xho6k9aubucb3', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(64, 'Marili Do Prado', '2024-07-11 06:05:07', '35', '2024-05-22 18:32:32', '2024-05-22 19:32:32', 'PAYMENT_RECEIVED', '1', 'sub_glz6td55r9sce746', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(65, 'Amauri Aparecido Gandini ', '2024-07-06 03:57:05', '35', '2024-04-24 13:31:32', '2024-04-24 14:31:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(66, 'David Martins ', '2024-07-07 04:29:52', '35', '2024-04-15 03:53:32', '2024-04-15 04:53:32', 'PAYMENT_RECEIVED', '1', 'sub_ukt9mchn3ly5euog', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(67, 'Maria Eduarda martins ', '2024-07-06 04:31:47', '35', '2024-04-15 03:15:32', '2024-04-15 04:15:32', 'PAYMENT_CONFIRMED', '1', 'sub_ukt9mchn3ly5euog', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(68, 'Valdete Maria de Salles', '2024-07-11 22:11:43', '35', '2024-06-30 22:32:32', '2024-06-30 23:32:32', 'PAYMENT_RECEIVED', '1', 'sub_8gfv58hi0tw1yj0f', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(69, 'ROSEMARI APARECIDA DAS DORES', '2024-07-10 03:21:12', '35', '2024-06-07 16:49:32', '2024-06-07 17:49:32', 'PAYMENT_CONFIRMED', '1', 'sub_iqet6p06umddqq72', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(70, 'Valdir Oliveira da Silva', '2024-07-10 02:11:16', '35', '2024-04-25 17:42:32', '2024-04-25 18:42:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(71, 'Patrícia Gonçalves do Nascimento ', '2024-07-10 00:24:26', '35', '2024-06-29 07:11:32', '2024-06-29 08:11:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(72, 'neide carvalho de moraes', '2024-07-12 10:37:54', '35', '2024-05-10 18:14:32', '2024-05-10 19:14:32', 'PAYMENT_RECEIVED', '1', 'sub_ui80cb63z8oyp646', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(73, 'Ivone Ulian ', '2024-07-09 12:50:56', '35', '2024-04-21 02:00:32', '2024-04-21 03:00:32', 'PAYMENT_CONFIRMED', '1', 'sub_0t4xho6k9aubucb3', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(74, 'Marcia Rodrigues ', '2024-07-11 23:43:04', '35', '2024-04-28 02:14:32', '2024-04-28 03:14:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(75, 'Ednea Soares Moraes Rodrigues ', '2024-07-10 08:08:49', '35', '2024-04-28 01:35:32', '2024-04-28 02:35:32', 'PAYMENT_CONFIRMED', '1', 'sub_2o0n1x224vph287a', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(76, 'Sineide Nazaré Leite', '2024-07-11 13:35:53', '35', '2024-06-29 17:37:32', '2024-06-29 18:37:32', 'PAYMENT_RECEIVED', '1', 'sub_1sxwxuiorvbkfxgd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(77, 'Silvia Cristina Marques', '2024-07-10 18:24:40', '35', '2024-04-28 18:32:32', '2024-04-28 19:32:32', 'PAYMENT_CONFIRMED', '1', 'sub_qq2pt0a05wmi2n37', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(78, 'SUELI MENDES ALMEIDA ', '2024-07-12 01:01:00', '35', '2024-07-06 16:33:32', '2024-07-06 17:33:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(79, 'Claudia Rodrigues Fonseca', '2024-07-08 20:50:12', '35', '2024-06-19 06:37:32', '2024-06-19 07:37:32', 'PAYMENT_CONFIRMED', '1', 'sub_nzf41ltel92wgz9v', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(80, 'Marcelo Aparecido Conde', '2024-07-09 01:31:10', '35', '2024-06-01 07:08:32', '2024-06-01 08:08:32', 'PAYMENT_RECEIVED', '1', 'sub_qnwoh68zjlr3urtn', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(81, 'ANTONIO CARLOS BOVE ', '2024-07-11 03:00:05', '35', '2024-05-13 19:54:32', '2024-05-13 20:54:32', 'PAYMENT_CONFIRMED', '1', 'sub_mfgsnai4cvprqz5c', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(82, 'Márcia Cecon', '2024-07-06 06:27:10', '35', '2024-04-22 05:56:32', '2024-04-22 06:56:32', 'PAYMENT_RECEIVED', '1', 'sub_kfb526z4l27rt173', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(83, 'Neide Regina Marinho de Amorim ', '2024-07-06 11:03:35', '35', '2024-05-13 18:54:32', '2024-05-13 19:54:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(84, 'CRISTINA ARAUJO DA FONSECA ', '2024-07-06 09:33:43', '35', '2024-05-25 16:16:32', '2024-05-25 17:16:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(85, 'Marlene Dos Santos Rodrigues', '2024-07-09 14:40:17', '35', '2024-06-24 21:01:32', '2024-06-24 22:01:32', 'PAYMENT_CONFIRMED', '1', 'sub_prbd508aa3onb4zr', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(86, 'Andrea Souza Santos Tobias ', '2024-07-12 18:24:45', '35', '2024-07-05 04:44:32', '2024-07-05 05:44:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(87, 'MARIA APARECIDA DE CARVALHO ', '2024-07-10 06:07:19', '35', '2024-05-11 17:58:32', '2024-05-11 18:58:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(88, 'Maria Merencio Da Costa Silva ', '2024-07-07 15:19:18', '35', '2024-06-06 05:45:32', '2024-06-06 06:45:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(89, 'Julieta Santos', '2024-07-07 21:37:29', '35', '2024-04-20 10:06:32', '2024-04-20 11:06:32', 'PAYMENT_CONFIRMED', '1', 'sub_9ew7eyuexme3qemp', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(90, 'Kiusam Oliveira', '2024-07-09 13:34:15', '35', '2024-04-18 00:33:32', '2024-04-18 01:33:32', 'PAYMENT_RECEIVED', '1', 'sub_2mbpqliar6jmaj8k', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(91, 'DALVA MARIA PERGOLI', '2024-07-09 06:55:49', '35', '2024-06-13 01:59:32', '2024-06-13 02:59:32', 'PAYMENT_CONFIRMED', '1', 'sub_uqhas6agscfzudcf', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(92, 'Urisnei Carlos Martins da Silva', '2024-07-08 10:45:06', '35', '2024-06-04 09:17:32', '2024-06-04 10:17:32', 'PAYMENT_RECEIVED', '1', 'sub_gee3fvn123rvsaoy', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(93, 'Gledistone Rodrigues Nylander', '2024-07-05 20:29:43', '35', '2024-05-18 10:55:32', '2024-05-18 11:55:32', 'PAYMENT_CONFIRMED', '1', 'sub_r03n5g3kapp7mqbl', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(94, 'Wanderley Francisco Gomes ', '2024-07-08 14:01:06', '35', '2024-05-27 07:53:32', '2024-05-27 08:53:32', 'PAYMENT_RECEIVED', '1', 'sub_ix2x58tgqbugm7hl', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(95, 'GERALDO LOPES DE OLIVEIRA', '2024-07-10 23:16:40', '35', '2024-05-12 00:12:32', '2024-05-12 01:12:32', 'PAYMENT_CONFIRMED', '1', 'sub_khp17ife1625vtz6', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(96, 'Rosângela Baptista Ramos Gandini ', '2024-07-12 15:05:00', '35', '2024-04-18 12:40:32', '2024-04-18 13:40:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(97, 'Jurandir Baganha Da Costa ', '2024-07-06 16:00:59', '35', '2024-04-22 04:44:32', '2024-04-22 05:44:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(98, 'Jane Luci da s. Gonçalves ', '2024-07-07 22:48:10', '35', '2024-05-27 00:54:32', '2024-05-27 01:54:32', 'PAYMENT_RECEIVED', '1', 'sub_q6d57pr0rjtnqxl1', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(99, 'Monica Fusco ciunciusky ', '2024-07-09 12:59:10', '35', '2024-06-15 07:08:32', '2024-06-15 08:08:32', 'PAYMENT_CONFIRMED', '1', 'sub_0k6dtlklk888b1jd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(100, 'AUGUSTINHO REDONDO', '2024-07-09 15:14:02', '35', '2024-06-20 05:25:32', '2024-06-20 06:25:32', 'PAYMENT_RECEIVED', '1', 'sub_yz74gmih0i3wd60n', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(101, 'Ivone Pedroza macedo ', '2024-07-11 14:13:33', '35', '2024-05-16 03:13:32', '2024-05-16 04:13:32', 'PAYMENT_CONFIRMED', '1', 'sub_0k6dtlklk888b1jd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(102, 'Gilza Cestari', '2024-07-09 05:07:55', '35', '2024-05-17 21:18:32', '2024-05-17 22:18:32', 'PAYMENT_RECEIVED', '1', 'sub_3xmqwogji6wb1yuv', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(103, 'Renata Alves dos Santos ', '2024-07-08 14:05:22', '35', '2024-04-24 18:49:32', '2024-04-24 19:49:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(104, 'Jose domingos veline ', '2024-07-08 12:28:51', '35', '2024-05-11 12:21:32', '2024-05-11 13:21:32', 'PAYMENT_RECEIVED', '1', 'sub_we046gyr8tm6ox9i', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(105, 'Judite Fátima Vasconcelos Ribeiro ', '2024-07-09 15:44:54', '35', '2024-06-29 06:55:32', '2024-06-29 07:55:32', 'PAYMENT_CONFIRMED', '1', 'sub_59srh0574gdbemxx', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(106, 'ROSARIA BUCINO ALUOTTO ', '2024-07-06 19:10:33', '35', '2024-06-16 20:11:32', '2024-06-16 21:11:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(107, 'IVANY AMARAL SOUSA ', '2024-07-11 20:13:57', '35', '2024-05-30 19:41:32', '2024-05-30 20:41:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(108, 'Iolanda Nunes Ferregatto', '2024-07-09 22:40:24', '35', '2024-06-21 22:28:32', '2024-06-21 23:28:32', 'PAYMENT_RECEIVED', '1', 'sub_9qoryhkb4bt6jrqd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(109, 'Adalberto Brassaroto101', '2024-07-09 06:41:20', '35', '2024-04-26 11:15:32', '2024-04-26 12:15:32', 'PAYMENT_CONFIRMED', '1', 'sub_tb3p1h7bwp4pcj2g', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(110, 'Adair Figueiredo de souza', '2024-07-07 06:02:54', '35', '2024-06-24 15:22:32', '2024-06-24 16:22:32', 'PAYMENT_RECEIVED', '1', 'sub_kjp5hyconrzvbki2', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(111, 'Helio Felício de oliveira', '2024-07-10 09:06:17', '35', '2024-06-21 07:41:32', '2024-06-21 08:41:32', 'PAYMENT_CONFIRMED', '1', 'sub_d17oty8213pen4mb', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(112, 'Jayro Silva', '2024-07-10 06:07:37', '35', '2024-06-18 03:15:32', '2024-06-18 04:15:32', 'PAYMENT_RECEIVED', '1', 'sub_q6d57pr0rjtnqxl1', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(113, 'Gisete Oliveira de almeida pina ', '2024-07-09 08:55:10', '35', '2024-06-22 10:35:32', '2024-06-22 11:35:32', 'PAYMENT_CONFIRMED', '1', 'sub_khj7qn5qa7jwcwkv', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(114, 'MARCELO PINTO ', '2024-07-07 00:33:13', '35', '2024-05-17 20:12:32', '2024-05-17 21:12:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(115, 'MARIA NILZA BARBOSA DE OLIVEIRA ', '2024-07-10 07:37:12', '35', '2024-05-23 10:46:32', '2024-05-23 11:46:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(116, 'Marluce Maria da Silva veline', '2024-07-10 07:52:13', '35', '2024-05-15 08:19:32', '2024-05-15 09:19:32', 'PAYMENT_RECEIVED', '1', 'sub_we046gyr8tm6ox9i', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(117, 'PAULO RICARDO DE CASTRO', '2024-07-12 05:37:45', '35', '2024-06-07 04:41:32', '2024-06-07 05:41:32', 'PAYMENT_CONFIRMED', '1', 'sub_lmbmse3n20am4map', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(118, 'Lilian Mikalkenas ', '2024-07-06 19:46:03', '35', '2024-05-30 00:33:32', '2024-05-30 01:33:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(119, 'Maria do Carmo Frauso de Jesus', '2024-07-08 22:42:11', '35', '2024-04-15 15:57:32', '2024-04-15 16:57:32', 'PAYMENT_CONFIRMED', '1', 'sub_oqw20usrqyu9ef40', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(120, 'Eneucides De Souza ', '2024-07-08 17:17:32', '35', '2024-05-31 11:55:32', '2024-05-31 12:55:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(121, 'ANA MARIA SOARES DE AMORIM SANTOS', '2024-07-11 07:34:47', '35', '2024-07-09 07:22:32', '2024-07-09 08:22:32', 'PAYMENT_CONFIRMED', '1', 'sub_f8kkc2xwlsaclyjg', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(122, 'MARCIA CRISTIANE DOS SANTOS ', '2024-07-09 07:28:04', '35', '2024-04-28 06:30:32', '2024-04-28 07:30:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(123, 'Elaine Jacob Condr ', '2024-07-06 17:27:53', '35', '2024-05-02 23:00:32', '2024-05-03 00:00:32', 'PAYMENT_CONFIRMED', '1', 'sub_qnwoh68zjlr3urtn', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(124, 'Rafael Wiser', '2024-07-11 08:21:34', '35', '2024-04-29 23:11:32', '2024-04-30 00:11:32', 'PAYMENT_RECEIVED', '1', 'sub_rcdninxdc9633glv', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(125, 'Edileusa Rodrigues campos', '2024-07-06 03:25:06', '35', '2024-04-29 04:24:32', '2024-04-29 05:24:32', 'PAYMENT_CONFIRMED', '1', 'sub_6mz0alzjom5ue7s8', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(126, 'silvia aparecida gomes de oliveira', '2024-07-07 19:33:29', '35', '2024-05-03 01:43:32', '2024-05-03 02:43:32', 'PAYMENT_RECEIVED', '1', 'sub_ak3oll99eahaxk3l', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(127, 'Jandira Da Silva Anibal ', '2024-07-10 03:56:40', '35', '2024-06-04 20:47:32', '2024-06-04 21:47:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(128, 'IVONETe macedo', '2024-07-11 14:12:22', '35', '2024-05-09 03:14:32', '2024-05-09 04:14:32', 'PAYMENT_RECEIVED', '1', 'sub_0k6dtlklk888b1jd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(129, 'Terezinha Oliveira Nascimento', '2024-07-07 20:58:57', '35', '2024-04-28 02:43:32', '2024-04-28 03:43:32', 'PAYMENT_CONFIRMED', '1', 'sub_5nj8umbuw3xyxurb', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(130, 'Maria De Lourdes Lopes Siqueira', '2024-07-09 09:43:19', '35', '2024-07-04 08:34:32', '2024-07-04 09:34:32', 'PAYMENT_RECEIVED', '1', 'sub_5lsseup5bitwlkei', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(131, 'Claudia Maratton Nunes', '2024-07-07 16:52:09', '35', '2024-04-17 06:10:32', '2024-04-17 07:10:32', 'PAYMENT_CONFIRMED', '1', 'sub_2m6jbf3agz348eph', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(132, 'ROGERIO BEZERRA', '2024-07-10 05:46:45', '35', '2024-04-21 17:58:32', '2024-04-21 18:58:32', 'PAYMENT_RECEIVED', '1', 'sub_ysmtbys9tj102s1b', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(133, 'MÔNICA DE FÁTIMA COLANERI', '2024-07-12 18:55:46', '35', '2024-06-06 21:21:32', '2024-06-06 22:21:32', 'PAYMENT_CONFIRMED', '1', 'sub_rpa04ad4a140uizk', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(134, 'Kimi Kanayama Apostolico ', '2024-07-07 10:15:13', '35', '2024-06-23 12:23:32', '2024-06-23 13:23:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(135, 'ELENA PEREIRA DOS SANTOS PERROTA ', '2024-07-11 10:04:50', '35', '2024-06-22 19:07:32', '2024-06-22 20:07:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(136, 'Sandra Barbosa lima', '2024-07-09 07:35:07', '35', '2024-05-23 09:14:32', '2024-05-23 10:14:32', 'PAYMENT_RECEIVED', '1', 'sub_6f8ybkq6yxkqxc6k', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(137, 'Haidee Hele Nice Alencar Lucas ', '2024-07-10 03:29:51', '35', '2024-04-26 17:57:32', '2024-04-26 18:57:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(138, 'Magda Perdigão', '2024-07-09 08:15:26', '35', '2024-07-09 23:48:32', '2024-07-10 00:48:32', 'PAYMENT_RECEIVED', '1', 'sub_huhxxp5i0u3vt052', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(139, 'Lucilia Valeriano gomes', '2024-07-07 20:20:56', '35', '2024-06-09 05:20:32', '2024-06-09 06:20:32', 'PAYMENT_CONFIRMED', '1', 'sub_ix2x58tgqbugm7hl', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(140, 'MARIA MEIRE LIMA FRANCISCO ', '2024-07-09 03:36:09', '35', '2024-06-22 13:55:32', '2024-06-22 14:55:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(141, 'Maria Silva', '2024-07-07 07:10:28', '35', '2024-04-24 08:29:32', '2024-04-24 09:29:32', 'PAYMENT_CONFIRMED', '1', 'sub_b4y1qx2og0hvvhvv', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(142, 'Aparecida Silva Pereira de Oliveira', '2024-07-12 10:14:24', '35', '2024-07-10 22:57:32', '2024-07-10 23:57:32', 'PAYMENT_RECEIVED', '1', 'sub_mc9to97wbk08xqiz', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(143, 'Margarida Pereira Marquini', '2024-07-07 07:24:23', '35', '2024-04-22 01:59:32', '2024-04-22 02:59:32', 'PAYMENT_CONFIRMED', '1', 'sub_lngc4q8k3n8rkr8q', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(144, 'Maria do Carmo Beserra Maia guedes', '2024-07-08 03:11:23', '35', '2024-07-04 10:13:32', '2024-07-04 11:13:32', 'PAYMENT_RECEIVED', '1', 'sub_kni0uie7q2bm1lfu', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(145, 'Maria Claudia Ferreira Da Silva ', '2024-07-12 04:04:57', '35', '2024-04-30 10:01:32', '2024-04-30 11:01:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(146, 'Marilin Cutri dos Santos', '2024-07-08 03:37:49', '35', '2024-05-26 10:36:32', '2024-05-26 11:36:32', 'PAYMENT_RECEIVED', '1', 'sub_u87xns1dfixjgb8y', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(147, 'EDSON MARQUES', '2024-07-07 22:10:47', '35', '2024-04-29 02:32:32', '2024-04-29 03:32:32', 'PAYMENT_CONFIRMED', '1', 'sub_aj9ylacd0yq1zsay', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(148, 'Alair Gomes Bravo', '2024-07-10 11:59:39', '35', '2024-06-16 12:24:32', '2024-06-16 13:24:32', 'PAYMENT_RECEIVED', '1', 'sub_pm1t7g50cfzmggya', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(149, 'Márcia Rodrigues', '2024-07-05 23:38:05', '35', '2024-05-24 19:57:32', '2024-05-24 20:57:32', 'PAYMENT_CONFIRMED', '1', 'sub_mu6frhtcw6978176', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(150, 'DEMETRIO MITEV FILHO ', '2024-07-05 22:38:56', '35', '2024-07-01 08:36:32', '2024-07-01 09:36:32', 'PAYMENT_RECEIVED', '1', 'sub_6iwn6lm49vcbg0ro', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(151, 'Rubens Galvão ', '2024-07-12 02:15:02', '35', '2024-05-19 18:40:32', '2024-05-19 19:40:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(152, 'Maria De Lourdes Fabiani ', '2024-07-07 13:48:47', '35', '2024-06-23 19:52:32', '2024-06-23 20:52:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(153, 'NAIR CORREA AGOSTINHO ', '2024-07-11 18:22:49', '35', '2024-06-07 10:11:32', '2024-06-07 11:11:32', 'PAYMENT_CONFIRMED', '1', 'sub_mb5b4fnb6oxmz4n6', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(154, 'Michel O Domingos ', '2024-07-11 13:28:14', '35', '2024-05-22 22:45:32', '2024-05-22 23:45:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(155, 'Wanderlei Gomes Bravo ', '2024-07-11 04:44:27', '35', '2024-07-09 16:35:32', '2024-07-09 17:35:32', 'PAYMENT_CONFIRMED', '1', 'sub_pm1t7g50cfzmggya', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(156, 'SANDRA APARECIDA BIZ', '2024-07-11 02:41:11', '35', '2024-05-10 07:27:32', '2024-05-10 08:27:32', 'PAYMENT_RECEIVED', '1', 'sub_8mavldglby2dj3t7', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(157, 'SILMARA CIPRIANO LEAL', '2024-07-08 16:49:08', '35', '2024-06-01 14:28:32', '2024-06-01 15:28:32', 'PAYMENT_CONFIRMED', '1', 'sub_liuz8vw48fipbm3c', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(158, 'Rodrigo Maita Ferreira', '2024-07-07 22:22:16', '35', '2024-07-02 08:43:32', '2024-07-02 09:43:32', 'PAYMENT_RECEIVED', '1', 'sub_r6ad51n369qij636', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(159, 'Maria Das graças', '2024-07-09 13:16:29', '35', '2024-06-18 19:48:32', '2024-06-18 20:48:32', 'PAYMENT_CONFIRMED', '1', 'sub_wjvvuxfzb3y6n6up', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(160, 'Simone Regina Laera', '2024-07-08 16:05:23', '35', '2024-06-22 14:46:32', '2024-06-22 15:46:32', 'PAYMENT_RECEIVED', '1', 'sub_62ndkdq8ncaq9qn4', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(161, 'José Eduardo Pico', '2024-07-08 01:11:26', '35', '2024-06-17 20:46:32', '2024-06-17 21:46:32', 'PAYMENT_CONFIRMED', '1', 'sub_nlzfcoc456ujrlst', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(162, 'Shirlei Maria Goreti Da Costa de Oliveira', '2024-07-10 04:16:51', '35', '2024-06-15 13:56:32', '2024-06-15 14:56:32', 'PAYMENT_RECEIVED', '1', 'sub_ipqfzgs26iw6jz33', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(163, 'Francinete Salles de Freitas ', '2024-07-08 14:21:31', '35', '2024-06-12 09:25:32', '2024-06-12 10:25:32', 'PAYMENT_CONFIRMED', '1', 'sub_p4hn53im1qmabur8', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(164, 'SUSANA HELENA FLORENCIO CORREA', '2024-07-06 16:22:43', '35', '2024-06-10 12:08:32', '2024-06-10 13:08:32', 'PAYMENT_RECEIVED', '1', 'sub_tr17jpvzaxj2lhgu', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(165, 'ANGELA REGINA DOS SANTOS ', '2024-07-10 23:08:45', '35', '2024-05-02 10:15:32', '2024-05-02 11:15:32', 'PAYMENT_CONFIRMED', '1', 'sub_aj9ylacd0yq1zsay', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(166, 'Rodrigo Ferrete', '2024-07-09 20:19:48', '35', '2024-05-16 12:29:32', '2024-05-16 13:29:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(167, 'ORLANDA DOMINGUES CARNIELO BOVE ', '2024-07-11 01:05:41', '35', '2024-06-25 00:32:32', '2024-06-25 01:32:32', 'PAYMENT_CONFIRMED', '1', 'sub_mfgsnai4cvprqz5c', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(168, 'BATISTA LARUSSA ', '2024-07-06 13:39:08', '35', '2024-06-25 03:07:32', '2024-06-25 04:07:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(169, 'Joberlita Alves Maciel', '2024-07-09 06:21:22', '35', '2024-06-25 06:03:32', '2024-06-25 07:03:32', 'PAYMENT_CONFIRMED', '1', 'sub_uh3eas49yixypeob', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(170, 'Adriana Batista', '2024-07-07 05:51:00', '35', '2024-05-26 14:13:32', '2024-05-26 15:13:32', 'PAYMENT_RECEIVED', '1', 'sub_0kitcrddljcj2i4i', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(171, 'SILVANA PAULA MITEV', '2024-07-12 11:54:15', '35', '2024-06-05 15:59:32', '2024-06-05 16:59:32', 'PAYMENT_CONFIRMED', '1', 'sub_6iwn6lm49vcbg0ro', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(172, 'PATRICIA TELES GONCALVES', '2024-07-11 07:48:16', '35', '2024-06-08 18:47:32', '2024-06-08 19:47:32', 'PAYMENT_RECEIVED', '1', 'sub_wwi550b0i9up9nxo', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(173, 'Adriana Manganaro', '2024-07-06 18:39:49', '35', '2024-06-28 04:00:32', '2024-06-28 05:00:32', 'PAYMENT_CONFIRMED', '1', 'sub_vgoco8iuna5qfgoy', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(174, 'ROSARIA BUCINO ALUOTTO', '2024-07-08 22:52:19', '35', '2024-05-20 13:32:32', '2024-05-20 14:32:32', 'PAYMENT_RECEIVED', '1', 'sub_pb5l1l1iomkvonef', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(175, 'JORGE ARO MARTINS JUNIOR ', '2024-07-12 18:50:59', '35', '2024-07-09 03:43:32', '2024-07-09 04:43:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(176, 'OSVALDO SANTIAGO PIOTO ', '2024-07-06 23:02:02', '35', '2024-05-18 10:03:32', '2024-05-18 11:03:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(177, 'Celso Guize', '2024-07-06 15:53:27', '35', '2024-07-05 11:10:32', '2024-07-05 12:10:32', 'PAYMENT_CONFIRMED', '1', 'sub_2xamb9miw49pt61k', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(178, 'Cristian Ferreira Passerini', '2024-07-11 01:46:02', '35', '2024-05-26 08:35:32', '2024-05-26 09:35:32', 'PAYMENT_RECEIVED', '1', 'sub_6hr4bodzm1gh3kvy', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(179, 'GERALDA CORREA DOS SANTOS ', '2024-07-08 07:37:23', '35', '2024-05-27 10:25:32', '2024-05-27 11:25:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(180, 'Jose Lucas ', '2024-07-11 13:18:17', '35', '2024-04-18 10:33:32', '2024-04-18 11:33:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(181, 'AZILA RODRIGUES DA SILVA CAVALCANTE ', '2024-07-06 16:35:39', '35', '2024-05-26 06:07:32', '2024-05-26 07:07:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(182, 'Aline Dascenção', '2024-07-10 23:02:07', '35', '2024-06-11 16:05:32', '2024-06-11 17:05:32', 'PAYMENT_RECEIVED', '1', 'sub_ywgico65zvvnys4k', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(183, 'SEBASTIANA CUNHA SANTOS ', '2024-07-09 13:22:22', '35', '2024-06-02 08:47:32', '2024-06-02 09:47:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(184, 'ANA Norberto', '2024-07-12 03:51:23', '35', '2024-05-25 10:24:32', '2024-05-25 11:24:32', 'PAYMENT_RECEIVED', '1', 'sub_5uktt670wkxvu7ys', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(185, 'ROSANGELA Silva doa Santos alves', '2024-07-10 22:37:20', '35', '2024-06-19 09:21:32', '2024-06-19 10:21:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(186, 'Antonia Regina da SIlva ', '2024-07-08 07:54:55', '35', '2024-05-08 04:56:32', '2024-05-08 05:56:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(187, 'José Adriano de Morais ', '2024-07-08 14:38:56', '35', '2024-05-15 12:36:32', '2024-05-15 13:36:32', 'PAYMENT_CONFIRMED', '1', 'sub_0q6wtkw1btqzipya', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(188, 'JOSE PEREIRA', '2024-07-09 07:22:36', '35', '2024-05-08 14:21:32', '2024-05-08 15:21:32', 'PAYMENT_RECEIVED', '1', 'sub_7ubx1is63dq8zl5z', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(189, 'MARIA LUCIA SILVA ZAGNOLE', '2024-07-08 03:36:37', '35', '2024-06-19 12:47:32', '2024-06-19 13:47:32', 'PAYMENT_CONFIRMED', '1', 'sub_ezpxbrz2m95pwjxd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(190, 'Julia Rodrigues da Silva ', '2024-07-07 02:58:51', '35', '2024-06-30 18:37:32', '2024-06-30 19:37:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(191, 'Ivanda Bosquetti Marques ', '2024-07-09 11:30:26', '35', '2024-04-23 06:53:32', '2024-04-23 07:53:32', 'PAYMENT_CONFIRMED', '1', 'sub_qq2pt0a05wmi2n37', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(192, 'Valdomiro Rodrigues da Silva', '2024-07-10 22:58:44', '35', '2024-05-19 00:44:32', '2024-05-19 01:44:32', 'PAYMENT_RECEIVED', '1', 'sub_c75xbqedxuvx7y4z', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(193, 'José Inácio', '2024-07-08 13:50:16', '35', '2024-05-03 06:28:32', '2024-05-03 07:28:32', 'PAYMENT_CONFIRMED', '1', 'sub_jbff31z5k14zl37p', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(194, 'Eliana Ruiz Ramos', '2024-07-11 16:36:07', '35', '2024-06-26 13:44:32', '2024-06-26 14:44:32', 'PAYMENT_RECEIVED', '1', 'sub_8rv24w7ug3o3sx9t', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(195, 'Mesaque Rodrigues', '2024-07-06 08:20:16', '35', '2024-05-17 11:49:32', '2024-05-17 12:49:32', 'PAYMENT_CONFIRMED', '1', 'sub_0ane4xkv0fz2b6hz', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(196, 'Gilvanete Galindo', '2024-07-07 20:34:39', '35', '2024-07-01 01:11:32', '2024-07-01 02:11:32', 'PAYMENT_RECEIVED', '1', 'sub_3hiaduupeumhxym2', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(197, 'Rodrigo De araujo', '2024-07-08 03:34:28', '35', '2024-04-20 00:24:32', '2024-04-20 01:24:32', 'PAYMENT_CONFIRMED', '1', 'sub_im5htks12sb36ucn', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(198, 'Luciana Alves da Silva', '2024-07-11 18:17:22', '35', '2024-04-26 21:12:32', '2024-04-26 22:12:32', 'PAYMENT_RECEIVED', '1', 'sub_0q6wtkw1btqzipya', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(199, 'Creuza Felix De Oliveira de Abreu', '2024-07-08 15:57:20', '35', '2024-07-05 08:50:32', '2024-07-05 09:50:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(200, 'Simone Santos Bento', '2024-07-09 04:58:50', '35', '2024-04-28 05:43:32', '2024-04-28 06:43:32', 'PAYMENT_RECEIVED', '1', 'sub_m6rwvgdyge2gei0s', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(201, 'DANIELA MARRONI ', '2024-07-09 08:16:45', '35', '2024-05-26 00:06:32', '2024-05-26 01:06:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(202, 'Israel Antônio Marquini ', '2024-07-06 05:37:21', '35', '2024-05-13 22:05:32', '2024-05-13 23:05:32', 'PAYMENT_RECEIVED', '1', 'sub_lngc4q8k3n8rkr8q', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(203, 'Maria Betânia Peixoto ', '2024-07-09 09:09:05', '35', '2024-05-13 06:57:32', '2024-05-13 07:57:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(204, 'Eduardo dos Santos Peixoto ', '2024-07-05 20:49:21', '35', '2024-04-29 00:18:32', '2024-04-29 01:18:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(205, 'Paula Torres Duarte Chelegao ', '2024-07-11 18:22:53', '35', '2024-07-01 07:55:32', '2024-07-01 08:55:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(206, 'GENIVALDO SOUZA LIMA', '2024-07-05 20:58:39', '35', '2024-06-17 06:51:32', '2024-06-17 07:51:32', 'PAYMENT_RECEIVED', '1', 'sub_duvg77g5y2sskslc', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(207, 'MARIA DO CARMO DE SOUZA', '2024-07-09 19:34:21', '35', '2024-06-25 10:26:32', '2024-06-25 11:26:32', 'PAYMENT_CONFIRMED', '1', 'sub_8es288c992jjf8d2', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(208, 'CAROL TOGUCHI BARROSO BASS ', '2024-07-06 21:13:35', '35', '2024-06-17 08:59:32', '2024-06-17 09:59:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(209, 'Viviane Silva de Santana', '2024-07-11 04:58:20', '35', '2024-04-21 18:58:32', '2024-04-21 19:58:32', 'PAYMENT_CONFIRMED', '1', 'sub_7snn6yqzehhk5k9d', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(210, 'paulo martins custodio', '2024-07-08 07:45:55', '35', '2024-05-01 13:45:32', '2024-05-01 14:45:32', 'PAYMENT_RECEIVED', '1', 'sub_zy0789iqo5yqdwme', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(211, 'JOEL BOSCO ', '2024-07-07 06:04:33', '35', '2024-06-07 13:56:32', '2024-06-07 14:56:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(212, 'Alcenira Vieira Da Costa ', '2024-07-09 11:04:10', '35', '2024-06-19 01:07:32', '2024-06-19 02:07:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(213, 'Rafael Duin ', '2024-07-07 18:45:40', '35', '2024-07-12 15:05:32', '2024-07-12 16:05:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(214, 'Sueli Jesuino Da Costa Luciano', '2024-07-06 00:38:12', '35', '2024-06-14 16:43:32', '2024-06-14 17:43:32', 'PAYMENT_RECEIVED', '1', 'sub_gb44xh6t17nthfv8', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(215, 'Erik Albert Dourado ', '2024-07-11 08:37:52', '35', '2024-06-19 04:28:32', '2024-06-19 05:28:32', 'PAYMENT_CONFIRMED', '1', 'sub_5ffx2ww9sbo6stmb', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(216, 'LUZELEIDE ALELUIA SILVA', '2024-07-09 15:05:21', '35', '2024-04-25 07:32:32', '2024-04-25 08:32:32', 'PAYMENT_RECEIVED', '1', 'sub_nm0kwkz7m8z14gko', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(217, 'Fabio Bibo ', '2024-07-11 00:10:42', '35', '2024-04-23 07:38:32', '2024-04-23 08:38:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(218, 'Rogéria Thais Augusto', '2024-07-06 05:45:09', '35', '2024-04-13 13:20:32', '2024-04-13 14:20:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(219, 'IVETE SA SOUZA', '2024-07-10 10:33:00', '35', '2024-05-25 16:41:32', '2024-05-25 17:41:32', 'PAYMENT_CONFIRMED', '1', 'sub_vfjsuo86pnlljcny', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(220, 'IVANA REGINA DE MORAES ', '2024-07-08 20:15:13', '35', '2024-05-07 18:09:32', '2024-05-07 19:09:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(221, 'THAISA PAULA MATHIAS', '2024-07-10 01:54:33', '35', '2024-05-12 00:16:32', '2024-05-12 01:16:32', 'PAYMENT_CONFIRMED', '1', 'sub_ckgusfyfxr3bljam', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(222, 'VANI APARECIDA ANDRADE MOREIRA', '2024-07-10 17:17:04', '35', '2024-05-13 16:23:32', '2024-05-13 17:23:32', 'PAYMENT_RECEIVED', '1', 'sub_490h8soatye3thz0', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(223, 'MARIO GOYA ', '2024-07-08 18:47:52', '35', '2024-05-24 14:29:32', '2024-05-24 15:29:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(224, 'Valéria Aparecida Mendes Dias', '2024-07-10 07:58:08', '35', '2024-07-06 06:56:32', '2024-07-06 07:56:32', 'PAYMENT_RECEIVED', '1', 'sub_2a8h80on5iwka5lf', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(225, 'ÍTALO ANTÔNIO PEREIRA VECCHI ', '2024-07-10 09:51:03', '35', '2024-04-28 13:42:32', '2024-04-28 14:42:32', 'PAYMENT_CONFIRMED', '1', 'sub_ct4k636wvp7zt79p', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(226, 'Alan Pereira', '2024-07-09 20:37:55', '35', '2024-06-21 11:29:32', '2024-06-21 12:29:32', 'PAYMENT_RECEIVED', '1', 'sub_rda8fnh3kv16yuvz', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(227, 'Edicarlos Medeiros', '2024-07-09 15:54:32', '35', '2024-05-14 04:50:32', '2024-05-14 05:50:32', 'PAYMENT_CONFIRMED', '1', 'sub_rjohdpx4a0l349up', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(228, 'MARCIA APARECIDA DE LIMA TOFANELLI MORAES', '2024-07-09 18:44:59', '35', '2024-04-23 17:20:32', '2024-04-23 18:20:32', 'PAYMENT_RECEIVED', '1', 'sub_4a22003b0znninyf', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(229, 'FLAVIA CARDOSO ROCHA ', '2024-07-08 04:01:58', '35', '2024-05-08 01:32:32', '2024-05-08 02:32:32', 'PAYMENT_CONFIRMED', '1', 'sub_ky0lapb4zadu4ae0', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(230, 'Rosimari Aparecida Paschoal Lemes ', '2024-07-12 15:48:28', '35', '2024-05-14 03:03:32', '2024-05-14 04:03:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(231, 'RAPHAEL CARLOS DOS REIS ', '2024-07-06 20:09:47', '35', '2024-07-09 05:50:32', '2024-07-09 06:50:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(232, 'Fabio Pereira Dos Santos ', '2024-07-07 16:04:28', '35', '2024-05-16 00:39:32', '2024-05-16 01:39:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(233, 'PRISCILA MAYRA MARCELINO GARCIA ', '2024-07-05 23:39:52', '35', '2024-07-03 22:58:32', '2024-07-03 23:58:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(234, 'FABRICIO GARCIA MARCELINO ', '2024-07-12 18:05:13', '35', '2024-05-28 22:31:32', '2024-05-28 23:31:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(235, 'Jaqueline Pereira dos Santos ', '2024-07-08 14:02:29', '35', '2024-06-12 16:54:32', '2024-06-12 17:54:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(236, 'BRUNO SANTOS PEREIRA ', '2024-07-12 13:13:59', '35', '2024-06-09 06:42:32', '2024-06-09 07:42:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(237, 'Maycon Henrique de Oliveira', '2024-07-06 03:02:20', '35', '2024-04-18 20:31:32', '2024-04-18 21:31:32', 'PAYMENT_CONFIRMED', '1', 'sub_h0ltm4kine6s2bjd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(238, 'Lauri Costa', '2024-07-12 03:27:49', '35', '2024-05-10 08:56:32', '2024-05-10 09:56:32', 'PAYMENT_RECEIVED', '1', 'sub_i3ymhvxxq942izqn', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(239, 'LEONCIO CHARCON', '2024-07-10 07:49:58', '35', '2024-05-05 16:46:32', '2024-05-05 17:46:32', 'PAYMENT_CONFIRMED', '1', 'sub_kpb9b8aaq4jw44gd', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(240, 'DOUGLAS ALVES PEREIRA ', '2024-07-08 10:35:00', '35', '2024-07-04 05:21:32', '2024-07-04 06:21:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(241, 'Ana Cecília Silva de Oliveira', '2024-07-05 23:22:04', '35', '2024-07-05 03:19:32', '2024-07-05 04:19:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(242, 'PATRICIA ANDRADE MOREIRA ', '2024-07-07 05:41:50', '35', '2024-05-08 06:33:32', '2024-05-08 07:33:32', 'PAYMENT_RECEIVED', '1', 'sub_490h8soatye3thz0', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(243, 'JOSE BESERRA DA SILVA', '2024-07-09 11:29:08', '35', '2024-05-25 13:01:32', '2024-05-25 14:01:32', 'PAYMENT_CONFIRMED', '1', 'sub_qcspbjxypag6c6zc', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(244, 'Priscila cruz', '2024-07-07 12:06:17', '35', '2024-04-22 09:36:32', '2024-04-22 10:36:32', 'PAYMENT_RECEIVED', '1', 'sub_en0zr8x4710o3rod', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(245, 'VALQUIRIA APARECIDA DE SANTANA', '2024-07-10 17:43:12', '35', '2024-06-20 05:43:32', '2024-06-20 06:43:32', 'PAYMENT_CONFIRMED', '1', 'sub_nspgf1r52xxrq8xw', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(246, 'MARIA TATIANE DA SILVA ', '2024-07-08 14:14:21', '35', '2024-05-06 08:46:32', '2024-05-06 09:46:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(247, 'Thais F de Oliveira', '2024-07-11 18:00:02', '35', '2024-05-06 05:56:32', '2024-05-06 06:56:32', 'PAYMENT_CONFIRMED', '1', 'sub_tydf4nqyq5z9w25i', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(248, 'FERNANDA ARO ', '2024-07-07 05:28:57', '35', '2024-04-24 02:57:32', '2024-04-24 03:57:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(249, 'WELLINGTON AQUINO RIBEIRO ROSA DE FREITAS', '2024-07-08 14:21:40', '35', '2024-04-14 15:26:32', '2024-04-14 16:26:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(250, 'Rosalia Garbez Gomes', '2024-07-10 06:27:06', '35', '2024-06-22 07:12:32', '2024-06-22 08:12:32', 'PAYMENT_RECEIVED', '1', 'sub_6ptd4eogblia4658', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(251, 'Marcos Souza', '2024-07-11 19:51:39', '35', '2024-06-09 07:11:32', '2024-06-09 08:11:32', 'PAYMENT_CONFIRMED', '1', 'sub_54dopljvohjviif5', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(252, 'TATIANE CRISTINA RODRIGUES PEREIRA ', '2024-07-06 19:09:01', '35', '2024-06-04 05:30:32', '2024-06-04 06:30:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(253, 'IOLANDA DA SILVA PEREIRA', '2024-07-10 08:20:31', '35', '2024-06-01 11:03:32', '2024-06-01 12:03:32', 'PAYMENT_CONFIRMED', '1', 'sub_ct4k636wvp7zt79p', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(254, 'Michelle Custodio Pabst', '2024-07-10 08:32:54', '35', '2024-07-02 15:55:32', '2024-07-02 16:55:32', 'PAYMENT_RECEIVED', '1', 'sub_41c98gaozgj8qttx', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(255, 'Gustavo Daniel Fari', '2024-07-11 12:57:12', '35', '2024-05-14 06:39:32', '2024-05-14 07:39:32', 'PAYMENT_CONFIRMED', '1', 'sub_1k0ahruxelifi2ct', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(256, 'Stefanie Dos Santos Silva Pereira ', '2024-07-08 09:39:58', '35', '2024-04-28 20:57:32', '2024-04-28 21:57:32', 'PAYMENT_RECEIVED', '1', 'sub_fktfpmtjw55ioc7z', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(257, 'Leonardo Teixeira', '2024-07-07 17:28:33', '35', '2024-06-06 07:54:32', '2024-06-06 08:54:32', 'PAYMENT_CONFIRMED', '1', 'sub_jsmdoaz2mt5w2hns', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(258, 'ALEF HERMES JAIME BASS ', '2024-07-12 10:13:46', '35', '2024-06-23 08:43:32', '2024-06-23 09:43:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02');
INSERT INTO `wp_sales` (`id`, `name`, `sale_date`, `sale_amount`, `sale_confirmed`, `sale_received`, `sale_status`, `sale_vendor_id`, `sale_asaas_subscription_id`, `created_at`, `updated_at`) VALUES
(259, 'ALIADHY BASS ', '2024-07-09 21:30:49', '35', '2024-04-27 12:05:32', '2024-04-27 13:05:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(260, 'Juliete Silva', '2024-07-11 03:39:01', '35', '2024-05-09 12:46:32', '2024-05-09 13:46:32', 'PAYMENT_RECEIVED', '1', 'sub_azt9mxatuh90uk1v', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(261, 'Luci Silva Vieira dos Santos', '2024-07-08 22:39:49', '35', '2024-06-06 03:50:32', '2024-06-06 04:50:32', 'PAYMENT_CONFIRMED', '1', 'sub_lwi57fznkb6bb933', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(262, 'Tais Yoshida', '2024-07-09 11:40:03', '35', '2024-06-02 04:44:32', '2024-06-02 05:44:32', 'PAYMENT_RECEIVED', '1', 'sub_4r7l93ao0fduv9sz', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(263, 'Edneia Bernardes da silva', '2024-07-07 03:13:01', '35', '2024-05-17 02:05:32', '2024-05-17 03:05:32', 'PAYMENT_CONFIRMED', '1', 'sub_kob3380m3ps5hu7q', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(264, 'Osvaldo Fortunato', '2024-07-10 16:11:38', '35', '2024-05-25 08:17:32', '2024-05-25 09:17:32', 'PAYMENT_RECEIVED', '1', 'sub_kh4a5o3gdgcgbgu8', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(265, 'darci simoes custodio ', '2024-07-11 01:11:45', '35', '2024-06-28 06:43:32', '2024-06-28 07:43:32', 'PAYMENT_CONFIRMED', '1', 'sub_zy0789iqo5yqdwme', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(266, 'Vitória Vera Brito', '2024-07-08 05:36:48', '35', '2024-04-27 10:17:32', '2024-04-27 11:17:32', 'PAYMENT_RECEIVED', '1', 'sub_0b6y8506tw5w5bcf', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(267, 'Natália Colla Faria ', '2024-07-10 15:53:17', '35', '2024-06-29 04:04:32', '2024-06-29 05:04:32', 'PAYMENT_CONFIRMED', '1', 'sub_1k0ahruxelifi2ct', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(268, 'vitor martinez rueda', '2024-07-12 15:08:28', '35', '2024-07-07 14:32:32', '2024-07-07 15:32:32', 'PAYMENT_RECEIVED', '1', 'sub_l1rwfi45wiqq1r99', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(269, 'Sandra Ao lemos', '2024-07-10 19:23:56', '35', '2024-06-28 12:14:32', '2024-06-28 13:14:32', 'PAYMENT_CONFIRMED', '1', 'sub_y73sjrojb41xwqdg', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(270, 'BEATRIZ GUESSO FONSECA ', '2024-07-12 12:24:33', '35', '2024-07-01 15:08:32', '2024-07-01 16:08:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(271, 'PAULO KENZO IWAI SILVA ', '2024-07-09 06:55:04', '35', '2024-05-11 10:09:32', '2024-05-11 11:09:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(272, 'MARIA SANTINA CARANICOLA', '2024-07-12 15:59:43', '35', '2024-04-20 20:07:32', '2024-04-20 21:07:32', 'PAYMENT_RECEIVED', '1', 'sub_5qgaf70tvsag0mjz', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(273, 'CAMILA SILVA AMORIM SANTOS', '2024-07-09 08:17:11', '35', '2024-05-10 11:00:32', '2024-05-10 12:00:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(274, 'Aline Favila', '2024-07-12 10:00:12', '35', '2024-06-09 01:28:32', '2024-06-09 02:28:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(275, 'Samir Fabiani Martins ', '2024-07-10 12:36:08', '35', '2024-07-04 14:29:32', '2024-07-04 15:29:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(276, 'JESSICA LINDISAY FERRER AGUILAR IWAI ', '2024-07-08 12:11:57', '35', '2024-05-01 11:49:32', '2024-05-01 12:49:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:02'),
(277, 'GUSTAVO ROSA', '2024-07-09 08:41:48', '35', '2024-05-04 12:54:32', '2024-05-04 13:54:32', 'PAYMENT_CONFIRMED', '1', 'sub_r2b9wugq6q4qdbvb', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(278, 'Nadir Aparecida De Lima Garcia ', '2024-07-08 02:39:02', '35', '2024-06-07 15:14:32', '2024-06-07 16:14:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(279, 'CAIO DA COSTA ', '2024-07-06 22:19:55', '35', '2024-06-22 23:16:32', '2024-06-23 00:16:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(280, 'Otavio Monteiro De Araujo ', '2024-07-08 03:36:19', '35', '2024-05-29 04:08:32', '2024-05-29 05:08:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(281, 'Merilyn santana de oliveira ', '2024-07-07 03:44:03', '35', '2024-07-08 05:55:32', '2024-07-08 06:55:32', 'PAYMENT_CONFIRMED', '1', 'sub_we046gyr8tm6ox9i', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(282, 'CARLOS FELIPE CAVALCANTE GONÇALVES MATIAS ', '2024-07-07 10:52:22', '35', '2024-05-19 21:46:32', '2024-05-19 22:46:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(283, 'THALES MARTINS ', '2024-07-12 05:40:04', '35', '2024-06-08 01:05:32', '2024-06-08 02:05:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(284, 'GABRIELA BARROSO PERES FERREIRA ', '2024-07-11 12:51:50', '35', '2024-05-08 18:41:32', '2024-05-08 19:41:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(285, 'Ana Beatriz Silva Lacerda', '2024-07-11 17:39:36', '35', '2024-04-26 19:38:32', '2024-04-26 20:38:32', 'PAYMENT_CONFIRMED', '1', 'sub_h152stsywd5y23it', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(286, 'BIANCA CAVALCANTE GONÇALVES MATIAS ', '2024-07-07 10:13:38', '35', '2024-04-25 11:28:32', '2024-04-25 12:28:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(287, 'MARIA EDUARDA VOLTOLINI DOMINGOS ', '2024-07-06 21:12:25', '35', '2024-04-24 00:29:32', '2024-04-24 01:29:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(288, 'Leonardo Manganaro', '2024-07-07 10:52:15', '35', '2024-06-13 09:54:32', '2024-06-13 10:54:32', 'PAYMENT_RECEIVED', '1', 'sub_f31g9727xw4ann54', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(289, 'Mariah Eduarda Manganaro ', '2024-07-08 11:28:32', '35', '2024-07-08 10:31:32', '2024-07-08 11:31:32', 'PAYMENT_CONFIRMED', '1', 'sub_vgoco8iuna5qfgoy', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(290, 'Sabrina Alves de Morais ', '2024-07-11 14:08:45', '35', '2024-06-16 05:29:32', '2024-06-16 06:29:32', 'PAYMENT_RECEIVED', '1', 'sub_0q6wtkw1btqzipya', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(291, 'MARIO FRANCISCO BARBOZA', '2024-07-10 01:02:17', '35', '2024-06-20 15:23:32', '2024-06-20 16:23:32', 'PAYMENT_CONFIRMED', '1', 'sub_sip8gxrpbminmztp', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(292, 'Andrew veline ', '2024-07-09 23:16:29', '35', '2024-04-13 23:29:32', '2024-04-14 00:29:32', 'PAYMENT_RECEIVED', '1', 'sub_we046gyr8tm6ox9i', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(293, 'Sebastiana Forato Luciano', '2024-07-10 08:18:03', '35', '2024-06-25 09:22:32', '2024-06-25 10:22:32', 'PAYMENT_CONFIRMED', '1', 'sub_txm66pnuy12lncwk', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(294, 'monique gomes', '2024-07-09 08:56:38', '35', '2024-06-16 16:33:32', '2024-06-16 17:33:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(295, 'GABRIEL PAULA MITEV ', '2024-07-11 04:02:17', '35', '2024-05-22 02:23:32', '2024-05-22 03:23:32', 'PAYMENT_CONFIRMED', '1', 'sub_6iwn6lm49vcbg0ro', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(296, 'Viniicius Silva', '2024-07-10 00:25:05', '35', '2024-05-30 00:21:32', '2024-05-30 01:21:32', 'PAYMENT_RECEIVED', '1', 'sub_ynqoygytv8sc7ngp', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(297, 'Maria Luiza Kobayashi ', '2024-07-12 08:18:08', '35', '2024-05-04 01:19:32', '2024-05-04 02:19:32', 'PAYMENT_CONFIRMED', '1', 'sub_8mavldglby2dj3t7', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(298, 'Bianca Santana ', '2024-07-05 21:06:44', '35', '2024-06-11 18:02:32', '2024-06-11 19:02:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(299, 'VITORIA CAROLINE SANTOS VALERIO', '2024-07-10 01:11:26', '35', '2024-05-08 02:40:32', '2024-05-08 03:40:32', 'PAYMENT_CONFIRMED', '1', 'sub_367qdmb3s96oabc2', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(300, 'Beatriz Vieira', '2024-07-11 00:02:23', '35', '2024-04-14 04:50:32', '2024-04-14 05:50:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(301, 'MARIA LUIZA MARIN ', '2024-07-09 16:23:54', '35', '2024-04-15 22:56:32', '2024-04-15 23:56:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(302, 'Giulia Gualtieri Zancan', '2024-07-08 00:04:58', '35', '2024-07-12 17:47:32', '2024-07-12 18:47:32', 'PAYMENT_RECEIVED', '1', 'sub_zxyeq5h9zhrvv5oy', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(303, 'NICOLAS ALEXANDRE SANTOS DE SOUZA ', '2024-07-08 15:29:28', '35', '2024-05-31 14:56:32', '2024-05-31 15:56:32', 'PAYMENT_CONFIRMED', '1', 'sub_8es288c992jjf8d2', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(304, 'Giovanna Fernandes Cestari ', '2024-07-07 02:16:24', '35', '2024-05-31 22:59:32', '2024-05-31 23:59:32', 'PAYMENT_RECEIVED', '1', 'sub_3xmqwogji6wb1yuv', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(305, 'MARIA ANTONIA DE ANDRADE', '2024-07-12 08:20:55', '35', '2024-07-04 09:03:32', '2024-07-04 10:03:32', 'PAYMENT_CONFIRMED', '1', 'sub_szzb9wd2cv2zektg', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(306, 'João Pedro Estevão do Couto', '2024-07-07 06:00:26', '35', '2024-04-23 19:37:32', '2024-04-23 20:37:32', 'PAYMENT_RECEIVED', '1', 'sub_yq39yske24dulnen', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(307, 'Vinicius Bovi Fernandes', '2024-07-07 14:54:47', '35', '2024-07-03 17:57:32', '2024-07-03 18:57:32', 'PAYMENT_CONFIRMED', '1', 'sub_00qb9g1493iv5hwb', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(308, 'João Victor Ramos Gandini ', '2024-07-09 08:07:07', '35', '2024-06-02 11:13:32', '2024-06-02 12:13:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(309, 'Camily Santos Ferreira ', '2024-07-11 18:23:01', '35', '2024-05-08 05:47:32', '2024-05-08 06:47:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(310, 'Livia soberana da silva fernandes ', '2024-07-09 07:05:43', '35', '2024-06-25 03:09:32', '2024-06-25 04:09:32', 'PAYMENT_RECEIVED', '1', 'sub_azt9mxatuh90uk1v', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(311, 'MANUELLA RODRIGUES PEREIRA ', '2024-07-10 13:09:05', '35', '2024-06-28 21:33:32', '2024-06-28 22:33:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(312, 'LORENZO RODRIGUES PEREIRA ', '2024-07-06 19:49:37', '35', '2024-07-12 00:29:32', '2024-07-12 01:29:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(313, 'DAVI MARCELINO GARCIA ', '2024-07-10 23:02:39', '35', '2024-06-29 06:24:32', '2024-06-29 07:24:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(314, 'ASHIRA TOGUCHI BASS ', '2024-07-11 03:16:16', '35', '2024-06-27 00:28:32', '2024-06-27 01:28:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(315, 'Davi Fernandes Silva', '2024-07-12 10:49:15', '35', '2024-05-28 07:16:32', '2024-05-28 08:16:32', 'PAYMENT_CONFIRMED', '1', 'sub_9up9tlzp0e8ajdv0', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(316, 'JOSE INACIO DA SILVA ', '2024-07-06 08:49:38', '35', '2024-06-29 04:42:32', '2024-06-29 05:42:32', 'PAYMENT_RECEIVED', '1', 'sub_nm0kwkz7m8z14gko', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(317, 'ADELINO ALVES ROCHA', '2024-07-06 19:09:25', '35', '2024-07-07 17:52:32', '2024-07-07 18:52:32', 'PAYMENT_CONFIRMED', '1', 'sub_ky0lapb4zadu4ae0', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(318, 'Geovanna victória da silva fernandes ', '2024-07-09 22:14:42', '35', '2024-04-17 23:18:32', '2024-04-18 00:18:32', 'PAYMENT_RECEIVED', '1', 'sub_azt9mxatuh90uk1v', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(319, 'CHLOE AKEMI FERRER AGUILAR IWAI ', '2024-07-08 13:27:45', '35', '2024-05-30 21:32:32', '2024-05-30 22:32:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(320, 'Rebeca Ernesto Marques', '2024-07-12 05:15:22', '35', '2024-06-03 10:02:32', '2024-06-03 11:02:32', 'PAYMENT_RECEIVED', '1', 'sub_vis05jhyaasp2wns', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(321, 'Noemia Maria da Silva Franco', '2024-07-09 03:22:49', '35', '2024-05-02 12:02:32', '2024-05-02 13:02:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(322, 'Carlos Augusto Ulian ', '2024-07-09 13:57:28', '35', '2024-04-29 11:32:32', '2024-04-29 12:32:32', 'PAYMENT_RECEIVED', '1', 'sub_0t4xho6k9aubucb3', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(323, 'Antônio Mendes', '2024-07-08 13:20:45', '35', '2024-05-22 07:23:32', '2024-05-22 08:23:32', 'PAYMENT_CONFIRMED', '1', 'sub_2jdblvdxy2sylogt', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(324, 'LORENZO AZEVEDO ARO MARTINS ', '2024-07-12 05:11:30', '35', '2024-07-05 14:12:32', '2024-07-05 15:12:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(325, 'WILSON GONCALVES MARCELINO ', '2024-07-12 08:06:35', '35', '2024-05-29 10:32:32', '2024-05-29 11:32:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(326, 'Heloysa Santos Ferreira ', '2024-07-12 17:33:06', '35', '2024-06-03 18:47:32', '2024-06-03 19:47:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(327, 'JOAQUIM PEREIRA DA SILVA', '2024-07-06 10:37:10', '35', '2024-06-01 06:20:32', '2024-06-01 07:20:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(328, 'Edmilson Pereira ', '2024-07-10 23:06:05', '35', '2024-06-22 03:42:32', '2024-06-22 04:42:32', 'PAYMENT_RECEIVED', '1', 'sub_l9bbry54hm3uskzg', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(329, 'Fabricio pina vilela ', '2024-07-08 08:10:19', '35', '2024-05-06 02:31:32', '2024-05-06 03:31:32', 'PAYMENT_CONFIRMED', '1', 'sub_khj7qn5qa7jwcwkv', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(330, 'ROSELI ARAUJO DE SOUZA SILVA ', '2024-07-12 14:58:10', '35', '2024-06-15 18:53:32', '2024-06-15 19:53:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(331, 'Roseli Araújo de Souza Silva ', '2024-07-08 04:03:02', '35', '2024-06-11 11:36:32', '2024-06-11 12:36:32', 'PAYMENT_CONFIRMED', '1', 'sub_q8d5iq7yhw0tslu3', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(332, 'Alessandra Alves de melo', '2024-07-09 05:51:15', '35', '2024-06-09 18:34:32', '2024-06-09 19:34:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(333, 'Maria de Lourdes Toninatto', '2024-07-09 23:20:18', '35', '2024-06-19 21:04:32', '2024-06-19 22:04:32', 'PAYMENT_CONFIRMED', '1', 'sub_rb0nz1j8t1bi5a5v', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(334, 'Edvaldo Santos Souza', '2024-07-12 07:01:56', '35', '2024-05-21 11:53:32', '2024-05-21 12:53:32', 'PAYMENT_RECEIVED', '1', 'sub_wpw8cyi2kp00wf13', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(335, 'IRINEU GASPAR', '2024-07-08 13:55:51', '35', '2024-06-15 05:07:32', '2024-06-15 06:07:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(336, 'ROSINALVA FERREIRA JOSE ', '2024-07-12 12:14:50', '35', '2024-05-28 14:36:32', '2024-05-28 15:36:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(337, 'Gilberto De Souza Santos ', '2024-07-06 12:43:22', '35', '2024-05-27 11:11:32', '2024-05-27 12:11:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(338, 'ANTONIA LUIZA RODRIGUES ', '2024-07-11 18:08:49', '35', '2024-06-28 08:19:32', '2024-06-28 09:19:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(339, 'Teresa Pavani Torrieri ', '2024-07-07 05:09:24', '35', '2024-05-08 11:15:32', '2024-05-08 12:15:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(340, 'FLAVIO MARTINS ', '2024-07-12 09:26:26', '35', '2024-05-06 22:15:32', '2024-05-06 23:15:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(341, 'Mailton Marcos Zagnole', '2024-07-12 14:40:39', '35', '2024-06-20 14:35:32', '2024-06-20 15:35:32', 'PAYMENT_CONFIRMED', '1', 'sub_0jxc0rasipcatk61', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(342, 'Wagner Carvalho Garcia ', '2024-07-09 08:04:56', '35', '2024-06-02 09:45:32', '2024-06-02 10:45:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(343, 'Cristiane Oliveira', '2024-07-09 08:36:56', '35', '2024-05-18 02:44:32', '2024-05-18 03:44:32', 'PAYMENT_CONFIRMED', '1', 'sub_ukt9mchn3ly5euog', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(344, 'Rosmaria Fusco ', '2024-07-06 21:22:15', '35', '2024-04-28 10:18:32', '2024-04-28 11:18:32', 'PAYMENT_RECEIVED', '1', 'sub_0k6dtlklk888b1jd', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(345, 'MARLENE JOSEFA DOS SANTOS', '2024-07-10 21:15:48', '35', '2024-05-05 08:20:32', '2024-05-05 09:20:32', 'PAYMENT_CONFIRMED', '1', 'sub_5gwhs93r85grs4kd', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(346, 'MARCOS LEMOS DA SILVA ', '2024-07-05 20:38:25', '35', '2024-06-11 15:19:32', '2024-06-11 16:19:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(347, 'Marilda Alves', '2024-07-12 17:11:11', '35', '2024-04-23 00:24:32', '2024-04-23 01:24:32', 'PAYMENT_CONFIRMED', '1', 'sub_2fkv00bf8a9rgrrp', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(348, 'CESAR DA CONCEIÇÃO RODRIGUES ', '2024-07-11 01:35:52', '35', '2024-04-15 12:07:32', '2024-04-15 13:07:32', 'PAYMENT_RECEIVED', '1', 'sub_lazc1z1j6re2f3rz', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(349, 'Jose Cavalari Lemes ', '2024-07-08 16:31:07', '35', '2024-05-11 11:37:32', '2024-05-11 12:37:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(350, 'Walter Ulian ', '2024-07-06 18:22:15', '35', '2024-05-07 14:57:32', '2024-05-07 15:57:32', 'PAYMENT_RECEIVED', '1', 'sub_0t4xho6k9aubucb3', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(351, 'Ricardo Ribeiro', '2024-07-11 00:28:27', '35', '2024-04-18 22:18:32', '2024-04-18 23:18:32', 'PAYMENT_CONFIRMED', '1', 'sub_onx4wdi8hl3ctro0', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(352, 'Francisco Bento Sousa', '2024-07-07 20:36:07', '35', '2024-05-19 21:14:32', '2024-05-19 22:14:32', 'PAYMENT_RECEIVED', '1', 'sub_qe9vd7a477jp16q7', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(353, 'MARIO YUKIYA UEMA ', '2024-07-11 13:52:02', '35', '2024-04-21 23:58:32', '2024-04-22 00:58:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(354, 'Antonio Lourival Pereira Portoira ', '2024-07-06 21:19:17', '35', '2024-06-09 10:53:32', '2024-06-09 11:53:32', 'PAYMENT_RECEIVED', '1', 'sub_8cg99uqvar1m8qon', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(355, 'BRUNA LIMA', '2024-07-11 15:45:11', '35', '2024-06-30 20:07:32', '2024-06-30 21:07:32', 'PAYMENT_CONFIRMED', '1', 'sub_0h739e6qmv6k2jr6', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(356, 'Zilda Nascimento', '2024-07-17 11:20:37', '35.35', '2024-04-20 09:10:32', '2024-04-20 10:10:32', 'PAYMENT_RECEIVED', '1', 'sub_apiol2fps9rbhex8', '2024-07-11 19:59:22', '2024-07-17 09:39:20'),
(357, 'SILVANDIRA BOM BIBO ', '2024-07-16 06:55:42', '35.35', '2024-05-17 21:12:32', '2024-05-17 22:12:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-17 09:39:32'),
(358, 'Marcia Helena Batista De Moraes Pereira', '2024-07-16 06:55:42', '35', '2024-06-23 14:18:32', '2024-06-23 15:18:32', 'PAYMENT_RECEIVED', '1', 'sub_l9bbry54hm3uskzg', '2024-07-11 19:59:22', '2024-07-17 09:39:34'),
(359, 'Roseli Porto', '2024-07-16 06:55:42', '35', '2024-05-12 22:56:32', '2024-05-12 23:56:32', 'PAYMENT_CONFIRMED', '1', 'sub_8cg99uqvar1m8qon', '2024-07-11 19:59:22', '2024-07-17 09:39:36'),
(360, 'EDSON BIBO ', '2024-07-16 06:55:42', '35', '2024-05-02 06:59:32', '2024-05-02 07:59:32', 'PAYMENT_RECEIVED', '1', '', '2024-07-11 19:59:22', '2024-07-17 09:39:37'),
(361, 'Marcos Reale ', '2024-07-16 06:55:42', '35', '2024-04-23 10:20:32', '2024-04-23 11:20:32', 'PAYMENT_CONFIRMED', '1', '', '2024-07-11 19:59:22', '2024-07-17 09:39:39'),
(362, 'Luiz Carlos Lopes', '2024-07-16 06:55:42', '35', '2024-06-30 02:47:32', '2024-06-30 03:47:32', 'PAYMENT_RECEIVED', '1', 'sub_ml8d7d4k7fqd5e4j', '2024-07-11 19:59:22', '2024-07-17 09:39:42'),
(363, 'Carlos Matana Mendes', '2024-07-16 06:55:42', '35', '2024-06-08 10:19:32', '2024-06-08 11:19:32', 'PAYMENT_CONFIRMED', '1', 'sub_dtg3h98zhql0mn13', '2024-07-11 19:59:22', '2024-07-17 09:39:46'),
(364, 'ROBSON PERGOLI ', '2024-07-12 01:26:43', '35', '2024-05-27 16:29:32', '2024-05-27 17:29:32', 'PAYMENT_RECEIVED', '1', 'sub_uqhas6agscfzudcf', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(365, 'ANTONIO SOARES DA SILVA', '2024-07-09 22:32:16', '35', '2024-05-24 23:49:32', '2024-05-25 00:49:32', 'PAYMENT_CONFIRMED', '1', 'sub_uovtw2uwfhv0ep5v', '2024-07-11 19:59:22', '2024-07-12 17:27:03'),
(383, '', '2024-07-18 16:14:24', '35', '', '', 'ativa', '2', 'sub_m2hba7bx547kpxvm', '2024-07-18 16:14:24', '2024-07-18 16:14:24'),
(393, '', '2024-07-19 17:53:19', '35', '', '', 'ativa', '2', 'sub_9wcwmpn6phwo3qdp', '2024-07-19 17:53:19', '2024-07-19 17:53:19'),
(394, '', '2024-07-22 20:53:57', '35', '', '', 'ativa', '1', 'sub_k5m7hrsuuadubd59', '2024-07-22 20:53:57', '2024-07-22 20:53:57'),
(395, '', '2024-07-22 21:01:06', '35', '', '', 'ativa', '1', 'sub_bjyf6jp6zmo3twwq', '2024-07-22 21:01:06', '2024-07-22 21:01:06'),
(396, '', '2024-07-22 21:05:35', '35', '', '', 'ativa', '1', 'sub_q6y3y0c7gcttq0mm', '2024-07-22 21:05:35', '2024-07-22 21:05:35'),
(397, '', '2024-07-22 21:13:15', '35', '', '', 'ativa', '', 'sub_hhqljl4fylidyu3p', '2024-07-22 21:13:15', '2024-07-22 21:13:15'),
(398, '', '2024-07-24 19:36:45', '35', '', '', 'ativa', '1', 'sub_5pn51r2gvfh1466f', '2024-07-24 19:36:45', '2024-07-24 19:36:45'),
(399, '', '2024-07-24 19:40:38', '135', '', '', 'ativa', '1', 'sub_s9mdhee4y0bss2bc', '2024-07-24 19:40:38', '2024-07-24 19:40:38'),
(400, '', '2024-08-01 15:11:21', '135', '', '', 'ativa', '1', 'sub_fzjq2myhqy97mtjt', '2024-08-01 15:11:21', '2024-08-01 15:11:21'),
(401, '', '2024-08-09 19:48:44', '39.9', '', '', 'ativa', NULL, 'sub_fvcibqt8qogeus28', '2024-08-09 19:48:44', '2024-08-09 19:48:44'),
(402, '', '2024-08-09 19:49:48', '39.9', '', '', 'ativa', NULL, 'sub_9r99sxs95d4u6prt', '2024-08-09 19:49:48', '2024-08-09 19:49:48'),
(403, '', '2024-08-12 18:54:19', '39.9', '', '', 'ativa', NULL, 'sub_okfyy159okr7i7lq', '2024-08-12 18:54:19', '2024-08-12 18:54:19'),
(404, '', '2024-08-12 18:57:00', '89.9', '', '', 'ativa', NULL, 'sub_lj3ck9e87zlaxcu3', '2024-08-12 18:57:00', '2024-08-12 18:57:00'),
(405, '', '2024-08-12 19:11:59', '73.815', '', '', 'ativa', NULL, 'sub_0bzgzqp4st5qw8un', '2024-08-12 19:11:59', '2024-08-12 19:11:59'),
(406, '', '2024-08-13 15:38:47', '107.73', '', '', 'ativa', '1', 'sub_g86efgmhcah8k9sy', '2024-08-13 15:38:47', '2024-08-13 15:38:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_termmeta`
--

CREATE TABLE `wp_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_terms`
--

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Sem categoria', 'sem-categoria', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_term_relationships`
--

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_term_taxonomy`
--

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_usermeta`
--

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'douglas'),
(2, 1, 'first_name', 'Douglas'),
(3, 1, 'last_name', 'Salvagni'),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'wp_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', ''),
(15, 1, 'show_welcome_panel', '1'),
(16, 1, 'session_tokens', 'a:1:{s:64:\"287c64c7cfb0c3957ef04959ca270cadead08533fcbc3d4bfe72681a0b246822\";a:4:{s:10:\"expiration\";i:1723643038;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36\";s:5:\"login\";i:1723470238;}}'),
(17, 1, 'wp_dashboard_quick_press_last_post_id', '620'),
(18, 1, 'meta-box-order_leads', 'a:3:{s:4:\"side\";s:9:\"submitdiv\";s:6:\"normal\";s:38:\"lead_extra_meta,slugdiv,lead_user_meta\";s:8:\"advanced\";s:0:\"\";}'),
(19, 1, 'screen_layout_leads', '2'),
(20, 1, 'closedpostboxes_page', 'a:0:{}'),
(21, 1, 'metaboxhidden_page', 'a:4:{i:0;s:10:\"postcustom\";i:1;s:16:\"commentstatusdiv\";i:2;s:11:\"commentsdiv\";i:3;s:9:\"authordiv\";}'),
(22, 1, 'phone_number', '(55) 5555-444'),
(23, 1, 'wallet_id', ''),
(24, 2, 'nickname', 'Tonho'),
(25, 2, 'first_name', 'Tonho'),
(26, 2, 'last_name', ''),
(27, 2, 'description', ''),
(28, 2, 'rich_editing', 'true'),
(29, 2, 'syntax_highlighting', 'true'),
(30, 2, 'comment_shortcuts', 'false'),
(31, 2, 'admin_color', 'fresh'),
(32, 2, 'use_ssl', '0'),
(33, 2, 'show_admin_bar_front', 'true'),
(34, 2, 'locale', ''),
(35, 2, 'wp_capabilities', 'a:1:{s:9:\"comercial\";b:1;}'),
(36, 2, 'wp_user_level', '0'),
(37, 2, 'dismissed_wp_pointers', ''),
(38, 2, 'session_tokens', 'a:1:{s:64:\"78c8e2ab3b2e87a865103d9d2c17569c267d22271fd12d8fc2dade7d1361be85\";a:4:{s:10:\"expiration\";i:1722792496;s:2:\"ip\";s:3:\"::1\";s:2:\"ua\";s:111:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36\";s:5:\"login\";i:1722619696;}}'),
(39, 2, 'wp_user-settings', 'mfold=o'),
(40, 2, 'wp_user-settings-time', '1720811480'),
(47, 2, 'phone_number', ''),
(48, 2, 'wallet_id', ''),
(49, 1, 'profile_image', '621');

-- --------------------------------------------------------

--
-- Estrutura da tabela `wp_users`
--

CREATE TABLE `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(255) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Extraindo dados da tabela `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'douglas', '$P$BFMEm7IiGdhzN3ruasERPyONuNc6nQ1', 'douglas', 'douglassalvagni@gmail.com', 'http://localhost/crm', '2024-07-03 19:02:50', '', 0, 'douglas'),
(2, 'Tonho', '$P$BXSS67/OwmFo2OWxZ.HArWZQXxFl6z.', 'tonho', 'tonho@gmail.com', '', '2024-07-12 19:09:42', '', 0, 'Tonho');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `wp_assinantes`
--
ALTER TABLE `wp_assinantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf_cnpj_unique` (`cpf_cnpj`);

--
-- Índices para tabela `wp_assinantes_archived`
--
ALTER TABLE `wp_assinantes_archived`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `wp_checkout_links`
--
ALTER TABLE `wp_checkout_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Índices para tabela `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Índices para tabela `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Índices para tabela `wp_leads_archived`
--
ALTER TABLE `wp_leads_archived`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `wp_links`
--
ALTER TABLE `wp_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Índices para tabela `wp_notifications`
--
ALTER TABLE `wp_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `wp_notifications_archived`
--
ALTER TABLE `wp_notifications_archived`
  ADD PRIMARY KEY (`id`),
  ADD KEY `original_id` (`original_id`);

--
-- Índices para tabela `wp_options`
--
ALTER TABLE `wp_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Índices para tabela `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Índices para tabela `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191)),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`);

--
-- Índices para tabela `wp_sales`
--
ALTER TABLE `wp_sales`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Índices para tabela `wp_terms`
--
ALTER TABLE `wp_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Índices para tabela `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Índices para tabela `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Índices para tabela `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Índices para tabela `wp_users`
--
ALTER TABLE `wp_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `wp_assinantes`
--
ALTER TABLE `wp_assinantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=565;

--
-- AUTO_INCREMENT de tabela `wp_assinantes_archived`
--
ALTER TABLE `wp_assinantes_archived`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=563;

--
-- AUTO_INCREMENT de tabela `wp_checkout_links`
--
ALTER TABLE `wp_checkout_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `wp_comments`
--
ALTER TABLE `wp_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `wp_leads_archived`
--
ALTER TABLE `wp_leads_archived`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `wp_links`
--
ALTER TABLE `wp_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `wp_notifications`
--
ALTER TABLE `wp_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `wp_notifications_archived`
--
ALTER TABLE `wp_notifications_archived`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `wp_options`
--
ALTER TABLE `wp_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4568;

--
-- AUTO_INCREMENT de tabela `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10421;

--
-- AUTO_INCREMENT de tabela `wp_posts`
--
ALTER TABLE `wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;

--
-- AUTO_INCREMENT de tabela `wp_sales`
--
ALTER TABLE `wp_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=407;

--
-- AUTO_INCREMENT de tabela `wp_termmeta`
--
ALTER TABLE `wp_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `wp_terms`
--
ALTER TABLE `wp_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `wp_users`
--
ALTER TABLE `wp_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
