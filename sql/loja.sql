-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Abr 06, 2011 as 09:35 
-- Versão do Servidor: 5.1.41
-- Versão do PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `loja`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acesso`
--

CREATE TABLE IF NOT EXISTS `acesso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `endereco` varchar(100) NOT NULL,
  `loja_usuario_grupo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Extraindo dados da tabela `acesso`
--

INSERT INTO `acesso` (`id`, `endereco`, `loja_usuario_grupo`) VALUES
(1, '/categorias/add', 1),
(2, '/categorias/index', 1),
(3, '/loja_ofertas/index', 1),
(4, '/loja_ofertas/add', 1),
(5, '/marcas/index', 1),
(6, '/marcas/add', 1),
(22, '/loja_textos/index', 1),
(25, '/loja_imagem/index', 1),
(28, '/usuarios/index', 1),
(10, '/administracao/index', 1),
(11, '/administracao/index 	', 2),
(12, '/administracao/index 	', 3),
(13, '/loja_ofertas/add', 2),
(14, '/loja_ofertas/edit', 2),
(15, '/loja_ofertas/index', 2),
(16, '/loja_ofertas/index', 1),
(17, '/loja_ofertas/edit', 1),
(18, '/categorias/edit', 1),
(19, '/marcas/add', 2),
(20, '/marcas/edit', 2),
(21, '/marcas/index', 2),
(23, '/loja_textos/add', 1),
(24, '/loja_textos/edit', 1),
(26, '/loja_imagem/add', 1),
(27, '/loja_imagem/edit', 1),
(29, '/usuarios/edit', 1),
(30, '/usuarios/delete', 1),
(31, '/usuarios/add', 1),
(32, '/loja_imagem/delete', 1),
(33, '/marcas/delete', 2),
(34, '/marcas/delete', 1),
(35, '/marcas/edit', 1),
(36, '/marcas/delete', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_busca_ofertas`
--

CREATE TABLE IF NOT EXISTS `loja_busca_ofertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `palavra` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Tabela de arquivamento das palavras pesquisadas' AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `loja_busca_ofertas`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_categorias`
--

CREATE TABLE IF NOT EXISTS `loja_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `descricao` varchar(400) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `children_position` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Extraindo dados da tabela `loja_categorias`
--

INSERT INTO `loja_categorias` (`id`, `nome`, `descricao`, `parent_id`, `children_position`, `ativo`, `created`, `modified`) VALUES
(3, 'Telefonia', 'Telefones, Celulares e Smartfones', 0, NULL, 1, NULL, NULL),
(5, 'Moveis', 'Moveis para escritório', 0, NULL, 1, NULL, NULL),
(6, 'Video Games', 'Console de Video Game, Jogos e etc', 0, NULL, 1, NULL, NULL),
(11, 'Acessórios para Video Game', 'Controle, cabos e diversos', 6, NULL, 1, NULL, NULL),
(27, 'Dormitório', 'Os melhores móveis para seu dormitório', 5, NULL, 1, NULL, NULL),
(29, 'Jogos', 'Os Melhores jogos para seu video game', 6, NULL, 1, NULL, NULL),
(30, 'Acessório para celulares', 'Acessórios para seu telefone ou celular', 3, NULL, 1, NULL, NULL),
(37, 'Smatphones', 'Aparelhos smartphones das melhores marcas', 3, NULL, 1, NULL, NULL),
(38, 'Roupas e Acessórios', 'Roupas das Melores marcas a preço pequenos', 0, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_clientes`
--

CREATE TABLE IF NOT EXISTS `loja_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `primeiro_nome` varchar(100) NOT NULL,
  `sobrenome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `seguro` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `loja_clientes`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_clientes_enderecos`
--

CREATE TABLE IF NOT EXISTS `loja_clientes_enderecos` (
  `loja_cliente_id` int(11) NOT NULL,
  `loja_tipo_endereco_id` int(11) NOT NULL,
  `rua` varchar(300) NOT NULL,
  `numero` int(11) NOT NULL,
  `loja_cidade_id` varchar(100) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `cep` int(8) NOT NULL,
  KEY `loja_cliente_id` (`loja_cliente_id`),
  KEY `loja_tipo_endereco_id` (`loja_tipo_endereco_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_clientes_enderecos`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_configuracoes`
--

CREATE TABLE IF NOT EXISTS `loja_configuracoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identificador` varchar(100) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `valor` varchar(30) NOT NULL,
  `publico` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `loja_configuracoes`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_imagens`
--

CREATE TABLE IF NOT EXISTS `loja_imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `local` varchar(200) NOT NULL,
  `imagem` varchar(5) DEFAULT NULL,
  `altura` int(11) DEFAULT NULL,
  `largura` int(11) DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `loja_imagens`
