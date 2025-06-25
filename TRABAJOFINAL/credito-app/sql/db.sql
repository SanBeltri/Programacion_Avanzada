

CREATE DATABASE IF NOT EXISTS `hipotecario_db`;
USE `hipotecario_db`;

-- Tabla de Usuarios
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('cliente', 'asesor', 'subgerente', 'gerente') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Créditos
CREATE TABLE `loans` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL, -- Cliente que solicita el crédito
    `amount` DECIMAL(15, 2) NOT NULL,
    `term` INT NOT NULL COMMENT 'Plazo en meses',
    `status` ENUM('pending_asesor', 'pending_subgerente', 'pending_gerente', 'approved', 'denied') NOT NULL DEFAULT 'pending_asesor',
    `client_notes` TEXT,     -- Notas del cliente
    `advisor_notes` TEXT,    -- Notas del asesor
    `subgerente_notes` TEXT, -- Notas del subgerente
    `gerente_notes` TEXT,    -- Notas del gerente
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `advisor_id` INT NULL,    -- Asesor que gestiona el crédito
    `subgerente_id` INT NULL, -- Subgerente que revisa
    `gerente_id` INT NULL,    -- Gerente que aprueba/niega
    `document_path` VARCHAR(255) NULL, -- Ruta del documento del crédito
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`advisor_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`subgerente_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`gerente_id`) REFERENCES `users`(`id`)
);

-- Inserta algunos usuarios de ejemplo
-- Las contraseñas son 'password' para todos los usuarios, hasheadas con BCRYPT.
-- Puedes verificar el hash con password_verify('password', $hash_from_db) en PHP.
INSERT INTO `users` (`username`, `password`, `role`) VALUES
('cliente1', '12345', 'cliente'), -- password: password
('asesor1', '12345', 'asesor'),
('subgerente1', '12345', 'subgerente'),
('gerente1', '12345', 'gerente');

