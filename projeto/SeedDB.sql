USE web_loja_de_roupas;

-- -----------------------------
-- Categorias
-- -----------------------------
INSERT INTO categoria (nome) VALUES 
('Camisetas'),
('Calças'),
('Jaquetas'),
('Acessórios'),
('Tênis'),
('Bolsas'),
('Meias'),
('Camisas Sociais'),
('Shorts'),
('Vestidos');

-- -----------------------------
-- Peças
-- -----------------------------
INSERT INTO peca (nome, estoque, Categoria_id_pk) VALUES
('Camiseta Branca', 50, 1),
('Camiseta Preta', 40, 1),
('Camiseta Vermelha', 35, 1),
('Calça Jeans', 60, 2),
('Calça Social Preta', 30, 2),
('Jaqueta Couro', 20, 3),
('Jaqueta Jeans', 25, 3),
('Boné Azul', 50, 4),
('Boné Vermelho', 45, 4),
('Tênis Branco', 40, 5),
('Tênis Preto', 35, 5),
('Bolsa de Couro', 15, 6),
('Bolsa de Tecido', 20, 6),
('Meia Branca', 100, 7),
('Meia Preta', 80, 7),
('Camisa Social Azul', 30, 8),
('Camisa Social Branca', 25, 8),
('Short Jeans', 40, 9),
('Short Esportivo', 50, 9),
('Vestido Preto', 20, 10),
('Vestido Vermelho', 15, 10),
('Camiseta Verde', 30, 1),
('Camiseta Azul', 35, 1),
('Calça Legging', 40, 2),
('Jaqueta Esportiva', 25, 3),
('Boné Preto', 50, 4),
('Tênis Vermelho', 30, 5),
('Bolsa Pequena', 25, 6),
('Meia Colorida', 60, 7),
('Camisa Social Rosa', 20, 8),
('Short Preto', 35, 9),
('Vestido Azul', 10, 10),
('Camiseta Listrada', 30, 1),
('Camiseta Estampada', 35, 1),
('Calça Cargo', 30, 2),
('Calça Moletom', 50, 2),
('Jaqueta com Capuz', 20, 3),
('Boné Listrado', 40, 4),
('Tênis Esportivo', 45, 5),
('Bolsa Média', 20, 6),
('Meia Esportiva', 70, 7),
('Camisa Social Cinza', 15, 8),
('Short Colorido', 25, 9),
('Vestido Floral', 10, 10),
('Camiseta Amarela', 30, 1),
('Calça Branca', 20, 2),
('Jaqueta Vermelha', 15, 3),
('Boné Verde', 25, 4),
('Tênis Azul', 30, 5),
('Bolsa Grande', 10, 6);

-- -----------------------------
-- Usuários
-- -----------------------------
INSERT INTO usuario (email, senha, permissao) VALUES
('admin@loja.com', 'admin123', 'admin'),
('vendedor1@loja.com', 'senha1', 'user'),
('vendedor2@loja.com', 'senha2', 'user'),
('vendedor3@loja.com', 'senha3', 'user'),
('vendedor4@loja.com', 'senha4', 'user'),
('vendedor5@loja.com', 'senha5', 'user'),
('cliente1@loja.com', 'senha6', 'user'),
('cliente2@loja.com', 'senha7', 'user'),
('cliente3@loja.com', 'senha8', 'user'),
('cliente4@loja.com', 'senha9', 'user');

-- -----------------------------
-- Reposições
-- -----------------------------
INSERT INTO reposicao (data_horario) VALUES
('2025-11-21 09:00:00'),
('2025-11-21 10:00:00'),
('2025-11-21 11:00:00'),
('2025-11-21 12:00:00'),
('2025-11-21 13:00:00'),
('2025-11-22 09:00:00'),
('2025-11-22 10:30:00'),
('2025-11-22 11:45:00'),
('2025-11-22 14:00:00'),
('2025-11-22 15:30:00'),
('2025-11-23 09:00:00'),
('2025-11-23 10:30:00'),
('2025-11-23 12:00:00'),
('2025-11-23 13:30:00'),
('2025-11-23 15:00:00'),
('2025-11-24 09:00:00'),
('2025-11-24 10:30:00'),
('2025-11-24 12:00:00'),
('2025-11-24 13:30:00'),
('2025-11-24 15:00:00');

-- -----------------------------
-- Reposição Tem Peça (aleatório)
-- -----------------------------
INSERT INTO reposicao_tem_peca (Reposicao_id_fk_pk, Peca_id_fk_pk, preco, quantidade) VALUES
(1, 1, 50, 20),
(1, 2, 55, 15),
(2, 3, 60, 10),
(2, 4, 200, 5),
(3, 5, 70, 20),
(3, 6, 220, 5),
(4, 7, 180, 10),
(4, 8, 40, 25),
(5, 9, 45, 20),
(5, 10, 250, 10),
(6, 11, 260, 5),
(6, 12, 300, 3),
(7, 13, 100, 10),
(7, 14, 10, 50),
(8, 15, 12, 40),
(8, 16, 120, 10),
(9, 17, 125, 8),
(9, 18, 80, 15),
(10, 19, 60, 20),
(10, 20, 180, 7),
(11, 21, 15, 20),
(11, 22, 15, 15),
(12, 23, 50, 12),
(12, 24, 55, 10),
(13, 25, 40, 15),
(13, 26, 100, 8),
(14, 27, 45, 20),
(14, 28, 200, 5),
(15, 29, 30, 12),
(15, 30, 15, 10),
(16, 31, 25, 12),
(16, 32, 35, 8),
(17, 33, 70, 10),
(17, 34, 75, 5),
(18, 35, 80, 15),
(18, 36, 40, 10),
(19, 37, 120, 5),
(19, 38, 35, 20),
(20, 39, 45, 12),
(20, 40, 60, 10);

-- -----------------------------
-- Vendas
-- -----------------------------
INSERT INTO venda (data_horario) VALUES
('2025-11-21 12:00:00'),
('2025-11-21 12:30:00'),
('2025-11-21 13:00:00'),
('2025-11-21 13:30:00'),
('2025-11-21 14:00:00'),
('2025-11-21 14:30:00'),
('2025-11-21 15:00:00'),
('2025-11-21 15:30:00'),
('2025-11-21 16:00:00'),
('2025-11-21 16:30:00'),
('2025-11-21 17:00:00'),
('2025-11-21 17:30:00'),
('2025-11-21 18:00:00'),
('2025-11-21 18:30:00'),
('2025-11-21 19:00:00'),
('2025-11-21 19:30:00'),
('2025-11-21 20:00:00'),
('2025-11-21 20:30:00'),
('2025-11-21 21:00:00'),
('2025-11-21 21:30:00');

-- -----------------------------
-- Venda Tem Peça (aleatório)
-- -----------------------------
INSERT INTO venda_tem_peca (Venda_id_fk_pk, Peca_id_fk_pk, preco, quantidade) VALUES
(1, 1, 55, 2),
(1, 2, 60, 1),
(2, 3, 65, 1),
(2, 4, 210, 1),
(3, 5, 75, 2),
(3, 6, 230, 1),
(4, 7, 185, 1),
(4, 8, 45, 2),
(5, 9, 50, 1),
(5, 10, 260, 1),
(6, 11, 270, 1),
(6, 12, 310, 1),
(7, 13, 110, 2),
(7, 14, 12, 3),
(8, 15, 15, 2),
(8, 16, 130, 1),
(9, 17, 130, 1),
(9, 18, 85, 1),
(10, 19, 65, 2),
(10, 20, 190, 1);