--

INSERT INTO `loja_imagens` (`id`, `local`, `imagem`, `altura`, `largura`, `descricao`, `ativo`) VALUES
(1, 'Logotipo Principal', 'jpeg', 200, 400, 'Cadastro de imagem que será utilizada como logotípo da sua loja.', 1),
(2, 'Rodapé Cartão', NULL, 200, 500, 'Imagem com os meios de pagamento aceito pela sua loja.', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_marcas`
--

CREATE TABLE IF NOT EXISTS `loja_marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(5) DEFAULT NULL,
  `site` varchar(200) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `loja_marcas`
--

INSERT INTO `loja_marcas` (`id`, `nome`, `imagem`, `site`, `ativo`, `created`, `modified`) VALUES
(1, 'Lilica Repilica', 'png', 'http://www.lilicaripilica.com.br', 1, NULL, NULL),
(2, 'Arezo', 'gif', 'http://www.arezzo.com.br/prefall/#/pt-br/home', 1, NULL, NULL),
(3, 'Malwee', 'jpeg', 'http://www.malwee.com.br/colecao/', 1, NULL, NULL),
(4, 'TNG', NULL, 'http://www.tng.com.br/site/', 1, NULL, NULL),
(12, 'Diesel Jeans', 'png', 'http://www.diesel.com/', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_meio_pagamentos`
--

CREATE TABLE IF NOT EXISTS `loja_meio_pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `codigo` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `loja_meio_pagamentos`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_oferta`
--

CREATE TABLE IF NOT EXISTS `loja_oferta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `descricao_longa` varchar(1000) DEFAULT NULL,
  `tags` varchar(200) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `loja_categoria_id` int(11) NOT NULL,
  `loja_marca_id` int(11) DEFAULT NULL,
  `preço` float(10,2) NOT NULL,
  `parcela` int(11) DEFAULT NULL,
  `juros` int(3) NOT NULL,
  `desconto` int(3) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loja_categoria_id` (`loja_categoria_id`),
  KEY `loja_marca_id` (`loja_marca_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Extraindo dados da tabela `loja_oferta`
--

INSERT INTO `loja_oferta` (`id`, `titulo`, `descricao`, `descricao_longa`, `tags`, `quantidade`, `loja_categoria_id`, `loja_marca_id`, `preço`, `parcela`, `juros`, `desconto`, `ativo`, `created`, `modified`) VALUES
(69, 'Calça Jeans Malhada', 'Roupas das Melores marcas a preço pequenos', '<p>\r\n	descricao longa</p>\r\n', 'metas tags', 10, 38, 4, 90.00, 1, 1, 1, 1, '2011-04-03', '2011-04-05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_oferta_imagens`
--

CREATE TABLE IF NOT EXISTS `loja_oferta_imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagem` varchar(5) NOT NULL,
  `loja_oferta_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `loja_oferta_id` (`loja_oferta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `loja_oferta_imagens`
--

INSERT INTO `loja_oferta_imagens` (`id`, `imagem`, `loja_oferta_id`) VALUES
(4, 'jpeg', 69);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_pedidos`
--

CREATE TABLE IF NOT EXISTS `loja_pedidos` (
  `id` int(11) NOT NULL,
  `loja_oferta_id` int(11) NOT NULL,
  `loja_cliente_id` int(11) NOT NULL,
  `loja_meio_pagamento_id` int(11) NOT NULL,
  `data_pedido` int(11) NOT NULL,
  `loja_status_id` int(11) NOT NULL,
  `loja_visita_id` int(11) DEFAULT NULL,
  KEY `loja_oferta_id` (`loja_oferta_id`),
  KEY `loja_meio_pagamento_id` (`loja_meio_pagamento_id`),
  KEY `loja_status_id` (`loja_status_id`),
  KEY `loja_cliente_id` (`loja_cliente_id`),
  KEY `loja_visita_id` (`loja_visita_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `loja_pedidos`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_status`
--

CREATE TABLE IF NOT EXISTS `loja_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `img` varchar(5) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `loja_status`
--

INSERT INTO `loja_status` (`id`, `titulo`, `descricao`, `img`, `ativo`) VALUES
(1, 'Pagamento em análise', 'Estamos esperando a confirmação do seu pagamento pela instituição financeira', '0', 1),
(2, 'Aguardo compensação', 'Estamos aguardando a compensação do seu Deposito ou Transferência', '0', 1),
(3, 'Encaminhado para o setor de estoque / despacho', 'Seu produto foi encaminhado para o setor de estoque, onde será separado seu produto e enviado. ', '0', 1),
(4, 'Encaminhado a Transportadora', 'Seu pedido foi encaminhado para a transportado, verifique os dado de remessa em sua guia de pedidos.', '', 1),
(5, 'Entregue', 'Seu produto foi entrege.', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_textos`
--

CREATE TABLE IF NOT EXISTS `loja_textos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `local` varchar(200) NOT NULL,
  `texto` varchar(3000) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `loja_textos`
--

INSERT INTO `loja_textos` (`id`, `local`, `texto`, `ativo`) VALUES
(1, 'Normas de Troca', '', 1),
(2, 'Prazo de entrega', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_tipo_endereco`
--

CREATE TABLE IF NOT EXISTS `loja_tipo_endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(40) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `loja_tipo_endereco`
--

INSERT INTO `loja_tipo_endereco` (`id`, `titulo`, `ativo`) VALUES
(1, 'Cobrança', 1),
(2, 'Entrega', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_usuarios`
--

CREATE TABLE IF NOT EXISTS `loja_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loja_grupo_id` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `nome_completo` varchar(200) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `loja_grupo_id` (`loja_grupo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `loja_usuarios`
--

INSERT INTO `loja_usuarios` (`id`, `loja_grupo_id`, `usuario`, `nome_completo`, `senha`, `ativo`) VALUES
(1, 3, 'renato', 'José Renato Beltrani', '1234', 1),
(2, 1, 'honjoya', 'Henrique Honjoya', '1234', 1),
(3, 2, 'adilan', 'Adilan Chicarolli', '1234', 1),
(5, 2, 'mazinha', 'Mariana Magni Bueno', '123', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_usuario_grupos`
--

CREATE TABLE IF NOT EXISTS `loja_usuario_grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(20) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `loja_usuario_grupos`
--

INSERT INTO `loja_usuario_grupos` (`id`, `grupo`, `ativo`) VALUES
(1, 'administrador', 1),
(2, 'manager', 1),
(3, 'user', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `loja_visitas`
--

CREATE TABLE IF NOT EXISTS `loja_visitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `loja_visitas`
--


--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `loja_clientes_enderecos`
--
ALTER TABLE `loja_clientes_enderecos`
  ADD CONSTRAINT `loja_clientes_enderecos_fk` FOREIGN KEY (`loja_cliente_id`) REFERENCES `loja_clientes` (`id`),
  ADD CONSTRAINT `loja_clientes_enderecos_fk1` FOREIGN KEY (`loja_tipo_endereco_id`) REFERENCES `loja_tipo_endereco` (`id`);

--
-- Restrições para a tabela `loja_oferta`
--
ALTER TABLE `loja_oferta`
  ADD CONSTRAINT `loja_oferta_fk` FOREIGN KEY (`loja_categoria_id`) REFERENCES `loja_categorias` (`id`),
  ADD CONSTRAINT `loja_oferta_fk1` FOREIGN KEY (`loja_marca_id`) REFERENCES `loja_marcas` (`id`);

--
-- Restrições para a tabela `loja_oferta_imagens`
--
ALTER TABLE `loja_oferta_imagens`
  ADD CONSTRAINT `loja_oferta_imagens_ibfk_1` FOREIGN KEY (`loja_oferta_id`) REFERENCES `loja_oferta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loja_oferta_imagens_ibfk_2` FOREIGN KEY (`loja_oferta_id`) REFERENCES `loja_oferta` (`id`) ON DELETE CASCADE;

--
-- Restrições para a tabela `loja_pedidos`
--
ALTER TABLE `loja_pedidos`
  ADD CONSTRAINT `loja_pedidos_fk` FOREIGN KEY (`loja_oferta_id`) REFERENCES `loja_oferta` (`id`),
  ADD CONSTRAINT `loja_pedidos_fk1` FOREIGN KEY (`loja_meio_pagamento_id`) REFERENCES `loja_meio_pagamentos` (`id`),
  ADD CONSTRAINT `loja_pedidos_fk2` FOREIGN KEY (`loja_status_id`) REFERENCES `loja_status` (`id`),
  ADD CONSTRAINT `loja_pedidos_fk3` FOREIGN KEY (`loja_cliente_id`) REFERENCES `loja_clientes` (`id`),
  ADD CONSTRAINT `loja_pedidos_fk4` FOREIGN KEY (`loja_visita_id`) REFERENCES `loja_visitas` (`id`);

--
-- Restrições para a tabela `loja_usuarios`
--
ALTER TABLE `loja_usuarios`
  ADD CONSTRAINT `loja_usuarios_fk` FOREIGN KEY (`loja_grupo_id`) REFERENCES `loja_usuario_grupos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
