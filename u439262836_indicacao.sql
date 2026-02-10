-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 10/02/2026 às 11:54
-- Versão do servidor: 11.8.3-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u439262836_indicacao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `imoveis`
--

CREATE TABLE `imoveis` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `nome_proprietario` varchar(191) NOT NULL,
  `contato_proprietario` varchar(191) NOT NULL,
  `endereco_imovel` varchar(191) NOT NULL,
  `status` varchar(100) DEFAULT 'Indicado',
  `data_indicacao` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `imoveis`
--

INSERT INTO `imoveis` (`id`, `id_usuario`, `tipo`, `nome_proprietario`, `contato_proprietario`, `endereco_imovel`, `status`, `data_indicacao`) VALUES
(9, 6, 'Locação', 'Princesa Stanescos', '21 99254-0780', 'Rua Barão de Ipanema, 37 - Ap 201 - Copacabana.', 'Em contato', '2025-12-22 18:46:35'),
(10, 9, 'Locação', 'Luana', '21 97035-6024', 'Rua do Catete, 311- Sala 1219 ', 'Imóvel alugado', '2025-12-30 19:44:15'),
(11, 9, 'Locação', 'Sonia, Bernardo e Felipe', 'sonia.beatriz.1945@gmail.com;\nfelipe.goulart@itamaraty.gov.br;\nbhgoulart@hotmail.com', 'Rua Barão da Torre,472- Loja- Ipanema\r\n', 'Imóvel alugado', '2025-12-30 19:47:13'),
(12, 9, 'Locação', 'Jeane Baltar', '21 99755-8088', 'Av. Lucio Costa, 6250- Apto 601- Barra da Tijuca', 'Imóvel captado', '2025-12-30 19:49:54'),
(13, 14, 'Locação', 'Eduarda', '21 98881-1023', 'Rua: Voluntários da Pátria, 54 (condomínio Mazzarino)- cobertura 06', 'Imóvel alugado', '2026-01-14 13:02:15'),
(14, 15, 'Locação', 'Marcia Pires', '+55 61 9644-1971', 'Estrada do Cafunda 1757 apto 711 ', 'Imóvel captado', '2026-01-14 13:18:09'),
(15, 16, 'Locação', 'Daniel', '21 98296-6712', 'Rua Riachuelo, 201 - Apto. 505 - Centro', 'Imóvel captado', '2026-01-21 12:14:16'),
(16, 17, 'Locação', 'Jane', '24999151633', 'Rua das Laranjeiras, 32/303', 'Em contato', '2026-01-23 20:22:39'),
(17, 17, 'Locação', 'Denis', '21965689752', 'Rua Amoroso Lima,100 ap.506- Cidade Nova', 'Imóvel captado', '2026-01-27 11:52:08'),
(24, 17, 'Venda', 'Denis', '2196568-9752', 'Rua Amoroso Lima, 100/506', 'Imóvel captado', '2026-01-27 19:48:14'),
(25, 19, 'Venda', 'sem nome ', '21999852521', 'Rua Toneleiro - Copacabana', 'Não captado', '2026-01-28 13:47:52'),
(26, 19, 'Locação', 'maria jose', '21970037544', 'r. do resende 198 kit 506', 'Imóvel captado', '2026-01-28 14:07:41'),
(27, 20, 'Locação', 'Anna Maria Tavares', '55 21 99203-4935', 'Niemayer, 805 - ap 702', 'Imóvel alugado', '2026-01-28 18:27:41'),
(28, 21, 'Locação', 'Maria Isabel da Silva Bentine', '(+1) 5613717525', 'Rua Figueiredo Magalhães, nº 236 - Apto. 504', 'Em negociação', '2026-01-28 19:03:14'),
(29, 21, 'Locação', 'Gláucia', ' (65) 9982-6249', 'Rua Barata Ribeiro, 496 - Apto. 202', 'Em contato', '2026-01-28 20:45:06'),
(30, 16, 'Locação', 'Rosângela', '21 97134-9763', 'Rua Buarque de Macedo, 61 - Flamengo', 'Em contato', '2026-01-29 14:10:50'),
(31, 16, 'Venda', 'Sandra', '24 98822-4369', 'Rua Hermenegildo de Barros, 08 - Apto. 612 - Santa Teresa.\r\n', 'Indicado', '2026-02-03 17:36:54'),
(32, 16, 'Venda', 'Ivan', '(21)98228-3435', 'Av. Nilo Peçanha, 50 - Sala 1602.', 'Indicado', '2026-02-03 17:39:54'),
(33, 16, 'Locação', 'Luiz Alberto', '21 99644-6195', 'Av. Rio Branco, 255 - SALAS', 'Em contato', '2026-02-03 17:41:14'),
(34, 14, 'Locação', 'VINICIUS NOEL DA SILVA DE OLIVEIRA', '21986662291', 'VOLUNTARIOS DA PATRIA, 54 - Cobertura 05\r\nCondomínio Mazzarino', 'Em negociação', '2026-02-04 14:56:41'),
(35, 22, 'Locação', 'Bruna Segal N da Silva', '21 9 8323-2151', 'Rua Visconde de Santa Isabel número 625 apt 502 bloco 02 - Grajau', 'Imóvel captado', '2026-02-04 15:44:48'),
(36, 6, 'Locação', 'LUIZA HELENA PAIXÃO DO NASCIMENTO', '21 98530-1394', 'Praia do Flamengo, 12 AP 810. Cond. Rio Carioca. Cliente informou que tem interesse em alugar depois do carnaval.', 'Em contato', '2026-02-04 15:53:59'),
(37, 23, 'Locação', 'Sr. Aroldo', '(21) 99439-1115', 'Rua Galvani 53/ apto 503 - Vila da Penha', 'Em contato', '2026-02-04 19:55:42'),
(38, 17, 'Venda', 'CLAUDIO REIS FERREIRA', '(35)9805-9937', 'Rua Silva Castro,22/ cobertura 01', 'Em contato', '2026-02-05 18:17:50'),
(39, 17, 'Locação', 'Adriano', '21995004000', 'Rua Vieira Souto.', 'Em contato', '2026-02-06 12:40:55'),
(40, 17, 'Venda', 'Gustavo', '21993974435', 'Rua Treze de Maio', 'Indicado', '2026-02-06 15:48:48'),
(41, 14, 'Venda', 'PATRICIA LEITE DE CASTRO', '2125372072', 'CONDOMINIO DO EDIFICIO BLUE POINT\r\nJOSE CARLOS NOGUEIRA DINIZ, 35\r\nRECREIO', 'Indicado', '2026-02-09 12:55:19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(191) NOT NULL,
  `departamento` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `senha` varchar(191) NOT NULL,
  `nivel` varchar(50) NOT NULL,
  `reset_token` varchar(191) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `departamento`, `email`, `senha`, `nivel`, `reset_token`, `reset_expires`, `data_cadastro`) VALUES
