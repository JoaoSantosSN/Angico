-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 29/05/2026 às 17:42
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `angico`
--
CREATE DATABASE IF NOT EXISTS `angico` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `angico`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE IF NOT EXISTS `agenda` (
  `nome_dono` varchar(100) DEFAULT NULL,
  `nome_pet` varchar(100) DEFAULT NULL,
  `servico` varchar(50) DEFAULT NULL,
  `data_hora` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`nome_dono`, `nome_pet`, `servico`, `data_hora`) VALUES
('Laura', '', 'tosa', '2026-04-27 00:00:00'),
('Laura', 'bobbe', 'banho', '2026-04-27 13:34:00'),
('Laura', 'bobbe', 'banho', '2026-04-27 13:34:00'),
('Laura', 'bobi', 'banho', '2026-04-20 13:35:00'),
('Laura', '', 'banho', '2026-04-06 00:00:00'),
('dale', 'fred', 'banho', '2026-05-06 02:59:00'),
('dale', 'fred', 'consulta', '2026-05-06 06:59:00'),
('dale', 'fred', 'banho', '2026-05-06 00:00:00'),
('dale', 'joao', 'banho', '2026-05-11 15:55:00'),
('Laura', '', 'banho', '2026-04-07 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `cli_cod` int NOT NULL AUTO_INCREMENT,
  `cli_nome` varchar(50) DEFAULT NULL,
  `cli_email` varchar(50) DEFAULT NULL,
  `cli_senha` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cli_cod`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`cli_cod`, `cli_nome`, `cli_email`, `cli_senha`) VALUES
(1, 'higor', 'higor43@gmail.com', '0'),
(2, 'Laura', 'Laura@gmail.com', 'Laura1'),
(3, 'dale', 'email@gmail.com', 'senha');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE IF NOT EXISTS `fornecedor` (
  `for_cod` int NOT NULL AUTO_INCREMENT,
  `for_social` varchar(50) DEFAULT NULL,
  `for_cnpj` varchar(30) DEFAULT NULL,
  `for_categoria` varchar(50) DEFAULT NULL,
  `for_whatsapp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `for_senha` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`for_cod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `fun_cod` int NOT NULL AUTO_INCREMENT,
  `fun_nome` varchar(50) DEFAULT NULL,
  `fun_cpf` varchar(30) DEFAULT NULL,
  `fun_senha` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`fun_cod`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`fun_cod`, `fun_nome`, `fun_cpf`, `fun_senha`) VALUES
(1, 'anthony', '12345678910', '123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico`
--

DROP TABLE IF EXISTS `historico`;
CREATE TABLE IF NOT EXISTS `historico` (
  `his_id` int NOT NULL AUTO_INCREMENT,
  `his_produto` varchar(255) DEFAULT NULL,
  `his_quantidade` int DEFAULT NULL,
  `his_fornecedor` varchar(255) DEFAULT NULL,
  `his_datahora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`his_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `historico`
--

INSERT INTO `historico` (`his_id`, `his_produto`, `his_quantidade`, `his_fornecedor`, `his_datahora`) VALUES
(1, 'Ração Premium', 11, 'Rações S.A', '2026-04-10 13:57:22'),
(2, 'Ração Premium', 122, '', '2026-04-10 13:59:37'),
(3, 'Ração Premium', 1, '', '2026-04-10 14:04:48'),
(4, 'Ração Premium', -1, '', '2026-04-10 14:06:34'),
(5, 'Ração Premium', -60, '', '2026-04-10 14:06:50'),
(6, 'Ração Premium', -1, '', '2026-04-10 14:08:59'),
(7, 'Ração Premium', -1, '', '2026-04-10 14:09:19'),
(8, 'Ração Premium', 6, '', '2026-04-10 14:21:59'),
(9, 'Ração Premium', 12, '', '2026-04-10 14:23:36'),
(10, 'Ração Premium', -10, 'Rações S.A', '2026-04-10 16:21:43'),
(11, 'Brinquedo Mordedor', 23, 'Brinquedos S.A', '2026-04-10 19:12:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `medico`
--

DROP TABLE IF EXISTS `medico`;
CREATE TABLE IF NOT EXISTS `medico` (
  `med_cod` int NOT NULL AUTO_INCREMENT,
  `med_nome` varchar(50) DEFAULT NULL,
  `med_crmv` varchar(30) DEFAULT NULL,
  `med_senha` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`med_cod`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `pro_id` int NOT NULL AUTO_INCREMENT,
  `pro_imagem` varchar(250) DEFAULT NULL,
  `pro_nome` varchar(50) DEFAULT NULL,
  `pro_quantidade` int DEFAULT NULL,
  `pro_preco` float DEFAULT NULL,
  `pro_fornecedor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`pro_id`, `pro_imagem`, `pro_nome`, `pro_quantidade`, `pro_preco`, `pro_fornecedor`) VALUES
(1, 'https://images.unsplash.com/photo-1583512603805-3cc6b41f3edb', 'Ração Premium', 80, 89.9, 'Rações S.A'),
(3, 'https://images.unsplash.com/photo-1601758228041-f3b2795255f1', 'Brinquedo Mordedor', 23, 29.9, 'Brinquedos S.A'),
(4, 'assets/Shampoo.png', 'Shampoo Pet', NULL, 39, NULL),
(6, 'assets/Condicionador.png', 'Condicionador Pet', 29, 29.9, NULL),
(9, 'assets/AntiPulga.png', 'Anti-Pulga', NULL, 19.9, NULL),
(11, 'assets/CamaPet.png', 'Cama Pet', NULL, 59.9, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
