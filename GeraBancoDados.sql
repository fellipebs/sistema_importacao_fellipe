CREATE DATABASE sistema_importacao; -- Criando database
USE sistema_importacao; -- Utilizando database

CREATE TABLE usuario(
usuario_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
usuario_login VARCHAR(200) NOT NULL,
usuario_nome VARCHAR(200) NOT NULL,
usuario_senha VARCHAR(200) NOT NULL,
usuario_imagem VARCHAR(30)
); -- Criando tabela de usuario


CREATE TABLE produto(
produto_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
produto_ean INT(20) NOT NULL UNIQUE,
produto_nome VARCHAR(200) NOT NULL,
produto_preco DOUBLE(9,2) NOT NULL,
produto_estoque DOUBLE(9,2) NOT NULL,
produto_data_fabricacao DATE
);


DELETE FROM produto;

SELECT * FROM produto