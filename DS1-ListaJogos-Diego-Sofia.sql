-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 31-Mar-2023 às 11:29
-- Versão do servidor: 8.0.32-0ubuntu0.22.04.2
-- versão do PHP: 7.3.33-8+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `DS1-ListaJogos-Diego-Sofia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Cartuchos`
--

CREATE TABLE `Cartuchos` (
  `userID` int NOT NULL,
  `gameID` int NOT NULL,
  `titulo` text NOT NULL,
  `sistema` text NOT NULL,
  `ano` year NOT NULL,
  `empresa` text NOT NULL,
  `imgpath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Users`
--

CREATE TABLE `Users` (
  `id` int NOT NULL,
  `username` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `Users`
--

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `Cartuchos`
--
ALTER TABLE `Cartuchos`
  ADD PRIMARY KEY (`userID`,`gameID`),
  ADD KEY `gameID` (`gameID`);

--
-- Índices para tabela `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Cartuchos`
--
ALTER TABLE `Cartuchos`
  MODIFY `gameID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `Cartuchos`
--
ALTER TABLE `Cartuchos`
  ADD CONSTRAINT `Cartuchos_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
