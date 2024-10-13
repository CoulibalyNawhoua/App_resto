-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 28 juil. 2023 à 22:04
-- Version du serveur : 8.0.33-0ubuntu0.22.04.2
-- Version de PHP : 8.1.2-1ubuntu2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_dipndip`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`softexpertise`@`localhost` PROCEDURE `getOrderItems` ()  BEGIN

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `actions_stocks`
--

CREATE TABLE `actions_stocks` (
  `id` int NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` varchar(16) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `actions_stocks`
--

INSERT INTO `actions_stocks` (`id`, `libelle`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Actions qui augmentent le stock', 'STOCK_INCREASE', '2023-07-13 10:07:01.000000', '2023-07-13 10:07:01.000000'),
(2, 'Actions qui réduisent le stock', 'STOCK_REDUCE', '2023-07-13 10:07:01.000000', '2023-07-13 10:07:01.000000');

-- --------------------------------------------------------

--
-- Structure de la table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'created', 'App\\Models\\User', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\": {\"id\": 7, \"name\": \"admin admin\", \"email\": \"admin@mail.com\", \"active\": 1, \"password\": \"$2y$10$zlAgdUWrJksylYitxoH2aOLe9cXV9YBEoNh0q0GJ0fa5uQfELSJY6\", \"api_token\": null, \"entite_id\": null, \"last_name\": \"admin\", \"created_at\": \"2023-07-28T22:03:08.000000Z\", \"first_name\": \"admin\", \"updated_at\": \"2023-07-28T22:03:08.000000Z\", \"remember_token\": null, \"email_verified_at\": null}}', NULL, '2023-07-28 22:03:08', '2023-07-28 22:03:08');

-- --------------------------------------------------------

--
-- Structure de la table `ajustements_products`
--

CREATE TABLE `ajustements_products` (
  `id` int NOT NULL,
  `before_quantity` float DEFAULT '0',
  `after_quantity` float DEFAULT '0',
  `produit_id` int DEFAULT NULL,
  `quantity` float DEFAULT '0',
  `operation_id` int DEFAULT NULL,
  `gap` float DEFAULT '0',
  `product_unit_id` int DEFAULT NULL,
  `product_unit_quantity` float DEFAULT '0',
  `entite_id` int DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `deleted_by` int DEFAULT NULL,
  `delete_ip` varchar(16) DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nom_categorie` varchar(45) NOT NULL,
  `sous_famille_id` int DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `code_categorie` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom_categorie`, `sous_famille_id`, `created_at`, `updated_at`, `add_date`, `added_by`, `add_ip`, `edited_by`, `edit_date`, `edit_ip`, `is_deleted`, `delete_ip`, `deleted_by`, `delete_date`, `code_categorie`) VALUES
(1, 'Produit semi finis', NULL, '2023-06-01 09:29:06.000000', '2023-07-07 10:11:46.000000', '2023-06-01 09:29:06.731466', 1, '127.0.0.1', 1, '2023-07-07 10:11:46', '127.0.0.1', 0, NULL, NULL, NULL, '002'),
(3, 'Matière première', NULL, '2023-06-11 11:47:12.000000', '2023-07-07 10:11:51.000000', '2023-06-11 11:47:12.387204', 1, '127.0.0.1', 1, '2023-07-07 10:11:51', '127.0.0.1', 0, NULL, NULL, NULL, '001'),
(4, 'Produit finis', NULL, '2023-06-11 11:47:36.000000', '2023-07-07 10:11:56.000000', '2023-06-11 11:47:36.620820', 1, '127.0.0.1', 1, '2023-07-07 10:11:56', '127.0.0.1', 0, NULL, NULL, NULL, '003');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int NOT NULL,
  `nom` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT NULL,
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `agences_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `delivery`
--

CREATE TABLE `delivery` (
  `id` int NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `delivery_status` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `delivery_confirm_by` int DEFAULT NULL,
  `delivery_confirm_date` datetime DEFAULT NULL,
  `delivery_confirm_note` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `commentaire` text,
  `entite_id` int DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime(6) DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `deleted_by` int DEFAULT NULL,
  `delete_ip` varchar(16) DEFAULT NULL,
  `delete_date` datetime(6) DEFAULT NULL,
  `preparation_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `delivery_products`
--

CREATE TABLE `delivery_products` (
  `id` int NOT NULL,
  `produit_id` int DEFAULT NULL,
  `delivery_id` int DEFAULT NULL,
  `quantity_delivered` float NOT NULL DEFAULT '0',
  `product_unit_id` int DEFAULT NULL,
  `product_unit_quantity` float NOT NULL DEFAULT '0',
  `order_quantity` float NOT NULL DEFAULT '0',
  `order_item_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `make_delivery` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id` int NOT NULL,
  `nom_departement` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_is` int DEFAULT '0',
  `display` int NOT NULL DEFAULT '1',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `code_depart` varchar(16) CHARACTER SET big5 COLLATE big5_chinese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- Déchargement des données de la table `departements`
--

INSERT INTO `departements` (`id`, `nom_departement`, `created_at`, `updated_at`, `add_date`, `added_by`, `add_ip`, `edited_by`, `edit_date`, `edit_ip`, `is_deleted`, `delete_is`, `display`, `delete_ip`, `deleted_by`, `delete_date`, `code_depart`) VALUES
(1, 'CUISINE', '2023-06-01 14:07:20.000000', '2023-07-09 22:22:28.000000', '2023-06-01 14:07:20.312677', 1, '127.0.0.1', 1, '2023-07-09 22:22:28', '127.0.0.1', 0, 1, 1, NULL, NULL, NULL, 'DP-002'),
(2, 'AGENCE', '2023-06-01 14:09:32.000000', '2023-07-09 22:22:41.000000', '2023-06-01 14:09:32.376629', 1, '127.0.0.1', 1, '2023-07-09 22:22:41', '127.0.0.1', 0, 1, 1, NULL, NULL, NULL, 'DP-003'),
(4, 'CENTRAL', '2023-06-01 15:30:51.000000', '2023-07-09 22:21:55.000000', '2023-06-01 15:30:51.198476', 1, '127.0.0.1', 1, '2023-07-09 22:21:55', '127.0.0.1', 0, 1, 1, NULL, NULL, NULL, 'DP-001');

-- --------------------------------------------------------

--
-- Structure de la table `entites`
--

CREATE TABLE `entites` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `departement_id` int DEFAULT NULL,
  `use_depot_principal` int NOT NULL DEFAULT '0',
  `code_depot` varchar(255) DEFAULT NULL,
  `adresse_depot` varchar(255) DEFAULT NULL,
  `ville_depot` varchar(255) DEFAULT NULL,
  `telephone_depot` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entites`
--

INSERT INTO `entites` (`id`, `name`, `created_at`, `updated_at`, `add_date`, `added_by`, `add_ip`, `edited_by`, `edit_date`, `edit_ip`, `is_deleted`, `delete_ip`, `deleted_by`, `delete_date`, `departement_id`, `use_depot_principal`, `code_depot`, `adresse_depot`, `ville_depot`, `telephone_depot`) VALUES
(1, 'DÉPÔT  CENTRAL ACHAT', '2023-06-06 11:30:31.000000', '2023-07-27 16:01:48.000000', '2023-06-06 11:30:31.914568', 1, NULL, 1, '2023-07-27 16:01:48', '127.0.0.1', 0, NULL, NULL, NULL, 4, 1, 'DP', 'BP 225 ABIDJAN', 'ABIDJAN', '0700000000'),
(2, 'DÉPÔT  CUISINE PRINCIPALE', '2023-06-06 13:48:32.000000', '2023-07-27 16:01:15.000000', '2023-06-06 13:48:32.482954', 1, '127.0.0.1', 1, '2023-07-27 16:01:15', '127.0.0.1', 0, NULL, NULL, NULL, 1, 0, 'CP', 'MARCORY ZONE 4', 'ABIDJAN', '0707070707'),
(3, 'DÉPÔT  ABIDJAN CHINA MALL', '2023-06-14 10:16:59.000000', '2023-07-27 16:01:29.000000', '2023-06-14 10:16:59.179100', 1, '127.0.0.1', 1, '2023-07-27 16:01:29', '127.0.0.1', 0, NULL, NULL, NULL, 2, 0, '001', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `familles`
--

CREATE TABLE `familles` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fiches_techniques`
--

CREATE TABLE `fiches_techniques` (
  `id` int NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `commentaire` varchar(45) DEFAULT NULL,
  `quantity` float DEFAULT '0',
  `produit_id` int DEFAULT NULL,
  `recette_id` int DEFAULT NULL,
  `unite_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` int NOT NULL,
  `nom` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gaspillages`
--

CREATE TABLE `gaspillages` (
  `id` int NOT NULL,
  `libelle` varchar(45) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `commentaire` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `quantity` float DEFAULT '0',
  `operation_id` int DEFAULT NULL,
  `produit_id` int DEFAULT NULL,
  `entite_id` int DEFAULT NULL,
  `product_unit_id` int DEFAULT NULL,
  `product_quantity_unit` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Structure de la table `operations`
--

CREATE TABLE `operations` (
  `id` int NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `action_stock_id` int DEFAULT NULL,
  `type_operation_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- Déchargement des données de la table `operations`
--

INSERT INTO `operations` (`id`, `libelle`, `created_at`, `updated_at`, `add_date`, `added_by`, `add_ip`, `edited_by`, `edit_date`, `edit_ip`, `is_deleted`, `delete_ip`, `deleted_by`, `delete_date`, `action_stock_id`, `type_operation_id`) VALUES
(1, 'Un produit arrivé expiration', '2023-07-28 10:43:04.000000', '2023-07-28 10:43:04.000000', '2023-07-28 10:43:04.857085', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(2, 'Un produit qui subit une décomposition', '2023-07-28 10:43:19.000000', '2023-07-28 10:43:19.000000', '2023-07-28 10:43:19.242115', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(3, 'Un produit de mauvaise qualité à sortir du stock', '2023-07-28 10:43:33.000000', '2023-07-28 10:43:33.000000', '2023-07-28 10:43:33.438048', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(4, 'Les pertes de matières premières lors de la production à la cuisine', '2023-07-28 10:43:46.000000', '2023-07-28 10:43:46.000000', '2023-07-28 10:43:46.769353', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(5, 'Mauvaise commande exécutée', '2023-07-28 10:44:01.000000', '2023-07-28 10:44:01.000000', '2023-07-28 10:44:01.985136', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(6, 'Produit détruit (ex : bouteille de vin cassé)', '2023-07-28 10:44:16.000000', '2023-07-28 10:44:16.000000', '2023-07-28 10:44:16.839249', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(7, 'Nettoyage des machines en début de service', '2023-07-28 10:44:30.000000', '2023-07-28 10:44:30.000000', '2023-07-28 10:44:30.578358', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(8, 'Bourrage des machines de production', '2023-07-28 10:44:44.000000', '2023-07-28 10:44:44.000000', '2023-07-28 10:44:44.993924', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(9, 'Pertes naturelles', '2023-07-28 10:45:01.000000', '2023-07-28 10:45:01.000000', '2023-07-28 10:45:01.989903', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1),
(10, 'ajouter la quantité', '2023-07-28 12:20:34.000000', '2023-07-28 12:20:34.000000', '2023-07-28 12:20:34.142921', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 2),
(11, 'Supprimer la quantité', '2023-07-28 14:07:10.000000', '2023-07-28 14:07:10.000000', '2023-07-28 14:07:10.855595', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `delivery_status` int DEFAULT '0',
  `total_amount` float DEFAULT '0',
  `entite_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `add_date` timestamp NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime(6) DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `deleted_by` int DEFAULT NULL,
  `delete_ip` varchar(16) DEFAULT NULL,
  `delete_date` datetime(6) DEFAULT NULL,
  `receipt_status` int DEFAULT '0',
  `validate_date` datetime DEFAULT NULL,
  `validate_by` int DEFAULT NULL,
  `validate_note` text,
  `confirm_date` datetime DEFAULT NULL,
  `confirm_by` int DEFAULT NULL,
  `total_item_order` int DEFAULT '0',
  `total_item_receipt` int NOT NULL DEFAULT '0',
  `enclose_date` datetime DEFAULT NULL,
  `enclose_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int NOT NULL,
  `produit_id` int DEFAULT NULL,
  `quantity` float DEFAULT '0',
  `quantity_delivered` float NOT NULL DEFAULT '0',
  `unite_price` float DEFAULT '0',
  `product_unit_id` int DEFAULT NULL,
  `order_id` int NOT NULL,
  `product_receipt_status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'liste_fournisseur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(2, 'ajouter_fournisseur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(3, 'modifier_fournisseur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(4, 'supprimer_fournisseur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(5, 'liste_permission', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(6, 'ajouter_permission', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(7, 'modifier_permission', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(8, 'supprimer_permission', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(9, 'liste_utilisateur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(10, 'ajouter_utilisateur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(11, 'modifier_utilisateur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(12, 'supprimer_utilisateur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(13, 'afficher_utilisateur', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(14, 'liste_role', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(15, 'ajouter_role', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(16, 'modifier_role', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(17, 'supprimer_role', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(18, 'liste_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(19, 'ajouter_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(20, 'modifier_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(21, 'supprimer_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(22, 'liste_sous_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(23, 'ajouter_sous_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(24, 'modifier_sous_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(25, 'supprimer_sous_famille', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(26, 'liste_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(27, 'ajouter_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(28, 'modifier_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(29, 'supprimer_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(30, 'afficher_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(31, 'liste_client', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(32, 'ajouter_client', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(33, 'modifier_client', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(34, 'supprimer_client', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(35, 'liste_categorie_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(36, 'ajouter_categorie_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(37, 'modifier_categorie_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(38, 'supprimer_categorie_produit', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(39, 'liste_achat', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(40, 'ajouter_achat', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(41, 'modifier_achat', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(42, 'supprimer_achat', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(43, 'detail_achat', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(44, 'liste_reception_achat', 'web', '2023-05-29 09:10:00', '2023-06-13 11:25:32'),
(45, 'ajouter_reception_achat', 'web', '2023-05-29 09:10:00', '2023-06-13 07:49:56'),
(46, 'modifier_reception_achat', 'web', '2023-05-29 09:10:00', '2023-06-13 07:49:20'),
(47, 'supprimer_vente', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(48, 'detail_vente', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(49, 'liste_inventaire', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(50, 'ajouter_inventaire', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(51, 'modifier_inventaire', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(52, 'supprimer_inventaire', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(53, 'detail_inventaire', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(54, 'afficher_tableau_bord', 'web', '2023-05-29 09:10:00', '2023-05-29 09:10:00'),
(55, 'liste_depot_stockage', 'web', '2023-06-13 07:40:30', '2023-07-10 11:08:50'),
(56, 'ajouter_depot_stockage', 'web', '2023-06-13 07:40:47', '2023-07-10 11:08:09'),
(57, 'modifier_depot_stockage', 'web', '2023-06-13 07:41:01', '2023-07-10 11:00:55'),
(58, 'supprimer_depot_stockage', 'web', '2023-06-13 07:41:18', '2023-07-10 11:05:32'),
(59, 'afficher_depot_stockage', 'web', '2023-06-13 07:41:37', '2023-07-10 11:05:02'),
(60, 'liste_departement', 'web', '2023-06-13 07:41:57', '2023-06-13 07:41:57'),
(61, 'ajouter_departement', 'web', '2023-06-13 07:42:12', '2023-06-13 07:42:12'),
(62, 'modifier_departement', 'web', '2023-06-13 07:42:27', '2023-06-13 07:42:27'),
(63, 'supprimer_departement', 'web', '2023-06-13 07:42:56', '2023-06-13 07:42:56'),
(64, 'afficher_departement', 'web', '2023-06-13 07:43:10', '2023-06-13 07:43:10'),
(65, 'liste_unite', 'web', '2023-06-13 07:44:12', '2023-06-13 07:44:12'),
(66, 'ajouter_unite', 'web', '2023-06-13 07:44:26', '2023-06-13 07:44:26'),
(67, 'modifier_unite', 'web', '2023-06-13 07:44:42', '2023-06-13 07:44:42'),
(68, 'supprimer_unite', 'web', '2023-06-13 07:45:01', '2023-06-13 07:45:01'),
(69, 'afficher_unite', 'web', '2023-06-13 07:45:16', '2023-06-13 07:45:16'),
(70, 'section_fournisseur', 'web', '2023-06-13 07:57:55', '2023-06-13 07:57:55'),
(71, 'section_departement', 'web', '2023-06-13 07:58:16', '2023-06-13 07:58:16'),
(72, 'section_depot_stockage', 'web', '2023-06-13 07:58:29', '2023-07-10 11:06:22'),
(73, 'section_produit', 'web', '2023-06-13 07:58:44', '2023-06-13 07:58:44'),
(74, 'section_achat', 'web', '2023-06-13 07:59:03', '2023-06-13 07:59:03'),
(75, 'section_commande_depot_stockage', 'web', '2023-06-13 07:59:36', '2023-07-10 11:02:49'),
(76, 'section_commande', 'web', '2023-06-13 07:59:53', '2023-06-13 07:59:53'),
(77, 'section_authentification', 'web', '2023-06-13 08:01:09', '2023-06-13 08:01:09'),
(78, 'section_permission', 'web', '2023-06-13 11:31:02', '2023-06-13 11:42:56'),
(79, 'section_role', 'web', '2023-06-13 11:31:19', '2023-06-13 11:43:21'),
(80, 'section_utilisateur', 'web', '2023-06-13 11:31:34', '2023-06-13 11:43:45'),
(81, 'modifier_commande', 'web', '2023-06-13 11:31:51', '2023-06-13 11:31:51'),
(82, 'liste_reception_commande', 'web', '2023-06-13 11:32:38', '2023-06-13 11:32:38'),
(83, 'modifier_reception_commande', 'web', '2023-06-13 11:33:02', '2023-06-13 11:33:02'),
(84, 'supprimer_reception_commande', 'web', '2023-06-13 11:33:25', '2023-06-13 11:33:25'),
(85, 'ajouter_commande', 'web', '2023-06-13 11:44:14', '2023-06-13 11:44:14'),
(86, 'supprimer_commande', 'web', '2023-06-13 11:44:29', '2023-06-13 11:44:29'),
(87, 'liste_commande', 'web', '2023-06-13 12:57:55', '2023-06-13 12:57:55'),
(88, 'ajouter_reception_commande', 'web', '2023-06-13 13:00:18', '2023-06-13 13:00:18'),
(89, 'creer_bon_livraison_commande', 'web', '2023-06-13 13:02:10', '2023-06-14 11:19:59'),
(90, 'liste_commande_depot_stockage', 'web', '2023-06-15 12:59:51', '2023-07-10 11:02:01'),
(91, 'liste_bon_livraison_commande', 'web', '2023-06-15 13:00:24', '2023-07-16 08:33:54'),
(92, 'commande_departement_central', 'web', '2023-07-10 11:15:56', '2023-07-20 15:28:57'),
(93, 'commande_departement_cuisine', 'web', '2023-07-10 11:16:25', '2023-07-20 15:28:18'),
(94, 'section_gaspillage', 'web', '2023-07-17 08:39:31', '2023-07-17 08:39:31'),
(95, 'ajouter_gaspillage', 'web', '2023-07-17 08:40:11', '2023-07-17 08:40:11'),
(96, 'modifier_gaspillage', 'web', '2023-07-17 08:41:02', '2023-07-17 08:41:02'),
(97, 'supprimer_gaspillage', 'web', '2023-07-17 08:41:34', '2023-07-17 08:41:34'),
(98, 'liste_gaspillage', 'web', '2023-07-17 08:42:35', '2023-07-17 08:42:35'),
(99, 'consultation_stock_depot_stockage', 'web', '2023-07-17 08:52:15', '2023-07-17 08:52:15'),
(100, 'section_operation', 'web', '2023-07-17 08:56:12', '2023-07-17 08:56:12'),
(101, 'ajouter_operation', 'web', '2023-07-17 08:56:25', '2023-07-17 08:56:25'),
(102, 'modifier_operation', 'web', '2023-07-17 08:56:40', '2023-07-17 08:56:40'),
(103, 'supprimer_operation', 'web', '2023-07-17 08:56:59', '2023-07-17 08:56:59'),
(104, 'liste_operation', 'web', '2023-07-17 08:57:16', '2023-07-17 08:57:16'),
(105, 'section_ajustement', 'web', '2023-07-17 09:01:33', '2023-07-17 09:01:33'),
(106, 'ajouter_ajustement', 'web', '2023-07-17 09:01:51', '2023-07-17 09:01:51'),
(107, 'modifier_ajustement', 'web', '2023-07-17 09:02:05', '2023-07-17 09:02:05'),
(108, 'supprimer_ajustement', 'web', '2023-07-17 09:02:21', '2023-07-17 09:02:21'),
(109, 'liste_ajustement', 'web', '2023-07-17 09:02:36', '2023-07-17 09:02:36'),
(110, 'section_recette', 'web', '2023-07-21 08:13:32', '2023-07-21 08:13:32'),
(111, 'ajouter_recette', 'web', '2023-07-21 08:13:46', '2023-07-21 08:13:46'),
(112, 'modifier_recette', 'web', '2023-07-21 08:14:01', '2023-07-21 08:14:01'),
(113, 'liste_recette', 'web', '2023-07-21 08:14:17', '2023-07-21 08:14:17'),
(114, 'supprimer_recette', 'web', '2023-07-21 08:15:27', '2023-07-21 08:15:39'),
(115, 'valider_livraison', 'web', '2023-07-28 06:54:38', '2023-07-28 06:54:38'),
(116, 'valider_commande', 'web', '2023-07-28 06:55:01', '2023-07-28 06:55:01'),
(117, 'confirmer_commande', 'web', '2023-07-28 06:55:22', '2023-07-28 06:55:22'),
(118, 'supprimer_reception_achat', 'web', '2023-07-28 06:57:28', '2023-07-28 09:20:09'),
(119, 'cloturer_commande', 'web', '2023-07-28 08:57:08', '2023-07-28 08:57:08'),
(120, 'validation_achat', 'web', '2023-07-28 09:10:50', '2023-07-28 09:10:50'),
(121, 'saisir_entre_stock', 'web', '2023-07-28 14:21:19', '2023-07-28 14:21:19'),
(122, 'saisir_sortie_stock', 'web', '2023-07-28 14:21:33', '2023-07-28 14:21:33');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `procurements`
--

CREATE TABLE `procurements` (
  `id` int NOT NULL,
  `reference` varchar(45) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `procurment_status` int DEFAULT '1',
  `payment_status` int DEFAULT '1',
  `receipt_status` int NOT NULL DEFAULT '0',
  `cost` float DEFAULT '0',
  `tax_value` float DEFAULT '0',
  `value` float DEFAULT NULL,
  `delivery_date` datetime(6) DEFAULT NULL,
  `invoice_reference` varchar(45) DEFAULT NULL,
  `fournisseur_id` int DEFAULT NULL,
  `entite_id` int DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  `date_prevue_reception` datetime DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `confirm_by` int DEFAULT NULL,
  `confirm_note` text,
  `total_produit` int NOT NULL DEFAULT '0',
  `closed_by` int DEFAULT NULL,
  `closed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `procurements_products`
--

CREATE TABLE `procurements_products` (
  `id` int NOT NULL,
  `reference` varchar(45) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `commentaire` varchar(45) DEFAULT NULL,
  `quantity` float DEFAULT '0',
  `quantity_received` float NOT NULL DEFAULT '0',
  `purchase_price` float DEFAULT '0',
  `total_purchase_price` float DEFAULT '0',
  `product_receipt_status` int NOT NULL DEFAULT '0',
  `procurement_id` int DEFAULT NULL,
  `produit_id` int DEFAULT NULL,
  `product_unit_id` int NOT NULL,
  `unit_quantity` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products_histories`
--

CREATE TABLE `products_histories` (
  `id` int NOT NULL,
  `libelle` varchar(45) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `commentaire` varchar(45) DEFAULT NULL,
  `quantity` float DEFAULT '0',
  `produit_id` int DEFAULT NULL,
  `product_unit_id` int DEFAULT NULL,
  `procurement_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int NOT NULL,
  `nom_produit` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `sous_familles_id` int DEFAULT NULL,
  `categories_id` int DEFAULT NULL,
  `unites_id` int NOT NULL,
  `reference_produit` varchar(45) DEFAULT NULL,
  `code_barre` varchar(45) DEFAULT NULL,
  `prix_vente` float DEFAULT NULL,
  `prix_achat` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits_unites`
--

CREATE TABLE `produits_unites` (
  `id` int NOT NULL,
  `produit_id` int NOT NULL,
  `unite_id` int NOT NULL,
  `pcb` float NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_deleted` int NOT NULL DEFAULT '0',
  `deleted_by` int DEFAULT NULL,
  `delete_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `receptions`
--

CREATE TABLE `receptions` (
  `id` int NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `total_receipt_price` float DEFAULT '0',
  `tax_value` float DEFAULT '0',
  `value` float DEFAULT NULL,
  `reception_date` datetime(6) DEFAULT NULL,
  `procurements_id` int DEFAULT NULL,
  `unite_id` int DEFAULT NULL,
  `invoice_reference` varchar(100) DEFAULT NULL,
  `entite_id` int DEFAULT NULL,
  `order_id` int DEFAULT NULL,
  `invoice` int DEFAULT '0',
  `receipt_status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `receptions_products`
--

CREATE TABLE `receptions_products` (
  `id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `commentaire` varchar(45) DEFAULT NULL,
  `quantity` float DEFAULT '0',
  `quantity_received` float DEFAULT '0',
  `unit_price` float DEFAULT '0',
  `sub_total` float DEFAULT '0',
  `receptions_id` int DEFAULT NULL,
  `procurement_product_id` int DEFAULT NULL,
  `order_product_id` int DEFAULT NULL,
  `produit_id` int DEFAULT NULL,
  `product_unit_id` int DEFAULT NULL,
  `unit_quantity` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

CREATE TABLE `recettes` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET big5 COLLATE big5_chinese_ci NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `prix_unitaire` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=big5;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2023-05-29 09:10:12', '2023-05-29 09:10:12'),
(2, 'super-admin', 'web', '2023-05-29 09:10:12', '2023-05-29 09:10:12'),
(3, 'responsable-stock-central', 'web', '2023-06-05 11:13:03', '2023-07-20 15:11:22'),
(4, 'responsable-stock-cuisine', 'web', '2023-06-13 09:52:36', '2023-07-20 15:11:43'),
(5, 'responsable-stock-agence', 'web', '2023-06-13 09:52:58', '2023-07-20 15:11:58'),
(6, 'responsable-stock', 'web', '2023-06-13 09:53:28', '2023-07-20 15:12:14');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 3),
(70, 3),
(74, 3),
(75, 3),
(89, 3),
(90, 3),
(91, 3),
(94, 3),
(95, 3),
(96, 3),
(97, 3),
(98, 3),
(99, 3),
(105, 3),
(106, 3),
(109, 3),
(118, 3),
(120, 3),
(75, 4),
(76, 4),
(81, 4),
(82, 4),
(84, 4),
(85, 4),
(86, 4),
(87, 4),
(88, 4),
(89, 4),
(90, 4),
(91, 4),
(92, 4),
(94, 4),
(95, 4),
(96, 4),
(97, 4),
(98, 4),
(99, 4),
(105, 4),
(106, 4),
(107, 4),
(108, 4),
(109, 4),
(117, 4),
(119, 4),
(121, 4),
(122, 4),
(76, 5),
(81, 5),
(82, 5),
(84, 5),
(85, 5),
(86, 5),
(87, 5),
(88, 5),
(89, 5),
(92, 5),
(93, 5),
(94, 5),
(95, 5),
(96, 5),
(97, 5),
(98, 5),
(99, 5),
(105, 5),
(106, 5),
(109, 5),
(117, 5),
(119, 5);

-- --------------------------------------------------------

--
-- Structure de la table `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `reference` varchar(45) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `delivery_status` enum('pending','delivered','stocked') DEFAULT 'pending',
  `entite` enum('agence','centrale','cuisine') DEFAULT NULL,
  `payment_status` enum('paid','unpaid') DEFAULT 'unpaid',
  `total_amount` float DEFAULT '0',
  `tax_value` float DEFAULT '0',
  `value` float DEFAULT NULL,
  `delivery_date` datetime(6) DEFAULT NULL,
  `invoice_reference` varchar(45) DEFAULT NULL,
  `entites_id` int DEFAULT NULL,
  `clients_id` int DEFAULT NULL,
  `recettes_cuisines_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sales_products`
--

CREATE TABLE `sales_products` (
  `id` int NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `quantity` float DEFAULT NULL,
  `unite_price` float DEFAULT '0',
  `sale_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'default_stockage', '3', NULL, '2023-06-06 10:03:09', '2023-06-06 10:04:22'),
(2, 'disable', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sous_familles`
--

CREATE TABLE `sous_familles` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `familles_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stock_products`
--

CREATE TABLE `stock_products` (
  `id` int NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `produit_id` int NOT NULL,
  `unite_id` int DEFAULT NULL,
  `entite_id` int DEFAULT NULL,
  `faible_quantite` float DEFAULT NULL,
  `alerte_stock_activee` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id` int NOT NULL,
  `reference` varchar(45) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT NULL,
  `added_by` int DEFAULT NULL,
  `add_ip` varchar(16) DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL,
  `value` float DEFAULT NULL,
  `orders_id` int DEFAULT NULL,
  `procurements_id` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_operations`
--

CREATE TABLE `types_operations` (
  `id` int NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `code` varchar(16) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `types_operations`
--

INSERT INTO `types_operations` (`id`, `libelle`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Sortie en stock', 'output', '2023-07-13 12:09:29.000000', '2023-07-13 12:09:29.000000'),
(2, 'Entrée en stock', 'entry', '2023-07-13 12:09:29.000000', '2023-07-13 12:09:29.000000');

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

CREATE TABLE `unites` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL,
  `add_date` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6),
  `added_by` int NOT NULL,
  `add_ip` varchar(16) NOT NULL,
  `edited_by` int DEFAULT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edit_ip` varchar(16) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `delete_ip` varchar(16) DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id`, `name`, `created_at`, `updated_at`, `add_date`, `added_by`, `add_ip`, `edited_by`, `edit_date`, `edit_ip`, `is_deleted`, `delete_ip`, `deleted_by`, `delete_date`) VALUES
(2, 'Piéce', '2023-06-01 10:06:28.000000', '2023-07-21 18:01:21.000000', '2023-06-01 10:06:28.113740', 1, '127.0.0.1', 1, '2023-07-21 18:01:21', '127.0.0.1', 0, NULL, NULL, NULL),
(3, 'Kilo gramme', '2023-06-01 10:06:52.000000', '2023-06-01 10:09:16.000000', '2023-06-01 10:06:52.636676', 1, '127.0.0.1', 1, '2023-06-01 10:09:16', '127.0.0.1', 0, NULL, NULL, NULL),
(5, 'Sac', '2023-06-01 10:07:25.000000', '2023-06-01 10:11:04.000000', '2023-06-01 10:07:25.463893', 1, '127.0.0.1', 1, '2023-06-01 10:11:04', '127.0.0.1', 0, NULL, NULL, NULL),
(6, 'Boîte', '2023-06-01 10:12:58.000000', '2023-06-01 10:12:58.000000', '2023-06-01 10:12:58.459590', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL),
(7, 'Sachet', '2023-06-01 10:13:11.000000', '2023-06-23 10:19:13.000000', '2023-06-01 10:13:11.776019', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL),
(8, 'Carton', '2023-06-01 10:13:35.000000', '2023-06-01 10:13:35.000000', '2023-06-01 10:13:35.561618', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL),
(9, 'Bidon', '2023-06-23 10:15:40.000000', '2023-06-23 10:15:40.000000', '2023-06-23 10:15:40.302845', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL),
(10, 'Litre', '2023-06-23 10:17:51.000000', '2023-06-23 10:17:51.000000', '2023-06-23 10:17:51.114686', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL),
(11, 'Paquet', '2023-06-23 10:18:03.000000', '2023-06-23 10:18:03.000000', '2023-06-23 10:18:03.605429', 1, '127.0.0.1', NULL, NULL, NULL, 0, NULL, NULL, NULL),
(12, 'Bouteille', '2023-06-23 10:18:40.000000', '2023-06-23 10:18:52.000000', '2023-06-23 10:18:40.985193', 1, '127.0.0.1', 1, '2023-06-23 10:18:52', '127.0.0.1', 0, NULL, NULL, NULL),
(13, 'Gramme', '2023-07-20 23:01:34.000000', '2023-07-20 23:02:03.000000', '2023-07-20 23:01:34.519007', 1, '127.0.0.1', 1, '2023-07-20 23:02:03', '127.0.0.1', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entite_id` int DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `entite_id`, `email`, `active`, `email_verified_at`, `password`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Djamala', 'Kouakou xavier', NULL, 'xavier.djamala@softexpertise.com', 1, '2023-05-29 09:10:19', '$2y$10$EhxzhpQF4YhXmzA.Hai8t.vnqGtA2ZRgDhVP4ZgdsjnCPq/k26Dvq', NULL, NULL, '2023-05-29 09:10:19', '2023-05-29 09:10:19'),
(7, NULL, 'admin', 'admin', NULL, 'admin@mail.com', 1, NULL, '$2y$10$zlAgdUWrJksylYitxoH2aOLe9cXV9YBEoNh0q0GJ0fa5uQfELSJY6', NULL, NULL, '2023-07-28 22:03:08', '2023-07-28 22:03:08');

-- --------------------------------------------------------

--
-- Structure de la table `user_infos`
--

CREATE TABLE `user_infos` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `communication` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marketing` tinyint DEFAULT NULL,
  `entites_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actions_stocks`
--
ALTER TABLE `actions_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Index pour la table `ajustements_products`
--
ALTER TABLE `ajustements_products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `delivery_products`
--
ALTER TABLE `delivery_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produit_has_approvisionnement_produit1_idx` (`produit_id`);

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `entites`
--
ALTER TABLE `entites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entites_departement_idx` (`departement_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `familles`
--
ALTER TABLE `familles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fiches_techniques`
--
ALTER TABLE `fiches_techniques`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gaspillages`
--
ALTER TABLE `gaspillages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gaspillages_motifs_gaspillages1_idx` (`operation_id`),
  ADD KEY `fk_gaspillages_entites1_idx` (`entite_id`);

--
-- Index pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Index pour la table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produit_has_approvisionnement_produit1_idx` (`produit_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `procurements`
--
ALTER TABLE `procurements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_procurements_fournisseurs1_idx` (`fournisseur_id`);

--
-- Index pour la table `procurements_products`
--
ALTER TABLE `procurements_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_procurements_products_procurements1_idx` (`procurement_id`),
  ADD KEY `fk_procurements_products_produits1_idx` (`produit_id`);

--
-- Index pour la table `products_histories`
--
ALTER TABLE `products_histories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produits_sous_familles1_idx` (`sous_familles_id`),
  ADD KEY `fk_produits_categories1_idx` (`categories_id`),
  ADD KEY `fk_produits_unites1_idx` (`unites_id`);

--
-- Index pour la table `produits_unites`
--
ALTER TABLE `produits_unites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `receptions`
--
ALTER TABLE `receptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_receptions_procurements1_idx` (`procurements_id`);

--
-- Index pour la table `receptions_products`
--
ALTER TABLE `receptions_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_receptions_products_receptions1_idx` (`receptions_id`);

--
-- Index pour la table `recettes`
--
ALTER TABLE `recettes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Index pour la table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_agences1_idx` (`entites_id`),
  ADD KEY `fk_orders_clients1_idx` (`clients_id`),
  ADD KEY `fk_orders_recettes_cuisines1_idx` (`recettes_cuisines_id`);

--
-- Index pour la table `sales_products`
--
ALTER TABLE `sales_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sales_products_sales_idx` (`sale_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_key_index` (`key`);

--
-- Index pour la table `sous_familles`
--
ALTER TABLE `sous_familles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sous_familles_familles_idx` (`familles_id`) USING BTREE;

--
-- Index pour la table `stock_products`
--
ALTER TABLE `stock_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stock_products_produits1_idx` (`produit_id`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `types_operations`
--
ALTER TABLE `types_operations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `unites`
--
ALTER TABLE `unites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- Index pour la table `user_infos`
--
ALTER TABLE `user_infos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actions_stocks`
--
ALTER TABLE `actions_stocks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `ajustements_products`
--
ALTER TABLE `ajustements_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `delivery_products`
--
ALTER TABLE `delivery_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `entites`
--
ALTER TABLE `entites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `familles`
--
ALTER TABLE `familles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fiches_techniques`
--
ALTER TABLE `fiches_techniques`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gaspillages`
--
ALTER TABLE `gaspillages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `procurements`
--
ALTER TABLE `procurements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `procurements_products`
--
ALTER TABLE `procurements_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products_histories`
--
ALTER TABLE `products_histories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits_unites`
--
ALTER TABLE `produits_unites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `receptions`
--
ALTER TABLE `receptions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `receptions_products`
--
ALTER TABLE `receptions_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recettes`
--
ALTER TABLE `recettes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sales_products`
--
ALTER TABLE `sales_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `sous_familles`
--
ALTER TABLE `sous_familles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_products`
--
ALTER TABLE `stock_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types_operations`
--
ALTER TABLE `types_operations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `unites`
--
ALTER TABLE `unites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user_infos`
--
ALTER TABLE `user_infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `entites`
--
ALTER TABLE `entites`
  ADD CONSTRAINT `fk_entites_departements1` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`);

--
-- Contraintes pour la table `gaspillages`
--
ALTER TABLE `gaspillages`
  ADD CONSTRAINT `fk_gaspillages_entites1` FOREIGN KEY (`entite_id`) REFERENCES `entites` (`id`),
  ADD CONSTRAINT `fk_gaspillages_motifs_gaspillages1` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`);

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `procurements`
--
ALTER TABLE `procurements`
  ADD CONSTRAINT `fk_procurements_fournisseurs1` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`);

--
-- Contraintes pour la table `procurements_products`
--
ALTER TABLE `procurements_products`
  ADD CONSTRAINT `fk_procurements_products_procurements1` FOREIGN KEY (`procurement_id`) REFERENCES `procurements` (`id`),
  ADD CONSTRAINT `fk_procurements_products_produits1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_produits_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_produits_sous_familles1` FOREIGN KEY (`sous_familles_id`) REFERENCES `sous_familles` (`id`),
  ADD CONSTRAINT `fk_produits_unites1` FOREIGN KEY (`unites_id`) REFERENCES `unites` (`id`);

--
-- Contraintes pour la table `receptions`
--
ALTER TABLE `receptions`
  ADD CONSTRAINT `fk_receptions_procurements1` FOREIGN KEY (`procurements_id`) REFERENCES `procurements` (`id`);

--
-- Contraintes pour la table `receptions_products`
--
ALTER TABLE `receptions_products`
  ADD CONSTRAINT `fk_receptions_products_receptions1` FOREIGN KEY (`receptions_id`) REFERENCES `receptions` (`id`);

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_orders_agences1` FOREIGN KEY (`entites_id`) REFERENCES `entites` (`id`),
  ADD CONSTRAINT `fk_orders_clients1` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `fk_orders_recettes_cuisines1` FOREIGN KEY (`recettes_cuisines_id`) REFERENCES `recettes` (`id`);

--
-- Contraintes pour la table `sales_products`
--
ALTER TABLE `sales_products`
  ADD CONSTRAINT `fk_orders_products_orders1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Contraintes pour la table `sous_familles`
--
ALTER TABLE `sous_familles`
  ADD CONSTRAINT `fk_sous_familles_familles1` FOREIGN KEY (`familles_id`) REFERENCES `familles` (`id`);

--
-- Contraintes pour la table `stock_products`
--
ALTER TABLE `stock_products`
  ADD CONSTRAINT `fk_stock_products_produits1` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
