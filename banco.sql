-- Rode uma vez no MySQL: cria o banco "app_login" e a tabela de usuários.
CREATE DATABASE IF NOT EXISTS app_login CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE app_login;

CREATE TABLE IF NOT EXISTS usuarios (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome         VARCHAR(120) NOT NULL,
    telefone     VARCHAR(11)  NOT NULL,
    email        VARCHAR(160) NOT NULL UNIQUE,
    senha_hash   VARCHAR(255) NOT NULL,
    criado_em    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuário do banco (só rode se ainda não criou). Com a senha trocada por uma sua, de preferência.
-- Em vez de ALL em *.*, este usuário só precisa de acesso ao banco do app:
CREATE USER IF NOT EXISTS 'kayo'@'localhost' IDENTIFIED BY '1234';
CREATE USER IF NOT EXISTS 'kayo'@'127.0.0.1' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON app_login.* TO 'kayo'@'localhost';
GRANT ALL PRIVILEGES ON app_login.* TO 'kayo'@'127.0.0.1';
FLUSH PRIVILEGES;
