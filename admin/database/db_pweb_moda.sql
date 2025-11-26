-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para moda
CREATE DATABASE IF NOT EXISTS `moda` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `moda`;

-- Copiando estrutura para tabela moda.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `estacao` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela moda.categoria: ~2 rows (aproximadamente)
INSERT INTO `categoria` (`id`, `nome`, `descricao`, `estacao`) VALUES
	(8, 'Vestidos', 'Vestidos casuais, de festa e midi.', 'Primavera'),
	(9, 'Casacos', 'Casacos, jaquetas e trench coats.', 'Inverno'),
	(10, 'Acessórios', 'Bolsas, cintos, joias, óculos de sol.', 'Verão');

-- Copiando estrutura para tabela moda.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `conteudo` text NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `autor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela moda.post: ~3 rows (aproximadamente)
INSERT INTO `post` (`id`, `titulo`, `conteudo`, `imagem`, `autor`) VALUES
	(13, 'Tendências de Moda para o Verão 2025', 'O verão 2025 chega com tons vibrantes, tecidos leves e muito conforto. Peças como vestidos florais, tops com recortes e shorts de cintura alta serão os destaques da estação. As cores mais usadas serão o rosa vibrante, azul oceano e amarelo solar. Aposte em acessórios minimalistas para completar o look.', '1763990992_post.png', 'Julia'),
	(14, 'A Moda Minimalista Está de Volta', 'O estilo minimalista retorna com força para quem gosta de elegância e simplicidade. Peças retas, cores neutras e cortes limpos estão entre as principais apostas. Combinações monocromáticas trazem sofisticação imediata.', '1763991320_post.jpg', 'Gabi'),
	(15, 'Guia de Moda Inverno: Peças-Chave Para o Frio', 'O inverno chega com um mix perfeito entre conforto, estilo e elegância. As peças-chave da estação trazem tecidos mais encorpados, tons neutros e acessórios que elevam qualquer look.', '1763991471_post.webp', 'Equipe');

-- Copiando estrutura para tabela moda.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) DEFAULT NULL,
  `preco` decimal(20,6) DEFAULT NULL,
  `estoque` int DEFAULT NULL,
  `tamanho` varchar(10) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `imagem` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela moda.produtos: ~2 rows (aproximadamente)
INSERT INTO `produtos` (`id`, `nome`, `preco`, `estoque`, `tamanho`, `cor`, `imagem`) VALUES
	(4, 'Calção', 45.900000, 2, 'M', 'Preta', '1763582127_saiapreta.webp'),
	(6, 'Casaco', 199.900000, 3, 'M', 'Amarelo', '1763987429_casaco.jpeg');

-- Copiando estrutura para tabela moda.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela moda.usuario: ~3 rows (aproximadamente)
INSERT INTO `usuario` (`id`, `nome`, `telefone`, `email`, `login`, `senha`) VALUES
	(8, 'Julia Bohrer', '49998115704', 'juliabohrerj@gmail.com', 'admin', '1234'),
	(9, 'Gabi', '499834575', 'gabibarcelos@gmail', 'gabi.0', '123456');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
