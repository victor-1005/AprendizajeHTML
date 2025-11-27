CREATE DATABASE Pruebas;
USE Pruebas;
-- ========
-- TABLA USUARIO
-- ======== 
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    edad INT,
    email VARCHAR(100),
    telefono VARCHAR(20)
);
-- ========
-- TABLA ROL
-- ======== 
CREATE TABLE rol(
  idRol INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  contra VARCHAR(250) NOT NULL,
  rol ENUM('administrador','consumidor') NOT NULL DEFAULT 'consumidor',
  idUsuario INT NOT NULL,
  CONSTRAINT fk_Rol_Usuaio FOREIGN  KEY (idUsuario)
  REFERENCES usuarios(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE 
);