(1, 'Carlos Eduardo de Farias Candido', 'Contas a Pagar', 'carlos@aciradm.com.br', '$2y$10$X78QlFRtZrBz90j9ywHo7.joMV3qn4aQUOWmEgr4/zo8ZdoyoVkca', 'Administrador', NULL, NULL, '2025-12-17 14:52:40'),
(2, 'Teste', 'Contas a Pagar', 'teste@teste.com', '$2y$10$BTXwwfST6NQKbGqOdKIwIe3dJgo6iae9TxotU7jCZk0QprUUJ2N42', 'Usuario', NULL, NULL, '2025-12-17 14:54:51'),
(3, 'Adriana Martins dos Santos', 'Locação', 'adriana-loc@aciradm.com.br', '$2y$10$yvJ.ie/ALC.FPVS9TmJCKexU1dqEeBQY.i3WizuWmvH6cjRj10v4q', 'Administrador', NULL, NULL, '2025-12-17 15:07:28'),
(4, 'Evanise Turteltaub', 'Contas a Pagar', 'evanise@aciradm.com.br', '$2y$10$/FTUxZ7Bd6EtDBQKctoZ2.0JyENnl/2WZTxwGuxRuxK3Ghcf6LbSG', 'Administrador', NULL, NULL, '2025-12-17 15:15:38'),
(5, 'Alexsandre Pereira dos Santos Junior', 'Contas a Pagar', 'alexsandre@aciradm.com.br', '$2y$10$sYCubUBE722SJ2GFxXy2pOquG.EGnzhy8DHrfT3mN6ng8uBOOmqbe', 'Administrador', NULL, NULL, '2025-12-17 20:17:16'),
(6, 'Rafaela Karine Soares Lourenço', 'Condomínios', 'suporte-filial@aciradm.com.br', '$2y$10$HfEazM89kEhGGply9IFPXO4/WyyBjQmRNE81Ex21nedLOueTDp1Dm', 'Usuario', NULL, NULL, '2025-12-22 18:40:46'),
(7, 'Thais Campos', 'RH', 'thaisrecrutamento.acir@gmail.com', '$2y$10$xc3UsVsRhOvpMyNXLKO78eQBGKOGpn2oHuHhTKglym9Iy9ULvfzSK', 'Usuario', NULL, NULL, '2025-12-23 13:39:14'),
(8, 'Genilson', 'TI', 'ti@aciradm.com.br', '$2y$10$LbbLvoqQViTzzaEh4EVKUuR..WWoKr9DvHfu1N7yfRrwtqg0a8XhC', 'Usuario', NULL, NULL, '2025-12-23 19:31:32'),
(9, 'Cristiane Mendes', 'Locação', 'cristiane-loc@aciradm.com.br', '$2y$10$AHZLctDV1YN2KXTfoTl93eF8wVN9BIxDeUWoUOAmP1i.KJ6oeyTDG', 'Usuario', NULL, NULL, '2025-12-30 19:43:00'),
(10, 'Acácio Andrade', 'Locação', 'acacio.andrade@aciradm.com.br', '$2y$10$wxhIxXJSDWqL0fuxglY80uwOsXtMvd9RxnLFQ5K6lf5Yqex2Ah.ga', 'Administrador', NULL, NULL, '2025-12-30 19:57:09'),
(11, 'Julia Moreira de Oliveira ', 'Locação', 'julia-loc@aciradm.com.br', '$2y$10$G8EXfo9ih8uNPPNVRnSKyurES7VXIBeXtKs4sN0cscWh/s98nFYP.', 'Administrador', NULL, NULL, '2026-01-02 17:23:50'),
(14, 'Diana', 'Comercial', 'dianakeli@aciradm.com.br', '$2y$10$RR/NIms7YhD6BvnRm32yi.ZHXNuvRHIwy4Qt9EbCqHedplkAdvASC', 'Usuario', NULL, NULL, '2026-01-14 13:00:50'),
(15, 'Gabriel Assis De Moraes', 'Comercial', 'gabriel-loc@aciradm.com.br', '$2y$10$NgLBqxJwAOjOFSQ2k9LxrO2jv9eU8iyxJM.l8RFBUwSlu7NKOvx/e', 'Usuario', NULL, NULL, '2026-01-14 13:16:54'),
(16, 'Amanda da Conceição Vasconcellos', 'Locação', 'amanda-loc@aciradm.com.br', '$2y$10$gOITz5BMsk9KICLJxHWqguXkLE.wg2JIvJWtGDiROBdhrkjBSouvy', 'Usuario', NULL, NULL, '2026-01-21 12:08:16'),
(17, 'Diana Santos', 'Locação', 'diana-loc@aciradm.com.br', '$2y$10$ox5whdynvTgvlKOn.SpEPeizxj.5kAON2fKJD20HRrCCw.F4Ocrry', 'Usuario', NULL, NULL, '2026-01-23 20:21:24'),
(18, 'Joao', 'Contas a Pagar', 'joao-loc@aciradm.com.br', '$2y$10$0PGOjN.LjDWsAOrIVG9Cyu9NRoHWt0aPmIsZAFkYcCH5DrsjtLtda', 'Administrador', NULL, NULL, '2026-01-27 19:43:06'),
(19, 'Roberto', 'Locação', 'roberto-loc@aciradm.com.br', '$2y$10$/Xi.utZTgIEXzgjJRBei3eqxSG6jHEkHuIJhwYsbyz7SSX0MMHrpi', 'Usuario', NULL, NULL, '2026-01-28 13:44:46'),
(20, 'Aline', 'Condomínios', 'aline@aciradm.com.br', '$2y$10$Vwua/yRdW5sHG3DSSgGy..ToXDnn8fiU2XDDpfkBK.Uqe3sJCiHeK', 'Usuario', NULL, NULL, '2026-01-28 18:25:25'),
(21, 'Ericson Ferraz', 'Condomínios', 'ericson@aciradm.com.br', '$2y$10$NOsh/4KMygJIb0pCFkD.6OhXpMIZOZffaSPTmOgYSXfconlOTrLqu', 'Usuario', NULL, NULL, '2026-01-28 19:00:22'),
(22, 'Maicon Alves Pereira ', 'Locação', 'maicon-loc@aciradm.com.br', '$2y$10$tXpFwu4Wfp9S4lfoU/3jg.4I9Zm/M5LEokOdMMzsl75vob4XbQvhW', 'Usuario', NULL, NULL, '2026-02-04 15:42:55'),
(23, 'Isabel Cristina Pinto', 'Locação', 'locacao@aciradm.com.br', '$2y$10$TvZoeuglmHthBjqiSUBF1e6qJcTXbWu7CDQf3/ERQ3xfK4O.6gAb.', 'Usuario', NULL, NULL, '2026-02-04 19:54:26');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `imoveis`
--
ALTER TABLE `imoveis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `endereco_imovel` (`endereco_imovel`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `imoveis`
--
ALTER TABLE `imoveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `imoveis`
--
ALTER TABLE `imoveis`
  ADD CONSTRAINT `imoveis_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
