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
-- ========
-- TABLA Vehiculo 
-- ======== 
CREATE TABLE vehiculo(
  idVehiculo INT AUTO_INCREMENT PRIMARY KEY,
  marca VARCHAR(50) NOT NULL,
  modelo VARCHAR(50) NOT NULL,
  tipo VARCHAR(50) NOT NULL,
  anio INT NOT NULL,
  matricula VARCHAR(20) NOT NULL UNIQUE,
  idUsuario INT NOT NULL,
  CONSTRAINT fk_Vehiculo_Usuario FOREIGN  KEY (idUsuario)
  REFERENCES usuarios(id)
  ON DELETE CASCADE
  ON UPDATE CASCADE 
);