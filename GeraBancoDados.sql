CREATE DATABASE sistema_importacao; -- Criando database
USE sistema_importacao; -- Utilizando database

CREATE TABLE usuario(
usuario_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
usuario_login VARCHAR(200) NOT NULL,
usuario_nome VARCHAR(200) NOT NULL,
usuario_senha VARCHAR(200) NOT NULL,
usuario_imagem VARCHAR(30)
); -- Criando tabela de usuario

SELECT * FROM usuario;
