-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2021 at 10:15 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_name`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211212165623', '2021-12-12 18:03:09', 850);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `leader_id_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `leader_id_id`, `description`) VALUES
(1, 3, 'Equipe de développement');

-- --------------------------------------------------------

--
-- Table structure for table `group_project`
--

CREATE TABLE `group_project` (
  `id` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `id_project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `manager_id_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_init` date NOT NULL,
  `deadline` date NOT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `manager_id_id`, `title`, `description`, `date_init`, `deadline`, `date_fin`) VALUES
(1, 3, 'Projet Web', 'Application Web Symfony', '2021-12-09', '2022-01-08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_group`
--

CREATE TABLE `project_group` (
  `id` int(11) NOT NULL,
  `id_project_id` int(11) NOT NULL,
  `id_group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_group`
--

INSERT INTO `project_group` (`id`, `id_project_id`, `id_group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `group_id_id` int(11) NOT NULL,
  `project_id_id` int(11) NOT NULL,
  `user_id_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `done` tinyint(1) NOT NULL,
  `date_init` date NOT NULL,
  `deadline` date NOT NULL,
  `date_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `group_id_id`, `project_id_id`, `user_id_id`, `title`, `description`, `done`, `date_init`, `deadline`, `date_fin`) VALUES
(1, 1, 1, 4, 'Tache 1', '<div>une petite tache</div>', 0, '2021-12-24', '2022-01-02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `group_id_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password2` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encpassword` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `group_id_id`, `name`, `prenom`, `username`, `password2`, `encpassword`, `roles`) VALUES
(1, NULL, 'admi', 'n', 'admin', NULL, '$2y$13$jeGqWBKgo3INcIX2I.tUR.mClqHdlPNP3H6pLbhD2e92vULio2N6m', '[\"ROLE_ADMIN\"]'),
(2, NULL, 'chefproje', 't', 'chefprojet', NULL, '$2y$13$tl.Zos8DMVtiv8fc/lMc4eOUpCyljShS97u4j8hZWifv8xhvD6WVe', '[\"ROLE_PROJECT_CHEF\"]'),
(3, NULL, 'chefequip', 'e', 'chefequipe', NULL, '$2y$13$..GUf2uj1n4MDIhGsIjo4.jU1We4JTQ0zaw9OnsCHot2JQ/w0yzom', '[\"ROLE_EQUIPE_CHEF\"]'),
(4, NULL, 'membr', 'e', 'membre', NULL, '$2y$13$NYvqo/ar0yE/liyF8NCT2uarLBkGpOaIghl5jfmscuPZWgc5w5yBa', '[\"ROLE_MEMBER\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6DC044C5EFE6DECF` (`leader_id_id`);

--
-- Indexes for table `group_project`
--
ALTER TABLE `group_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2FB3D0EE569B5E6D` (`manager_id_id`);

--
-- Indexes for table `project_group`
--
ALTER TABLE `project_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7E954D5BB3E79F4B` (`id_project_id`),
  ADD KEY `IDX_7E954D5BAE8F35D2` (`id_group_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB252F68B530` (`group_id_id`),
  ADD KEY `IDX_527EDB256C1197C9` (`project_id_id`),
  ADD KEY `IDX_527EDB259D86650F` (`user_id_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649EC595A10` (`password2`),
  ADD KEY `IDX_8D93D6492F68B530` (`group_id_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_project`
--
ALTER TABLE `group_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_group`
--
ALTER TABLE `project_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `FK_6DC044C5EFE6DECF` FOREIGN KEY (`leader_id_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `FK_2FB3D0EE569B5E6D` FOREIGN KEY (`manager_id_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `project_group`
--
ALTER TABLE `project_group`
  ADD CONSTRAINT `FK_7E954D5BAE8F35D2` FOREIGN KEY (`id_group_id`) REFERENCES `group` (`id`),
  ADD CONSTRAINT `FK_7E954D5BB3E79F4B` FOREIGN KEY (`id_project_id`) REFERENCES `project` (`id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB252F68B530` FOREIGN KEY (`group_id_id`) REFERENCES `group` (`id`),
  ADD CONSTRAINT `FK_527EDB256C1197C9` FOREIGN KEY (`project_id_id`) REFERENCES `project` (`id`),
  ADD CONSTRAINT `FK_527EDB259D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6492F68B530` FOREIGN KEY (`group_id_id`) REFERENCES `group` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
