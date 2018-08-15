-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30-Jan-2017 às 19:15
-- Versão do servidor: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suflist`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `company`
--

CREATE TABLE `company` (
  `id` int(10) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `nome_ceo` int(10) NOT NULL,
  `ip_company` varchar(255) NOT NULL DEFAULT '127.0.0.1',
  `n_funcionarios` int(10) NOT NULL,
  `h_trabalho_s` int(10) NOT NULL DEFAULT '40',
  `h_inicio` int(10) NOT NULL,
  `h_final` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `company`
--

INSERT INTO `company` (`id`, `nome`, `nome_ceo`, `ip_company`, `n_funcionarios`, `h_trabalho_s`, `h_inicio`, `h_final`) VALUES
(10, 'iConsulting', 66, '::1', 2, 40, 1485761400, 1485793800);

-- --------------------------------------------------------

--
-- Estrutura da tabela `promo_code`
--

CREATE TABLE `promo_code` (
  `id` int(10) NOT NULL,
  `code_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `promo_code`
--

INSERT INTO `promo_code` (`id`, `code_name`) VALUES
(1, 'tone');

-- --------------------------------------------------------

--
-- Estrutura da tabela `timerday`
--

CREATE TABLE `timerday` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `h_inicio` int(10) DEFAULT NULL,
  `h_pausa` int(10) DEFAULT NULL,
  `h_final` int(10) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `h_check` int(10) DEFAULT NULL,
  `h_total` int(10) DEFAULT NULL,
  `dia` varchar(255) DEFAULT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `timerday`
--

INSERT INTO `timerday` (`id`, `id_user`, `h_inicio`, `h_pausa`, `h_final`, `status`, `h_check`, `h_total`, `dia`, `data`) VALUES
(1, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-30 17:36:00'),
(5, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-30 17:36:00'),
(6, 66, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-30 17:36:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `timertotal`
--

CREATE TABLE `timertotal` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `dia_inicio` datetime DEFAULT NULL,
  `dia_final` datetime DEFAULT NULL,
  `hs_total` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(45) NOT NULL,
  `status` smallint(10) NOT NULL DEFAULT '10',
  `role` int(10) NOT NULL DEFAULT '10',
  `ceo` int(10) NOT NULL DEFAULT '0',
  `company` varchar(255) NOT NULL DEFAULT 'insert company',
  `photo` varchar(255) NOT NULL DEFAULT 'default-profile',
  `n_func` int(10) DEFAULT '0',
  `auth_key` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `password_hash`, `email`, `status`, `role`, `ceo`, `company`, `photo`, `n_func`, `auth_key`, `created_at`, `password_reset_token`, `updated_at`) VALUES
(66, 'Carlos Sousa', '$2y$13$vU3TfS2pTLdO2lGX809uw.TYRdmwEwTgba1nxittxT0wnuTF/KLtW', 'carlos.sousa@iconsulting-group.com', 10, 10, 2, 'iConsulting', 'default-profile', 2, 'UYB4FOiXEcK5CnyEhQ4w13HEPORZRKwr', 1485768021, NULL, 1485768287),
(67, 'milhoesnando', '$2y$13$qWeU0pgF7DjH3PlZRFcyTeru0pzX2AvHs2l7WCT.jEeRmxGa53/pG', 'milhoesnando@hotmail.com', 10, 10, 0, 'iConsulting', 'default-profile', 0, 'U_rjPmzIoIOsGEqQZNoxgA9UIMwrKuwY', 1485768185, NULL, 1485768185),
(68, 'antonio_carlos_alves_sousa', '$2y$13$b91V37u7tIfWdAv7SUwloOSGFjActdcpd4bK8/XPLhgqAywpAiSdq', 'antonio_carlos_alves_sousa@hotmail.com', 10, 10, 0, 'iConsulting', 'default-profile', 0, 'NdN04yzGeCvjjc5S3HevowHCkTBmH6ex', 1485768187, NULL, 1485768187);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_information`
--

CREATE TABLE `user_information` (
  `user_id` int(10) NOT NULL,
  `user_img` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_nome` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_apelido` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_contribuinte` int(10) DEFAULT NULL,
  `user_nomeempresa` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_cidade` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_postal` int(10) DEFAULT NULL,
  `user_phone` int(10) DEFAULT NULL,
  `user_descricao` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `user_pais` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_distrito` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_sexo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `user_datanascimento` date DEFAULT NULL,
  `user_profissao` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `info` int(10) DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_code`
--
ALTER TABLE `promo_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timerday`
--
ALTER TABLE `timerday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timertotal`
--
ALTER TABLE `timertotal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `password_resete_token_UNIQUE` (`password_reset_token`);

--
-- Indexes for table `user_information`
--
ALTER TABLE `user_information`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `promo_code`
--
ALTER TABLE `promo_code`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `timerday`
--
ALTER TABLE `timerday`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `timertotal`
--
ALTER TABLE `timertotal`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
